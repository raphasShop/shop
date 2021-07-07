<?php
include_once('./_common.php');

if ($is_member) {
    alert_close('이미 로그인중입니다.', G5_URL);
}

$mb_id = trim($_POST['mb_id']);
$phone = trim($_POST['mb_phone']);
$mb_name = trim($_POST['mb_name']);
$phone = str_replace('-', '', $phone);

$phone_telecom = substr($phone,0,3);
$phone_mid = substr($phone,3,4);
$phone_end = substr($phone,7,4);

$phone_hyphen = $phone_telecom."-".$phone_mid."-".$phone_end;


if (!$phone)
    alert_close('전화번호 오류입니다.');

$sql = " select mb_id, mb_name, mb_hp from {$g5['member_table']} where mb_id = '$mb_id' AND mb_name = '$mb_name' AND mb_hp = '$phone_hyphen'";
$mb = sql_fetch($sql);
if (!$mb['mb_id'])
    alert('입력하신 계정 정보가 정확하지 않습니다.');
else if (is_admin($mb['mb_id']))
    alert('관리자 아이디는 접근 불가합니다.');

// 임시비밀번호 발급
$change_password = rand(100000, 999999);
$mb_password = get_encrypt_string($change_password);

// 어떠한 회원정보도 포함되지 않은 일회용 난수를 생성하여 인증에 사용
//$mb_nonce = md5(pack('V*', rand(), rand(), rand(), rand()));

// 임시비밀번호를 패스워드에 저장
$sql = " update {$g5['member_table']} set mb_password = '$mb_password' where mb_id = '{$mb['mb_id']}' ";
sql_query($sql);

// 인증 링크 생성
//$href = G5_BBS_URL.'/password_lost_certify.php?mb_no='.$mb['mb_no'].'&amp;mb_nonce='.$mb_nonce;

//----------------------------------------------------------
// 알림톡전송 시작
//----------------------------------------------------------
//echo "<script>console.log( 'Debug Objects: " . $od_status. "' );</script>";

$kakao_rcv_number = preg_replace("/[^0-9]/", "", $mb['mb_hp']);

$msg = "[핏콩]\r\n".$mb['mb_name']."님의 임시비밀번호는\r\n".$change_password." 입니다.\r\n로그인 후 비밀번호를 변경하세요.";
$rst = kakaomsg('http://api.apistore.co.kr/kko/1/msg/fitkong', array('PHONE'=>$kakao_rcv_number, 'CALLBACK'=>'01028740137', 'MSG'=>$msg, 'TEMPLATE_CODE'=>'FK0009', 'BTN_TYPES'=>'', 'BTN_TXTS'=>''));


//----------------------------------------------------------
// 알림톡전송 끝
//----------------------------------------------------------


alert($email.' 입력하신 휴대폰번호로 임시비밀번호가 발송 되었습니다.\\n\\n카카오톡 알림톡을 확인하여 주십시오.', G5_BBS_URL.'/login.php');
?>
