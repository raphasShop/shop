<?php
$sub_menu = "100200";
include_once('./_common.php');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$mb = get_member($mb_id);
if (!$mb['mb_id'])
    alert('존재하는 회원아이디가 아닙니다.');

check_admin_token();

/* 원본 (1개씩 등록하는 방식)
$sql = " insert into {$g5['auth_table']}
            set mb_id   = '{$_POST['mb_id']}',
                au_menu = '{$_POST['au_menu']}',
                au_auth = '{$_POST['r']},{$_POST['w']},{$_POST['d']}' ";
$result = sql_query($sql, FALSE);
if (!$result) {
    $sql = " update {$g5['auth_table']}
                set au_auth = '{$_POST['r']},{$_POST['w']},{$_POST['d']}'
              where mb_id   = '{$_POST['mb_id']}'
                and au_menu = '{$_POST['au_menu']}' ";
    sql_query($sql);
}
*/

##############################################################################

// 한번에 여러개를 선택하여 권한을 주는 방식으로 변경 - 아이스크림 2018-02-26

##############################################################################

if (!count($_POST['auth_chk'])) {
    alert("메뉴가 선택되지 않았습니다. 먼저 메뉴를 선택하세요");
}

for ($i=0; $i<count($_POST['auth_chk']); $i++) {
	// 실제 번호를 넘김
	$k = $_POST['auth_chk'][$i];

	$sql = " insert into {$g5['auth_table']}
				set mb_id   = '{$_POST['mb_id']}',
					au_menu = '{$_POST['au_menu'][$k]}',
					au_auth = '{$_POST['r']},{$_POST['w']},{$_POST['d']}' ";
	$result = sql_query($sql, FALSE);
	if (!$result) {
		$sql = " update {$g5['auth_table']}
					set au_auth = '{$_POST['r']},{$_POST['w']},{$_POST['d']}'
				  where mb_id   = '{$_POST['mb_id']}'
					and au_menu = '{$_POST['au_menu'][$k]}' ";
		sql_query($sql);
	}
}

//sql_query(" OPTIMIZE TABLE `$g5['auth_table']` ");

goto_url('./auth2_list.php?'.$qstr);
?>
