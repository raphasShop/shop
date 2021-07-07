<?php
if (!defined('G5_USE_SHOP') || !G5_USE_SHOP) return; // 영카트일경우 활성화됨
// 소메뉴그룹의 하위메뉴표시 아이콘은 $treeicon 으로 정의
// $treeicon 이 정의한 이미지아이콘을 변경하려면 admin.menu100.php 파일에서 수정하세요

$menu['menu400'] = array (
    array('400000', '상품관리', G5_ADMIN_URL.'/shop_admin/itemlist.php', 'shop_config'),
    array('400200', '<i class="fas fa-sitemap"></i> 분류관리', G5_ADMIN_URL.'/shop_admin/categorylist.php', 'scf_cate'),
    array('400300a', '<i class="fas fa-barcode"></i> 상품관리', G5_ADMIN_URL.'/shop_admin/itemlist.php', 'scf', 1),
	array('400300', $treeicon.'전체상품관리', G5_ADMIN_URL.'/shop_admin/itemlist.php', 'scf_item', 2),
	array('400333', $treeicon.'상품등록 <i class="fa fa-upload"></i>', G5_ADMIN_URL.'/shop_admin/itemform.php', 'scf_item_form', 2),
    array('400610', $treeicon.'상품유형관리', G5_ADMIN_URL.'/shop_admin/itemtypelist.php', 'scf_item_type', 2),
	array('400620', $treeicon.'상품재고관리', G5_ADMIN_URL.'/shop_admin/itemstocklist.php', 'scf_item_stock', 2),
    array('400500', $treeicon.'상품옵션재고관리', G5_ADMIN_URL.'/shop_admin/optionstocklist.php', 'scf_item_option', 2),
	// 상품이미지/상품진열
	array('400910', '<i class="fab fa-microsoft"></i> 상품진열설정', G5_ADMIN_URL.'/shop_admin/config_dis_main.php', 'de_display', 1),
    array('400911', $treeicon.'메인 상품진열', G5_ADMIN_URL.'/shop_admin/config_dis_main.php', 'de_display_main', 2),
	array('400912', $treeicon.'상품목록 상품진열', G5_ADMIN_URL.'/shop_admin/config_dis_list.php', 'de_display_list', 2),
	array('400913', $treeicon.'상품이미지사이즈', G5_ADMIN_URL.'/shop_admin/config_listimgsize.php', 'de_display_imgsize', 2),
	//상품엑셀등록
	array('400335a', '<i class="fas fa-upload"></i> 상품일괄등록', G5_ADMIN_URL.'/shop_admin/item_EXCEL.php', 'scf_xls', 1),
	array('400335', $treeicon.'상품Excel등록', G5_ADMIN_URL.'/shop_admin/item_EXCEL.php', 'scf_itemexcel', 2),
	array('400336', $treeicon.'상품옵션Excel등록', G5_ADMIN_URL.'/shop_admin/itemoption_EXCEL.php', 'scf_optionexcel', 2),
	//상품 xml 가져오기,내보내기
	array('400800', '<i class="fas fa-book"></i> 쿠폰사용관리', G5_ADMIN_URL.'/shop_admin/couponuse.php', 'scf_couponuse')
	//array('400700', '<i class="far fa-save"></i> 상품XML', G5_ADMIN_URL.'/shop_admin/item_export.php', 'scf_xml', 1),
	//array('400710', $treeicon.'상품가져오기', G5_ADMIN_URL.'/shop_admin/item_import.php', 'scf_xml_import', 2),
	//array('400720', $treeicon.'상품내보내기', G5_ADMIN_URL.'/shop_admin/item_export.php', 'scf_xml_export', 2)
);
?>