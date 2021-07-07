<?php
include_once("_common.php");
$imgnumber1 = '1';
if ($_COOKIE['ck_bn_id'] != $imgnumber1)
{
    $sql = " update g5_shop_mtopbanner set bn_hit = bn_hit + 1";
    sql_query($sql);
    // 하루 동안
    set_cookie("ck_bn_id", $imgnumber1, 60*60*24);
}

goto_url($url);
?>
