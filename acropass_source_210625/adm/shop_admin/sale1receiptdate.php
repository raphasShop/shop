<?php
$sub_menu = '415160'; /* 새로만든메뉴 2017-04-29 크림장수 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$fr_receipt_date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $fr_receipt_date);
$to_receipt_date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $to_receipt_date);

$g5['title'] = $fr_receipt_date.' ~ '.$to_receipt_date.' 일별 결제(입금) 현황';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

function print_line($save)
{
    $date = preg_replace("/-/", "", $save['od_date']);

    // td 백그라운드 설정함수 추가 - 아이스크림
	$bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>"><!-- td 백그라운드 설정함수 추가 - 아이스크림 -->
        <td class="td_alignc"><a href="./sale1receipttoday.php?date=<?php echo $date; ?>" class="at-tip" data-original-title="<nobr>일일입금현황표<br>보러가기</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><img src="<?php echo G5_ADMIN_URL; ?>/img/icon/date.png" border="0"> <?php echo $save['od_date']; ?></a></td>
        <td class="td_num"><?php echo number_format($save['ordercount']); ?></td>
        <td class="td_numsum" style="background:#FCEAF5;"><?php echo number_format($save['orderprice']); ?></td>
        <td class="td_numsum" style="background:#DFF7F4;"><?php echo number_format($save['receiptprice']); //매출(입금)금액?></td>
        <td class="td_numcoupon"><?php echo number_format($save['ordercoupon']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptbank']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptvbank']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptiche']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptcard']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptnaver']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receipthp']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptpoint']); ?></td>
        <td class="td_numcancel1">
            <?php if($save['orderefund'] > 0) {?><?php echo number_format($save['orderefund']); //환불금액?><?php } ?>
        </td>
    </tr>
    <?php
}

$sql = " select od_id,
            SUBSTRING(od_receipt_time,1,10) as od_date,
            od_settle_case,
            od_receipt_price,
            od_receipt_point,
			od_refund_price,
            od_cart_price,
            od_cancel_price,
            od_misu,
            (od_cart_price + od_send_cost + od_send_cost2) as orderprice,
            (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
       from {$g5['g5_shop_order_table']}
      where SUBSTRING(od_receipt_time,1,10) between '$fr_receipt_date' and '$to_receipt_date'
      order by od_receipt_time desc ";
$result = sql_query($sql);
?>
<!-- [PRINT] 인쇄용 제이쿼리 인클루드 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.5.1/jQuery.print.min.js"></script>
<!--//-->
<div id="this_print"><!-- [PRINT] 인쇄공간 감싸기 시작 this_print -->

<!-- 검색창 시작 { -->
<div class="dan-datebox_mobile" style="margin-bottom:20px;"><!-- 분류별검색창 -->
    <div class="row"><!-- row 시작 { -->
        <form name="frm_sale_date" action="./sale1receiptdate.php" class="big_sch02 big_sch" method="get">
        <strong>일별결제</strong>
        <input type="text" name="fr_receipt_date" value="<?php echo $fr_receipt_date; ?>" id="fr_receipt_date" required class="frm_input" size="10" maxlength="10" style="width:85px;">
        ~
        <input type="text" name="to_receipt_date" value="<?php echo $to_receipt_date; ?>" id="to_receipt_date" required class="frm_input" size="10" maxlength="10" style="width:85px;">
        <input type="submit" value="검색" class="btn_submit">&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="submit" onclick="javascript:set_date('오늘');">오늘</button>
        <button type="submit" onclick="javascript:set_date('어제');">어제</button>
        <button type="submit" onclick="javascript:set_date('이번주');">이번주</button>
        <button type="submit" onclick="javascript:set_date('이번달');">이번달</button>
        <button type="submit" onclick="javascript:set_date('지난주');">지난주</button>
        <button type="submit" onclick="javascript:set_date('지난달');">지난달</button>
        <button type="submit" onclick="javascript:set_date('1주일');">1주일</button>
        <button type="submit" onclick="javascript:set_date('1개월');">1개월</button>
        <button type="submit" onclick="javascript:set_date('3개월');">3개월</button>
        <button type="submit" onclick="javascript:set_date('6개월');">6개월</button>
        <button type="submit" onclick="javascript:set_date('1년');">1년</button>
        <button type="button" onclick="javascript:set_date('초기화');"><i class="fa fa-refresh" aria-hidden="true"></i> 초기화</button>
        </form>
    </div><!-- } row 끝 -->
</div><!-- 검색창 -->
<!-- } 검색창 끝 -->

<!-- 안내창 -->
<div class="local_desc02 local_desc">
        <p>
            <span class="black font-13 font-bold">"주문과 상관없이 입금일기준으로 실제 입금내역을 비교할수있는 일별입금현황표"</span><br>
            매출현황표는 주문일을 기준으로 주문금액과 매출액을 계산해주므로, 실제 결제(입금)금액과는 차이가 있습니다.<br>
            무통장입금은 주문 후 다음날 입금할수도 있어서 주문일과 입금일이 달라서, 당일 실제 입금금액이 확인이 않됩니다.<br> 
            그래서, <b>실제 결제(입금)일 기준으로 무통장입금이나 결제된것을 확인할수 있게 하였습니다.</b><br>
            <strong>[총결제(입금)합계]</strong> 해당일자 기준으로 결제(입금) 완료된 모든 결제<br>
            <strong>[실결제(입금)합계]</strong> 해당일자 기준으로 결제(입금) 완료된 모든 결제 중에서 환불한 금액을 제외한 최종 수입금액을 말합니다. 
        </p>
</div>
<!-- // -->

<div class="tbl_head01 tbl_wrap">

    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <thead>
    <tr>
        <th scope="col">결제(입금)일</th>
        <th scope="col">입금수</th>
        <th scope="col" style="background:#F29CD5;">총결제(입금)합계</th>
        <th scope="col" style="background:#53D0C7;">실결제(입금)합계</th><!-- 매출합계 추가-->
        <th scope="col">쿠폰</th>
        <th scope="col">무통장</th>
        <th scope="col">가상계좌</th>
        <th scope="col">계좌이체</th>
        <th scope="col">카드입금</th>
        <th scope="col">네이버페이</th>
        <th scope="col">휴대폰</th>
        <th scope="col">포인트입금</th>
        <th scope="col">환불금액</th>
    </tr>
    </thead>
    <tbody>
    <?php
    unset($save);
    unset($tot);
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        if ($i == 0)
            $save['od_date'] = $row['od_date'];

        if ($save['od_date'] != $row['od_date']) {
            print_line($save);
            unset($save);
            $save['od_date'] = $row['od_date'];
        }

        $save['ordercount']++;
        $save['orderprice']    += $row['orderprice'];
		$save['receiptprice']  += $row['od_receipt_price'] - $row['od_refund_price']; //매출(입금)금액
        $save['ordercancel']   += $row['od_cancel_price'];
		$save['orderefund']    += $row['od_refund_price']; //환불금액
        $save['ordercoupon']   += $row['couponprice'];
        if($row['od_settle_case'] == '무통장')
            $save['receiptbank']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '가상계좌')
            $save['receiptvbank']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '계좌이체')
            $save['receiptiche']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '휴대폰')
            $save['receipthp']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '신용카드')
            $save['receiptcard']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '네이버페이')
            $save['receiptnaver']   += $row['od_receipt_price'];
        $save['receiptpoint']  += $row['od_receipt_point'];
        $save['misu']          += $row['od_misu'];

        $tot['ordercount']++;
        $tot['orderprice']     += $row['orderprice'];
		$tot['receiptprice']  += $row['od_receipt_price'] - $row['od_refund_price']; //매출(입금)합계
        $tot['ordercancel']    += $row['od_cancel_price'];
		$tot['orderefund']    += $row['od_refund_price']; //환불금액
        $tot['ordercoupon']    += $row['couponprice'];
        if($row['od_settle_case'] == '무통장')
            $tot['receiptbank']    += $row['od_receipt_price'];
        if($row['od_settle_case'] == '가상계좌')
            $tot['receiptvbank']    += $row['od_receipt_price'];
        if($row['od_settle_case'] == '계좌이체')
            $tot['receiptiche']    += $row['od_receipt_price'];
        if($row['od_settle_case'] == '휴대폰')
            $tot['receipthp']    += $row['od_receipt_price'];
        if($row['od_settle_case'] == '신용카드')
            $tot['receiptcard']    += $row['od_receipt_price'];
        if($row['od_settle_case'] == '네이버페이')
            $tot['receiptnaver']   += $row['od_receipt_price'];
        $tot['receiptpoint']  += $row['od_receipt_point'];
        $tot['misu']           += $row['od_misu'];
    }

    if ($i == 0) {
        echo '<tr><td colspan="13" class="empty_table">자료가 없습니다.</td></tr>';
    } else {
        print_line($save);
    }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td>합계</td>
        <td><?php echo number_format($tot['ordercount']); ?></td>
        <td><?php echo number_format($tot['orderprice']); ?></td>
        <td><?php echo number_format($tot['receiptprice']); //매출(입금)합계?></td>
        <td><?php echo number_format($tot['ordercoupon']); ?></td>
        <td><?php echo number_format($tot['receiptbank']); ?></td>
        <td><?php echo number_format($tot['receiptvbank']); ?></td>
        <td><?php echo number_format($tot['receiptiche']); ?></td>
        <td><?php echo number_format($tot['receiptcard']); ?></td>
        <td><?php echo number_format($tot['receiptnaver']); ?></td>
        <td><?php echo number_format($tot['receipthp']); ?></td>
        <td><?php echo number_format($tot['receiptpoint']); ?></td>
        <td>
        <?php echo number_format($tot['orderefund']); //환불금액합계 ?>
        </td>
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
    $("#date, #fr_receipt_date, #to_receipt_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        showButtonPanel: true,
        yearRange: "c-99:c+99",
        maxDate: "+0d"
    });
});

function set_date(today)
{
    <?php
    $date_term = date('w', G5_SERVER_TIME); // 일단위
    $week_term = $date_term + 7; //일주일단위
    $last_term = strtotime(date('Y-m-01', G5_SERVER_TIME)); // 매월1일기준
	$month_term = strtotime(date('Y-m-d', G5_SERVER_TIME)); // 매월 오늘날짜 기준
    ?>
    if (today == "오늘") {
        document.getElementById("fr_receipt_date").value = "<?php echo G5_TIME_YMD; ?>";
        document.getElementById("to_receipt_date").value = "<?php echo G5_TIME_YMD; ?>";
    } else if (today == "어제") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
    } else if (today == "이번주") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-d', strtotime('-'.$date_term.' days', G5_SERVER_TIME)); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
    } else if (today == "이번달") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-01', G5_SERVER_TIME); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
    } else if (today == "지난주") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-d', strtotime('-'.$week_term.' days', G5_SERVER_TIME)); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', strtotime('-'.($week_term - 6).' days', G5_SERVER_TIME)); ?>";
    } else if (today == "지난달") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-01', strtotime('-1 Month', $last_term)); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-t', strtotime('-1 Month', $last_term)); ?>";    
	} else if (today == "1주일") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-d', strtotime('-7 days', $month_term)); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "1개월") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-d', strtotime('-1 Month', $month_term)); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	
	} else if (today == "3개월") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-d', strtotime('-3 Month', $month_term)); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "6개월") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-d', strtotime('-6 Month', $month_term)); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "1년") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-d', strtotime('-12 Month', $month_term)); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "초기화") {
        document.getElementById("fr_receipt_date").value = "";
        document.getElementById("to_receipt_date").value = "";
    }
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
