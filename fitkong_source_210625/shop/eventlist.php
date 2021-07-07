<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/eventlist.php');
    return;
}

include_once(G5_SHOP_PATH.'/_head.php');
$eventlist_skin = G5_SHOP_SKIN_PATH.'/eventlist.skin.php';

if(!file_exists($eventlist_skin)) {
    echo str_replace(G5_PATH.'/', '', $eventlist_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($eventlist_skin);
}

include_once(G5_SHOP_PATH.'/_tail.php');


?>