<?php
if (!defined('G5_USE_SHOP') || !G5_USE_SHOP) return;
// 소메뉴그룹의 하위메뉴표시 아이콘은 $treeicon 으로 정의
// $treeicon 이 정의한 이미지아이콘을 변경하려면 admin.menu100.php 파일에서 수정하세요

// 장바구니보관기간 표시 (환경설정 > 쇼핑몰기본설정 > 권한/기타 항목중에 장바구니 보관기간 설정값을 가져옴
$de_cart_keep_term = '<span class="round_cnt_lightpink font-normal">'.$default['de_cart_keep_term'].'일</span>';

$menu['menu416'] = array (
    array('416000', '판매전략', G5_ADMIN_URL.'/shop_admin/itemsellrank.php', 'market_config'),
	//array('416000', '판매전략실', G5_ADMIN_URL.'/shop_admin/bigdata.php', 'market_config'),
	//array('416100', '빅데이타', G5_ADMIN_URL.'/shop_admin/bigdata.php', 'market_bigdata'),
	array('416310a', '<i class="far fa-thumbs-up"></i> 랭킹', G5_ADMIN_URL.'/shop_admin/itemsellrank.php', 'ranking', 1),
	array('416310', $treeicon.'판매순위', G5_ADMIN_URL.'/shop_admin/itemsellrank.php', 'market_rank', 2),
	array('416320', $treeicon.'옵션판매순위', G5_ADMIN_URL.'/shop_admin/itemselloptionrank.php', 'market_rank2', 2),
	array('416420', $treeicon.'장바구니순위', G5_ADMIN_URL.'/shop_admin/cartlist.php', 'market_cart', 2),
	array('416410', $treeicon.'위시리스트순위', G5_ADMIN_URL.'/shop_admin/wishlist.php', 'market_wish', 2),
	array('416220', $treeicon.'인기검색어순위', ''.G5_ADMIN_URL.'/popular_rank.php', 'market_poprank', 2),
	array('416160a', '<i class="fas fa-eye"></i> 잠재적구매행동', G5_ADMIN_URL.'/shop_admin/cartlist_allview.php', 'market_cartallview', 1),
	array('416160', $treeicon.'장바구니관리', G5_ADMIN_URL.'/shop_admin/cartlist_allview.php', 'market_cartallview', 2),
	array('416180', $treeicon.'장바구니삭제 '.$de_cart_keep_term, G5_ADMIN_URL.'/shop_admin/cartlist_alldel.php', 'market_cartaldel', 2),
	array('416170', $treeicon.'위시리스트관리', G5_ADMIN_URL.'/shop_admin/wishlist_allview.php', 'market_wishallview', 2),
	array('416210', $treeicon.'인기검색어관리', ''.G5_ADMIN_URL.'/popular_list.php', 'market_poplist', 2)
);
?>