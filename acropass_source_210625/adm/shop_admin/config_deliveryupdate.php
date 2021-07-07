<?php
$sub_menu = '111111'; /* (새로만듬)배송설정 */
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

// 로그인을 바로 이 주소로 하는 경우 쇼핑몰설정값이 사라지는 현상을 방지
//if (!$_POST['de_delivery_company']) goto_url("./config_delivery.php");

#######################################################################################

//배송관련 설정 업데이트 (쇼핑몰설정 configform.php에서 분할되어나옴 - 아이스크림)

#######################################################################################

$sql = " update {$g5['g5_shop_default_table']}
            set de_delivery_company           = '{$_POST['de_delivery_company']}',
                de_send_cost_case             = '{$_POST['de_send_cost_case']}',
                de_send_cost_limit            = '{$_POST['de_send_cost_limit']}',
                de_send_cost_list             = '{$_POST['de_send_cost_list']}',
                de_hope_date_use              = '{$_POST['de_hope_date_use']}',
                de_hope_date_after            = '{$_POST['de_hope_date_after']}',
                de_baesong_content            = '{$_POST['de_baesong_content']}'
                ";
sql_query($sql);

goto_url("./config_delivery.php");
?>
