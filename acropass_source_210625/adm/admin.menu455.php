<?php
if (!defined('G5_USE_SHOP') || !G5_USE_SHOP) return;

$menu['menu455'] = array (
    array('455000', '고객대응', G5_ADMIN_URL.'/shop_admin/itemqalist.php', 'shopcs_config'),	
	array('455660', '상품문의', G5_ADMIN_URL.'/shop_admin/itemqalist.php', 'scs_item_qna'),
    array('455650', '사용후기', G5_ADMIN_URL.'/shop_admin/itemuselist.php', 'scs_ps'),
	array('455400', '재입고SMS알림', G5_ADMIN_URL.'/shop_admin/itemstocksms.php', 'scs_stock_sms')
);
?>