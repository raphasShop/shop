<?php
$sub_menu = '600200';
include_once('./_common.php');

check_demo();

check_admin_token();

if (!count($_POST['chk'])) {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($_POST['act_button'] == "선택수정") {
	
	auth_check($auth[$sub_menu], 'w');
	
	for ($i=0; $i<count($_POST['chk']); $i++) {
		
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		
		$sql = "update comcose_sellprice_category_add
				set cose_cat_add_set_price_type	= '{$_POST['cose_cat_add_set_price_type'][$k]}',
					cose_cat_add_set_price		= '{$_POST['cose_cat_add_set_price'][$k]}',
					cose_cat_add_use			= '{$_POST['cose_cat_add_use'][$k]}'
				where cose_add_cat_id   = '{$_POST['cose_add_cat_id'][$k]}' ";
		sql_query($sql);
	}
} else if ($_POST['act_button'] == "선택삭제") {
	
	if ($is_admin != 'super')
		alert('등록된 카테고리 삭제는 최고관리자만 가능합니다.');
		
		auth_check($auth[$sub_menu], 'd');
		
		
		for ($i=0; $i<count($_POST['chk']); $i++) {
			// 실제 번호를 넘김
			$k = $_POST['chk'][$i];

			$sql = " delete from comcose_sellprice_category_add where cose_cat_add_cat_id = '{$_POST['cose_cat_add_cat_id'][$k]}' ";
			sql_query($sql);
		}
}

goto_url("./_comcose_sellprice_category_add.php?sst=$sst&amp;sod=$sod&amp;sfl=$sfl&amp;stx=$stx&amp;page=$page");
?>