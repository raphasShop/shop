<?php
if (!defined('_GNUBOARD_')) exit;

#######################################################################################
/* 일자별 주문 합계 표시 [아이스크림소스] */
// 삽입함수 include_once(G5_ADMIN_PATH.'/sum/admin.sum_orderdate.php');
// 일,주,이달,전체 주문/매출 건수 표시
#######################################################################################
	
// 기간/일자 추출 함수 (*관리자메인페이지에도 적용되는 공통함수임)
$date_term = date('w', G5_SERVER_TIME); // (일 간격) 일단위
$oneweek_term = $date_term + 7; //(최근일주일 간격) 7일단위
$onemonth_term = strtotime(date('Y-m-d', G5_SERVER_TIME)); // (최근한달 간격) 매월 전달 오늘날짜 기준
$today = date("Y-m-d", G5_SERVER_TIME); //오늘날짜
//$yesterday = date('Y-m-d', G5_SERVER_TIME - 86400); // 어제날짜
$yesterday = date('Y-m-d', strtotime('-1 days', G5_SERVER_TIME)); 
$weekoneday = date('Y-m-d', strtotime('-'.$date_term.' days', G5_SERVER_TIME)); // (이번주시작) 매주 일요일 부터
$moneday = date('Y-m-01', G5_SERVER_TIME); // (이번달시작) 매월 1일부터
$mnowday = date('Y-m-d', G5_SERVER_TIME); // (이번달 오늘까지) 매월 오늘날짜
$lastmonth_term = strtotime(date('Y-m-01', G5_SERVER_TIME)); // 매월1일기준(전달,1년기준 출력시)
$lastmonthday = date('Y-m-01', strtotime('-1 Month', $lastmonth_term)); // (전달 시작) 전달 1일부터
$lastmonthendday = date('Y-m-t', strtotime('-1 Month', $lastmonth_term)); // (전달 끝) 전달 말일까지
$amonthoneday = date('Y-m-d', strtotime('-1 Month', $onemonth_term)); //(최근한달 시작일) 한달전 오늘

// 오늘의 모든주문(현재상태에 상관없이 오늘 주문건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$today 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $infotoday = array();
    $infotoday['count'] = (int)$row['cnt'];
    $infotoday['price'] = (int)$row['price'];
    $infotoday['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($today).'&to_date='.urlencode($today);
	
// 어제의 모든주문(현재상태에 상관없이 어제 주문건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$yesterday 00:00:00' and '$yesterday 23:59:59'";
    $row = sql_fetch($sql);
    $infoyesterday = array();
    $infoyesterday['count'] = (int)$row['cnt'];
    $infoyesterday['price'] = (int)$row['price'];
    $infoyesterday['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($yesterday).'&to_date='.urlencode($yesterday);

// 이달의 모든주문(현재상태에 상관없이 이달 주문건만 계산)/금액(관리자모드) - 이달 1일 부터 현재일까지
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$moneday 00:00:00' and '$mnowday 23:59:59'";
    $row = sql_fetch($sql);
    $infomonth = array();
    $infomonth['count'] = (int)$row['cnt'];
    $infomonth['price'] = (int)$row['price'];
    $infomonth['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($moneday).'&to_date='.urlencode($mnowday);
	
// 이달의 PC 주문(현재상태에 상관없이 이달 PC로 주문건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$moneday 00:00:00' and '$mnowday 23:59:59' and od_mobile != '1'";
    $row = sql_fetch($sql);
    $infomonth_pc = array();
    $infomonth_pc['count'] = (int)$row['cnt'];
    $infomonth_pc['price'] = (int)$row['price'];
    $infomonth_pc['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_mobile=PC&od_term=od_time&fr_date='.urlencode($moneday).'&to_date='.urlencode($mnowday);
	
// 이달의 모바일 주문(현재상태에 상관없이 이달 PC로 주문건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$moneday 00:00:00' and '$mnowday 23:59:59' and od_mobile = '1'";
    $row = sql_fetch($sql);
    $infomonth_mobile = array();
    $infomonth_mobile['count'] = (int)$row['cnt'];
    $infomonth_mobile['price'] = (int)$row['price'];
    $infomonth_mobile['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_mobile=모바일&od_term=od_time&fr_date='.urlencode($moneday).'&to_date='.urlencode($mnowday);

// 이달의 매출(실제결제금액)(현재상태에 상관없이 결제완료건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$moneday 00:00:00' and '$mnowday 23:59:59'";
    $row = sql_fetch($sql);
    $infomonth_sale = array();
    $infomonth_sale['count'] = (int)$row['cnt'];
    $infomonth_sale['price'] = (int)$row['price'];
    $infomonth_sale['href'] = G5_ADMIN_URL.'/shop_admin/sale1date.php?fr_date='.urlencode($moneday).'&to_date='.urlencode($mnowday);
	
// 이달의 주문취소/환불(주문취소 주문건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$moneday 00:00:00' and '$mnowday 23:59:59' and ( (od_status = '취소') or (od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0) ) ";
    $row = sql_fetch($sql);
    $infomonth_cancle = array();
    $infomonth_cancle['count'] = (int)$row['cnt'];
    $infomonth_cancle['price'] = (int)$row['price'];
    $infomonth_cancle['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=취소&od_term=od_time&fr_date='.urlencode($moneday).'&to_date='.urlencode($mnowday);

// 전달의 모든주문(현재상태에 상관없이 전달 주문건만 계산)/금액(관리자모드) - 전달1일 부터 말일
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$lastmonthday 00:00:00' and '$lastmonthendday 23:59:59'";
    $row = sql_fetch($sql);
    $infolastmonth = array();
    $infolastmonth['count'] = (int)$row['cnt'];
    $infolastmonth['price'] = (int)$row['price'];
    $infolastmonth['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($lastmonthday).'&to_date='.urlencode($lastmonthendday);

// 이번주의 모든주문(현재상태에 상관없이 전달 주문건만 계산)/금액(관리자모드) - 일요일~토요일
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$weekoneday 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $infoweek = array();
    $infoweek['count'] = (int)$row['cnt'];
    $infoweek['price'] = (int)$row['price'];
    $infoweek['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($weekoneday).'&to_date='.urlencode($today);
	
// 최근한달의 모든주문(현재상태에 상관없이 전달 주문건만 계산)/금액(관리자모드) - 최근한달
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$amonthoneday 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $infonearmonth = array();
    $infonearmonth['count'] = (int)$row['cnt'];
    $infonearmonth['price'] = (int)$row['price'];
    $infonearmonth['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($amonthoneday).'&to_date='.urlencode($today);
			
#####################################################################################
?>