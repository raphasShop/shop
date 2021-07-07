<?php
$sub_menu = '100301'; // 메일사용 및 발송설정
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

#######################################################################################

//메일환경 및 메일발송 설정 업데이트 (기본설정 config_form.php에서 하지않고 새로만듦 - 아이스크림)

#######################################################################################

$sql = " update {$g5['config_table']}
            set cf_email_use = '{$_POST['cf_email_use']}',
			    cf_formmail_is_member = '{$_POST['cf_formmail_is_member']}',
				cf_email_wr_super_admin = '{$_POST['cf_email_wr_super_admin']}',
                cf_email_wr_group_admin = '{$_POST['cf_email_wr_group_admin']}',
                cf_email_wr_board_admin = '{$_POST['cf_email_wr_board_admin']}',
                cf_email_wr_write = '{$_POST['cf_email_wr_write']}',
                cf_email_wr_comment_all = '{$_POST['cf_email_wr_comment_all']}',
			    cf_email_po_super_admin = '{$_POST['cf_email_po_super_admin']}',
				cf_email_mb_super_admin = '{$_POST['cf_email_mb_super_admin']}',
                cf_email_mb_member = '{$_POST['cf_email_mb_member']}'
                ";
sql_query($sql);

goto_url("./config_mailsend.php");
?>
