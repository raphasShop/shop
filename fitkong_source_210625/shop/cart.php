<?php
include_once('./_common.php');
include_once(G5_SHOP_PATH.'/settle_naverpay.inc.php');

// 보관기간이 지난 상품 삭제
cart_item_clean();

// cart id 설정
set_cart_id($sw_direct);

$s_cart_id = get_session('ss_cart_id');
// 선택필드 초기화
$sql = " update {$g5['g5_shop_cart_table']} set ct_select = '0' where od_id = '$s_cart_id' ";
sql_query($sql);

$cart_action_url = G5_SHOP_URL.'/cartupdate.php';

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/cart.php');
    return;
}

// 테마에 cart.php 있으면 include
if(defined('G5_THEME_SHOP_PATH')) {
    $theme_cart_file = G5_THEME_SHOP_PATH.'/cart.php';
    if(is_file($theme_cart_file)) {
        include_once($theme_cart_file);
        return;
        unset($theme_cart_file);
    }
}

// 100원 프로모션 구매 제한 체크
 if ($it_id == '1622793578' || $it_id == '1622793637' || $it_id == '1622793630') {
    $promotion_item = true;
} else {
    $promotion_item = false;
}

$g5['title'] = '장바구니';
include_once('./_head.php');
?>
<!-- 장바구니 시작 { -->
<script src="<?php echo G5_JS_URL; ?>/shop.js"></script>
<script src="<?php echo G5_JS_URL; ?>/shop.override.js"></script>
<div id="shop_cart_wrap">
    <div class="shop_main_title">장바구니</div>
    <div class="shop_con_wrap">
        <div id="sod_bsk" class="od_prd_list">

            <form name="frmcartlist" id="sod_bsk_list" class="2017_renewal_itemform" method="post" action="<?php echo $cart_action_url; ?>">
            <div class="tbl_head03 tbl_wrap">
                <table>
                <thead>
                <tr>
                    <th scope="col">
                        <label for="ct_all" class="sound_only"><span></span>상품 전체</label>
                        <input type="checkbox" name="ct_all" value="1" id="ct_all" checked="checked">
                        <label for="ct_all"><span></span></label>
                    </th>
                    <th scope="col"><span class="shop_cart_top_all">전체선택</span><button type="button" class="shop_cart_delete" onclick="return form_check('seldelete');">선택삭제</button><button type="button" class="shop_cart_clear" onclick="return form_check('alldelete');">비우기</button></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $tot_point = 0;
                $tot_sell_price = 0;

                // $s_cart_id 로 현재 장바구니 자료 쿼리
                $sql = " select a.ct_id,
                                a.it_id,
                                a.it_name,
                                a.ct_price,
                                a.ct_point,
                                a.ct_qty,
                                a.ct_status,
                                a.ct_send_cost,
                                a.it_sc_type,
                                b.it_cust_price,
                                b.ca_id,
                                b.ca_id2,
                                b.ca_id3
                           from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
                          where a.od_id = '$s_cart_id' ";
                $sql .= " group by a.it_id ";
                $sql .= " order by a.ct_id ";
                $result = sql_query($sql);

                $it_send_cost = 0;

                // enp cart data reset
                $enp_cart_item = 0;
                $enp_cart_num = 0;

                for ($i=0; $row=sql_fetch_array($result); $i++)
                {
                    // 합계금액 계산
                    $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
                                    SUM(ct_point * ct_qty) as point,
                                    SUM(ct_qty) as qty
                                from {$g5['g5_shop_cart_table']}
                                where it_id = '{$row['it_id']}'
                                  and od_id = '$s_cart_id' ";
                    $sum = sql_fetch($sql);

                    if ($i==0) { // 계속쇼핑
                        $continue_ca_id = $row['ca_id'];
                    }

                    $a1 = '<a href="./item.php?it_id='.$row['it_id'].'" class="prd_name"><b>';
                    $a2 = '</b></a>';
                    $image = get_it_image($row['it_id'], 150, 150);

                    $it_name = $a1 . stripslashes($row['it_name']) . $a2;
                    $it_options = print_item_options($row['it_id'], $s_cart_id);

                    
                    if($it_options) {
                        $mod_options = '<div class="sod_option_btn"><button type="button" class="mod_options">선택사항수정</button></div>';
                        // 100원 프로모션 아이템 옵션 선택 제거 
                        if ($row['it_id'] == '1622793578' || $row['it_id'] == '1622793637' || $row['it_id'] == '1622793630') {
                            $mod_options = '';
                            $promotion_item_select = true;
                            $promotion_sale_item = true;
                        }
                        $it_name .= '<div class="sod_opt">'.$it_options.'</div>';
                    }
                    
                    // 배송비
                    switch($row['ct_send_cost'])
                    {
                        case 1:
                            $ct_send_cost = '착불';
                            break;
                        case 2:
                            $ct_send_cost = '무료';
                            break;
                        default:
                            $ct_send_cost = '선불';
                            break;
                    }

                    // 조건부무료
                    if($row['it_sc_type'] == 2) {
                        $sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $s_cart_id);

                        if($sendcost == 0)
                            $ct_send_cost = '무료';
                    }

                    $point      = $sum['point'];
                    $sell_price = $sum['price'];

                    // enp cart analytics
                    $it_id = $row['it_id'];
                    $sql = " select ct_option, io_id, ct_price, ct_qty, io_price
                                from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and od_id = '$s_cart_id' order by io_type asc, ct_id asc ";
                    $result2 = sql_query($sql);
                    for($j=0; $row2=sql_fetch_array($result2); $j++) {
                        $enp_item_code[$enp_cart_num] = $row['it_id'];
                        $enp_item_name[$enp_cart_num] = get_text($row['it_name']);
                        if($row2['io_id']) {
                            $enp_item_name[$enp_cart_num] = $enp_item_name[$enp_cart_num]."/".$row2['io_id'];
                        }
                        $enp_item_price[$enp_cart_num] = $row2['ct_price'] + $row2['io_price'];
                        $enp_item_qty[$enp_cart_num] = $row2['ct_qty'];
                        $enp_item_cust_price[$enp_cart_num] = $row2['ct_price'] + $row2['io_price'];
                        $enp_cart_item = $enp_cart_item + $row2['ct_qty'];
                        $enp_cart_num++;
                    }
                ?>

                <tr>
                    <td class="td_chk">
                        
                        <input type="checkbox" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" checked="checked"><label for="ct_chk_<?php echo $i; ?>"><span></span></label>
                    </td> 
                    
                    <td  class="td_prd">
                        <div class="sod_img"><a href="./item.php?it_id=<?php echo $row['it_id']; ?>"><?php echo $image; ?></a></div>
                        <div class="sod_name">
                            <input type="hidden" name="it_id[<?php echo $i; ?>]"    value="<?php echo $row['it_id']; ?>">
                            <input type="hidden" name="it_name[<?php echo $i; ?>]"  value="<?php echo get_text($row['it_name']); ?>">
                            <?php echo $it_name.$mod_options; ?>
                            <div class="shop_cart_item_price"><?php echo number_format($sum['price']); ?>원</div>
                        </div>
                    </td>
                    <!--
                    <td class="td_num"><?php echo number_format($sum['qty']); ?></td>
                    <td class="td_numbig text_right"><?php echo number_format($row['ct_price']); ?></td>
                    <td class="td_numbig text_right"><?php echo number_format($point); ?></td>
                    <td class="td_dvr"><?php echo $ct_send_cost; ?></td>
                    <td class="td_numbig text_right"><span id="sell_price_<?php echo $i; ?>" class="total_prc"><?php echo number_format($sell_price); ?></span></td>
                    -->
                </tr>

                <?php
                    $tot_point      += $point;
                    $tot_sell_price += $sell_price;
                } // for 끝

                if ($i == 0) {
                    echo '<tr><td colspan="8" class="shop_cart_empty_icon"><img src="'.G5_IMG_URL.'/empty_icon.png"></td></tr>';
                    echo '<tr><td colspan="8" class="empty_table">장바구니에 담긴 상품이 없습니다.</td></tr>';
                } else {
                    // 배송비 계산
                    $send_cost = get_sendcost($s_cart_id, 0);
                }
                ?>
                </tbody>
                </table>
            </div>

            <?php
            $tot_price = $tot_sell_price + $send_cost; // 총계 = 주문상품금액합계 + 배송비
            if ($tot_price > 0 || $send_cost > 0) {
            ?>
            <div class="shop_cart_price_tot">
                <div class="shop_cart_tot_sell_price">총 상품 금액<span><?php echo number_format($tot_sell_price); ?>원</span></div>
                <div class="shop_cart_tot_point">총 적립금<span><?php echo number_format($tot_point); ?>원</span></div>
                <div class="shop_cart_tot_delivery">배송비<span><?php echo number_format($send_cost); ?>원</span></div>
                <div class="shop_cart_tot_price">예상 결제 금액<span><?php echo number_format($tot_price); ?><b>원</b></span></div>
            </div>
         
            <?php } ?>

            <div id="sod_bsk_act">
                <?php if ($i == 0) { ?>
                <a href="<?php echo G5_SHOP_URL; ?>/" class="btn01">쇼핑 계속하기</a>
                <?php } else { ?>
                <input type="hidden" name="url" value="./orderform.php">
                <input type="hidden" name="records" value="<?php echo $i; ?>">
                <input type="hidden" name="act" value="">
                <?php if($promotion_item_select && (int)$tot_sell_price < 20000) { // 100원 프로모션 상품 포함 시, 20000원 미만 상품 주문 버튼 제거 ?>
                <div style="text-align: center;font-size:15px;line-height:25px;font-weight:bold;padding:10px;color:#452417;border:1px solid #452417;margin-bottom:40px;">100원 프로모션 상품은<br>다른 상품과 함께 총 상품금액 20,000원 이상 구매 시, 주문가능합니다.</div>
                <?php } ?>
                <a href="<?php echo G5_SHOP_URL; ?>" class="btn01">쇼핑 계속하기</a>
                <?php if(!$promotion_item_select || ($promotion_item_select && (int)$tot_sell_price > 20000)) { // 100원 프로모션 상품 포함 시, 20000원 미만 상품 주문 버튼 제거?>
                <button type="submit" onclick="return form_check('buy');" class="btn_submit">주문하기</button>
                <?php } ?>
                <?php if(!$promotion_item_select) { // 100원 프로모션 상품 포함 시, 네이버페이 주문 금지 ?>
                <div class="shop_cart_naverpay">
                <?php if ($naverpay_button_js) { ?>
                <div class="cart-naverpay"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
                <?php } ?>
                </div>
                <?php } ?>
                <?php } ?>
            </div>

            </form>

        </div>
    </div>
</div>

<script>
$(function() {
    var close_btn_idx;

    // 선택사항수정
    $(".mod_options").click(function() {
        var it_id = $(this).closest("tr").find("input[name^=it_id]").val();
        var $this = $(this);
        close_btn_idx = $(".mod_options").index($(this));

        $.post(
            "./cartoption.php",
            { it_id: it_id },
            function(data) {
                $("#mod_option_frm").remove();
                $this.after("<div id=\"mod_option_frm\"></div>");
                $("#mod_option_frm").html(data);
                price_calculate();
            }
        );
    });

    // 모두선택
    $("input[name=ct_all]").click(function() {
        if($(this).is(":checked"))
            $("input[name^=ct_chk]").attr("checked", true);
        else
            $("input[name^=ct_chk]").attr("checked", false);
    });

    // 옵션수정 닫기
    $(document).on("click", "#mod_option_close", function() {
        $("#mod_option_frm").remove();
        $(".mod_options").eq(close_btn_idx).focus();
    });
    $("#win_mask").click(function () {
        $("#mod_option_frm").remove();
        $(".mod_options").eq(close_btn_idx).focus();
    });

});

function fsubmit_check(f) {
    if($("input[name^=ct_chk]:checked").length < 1) {
        alert("구매하실 상품을 하나이상 선택해 주십시오.");
        return false;
    }

    return true;
}

function form_check(act) {
    var f = document.frmcartlist;
    var cnt = f.records.value;

    if (act == "buy")
    {
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert("주문하실 상품을 하나이상 선택해 주십시오.");
            return false;
        }

        f.act.value = act;
        //f.submit();
    }
    else if (act == "alldelete")
    {
        f.act.value = act;
        f.submit();
    }
    else if (act == "seldelete")
    {
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert("삭제하실 상품을 하나이상 선택해 주십시오.");
            return false;
        }

        f.act.value = act;
        f.submit();
    }

    return true;
}
</script>


<!-- Enliple Tracker Start -->
<script type="text/javascript">
var ENP_VAR = { conversion: { product: [] } };

// 주문한 각 제품들을 배열에 저장
ENP_VAR.conversion.product.push(
    // 주문 상품1
    <?php 
    for ($i=0; $i<$enp_cart_num; $i++) {?>
    {
        productCode : '<?php echo $enp_item_code[$i]; ?>',
        productName : '<?php echo $enp_item_name[$i]; ?>',
        price : '<?php echo $enp_item_price[$i]; ?>',
        dcPrice : '<?php echo $enp_item_cust_price[$i]; ?>',
        qty : '<?php echo $enp_item_qty[$i]; ?>'
    }<?php if($i<$enp_cart_num-1) { echo ",\n"; }} ?>);

    ENP_VAR.conversion.totalPrice = '<?php echo $tot_sell_price; ?>';  // 없는 경우 단일 상품의 정보를 이용해 계산
    ENP_VAR.conversion.totalQty = '<?php echo $enp_cart_item; ?>';  // 없는 경우 단일 상품의 정보를 이용해 계산

    (function(a,g,e,n,t){a.enp=a.enp||function(){(a.enp.q=a.enp.q||[]).push(arguments)};n=g.createElement(e);n.async=!0;n.defer=!0;n.src="https://cdn.megadata.co.kr/dist/prod/enp_tracker_self_hosted.min.js";t=g.getElementsByTagName(e)[0];t.parentNode.insertBefore(n,t)})(window,document,"script");
    enp('create', 'conversion', 'jhyim', { device: '<?php echo $device_type; ?>', paySys: 'naverPay' }); // W:웹, M: 모바일, B: 반응형
</script>
<!-- Enliple Tracker End -->

<!-- } 장바구니 끝 -->
<?php
include_once('./_tail.php');
?>