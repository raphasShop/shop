<?php
$sub_menu = '415110'; /* 원본메뉴코드 500110 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$date = preg_replace('/[^0-9]/i', '', $date);

$date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $date);

$g5['title'] = "$date 일 매출현황";
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$sql = " select od_id,
                mb_id,
                od_name,
				od_mobile,
                od_settle_case,
                od_cart_price,
                od_receipt_price,
                od_receipt_point,
				od_refund_price,
                od_cancel_price,
                od_misu,
                (od_cart_price + od_send_cost + od_send_cost2) as orderprice,
                (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
           from {$g5['g5_shop_order_table']}
          where SUBSTRING(od_time,1,10) = '$date'
          order by od_id desc ";
$result = sql_query($sql);
?>
<!-- [PRINT] 인쇄용 제이쿼리 인클루드 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.5.1/jQuery.print.min.js"></script>
<!--//-->
<div id="this_print"><!-- [PRINT] 인쇄공간 감싸기 시작 this_print -->

<!-- 검색창 시작 { -->
<div class="dan-datebox_mobile" style="text-align:center;margin-bottom:20px;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
        <form name="frm_sale_today" action="./sale1today.php" class="big_sch02 big_sch" method="get">
        <strong>일일매출</strong>
        <input type="text" name="date" value="<?php echo $date; ?>" id="date" required class="required frm_input" size="10" maxlength="10" style="width:85px;">
        <label for="date">일 하루</label>
        <input type="submit" value="확인" class="btn_submit">&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="submit" onclick="javascript:set_today('오늘');">오늘</button>
        <button type="submit" onclick="javascript:set_today('어제');"><?php echo date('m-d', strtotime('-1 day', G5_SERVER_TIME)); ?></button>
        <button type="submit" onclick="javascript:set_today('이일전');"><?php echo date('m-d', strtotime('-2 day', G5_SERVER_TIME)); ?></button>
        <button type="submit" onclick="javascript:set_today('삼일전');"><?php echo date('m-d', strtotime('-3 day', G5_SERVER_TIME)); ?></button>
        <button type="submit" onclick="javascript:set_today('사일전');"><?php echo date('m-d', strtotime('-4 day', G5_SERVER_TIME)); ?></button>
        <button type="submit" onclick="javascript:set_today('오일전');"><?php echo date('m-d', strtotime('-5 day', G5_SERVER_TIME)); ?></button>
        <button type="submit" onclick="javascript:set_today('육일전');"><?php echo date('m-d', strtotime('-6 day', G5_SERVER_TIME)); ?></button>
        <button type="submit" onclick="javascript:set_today('칠일전');"><?php echo date('m-d', strtotime('-7 day', G5_SERVER_TIME)); ?></button>
        <button type="button" onclick="javascript:set_today('초기화');"><i class="fa fa-refresh" aria-hidden="true"></i> 초기화</button>
        </form>
    </div><!-- } row 끝 -->
</div><!-- 검색창 -->
<!-- } 검색창 끝 -->


<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <thead>
    <tr>
        <th scope="col">주문번호</th>
        <th scope="col">주문자</th>
        <th scope="col">주문합계</th>
        <th scope="col">매출합계</th><!-- 매출합계 추가-->
        <th scope="col">쿠폰</th>
        <th scope="col">무통장</th>
        <th scope="col">가상계좌</th>
        <th scope="col">계좌이체</th>
        <th scope="col">카드입금</th>
        <th scope="col">네이버페이</th>
        <th scope="col">휴대폰</th>
        <th scope="col">포인트입금</th>
        <th scope="col">주문취소<br>(환불금액)</th>
        <th scope="col">미수금</th>
    </tr>
    </thead>
    <tbody>
    <?php
    unset($tot);
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        if ($row['mb_id'] == '') { // 비회원일 경우는 주문자로 링크
            $href = '<a href="./orderlist.php?sel_field=od_name&amp;search='.$row['od_name'].'">';
        } else { // 회원일 경우는 회원아이디로 링크
            $href = '<a href="./orderlist.php?sel_field=mb_id&amp;search='.$row['mb_id'].'">';
        }
		
		$receiptprice  = $row['od_receipt_price'] - $row['od_refund_price']; //매출(입금)금액
		$orderefund    = $row['od_refund_price']; //환불금액

        $receipt_bank = $receipt_card = $receipt_naver = $receipt_vbank = $receipt_iche = $receipt_hp = 0;
        if($row['od_settle_case'] == '무통장')
            $receipt_bank = $row['od_receipt_price'];
        if($row['od_settle_case'] == '가상계좌')
            $receipt_vbank = $row['od_receipt_price'];
        if($row['od_settle_case'] == '계좌이체')
            $receipt_iche = $row['od_receipt_price'];
        if($row['od_settle_case'] == '휴대폰')
            $receipt_hp = $row['od_receipt_price'];
        if($row['od_settle_case'] == '신용카드')
            $receipt_card = $row['od_receipt_price'];
        if($row['od_settle_case'] == '네이버페이')
            $receipt_naver = $row['od_receipt_price'];

        // td 백그라운드 설정함수 추가 - 아이스크림
	    $bg = 'bg'.($i%2);
    ?>
        <tr class="<?php echo $bg; ?>"><!-- td 백그라운드 설정함수 추가 - 아이스크림 -->
            <td class="td_alignc"><a href="./orderform.php?od_id=<?php echo $row['od_id']; ?>"><?php echo $row['od_id']; ?></a></td>
            <td class="td_name"><?php echo $href; ?><?php echo $row['od_name']; ?></a></td>
            <td class="td_numsum" style="background:#FCEAF5;">
            <?php echo ($row['od_mobile'] > 0) ? '<img src="'.G5_ADMIN_URL.'/img/icon_mobile.gif" title="모바일주문">' : '';?>
			<?php echo number_format($row['orderprice']); ?>
            </td>
            <td class="td_numsum" style="background:#DFF7F4;"><?php echo number_format($receiptprice); ?></td>
            <td class="td_numcoupon"><?php echo number_format($row['couponprice']); ?></td>
            <td class="td_numincome"><?php echo number_format($receipt_bank); ?></td>
            <td class="td_numincome"><?php echo number_format($receipt_vbank); ?></td>
            <td class="td_numincome"><?php echo number_format($receipt_iche); ?></td>
            <td class="td_numincome"><?php echo number_format($receipt_card); ?></td>
            <td class="td_numincome"><?php echo number_format($receipt_naver); ?></td>
            <td class="td_numincome"><?php echo number_format($receipt_hp); ?></td>
            <td class="td_numincome"><?php echo number_format($row['od_receipt_point']); ?></td>
            <td class="td_numcancel1">
            <?php if($row['od_cancel_price'] > 0) {?><?php echo number_format($row['od_cancel_price']); //취소금액?><?php } else { ?><span class="font-normal gray"><?php echo number_format($row['od_cancel_price']); //취소금액?></span><?php } ?>
            <br>
            <?php if($orderefund > 0) {?><span class="font-normal">(<?php echo number_format($orderefund); //환불금액?>)</span><?php } ?>
            
            </td>
            <td class="td_numrdy"><?php echo number_format($row['od_misu']); ?></td>
        </tr>
    <?php
        $tot['orderprice']    += $row['orderprice'];
		$tot['receiptprice']  += $row['od_receipt_price'] - $row['od_refund_price']; //매출(입금)합계
        $tot['ordercancel']   += $row['od_cancel_price'];
		$tot['orderefund']    += $row['od_refund_price']; //환불금액
        $tot['coupon']        += $row['couponprice'] ;
        $tot['receipt_bank']  += $receipt_bank;
        $tot['receipt_vbank'] += $receipt_vbank;
        $tot['receipt_iche']  += $receipt_iche;
        $tot['receipt_card']  += $receipt_card;
        $tot['receipt_card']  += $receipt_naver;
        $tot['receipt_hp']    += $receipt_hp;
        $tot['receipt_point'] += $row['od_receipt_point'];
        $tot['misu']          += $row['od_misu'];
    }

    if ($i == 0) {
        echo '<tr><td colspan="13" class="empty_table">자료가 없습니다</td></tr>';
    }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2">합 계</td>
        <td><?php echo number_format($tot['orderprice']); ?></td>
        <td><?php echo number_format($tot['receiptprice']); //매출(입금)합계?></td>
        <td><?php echo number_format($tot['coupon']); ?></td>
        <td><?php echo number_format($tot['receipt_bank']); ?></td>
        <td><?php echo number_format($tot['receipt_vbank']); ?></td>
        <td><?php echo number_format($tot['receipt_iche']); ?></td>
        <td><?php echo number_format($tot['receipt_card']); ?></td>
        <td><?php echo number_format($tot['receipt_naver']); ?></td>
        <td><?php echo number_format($tot['receipt_hp']); ?></td>
        <td><?php echo number_format($tot['receipt_point']); ?></td>
        <td>
		<?php echo number_format($tot['ordercancel']); ?><br>
        <?php if($tot['orderefund'] > 0) {?><span class="font-normal">(<?php echo number_format($tot['orderefund']); //환불금액?>)</span><?php } ?>
        </td>
        <td><?php echo number_format($tot['misu']); ?></td>
    </tr>
    </tfoot>
    </table>
</div>

</div><!-- [PRINT] 인쇄공간 감싸기 끝 this_print -->

<!-- [PRINT] 인쇄버튼 -->
<div class="pull-right darkgray font-11" style="display:block; padding:15px 0px;">
    <i class="fa fa-lightbulb-o fa-lg blue font-12" aria-hidden="true"> 인쇄팁</i> 인쇄버튼을 누르면 프린트를 위한 인쇄제어창이 나옵니다. 속성 버튼을 클릭해서 용지방향을 <b>"가로"</b>로 해주셔야 잘리지않고 인쇄됩니다&nbsp;&nbsp;&nbsp;
    <button class="btn btn-red btn-lg" onclick="$('#this_print').print();">인쇄</button><!-- [PRINT] 인쇄버튼 -->
</div>
<!--//-->

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">
    <div class="bq_basic">
        <button onclick="$('#this_print').print();"><i class="fas fa-window-maximize"></i> 프린트</button><!-- [PRINT] 인쇄버튼 -->
    </div>
</div>
<!--//-->

<script>
$(function() {
    $("#date, #fr_date, #to_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        showButtonPanel: true,
        yearRange: "c-99:c+99",
        maxDate: "+0d"
    });
});

function set_today(today)
{
    <?php
    $date_term = date('w', G5_SERVER_TIME); // 일단위
    $week_term = $date_term + 7; //일주일단위
    $last_term = strtotime(date('Y-m-01', G5_SERVER_TIME)); // 매월1일기준
	$month_term = strtotime(date('Y-m-d', G5_SERVER_TIME)); // 매월 오늘날짜 기준
    ?>
    if (today == "오늘") {
        document.getElementById("date").value = "<?php echo G5_TIME_YMD; ?>";
    } else if (today == "어제") {
        document.getElementById("date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
    } else if (today == "이일전") {
        document.getElementById("date").value = "<?php echo date('Y-m-d', strtotime('-2 day', G5_SERVER_TIME)); ?>";
	} else if (today == "삼일전") {
        document.getElementById("date").value = "<?php echo date('Y-m-d', strtotime('-3 day', G5_SERVER_TIME)); ?>";
	} else if (today == "사일전") {
        document.getElementById("date").value = "<?php echo date('Y-m-d', strtotime('-4 day', G5_SERVER_TIME)); ?>";
	} else if (today == "오일전") {
        document.getElementById("date").value = "<?php echo date('Y-m-d', strtotime('-5 day', G5_SERVER_TIME)); ?>";
	} else if (today == "육일전") {
        document.getElementById("date").value = "<?php echo date('Y-m-d', strtotime('-6 day', G5_SERVER_TIME)); ?>";
	} else if (today == "칠일전") {
        document.getElementById("date").value = "<?php echo date('Y-m-d', strtotime('-7 day', G5_SERVER_TIME)); ?>";
	} else if (today == "초기화") {
        document.getElementById("date").value = "<?php echo G5_TIME_YMD; ?>";
    }
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
