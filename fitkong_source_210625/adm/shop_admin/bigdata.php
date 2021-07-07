<?php
$sub_menu = '416100'; /* 원본메뉴코드 500110 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '빅데이터';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
##################################################
// [취소신청] 취소진행중 표시 - 반품/환불/교환 신청 및 진행중 표시 [아이스크림소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_ordercancle.php');
##################################################
###############################################################################################
/* 결제수단별 합계 [크림장수소스]*/
###############################################################################################
// 일자별 결제수단 주문 합계 금액
function get_order_settle_sum($date)
{
    global $g5, $default;

    $case = array('신용카드', '계좌이체', '가상계좌', '무통장', '휴대폰');
    $info = array();

    // 결제수단별 합계
    foreach($case as $val)
    {
        $sql = " select sum(od_cart_price + od_send_cost + od_send_cost2 - od_receipt_point - od_cart_coupon - od_coupon - od_send_coupon) as price,
                        count(*) as cnt
                    from {$g5['g5_shop_order_table']}
                    where SUBSTRING(od_time, 1, 10) = '$date'
                      and od_settle_case = '$val' ";
        $row = sql_fetch($sql);

        $info[$val]['price'] = (int)$row['price'];
        $info[$val]['count'] = (int)$row['cnt'];
    }

    // 포인트 합계
    $sql = " select sum(od_receipt_point) as price,
                    count(*) as cnt
                from {$g5['g5_shop_order_table']}
                where SUBSTRING(od_time, 1, 10) = '$date'
                  and od_receipt_point > 0 ";
    $row = sql_fetch($sql);
    $info['포인트']['price'] = (int)$row['price'];
    $info['포인트']['count'] = (int)$row['cnt'];

    // 쿠폰 합계
    $sql = " select sum(od_cart_coupon + od_coupon + od_send_coupon) as price,
                    count(*) as cnt
                from {$g5['g5_shop_order_table']}
                where SUBSTRING(od_time, 1, 10) = '$date'
                  and ( od_cart_coupon > 0 or od_coupon > 0 or od_send_coupon > 0 ) ";
    $row = sql_fetch($sql);
    $info['쿠폰']['price'] = (int)$row['price'];
    $info['쿠폰']['count'] = (int)$row['cnt'];

    return $info;
}
###############################################################################################
/* 주문 그래프 [크림장수소스]*/
###############################################################################################
function get_max_value($arr)
{
    foreach($arr as $key => $val)
    {
        if(is_array($val))
        {
            $arr[$key] = get_max_value($val);
        }
    }

    sort($arr);

    return array_pop($arr);
}
// 일자별 주문 합계 금액
function get_order_date_sum($date)
{
    global $g5;

    $sql = " select sum(od_cart_price + od_send_cost + od_send_cost2) as orderprice,
                    sum(od_cancel_price) as cancelprice
                from {$g5['g5_shop_order_table']}
                where SUBSTRING(od_time, 1, 10) = '$date' ";
    $row = sql_fetch($sql);

    $info = array();
    $info['order'] = (int)$row['orderprice'];
    $info['cancel'] = (int)$row['cancelprice'];

    return $info;
}

################################################
/* 매출관리 메인페이지에서만 추출하는 데이터 */
// admin.sum_order.php에 추가하면 모든페이지에서 데이타를 불러오기위한 과부하가 예상되어
// 따로 매출관리페이지에만 표시함
################################################
// 전체 매출 건수/금액(상태와 상관없이 전체주문)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_cancel_price) as price from {$g5['g5_shop_order_table']} ";
    $row = sql_fetch($sql);
    $info_saleonly = array();
    $info_saleonly['count'] = (int)$row['cnt'];
    $info_saleonly['price'] = (int)$row['price'];
    $info_saleonly['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';

// PC 매출 건수/금액(상태와 상관없이 전체주문)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_mobile != '1' ";
    $row = sql_fetch($sql);
    $info_saleonly_pc = array();
    $info_saleonly_pc['count'] = (int)$row['cnt'];
    $info_saleonly_pc['price'] = (int)$row['price'];
    $info_saleonly_pc['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';

// 모바일 매출 건수/금액(상태와 상관없이 전체주문)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_mobile = '1' ";
    $row = sql_fetch($sql);
    $info_saleonly_mobile = array();
    $info_saleonly_mobile['count'] = (int)$row['cnt'];
    $info_saleonly_mobile['price'] = (int)$row['price'];
    $info_saleonly_mobile['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';
	
?>
<div class="font-14 pink">빅데이타페이지는 대대적인 개편중입니다</div>
<div class="h10"></div>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
