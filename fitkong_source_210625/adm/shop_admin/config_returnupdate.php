<?php
$sub_menu = '111113'; /* (새로만듬)반품/교환/환불설정 */
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

// 로그인을 바로 이 주소로 하는 경우 쇼핑몰설정값이 사라지는 현상을 방지
//if (!$_POST['de_admin_return_zip']) goto_url("./config_return.php");

#######################################################################################

//교환,반품 설정 업데이트 (쇼핑몰설정 configform.php에서 분할되어나옴 - 아이스크림)

#######################################################################################

$sql = " update {$g5['g5_shop_default_table']}
            set de_admin_return_zip           = '{$_POST['de_admin_return_zip']}',
                de_admin_return_addr          = '{$_POST['de_admin_return_addr']}',
                de_change_content             = '{$_POST['de_change_content']}'
                ";
sql_query($sql);

goto_url("./config_return.php");
?>
