<?php
if (!defined('G5_USE_SHOP') || !G5_USE_SHOP) return;
// 소메뉴그룹의 하위메뉴표시 아이콘은 $treeicon 으로 정의
// $treeicon 이 정의한 이미지아이콘을 변경하려면 admin.menu100.php 파일에서 수정하세요

#######################################################################################
	
$left_today = date("Y-m-d"); //오늘날짜

/* 상태별 합계 표시 [크림장수소스]*/
// 오늘의 모든주문(현재상태에상관없이 오늘 주문건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$left_today 00:00:00' and '$left_today 23:59:59' ";
    $row = sql_fetch($sql);
    $left_infotoday = array();
    $left_infotoday['count'] = (int)$row['cnt'];
    $left_infotoday['price'] = (int)$row['price'];
    $left_infotoday['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($left_today).'&to_date='.urlencode($left_today);
	
// 주문 건수/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_status = '주문' ";
    $row = sql_fetch($sql);
    $left_info1 = array();
    $left_info1['count'] = (int)$row['cnt'];
    $left_info1['price'] = (int)$row['price'];
    $left_info1['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=주문';

// 입금 건수/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_status = '입금' ";
    $row = sql_fetch($sql);
    $left_info2 = array();
    $left_info2['count'] = (int)$row['cnt'];
    $left_info2['price'] = (int)$row['price'];
    $left_info2['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=입금';

// 준비 건수/금액(관리자모드)	
	$sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_status = '준비' ";
    $row = sql_fetch($sql);
    $left_info3 = array();
    $left_info3['count'] = (int)$row['cnt'];
    $left_info3['price'] = (int)$row['price'];
    $left_info3['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=준비';

// 배송 건수/금액(관리자모드)	
	$sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_status = '배송' ";
    $row = sql_fetch($sql);
    $left_info4 = array();
    $left_info4['count'] = (int)$row['cnt'];
    $left_info4['price'] = (int)$row['price'];
    $left_info4['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=배송';

#######################################################################################
// 주문상태별 개수 표시
$linfotoday = ($left_infotoday['count'] > 0) ? ' <span class="round_cnt_lightpink">'.number_format($left_infotoday['count']).'</span>' : ''; //오늘의주문개수
$linfo1 = ($left_info1['count'] > 0) ? ' <span class="round_cnt_blue">'.number_format($left_info1['count']).'</span>' : ''; //주문개수
$linfo2 = ($left_info2['count'] > 0) ? ' <span class="round_cnt_blue">'.number_format($left_info2['count']).'</span>' : ''; //입금개수
$linfo3 = ($left_info3['count'] > 0) ? ' <span class="round_cnt_blue">'.number_format($left_info3['count']).'</span>' : ''; //준비개수
$linfo4 = ($left_info4['count'] > 0) ? ' <span class="round_cnt_blue">'.number_format($left_info4['count']).'</span>' : ''; //배송개수
#######################################################################################


$menu['menu411'] = array (
    array('411000', '주문관리', G5_ADMIN_URL.'/shop_admin/orderlist.php', 'shop_order'),    
	array('411640', '<i class="far fa-envelope-open"></i> 입금확인요청자', G5_ADMIN_URL.'/shop_admin/atmcheck.php', 'odr_ps'),
	array('411500', '<i class="fas fa-ban font-14"></i> 결제중단/실패', G5_ADMIN_URL.'/shop_admin/inorderlist.php', 'odr_inorder'),
	array('411600', '<i class="fas fa-user-circle"></i> 개인결제관리', G5_ADMIN_URL.'/shop_admin/personalpaylist.php', 'odr_personalpay'),
	array('411120', '<i class="fas fa-print"></i> 주문서일괄출력', G5_ADMIN_URL.'/shop_admin/orderprint.php', 'odr_print_order'),	
	array('411150', '<i class="fas fa-upload"></i> 송장Excel일괄등록', G5_ADMIN_URL.'/shop_admin/orderdelivery_EXCEL.php', 'odr_delivery'),
	array('411400', '<i class="fas fa-shopping-basket"></i> 주문내역', G5_ADMIN_URL.'/shop_admin/orderlist.php', 'odr_order', 1),
	array('411401', $treeicon.'전체주문', G5_ADMIN_URL.'/shop_admin/orderlist.php', 'odr_order0', 2),
	array('411402', $treeicon.'오늘의주문'.$linfotoday, G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($left_today).'&to_date='.urlencode($left_today), 'odr_today1', 2),
	
	array('411403', $treeicon.'입금대기'.$linfo1, G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=주문', 'odr_order1', 2),
	array('411404', $treeicon.'결제완료'.$linfo2, G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=입금', 'odr_order2', 2),
	array('411405', $treeicon.'배송준비중'.$linfo3, G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=준비', 'odr_order3', 2),
	array('411406', $treeicon.'배송중'.$linfo4, G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=배송', 'odr_order4', 2),
	array('411407', $treeicon.'배송완료', G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=완료', 'odr_order5', 2),	
	array('411408', $treeicon.'입금전취소', G5_ADMIN_URL.'/shop_admin/orderlist.php?od_cancel_price=Y', 'odr_order6', 2),
	array('411409', $treeicon.'취소/반품/환불/품절', G5_ADMIN_URL.'/shop_admin/orderlist.php?od_status=취소', 'odr_order7', 2)
);
?>