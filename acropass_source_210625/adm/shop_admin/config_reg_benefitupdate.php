<?php
$sub_menu = '200205'; /* (새로만듬) 회원가입혜택 */
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

// 로그인을 바로 이 주소로 하는 경우 쇼핑몰설정값이 사라지는 현상을 방지
//if (!$_POST['de_admin_return_zip']) goto_url("./config_return.php");

#######################################################################################

//회원가입시혜택 설정 업데이트 (쇼핑몰설정 configform.php에서 분할되어나옴 - 아이스크림)

#######################################################################################

$sql = " update {$g5['g5_shop_default_table']}
            set de_member_reg_coupon_use      = '{$_POST['de_member_reg_coupon_use']}',
                de_member_reg_coupon_term     = '{$_POST['de_member_reg_coupon_term']}',
                de_member_reg_coupon_price    = '{$_POST['de_member_reg_coupon_price']}',
                de_member_reg_coupon_minimum  = '{$_POST['de_member_reg_coupon_minimum']}'
                ";
sql_query($sql);

// 기본환경설정 테이블 업데이트
// (1) 포인트(적립금)
$sql = " update {$g5['config_table']}
            set cf_register_point = '{$_POST['cf_register_point']}'
                ";
sql_query($sql);

goto_url("./config_reg_benefit.php");
?>
