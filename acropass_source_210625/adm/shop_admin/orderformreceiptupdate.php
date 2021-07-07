<?php
$sub_menu = '411400'; /* 수정전 원본 메뉴코드 400400 */
include_once('./_common.php');
include_once('./admin.shop.lib.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');

auth_check($auth[$sub_menu], "w");

check_admin_token();

$sql = " select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' ";
$od  = sql_fetch($sql);
if(!$od['od_id'])
    alert('주문자료가 존재하지 않습니다.');

if ($od_receipt_time) {
    if (check_datetime($od_receipt_time) == false)
        alert('결제일시 오류입니다.');
}

// 결제정보 반영
$sql = " update {$g5['g5_shop_order_table']}
            set od_deposit_name    = '{$_POST['od_deposit_name']}',
                od_bank_account    = '{$_POST['od_bank_account']}',
                od_receipt_time    = '{$_POST['od_receipt_time']}',
                od_receipt_price   = '{$_POST['od_receipt_price']}',
                od_receipt_point   = '{$_POST['od_receipt_point']}',
                od_refund_price    = '{$_POST['od_refund_price']}',
                od_delivery_company= '{$_POST['od_delivery_company']}',
                od_invoice         = '{$_POST['od_invoice']}',
                od_invoice_time    = '{$_POST['od_invoice_time']}',
                od_send_cost       = '{$_POST['od_send_cost']}',
                od_send_cost2      = '{$_POST['od_send_cost2']}'
            where od_id = '$od_id' ";
sql_query($sql);

// 주문정보
$info = get_order_info($od_id);
if(!$info)
    alert('주문자료가 존재하지 않습니다.');

$od_status = $od['od_status'];
$cart_status = false;

// 미수가 0이고 상태가 주문이었다면 입금으로 변경
if($info['od_misu'] == 0 && $od['od_status'] == '주문')
{
    $od_status = '입금';
    $cart_status = true;
}

// 배송정보가 있으면 주문상태 배송으로 변경
$order_status = array('입금', '준비');
if($_POST['od_delivery_company'] && $_POST['od_invoice'] && in_array($od['od_status'], $order_status))
{
    $od_status = '배송';
    $cart_status = true;
    $info_status = $od['od_status'];

    if($od['od_status'] == '준비') {
        //----------------------------------------------------------
        // 알림톡전송 시작
        //----------------------------------------------------------
        //echo "<script>console.log( 'Debug Objects: " . $od_status. "' );</script>";
        $today = date("Y/m/d");
        $last_bank_day = date("Y/m/d", time() + 172800);
        $kakao_rcv_number = preg_replace("/[^0-9]/", "", $od['od_hp']);
        $sql = " select it_name from {$g5['g5_shop_cart_table']} where od_id = '$od_id'";
        $ite = sql_fetch($sql);

        $msg = "[아크로패스]\r\n안녕하세요 ".$od['od_name']."님!\r\n주문하신 상품이 발송되었습니다.\r\n- 상품명: ".$ite['it_name']."\r\n- 택배사: ".$_POST['od_delivery_company']."\r\n- 운송장번호: ".$_POST['od_invoice']."\r\n고객님의 소중한 상품은 공휴일 제외 1~3일만에 수령받으실 수 있으니 조금만 기다려 주시기바랍니다.";
        $rst = kakaomsg('http://api.apistore.co.kr/kko/1/msg/raphas', array('PHONE'=>$kakao_rcv_number, 'CALLBACK'=>'01024780137', 'MSG'=>$msg, 'TEMPLATE_CODE'=>'AC0004', 'BTN_TYPES'=>'배송조회', 'BTN_TXTS'=>'배송조회'));


        //----------------------------------------------------------
        // 알림톡전송 끝
        //----------------------------------------------------------
    }
}

// 미수금액
$od_misu = ( $od['od_cart_price'] - $od['od_cancel_price'] + $_POST['od_send_cost'] + $_POST['od_send_cost2'] )
           - ( $od['od_cart_coupon'] + $od['od_coupon'] + $od['od_send_coupon'] )
           - ( $_POST['od_receipt_price'] + $_POST['od_receipt_point'] - $_POST['od_refund_price'] );

// 미수금 정보 등 반영
$sql = " update {$g5['g5_shop_order_table']}
            set od_misu         = '$od_misu',
                od_tax_mny      = '{$info['od_tax_mny']}',
                od_vat_mny      = '{$info['od_vat_mny']}',
                od_free_mny     = '{$info['od_free_mny']}',
                od_status       = '$od_status'
            where od_id = '$od_id' ";
sql_query($sql);

// 장바구니 상태 변경
if($cart_status) {
    $sql = " update {$g5['g5_shop_cart_table']}
                set ct_status = '$od_status'
                where od_id = '$od_id' ";

    switch($od_status) {
        case '입금':
            $sql .= " and ct_status = '주문' ";
            break;
        case '배송':
            $sql .= " and ct_status IN ('".implode("', '", $order_status)."') ";
            break;
        default:
            ;
    }

    sql_query($sql);
}


// 배송때 재고반영
if($info['od_misu'] == 0 && $od_status == '배송') {
    $sql = " select * from {$g5['g5_shop_cart_table']} where od_id = '$od_id' ";
    $result = sql_query($sql);

    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        // 재고를 사용하지 않았다면
        $stock_use = $row['ct_stock_use'];

        if(!$row['ct_stock_use'])
        {
            // 재고에서 뺀다.
            subtract_io_stock($row['it_id'], $row['ct_qty'], $row['io_id'], $row['io_type']);
            $stock_use = 1;

            $sql = " update {$g5['g5_shop_cart_table']} set ct_stock_use  = '$stock_use' where ct_id = '{$row['ct_id']}' ";
            sql_query($sql);
        }
    }

    unset($sql);
    unset($result);
    unset($row);
}


// 메일발송
define("_ORDERMAIL_", true);
include "./ordermail.inc.php";


// SMS 문자전송
define("_ORDERSMS_", true);
include "./ordersms.inc.php";


// 에스크로 배송처리
if($_POST['od_tno'] && $_POST['od_escrow'] == 1)
{
    $escrow_tno  = $_POST['od_tno'];
    $escrow_corp = $_POST['od_delivery_company'];
    $escrow_numb = $_POST['od_invoice'];

    include(G5_SHOP_PATH.'/'.$od['od_pg'].'/escrow.register.php');
}


$qstr = "sort1=$sort1&amp;sort2=$sort2&amp;sel_field=$sel_field&amp;search=$search&amp;page=$page";

goto_url("./orderform.php?od_id=$od_id&amp;$qstr");
?>
