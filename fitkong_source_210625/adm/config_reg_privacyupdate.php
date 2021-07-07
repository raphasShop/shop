<?php
$sub_menu = '200202'; // 회원가입약관 및 개인정보처리방침
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

// 로그인을 바로 이 주소로 하는 경우 환경설정값이 사라지는 현상을 방지
if (!$_POST['cf_stipulation']) goto_url("./config_reg_privacy.php");

#######################################################################################

//회원가입약관 설정 업데이트 (기본설정 config_form.php에서 하지않고 새로만듦 - 아이스크림)

#######################################################################################

$sql = " update {$g5['config_table']}
            set cf_stipulation = '{$_POST['cf_stipulation']}',
                cf_privacy = '{$_POST['cf_privacy']}'
                ";
sql_query($sql);

goto_url("./config_reg_privacy.php");
?>
