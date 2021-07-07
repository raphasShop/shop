<?php
$menu['menu200'] = array (
    array('200000', '회 원', G5_ADMIN_URL.'/member_list.php', 'member'),
	//회원관리
    array('200100a', '회원관리', G5_ADMIN_URL.'/member_list.php', 'mb_member', 1),
	array('200100', $treeicon.'전체회원', G5_ADMIN_URL.'/member_list.php', 'mb_list', 2),
	array('200150', $treeicon.'회원등급설정', G5_ADMIN_URL.'/member_lev_conf.php', 'mb_lev_conf', 2),
	array('200160', $treeicon.'포인트관리', G5_ADMIN_URL.'/point_list.php', 'mb_point', 2),
	//회원메일발송
	array('200300', '회원메일발송', G5_ADMIN_URL.'/mail_list.php', 'mb_mail'),
	//회원가입설정
	array('200200', '회원가입설정', G5_ADMIN_URL.'/config_reg_basic.php', 'scf_reg', 1),
	array('200201', $treeicon.'회원가입정책설정', G5_ADMIN_URL.'/config_reg_basic.php', 'cf_config_reg', 2),
	array('200202', $treeicon.'회원가입약관', G5_ADMIN_URL.'/config_reg_privacy.php', 'cf_config_reg_privacy', 2),
	array('200203', $treeicon.'본인확인서비스', G5_ADMIN_URL.'/config_ipin.php', 'cf_config_ipin', 2),
	array('200205', $treeicon.'회원가입혜택', G5_ADMIN_URL.'/shop_admin/config_reg_benefit.php', 'scf_reg_benefit', 2)
  
);
?>