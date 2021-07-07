<?php
$sub_menu = '600100';
include_once('./_common.php');

$cose_add_level_id = $_POST['cose_add_level_id'];
$cose_add_level_use = $_POST['cose_add_level_use'];
$cose_add_level_login = $_POST['cose_add_level_login'];
$cose_add_level_1_type = $_POST['cose_add_level_1_type'];
$cose_add_level_1 = $_POST['cose_add_level_1'];
$cose_add_level_2_type = $_POST['cose_add_level_2_type'];
$cose_add_level_2 = $_POST['cose_add_level_2'];
$cose_add_level_3_type = $_POST['cose_add_level_3_type'];
$cose_add_level_3 = $_POST['cose_add_level_3'];
$cose_add_level_4_type = $_POST['cose_add_level_4_type'];
$cose_add_level_4 = $_POST['cose_add_level_4'];
$cose_add_level_5_type = $_POST['cose_add_level_5_type'];
$cose_add_level_5 = $_POST['cose_add_level_5'];
$cose_add_level_6_type = $_POST['cose_add_level_6_type'];
$cose_add_level_6 = $_POST['cose_add_level_6'];
$cose_add_level_7_type = $_POST['cose_add_level_7_type'];
$cose_add_level_7 = $_POST['cose_add_level_7'];
$cose_add_level_8_type = $_POST['cose_add_level_8_type'];
$cose_add_level_8 = $_POST['cose_add_level_8'];
$cose_add_level_9_type = $_POST['cose_add_level_9_type'];
$cose_add_level_9 = $_POST['cose_add_level_9'];		
		
$sql = "insert into comcose_sellprice_level 
(`cose_add_level_id`, 
`cose_add_level_use`, 
`cose_add_level_login`, 
`cose_add_level_1_type`, 
`cose_add_level_1`, 
`cose_add_level_2_type`, 
`cose_add_level_2`, 
`cose_add_level_3_type`, 
`cose_add_level_3`, 
`cose_add_level_4_type`, 
`cose_add_level_4`, 
`cose_add_level_5_type`, 
`cose_add_level_5`, 
`cose_add_level_6_type`, 
`cose_add_level_6`, 
`cose_add_level_7_type`, 
`cose_add_level_7`, 
`cose_add_level_8_type`, 
`cose_add_level_8`, 
`cose_add_level_9_type`, 
`cose_add_level_9`
)
values
('$cose_add_level_id',
'$cose_add_level_use',
'$cose_add_level_login',
'$cose_add_level_1_type',
'$cose_add_level_1',
'$cose_add_level_2_type',
'$cose_add_level_2',
'$cose_add_level_3_type',
'$cose_add_level_3',
'$cose_add_level_4_type',
'$cose_add_level_4',
'$cose_add_level_5_type',
'$cose_add_level_5',
'$cose_add_level_6_type',
'$cose_add_level_6',
'$cose_add_level_7_type',
'$cose_add_level_7',
'$cose_add_level_8_type',
'$cose_add_level_8',
'$cose_add_level_9_type',
'$cose_add_level_9' 
)on duplicate key update 
cose_add_level_id = '$cose_add_level_id',
cose_add_level_use = '$cose_add_level_use', 
cose_add_level_login = '$cose_add_level_login', 
cose_add_level_1_type = '$cose_add_level_1_type', 
cose_add_level_1 = '$cose_add_level_1', 
cose_add_level_2_type = '$cose_add_level_2_type', 
cose_add_level_2 = '$cose_add_level_2', 
cose_add_level_3_type = '$cose_add_level_3_type', 
cose_add_level_3 = '$cose_add_level_3', 
cose_add_level_4_type = '$cose_add_level_4_type', 
cose_add_level_4 = '$cose_add_level_4', 
cose_add_level_5_type = '$cose_add_level_5_type', 
cose_add_level_5 = '$cose_add_level_5', 
cose_add_level_6_type = '$cose_add_level_6_type', 
cose_add_level_6 = '$cose_add_level_6', 
cose_add_level_7_type = '$cose_add_level_7_type', 
cose_add_level_7 = '$cose_add_level_7', 
cose_add_level_8_type = '$cose_add_level_8_type', 
cose_add_level_8 = '$cose_add_level_8', 
cose_add_level_9_type = '$cose_add_level_9_type', 
cose_add_level_9 = '$cose_add_level_9'";
		
sql_query($sql);

goto_url("./_comcose_sellprice_level.php");
?>