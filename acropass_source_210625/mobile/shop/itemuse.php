<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$itemuse_list = "./itemuselist.php";
$itemuse_form = "./itemuseform.php?it_id=".$it_id;
$itemuse_formupdate = "./itemuseformupdate.php?it_id=".$it_id;

$photo_review = $_GET['photo'];

if($photo_review == y) {
    $photo_sql = "and is_content like '%img%'";
}

$sql_common = " from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' and is_confirm = '1' $photo_sql ";

// 테이블의 전체 레코드수만 얻음
$sql = " select COUNT(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 10;
$total_page  = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 레코드 구함

$sql = "select * $sql_common order by is_id desc limit $from_record, $rows ";
$result = sql_query($sql);

$sql_common1 = " from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' and is_confirm = '1' ";

// 테이블의 전체리뷰 레코드수만 얻음
$sql1 = " select COUNT(*) as cnt " . $sql_common1;
$row1 = sql_fetch($sql1);
$total_count1 = $row1['cnt'];

$sql_common2 = " from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' and is_confirm = '1' and is_content like '%img%'";

// 테이블의 포토리뷰 레코드수만 얻음
$sql2 = " select COUNT(*) as cnt " . $sql_common2;
$row2 = sql_fetch($sql2);
$total_count2 = $row2['cnt'];

$itemuse_skin = G5_MSHOP_SKIN_PATH.'/itemuse.skin.php';

if(!file_exists($itemuse_skin)) {
    echo str_replace(G5_PATH.'/', '', $itemuse_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($itemuse_skin);
}
?>