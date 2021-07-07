<?php
include_once('./_common.php');



$g5['title'] = "로그인 검사";

include_once('./_head.php');
$mb_id       = trim($_POST['mb_id']);
$mb_birth = trim($_POST['mb_birth']);
$mb_email = trim($_POST['mb_email']);

$login_action_url = G5_HTTPS_BBS_URL."/member_reg_result.php";

if (!$mb_id)
    alert('회원아이디를 필수로 입력해주셔야 됩니다.');

if (!$mb_birth && !$mb_email)
    alert('생년월일 또는 이메일 중 하나는 입력해주셔야 됩니다.');

$member_check=0;
$mb = get_member($mb_id);


if(($mb_id == $mb['mb_id']) && ($mb_birth == $mb['mb_birth'])) {
    $member_check = 1;
} 

if(($mb_id == $mb['mb_id']) && ($mb_email == $mb['mb_email'])) {
    $member_check = 1;
} 

if($member_check == 1) {
    $login_file = $member_skin_path.'/membercheck.skin.php';
	if (!file_exists($login_file))
	    $member_skin_path   = G5_SKIN_PATH.'/member/basic';

	include_once($member_skin_path.'/membercheck.skin.php');

	include_once('./_tail.php');
} else {
	alert('입력하신 정보가 올바르지 않습니다.');
}
 



// 로그인 스킨이 없는 경우 관리자 페이지 접속이 안되는 것을 막기 위하여 기본 스킨으로 대체

?>

