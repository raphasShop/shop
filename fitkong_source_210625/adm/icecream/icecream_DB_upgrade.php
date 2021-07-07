<?php
#################################################################

/* 아이스크림설치를 위한 DB 설치 */

#################################################################

/*
최초작성일 : 2018-03-27
최종수정일 : 2018-11-11

버전 : 아이스크림 S9 영카트NEW 관리자
개발 : 아이스크림 아이스크림플레이 icecreamplay.cafe24.com
라이센스 : 유료판매 프로그램으로 유료 라이센스를 가집니다
           - 1카피 1도메인
           - 무단배포불가/무단사용불가
           - 소스의 일부 또는 전체 배포/공유/수정배포 불가
*/

#################################################################

$sub_menu = '999710';
include_once('./_common.php');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '아이스크림 DB 업그레이드';
include_once(G5_ADMIN_PATH.'/admin.head.php');


$is_check = false;


#################################################################

/*
아이스크림S8 기준 2018년4월1일까지 추가된 DB 업데이트
*/

#################################################################


// ■ 환경설정 > 사이트설정 > 검색엔진최적화(SEO)
// ▧ admin/configform.php 실행시 필요한 추가필드
// ▧ [방문자스크립트 필드추가] 방문자스크립트 필드 추가(구글애널리틱스 등)
/* 영카트 기본 추가필드 */
if(!sql_query(" select cf_analytics from {$g5['config_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                 ADD `cf_analytics` TEXT NOT NULL AFTER `cf_intercept_ip`
	", true);
	
	$is_check = true;
}

// ■ 환경설정 > 사이트설정 > 검색엔진최적화(SEO)
// ▧ admin/configform.php 실행시 필요한 추가필드
// ▧ [메타태그 필드추가] 메타태그 필드 추가(구글애널리틱스 등)
/* 영카트 기본 추가필드 */
if(!sql_query(" select cf_add_meta from {$g5['config_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                 ADD `cf_add_meta` TEXT NOT NULL AFTER `cf_analytics` 
	", true);
	
	$is_check = true;
}

// ■ 환경설정 > 쇼핑몰설정 > 쇼핑몰기본설정
// ▧ adm/shop_admin/configform.php 실행시 필요한 아이스크림 전용 추가필드
// ▧ [반품주소 필드추가] 쇼핑몰설정에서 반품받을 주소 등록 필드 추가
/* 아이스크림전용 필드추가 */
if(!sql_query(" select de_admin_return_zip from {$g5['g5_shop_default_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                 ADD `de_admin_return_zip` varchar(255) NOT NULL DEFAULT '' AFTER `de_admin_info_email`,
                 ADD `de_admin_return_addr` varchar(255) NOT NULL DEFAULT '' AFTER `de_admin_return_zip`
	", true);
	
	$is_check = true;
}

// ■ 환경설정 > 외부연동서비스 > 추천쇼핑몰설정
// ▧ adm/shop_admin/config_link.php 실행시 필요한 아이스크림 전용 추가필드
// ▧ [추천쇼핑몰 필드추가] 추천쇼핑몰 설정 필드 추가
/* 아이스크림전용 필드추가 */
if(!sql_query(" select ch_link_baro_use from {$g5['g5_shop_default_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
	             ADD `ch_link_baro_use` tinyint(4) NOT NULL AFTER `de_member_reg_coupon_minimum`,
				 ADD `ch_link_tel_number` VARCHAR(255) NOT NULL AFTER `ch_link_baro_use`,
				 ADD `ch_link_kakaoplus_url` VARCHAR(255) NOT NULL AFTER `ch_link_tel_number`,
				 ADD `ch_link_market_name1` VARCHAR(255) NOT NULL AFTER `ch_link_kakaoplus_url`,
				 ADD `ch_link_market_name2` VARCHAR(255) NOT NULL AFTER `ch_link_market_name1`,
				 ADD `ch_link_market_name3` VARCHAR(255) NOT NULL AFTER `ch_link_market_name2`,
				 ADD `ch_link_market_name4` VARCHAR(255) NOT NULL AFTER `ch_link_market_name3`,
				 ADD `ch_link_market_name5` VARCHAR(255) NOT NULL AFTER `ch_link_market_name4`,
				 ADD `ch_link_market_name6` VARCHAR(255) NOT NULL AFTER `ch_link_market_name5`,
				 ADD `ch_link_market_name7` VARCHAR(255) NOT NULL AFTER `ch_link_market_name6`,
				 ADD `ch_link_market_name8` VARCHAR(255) NOT NULL AFTER `ch_link_market_name7`,
				 ADD `ch_link_market_name9` VARCHAR(255) NOT NULL AFTER `ch_link_market_name8`,
				 ADD `ch_link_market_name10` VARCHAR(255) NOT NULL AFTER `ch_link_market_name9`	 
	", true);
	
	$is_check = true;
}

// ■ 환경설정 > 외부연동서비스 > 알뱅킹설정
// ▧ adm/shop_admin/config_apibox.php 실행시 필요한 아이스크림 전용 추가필드
// ▧ [알뱅킹 필드추가] 쇼핑몰설정 테이블에 알뱅킹서비스 설정 필드 추가
/* 아이스크림전용 필드추가 */
if(!sql_query(" select apibox_use from {$g5['g5_shop_default_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
	             ADD `apibox_use` tinyint(4) NOT NULL AFTER `ch_link_market_name10`,
				 ADD `apibox_id` VARCHAR(30) NOT NULL AFTER `apibox_use`
	", true);
	
	$is_check = true;
}

// ■ 디자인 > 배너관리 > 쇼핑몰메인배너
// ▧ shop_admin/bannerlist.php 실행시 필요한 아이스크림 전용 추가필드
// ▧ [추천쇼핑몰 필드추가] 배너관리에 배경색지정 필드 추가
/* 아이스크림전용 필드추가 */
if(!sql_query(" select bn_bgcolor from {$g5['g5_shop_banner_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_banner_table']}`
                 ADD `bn_bgcolor` varchar(10) NOT NULL AFTER `bn_border` 
	", true);
	
	$is_check = true;
}

// ■ 디자인 > 배너관리 > 쇼핑몰메인배너
// ▧ shop_admin/bannerlist.php 실행시 필요한 추가필드
// ▧ [접속기기 필드추가] 접속기기의 종류 필드 추가 (PC,모바일)
/* 영카트 기본 추가필드 */
if(!sql_query(" select bn_device from {$g5['g5_shop_banner_table']} limit 0, 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_banner_table']}`
                    ADD `bn_device` varchar(10) not null default '' AFTER `bn_url` ", true);
    sql_query(" update {$g5['g5_shop_banner_table']} set bn_device = 'pc' ", true);//접속기기 pc로 기본값 저장
	
	$is_check = true;
}

// ■ 디자인 > 팝업창관리
// ▧ adm/newwinlist.php 실행시 필요한 아이스크림 전용 추가필드
// ▧ [팝업창 필드추가] 팝업창에 아이스크림 추가기능 필드 추가 (아이스크림전용기능)
/* 아이스크림전용 필드추가 */
// [필드추가] nw_padding : 내용 상하좌우 패딩값 추가
if(!sql_query(" select nw_padding from {$g5['new_win_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['new_win_table']}`
                  	ADD `nw_padding` int(11) NOT NULL DEFAULT '0' AFTER `nw_width` 
	", true);
	
	$is_check = true;
}

// ■ 회원 > 회원관리 > 수정
// ▧ admin/member_list.php 실행시 필요한 아이스크림 전용 추가필드
// ▧ [회원가입 필드추가] 회원 탈퇴일,차단일 시간까지 등록하도록 기존 필드삭제후 추가 (varchar(19))
/* 영카트 기본 필드이며, 아이스크림에 최적화하기 위해 varchar(19)로 변경하는 작업(기존 필드 삭제후 설치해야 함) */
if(!sql_query(" select mb_leave_date from {$g5['member_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['member_table']}`
                 ADD `mb_leave_date` varchar(19) NOT NULL DEFAULT '' AFTER `mb_ip`,
				 ADD `mb_intercept_date` varchar(19) NOT NULL DEFAULT '' AFTER `mb_leave_date` 
	", true);
					
	$is_check = true;
}

// ■ 회원 > 회원관리 > 회원그룹관리
// ▧ adm/member_lev_conf.php 실행시 필요한 아이스크림 전용 추가필드
// ▧ [회원그룹 필드추가] 회원그룹생성을 위한 기본환경설정 config_table 에 필드추가 (회원테이블아님!!)
/* 아이스크림전용 필드추가 */
if(!sql_query(" select lev_cf_1 from {$g5['config_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `lev_cf_1` VARCHAR(255) NOT NULL DEFAULT '비회원' AFTER `cf_10`,
                    ADD `lev_cf_2` VARCHAR(255) NOT NULL AFTER `lev_cf_1`,
                    ADD `lev_cf_3` VARCHAR(255) NOT NULL AFTER `lev_cf_2`,
                    ADD `lev_cf_4` VARCHAR(255) NOT NULL AFTER `lev_cf_3`,
                    ADD `lev_cf_5` VARCHAR(255) NOT NULL AFTER `lev_cf_4`,
                    ADD `lev_cf_6` VARCHAR(255) NOT NULL AFTER `lev_cf_5`,
                    ADD `lev_cf_7` VARCHAR(255) NOT NULL AFTER `lev_cf_6`,
                    ADD `lev_cf_8` VARCHAR(255) NOT NULL AFTER `lev_cf_7`,
                    ADD `lev_cf_9` VARCHAR(255) NOT NULL AFTER `lev_cf_8`,
                    ADD `lev_cf_10` VARCHAR(255) NOT NULL DEFAULT '최고관리자' AFTER `lev_cf_9` 
	", true);
				
	$is_check = true;
}

// ■ 상품 > 상품진열설정 > 메인상품진열
// ▧ adm/shop_admin/config_dis_main.php 실행시 필요한 아이스크림 전용 추가필드
// ▧ [유형별명칭 PC 필드추가] 유형별 명칭 직접입력 필드 추가
/* 아이스크림전용 필드추가 */
if(!sql_query(" select de_type1_title from {$g5['g5_shop_default_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_type1_title` varchar(255) NOT NULL DEFAULT '히트상품' AFTER `de_shop_mobile_skin`,
					ADD `de_type2_title` varchar(255) NOT NULL DEFAULT '추천상품' AFTER `de_type1_title`,
					ADD `de_type3_title` varchar(255) NOT NULL DEFAULT '최신상품' AFTER `de_type2_title`,
					ADD `de_type4_title` varchar(255) NOT NULL DEFAULT '인기상품' AFTER `de_type3_title`,
					ADD `de_type5_title` varchar(255) NOT NULL DEFAULT '할인상품' AFTER `de_type4_title` 
	", true);
	
	$is_check = true;
}

// ■ 상품 > 상품진열설정 > 메인상품진열
// ▧ adm/shop_admin/config_dis_main.php 실행시 필요한 아이스크림 전용 추가필드
// ▧ [유형별명칭 모바일 필드추가] 유형별 모바일 명칭 직접입력 필드 추가
/* 아이스크림전용 필드추가 */
if(!sql_query(" select de_mobile_type1_title from {$g5['g5_shop_default_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_mobile_type1_title` varchar(255) NOT NULL DEFAULT '히트상품' AFTER `de_type5_img_height`,
					ADD `de_mobile_type2_title` varchar(255) NOT NULL DEFAULT '추천상품' AFTER `de_mobile_type1_title`,
					ADD `de_mobile_type3_title` varchar(255) NOT NULL DEFAULT '최신상품' AFTER `de_mobile_type2_title`,
					ADD `de_mobile_type4_title` varchar(255) NOT NULL DEFAULT '인기상품' AFTER `de_mobile_type3_title`,
					ADD `de_mobile_type5_title` varchar(255) NOT NULL DEFAULT '할인상품' AFTER `de_mobile_type4_title` 
	", true);
	
	$is_check = true;
}

/* ★ g5_shop_order_atmcheck 테이블 새로 설치 */
// ■ 주문관리 > 입금확인요청자
// ▧ adm/shop_admin/atmcheck.php 실행시 필요한 아이스크림 전용 테이블 설치
// ▧ [테이블설치] 입금확인요청 테이블 설치
/* 아이스크림전용 데이타베이스 설치 */
if(!sql_query(" select od_bank_account from `g5_shop_order_atmcheck` limit 1 ", false)) {
$sql = " CREATE TABLE IF NOT EXISTS `g5_shop_order_atmcheck` (
         `id_id` int(11) NOT NULL AUTO_INCREMENT,
         `it_id` varchar(25) NOT NULL,
         `od_id` varchar(20) NOT NULL,
         `mb_id` varchar(255) NOT NULL,
         `id_name` varchar(255) NOT NULL,
         `id_password` varchar(255) NOT NULL,
         `id_subject` varchar(255) NOT NULL,
         `od_bank_account` varchar(255) NOT NULL,
         `id_deposit_name` varchar(20) NOT NULL,
         `id_money` varchar(20) NOT NULL,
         `id_deposit_date` date NOT NULL DEFAULT '0000-00-00',
         `id_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
         `id_ip` varchar(25) NOT NULL,
         `id_confirm` tinyint(4) NOT NULL DEFAULT '0',
         PRIMARY KEY (`id_id`),
         KEY `index1` (`od_id`)
       ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;" ;
sql_query($sql, true);

$is_check = true;
}

// ■ 주문관리 > 주문내역
// ▧ adm/shop_admin/orderlist.php 실행시 필요한 아이스크림 전용 추가필드
// ▧ [주문서 필드추가] 주문서에서 장바구니 상품코드를 가져오기위한 필드추가 (입금확인요청 등에사용)
/* 아이스크림전용 필드추가 */
if(!sql_query(" select it_id from {$g5['g5_shop_order_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_order_table']}`
                 ADD `it_id` varchar(25) NOT NULL DEFAULT '' AFTER `mb_id`,
				 ADD `it_idx` varchar(25) NOT NULL DEFAULT '' AFTER `it_id`,
			     ADD `it_namex` varchar(255) NOT NULL DEFAULT '' AFTER `it_idx` 
	", true);
					
	$is_check = true;
}

// ■ 고객대응 > 상품문의
// ▧ adm/shop_admin/itemqalist.php 실행시 필요한 아이스크림 전용 추가필드
// ▧ [상품문의 필드추가] 답변시간등록을 위한 필드추가 (입금시간으로 데이타출력을 위한 필드추가)
/* 아이스크림전용 필드추가 */
if(!sql_query(" select iq_timeanswer from {$g5['g5_shop_item_qa_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_qa_table']}`
                   ADD `iq_timeanswer` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `iq_time` 
	", true);
	
	$is_check = true;
}


###########################################################################

/*
추가된 DB 업데이트 : 2018년 5월 5일

- 쇼핑몰메인페이지 설정기능
*/

###########################################################################


// ■ 환경설정 > 접속화면설정
// ▧ /admin/config_main.php 실행시 필요한 아이스크림 전용 추가필드
// ▧ [접속화면설정] 회원접속시 메인에서 보여질 페이지 환경설정
/* 아이스크림전용 필드추가 */
if(!sql_query(" select cf_main_choice from {$g5['config_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                   ADD `cf_main_choice` varchar(20) NOT NULL DEFAULT '' AFTER `cf_recaptcha_secret_key` 
	", true);
	sql_query(" update {$g5['config_table']} set cf_main_choice = 'community' ", true); //접속화면설정 기본값 커뮤니티로 저장
	
	$is_check = true;
}

// ■ 환경설정 > 기본환경설정 (SIR에서 추가된 기본 기능 DB 2018-04-11기준)
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
				
	$is_check = true;
}

// ■ 환경설정 > 사이트설정 > 검색엔진최적화
// ▧ /admin/config_seo.php 실행시 필요한 아이스크림 전용 추가필드
// ▧ [검색엔진최적화] 에서 메타태그 등록관련 추가필드 환경설정
/* 아이스크림전용 필드추가 */
if(!sql_query(" select cf_meta_author from {$g5['config_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                   ADD `cf_meta_author` varchar(255) NOT NULL DEFAULT '' AFTER `cf_editor`,
				   ADD `cf_meta_description` varchar(255) NOT NULL DEFAULT '' AFTER `cf_meta_author`,
				   ADD `cf_meta_keyword` varchar(255) NOT NULL DEFAULT '' AFTER `cf_meta_description`,
				   ADD `cf_meta_use_basic` int(11) NOT NULL DEFAULT '1' AFTER `cf_meta_keyword`,
				   ADD `cf_meta_use_board` int(11) NOT NULL DEFAULT '1' AFTER `cf_meta_use_basic`,
				   ADD `cf_meta_use_content` int(11) NOT NULL DEFAULT '1' AFTER `cf_meta_use_board`,
				   ADD `cf_meta_use_item` int(11) NOT NULL DEFAULT '1' AFTER `cf_meta_use_content`
	", true);
	
	$is_check = true;
}


###########################################################################

/*
추가된 DB 업데이트 : 2018년 9월 1일

- 고객센터운영시간정보 등
*/

###########################################################################


// ■ 환경설정 > 쇼핑몰설정 > 쇼핑몰기본설정
// ▧ adm/shop_admin/configform.php 실행시 필요한 아이스크림 전용 추가필드
// ▧ [고객센터운영시간 필드추가] 쇼핑몰설정에서 고객센터운영시간 등록 필드 추가
/* 아이스크림전용 필드추가 */
if(!sql_query(" select de_admin_open_day from {$g5['g5_shop_default_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                 ADD `de_admin_open_day` varchar(255) NOT NULL DEFAULT '월-금 am 09:00 - pm 5:00' AFTER `de_admin_info_email`,
                 ADD `de_admin_open_weekend` varchar(255) NOT NULL DEFAULT '' AFTER `de_admin_open_day`,
				 ADD `de_admin_open_lunch` varchar(255) NOT NULL DEFAULT 'pm 12:00 - pm 2:00' AFTER `de_admin_open_weekend`,
				 ADD `de_admin_open_info` varchar(255) NOT NULL DEFAULT '주말/휴일/공휴일/국경일은 업무를 하지않으며 배송업무도 쉽니다' AFTER `de_admin_open_lunch`
	", true);
	
	$is_check = true;
}


###########################################################################

/*
추가된 DB 업데이트 : 2018년 10월 24일

- 반품배송비 등
*/

###########################################################################

// ■ 환경설정 > 쇼핑몰설정 > 반품교환환불설정
// ▧ adm/shop_admin/config_return.php 실행시 필요한 아이스크림 전용 추가필드
// ▧ 반품,교환,환불을 위한 편도/왕복 배송비 설정 추가
/* 아이스크림전용 필드추가 */
if(!sql_query(" select de_admin_return_onefee from {$g5['g5_shop_default_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                 ADD `de_admin_return_onefee` varchar(20) NOT NULL DEFAULT '3000' AFTER `de_admin_return_addr`,
                 ADD `de_admin_return_twofee` varchar(20) NOT NULL DEFAULT '6000' AFTER `de_admin_return_onefee`
	", true);
	
	$is_check = true;
}




/*********************************************************
 DB업데이트 완료메세지 
*********************************************************/
$db_upgrade_msg = $is_check ? '<span class="font-14 orangered">아이스크림의 새로운 DB 업데이트가 완료되었습니다</span>' : '더 이상 추가될 DB나 필드가 없습니다.<br>현재 DB가 아이스크림 설치후 최신 DB입니다.';
?>

<div class="local_desc02 local_desc" style="padding:50px;">
    <p>
        <?php echo $db_upgrade_msg; ?>
    </p>
</div>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>