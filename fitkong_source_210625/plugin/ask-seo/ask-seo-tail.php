<?php

if (!defined('_GNUBOARD_')) {
    exit;
}
/**
 * ASK SEO 출력부분 Tail 용
 */

//seo 사용에 체크해야 출력된다.
if (!$config['as_use']) {
    return;
}
//seo 사용에 체크해야 출력된다.
if (!$config['as_use']) {
    return;
}
$as_tailtags = new AskSEO;

#######################################################
# 게시판 목록에 구조화된 데이터 추가
#######################################################
if ($bo_table && strstr($_SERVER['PHP_SELF'], 'board') && !$wr_id) {
    $_board_url           = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . "?bo_table={$bo_table}";
    $board_structure_data = array(
        '@context'        => 'http://schema.org',
        '@type'           => 'ItemList',
        'itemListElement' => array(),
    );
    for ($i = 0; count($list) > $i; $i++) {
        $_board_item_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . "?bo_table={$bo_table}&wr_id={$list[$i]['wr_id']}";
        //첨부파일
        $_file = $as_tailtags->get_file($bo_table, $list[$i]['wr_id'], $list[$i]['wr_content']);

        $board_item = array(
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'url'      => $_board_item_url,
            'name'     => get_text($list[$i]['wr_name']),
            'image'    => array(),

        );
        if (count($_file) > 0) {
            foreach ($_file as $files) {
                array_push($board_item['image'], $files);
            }
        }

        array_push($board_structure_data['itemListElement'], $board_item);
    }
}

echo "<!-- ################ ASK SEO Generator ################  -->" . PHP_EOL;

//구조화된 데이터 출력
$as_tailtags->jsonld($board_structure_data);
echo $as_tailtags->render();

echo "<!-- ################  //ASK SEO Generator ################ -->\n\n" . PHP_EOL;
