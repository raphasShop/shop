<?php
if (!defined('_GNUBOARD_')) exit;

#######################################################################################
/* [취소신청] 취소진행중 표시 - 반품/환불/교환 신청 및 진행중 표시 [아이스크림소스]*/	
// 삽입함수 include_once(G5_ADMIN_PATH.'/sum/admin.sum_ordercancle.php');
// 환불,반품,교환 등 신청/진행상황 추가로 인한 상태 집계 추가
#######################################################################################
	
// 환불신청 건수 (고객신청접수)
    //$sql = " select count(*) as cnt from {$g5['g5_shop_order_table']} where od_id IN ( SELECT od_id FROM `g5_shop_cart` WHERE ct_status = '환불' ) ";
	$sql = " select count(*) as cnt from {$g5['g5_shop_cart_table']} where ct_status = '환불신청' ";
    $row = sql_fetch($sql);
    $now_refund = array();
    $now_refund['count'] = (int)$row['cnt'];
    $now_refund['price'] = (int)$row['price'];
    $now_refund['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';

// 환불진행중 건수 (진행중)
	$sql = " select count(*) as cnt from {$g5['g5_shop_cart_table']} where ct_status = '환불진행중' ";
    $row = sql_fetch($sql);
    $now_refunding = array();
    $now_refunding['count'] = (int)$row['cnt'];
    $now_refunding['price'] = (int)$row['price'];
    $now_refunding['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';	

// 반품신청 건수 (고객신청접수)
	$sql = " select count(*) as cnt from {$g5['g5_shop_cart_table']} where ct_status = '반품신청' ";
    $row = sql_fetch($sql);
    $now_back = array();
    $now_back['count'] = (int)$row['cnt'];
    $now_back['price'] = (int)$row['price'];
    $now_back['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';

// 반품진행중 건수 (진행중)
	$sql = " select count(*) as cnt from {$g5['g5_shop_cart_table']} where ct_status = '반품진행중' ";
    $row = sql_fetch($sql);
    $now_backing = array();
    $now_backing['count'] = (int)$row['cnt'];
    $now_backing['price'] = (int)$row['price'];
    $now_backing['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';

// 교환신청 건수 (고객신청접수)
	$sql = " select count(*) as cnt from {$g5['g5_shop_cart_table']} where ct_status = '교환신청' ";
    $row = sql_fetch($sql);
    $now_change = array();
    $now_change['count'] = (int)$row['cnt'];
    $now_change['price'] = (int)$row['price'];
    $now_change['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';

// 교환진행중 건수 (진행중)
	$sql = " select count(*) as cnt from {$g5['g5_shop_cart_table']} where ct_status = '교환진행중' ";
    $row = sql_fetch($sql);
    $now_changeing = array();
    $now_changeing['count'] = (int)$row['cnt'];
    $now_changeing['price'] = (int)$row['price'];
    $now_changeing['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';
	
#####################################################################################
?>