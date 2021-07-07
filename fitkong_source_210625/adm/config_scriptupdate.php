<?php
$sub_menu = '155202'; // 레이아웃추가설정,script/css 추가
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

#######################################################################################

//레이아웃추가설정,script/css 추가 설정 업데이트 (기본설정 config_form.php에서 하지않고 새로만듦 - 아이스크림)

#######################################################################################

$sql = " update {$g5['config_table']}
            set cf_add_script = '{$_POST['cf_add_script']}'
                ";
sql_query($sql);

goto_url("./config_script.php");
?>
