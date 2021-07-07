<?php
$sub_menu = '600200';
include_once('./_common.php');

check_demo();

check_admin_token();

if (!count($_POST['chk'])) {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($_POST['act_button'] == "선택삭제") {
	
	if ($is_admin != 'super')
		alert('등록된 카테고리 삭제는 최고관리자만 가능합니다.');
		
		auth_check($auth[$sub_menu], 'd');
		
		
		for ($i=0; $i<count($_POST['chk']); $i++) {
			// 실제 번호를 넘김
			$k = $_POST['chk'][$i];

			$sql = " delete from comcose_sellprice_category_except where cose_except_cat_id = '{$_POST['cose_except_cat_id'][$k]}' ";
			sql_query($sql);
		}
}

goto_url("./_comcose_sellprice_category_except.php?sst=$sst&amp;sod=$sod&amp;sfl=$sfl&amp;stx=$stx&amp;page=$page");
?>