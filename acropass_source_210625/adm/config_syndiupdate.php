<?php
$sub_menu = '100104'; // 네이버신디케이션
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();


#####################################################################

// 네이버신디케이션 설정 업데이트 (아이스크림)

#####################################################################

$sql = " update {$g5['config_table']}
            set cf_syndi_token = '{$_POST['cf_syndi_token']}',
                cf_syndi_except = '{$_POST['cf_syndi_except']}'
                ";
sql_query($sql);

goto_url("./config_syndi.php");
?>
