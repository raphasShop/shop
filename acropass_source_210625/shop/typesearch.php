<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/typesearch.php');
    return;
}

$g5['title'] = "타입별 상품 검색 결과";
include_once('./_head.php');

// QUERY 문에 공통적으로 들어가는 내용
// 상품명에 검색어가 포한된것과 상품판매가능인것만
$sql_common = " from {$g5['g5_shop_item_table']} a, {$g5['g5_shop_category_table']} b ";

$where = array();
$where[] = " (a.ca_id = b.ca_id and a.it_use = 1 and b.ca_use = 1 and a.it_5 = '') ";

$search_all = true;
// 상세검색 이라면

$q       = utf8_strcut(get_search_string(trim($_GET['q'])), 30, "");
$qtype   = isset($_GET['qtype']) ? trim($_GET['qtype']) : '';

if ($qtype == "type") {
    $where[] = " a.it_11 = '$q' ";
} else if ($qtype == "purpose") {
    $where[] = " a.it_12 = '$q' ";
}

$sql_where = " where " . implode(" and ", $where);


// 총몇개 = 한줄에 몇개 * 몇줄
$items = $default['de_search_list_mod'] * $default['de_search_list_row'];
// 페이지가 없으면 첫 페이지 (1 페이지)
if ($page < 1) $page = 1;
// 시작 레코드 구함
$from_record = ($page - 1) * $items;

// 검색된 내용이 몇행인지를 얻는다
$sql = " select COUNT(*) as cnt $sql_common $sql_where ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];
$total_page  = ceil($total_count / $items); // 전체 페이지 계산

$sql = " select b.ca_id, b.ca_name, count(*) as cnt $sql_common $sql_where group by b.ca_id order by b.ca_id ";
$result = sql_query($sql);

$categorys = array();
// 검색된 분류를 배열에 저장
while($row = sql_fetch_array($result)){
    $categorys[] = $row;
}

$q = get_text($q);
$search_skin = G5_SHOP_SKIN_PATH.'/typesearch.skin.php';

if(!file_exists($search_skin)) {
    echo str_replace(G5_PATH.'/', '', $search_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($search_skin);
}

include_once('./_tail.php');
?>
