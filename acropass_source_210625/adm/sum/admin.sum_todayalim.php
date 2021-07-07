<?php
if (!defined('_GNUBOARD_')) exit;

#######################################################################################
/* 오늘 발생한 일만 안내 / 주문, 승인 및 답변, 재고확인등 처리해야 할 알림 정보 */
// 아이스크림 소스
// 삽입함수 include_once(G5_ADMIN_PATH.'/sum/admin.sum_todayalim.php');
// 오늘 발생한 일중 주문확인/승인/답변완료된것들은 확인된것으로 처리되서 알림건수에서 제외됨
// 모든 페이지에 표시됩니다. admin.head.php
#######################################################################################
	
// 기간/일자 추출 함수 (*관리자메인페이지에도 적용되는 공통함수임)
/*
adm/admin.sum_alim.php 파일에 정의된 기간설정함수를 그대로 사용합니다.
중복사용하는 경우 코드가 꼬일수 있어서, 한개의 파일에만 기간설정함수를 설정.
오늘것만 하게되면, 밤12시이후 갑자기 건수가 사라질수가 있어서
어제것까지 합계건수 표시되게 함
*/

// 오늘의 주문 알림 (주문/입금된 오늘 주문건만 알림표시 - 준비중으로 변경되면 자동으로 건수에서 차감됨)
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_status IN ( '주문', '입금' ) and od_time between '$yesterday 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $toalim_order = array();
    $toalim_order['count'] = (int)$row['cnt'];
    $toalim_order['price'] = (int)$row['price'];
    $toalim_order['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($today).'&to_date='.urlencode($today);

// 오늘의 1:1상담 알림 - 오늘 등록된 1:1상담 중 관리자가 답변안한 레코드수만 얻음
    $sql = " select count(*) as cnt from {$g5['qa_content_table']} where qa_status ='0' and qa_datetime between '$yesterday 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $toalim_1to1 = array();
    $toalim_1to1['count'] = (int)$row['cnt'];

// 오늘의 입금확인요청 알림 - 오늘 등록된 입금확인요청 중 관리자가 승인안한 레코드수만 얻음
    $sql = " select count(*) as cnt from {$g5['g5_shop_order_atmcheck_table']} where id_confirm ='0' and id_time between '$yesterday 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $toalim_atm = array();
    $toalim_atm['count'] = (int)$row['cnt'];

// 오늘의 상품Q&A 알림 - 오늘 등록된 상품Q&A 중 관리자가 답변안한 레코드수만 얻음
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_qa_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id = b.it_id) left join {$g5['member_table']} c on (a.mb_id = c.mb_id) where iq_answer ='' and iq_time between '$yesterday 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $toalim_itemqa = array();
    $toalim_itemqa['count'] = (int)$row['cnt'];

// 오늘의 사용후기 알림 - 오늘 등록된 사용후기 중 관리자가 승인안한 레코드수만 얻음
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_use_table']} where is_confirm != '1' and is_time between '$yesterday 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $toalim_itemuse = array();
    $toalim_itemuse['count'] = (int)$row['cnt'];

// 오늘의 PG사결제 미완료(주문에러) 목록(장바구니CART번호가 공란이아니면 표시) - 오늘 미완료 레코드수만 얻음
    $sql = " select count(*) as cnt from {$g5['g5_shop_order_data_table']} where cart_id <> '0' and dt_time between '$yesterday 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $toalim_pgerror = array();
    $toalim_pgerror['count'] = (int)$row['cnt'];
	// 링크주소샘플 /adm/shop_admin/inorderform.php?od_id=2017092312023398
	
// 오늘의 개인결제 결제완료 - 고객이 개인결제를 완료한 레코드수만 얻음
    $sql = " select count(*) as cnt, sum(pp_price - pp_receipt_price) as price from {$g5['g5_shop_personalpay_table']} where pp_receipt_price > '0' and pp_use = '1' and pp_receipt_time between '$today 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $toalim_ppay = array();
    $toalim_ppay['count'] = (int)$row['cnt'];
	$toalim_ppay['price'] = (int)$row['price'];	





/* 오늘알림 총 건수 표시 */
$todayalim_all = $toalim_order['count'] +  $toalim_1to1['count'] + $toalim_atm['count'] + $toalim_itemqa['count'] + $toalim_itemuse['count'] + $toalim_pgerror['count'] + $toalim_ppay['count']; 
//주문/입금 + 1:1상담 + 입금확인요청 + 상품Q&A + 사용후기 + PG사결제미완료 + 개인결제완료분
			
#####################################################################################
?>