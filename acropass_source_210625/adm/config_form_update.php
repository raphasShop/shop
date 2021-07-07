<?php
$sub_menu = "100100";
include_once('./_common.php');

#######################################################################################

// 환경설정에서 따로 페이지로 빼놓은것들이 있습니다
// 로고관리/본인확인/sns/네이버신디케이션 등 은 별도 페이지로 뺌

#######################################################################################

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$mb = get_member($cf_admin);
if (!$mb['mb_id'])
    alert('최고관리자 회원아이디가 존재하지 않습니다.');

check_admin_token();

$sql = " update {$g5['config_table']}
            set cf_title = '{$_POST['cf_title']}',
                cf_admin = '{$_POST['cf_admin']}',
                cf_admin_email = '{$_POST['cf_admin_email']}',
                cf_admin_email_name = '{$_POST['cf_admin_email_name']}',
                cf_use_point = '{$_POST['cf_use_point']}',
                cf_point_term = '{$_POST['cf_point_term']}',
                cf_login_point = '{$_POST['cf_login_point']}',
                cf_new_skin = '{$_POST['cf_new_skin']}',
                cf_search_skin = '{$_POST['cf_search_skin']}',
                cf_connect_skin = '{$_POST['cf_connect_skin']}',
                cf_faq_skin = '{$_POST['cf_faq_skin']}',
                cf_new_del = '{$_POST['cf_new_del']}',
                cf_memo_del = '{$_POST['cf_memo_del']}',
                cf_visit_del = '{$_POST['cf_visit_del']}',
                cf_popular_del = '{$_POST['cf_popular_del']}',
                cf_login_minutes = '{$_POST['cf_login_minutes']}',
                cf_memo_send_point = '{$_POST['cf_memo_send_point']}',
                cf_mobile_new_skin = '{$_POST['cf_mobile_new_skin']}',
                cf_mobile_search_skin = '{$_POST['cf_mobile_search_skin']}',
                cf_mobile_connect_skin = '{$_POST['cf_mobile_connect_skin']}',
                cf_mobile_faq_skin = '{$_POST['cf_mobile_faq_skin']}',
                cf_sms_use = '{$_POST['cf_sms_use']}',
                cf_sms_type = '{$_POST['cf_sms_type']}',
                cf_icode_id = '{$_POST['cf_icode_id']}',
                cf_icode_pw = '{$_POST['cf_icode_pw']}',
                cf_icode_server_ip = '{$_POST['cf_icode_server_ip']}',
                cf_icode_server_port = '{$_POST['cf_icode_server_port']}',
                cf_1_subj = '{$_POST['cf_1_subj']}',
                cf_2_subj = '{$_POST['cf_2_subj']}',
                cf_3_subj = '{$_POST['cf_3_subj']}',
                cf_4_subj = '{$_POST['cf_4_subj']}',
                cf_5_subj = '{$_POST['cf_5_subj']}',
                cf_6_subj = '{$_POST['cf_6_subj']}',
                cf_7_subj = '{$_POST['cf_7_subj']}',
                cf_8_subj = '{$_POST['cf_8_subj']}',
                cf_9_subj = '{$_POST['cf_9_subj']}',
                cf_10_subj = '{$_POST['cf_10_subj']}',
                cf_1 = '{$_POST['cf_1']}',
                cf_2 = '{$_POST['cf_2']}',
                cf_3 = '{$_POST['cf_3']}',
                cf_4 = '{$_POST['cf_4']}',
                cf_5 = '{$_POST['cf_5']}',
                cf_6 = '{$_POST['cf_6']}',
                cf_7 = '{$_POST['cf_7']}',
                cf_8 = '{$_POST['cf_8']}',
                cf_9 = '{$_POST['cf_9']}',
                cf_10 = '{$_POST['cf_10']}' ";
sql_query($sql);

//sql_query(" OPTIMIZE TABLE `$g5[config_table]` ");

goto_url('./config_form.php', false);
?>