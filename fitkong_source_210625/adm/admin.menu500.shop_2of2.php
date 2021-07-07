<?php

$menu['menu500'] = array (
    array('500000', '접속자', G5_ADMIN_URL.'/visit_list.php', 'vist_center'),
	array('500000a', '접속자집계', G5_ADMIN_URL.'/visit_list.php', 'usr_visit', 1),
	array('500800', $treeicon.'접속자', G5_ADMIN_URL.'/visit_list.php'.$query_string, 'usr_list', 2),
	array('500801', $treeicon.'도메인', G5_ADMIN_URL.'/visit_domain.php'.$query_string, 'usr_domain', 2),
	array('500802', $treeicon.'브라우저', G5_ADMIN_URL.'/visit_browser.php'.$query_string, 'usr_browser', 2),
	array('500803', $treeicon.'OS', G5_ADMIN_URL.'/visit_os.php'.$query_string, 'usr_os', 2),
	array('500804', $treeicon.'접속기기', G5_ADMIN_URL.'/visit_device.php'.$query_string, 'usr_device', 2),
	array('500805', $treeicon.'시간대', G5_ADMIN_URL.'/visit_hour.php'.$query_string, 'usr_hour', 2),
	array('500806', $treeicon.'요일', G5_ADMIN_URL.'/visit_week.php'.$query_string, 'usr_week', 2),
	array('500807', $treeicon.'일별', G5_ADMIN_URL.'/visit_date.php'.$query_string, 'usr_date', 2),
	array('500808', $treeicon.'월별', G5_ADMIN_URL.'/visit_month.php'.$query_string, 'usr_month', 2),
	array('500809', $treeicon.'연도별', G5_ADMIN_URL.'/visit_year.php'.$query_string, 'usr_year', 2),	
    array('500830', '접속자검색', G5_ADMIN_URL.'/visit_search.php', 'usr_search'),
    array('500840', '접속자로그삭제', G5_ADMIN_URL.'/visit_delete.php', 'usr_delete')
);
?>