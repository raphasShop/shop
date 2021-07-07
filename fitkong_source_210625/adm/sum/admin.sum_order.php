<?php
if (!defined('_GNUBOARD_')) exit;

#######################################################################################
/* 주문 상태별 합계 표시 [아이스크림소스] */
// 삽입함수 include_once(G5_ADMIN_PATH.'/sum/admin.sum_order.php');
// [주문/입금/준비/배송] 주문처리할 건수 표시
#######################################################################################

$od_status_today = date("Y-m-d", G5_SERVER_TIME); //오늘날짜
	
// 주문(입금대기) 건수/금액(무통장입금 등 입금전 주문 / 관리자모드)
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_status = '주문' ";
    $row = sql_fetch($sql);
    $info1 = array();
    $info1['count'] = (int)$row['cnt'];
    $info1['price'] = (int)$row['price'];
    $info1['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=주문';

// 오늘의 status 주문(입금대기) 건수/금액(무통장입금 등 입금전 주문 / 관리자모드)
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_status = '주문' and od_time between '$od_status_today 00:00:00' and '$od_status_today 23:59:59' ";
    $row = sql_fetch($sql);
    $info1_odtoday = array();
    $info1_odtoday['count'] = (int)$row['cnt'];
    $info1_odtoday['price'] = (int)$row['price'];
    $info1_odtoday['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=주문';

// 입금 건수/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_status = '입금' ";
    $row = sql_fetch($sql);
    $info2 = array();
    $info2['count'] = (int)$row['cnt'];
    $info2['price'] = (int)$row['price'];
    $info2['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=입금';

// 오늘의 status 입금 건수/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_status = '입금' and od_receipt_time between '$od_status_today 00:00:00' and '$od_status_today 23:59:59' ";
    $row = sql_fetch($sql);
    $info2_odtoday = array();
    $info2_odtoday['count'] = (int)$row['cnt'];
    $info2_odtoday['price'] = (int)$row['price'];
    $info2_odtoday['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=입금';
	
// 준비 건수/금액(관리자모드)	
	$sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_status = '준비' ";
    $row = sql_fetch($sql);
    $info3 = array();
    $info3['count'] = (int)$row['cnt'];
    $info3['price'] = (int)$row['price'];
    $info3['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=준비';

// 배송 건수/금액(관리자모드)	
	$sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_status = '배송' ";
    $row = sql_fetch($sql);
    $info4 = array();
    $info4['count'] = (int)$row['cnt'];
    $info4['price'] = (int)$row['price'];
    $info4['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=배송';

// 오늘의 status 배송 건수/금액(관리자모드)	
	$sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_status = '배송' and od_invoice_time between '$od_status_today 00:00:00' and '$od_status_today 23:59:59' ";
    $row = sql_fetch($sql);
    $info4_odtoday = array();
    $info4_odtoday['count'] = (int)$row['cnt'];
    $info4_odtoday['price'] = (int)$row['price'];
    $info4_odtoday['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=배송';
	
// 개인결제(미입금) 건수/금액(관리자모드) 
	$sql = " select count(*) as cnt, sum(pp_price - pp_receipt_price) as price from {$g5['g5_shop_personalpay_table']} where pp_receipt_price = '0' ";
    $row = sql_fetch($sql);
    $info_personal = array();
    $info_personal['count'] = (int)$row['cnt'];
    $info_personal['price'] = (int)$row['price'];
    $info_personal['href'] = G5_ADMIN_URL.'/shop_admin/personalpaylist.php';

// 오늘의 개인결제(미입금) 건수/금액(관리자모드) 
	$sql = " select count(*) as cnt, sum(pp_price - pp_receipt_price) as price from {$g5['g5_shop_personalpay_table']} where pp_receipt_price = '0' and pp_time between '$od_status_today 00:00:00' and '$od_status_today 23:59:59' ";
    $row = sql_fetch($sql);
    $info_personal_odtoday = array();
    $info_personal_odtoday['count'] = (int)$row['cnt'];
    $info_personal_odtoday['price'] = (int)$row['price'];
    $info_personal_odtoday['href'] = G5_ADMIN_URL.'/shop_admin/personalpaylist.php';

#######################################################################################
/* 종류별 전체 합계 표시 [아이스크림소스] */
// shop_admin/sale1.php 파일로 옮김. 매출현황페이지에서만 사용
// 다른페이지들에서는 전체주문수를 뽑는것은 과부하가 예상되어 매출현황페이지에서만 사용
#######################################################################################

?>