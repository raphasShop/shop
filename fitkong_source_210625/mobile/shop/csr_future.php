<?php
include_once('./_common.php');

include_once(G5_MSHOP_PATH.'/_head.php');
$csr_skin = G5_MSHOP_SKIN_PATH.'/csr_future.skin.php';

if(!file_exists($csr_skin)) {
    echo str_replace(G5_PATH.'/', '', $csr_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($csr_skin);
}

include_once(G5_MSHOP_PATH.'/_tail.php');
?>