<?php
// 소메뉴그룹의 메뉴 트리구조 아이콘 정의 (메뉴에 2로 표시된것에 적용)
// admin.menuXXX.php 파일에 모두 적용
$treeicon = '<img src="'.G5_ADMIN_URL.'/img/left-plus.gif"> ';

$menu['menu300'] = array (
    array('300000', '게시판', ''.G5_ADMIN_URL.'/board_list.php', 'board'),
	//게시판설정
	array('100101', '게시판환경설정', ''.G5_ADMIN_URL.'/config_board.php', 'config_board'),	
	//게시판관리
	array('300100a', '게시판관리', ''.G5_ADMIN_URL.'/board_list.php', 'bbs_board', 1),
    array('300100', $treeicon.'게시판 목록', ''.G5_ADMIN_URL.'/board_list.php', 'bbs_boardlist', 2),
	array('300110', $treeicon.'게시판 추가', ''.G5_ADMIN_URL.'/board_form.php', 'bbs_boardadd', 2),
    array('300200', $treeicon.'게시판 그룹관리', ''.G5_ADMIN_URL.'/boardgroup_list.php', 'bbs_group', 2),
	//콘텐츠관리
	array('300500a', '콘텐츠관리', ''.G5_ADMIN_URL.'/contentlist.php', 'contents', 1),
    array('300600', $treeicon.'내용관리', G5_ADMIN_URL.'/contentlist.php', 'scf_contents', 2),
    array('300700', $treeicon.'FAQ관리', G5_ADMIN_URL.'/faqmasterlist.php', 'scf_faq', 2),
	array('300500', $treeicon.'1:1문의설정', ''.G5_ADMIN_URL.'/qa_config.php', 'qa', 2),
	//댓글현황
    array('300820', '글,댓글 현황', G5_ADMIN_URL.'/write_count.php', 'scf_write_count')
);
?>