<?php
$sub_menu = '100102'; // 소셜로그인 설정
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '소셜로그인설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');
/*
$pg_anchor = '<ul class="anchor">
<li><a href="#anc_ch_basic">기본설정</a></li>
<li><a href="#anc_ch_market">추천쇼핑몰관리</a></li>
</ul>';
*/
$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

// 구글 짧은 주소 테이블 추가
if(!isset($config['cf_googl_shorturl_apikey'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_googl_shorturl_apikey` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_captcha_mp3` ", true);
}
// 페이스북
if(!isset($config['cf_facebook_appid'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_facebook_appid` VARCHAR(255) NOT NULL AFTER `cf_googl_shorturl_apikey`,
                    ADD `cf_facebook_secret` VARCHAR(255) NOT NULL AFTER `cf_facebook_appid`,
                    ADD `cf_twitter_key` VARCHAR(255) NOT NULL AFTER `cf_facebook_secret`,
                    ADD `cf_twitter_secret` VARCHAR(255) NOT NULL AFTER `cf_twitter_key` ", true);
}
// 카카오톡링크 api 키
if(!isset($config['cf_kakao_js_apikey'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_kakao_js_apikey` varchar(255) NOT NULL DEFAULT '' AFTER `cf_googl_shorturl_apikey` ", true);
}

//소셜 로그인 관련 필드 및 구글 리챕챠 필드 추가
if(!isset($config['cf_social_login_use'])) {
    sql_query("ALTER TABLE `{$g5['config_table']}`
                ADD `cf_social_login_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `cf_googl_shorturl_apikey`,
                ADD `cf_google_clientid` varchar(100) NOT NULL DEFAULT '' AFTER `cf_twitter_secret`,
                ADD `cf_google_secret` varchar(100) NOT NULL DEFAULT '' AFTER `cf_google_clientid`,
                ADD `cf_naver_clientid` varchar(100) NOT NULL DEFAULT '' AFTER `cf_google_secret`,
                ADD `cf_naver_secret` varchar(100) NOT NULL DEFAULT '' AFTER `cf_naver_clientid`,
                ADD `cf_kakao_rest_key` varchar(100) NOT NULL DEFAULT '' AFTER `cf_naver_secret`,
                ADD `cf_social_servicelist` varchar(255) NOT NULL DEFAULT '' AFTER `cf_social_login_use`,
                ADD `cf_payco_clientid` varchar(100) NOT NULL DEFAULT '' AFTER `cf_social_servicelist`,
                ADD `cf_payco_secret` varchar(100) NOT NULL DEFAULT '' AFTER `cf_payco_clientid`,
                ADD `cf_captcha` varchar(100) NOT NULL DEFAULT '' AFTER `cf_kakao_js_apikey`,
                ADD `cf_recaptcha_site_key` varchar(100) NOT NULL DEFAULT '' AFTER `cf_captcha`,
                ADD `cf_recaptcha_secret_key` varchar(100) NOT NULL DEFAULT '' AFTER `cf_recaptcha_site_key`
    ", true);
}

//소셜 로그인 관련 필드 카카오 클라이언트 시크릿 추가
if(!isset($config['cf_kakao_client_secret'])) {
    sql_query("ALTER TABLE `{$g5['config_table']}`
                ADD `cf_kakao_client_secret` varchar(100) NOT NULL DEFAULT '' AFTER `cf_kakao_rest_key`
    ", true);
}

// 소셜 로그인 관리 테이블 없을 경우 생성
if(!sql_query(" DESC {$g5['social_profile_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['social_profile_table']}` (
                  `mp_no` int(11) NOT NULL AUTO_INCREMENT,
                  `mb_id` varchar(255) NOT NULL DEFAULT '',
                  `provider` varchar(50) NOT NULL DEFAULT '',
                  `object_sha` varchar(45) NOT NULL DEFAULT '',
                  `identifier` varchar(255) NOT NULL DEFAULT '',
                  `profileurl` varchar(255) NOT NULL DEFAULT '',
                  `photourl` varchar(255) NOT NULL DEFAULT '',
                  `displayname` varchar(150) NOT NULL DEFAULT '',
                  `description` varchar(255) NOT NULL DEFAULT '',
                  `mp_register_day` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  `mp_latest_day` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                  UNIQUE KEY `mp_no` (`mp_no`),
                  KEY `mb_id` (`mb_id`),
                  KEY `provider` (`provider`)
                ) ", true);
}

?>

<form name="fconfigform" action="./config_loginupdate.php" onsubmit="return fconfigform_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="" id="token">

<!-- 소셜로그인 연동설정 { -->
<section id="anc_cf_login">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">소셜로그인 사용 설정 <a href="https://sir.kr/manual/g5/276" class="btn_frmline" target="_blank" style="margin-left:10px; font-size:12px;" > 소셜로그인 설정 메뉴얼 보기 </a></h2>
    <div class="local_desc02 local_desc">
        <p>회원가입하지 않고, 사용하고있는 포털/SNS 아이디로 로그인할 수 있는 서비스입니다.</p>
        <p><strong>네이버,카카오,페이스북,구글,트위터,페이코 아이디로 로그인</strong> : 해당 서비스를 이용하려면 해당사이트에서 로그인 API 키를 받으시면 됩니다</p>
        <p><span class="info_navi_link">환경설정 &gt; 외부연동서비스 &gt; API키값등록에서도 동일하게 등록</span>할 수 있습니다</p>
        </p>
    </div>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>소셜네트워크서비스 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_social_login_use">소셜로그인 사용</label></th>
            <td>
                <?php echo help('소셜로그인을 사용합니다.') ?>
                <label class="switch-check">
                <input type="checkbox" name="cf_social_login_use" value="1" id="cf_social_login_use" <?php echo (!empty($config['cf_social_login_use']))?'checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
            </td>
        </tr>
        <tr>
            <th colspan="2" class="titletag">NAVER</th>
        </tr>
        <tr>
            <th scope="row">사용여부</th>
            <td>
                <label class="switch-check">
                <input type="checkbox" name="cf_social_servicelist[]" id="check_social_naver" value="naver" <?php echo option_array_checked('naver', $config['cf_social_servicelist']); ?> >
                <div class="check-slider round"></div>
                </label>
                
                <label for="check_social_naver">네이버 로그인을 사용합니다</label>
            </td>
        </tr>
        <tr>
            <th scope="row" class="font-normal">네이버 CallbackURL</th>
            <td>
                <?php echo get_social_callbackurl('naver'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_naver_clientid">네이버 Client ID</label></th>
            <td>
                <input type="text" name="cf_naver_clientid" value="<?php echo $config['cf_naver_clientid'] ?>" id="cf_naver_clientid" class="frm_input"> <a href="https://developers.naver.com/apps/#/register" target="_blank" class="btn_frmline">앱 등록하기</a>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_naver_secret">네이버 Client Secret</label></th>
            <td>
                <input type="text" name="cf_naver_secret" value="<?php echo $config['cf_naver_secret'] ?>" id="cf_naver_secret" class="frm_input w100per" size="45">
            </td>
        </tr>
        <tr>
            <th colspan="2" class="titletag">FACE BOOK</th>
        </tr>
        <tr>
            <th scope="row">사용여부</th>
            <td>
                <label class="switch-check">
                <input type="checkbox" name="cf_social_servicelist[]" id="check_social_facebook" value="facebook" <?php echo option_array_checked('facebook', $config['cf_social_servicelist']); ?> >
                <div class="check-slider round"></div>
                </label>
                <label for="check_social_facebook">페이스북 로그인을 사용합니다</label>
            </td>
        </tr>
        <tr>
            <th scope="row" class="font-normal">페이스북 유효한 OAuth 리디렉션 URI</th>
            <td>
                <?php echo get_social_callbackurl('facebook'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_facebook_appid">페이스북 앱 ID</label></th>
            <td>
                <input type="text" name="cf_facebook_appid" value="<?php echo $config['cf_facebook_appid'] ?>" id="cf_facebook_appid" class="frm_input"> <a href="https://developers.facebook.com/apps" target="_blank" class="btn_frmline">앱 등록하기</a>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_facebook_secret">페이스북 앱 Secret</label></th>
            <td>
                <input type="text" name="cf_facebook_secret" value="<?php echo $config['cf_facebook_secret'] ?>" id="cf_facebook_secret" class="frm_input w100per">
            </td>
        </tr>
        <tr>
            <th colspan="2" class="titletag">Twitter</th>
        </tr>
        <tr>
            <th scope="row">사용여부</th>
            <td>
                <label class="switch-check">
                <input type="checkbox" name="cf_social_servicelist[]" id="check_social_twitter" value="twitter" <?php echo option_array_checked('twitter', $config['cf_social_servicelist']); ?> >
                <div class="check-slider round"></div>
                </label>
                <label for="check_social_twitter">트위터 로그인을 사용합니다</label>
            </td>
        </tr>
        <tr>
            <th scope="row" class="font-normal">트위터 CallbackURL</th>
            <td>
                <?php echo get_social_callbackurl('twitter'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_twitter_key">트위터 컨슈머 Key</label></th>
            <td>
                <input type="text" name="cf_twitter_key" value="<?php echo $config['cf_twitter_key'] ?>" id="cf_twitter_key" class="frm_input"> <a href="https://dev.twitter.com/apps" target="_blank" class="btn_frmline">앱 등록하기</a>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_twitter_secret">트위터 컨슈머 Secret</label></th>
            <td>
                <input type="text" name="cf_twitter_secret" value="<?php echo $config['cf_twitter_secret'] ?>" id="cf_twitter_secret" class="frm_input w100per">
            </td>
        </tr>
        <tr>
            <th colspan="2" class="titletag">Google</th>
        </tr>
        <tr>
            <th scope="row">사용여부</th>
            <td>
                <label class="switch-check">
                <input type="checkbox" name="cf_social_servicelist[]" id="check_social_google" value="google" <?php echo option_array_checked('google', $config['cf_social_servicelist']); ?> >
                <div class="check-slider round"></div>
                </label>
                <label for="check_social_google">구글 로그인을 사용합니다</label>
            </td>
        </tr>
        <tr>
            <th scope="row" class="font-normal">구글 승인된 리디렉션 URI</th>
            <td>
                <?php echo get_social_callbackurl('google'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_google_clientid">구글 Client ID</label></th>
            <td>
                <input type="text" name="cf_google_clientid" value="<?php echo $config['cf_google_clientid'] ?>" id="cf_google_clientid" class="frm_input"> <a href="https://console.developers.google.com" target="_blank" class="btn_frmline">앱 등록하기</a>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_google_secret">구글 Client Secret</label></th>
            <td>
                <input type="text" name="cf_google_secret" value="<?php echo $config['cf_google_secret'] ?>" id="cf_google_secret" class="frm_input w100per">
            </td>
        </tr>
        <tr>
            <th colspan="2" class="titletag">KAKAO</th>
        </tr>
        <tr>
            <th scope="row">사용여부</th>
            <td>
                <label class="switch-check">
                <input type="checkbox" name="cf_social_servicelist[]" id="check_social_kakao" value="kakao" <?php echo option_array_checked('kakao', $config['cf_social_servicelist']); ?> >
                <div class="check-slider round"></div>
                </label>
                <label for="check_social_kakao">카카오 로그인을 사용합니다</label>
            </td>
        </tr>
        <tr>
            <th scope="row" class="font-normal">카카오 웹 Redirect Path</th>
            <td>
                <?php echo get_social_callbackurl('kakao', true); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_kakao_rest_key">카카오 REST API 키</label></th>
            <td>
                <input type="text" name="cf_kakao_rest_key" value="<?php echo $config['cf_kakao_rest_key'] ?>" id="cf_kakao_rest_key" class="frm_input"> <a href="https://developers.kakao.com/apps/new" target="_blank" class="btn_frmline">앱 등록하기</a>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_kakao_client_secret">카카오 Client Secret</label></th>
            <td>
                <input type="text" name="cf_kakao_client_secret" value="<?php echo $config['cf_kakao_client_secret'] ?>" id="cf_kakao_client_secret" class="frm_input w100per">
            </td>
        </tr>
        <tr>
            <th colspan="2" class="titletag">PAYCO</th>
        </tr>
        <tr>
            <th scope="row">사용여부</th>
            <td>
                <label class="switch-check">
                <input type="checkbox" name="cf_social_servicelist[]" id="check_social_payco" value="payco" <?php echo option_array_checked('payco', $config['cf_social_servicelist']); ?> >
                <div class="check-slider round"></div>
                </label>
                <label for="check_social_payco">페이코 로그인을 사용합니다</label>
            </td>
        </tr>
        <tr>
            <th scope="row" class="font-normal">페이코 CallbackURL</th>
            <td>
                <?php echo get_social_callbackurl('payco'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_payco_clientid">페이코 Client ID</label></th>
            <td>
                <input type="text" name="cf_payco_clientid" value="<?php echo $config['cf_payco_clientid']; ?>" id="cf_payco_clientid" class="frm_input"> <a href="https://developers.payco.com/guide" target="_blank" class="btn_frmline">앱 등록하기</a>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_payco_secret">페이코 Secret</label></th>
            <td>
                <input type="text" name="cf_payco_secret" value="<?php echo $config['cf_payco_secret']; ?>" id="cf_payco_secret" class="frm_input w100per">
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>
<!-- // --> 

<?php// echo $frm_submit; //저장버튼?>

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">   
    <div class="bq_basic_icon">
    <a href="<?php echo G5_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/home_icon.png" border="0" title="홈"></a>
    <a href="<?php echo G5_SHOP_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/shop_icon.png" border="0" title="쇼핑몰">&nbsp;&nbsp;</a>
    </div>
    
    <div class="bq_basic_submit">
    <input type="submit" value="확인" accesskey="s">
    </div>
</div>
<!--//-->

</form>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
