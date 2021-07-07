<?php
include_once('./_common.php');

if ($is_member) {
    alert("이미 로그인중입니다.");
}

$g5['title'] = '회원정보 찾기';
include_once('./_head.php');
include_once('./_head.sub.php');

$url = $_SERVER['REQUEST_URI'];

// url 체크
check_url_host($url);

$action_url = G5_HTTPS_BBS_URL."/id_find2.php";
include_once($member_skin_path.'/id_find.skin.php');

include_once('./_tail.php');
//include_once(G5_PATH.'/tail.sub.php');
?>