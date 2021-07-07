<?php
$sub_menu = '600500';
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
	    $cose_item_add_set_price1 = preg_replace('/[^0-9]*/s', '', $_POST['cose_item_add_set_price1']);
	    $cose_item_add_set_price2 = preg_replace('/[^0-9]*/s', '', $_POST['cose_item_add_set_price2']);
	    $cose_item_add_set_price3 = preg_replace('/[^0-9]*/s', '', $_POST['cose_item_add_set_price3']);
	    $cose_item_add_set_price4 = preg_replace('/[^0-9]*/s', '', $_POST['cose_item_add_set_price4']);
	    $cose_item_add_set_price5 = preg_replace('/[^0-9]*/s', '', $_POST['cose_item_add_set_price5']);
	    $cose_item_add_set_price6 = preg_replace('/[^0-9]*/s', '', $_POST['cose_item_add_set_price6']);
	    $cose_item_add_set_price7 = preg_replace('/[^0-9]*/s', '', $_POST['cose_item_add_set_price7']);
	    $cose_item_add_set_price8 = preg_replace('/[^0-9]*/s', '', $_POST['cose_item_add_set_price8']);
	    $cose_item_add_set_price9 = preg_replace('/[^0-9]*/s', '', $_POST['cose_item_add_set_price9']);
		$k = $_POST['chk'][$i];
		$sql = "update comcose_sellprice_item_add
				set cose_item_add_it_name = '{$_POST['cose_item_add_it_name'][$k]}',
				cose_item_add_set_price_type1 = '{$_POST['cose_item_add_set_price_type1'][$k]}',
				cose_item_add_set_price1 = '{$cose_item_add_set_price1[$k]}',
				cose_item_add_set_price_type2 = '{$_POST['cose_item_add_set_price_type2'][$k]}',
				cose_item_add_set_price2 = '{$cose_item_add_set_price2[$k]}',
				cose_item_add_set_price_type3 = '{$_POST['cose_item_add_set_price_type3'][$k]}',
				cose_item_add_set_price3 = '{$cose_item_add_set_price3[$k]}',
				cose_item_add_set_price_type4 = '{$_POST['cose_item_add_set_price_type4'][$k]}',
				cose_item_add_set_price4 = '{$cose_item_add_set_price4[$k]}',
				cose_item_add_set_price_type5 = '{$_POST['cose_item_add_set_price_type5'][$k]}',
				cose_item_add_set_price5 = '{$cose_item_add_set_price5[$k]}',
				cose_item_add_set_price_type6 = '{$_POST['cose_item_add_set_price_type6'][$k]}',
				cose_item_add_set_price6 = '{$cose_item_add_set_price6[$k]}',
				cose_item_add_set_price_type7 = '{$_POST['cose_item_add_set_price_type7'][$k]}',
				cose_item_add_set_price7 = '{$cose_item_add_set_price7[$k]}',
				cose_item_add_set_price_type8 = '{$_POST['cose_item_add_set_price_type8'][$k]}',
				cose_item_add_set_price8 = '{$cose_item_add_set_price8[$k]}',
				cose_item_add_set_price_type9 = '{$_POST['cose_item_add_set_price_type9'][$k]}',
				cose_item_add_set_price9 = '{$cose_item_add_set_price9[$k]}',
				cose_item_add_ca_id = '{$_POST['cose_item_add_ca_id'][$k]}'
				where cose_add_item_id   = '{$_POST['cose_add_item_id'][$k]}' ";
		sql_query($sql);
	}
} else if ($_POST['act_button'] == "선택삭제") {
	
	if ($is_admin != 'super')
		alert('등록된 카테고리 삭제는 최고관리자만 가능합니다.');
		
		auth_check($auth[$sub_menu], 'd');
		
		
		for ($i=0; $i<count($_POST['chk']); $i++) {
			// 실제 번호를 넘김
			$k = $_POST['chk'][$i];

			$sql = " delete from comcose_sellprice_item_add where cose_item_add_it_id = '{$_POST['cose_item_add_it_id'][$k]}' ";
			sql_query($sql);
		}
}

goto_url("./_comcose_sellprice_item_add.php?sst=$sst&amp;sod=$sod&amp;sfl=$sfl&amp;stx=$stx&amp;page=$page");
?>