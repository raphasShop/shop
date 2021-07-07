<?php
include_once('./_common.php');

include_once(G5_MSHOP_PATH.'/_head.php');
$community_skin = G5_MSHOP_SKIN_PATH.'/community.skin.php';

if(!file_exists($community_skin)) {
    echo str_replace(G5_PATH.'/', '', $community_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($community_skin);
}

include_once(G5_MSHOP_PATH.'/_tail.php');
?>