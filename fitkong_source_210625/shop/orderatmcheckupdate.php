<?php
//if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once('./_common.php');

$g5['title'] = '입금확인요청완료';

//데이터 공백제거 <!--
$od_id            = trim($_REQUEST['od_id']);
$id_subject       = trim($_POST['id_subject']);
$od_bank_account  = trim($_POST['od_bank_account']);
$id_deposit_name  = trim($_POST['id_deposit_name']);
$id_money         = trim($_POST['id_money']);
$id_deposit_date  = trim($_POST['id_deposit_date']);
$id_name          = trim($_POST['id_name']);
// -->

 $sql = " select * from {$g5['g5_shop_order_atmcheck_table']} where od_id = '$od_id' ";
 $check_row = sql_fetch($sql);
 if($check_row['od_id'] == $od_id) {
       alert_close('이미 입금확인요청하셨습니다\n입금확인요청은 1회만 가능합니다');
 } else {
	
	//추가한 테이블을 $g5포함한 접두사로 설정해야함 ( data/dbconfig.php 파일에서 테이블 접두어 추가하기 )
    $tmp_row = sql_fetch(" select max(id_id) as max_id_id from {$g5['g5_shop_order_atmcheck_table']} ");
    $id_id = $tmp_row['max_id_id'] + 1;
    $sql = "insert {$g5['g5_shop_order_atmcheck_table']}
               set od_id = '$od_id',
			       it_id = '$it_id',
                   mb_id = '{$member['mb_id']}',
                   id_name = '$id_name',
                   id_subject = '$id_subject',
				   od_bank_account = '$od_bank_account',
				   id_deposit_name = '$id_deposit_name',
				   id_money = '$id_money',
				   id_deposit_date = '$id_deposit_date',
                   id_time = '".G5_TIME_YMDHIS."',
                   id_confirm = '0',
				   id_ip = '{$_SERVER['REMOTE_ADDR']}'
				   "; // 

    sql_query($sql);

    $id_id = sql_insert_id();
	
	alert_close('입금확인되면 주문/배송조회에서\n상태가 입금 또는 준비로 변경됩니다\n\n주문시 기재한 이메일로도 발송됩니다\n\n주문/배송조회와 이메일로 확인하세요');
	
 }
    
?>