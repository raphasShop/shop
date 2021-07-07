<?php
include_once('./_common.php');

if ($is_member) {
    alert_close('이미 로그인중입니다.', G5_URL);
}


$phone = trim($_POST['mb_phone']);
$mb_name = trim($_POST['mb_name']);
$phone = str_replace('-', '', $phone);

$phone_telecom = substr($phone,0,3);
$phone_mid = substr($phone,3,4);
$phone_end = substr($phone,7,4);

$phone_hyphen = $phone_telecom."-".$phone_mid."-".$phone_end;


if (!$phone)
    alert_close('전화번호 오류입니다.');

$sql = " select mb_id, mb_name, mb_hp from {$g5['member_table']} where mb_name = '$mb_name' AND mb_hp = '$phone_hyphen'";
$mb = sql_fetch($sql);
if (!$mb['mb_id'])
    alert('입력하신 이름과 휴대폰번호로 등록된 아이디가 없습니다.');
else if (is_admin($mb['mb_id']))
    alert('관리자 아이디는 접근 불가합니다.');

//----------------------------------------------------------
// 알림톡전송 시작
//----------------------------------------------------------
//echo "<script>console.log( 'Debug Objects: " . $od_status. "' );</script>";
$today = date("Y/m/d");
$last_bank_day = date("Y/m/d", time() + 172800);
$kakao_rcv_number = preg_replace("/[^0-9]/", "", $mb['mb_hp']);

$msg = "[아크로패스] ".$mb['mb_name']."님의 아이디는 ".$mb['mb_id']."입니다.";
$rst = kakaomsg('http://api.apistore.co.kr/kko/1/msg/raphas', array('PHONE'=>$kakao_rcv_number, 'CALLBACK'=>'01024780137', 'MSG'=>$msg, 'TEMPLATE_CODE'=>'AC0008', 'BTN_TYPES'=>'', 'BTN_TXTS'=>''));


//----------------------------------------------------------
// 알림톡전송 끝
//----------------------------------------------------------


alert_close($email.' 입력하신 휴대폰번호로 아이디가 발송 되었습니다.\\n\\n카카오톡 알림톡을 확인하여 주십시오.');
?>
