<?php

include_once('./_common.php');

if(!$is_admin) {
    alert("관리자만 접근 가능합니다.", G5_URL);
}

$sql_common = " from {$g5['g5_shop_coupon_zone_table']} ";
$sql_search = " where cz_subject = '카카오10% 할인쿠폰' and cz_code_start = '2021-05-01' ";
if (!$sst) {
    $sst  = "cz_id";
    $sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search}
            {$sql_order} ";

$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = " select *
            {$sql_common}
            {$sql_search}
            {$sql_order} ";

$result = sql_query($sql);
$update_count = 0;

for ($i=0; $row=sql_fetch_array($result); $i++) {

	$cz_id = $row['cz_id'];
    $sql0 = " select count(*) as cnt from {$g5['g5_shop_coupon_code_log_table']} where cz_id = '$cz_id' ";
    $row0 = sql_fetch($sql0);

    $cz_count = $row0['cnt'];

    if($cz_count == 0) {
    	$sql = "update acropass_shop_coupon_zone set cz_code_start = '2021-06-01', cz_code_end = '2021-06-30', cz_start = '2021-06-01', cz_end = '2021-06-30' where cz_id = '$cz_id' ";
    	$row = sql_fetch($sql);
    	$update_count++;
    }
}


echo $total_count;
echo "<br>";
echo $update_count;
?>