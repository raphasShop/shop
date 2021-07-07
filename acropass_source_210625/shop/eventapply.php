<?php
include_once('./_common.php');

$evt_id = $_GET['evtid'];

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL."/eventapply.php?evtid=".$evt_id));

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/eventapply.php');
    return;
}

include_once(G5_SHOP_PATH.'/_head.php');
$eventapply_skin = G5_SHOP_SKIN_PATH.'/eventapply.skin.php';

if(!file_exists($eventapply_skin)) {
    echo str_replace(G5_PATH.'/', '', $eventapply_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($eventapply_skin);
}

include_once(G5_SHOP_PATH.'/_tail.php');


?>