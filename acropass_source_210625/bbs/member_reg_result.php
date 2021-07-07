<?php
include_once('./_common.php');



$g5['title'] = "로그인 검사";

include_once('./_head.php');
$mb_id       = trim($_POST['mb_id']);
$mb_pwd = trim($_POST['od_pwd']);
$mb_pwd_re = trim($_POST['od_pwd_re']);

$login_action_url = G5_HTTPS_BBS_URL."/member_reg_result.php";

$member_check = 1;
if (!$mb_id) {
    $error_msg = '회원아이디를 필수로 입력해주셔야 됩니다.';
    $member_check=0;
}

if (!$mb_pwd || !$mb_pwd_re) {
    $error_msg = '비밀번호를 입력해주세요.';
	$member_check=0;
}

if($mb_pwd != $mb_pwd_re) {
    $error_msg = '비밀번호가 일치하지 않습니다.';
    $member_check=0;
}


if($member_check == 1) {
	$sql = "update {$g5['member_table']} set mb_password = '".get_encrypt_string($mb_pwd)."', mb_7 = '1' where mb_id = '$mb_id'";
	$rst = sql_query($sql);
}


$login_file = $member_skin_path.'/memberresult.skin.php';
if (!file_exists($login_file))
    $member_skin_path   = G5_SKIN_PATH.'/member/basic';

include_once($member_skin_path.'/memberresult.skin.php');

include_once('./_tail.php');

 



// 로그인 스킨이 없는 경우 관리자 페이지 접속이 안되는 것을 막기 위하여 기본 스킨으로 대체

?>

