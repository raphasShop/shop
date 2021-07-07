<?php
$sub_menu = '600500';
include_once('./_common.php');



check_demo();

check_admin_token();

if (!count($_POST['chk'])) {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

	
	for ($i=0; $i<count($_POST['chk']); $i++) {
		
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];
		
		$sql = "insert into comcose_sellprice_item_add
		set cose_item_add_it_id = '{$_POST['cose_item_add_it_id'][$k]}',
		cose_item_add_it_name = '{$_POST['cose_item_add_it_name'][$k]}',
		cose_item_add_set_price_type1 = '{$_POST['cose_item_add_set_price_type1'][$k]}',
		cose_item_add_set_price1 = '{$_POST['cose_item_add_set_price1'][$k]}',
		cose_item_add_set_price_type2 = '{$_POST['cose_item_add_set_price_type2'][$k]}',
		cose_item_add_set_price2 = '{$_POST['cose_item_add_set_price2'][$k]}',
		cose_item_add_set_price_type3 = '{$_POST['cose_item_add_set_price_type3'][$k]}',
		cose_item_add_set_price3 = '{$_POST['cose_item_add_set_price3'][$k]}',
		cose_item_add_set_price_type4 = '{$_POST['cose_item_add_set_price_type4'][$k]}',
		cose_item_add_set_price4 = '{$_POST['cose_item_add_set_price4'][$k]}',
		cose_item_add_set_price_type5 = '{$_POST['cose_item_add_set_price_type5'][$k]}',
		cose_item_add_set_price5 = '{$_POST['cose_item_add_set_price5'][$k]}',
		cose_item_add_set_price_type6 = '{$_POST['cose_item_add_set_price_type6'][$k]}',
		cose_item_add_set_price6 = '{$_POST['cose_item_add_set_price6'][$k]}',
		cose_item_add_set_price_type7 = '{$_POST['cose_item_add_set_price_type7'][$k]}',
		cose_item_add_set_price7 = '{$_POST['cose_item_add_set_price7'][$k]}',
		cose_item_add_set_price_type8 = '{$_POST['cose_item_add_set_price_type8'][$k]}',
		cose_item_add_set_price8 = '{$_POST['cose_item_add_set_price8'][$k]}',
		cose_item_add_set_price_type9 = '{$_POST['cose_item_add_set_price_type9'][$k]}',
		cose_item_add_set_price9 = '{$_POST['cose_item_add_set_price9'][$k]}',
		cose_item_add_ca_id = '{$_POST['cose_item_add_ca_id'][$k]}' ";
		sql_query($sql);
	}


	goto_url("./_comcose_sellprice_item_add.php");
?>