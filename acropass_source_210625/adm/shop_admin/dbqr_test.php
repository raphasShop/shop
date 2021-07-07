<?php 

include_once('./_common.php');

$sql3 = " SELECT b.io_price, b.od_id, b.it_id, b.ct_option, b.ct_qty, b.ct_price, b.cp_price, a.od_pg, a.od_status
               FROM {$g5['g5_shop_cart_table']} b, {$g5['g5_shop_order_table']} a
              where a.od_tel =  '$od_tel' or a.od_hp = '$od_hp' ";
       // $result3 = sql_query($sql3);
echo $sql3;

?>