<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/brandstory.php');
    return;
}

include_once(G5_SHOP_PATH.'/_head.php');
$brandstory_skin = G5_SHOP_SKIN_PATH.'/brandstory.skin.php';

if(!file_exists($brandstory_skin)) {
    echo str_replace(G5_PATH.'/', '', $brandstory_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($brandstory_skin);
}

include_once(G5_SHOP_PATH.'/_tail.php');


?>