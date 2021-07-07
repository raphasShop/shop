<?php
    /**
     * ASK SEO
     * RSS 2.0
     * 유료프로그램입니다.
     * 불법복제시 불이익을 받을 수 있습니다.
     */
    include_once "./_common.php";
    include_once G5_LIB_PATH . '/thumbnail.lib.php';
    require_once G5_PLUGIN_PATH . "/ask-cache/autoload.php";
    use phpFastCache\CacheManager;
    //캐시설정
    CacheManager::setup(array(
        "path" => G5_DATA_PATH . '/tmp', //저장위치
    ));
    CacheManager::CachingMethod("phpfastcache");
    $InstanceCache = CacheManager::Files();

    //캐시 키값
    $cache_key    = "asktools_rssfeed_" . $config['as_feed_type'] . $config['as_feed_target'] . $config['as_feed_rows'];
    $CachedString = $InstanceCache->get($cache_key);

    //파일캐시 저장 시간(초)
    $ttl = '600';
    if (!function_exists(specialchars_replace)) {
        // 특수문자 변환
        function specialchars_replace($str, $len = 0)
        {
            if ($len) {
                $str = substr($str, 0, $len);
            }

            $str = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $str);

            /*
            $str = preg_replace("/&/", "&amp;", $str);
            $str = preg_replace("/</", "&lt;", $str);
            $str = preg_replace("/>/", "&gt;", $str);
             */

            return $str;
        }
    }

    ################
    # 파일 캐시처리 #
    ################
    if (is_null($CachedString)) {

        $tags = new AskSEO;

        ########################
        # 새글 목록에서 가져온다 #
        ########################
        if ($config['as_feed_target'] == 'new_table') {
            $sql_common  = " from {$g5['board_new_table']} a, {$g5['board_table']} b where a.bo_table = b.bo_table and  b.bo_use_search = 1  and a.wr_id = a.wr_parent order by a.bn_id desc ";
            $sql         = " select count(*) as cnt {$sql_common} ";
            $row         = sql_fetch($sql);
            $total_count = $row['cnt'];
            $rows        = $config['as_feed_rows'];
            $total_page  = ceil($total_count / $rows); // 전체 페이지 계산
            if ($page < 1) {
                $page = 1;
            }
            // 페이지가 없으면 첫 페이지 (1 페이지)
            $from_record = ($page - 1) * $rows; // 시작 열을 구함

            $sql    = " select a.*, b.bo_subject {$sql_common} {$sql_order} limit {$from_record}, {$rows} ";
            $list   = array();
            $result = sql_query($sql);
            for ($i = 0; $row = sql_fetch_array($result); $i++) {
                //원글만 출력한다.
                $list[$i]                  = $tags->get_view($row['bo_table'], $row['wr_id']);
                $list[$i]['0']['file']     = get_file($row['bo_table'], $row['wr_id']);
                $list[$i]['0']['bo_table'] = $row['bo_table'];
            }

            //배열 정리
            foreach ($list as $key => $val) {
                $rss[] = $val['0'];
            }
        } elseif ($config['as_feed_target'] == 'all_board') {
            #########################
            # 게시판전체에서 가져온다 #
            #########################
            $query  = "select * from {$g5['board_table']} where bo_use_search = 1 order by bo_order asc";
            $result = sql_query($query);
            $list   = array();
            $j      = 0;
            for ($a = 0; $rows = sql_fetch_array($result); $a++) {
                //개별 게시판 가져오기
                $sql     = "select * from {$g5['write_prefix']}{$rows['bo_table']} where wr_is_comment = 0 order by wr_num asc limit 10";
                $result2 = sql_query($sql);
                for ($i = 0; $row2 = sql_fetch_array($result2); $i++) {
                    //원글만 출력한다.
                    $list[$j]             = $row2;
                    $list[$j]['file']     = get_file($rows['bo_table'], $row2['wr_id']);
                    $list[$j]['bo_table'] = $rows['bo_table'];
                    $j++;
                }
                $j++;
            }
            $rss = $list;
            //배열 정렬하기 및 배열 페이징
        }
        //파일캐시에 저장
        $InstanceCache->set($cache_key, $rss, $ttl);
        //var_dump($rss);

    } else {
        #############################
        # 저장된 파일 캐시에서 불러옴 #
        #############################
        $rss = $CachedString;
        //var_dump($rss);
    }

    $item  = '';
    $entry = '';
    foreach ($rss as $key => $val) {
        //비밀글이면 패스
        if (strstr($val['wr_option'], 'secret')) {
            continue;
        }
        //카테고리
        if ($val['ca_name']) {
            $category = "<category><![CDATA[" . $val['ca_name'] . "]]></category>";
        }
        if (strstr($val['wr_option'], 'html')) {
            $html = 1;
        } else {
            $html = 0;
        }

        //본문썸네일
        $val['wr_content'] = get_view_thumbnail($val['wr_content'], 800);
        //인라인 스타일시트 제거
        $val['wr_content'] = preg_replace('/(<[^>]*) style=("[^"]+"|\'[^\']+\')([^>]*>)/i', '$1$3', $val['wr_content']);
        //$val['wr_content'] = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', $val['wr_content']);

        $media_image         = '';
        $media_video_content = '' . PHP_EOL;
        $media_mp3_content   = '' . PHP_EOL;
        $media_video_count   = 0;
        //첨부파일썸네일
        if ($val['file']['count'] > 0) {
            for ($i = 0; $val['file']['count'] > $i; $i++) {
                //이미지 체크
                $ext = array_pop(explode('.', $val['file'][$i]['file']));
                ################
                # 이미지 확장자 #
                ################
                if (stristr('jpg,jpeg,gif,png', $ext)) {
                    $save_path = G5_DATA_PATH . '/file/' . $val['bo_table'];
                    $thumb     = thumbnail($val['file'][$i]['file'], $save_path, $save_path, 800, 600, false, true);
                    $media_image .= "<div class='rss-images'><img src='" . G5_DATA_URL . "/file/{$val['bo_table']}/{$thumb}'/></div>";
                }
                ################
                # 동영상 확장자 #
                ################
                if (stristr('mp4,avi,webm,wmv', $ext)) {
                    $media_video_count++;
                    $save_movie_path = G5_DATA_URL . '/file/' . $val['bo_table'] . '/' . $val['file'][$i]['file'];
                    $media_video_content .= "<media:content url=\"{$save_movie_path}\" medium=\"video\">
                <media:title>동영상</media:title>
                <media:description><![CDATA[동영상]]></media:description>
                <media:credit role=\"author\" scheme=\"urn:ebu\"><![CDATA[{$val['wr_name']}]]></media:credit>
                </media:content>" . PHP_EOL;
                }
                ###############
                # Mp3 확장자  #
                ###############
                if (stristr('mp3,ogg', $ext)) {
                    $media_video_count++;
                    $save_mp3_path = G5_DATA_URL . '/file/' . $val['bo_table'] . '/' . $val['file'][$i]['file'];
                    $media_mp3_content .= "<media:content url=\"{$save_mp3_path}\" medium=\"audio\">
                <media:title>MP3 오디오</media:title>
                <media:description><![CDATA[MP3 오디오]]></media:description>
                <media:credit role=\"author\" scheme=\"urn:ebu\"><![CDATA[{$val['wr_name']}]]></media:credit>
                </media:content>" . PHP_EOL;
                }
            }
        }

        if ($media_video_count == 0) {
            $media_video_content = '';
        } else if ($media_video_count == 1) {
            $media_video .= $media_video_content;
        } else if ($media_video_count > 1) {
            $media_video .= $media_video_content;
        }

        if(!$val['wr_email']){
            $val['wr_email'] = $config['cf_admin_email'];
        }
        //RSS 용
        $item .= "
            <item>
                <author>{$val['wr_email']}(" . specialchars_replace($val['wr_name']) . ")</author>
                {$category}
                <title><![CDATA[" . specialchars_replace($val['wr_subject']) . "]]></title>
                <link>" . specialchars_replace(G5_BBS_URL . "/board.php?bo_table={$val['bo_table']}&wr_id={$val['wr_id']}") . "</link>
                <guid>" . specialchars_replace(G5_BBS_URL . "/board.php?bo_table={$val['bo_table']}&wr_id={$val['wr_id']}") . "</guid>
                <description><![CDATA[" . $media_image . $val['wr_content'] . "]]></description>
                {$media_video}
                {$media_mp3_content}
                <pubDate>" . date('r', strtotime($val['wr_datetime'])) . "</pubDate>
            </item>";

        //ATOM 용
        $entry .= "
            <entry>
                <id>" . specialchars_replace(G5_BBS_URL . "/board.php?bo_table={$val['bo_table']}&wr_id={$val['wr_id']}") . "</id>
                <published>" . date('Y-m-d\TH:i:sP', strtotime($val['wr_datetime'])) . "</published>
                <updated>" . date('Y-m-d\TH:i:sP', strtotime($val['wr_datetime'])) . "</updated>
                <title type=\"text\">" . specialchars_replace($val['wr_subject']) . "</title>
                <content type=\"html\"><![CDATA[" . $media_image . $val['wr_content'] . "]]></content>
                <link rel=\"alternate\" type=\"text/html\" href=\"" . specialchars_replace(G5_BBS_URL . "/board.php?bo_table={$val['bo_table']}&wr_id={$val['wr_id']}") . "\" title=\"" . specialchars_replace($val['wr_subject']) . "\" />
                {$media_video}
                {$media_mp3_content}
                <author>
                    <name>서기진</name>
                    <uri>" . specialchars_replace(G5_BBS_URL . "/board.php?bo_table={$val['bo_table']}&wr_id={$val['wr_id']}") . "</uri>
                    <email>{$val['wr_email']}</email>
                </author>
                <thr:total>0</thr:total>
            </entry>";
    }

    //해더 설정
    //header("content-type: application/atom+xml");
    header('Content-type: text/xml');
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
?>
<?php if ($config['as_feed_type'] == 'rss') {?>
<?php echo '<?xml-stylesheet type="text/css" href="' . G5_PLUGIN_URL . '/ask-seo/as_rss.css" ?>' . PHP_EOL; ?>
<rss version="2.0" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:taxo="http://purl.org/rss/1.0/modules/taxonomy/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/">
    <channel>
        <title><![CDATA[<?php echo $config['cf_title'] ?>]]></title>
        <link><?php echo G5_URL ?></link>
        <atom:link href="<?php echo G5_URL . '/as_rss.php'; ?>" rel="self" type="application/rss+xml" />
        <?php if ($config['as_logo']) {?>
        <image>
            <url><![CDATA[<?php echo G5_DATA_URL . '/aslogo/' . $config['as_logo']; ?>]]></url>
            <title><![CDATA[<?php echo $config['cf_title'] ?>]]></title>
            <link><?php echo G5_URL ?></link>
        </image>
        <?php }?>
        <description><![CDATA[<?php echo $config['as_description']; ?>]]></description>
        <language>ko</language>
        <generator>ASK SEO Generator</generator>
        <pubDate><?php echo date('r', time()); ?></pubDate>
        <?php echo $item ?>
    </channel>
</rss>
<?php } elseif ($config['as_feed_type'] == 'atom') {?>
<?php echo '<?xml-stylesheet type="text/css" href="' . G5_PLUGIN_URL . '/ask-seo/as_atom.css" ?>' . PHP_EOL; ?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:openSearch="http://a9.com/-/spec/opensearchrss/1.0/"  xmlns:georss="http://www.georss.org/georss" xmlns:thr="http://purl.org/syndication/thread/1.0" xmlns:media="http://search.yahoo.com/mrss/">
    <id><?php echo G5_URL . '/'; ?></id>
    <link rel="self" type="application/atom+xml" href="<?php echo G5_URL . '/as_rss.php'; ?>" />
    <updated><?php echo date('Y-m-d\TH:i:sP', time()); ?></updated>
    <title type="text"><?php echo $config['cf_title'] ?></title>
    <subtitle type="html"><?php echo $config['as_description']; ?></subtitle>
    <author>
        <name><?php echo $config['cf_admin'] ?></name>
        <email><?php echo $config['cf_admin_email'] ?></email>
    </author>
    <?php echo $entry ?>
</feed>
<?php }?>