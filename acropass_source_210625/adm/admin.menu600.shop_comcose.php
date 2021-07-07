<?php
if (!defined('G5_USE_SHOP') || !G5_USE_SHOP) return;

$menu['menu600'] = array (
    array('600000', '판매금액설정', 'sellprice_stats'),
    array('600600', '판매금액설정 안내', G5_ADMIN_URL.'/shop_admin/_comcose_sellprice_setting.php', 'sellprice_info'),
    array('600100', '회원권한별 금액설정', G5_ADMIN_URL.'/shop_admin/_comcose_sellprice_level.php', 'level_setting'),
	array('600500', '상품별 금액설정', G5_ADMIN_URL.'/shop_admin/_comcose_sellprice_item_add.php', 'item_setting'),
    array('600200', '분류별 금액설정', G5_ADMIN_URL.'/shop_admin/_comcose_sellprice_category_add.php', 'category_setting'),
    array('600300', '제외 분류설정', G5_ADMIN_URL.'/shop_admin/_comcose_sellprice_category_except.php', 'category_except'),
    array('600400', '제외 상품설정', G5_ADMIN_URL.'/shop_admin/_comcose_sellprice_item_except.php', 'item_except'),
    array('600900', '상품유형관리', G5_ADMIN_URL.'/shop_admin/_comcose_itemtypelist.php', 'item_except'),
);
?>