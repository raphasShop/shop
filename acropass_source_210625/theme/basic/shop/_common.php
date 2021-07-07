<?php
include_once('../../../common.php');
include_once('../../../icecream/common.icecream.php'); // 아이스크림전용 common 변수 추가

if (isset($_REQUEST['sort']))  {
    $sort = trim($_REQUEST['sort']);
    $sort = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $sort);
} else {
    $sort = '';
}

if (isset($_REQUEST['sortodr']))  {
    $sortodr = preg_match("/^(asc|desc)$/i", $sortodr) ? $sortodr : '';
} else {
    $sortodr = '';
}

if (!defined('G5_USE_SHOP') || !G5_USE_SHOP)
    die('<p>쇼핑몰 설치 후 이용해 주십시오.</p>');

define('_SHOP_', true);
?>