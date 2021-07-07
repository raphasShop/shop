<?php
// 소메뉴그룹의 메뉴 트리구조 아이콘 정의 (메뉴에 2로 표시된것에 적용)
// admin.menuXXX.php 파일에 모두 적용
$treeicon = '<img src="'.G5_ADMIN_URL.'/img/left-plus.gif"> ';

$menu['menu111'] = array (
    array('111000', '쇼핑설정', G5_ADMIN_URL.'/shop_admin/configform.php',   'config_shop'),
	
	array('111100', '쇼핑몰설정', G5_ADMIN_URL.'/shop_admin/configform.php', 'scf_conf', 1),
	array('111110', $treeicon.'쇼핑몰기본설정', G5_ADMIN_URL.'/shop_admin/configform.php', 'scf_config', 2),
	array('111116', $treeicon.'쇼핑알림설정', G5_ADMIN_URL.'/shop_admin/config_shopping_alim.php', 'scf_alim', 2),	
	array('111114', $treeicon.'결제/적립금설정', G5_ADMIN_URL.'/shop_admin/config_pay.php', 'scf_pay', 2),
	array('111115', $treeicon.'PG/간편페이설정', G5_ADMIN_URL.'/shop_admin/config_pgpay.php', 'scf_pgpay', 2),
	array('111111', $treeicon.'배송설정', G5_ADMIN_URL.'/shop_admin/config_delivery.php', 'scf_delivery', 2),
	array('111112', $treeicon.'배송비추가관리', G5_ADMIN_URL.'/shop_admin/sendcostlist.php', 'scf_sendcost', 2),
	array('111113', $treeicon.'반품/교환/환불설정', G5_ADMIN_URL.'/shop_admin/config_return.php', 'scf_return', 2),
	array('111502', $treeicon.'추천쇼핑몰설정', G5_ADMIN_URL.'/shop_admin/config_link.php', 'scf_config_link', 2)
);
?>