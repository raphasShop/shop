<?php

if (!defined('_GNUBOARD_')) {
    exit;
}
/**
 * ASK SEO 출력부분
 */

//seo 사용에 체크해야 출력된다.
if (!$config['as_use']) {
    return;
}

$as_tags = new AskSEO;
$hostname = as_get_hostname();

#######################################################
# 인덱스 페이지
#######################################################
if (defined('_INDEX_') == true) {
    $as_tags->link('canonical', $config['as_url']);
    $as_tags->og('title', $config['as_title']);
    $as_tags->og('url', $config['as_url']);
    $as_tags->og('type', 'website');
    $as_tags->og('description', $config['as_description']);
    $as_tags->meta('description', $config['as_description']);
    $as_tags->meta('keywords', $config['as_keywords']);
    if ($config['as_logo']) {
        $as_tags->og('image', AS_SAVE_URL . '/' . $config['as_logo']);
        $logo_url = AS_SAVE_URL . '/' . $config['as_logo'];
    }

    $structure_data = array(
        '@context'        => 'http://schema.org',
        '@type'           => 'Organization',
        'url'             => $config['as_url'],
        'logo'            => $logo_url,
        'contactPoint'    => array(
            '@type'       => 'ContactPoint',
            'telephone'   => '+82-' . $config['as_telephone'],
            'contactType' => 'customer service',
        ),
        'potentialAction' => array(
            "@type"       => "SearchAction",
            "target"      => G5_BBS_URL . '/search.php?sfl=wr_subject%7C%7Cwr_content&sop=and&stx={search_term_string}',
            "query-input" => "required name=search_term_string",
        ),
    );

    //소셜프로필이 있다면 출력
    $social_profile['sameAs'] = array();
    if ($config['as_sns_facebook']) {
        array_push($social_profile['sameAs'], $config['as_sns_facebook']);
    }
    if ($config['as_sns_twitter']) {
        array_push($social_profile['sameAs'], $config['as_sns_twitter']);
    }
    if ($config['as_sns_instagram']) {
        array_push($social_profile['sameAs'], $config['as_sns_instagram']);
    }
    if ($config['as_sns_youtube']) {
        array_push($social_profile['sameAs'], $config['as_sns_youtube']);
    }
    if ($config['as_sns_googleplus']) {
        array_push($social_profile['sameAs'], $config['as_sns_googleplus']);
    }
    if ($config['as_sns_linkedin']) {
        array_push($social_profile['sameAs'], $config['as_sns_linkedin']);
    }
    if ($config['as_sns_pinterest']) {
        array_push($social_profile['sameAs'], $config['as_sns_pinterest']);
    }
    if ($config['as_sns_soundcloud']) {
        array_push($social_profile['sameAs'], $config['as_sns_soundcloud']);
    }
    if ($config['as_sns_tumblr']) {
        array_push($social_profile['sameAs'], $config['as_sns_tumblr']);
    }
    if ($config['as_sns_navercafe']) {
        array_push($social_profile['sameAs'], $config['as_sns_navercafe']);
    }
    if ($config['as_sns_naversmartstore']) {
        array_push($social_profile['sameAs'], $config['as_sns_naversmartstore']);
    }
    if ($config['as_sns_naverpost']) {
        array_push($social_profile['sameAs'], $config['as_sns_naverpost']);
    }
    if ($config['as_sns_naverpholar']) {
        array_push($social_profile['sameAs'], $config['as_sns_naverpholar']);
    }
    if ($config['as_sns_itunes']) {
        array_push($social_profile['sameAs'], $config['as_sns_itunes']);
    }
    if ($config['as_sns_googleplaystore']) {
        array_push($social_profile['sameAs'], $config['as_sns_googleplaystore']);
    }
    if ($config['as_sns_navertv']) {
        array_push($social_profile['sameAs'], $config['as_sns_navertv']);
    }
    if ($config['as_sns_kakaostory']) {
        array_push($social_profile['sameAs'], $config['as_sns_kakaostory']);
    }

    //배열 합치기
    $structure_data = array_merge($structure_data, $social_profile);

    //사이트 소유 확인
    if ($config['as_naver_verification']) {
        //네이버
        echo "<!-- Naver Webmaster Tools -->" . PHP_EOL;
        echo "<meta name='naver-site-verification' content='{$config['as_naver_verification']}'/>" . PHP_EOL;
    }
    if ($config['as_google_verification']) {
        //구글
        echo "<!-- Google Webmaster Tools -->" . PHP_EOL;
        echo "<meta name='google-site-verification' content='{$config['as_google_verification']}'/>" . PHP_EOL;
    }
    if ($config['as_bing_verification']) {
        //빙
        echo "<!-- Bing Webmaster Tools -->" . PHP_EOL;
        echo "<meta name='msvalidate.01' content='{$config['as_bing_verification']}'/>" . PHP_EOL;
    }
}

#######################################################
# Group에서 출력
#######################################################
if ($gr_id && strstr($_SERVER['PHP_SELF'], 'group')) {
    $_url = $hostname . $_SERVER['SCRIPT_NAME'] . "?gr_id={$gr_id}";
    $as_tags->link('canonical', $_url);
    $as_tags->og('title', $group['gr_subject']);
    $as_tags->og('url', $_url);
    $as_tags->og('type', 'article');
    $as_tags->meta('keywords', $group[AS_GROUP_KEYWORDS_FIELD]);
    $as_tags->meta('description', $group[AS_GROUP_DESCRIPTION_FIELD]);

}

#######################################################
# 게시판 목록에서만 출력
#######################################################
if ($bo_table && !$wr_id && strstr($_SERVER['PHP_SELF'], 'board')) {
    $_url =  $hostname . $_SERVER['SCRIPT_NAME'] . "?bo_table={$bo_table}";
    $as_tags->link('canonical', $_url);
    $as_tags->og('title', $board['bo_subject']);
    $as_tags->og('url', $_url);
    $as_tags->og('type', 'article');
    $as_tags->meta('keywords', $board[AS_BOARD_KEYWORDS_FIELD]);
    $as_tags->meta('description', $board[AS_BOARD_DESCRIPTION_FIELD]);
    //게시판 검색엔진 차단
    if ($board[AS_BOARD_NOINDEX_FIELD]) {
        $as_tags->meta('robots', 'noindex');
        $as_tags->meta('robots', 'nofollow');
    }
}

#######################################################
# 게시판 내용
#######################################################
if ($bo_table && $wr_id && strstr($_SERVER['PHP_SELF'], 'board')) {
    //게시물 가져오기
    $_tmp_view = $as_tags->get_view($bo_table, $wr_id, false);
    $_view     = $_tmp_view['0'];
    //설명
    $_description = cut_str(strip_tags($_view['wr_content']), 120);
    //제목
    $_title = cut_str(strip_tags($_view['wr_subject']), 60);
    //URL
    $_url = $hostname . $_SERVER['SCRIPT_NAME'] . "?bo_table={$bo_table}&wr_id={$wr_id}";
    //첨부파일
    $_file = $as_tags->get_file($bo_table, $wr_id, $_view['wr_content']);

    //og title을 사용자가 입력한 값으로 사용.
    if ($_view[AS_WRITE_TITLE_FIELD]) {
        //title 게시물 여분필드 8번
        $_title = strip_tags($_view[AS_WRITE_TITLE_FIELD]);
    }
    //사용자 지정 KEYWORDS 가 있다면 사용
    if ($_view[AS_WRITE_KEYWORDS_FIELD]) {
        //keywords는 게시물 여분필드 9번
        $_keywords = strip_tags($_view[AS_WRITE_KEYWORDS_FIELD]);
        $as_tags->meta('keywords', $_keywords);
    }
    if ($_view[AS_WRITE_DESCRIPTION_FIELD]) {
        //description는 게시물 여분필드 10번
        $_description = strip_tags($_view[AS_WRITE_DESCRIPTION_FIELD]);
    }

    $as_tags->meta('description', $_description);
    $as_tags->og('description', $_description);
    //게시판 검색엔진 차단
    if ($board[AS_BOARD_NOINDEX_FIELD]) {
        $as_tags->meta('robots', 'noindex');
        $as_tags->meta('robots', 'nofollow');
    }
    //게시물 고유주소
    $as_tags->link('canonical', $_url);
    $as_tags->og('title', $_title);
    $as_tags->og('url', $_url);
    $as_tags->og('type', 'article');
    //첨부이미지
    if (count($_file) > 0) {
        $as_tags->og('image', $_file['0']);
        $_json_ld_image = $_file;
    } else {
        $_json_ld_image = G5_URL . '/img/no_img.png';
    }
    //위터는 og 태그를 공유하기 때문에 카드타입만 설정
    $as_tags->twitter('card', 'summary_large_image');

    /*
     * 게시물 내용보기 구조화
     */

    //회원이미지
    $_member_image = $as_tags->get_member_image($_view['mb_id']);
    //Json LD
    $structure_data = array(
        '@context'         => 'http://schema.org',
        '@type'            => 'Article',
        'mainEntityOfPage' => array(
            '@type' => 'WebPage',
            '@id'   => $_url,
        ),
        'name'             => $_view['wr_name'],
        'author'           => array(
            '@type' => 'Person',
            'name'  => $_view['wr_name'],
        ),
        'datePublished'    => $_view['wr_datetime'],
        'headline'         => $_view['wr_subject'],
        'description'      => $_description,
        'image'            => $_json_ld_image,
        'publisher'        => array(
            '@type' => 'Organization',
            'name'  => $_view['wr_name'],
            'logo'  => array(
                '@type'  => 'ImageObject',
                'name'   => 'MemberLogo',
                'width'  => '60',
                'height' => '60',
                'url'    => $_member_image,
            ),
        ),
        'dateModified'     => $_view['wr_last'],
    );
}

echo "<!-- ################ ASK SEO Generator ################  -->" . PHP_EOL;

//구조화된 데이터 출력
$as_tags->jsonld($structure_data);
echo $as_tags->render();

echo "<!-- ################  //ASK SEO Generator ################ -->\n\n" . PHP_EOL;

//RSS 링크 출력
echo '<link rel="alternate" type="application/' . $config['as_feed_type'] . '+xml" title="' . $config['cf_title'] . ' - RSS" href="' . G5_URL . '/as_rss.php" />' . PHP_EOL;

//게시판 목록에서 RSS 링크 출력
if ($bo_table && !$wr_id && strstr($_SERVER['PHP_SELF'], 'board') && $board['bo_use_rss_view']) {
    echo '<link rel="alternate" type="application/rss+xml" title="' . $board['bo_subject'] . ' - RSS" href="' . G5_BBS_URL . '/rss.php?bo_table=' . $bo_table . '" />' . PHP_EOL;
}
