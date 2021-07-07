<?php
$sub_menu = '400800'; /* 수정전 원본 메뉴코드 400810 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

$_POST = array_map('trim', $_POST);


$sql_common = " ex_coupon_use  = '{$_POST['cf_use_coupon']}' ";

$sql = " update {$g5['config_table']}
                set $sql_common ";
sql_query($sql);



goto_url('./couponuse.php?'.$qstr);
?>