<?php
// 소메뉴그룹의 메뉴 트리구조 아이콘 정의 (메뉴에 2로 표시된것에 적용)
// admin.menuXXX.php 파일에 모두 적용
//$menu100icon = '<img src="'.G5_ADMIN_URL.'/img/menu-1-1.png"> ';
$treeicon = '<img src="'.G5_ADMIN_URL.'/img/left-plus.gif"> ';//하위메뉴 트리아이콘

$menu['menu100'] = array (
    array('100000', '환경설정', G5_ADMIN_URL.'/config_form.php',   'config'),
	
	array('100600', '접속환경설정', G5_ADMIN_URL.'/config_main.php',   'cf', 1),
	array('100601', $treeicon.'접속화면설정', G5_ADMIN_URL.'/config_main.php',   'cf_main', 2),
	array('100602', $treeicon.'사용자접속제한', G5_ADMIN_URL.'/config_contact.php',   'cf_cotact', 2),
    
	array('100100a', '사이트설정', G5_ADMIN_URL.'/config_form.php',   'cf', 1),
	array('100100', $treeicon.'기본환경설정', G5_ADMIN_URL.'/config_form.php',   'cf_basic', 2),
	array('100101', $treeicon.'게시판환경설정', G5_ADMIN_URL.'/config_board.php',   'cf_board', 2),
	array('100103', $treeicon.'검색엔진최적화(SEO)', G5_ADMIN_URL.'/config_seo.php', 'cf_config_seo', 2),
	array('100102', $treeicon.'소셜로그인 사용', G5_ADMIN_URL.'/config_login.php', 'cf_config_login', 2),
	array('100104', $treeicon.'네이버신디케이션', G5_ADMIN_URL.'/config_syndi.php', 'cf_config_syndi', 2),
	
	array('100300a', '메일환경설정', G5_ADMIN_URL.'/config_mailsend.php', 'cf_mail', 1),
	array('100301', $treeicon.'메일환경 및 발송설정', G5_ADMIN_URL.'/config_mailsend.php', 'cf_mailsend', 2),
	array('100300', $treeicon.'메일테스트', G5_ADMIN_URL.'/sendmail_test.php', 'cf_mailtest', 2),
	
	//무통장입금 자동확인 서비스(유료/사용설정은 서비스업체 홈페이지에서 가능) 2017-12-07
	array('100500a', '외부연동서비스', G5_ADMIN_URL.'/config_sns.php', 'cf_outside', 1),
	array('100503', $treeicon.'API키 등록', G5_ADMIN_URL.'/config_sns.php', 'cf_config_sns', 2),
	array('100501', $treeicon.'알뱅킹설정', G5_ADMIN_URL.'/shop_admin/config_apibox.php', 'scf_config_apibox', 2),

    array('100200', '관리권한설정', G5_ADMIN_URL.'/auth_list.php',     'cf_auth'),

	array('100210a', '부가서비스안내', G5_ADMIN_URL.'/shop_admin/price.php', 'pmt_out', 1),
	array('100210', $treeicon.'가격비교사이트', G5_ADMIN_URL.'/shop_admin/price.php', 'cf_compare', 2),
	array('100400', $treeicon.'부가서비스', G5_ADMIN_URL.'/service.php', 'cf_service', 2),

	array('100980', 'SEO 설정', G5_ADMIN_URL.'/ask-seo/ask_seo_form.php', 'cf_ask'),
    array('100981', 'SEO 그룹설정', G5_ADMIN_URL.'/ask-seo/ask_seo_group.php', 'cf_ask'),
	array('100982', 'SEO 게시판설정', G5_ADMIN_URL.'/ask-seo/ask_seo_board.php', 'cf_ask'),

	array('600000', '판매금액설정', 'sellprice_stats'),
    array('600600', '판매금액설정 안내', G5_ADMIN_URL.'/shop_admin/_comcose_sellprice_setting.php', 'sellprice_info'),
    array('600100', '회원권한별 금액설정', G5_ADMIN_URL.'/shop_admin/_comcose_sellprice_level.php', 'level_setting'),
	array('600500', '상품별 금액설정', G5_ADMIN_URL.'/shop_admin/_comcose_sellprice_item_add.php', 'item_setting'),
    array('600200', '분류별 금액설정', G5_ADMIN_URL.'/shop_admin/_comcose_sellprice_category_add.php', 'category_setting'),
    array('600300', '제외 분류설정', G5_ADMIN_URL.'/shop_admin/_comcose_sellprice_category_except.php', 'category_except'),
    array('600400', '제외 상품설정', G5_ADMIN_URL.'/shop_admin/_comcose_sellprice_item_except.php', 'item_except'),
    array('600900', '상품유형관리', G5_ADMIN_URL.'/shop_admin/_comcose_itemtypelist.php', 'item_except')

);
?>