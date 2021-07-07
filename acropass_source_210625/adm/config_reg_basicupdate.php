<?php
$sub_menu = '200201'; // 회원가입항목 및 정책
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

#######################################################################################

//회원가입항목 및 정책 설정 업데이트 (기본설정 config_form.php에서 하지않고 새로만듦 - 아이스크림)

#######################################################################################

$sql = " update {$g5['config_table']}
            set cf_use_email_certify = '{$_POST['cf_use_email_certify']}',
			    cf_member_skin = '{$_POST['cf_member_skin']}',
				cf_mobile_member_skin = '{$_POST['cf_mobile_member_skin']}',
				cf_use_homepage = '{$_POST['cf_use_homepage']}',
                cf_req_homepage = '{$_POST['cf_req_homepage']}',
                cf_use_tel = '{$_POST['cf_use_tel']}',
                cf_req_tel = '{$_POST['cf_req_tel']}',
                cf_use_hp = '{$_POST['cf_use_hp']}',
                cf_req_hp = '{$_POST['cf_req_hp']}',
                cf_use_addr = '{$_POST['cf_use_addr']}',
                cf_req_addr = '{$_POST['cf_req_addr']}',
				cf_use_signature = '{$_POST['cf_use_signature']}',
                cf_req_signature = '{$_POST['cf_req_signature']}',
                cf_use_profile = '{$_POST['cf_use_profile']}',
                cf_req_profile = '{$_POST['cf_req_profile']}',
				cf_register_level = '{$_POST['cf_register_level']}',
                cf_register_point = '{$_POST['cf_register_point']}',
				cf_leave_day = '{$_POST['cf_leave_day']}',
				cf_nick_modify = '{$_POST['cf_nick_modify']}',
				cf_open_modify = '{$_POST['cf_open_modify']}',
				cf_cut_name = '{$_POST['cf_cut_name']}',
				cf_use_member_icon = '{$_POST['cf_use_member_icon']}',
				cf_icon_level = '{$_POST['cf_icon_level']}',
                cf_member_icon_size = '{$_POST['cf_member_icon_size']}',
                cf_member_icon_width = '{$_POST['cf_member_icon_width']}',
                cf_member_icon_height = '{$_POST['cf_member_icon_height']}',
				cf_email_mb_super_admin = '{$_POST['cf_email_mb_super_admin']}',
                cf_email_mb_member = '{$_POST['cf_email_mb_member']}',
				cf_use_recommend = '{$_POST['cf_use_recommend']}',
                cf_recommend_point = '{$_POST['cf_recommend_point']}',
				cf_prohibit_id = '{$_POST['cf_prohibit_id']}',
                cf_prohibit_email = '{$_POST['cf_prohibit_email']}'
                ";
sql_query($sql);

goto_url("./config_reg_basic.php");
?>
