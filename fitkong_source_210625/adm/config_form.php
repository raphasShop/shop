<?php
$sub_menu = "100100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

if (!isset($config['cf_mobile_new_skin'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_mobile_new_skin` VARCHAR(255) NOT NULL AFTER `cf_memo_send_point`,
                    ADD `cf_mobile_search_skin` VARCHAR(255) NOT NULL AFTER `cf_mobile_new_skin`,
                    ADD `cf_mobile_connect_skin` VARCHAR(255) NOT NULL AFTER `cf_mobile_search_skin`,
                    ADD `cf_mobile_member_skin` VARCHAR(255) NOT NULL AFTER `cf_mobile_connect_skin` ", true);
}

if (isset($config['cf_gcaptcha_mp3'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    CHANGE `cf_gcaptcha_mp3` `cf_captcha_mp3` VARCHAR(255) NOT NULL DEFAULT '' ", true);
} else if (!isset($config['cf_captcha_mp3'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_captcha_mp3` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_mobile_member_skin` ", true);
}

if(!isset($config['cf_editor'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_editor` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_captcha_mp3` ", true);
}

if(!isset($config['cf_mobile_pages'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_mobile_pages` INT(11) NOT NULL DEFAULT '0' AFTER `cf_write_pages` ", true);
    sql_query(" UPDATE `{$g5['config_table']}` SET cf_mobile_pages = '5' ", true);
}

// uniqid 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['uniqid_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['uniqid_table']}` (
                  `uq_id` bigint(20) unsigned NOT NULL,
                  `uq_ip` varchar(255) NOT NULL,
                  PRIMARY KEY (`uq_id`)
                ) ", false);
}

if(!sql_query(" SELECT uq_ip from {$g5['uniqid_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE {$g5['uniqid_table']} ADD `uq_ip` VARCHAR(255) NOT NULL ");
}

// 임시저장 테이블이 없을 경우 생성
if(!sql_query(" DESC {$g5['autosave_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['autosave_table']}` (
                  `as_id` int(11) NOT NULL AUTO_INCREMENT,
                  `mb_id` varchar(20) NOT NULL,
                  `as_uid` bigint(20) unsigned NOT NULL,
                  `as_subject` varchar(255) NOT NULL,
                  `as_content` text NOT NULL,
                  `as_datetime` datetime NOT NULL,
                  PRIMARY KEY (`as_id`),
                  UNIQUE KEY `as_uid` (`as_uid`),
                  KEY `mb_id` (`mb_id`)
                ) ", false);
}

if(!isset($config['cf_admin_email'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_admin_email` VARCHAR(255) NOT NULL AFTER `cf_admin` ", true);
}

if(!isset($config['cf_admin_email_name'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_admin_email_name` VARCHAR(255) NOT NULL AFTER `cf_admin_email` ", true);
}

if(!isset($config['cf_sms_use'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_sms_use` varchar(255) NOT NULL DEFAULT '' AFTER `cf_cert_limit`,
                    ADD `cf_icode_id` varchar(255) NOT NULL DEFAULT '' AFTER `cf_sms_use`,
                    ADD `cf_icode_pw` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_id`,
                    ADD `cf_icode_server_ip` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_pw`,
                    ADD `cf_icode_server_port` varchar(255) NOT NULL DEFAULT '' AFTER `cf_icode_server_ip` ", true);
}

if(!isset($config['cf_mobile_page_rows'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_mobile_page_rows` int(11) NOT NULL DEFAULT '0' AFTER `cf_page_rows` ", true);
}

if(!isset($config['cf_faq_skin'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_faq_skin` varchar(255) NOT NULL DEFAULT '' AFTER `cf_connect_skin`,
                    ADD `cf_mobile_faq_skin` varchar(255) NOT NULL DEFAULT '' AFTER `cf_mobile_connect_skin` ", true);
}

if(!isset($config['cf_optimize_date'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_optimize_date` date NOT NULL default '0000-00-00' AFTER `cf_popular_del` ", true);
}

// SMS 전송유형 필드 추가
if(!isset($config['cf_sms_type'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_sms_type` varchar(10) NOT NULL DEFAULT '' AFTER `cf_sms_use` ", true);
}

// 접속자 정보 필드 추가
if(!sql_query(" select vi_browser from {$g5['visit_table']} limit 1 ")) {
    sql_query(" ALTER TABLE `{$g5['visit_table']}`
                    ADD `vi_browser` varchar(255) NOT NULL DEFAULT '' AFTER `vi_agent`,
                    ADD `vi_os` varchar(255) NOT NULL DEFAULT '' AFTER `vi_browser`,
                    ADD `vi_device` varchar(255) NOT NULL DEFAULT '' AFTER `vi_os` ", true);
}

// 회원 이미지 관련 필드 추가
if(!isset($config['cf_member_img_size'])) {
    sql_query("ALTER TABLE `{$g5['config_table']}`
                ADD `cf_member_img_size` int(11) NOT NULL DEFAULT '0' AFTER `cf_member_icon_height`,
                ADD `cf_member_img_width` int(11) NOT NULL DEFAULT '0' AFTER `cf_member_img_size`,
                ADD `cf_member_img_height` int(11) NOT NULL DEFAULT '0' AFTER `cf_member_img_width`
    ", true);

    $sql = " update {$g5['config_table']} set cf_member_img_size = 50000, cf_member_img_width = 60, cf_member_img_height = 60 ";
    sql_query($sql, false);

    $config['cf_member_img_size'] = 50000;
    $config['cf_member_img_width'] = 60;
    $config['cf_member_img_height'] = 60;
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

// 회원 이미지 관련 필드 추가
if(!isset($config['cf_member_img_size'])) {
    sql_query("ALTER TABLE `{$g5['config_table']}`
                ADD `cf_member_img_size` int(11) NOT NULL DEFAULT '0' AFTER `cf_member_icon_height`,
                ADD `cf_member_img_width` int(11) NOT NULL DEFAULT '0' AFTER `cf_member_img_size`,
                ADD `cf_member_img_height` int(11) NOT NULL DEFAULT '0' AFTER `cf_member_img_width`
    ", true);

    $sql = " update {$g5['config_table']} set cf_member_img_size = 50000, cf_member_img_width = 60, cf_member_img_height = 60 ";
    sql_query($sql, false);

    $config['cf_member_img_size'] = 50000;
    $config['cf_member_img_width'] = 60;
    $config['cf_member_img_height'] = 60;
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


if(!$config['cf_faq_skin']) $config['cf_faq_skin'] = "basic";
if(!$config['cf_mobile_faq_skin']) $config['cf_mobile_faq_skin'] = "basic";

$g5['title'] = '사이트 기본 환경설정';
include_once ('./admin.head.php');

$pg_anchor = '<ul class="anchor">
    <li><a href="#anc_cf_adminchoice">최고관리자</a></li>
	<li><a href="#anc_cf_basic">기본환경</a></li>
	<li><a href="#anc_cf_point">포인트</a></li>
	<li><a href="#anc_cf_skin">스킨</a></li>
	<li><a href="#anc_cf_datadel">데이타삭제설정</a></li>
    <li><a href="#anc_cf_sms">SMS</a></li>
    <li><a href="#anc_cf_extra">여분필드</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';

if (!$config['cf_icode_server_ip'])   $config['cf_icode_server_ip'] = '211.172.232.124';
if (!$config['cf_icode_server_port']) $config['cf_icode_server_port'] = '7295';

if ($config['cf_sms_use'] && $config['cf_icode_id'] && $config['cf_icode_pw']) {
    $userinfo = get_icode_userinfo($config['cf_icode_id'], $config['cf_icode_pw']);
}
?>


<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);">
<input type="hidden" name="token" value="" id="token">

<!-- 최고관리자 설정 -->
<section id="anc_cf_adminchoice">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">최고관리자 설정</h2>
    <div class="local_desc02 local_desc">
        <p>최고관리자를 선택할 수 있습니다.</p>
    </div>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>최고관리자 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_admin">최고관리자<strong class="sound_only">필수</strong></label></th>
            <td><?php echo get_member_id_select('cf_admin', 10, $config['cf_admin'], 'required') ?></td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!--//-->

<!-- 기본설정 -->
<section id="anc_cf_basic">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">기본환경 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>홈페이지 기본환경 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_title">홈페이지 제목<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="cf_title" value="<?php echo $config['cf_title'] ?>" id="cf_title" required class="required frm_input w100per"></td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_admin_email">관리자 메일 주소<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo help('관리자가 보내고 받는 용도로 사용하는 메일 주소를 입력합니다. (회원가입, 인증메일, 테스트, 회원메일발송 등에서 사용)') ?>
                <input type="text" name="cf_admin_email" value="<?php echo $config['cf_admin_email'] ?>" id="cf_admin_email" required class="required email frm_input w100per">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_admin_email_name">관리자 메일 발송이름<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo help('관리자가 보내고 받는 용도로 사용하는 메일의 발송이름을 입력합니다. (회원가입, 인증메일, 테스트, 회원메일발송 등에서 사용)') ?>
                <input type="text" name="cf_admin_email_name" value="<?php echo $config['cf_admin_email_name'] ?>" id="cf_admin_email_name" required class="required frm_input w100per">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_login_minutes">현재 접속자</label></th>
            <td>
                <?php echo help('설정값 이내의 접속자를 현재 접속자로 인정') ?>
                <input type="text" name="cf_login_minutes" value="<?php echo $config['cf_login_minutes'] ?>" id="cf_login_minutes" class="frm_input" size="3"> 분
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo preg_replace('#</div>$#i', '<button type="button" class="get_theme_confc btn btn-orangered" data-type="conf_skin"><i class="fas fa-magic"></i> 테마 스킨설정 가져오기</button></div>', $frm_submit); ?>
<!-- // -->

<!-- 포인트 설정 -->
<section id="anc_cf_point">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">포인트 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>포인트 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_use_point">포인트(적립금) 사용</label></th>
            <td>
            <label class="switch-check">
            <input type="checkbox" name="cf_use_point" value="1" id="cf_use_point" <?php echo $config['cf_use_point']?'checked':''; ?>> 사용
            <div class="check-slider round"></div>
            </label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_login_point">로그인시 포인트<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo help('회원이 로그인시 하루에 한번만 적립') ?>
                <input type="text" name="cf_login_point" value="<?php echo $config['cf_login_point'] ?>" id="cf_login_point" required class="required frm_input" size="5"> 점
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_memo_send_point">쪽지보낼시 차감 포인트<strong class="sound_only">필수</strong></label></th>
            <td>
                 <?php echo help('양수로 입력하십시오. 0점은 쪽지 보낼시 포인트를 차감하지 않습니다.') ?>
                <input type="text" name="cf_memo_send_point" value="<?php echo $config['cf_memo_send_point'] ?>" id="cf_memo_send_point" required class="required frm_input red" size="5"> 점
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_point_term">포인트 유효기간</label></th>
            <td>
                <?php echo help('0으로 설정시 유효기간없음. 유효기간 설정시 기간경과후에는 포인트가 사라집니다.<br><strong>[유의사항]</strong> 쇼핑몰을 운영중이라면 반드시 0으로 설정하셔야 회원적립금이 사라지는 불상사를 막을 수 있습니다.') ?>
                <input type="text" name="cf_point_term" value="<?php echo $config['cf_point_term']; ?>" id="cf_point_term" required class="required frm_input" size="5"> 일
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!--//-->

<!-- 스킨설정 -->
<section id="anc_cf_skin">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">스킨 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>스킨 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <!-- PC -->
        <tr>
            <th colspan="2" class="titletag">PC 스킨</th>
        </tr>
        <tr>
            <th scope="row"><label for="cf_new_skin">최근게시물 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_skin_select('new', 'cf_new_skin', 'cf_new_skin', $config['cf_new_skin'], 'required'); ?>
            </td>
        </tr>
        
        <tr>
            <th scope="row"><label for="cf_search_skin">검색 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_skin_select('search', 'cf_search_skin', 'cf_search_skin', $config['cf_search_skin'], 'required'); ?>
            </td>
        </tr>
        
        <tr>
            <th scope="row"><label for="cf_connect_skin">접속자 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_skin_select('connect', 'cf_connect_skin', 'cf_connect_skin', $config['cf_connect_skin'], 'required'); ?>
            </td>
        </tr>
        
        <tr>
            <th scope="row"><label for="cf_faq_skin">FAQ 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_skin_select('faq', 'cf_faq_skin', 'cf_faq_skin', $config['cf_faq_skin'], 'required'); ?>
            </td>
        </tr>
        <!--//-->
        <!-- 모바일 -->
        <tr>
            <th colspan="2" class="titletag">모바일 스킨</th>
        </tr>
        <tr>
            <th scope="row"><label for="cf_mobile_new_skin">모바일 최근게시물 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_skin_select('new', 'cf_mobile_new_skin', 'cf_mobile_new_skin', $config['cf_mobile_new_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_mobile_search_skin">모바일 검색 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_skin_select('search', 'cf_mobile_search_skin', 'cf_mobile_search_skin', $config['cf_mobile_search_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_mobile_connect_skin">모바일 접속자 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_skin_select('connect', 'cf_mobile_connect_skin', 'cf_mobile_connect_skin', $config['cf_mobile_connect_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_mobile_faq_skin">모바일 FAQ 스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_skin_select('faq', 'cf_mobile_faq_skin', 'cf_mobile_faq_skin', $config['cf_mobile_faq_skin'], 'required'); ?>
            </td>
        </tr>
        <!--//-->
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!--//-->

<!-- 데이타 삭제 설정 -->
<section id="anc_cf_datadel">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">데이타삭제 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>데이타삭제 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_new_del">최근게시물 삭제</label></th>
            <td>
                <?php echo help('설정일이 지난 최근게시물 자동 삭제') ?>
                <input type="text" name="cf_new_del" value="<?php echo $config['cf_new_del'] ?>" id="cf_new_del" class="frm_input" size="5"> 일
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_memo_del">쪽지 삭제</label></th>
            <td>
                <?php echo help('설정일이 지난 쪽지 자동 삭제') ?>
                <input type="text" name="cf_memo_del" value="<?php echo $config['cf_memo_del'] ?>" id="cf_memo_del" class="frm_input" size="5"> 일
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_visit_del">접속자로그 삭제</label></th>
            <td>
                <?php echo help('설정일이 지난 접속자 로그 자동 삭제') ?>
                <input type="text" name="cf_visit_del" value="<?php echo $config['cf_visit_del'] ?>" id="cf_visit_del" class="frm_input" size="5"> 일
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_popular_del">인기검색어 삭제</label></th>
            <td>
                <?php echo help('설정일이 지난 인기검색어 자동 삭제') ?>
                <input type="text" name="cf_popular_del" value="<?php echo $config['cf_popular_del'] ?>" id="cf_popular_del" class="frm_input" size="5"> 일
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!--//-->

<!-- SMS설정 -->
<section id="anc_cf_sms">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">SMS</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>SMS 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_sms_use">SMS 사용</label></th>
            <td>
                <select id="cf_sms_use" name="cf_sms_use">
                    <option value="" <?php echo get_selected($config['cf_sms_use'], ''); ?>>사용안함</option>
                    <option value="icode" <?php echo get_selected($config['cf_sms_use'], 'icode'); ?>>아이코드</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_sms_type">SMS 전송유형</label></th>
            <td>
                <?php echo help("전송유형을 SMS로 선택하시면 최대 80바이트까지 전송하실 수 있으며<br>LMS로 선택하시면 90바이트 이하는 SMS로, 그 이상은 1500바이트까지 LMS로 전송됩니다.<br>요금은 건당 SMS는 16원, LMS는 48원입니다."); ?>
                <select id="cf_sms_type" name="cf_sms_type">
                    <option value="" <?php echo get_selected($config['cf_sms_type'], ''); ?>>SMS</option>
                    <option value="LMS" <?php echo get_selected($config['cf_sms_type'], 'LMS'); ?>>LMS</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_icode_id">아이코드 회원아이디</label></th>
            <td>
                <?php echo help("아이코드에서 사용하시는 회원아이디를 입력합니다."); ?>
                <input type="text" name="cf_icode_id" value="<?php echo $config['cf_icode_id']; ?>" id="cf_icode_id" class="frm_input" size="20">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_icode_pw">아이코드 비밀번호</label></th>
            <td>
                <?php echo help("아이코드에서 사용하시는 비밀번호를 입력합니다."); ?>
                <input type="password" name="cf_icode_pw" value="<?php echo $config['cf_icode_pw']; ?>" id="cf_icode_pw" class="frm_input">
            </td>
        </tr>
        <tr>
            <th scope="row">요금제</th>
            <td>
                <input type="hidden" name="cf_icode_server_ip" value="<?php echo $config['cf_icode_server_ip']; ?>">
                <?php
                    if ($userinfo['payment'] == 'A') {
                       echo '충전제';
                        echo '<input type="hidden" name="cf_icode_server_port" value="7295">';
                    } else if ($userinfo['payment'] == 'C') {
                        echo '정액제';
                        echo '<input type="hidden" name="cf_icode_server_port" value="7296">';
                    } else {
                        echo '가입해주세요.';
                        echo '<input type="hidden" name="cf_icode_server_port" value="7295">';
                    }
                ?>
            </td>
        </tr>
        <tr>
            <th scope="row">아이코드 SMS 신청<br>회원가입</th>
            <td>
                <a href="http://icodekorea.com/res/join_company_fix_a.php?sellid=sir2" target="_blank" class="btn_frmline">아이코드 회원가입</a>
            </td>
        </tr>
         <?php if ($userinfo['payment'] == 'A') { ?>
        <tr>
            <th scope="row">충전 잔액</th>
            <td>
                <?php echo number_format($userinfo['coin']); ?> 원.
                <a href="http://www.icodekorea.com/smsbiz/credit_card_amt.php?icode_id=<?php echo $config['cf_icode_id']; ?>&amp;icode_passwd=<?php echo $config['cf_icode_pw']; ?>" target="_blank" class="btn_frmline">충전하기</a>
            </td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>

<section id="anc_cf_extra">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">여분필드 기본 설정</h2>
    <div class="local_desc02 local_desc">
        <p>각 게시판 관리에서 개별적으로 설정 가능합니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>여분필드 기본 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <?php for ($i=1; $i<=10; $i++) { ?>
        <tr>
            <th scope="row">여분필드<?php echo $i ?></th>
            <td class="td_extra">
                <label for="cf_<?php echo $i ?>_subj">여분필드<?php echo $i ?> 제목</label>
                <input type="text" name="cf_<?php echo $i ?>_subj" value="<?php echo get_text($config['cf_'.$i.'_subj']) ?>" id="cf_<?php echo $i ?>_subj" class="frm_input" size="30">
                <label for="cf_<?php echo $i ?>">여분필드<?php echo $i ?> 값</label>
                <input type="text" name="cf_<?php echo $i ?>" value="<?php echo $config['cf_'.$i] ?>" id="cf_<?php echo $i ?>" class="frm_input" size="30">
            </td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>

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

<script>
$(function(){

    $(".get_theme_confc").on("click", function() {
        var type = $(this).data("type");
        var msg = "기본환경 스킨 설정";
        if(type == "conf_member")
            msg = "기본환경 회원스킨 설정";

        if(!confirm("현재 테마의 "+msg+"을 적용하시겠습니까?"))
            return false;

        $.ajax({
            type: "POST",
            url: "./theme_config_load.php",
            cache: false,
            async: false,
            data: { type: type },
            dataType: "json",
            success: function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                var field = Array('cf_member_skin', 'cf_mobile_member_skin', 'cf_new_skin', 'cf_mobile_new_skin', 'cf_search_skin', 'cf_mobile_search_skin', 'cf_connect_skin', 'cf_mobile_connect_skin', 'cf_faq_skin', 'cf_mobile_faq_skin');
                var count = field.length;
                var key;

                for(i=0; i<count; i++) {
                    key = field[i];

                    if(data[key] != undefined && data[key] != "")
                        $("select[name="+key+"]").val(data[key]);
                }
            }
        });
    });
});

function fconfigform_submit(f)
{
    f.action = "./config_form_update.php";
    return true;
}
</script>

<?php
include_once ('./admin.tail.php');
?>
