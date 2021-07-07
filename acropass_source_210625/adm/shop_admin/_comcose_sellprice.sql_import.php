<?php
include_once('./_common.php');
auth_check($auth[$sub_menu], "r");
//Import-.sql-file-using-php - https://github.com/Thamaraiselvam/Import-.sql-file-using-php
$filename = './_comcose_sellprice.sql';
$templine = '';
$lines = file($filename);
foreach ($lines as $line)
{
	if (substr($line, 0, 2) == '--' || $line == '')
		continue;
		$templine .= $line;
		if (substr(trim($line), -1, 1) == ';')
		{
			sql_query($templine);
			$templine = '';
		}
}
goto_url("./_comcose_sellprice_setting.php");
?>

