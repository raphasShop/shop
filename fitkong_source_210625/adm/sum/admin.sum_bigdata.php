<?php
if (!defined('_GNUBOARD_')) exit;

#######################################################################################
/* 잠재 구매 행동 [아이스크림소스]*/
// 삽입함수 include_once(G5_ADMIN_PATH.'/sum/admin.sum_bigdata.php');
// 장바구니담기, 찜하기, 회원가입, 쿠폰받아놓기 등 구매전에 일어나는 행동들
// index.php 에서 사용함
// 어제함수 $yesterday
#######################################################################################
	
// [오늘] 장바구니에 담은 상품
    $today_cart_cnt = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_cart_table']} where ct_status = '쇼핑' and ct_time between '$today 00:00:00' and '$today 23:59:59' ";
    $row = sql_fetch($sql);
    $today_cart_cnt = (int)$row['cnt'];

// [어제] 장바구니에 담은 상품
    $yesterday_cart_cnt = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_cart_table']} where ct_status = '쇼핑' and ct_time between '$yesterday 00:00:00' and '$yesterday 23:59:59' ";
    $row = sql_fetch($sql);
    $yesterday_cart_cnt = (int)$row['cnt'];
	
// [이번달] 장바구니에 담은 상품
    $month_cart_cnt = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_cart_table']} where ct_status = '쇼핑' and ct_time between '$moneday 00:00:00' and '$mnowday 23:59:59' ";
    $row = sql_fetch($sql);
    $month_cart_cnt = (int)$row['cnt'];

#####################################################################################

// [오늘] 위시리스트에 담은 상품
    $today_wish_cnt = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_wish_table']} where wi_time between '$today 00:00:00' and '$today 23:59:59' ";
    $row = sql_fetch($sql);
    $today_wish_cnt = (int)$row['cnt'];

// [어제] 위시리스트에 담은 상품
    $yesterday_wish_cnt = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_wish_table']} where wi_time between '$yesterday 00:00:00' and '$yesterday 23:59:59' ";
    $row = sql_fetch($sql);
    $yesterday_wish_cnt = (int)$row['cnt'];
	
// [이번달] 위시리스트에 담은 상품
    $month_wish_cnt = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_wish_table']} where wi_time between '$moneday 00:00:00' and '$mnowday 23:59:59' ";
    $row = sql_fetch($sql);
    $month_wish_cnt = (int)$row['cnt'];	

#####################################################################################

// [오늘] 회원가입
    $today_mship_cnt = 0;
    $sql = " select count(*) as cnt from {$g5['member_table']} where mb_datetime between '$today 00:00:00' and '$today 23:59:59' ";
    $row = sql_fetch($sql);
    $today_mship_cnt = (int)$row['cnt'];

// [어제] 회원가입
    $yesterday_mship_cnt = 0;
    $sql = " select count(*) as cnt from {$g5['member_table']} where mb_datetime between '$yesterday 00:00:00' and '$yesterday 23:59:59' ";
    $row = sql_fetch($sql);
    $yesterday_mship_cnt = (int)$row['cnt'];
	
// [이번달] 회원가입
    $month_mship_cnt = 0;
    $sql = " select count(*) as cnt from {$g5['member_table']} where mb_datetime between '$moneday 00:00:00' and '$mnowday 23:59:59' ";
    $row = sql_fetch($sql);
    $month_mship_cnt = (int)$row['cnt'];

#####################################################################################
	
// [오늘] 회원탈퇴
    $today_mleave_cnt = 0;
    $sql = " select count(*) as cnt from {$g5['member_table']} where mb_leave_date between '$today 00:00:00' and '$today 23:59:59' ";
    $row = sql_fetch($sql);
    $today_mleave_cnt = (int)$row['cnt'];

// [어제] 회원탈퇴
    $yesterday_mleave_cnt = 0;
    $sql = " select count(*) as cnt from {$g5['member_table']} where mb_leave_date between '$yesterday 00:00:00' and '$yesterday 23:59:59' ";
    $row = sql_fetch($sql);
    $yesterday_mleave_cnt = (int)$row['cnt'];
	
// [이번달] 회원탈퇴
    $month_mleave_cnt = 0;
    $sql = " select count(*) as cnt from {$g5['member_table']} where mb_leave_date between '$moneday 00:00:00' and '$mnowday 23:59:59' ";
    $row = sql_fetch($sql);
    $month_mleave_cnt = (int)$row['cnt'];	

#####################################################################################

// [오늘] 쿠폰존 쿠폰다운로드 수
    $today_czone_cnt = 0;
    $sql = " select sum(cz_download) as download from {$g5['g5_shop_coupon_zone_table']} where cz_datetime between '$today 00:00:00' and '$today 23:59:59' ";
    $row = sql_fetch($sql);
    $today_czone = array();
	$today_czone['download'] = (int)$row['download'];

// [어제] 쿠폰존 쿠폰다운로드 수
    $yesterday_czone_cnt = 0;
    $sql = " select sum(cz_download) as download from {$g5['g5_shop_coupon_zone_table']} where cz_datetime between '$yesterday 00:00:00' and '$yesterday 23:59:59' ";
    $row = sql_fetch($sql);
    $yesterday_czone = array();
	$yesterday_czone['download'] = (int)$row['download'];
	
// [이번달] 쿠폰존 쿠폰다운로드 수
    $month_czone_cnt = 0;
    $sql = " select sum(cz_download) as download from {$g5['g5_shop_coupon_zone_table']} where cz_datetime between '$moneday 00:00:00' and '$mnowday 23:59:59' ";
    $row = sql_fetch($sql);
    $month_czone = array();
	$month_czone['download'] = (int)$row['download'];

#####################################################################################

// [오늘] 새로 등록한 상품
    $today_item_cnt = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_table']} where it_time between '$today 00:00:00' and '$today 23:59:59' ";
    $row = sql_fetch($sql);
    $today_item_cnt = (int)$row['cnt'];

// [어제] 새로 등록한 상품
    $yesterday_item_cnt = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_table']} where it_time between '$yesterday 00:00:00' and '$yesterday 23:59:59' ";
    $row = sql_fetch($sql);
    $yesterday_item_cnt = (int)$row['cnt'];
	
// [이번달] 새로 등록한 상품
    $month_item_cnt = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_table']} where it_time between '$moneday 00:00:00' and '$mnowday 23:59:59' ";
    $row = sql_fetch($sql);
    $month_item_cnt = (int)$row['cnt'];
	
#####################################################################################
?>