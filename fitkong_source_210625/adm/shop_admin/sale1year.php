<?php
$sub_menu = '415140'; /* 원본메뉴코드 500110 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$fr_year = preg_replace('/[^0-9]/i', '', $fr_year);
$to_year = preg_replace('/[^0-9]/i', '', $to_year);

$g5['title'] = $fr_year.' ~ '.$to_year.' 연간 매출현황';
include_once (G5_ADMIN_PATH.'/admin.head.php');

function print_line($save)
{
    // td 백그라운드 설정함수 추가 - 아이스크림
	$bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>"><!-- td 백그라운드 설정함수 추가 - 아이스크림 -->
        <td class="td_alignc"><a href="./sale1month.php?fr_month=<?php echo $save['od_date']; ?>01&amp;to_month=<?php echo $save['od_date']; ?>12"><?php echo $save['od_date']; ?></a></td>
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
		    <?php if($save['ordercancel'] > 0) {?><?php echo number_format($save['ordercancel']); //취소금액?><?php } else { ?><span class="font-normal gray"><?php echo number_format($save['ordercancel']); //취소금액?></span><?php } ?>
            <br>
            <?php if($save['orderefund'] > 0) {?><span class="font-normal">(<?php echo number_format($save['orderefund']); //환불금액?>)</span><?php } ?>
        </td>
        <td class="td_numrdy"><?php echo number_format($save['misu']); ?></td>
    </tr>
    <?php
}

$sql = " select od_id,
                SUBSTRING(od_time,1,4) as od_date,
                od_send_cost,
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
          where SUBSTRING(od_time,1,4) between '$fr_year' and '$to_year'
          order by od_time desc ";
$result = sql_query($sql);
?>
<!-- [PRINT] 인쇄용 제이쿼리 인클루드 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.5.1/jQuery.print.min.js"></script>
<!--//-->
<div id="this_print"><!-- [PRINT] 인쇄공간 감싸기 시작 this_print -->

<!-- 검색창 시작 { -->
<div class="dan-schbox1" style="text-align:center;margin-bottom:20px;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
        <form name="frm_sale_year" action="./sale1year.php" class="big_sch01 big_sch" method="get">
        <strong>연간매출</strong>
        <input type="text" name="fr_year" value="<?php echo $fr_year; ?>" id="fr_year" required class="required frm_input_big" size="4" maxlength="4" style="width:60px;">
        <label for="fr_year">년 ~</label>
        <input type="text" name="to_year" value="<?php echo $to_year; ?>" id="to_year" required class="required frm_input_big" size="4" maxlength="4" style="width:60px;">
        <label for="to_year">년</label>
        <input type="submit" value="검색" class="btn_submit_big">
        </form>    </div><!-- } row 끝 -->
</div><!-- 검색창 -->
<!-- } 검색창 끝 -->

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <thead>
    <tr>
        <th scope="col">주문년도</th>
        <th scope="col">주문수</th>
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
        $tot['orderprice']    += $row['orderprice'];
		$tot['receiptprice']  += $row['od_receipt_price'] - $row['od_refund_price']; //매출(입금)합계
        $tot['ordercancel']   += $row['od_cancel_price'];
		$tot['orderefund']    += $row['od_refund_price']; //환불금액
        $tot['ordercoupon']   += $row['couponprice'];
        if($row['od_settle_case'] == '무통장')
            $tot['receiptbank']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '가상계좌')
            $tot['receiptvbank']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '계좌이체')
            $tot['receiptiche']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '휴대폰')
            $tot['receipthp']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '신용카드')
            $tot['receiptcard']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '네이버페이')
            $tot['receiptnaver']   += $row['od_receipt_price'];
        $tot['receiptpoint']  += $row['od_receipt_point'];
        $tot['misu']          += $row['od_misu'];
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
        <td>합 계</td>
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
		<?php echo number_format($tot['ordercancel']); //취소금액?><br>
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

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
