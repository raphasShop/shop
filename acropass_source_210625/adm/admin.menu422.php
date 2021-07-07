<?php
if (!defined('G5_USE_SHOP') || !G5_USE_SHOP) return;
// 소메뉴그룹의 하위메뉴표시 아이콘은 $treeicon 으로 정의
// $treeicon 이 정의한 이미지아이콘을 변경하려면 admin.menu100.php 파일에서 수정하세요

$menu['menu422'] = array (
    array('422000', '프로모션', G5_ADMIN_URL.'/shop_admin/couponlist.php', 'shop_config'),
	array('422800a', '<i class="fas fa-book"></i> 쿠폰', G5_ADMIN_URL.'/shop_admin/couponlist.php', 'pmt_couponall', 1),
	array('422800', $treeicon.'할인쿠폰관리', G5_ADMIN_URL.'/shop_admin/couponlist.php', 'pmt_coupon', 2),
    array('422810', $treeicon.'쿠폰코드관리', G5_ADMIN_URL.'/shop_admin/couponzonelist.php', 'pmt_coupon_zone', 2),
	
	array('422300a', '<i class="fas fa-birthday-cake"></i> 이벤트/기획전', G5_ADMIN_URL.'/shop_admin/itemevent.php', 'pmt_eventall', 1),
	array('422300', $treeicon.'이벤트(기획전)관리', G5_ADMIN_URL.'/shop_admin/itemevent.php', 'pmt_event', 2),
    array('422310', $treeicon.'이벤트(기획전)일괄처리', G5_ADMIN_URL.'/shop_admin/itemeventlist.php', 'pmt_event_mng', 2),

    array('422500a', '<i class="fas fa-project-diagram"></i> 프로모션개별URL', G5_ADMIN_URL.'/shop_admin/promotionaddlist.php', 'pmt_addlist', 1),
    array('422500', $treeicon.'프로모션개별URL 관리', G5_ADMIN_URL.'/shop_admin/promotionaddlist.php', 'pmt_addlist', 2),

    array('422400', '<i class="fas fa-clipboard-list"></i> 리뷰혜택관리', G5_ADMIN_URL.'/shop_admin/revieweventlist.php', 'pmt_review_event_mng'),

	array('422900', '<i class="fas fa-pie-chart"></i> 투표관리', G5_ADMIN_URL.'/poll_list.php', 'mb_poll')
);
?>