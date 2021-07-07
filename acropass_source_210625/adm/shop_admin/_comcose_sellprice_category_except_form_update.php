<?php
$sub_menu = '600200';
include_once('./_common.php');



		$sql = " insert into comcose_sellprice_category_except
		set cose_except_add_cat_id = '{$_POST['cose_except_add_cat_id']}',
		cose_except_add_cat_caname = '{$_POST['cose_except_add_cat_caname']}' ";
		sql_query($sql);


goto_url("./_comcose_sellprice_category_except.php?sst=$sst&amp;sod=$sod&amp;sfl=$sfl&amp;stx=$stx&amp;page=$page");
?>