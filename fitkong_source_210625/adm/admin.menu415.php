<?php
if (!defined('G5_USE_SHOP') || !G5_USE_SHOP) return;
// 소메뉴그룹의 하위메뉴표시 아이콘은 $treeicon 으로 정의
// $treeicon 이 정의한 이미지아이콘을 변경하려면 admin.menu100.php 파일에서 수정하세요
#################################################################################################################
// 기간설정을 위한 기초문
/* 유의사항 : orderlist.php / sale1.php 파일에도 쓰이는 기초문으로 같은 명령어에 내용이 달라지면 DB문제가 발생하므로
              같은 명령내용이지만, 명령어 함수를 다르게 변경함 (실제예) $date_term -> $left_date_term 함수 맨앞에 left_ 추가
*/
$left_date_term = date('w', G5_SERVER_TIME); // 일단위
$left_week_term = $date_term + 7; //일주일단위
$left_last_term = strtotime(date('Y-m-01', G5_SERVER_TIME)); // 매월 1일 기준
$left_month_term = strtotime(date('Y-m-d', G5_SERVER_TIME)); // 매월 오늘날짜 기준
$left_year_term = strtotime(date('Y-01-01', G5_SERVER_TIME)); // 매년 1월 기준

$menu['menu415'] = array (
    array('415000', '매 출', G5_ADMIN_URL.'/shop_admin/sale1.php', 'sales_config'),
	array('415100', '<i class="fa fa-line-chart"></i> 매출현황', G5_ADMIN_URL.'/shop_admin/sale1.php', 'sales_stats'),
	
	array('415160a', '<i class="far fa-bar-chart"></i> 입금현황', G5_ADMIN_URL.'/shop_admin/sale1receiptdate.php?fr_receipt_date='.date("Y-m-d", strtotime('-1 Month', $left_month_term)).'&to_receipt_date='.date("Y-m-d", G5_SERVER_TIME), 'receipt', 1),
	array('415160', $treeicon.'일별입금현황표', G5_ADMIN_URL.'/shop_admin/sale1receiptdate.php?fr_receipt_date='.date("Y-m-d", strtotime('-1 Month', $left_month_term)).'&to_receipt_date='.date("Y-m-d", G5_SERVER_TIME), 'receipt_date', 2),
	array('415170', $treeicon.'월별입금현황표', G5_ADMIN_URL.'/shop_admin/sale1receiptmonth.php?fr_receipt_month='.date('Y-m', strtotime('-12 Month', $left_last_term)).'&to_receipt_month='.date("Ym", G5_SERVER_TIME), 'receipt_month', 2),
	array('415180', $treeicon.'일일입금현황표', G5_ADMIN_URL.'/shop_admin/sale1receipttoday.php?receipt_date='.date("Y-m-d", G5_SERVER_TIME), 'receipt_today', 2),
	
	array('415120a', '<i class="far fa-bar-chart"></i> 매출표', G5_ADMIN_URL.'/shop_admin/sale1date.php?fr_date='.date("Y-m-d", strtotime('-1 Month', $left_month_term)).'&to_date='.date("Y-m-d", G5_SERVER_TIME), 'sales', 1),
	array('415120', $treeicon.'일별매출표', G5_ADMIN_URL.'/shop_admin/sale1date.php?fr_date='.date("Y-m-d", strtotime('-1 Month', $left_month_term)).'&to_date='.date("Y-m-d", G5_SERVER_TIME), 'sales_date', 2),
	array('415130', $treeicon.'월별매출표', G5_ADMIN_URL.'/shop_admin/sale1month.php?fr_month='.date('Y-m', strtotime('-12 Month', $left_last_term)).'&to_month='.date("Ym", G5_SERVER_TIME), 'sales_month', 2),
	array('415140', $treeicon.'연간매출표', G5_ADMIN_URL.'/shop_admin/sale1year.php?fr_year='.date("Y", strtotime('-10 Year', $left_year_term)).'&to_year='.date("Y", G5_SERVER_TIME), 'sales_year', 2),
	array('415110', $treeicon.'일일매출표', G5_ADMIN_URL.'/shop_admin/sale1today.php?date='.date("Y-m-d", G5_SERVER_TIME), 'sales_today', 2),
	
	array('415310a', '<i class="far fa-bar-chart"></i> 매출성향', G5_ADMIN_URL.'/shop_admin/sale2item.php', 'sales_item', 1),
	array('415310', $treeicon.'상품별매출표', G5_ADMIN_URL.'/shop_admin/sale2item.php', 'sales_item', 2)
	
	// 판매순위표, 회원구매순위표,  PC/모바일매출분석, 시간대별매출표, 요일별매출표
);
?>