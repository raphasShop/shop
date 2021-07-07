<?php
/**
 * ASK SEO
 * Sitemap
 * 불법복제시 불이익을 받을 수 있습니다.
 */

include_once "./_common.php";
header('Content-type: text/xml; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
//메뉴를 사이트맵으로 작성
$sql    = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '2' order by me_order, me_id ";
$result = sql_query($sql, false);
for ($i = 0; $row = sql_fetch_array($result); $i++) {
    //1단 메뉴
    $sitemap .= '<url>' . PHP_EOL;
    //URL
    $sitemap .= '<loc>' . htmlspecialchars($row['me_link']) . '</loc>' . PHP_EOL;
    $lastmod = get_lastmodify_date($row['me_link']);
    if($lastmod){
        $sitemap .= '<lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
    }
    //수정빈도
    $sitemap .= '<changefreq>weekly</changefreq>' . PHP_EOL;
    //중요도, google은 사용하지 않음
    $sitemap .= '<priority>0.9</priority>';
    $sitemap .= '</url>' . PHP_EOL;
    $sql2    = " select * from {$g5['menu_table']} where me_use = '1' and length(me_code) = '4' and substring(me_code, 1, 2) = '{$row['me_code']}' order by me_order, me_id ";
    $result2 = sql_query($sql2);

    ########################
    # 2단메뉴
    ########################
    for ($k = 0; $row2 = sql_fetch_array($result2); $k++) {
        $sitemap .= '<url>' . PHP_EOL;
        //URL
        $sitemap .= '<loc>' . htmlspecialchars($row2['me_link']) . '</loc>' . PHP_EOL;
        $lastmod = get_lastmodify_date($row2['me_link']);
        if($lastmod){
            $sitemap .= '<lastmod>' . $lastmod . '</lastmod>' . PHP_EOL;
        }        
        //수정빈도
        $sitemap .= '<changefreq>weekly</changefreq>' . PHP_EOL;
        //중요도
        $sitemap .= '<priority>0.5</priority>';
        $sitemap .= '</url>' . PHP_EOL;
    }
}

############
# 추가URL
############
$as_sitemap_addurl = preg_split('/\r\n|[\r\n]/', $config['as_sitemap_addurl']);
if (count($as_sitemap_addurl) > 0) {
    foreach ($as_sitemap_addurl as $addurl) {
        if(!$addurl){
            continue;
        }
        $sitemap .= '<url>' . PHP_EOL;
        //URL
        $sitemap .= '<loc>' . htmlspecialchars($addurl) . '</loc>' . PHP_EOL;
        //수정빈도
        $sitemap .= '<changefreq>weekly</changefreq>' . PHP_EOL;
        //중요도
        $sitemap .= '<priority>0.5</priority>';
        $sitemap .= '</url>' . PHP_EOL;
    }
}

##############
# 게시판추가
##############
$as_sitemap_boardlist = unserialize($config['as_sitemap_boardlist']);
if (count($as_sitemap_boardlist) > 0 && $as_sitemap_boardlist) {
    foreach ($as_sitemap_boardlist as $wr) {
        $sql    = "select wr_id from {$g5['write_prefix']}{$wr} where wr_is_comment = '0' order by wr_num asc limit {$config['as_sitemap_boardcount']}";
        $result = sql_query($sql);
        for ($i = 0; $rows = sql_fetch_array($result); $i++) {
            $link_url = G5_BBS_URL . '/board.php?bo_table=' . $wr . '&wr_id=' . $rows['wr_id'];
            $sitemap .= '<url>' . PHP_EOL;
            //URL
            $sitemap .= '<loc>' . htmlspecialchars($link_url) . '</loc>' . PHP_EOL;
            //수정빈도
            $sitemap .= '<changefreq>weekly</changefreq>' . PHP_EOL;
            //중요도
            $sitemap .= '<priority>0.5</priority>';
            $sitemap .= '</url>' . PHP_EOL;
        }
    }
}

##############
# 내용관리추가
##############
$as_sitemap_contentslist = unserialize($config['as_sitemap_contentslist']);
if (count($as_sitemap_contentslist) > 0 && $as_sitemap_contentslist) {
    foreach ($as_sitemap_contentslist as $co) {
        $link_url = G5_BBS_URL . '/content.php?co_id=' . $co;
        $sitemap .= '<url>' . PHP_EOL;
        //URL
        $sitemap .= '<loc>' . htmlspecialchars($link_url) . '</loc>' . PHP_EOL;
        //수정빈도
        $sitemap .= '<changefreq>weekly</changefreq>' . PHP_EOL;
        //중요도
        $sitemap .= '<priority>0.5</priority>';
        $sitemap .= '</url>' . PHP_EOL;
    }
}

############
# FAQ 추가
############
if ($config['as_sitemap_faq']) {
    $sql    = "select * from {$g5['faq_master_table']} order by fm_order";
    $result = sql_query($sql);
    for ($i = 0; $faq = sql_fetch_array($result); $i++) {
        $link_url = G5_BBS_URL . '/faq.php?fm_id=' . $faq['fm_id'];
        $sitemap .= '<url>' . PHP_EOL;
        //URL
        $sitemap .= '<loc>' . htmlspecialchars($link_url) . '</loc>' . PHP_EOL;
        //수정빈도
        $sitemap .= '<changefreq>weekly</changefreq>' . PHP_EOL;
        //중요도
        $sitemap .= '<priority>0.4</priority>';
        $sitemap .= '</url>' . PHP_EOL;
    }
}

$sitemap .= '</urlset>';

//출력
echo $sitemap;