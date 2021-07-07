<?php
$sub_menu = '111110'; /* 새로만듦 */
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

// 로그인을 바로 이 주소로 하는 경우 쇼핑몰설정값이 사라지는 현상을 방지
if (!$_POST['de_sms_cont1']) goto_url("./config_shopping_alim.php");

#######################################################################################

//쇼핑 알림 업데이트 (쇼핑몰알림설정 config_shopping_alim.php - 아이스크림)

#######################################################################################

$sql = " update {$g5['g5_shop_default_table']}
            set de_sms_cont1                  = '{$_POST['de_sms_cont1']}',
                de_sms_cont2                  = '{$_POST['de_sms_cont2']}',
                de_sms_cont3                  = '{$_POST['de_sms_cont3']}',
                de_sms_cont4                  = '{$_POST['de_sms_cont4']}',
                de_sms_cont5                  = '{$_POST['de_sms_cont5']}',
                de_sms_use1                   = '{$_POST['de_sms_use1']}',
                de_sms_use2                   = '{$_POST['de_sms_use2']}',
                de_sms_use3                   = '{$_POST['de_sms_use3']}',
                de_sms_use4                   = '{$_POST['de_sms_use4']}',
                de_sms_use5                   = '{$_POST['de_sms_use5']}',
                de_sms_hp                     = '{$_POST['de_sms_hp']}'
                ";
sql_query($sql);

// SMS 아이코드 설정
$sql = " update {$g5['config_table']}
            set cf_sms_use              = '{$_POST['cf_sms_use']}',
                cf_sms_type             = '{$_POST['cf_sms_type']}',
                cf_icode_id             = '{$_POST['cf_icode_id']}',
                cf_icode_pw             = '{$_POST['cf_icode_pw']}',
                cf_icode_server_ip      = '{$_POST['cf_icode_server_ip']}',
                cf_icode_server_port    = '{$_POST['cf_icode_server_port']}' ";
sql_query($sql);


goto_url("./config_shopping_alim.php");
?>
