<?php
$sub_menu = '111110'; /* 수정전 원본 메뉴코드 400100 */
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

// 대표전화번호 유효성 체크
if(!check_vaild_callback($_POST['de_admin_company_tel']))
    alert('대표전화번호를 올바르게 입력해 주세요.');

// 로그인을 바로 이 주소로 하는 경우 쇼핑몰설정값이 사라지는 현상을 방지
if (!$_POST['de_admin_company_owner']) goto_url("./configform.php");

/* 로고관리페이지 새로 생성 config_logo.php / config_logoupdate.php 파일 확인

if ($_POST['logo_img_del'])  @unlink(G5_DATA_PATH."/common/logo_img");
if ($_POST['logo_img_del2'])  @unlink(G5_DATA_PATH."/common/logo_img2");
if ($_POST['mobile_logo_img_del'])  @unlink(G5_DATA_PATH."/common/mobile_logo_img");
if ($_POST['mobile_logo_img_del2'])  @unlink(G5_DATA_PATH."/common/mobile_logo_img2");

if ($_FILES['logo_img']['name']) upload_file($_FILES['logo_img']['tmp_name'], "logo_img", G5_DATA_PATH."/common");
if ($_FILES['logo_img2']['name']) upload_file($_FILES['logo_img2']['tmp_name'], "logo_img2", G5_DATA_PATH."/common");
if ($_FILES['mobile_logo_img']['name']) upload_file($_FILES['mobile_logo_img']['tmp_name'], "mobile_logo_img", G5_DATA_PATH."/common");
if ($_FILES['mobile_logo_img2']['name']) upload_file($_FILES['mobile_logo_img2']['tmp_name'], "mobile_logo_img2", G5_DATA_PATH."/common");
*/


#######################################################################################

//쇼핑 기본설정 업데이트 (sms문구는 별도페이지로 뺌 - 아이스크림)

#######################################################################################

$sql = " update {$g5['g5_shop_default_table']}
            set de_admin_company_owner        = '{$_POST['de_admin_company_owner']}',
                de_admin_company_name         = '{$_POST['de_admin_company_name']}',
                de_admin_company_saupja_no    = '{$_POST['de_admin_company_saupja_no']}',
                de_admin_company_tel          = '{$_POST['de_admin_company_tel']}',
                de_admin_company_fax          = '{$_POST['de_admin_company_fax']}',
                de_admin_tongsin_no           = '{$_POST['de_admin_tongsin_no']}',
                de_admin_company_zip          = '{$_POST['de_admin_company_zip']}',
                de_admin_company_addr         = '{$_POST['de_admin_company_addr']}',
				de_admin_return_zip           = '{$_POST['de_admin_return_zip']}',
                de_admin_return_addr          = '{$_POST['de_admin_return_addr']}',
                de_admin_info_name            = '{$_POST['de_admin_info_name']}',
                de_admin_info_email           = '{$_POST['de_admin_info_email']}',
				de_admin_open_day             = '{$_POST['de_admin_open_day']}',
				de_admin_open_weekend         = '{$_POST['de_admin_open_weekend']}',
				de_admin_open_lunch           = '{$_POST['de_admin_open_lunch']}',
				de_admin_open_info            = '{$_POST['de_admin_open_info']}',
                de_level_sell                 = '{$_POST['de_level_sell']}',
                de_item_use_use               = '{$_POST['de_item_use_use']}',
                de_item_use_write             = '{$_POST['de_item_use_write']}',
                de_code_dup_use               = '{$_POST['de_code_dup_use']}',
                de_cart_keep_term             = '{$_POST['de_cart_keep_term']}',
                de_guest_cart_use             = '{$_POST['de_guest_cart_use']}',
                de_admin_buga_no              = '{$_POST['de_admin_buga_no']}',
                de_guest_privacy              = '{$_POST['de_guest_privacy']}'
                ";
sql_query($sql);

/* SMS 아이코드 설정
$sql = " update {$g5['config_table']}
            set cf_sms_use              = '{$_POST['cf_sms_use']}',
                cf_sms_type             = '{$_POST['cf_sms_type']}',
                cf_icode_id             = '{$_POST['cf_icode_id']}',
                cf_icode_pw             = '{$_POST['cf_icode_pw']}',
                cf_icode_server_ip      = '{$_POST['cf_icode_server_ip']}',
                cf_icode_server_port    = '{$_POST['cf_icode_server_port']}' ";
sql_query($sql);
*/

goto_url("./configform.php");
?>
