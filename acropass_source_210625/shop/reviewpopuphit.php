<?php
include_once("./_common.php");

$rvp_id = (int) $rvp_id;
$bod = (int) $bod;
$datetime = date("Y-m-d H:i:s");

$sql = " insert into {$g5['g5_shop_review_popup_log_table']}
                set rvp_id         = '$rvp_id',
                	rvp_order	   = '$bod',
                	rvpl_time	   = '$datetime',
                    it_id          = '$it_id' ";
sql_query($sql);


$sql = " select rvp_url from {$g5['g5_shop_review_popup_table']} where rvp_id = '$rvp_id' ";
$row = sql_fetch($sql);

if( ! $row['rvp_url'] ){
    alert('해당 연결 주소가 존재하지 않습니다.', G5_SHOP_URL);
}


$url = clean_xss_tags($row['rvp_url']);

goto_url($url);
?>
