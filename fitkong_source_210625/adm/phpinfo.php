<?php
$sub_menu = "999500";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'r');

phpinfo();
?>