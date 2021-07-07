<?php
$sub_menu = '100101'; // 게시판기본환경 설정
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

#######################################################################################

//게시판기본환경 설정 업데이트 (기본설정 config_form.php에서 하지않고 새로만듦 - 아이스크림)

#######################################################################################

$sql = " update {$g5['config_table']}
            set cf_delay_sec = '{$_POST['cf_delay_sec']}',
			    cf_link_target = '{$_POST['cf_link_target']}',
				cf_read_point = '{$_POST['cf_read_point']}',
                cf_write_point = '{$_POST['cf_write_point']}',
                cf_comment_point = '{$_POST['cf_comment_point']}',
                cf_download_point = '{$_POST['cf_download_point']}',
				cf_search_part = '{$_POST['cf_search_part']}',
				cf_image_extension = '{$_POST['cf_image_extension']}',
                cf_flash_extension = '{$_POST['cf_flash_extension']}',
                cf_movie_extension = '{$_POST['cf_movie_extension']}',
				cf_filter = '{$_POST['cf_filter']}',
				cf_email_wr_super_admin = '{$_POST['cf_email_wr_super_admin']}',
                cf_email_wr_group_admin = '{$_POST['cf_email_wr_group_admin']}',
                cf_email_wr_board_admin = '{$_POST['cf_email_wr_board_admin']}',
                cf_email_wr_write = '{$_POST['cf_email_wr_write']}',
                cf_email_wr_comment_all = '{$_POST['cf_email_wr_comment_all']}',
				cf_new_rows = '{$_POST['cf_new_rows']}',
				cf_page_rows = '{$_POST['cf_page_rows']}',
				cf_write_pages = '{$_POST['cf_write_pages']}',
				cf_mobile_page_rows = '{$_POST['cf_mobile_page_rows']}',
                cf_mobile_pages = '{$_POST['cf_mobile_pages']}',
				cf_editor = '{$_POST['cf_editor']}',
				cf_captcha_mp3 = '{$_POST['cf_captcha_mp3']}',
				cf_captcha = '{$_POST['cf_captcha']}',
                cf_recaptcha_site_key = '{$_POST['cf_recaptcha_site_key']}',
                cf_recaptcha_secret_key   =   '{$_POST['cf_recaptcha_secret_key']}',
				cf_use_copy_log = '{$_POST['cf_use_copy_log']}'
				
                ";
sql_query($sql);

goto_url("./config_board.php");
?>
