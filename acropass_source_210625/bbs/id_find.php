<?php
include_once('./_common.php');

if ($is_member) {
    alert("이미 로그인중입니다.");
}

$g5['title'] = '회원정보 찾기';
include_once(G5_PATH.'/head.sub.php');

$action_url = G5_HTTPS_BBS_URL."/id_find2.php";
include_once($member_skin_path.'/id_find.skin.php');

include_once(G5_PATH.'/tail.sub.php');
?>