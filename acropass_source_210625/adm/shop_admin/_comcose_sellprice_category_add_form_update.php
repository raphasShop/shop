<?php
$sub_menu = '600200';
include_once('./_common.php');



		$sql = " insert into comcose_sellprice_category_add
		set cose_cat_add_cat_id = '{$_POST['cose_cat_add_cat_id']}',
		cose_cat_add_cat_caname = '{$_POST['cose_cat_add_cat_caname']}',
		cose_cat_add_set_price_type = '{$_POST['cose_cat_add_set_price_type']}',
		cose_cat_add_set_price = '{$_POST['cose_cat_add_set_price']}',
		cose_cat_add_use = '{$_POST['cose_cat_add_use']}' ";
		sql_query($sql);


goto_url("./_comcose_sellprice_category_add.php?sst=$sst&amp;sod=$sod&amp;sfl=$sfl&amp;stx=$stx&amp;page=$page");
?>