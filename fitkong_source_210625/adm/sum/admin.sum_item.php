<?php
if (!defined('_GNUBOARD_')) exit;

#######################################################################################
/* 상품 관련 합계 표시 [아이스크림소스] */
// 삽입함수 include_once(G5_ADMIN_PATH.'/sum/admin.sum_item.php');
// 판매상품,판매중지,품절상품등 건수 표시
#######################################################################################

// 전체 상품수
    $item_sell_all = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_table']} ";
    $row = sql_fetch($sql);
    $item_sell_all = (int)$row['cnt'];
		
// 판매중인 전체 상품수
    $item_sell_use = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_table']} where it_use = '1' ";
    $row = sql_fetch($sql);
    $item_sell_use = (int)$row['cnt'];

// 미판매중인 전체 상품수(판매중지)
    $item_sell_stop = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_table']} where it_use <> '1' ";
    $row = sql_fetch($sql);
    $item_sell_stop = (int)$row['cnt'];

// 품절된 상품수
    $item_sell_soldout = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_table']} where it_soldout = '1' ";
    $row = sql_fetch($sql);
    $item_sell_soldout = (int)$row['cnt'];

// 네이버페이 상품수
    $item_naverpay = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_table']} where ec_mall_pid <> '' ";
    $row = sql_fetch($sql);
    $item_naverpay = (int)$row['cnt'];

// 판매자이메일등록 상품수 - 다른판매자
    $item_sell_email = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_table']} where it_sell_email <> '' ";
    $row = sql_fetch($sql);
    $item_sell_email = (int)$row['cnt'];

#####################################################################################
?>