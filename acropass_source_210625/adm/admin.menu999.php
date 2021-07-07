<?php
$menu['menu999'] = array (
	array('999000', '최적화', G5_ADMIN_URL.'/server_info.php', 'diet'),
	array('999110', '<i class="fas fa-chart-pie"></i> 내서버정보', G5_ADMIN_URL.'/server_info.php', 'di_hostinginfo'),
	array('999500', '<i class="fas fa-clipboard-list"></i> phpinfo()', G5_ADMIN_URL.'/phpinfo.php', 'di_phpinfo'),
	
	array('999700', '<i class="far fa-trash-alt"></i> 일괄삭제', '#', 'di_all', 1),
	
    array('999800', $treeicon.'세션파일 일괄삭제', G5_ADMIN_URL.'/session_file_delete.php', 'di_session', 2),
    array('999900', $treeicon.'캐시파일 일괄삭제', G5_ADMIN_URL.'/cache_file_delete.php', 'di_cache', 2),
    array('999910', $treeicon.'캡챠파일 일괄삭제', G5_ADMIN_URL.'/captcha_file_delete.php', 'di_captcha', 2),
    array('999920', $treeicon.'썸네일파일 일괄삭제', G5_ADMIN_URL.'/thumbnail_file_delete.php', 'di_thumbnail', 2)    
);

if(version_compare(phpversion(), '5.3.0', '>=') && defined('G5_BROWSCAP_USE') && G5_BROWSCAP_USE) {
    $menu['menu999'][] = array('999520', '접속로그 변환', G5_ADMIN_URL.'/browscap_convert.php', 'di_visit_cnvrt');
}

    $menu['menu999'][] = array('999400', '<i class="fas fa-broadcast-tower"></i> 업데이트', G5_ADMIN_URL.'/browscap.php', 'di_update', 1);
if(version_compare(phpversion(), '5.3.0', '>=') && defined('G5_BROWSCAP_USE') && G5_BROWSCAP_USE) {
    $menu['menu999'][] = array('999510', $treeicon.'Browscap 업데이트', G5_ADMIN_URL.'/browscap.php', 'di_browscap', 2);
}
    $menu['menu999'][] = array('999410', $treeicon.'영카트 DB업그레이드', G5_ADMIN_URL.'/dbupgrade.php', 'db_upgrade', 2);
    $menu['menu999'][] = array('999710', $treeicon.'아이스크림 DB업데이트', G5_ADMIN_URL.'/icecream/icecream_DB_upgrade.php', 'ice_db_upgrade', 2);
	$menu['menu999'][] = array('999600', '<i class="fas fa-cloud-download-alt"></i> 백업', G5_ADMIN_URL.'/ar.hc_sql_dump.php', 'db_dump', 1);
    $menu['menu999'][] = array('999610', $treeicon.'HowCode SQL 덤프', G5_ADMIN_URL.'/ar.hc_sql_dump.php', 'db_dump', 2);

?>