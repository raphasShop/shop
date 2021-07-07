<?php
// 소메뉴그룹의 메뉴 트리구조 아이콘 정의 (메뉴에 2로 표시된것에 적용)
// admin.menuXXX.php 파일에 모두 적용
$treeicon = '<img src="'.G5_ADMIN_URL.'/img/left-plus.gif"> ';

$menu['menu155'] = array (
    array('155000', '디자인', G5_ADMIN_URL.'/config_logo.php', 'design'),
	
	// theme폴더에 업로드한 테마관리(그누보드/영카트공통)
	array('155100', '<i class="fas fa-magic"></i> 테마/메뉴', ''.G5_ADMIN_URL.'/theme.php', 'thema', 1),
	array('155101', $treeicon.'테마관리', G5_ADMIN_URL.'/theme.php', 'de_theme', 2),
    array('155102', $treeicon.'메뉴설정', G5_ADMIN_URL.'/menu_list.php', 'de_menu', 2),
	
	// 설정을 통한 디자인
    array('155200', '<i class="fas fa-keyboard"></i> 설정디자인', G5_ADMIN_URL.'/config_logo.php',   'de_conf', 1),
	array('155201', $treeicon.'로고/파비콘', G5_ADMIN_URL.'/config_logo.php', 'de_conf_logo', 2),
	array('155202', $treeicon.'레이아웃추가설정', G5_ADMIN_URL.'/config_script.php', 'de_conf_script', 2),
	
	// 배너,팝업 등 관리
	array('155300', '<i class="fab fa-adversal"></i> 배너관리', G5_ADMIN_URL.'/shop_admin/bannerlist.php?dvc=pc&position=메인', 'pmt_banpop', 1),
    array('155351', $treeicon.'메인배너관리(PC)', G5_ADMIN_URL.'/shop_admin/bannerlist.php?dvc=pc&position=메인', 'main_banpop', 2),
    array('155352', $treeicon.'메인배너관리(모바일)', G5_ADMIN_URL.'/shop_admin/bannerlist.php?dvc=mobile&position=메인', 'main_mobanpop', 2),
    //array('155353', $treeicon.'샵배너관리(PC)', G5_ADMIN_URL.'/shop_admin/bannerlist.php?device=pc&position=샵', 'pmt_banpop', 2),
    //array('155354', $treeicon.'샵배너관리(모바일)', G5_ADMIN_URL.'/shop_admin/bannerlist.php?device=mobile&position=샵', 'pmt_banpop', 2),
    //array('155301', $treeicon.'(쇼핑몰) 메인배너', G5_ADMIN_URL.'/shop_admin/bannerlist.php', 'pmt_banner', 2),
	array('155355', $treeicon.'(공통) 탑배너관리', G5_ADMIN_URL.'/top.banner_admin/top.banner.php', 'top.banner', 2),
	//array('155301', '배너관리', G5_ADMIN_URL.'/shop_admin/bannerlist.php', 'pmt_banner'),

	// 커뮤니티관리
	array('155700', '<i class="fab fa-adversal"></i> 커뮤니티관리', G5_ADMIN_URL.'/shop_admin/instalist.php', 'com_insta', 1),
    array('155701', $treeicon.'인스타그램관리', G5_ADMIN_URL.'/shop_admin/instalist.php', 'com_insta', 2),
    array('155702', $treeicon.'핏콩다방관리', G5_ADMIN_URL.'/shop_admin/dabanglist.php', 'com_dabang', 2),
    array('155703', $treeicon.'핏콩미식회관리', G5_ADMIN_URL.'/shop_admin/daintylist.php', 'com_daintyfood', 2),
    array('155704', $treeicon.'핏콩레시피관리', G5_ADMIN_URL.'/shop_admin/recipelist.php', 'com_recipe', 2),
    //array('155301', $treeicon.'(쇼핑몰) 메인배너', G5_ADMIN_URL.'/shop_admin/bannerlist.php', 'pmt_banner', 2),
	
	// 리뷰팝업관리
	array('155601', '리뷰팝업관리', G5_ADMIN_URL.'/shop_admin/review_popup_list.php', 'pmt_revpop'),
	// 팝업관리
	array('155401', '팝업창관리', G5_ADMIN_URL.'/newwinlist.php', 'pmt_poplayer'),
	// 태그관리
	array('155501', '추천검색어관리', G5_ADMIN_URL.'/search.tag.php', 'pmt_tag'),
	// 컨텐츠배너관리
	array('155801', '컨텐츠배너관리', G5_ADMIN_URL.'/shop_admin/con_bannerlist.php', 'pmt_conbanner')
	

);
?>