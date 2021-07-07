<?php
include_once('./_common.php');

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL."/mypage.php"));

$month_f = $_GET['month'];
$ps_f = $_GET['ps'];

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/orderlist.php');
    return;
}

include_once(G5_SHOP_PATH.'/_head.php');
$orderlist_skin = G5_SHOP_SKIN_PATH.'/orderlist.skin.php';

if(!file_exists($orderlist_skin)) {
    echo str_replace(G5_PATH.'/', '', $orderlist_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($orderlist_skin);
}

include_once(G5_SHOP_PATH.'/_tail.php');


?>