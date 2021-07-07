<?php
$sub_menu = '100102'; // 소셜로그인 설정
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

#######################################################################################

// 소셜로그인 사용 설정 업데이트 (아이스크림)

#######################################################################################

$cf_social_servicelist = !empty($_POST['cf_social_servicelist']) ? implode(',', $_POST['cf_social_servicelist']) : '';

$sql = " update {$g5['config_table']}
            set cf_social_login_use     = '{$_POST['cf_social_login_use']}',
			    cf_social_servicelist   =   '{$cf_social_servicelist}',
				cf_naver_clientid = '{$_POST['cf_naver_clientid']}',
                cf_naver_secret = '{$_POST['cf_naver_secret']}',
				cf_facebook_appid = '{$_POST['cf_facebook_appid']}',
                cf_facebook_secret = '{$_POST['cf_facebook_secret']}',
				cf_twitter_key = '{$_POST['cf_twitter_key']}',
                cf_twitter_secret = '{$_POST['cf_twitter_secret']}',
				cf_google_clientid = '{$_POST['cf_google_clientid']}',
                cf_google_secret = '{$_POST['cf_google_secret']}',
                cf_kakao_rest_key = '{$_POST['cf_kakao_rest_key']}',
                cf_kakao_client_secret = '{$_POST['cf_kakao_client_secret']}',
				cf_payco_clientid = '{$_POST['cf_payco_clientid']}',
                cf_payco_secret = '{$_POST['cf_payco_secret']}'
				
                ";
sql_query($sql);

goto_url("./config_login.php");
?>
