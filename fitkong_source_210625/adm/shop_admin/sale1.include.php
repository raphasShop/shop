<?php
if (!defined('_GNUBOARD_')) exit;

################################################
/* 입금현황표 */
// admin.sum_order.php에 추가하면 모든페이지에서 데이타를 불러오기위한 과부하가 예상되어
// 따로 매출관리페이지에만 표시함
################################################	

// 오늘의 모든 입금(현재상태에 상관없이 오늘 입금건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_refund_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$today 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $infotoday_receipt = array();
    $infotoday_receipt['count'] = (int)$row['cnt'];
    $infotoday_receipt['price'] = (int)$row['price'];
    $infotoday_receipt['href'] = G5_ADMIN_URL.'/shop_admin/sale1receipttoday.php?receipt_date='.urlencode($today);
	
// 어제의 모든 입금(현재상태에 상관없이 어제 입금건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_refund_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$yesterday 00:00:00' and '$yesterday 23:59:59'";
    $row = sql_fetch($sql);
    $infoyesterday_receipt = array();
    $infoyesterday_receipt['count'] = (int)$row['cnt'];
    $infoyesterday_receipt['price'] = (int)$row['price'];
    $infoyesterday_receipt['href'] = G5_ADMIN_URL.'/shop_admin/sale1receipttoday.php?receipt_date='.urlencode($yesterday);

// 최근한달의 모든 입금(현재상태에 상관없이 최근한달간의 입금건만 계산)/금액(관리자모드) - 최근한달
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_refund_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$amonthoneday 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $infonearmonth_receipt = array();
    $infonearmonth_receipt['count'] = (int)$row['cnt'];
    $infonearmonth_receipt['price'] = (int)$row['price'];
    $infonearmonth_receipt['href'] = G5_ADMIN_URL.'/shop_admin/sale1receiptdate.php?fr_receipt_date='.urlencode($amonthoneday).'&to_receipt_date='.urlencode($today);
	
// 이번주의 모든 입금(현재상태에 상관없이 전달 입금건만 계산)/금액(관리자모드) - 일요일~토요일
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_refund_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$weekoneday 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $infoweek_receipt = array();
    $infoweek_receipt['count'] = (int)$row['cnt'];
    $infoweek_receipt['price'] = (int)$row['price'];
    $infoweek_receipt['href'] = G5_ADMIN_URL.'/shop_admin/sale1receiptdate.php?fr_receipt_date='.urlencode($weekoneday).'&to_receipt_date='.urlencode($today);

// 이번달의 모든 입금(현재상태에 상관없이 이달 입금건만 계산)/금액(관리자모드) - 이달 1일 부터 현재일까지
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_refund_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$moneday 00:00:00' and '$mnowday 23:59:59'";
    $row = sql_fetch($sql);
    $infomonth_receipt = array();
    $infomonth_receipt['count'] = (int)$row['cnt'];
    $infomonth_receipt['price'] = (int)$row['price'];
    $infomonth_receipt['href'] = G5_ADMIN_URL.'/shop_admin/sale1receiptdate.php?fr_receipt_date='.urlencode($moneday).'&to_receipt_date='.urlencode($mnowday);

// 이전달의 모든 입금(현재상태에 상관없이 전달 입금건만 계산)/금액(관리자모드) - 전달1일 부터 말일
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_refund_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$lastmonthday 00:00:00' and '$lastmonthendday 23:59:59'";
    $row = sql_fetch($sql);
    $infolastmonth_receipt = array();
    $infolastmonth_receipt['count'] = (int)$row['cnt'];
    $infolastmonth_receipt['price'] = (int)$row['price'];
    $infolastmonth_receipt['href'] = G5_ADMIN_URL.'/shop_admin/sale1receiptdate.php?fr_receipt_date='.urlencode($lastmonthday).'&to_receipt_date='.urlencode($lastmonthendday);

################################################
/* 매출현황표 */
// admin.sum_order.php에 추가하면 모든페이지에서 데이타를 불러오기위한 과부하가 예상되어
// 따로 매출관리페이지에만 표시함
################################################	

// 오늘의 모든 매출(현재상태에 상관없이 오늘 매출건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$today 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $infotoday_sale = array();
    $infotoday_sale['count'] = (int)$row['cnt'];
    $infotoday_sale['price'] = (int)$row['price'];
    $infotoday_sale['href'] = G5_ADMIN_URL.'/shop_admin/sale1today.php?date='.urlencode($today);
	
// 어제의 모든 매출(현재상태에 상관없이 어제 매출건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$yesterday 00:00:00' and '$yesterday 23:59:59'";
    $row = sql_fetch($sql);
    $infoyesterday_sale = array();
    $infoyesterday_sale['count'] = (int)$row['cnt'];
    $infoyesterday_sale['price'] = (int)$row['price'];
    $infoyesterday_sale['href'] = G5_ADMIN_URL.'/shop_admin/sale1today.php?date='.urlencode($yesterday);

// 최근한달의 모든 매출(현재상태에 상관없이 최근한달간의 매출건만 계산)/금액(관리자모드) - 최근한달
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$amonthoneday 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $infonearmonth_sale = array();
    $infonearmonth_sale['count'] = (int)$row['cnt'];
    $infonearmonth_sale['price'] = (int)$row['price'];
    $infonearmonth_sale['href'] = G5_ADMIN_URL.'/shop_admin/sale1date.php?fr_date='.urlencode($amonthoneday).'&to_date='.urlencode($today);
	
// 이번주의 모든 매출(현재상태에 상관없이 전달 매출건만 계산)/금액(관리자모드) - 일요일~토요일
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$weekoneday 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $infoweek_sale = array();
    $infoweek_sale['count'] = (int)$row['cnt'];
    $infoweek_sale['price'] = (int)$row['price'];
    $infoweek_sale['href'] = G5_ADMIN_URL.'/shop_admin/sale1date.php?fr_date='.urlencode($weekoneday).'&to_date='.urlencode($today);

// 이번달의 모든 매출(현재상태에 상관없이 이달 매출건만 계산)/금액(관리자모드) - 이달 1일 부터 현재일까지
/* admin.sum_orderdate.php 파일에 있음. 전체파일에 인클루드되는 파일이기에 중복되어 여기서는 빠짐 */

// 이전달의 모든 매출(현재상태에 상관없이 전달 매출건만 계산)/금액(관리자모드) - 전달1일 부터 말일
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$lastmonthday 00:00:00' and '$lastmonthendday 23:59:59'";
    $row = sql_fetch($sql);
    $infolastmonth_sale = array();
    $infolastmonth_sale['count'] = (int)$row['cnt'];
    $infolastmonth_sale['price'] = (int)$row['price'];
    $infolastmonth_sale['href'] = G5_ADMIN_URL.'/shop_admin/sale1receiptdate.php?fr_date='.urlencode($lastmonthday).'&to_date='.urlencode($lastmonthendday);

################################################
/* 취소/환불현황표 */
// admin.sum_order.php에 추가하면 모든페이지에서 데이타를 불러오기위한 과부하가 예상되어
// 따로 취소/환불관리페이지에만 표시함
################################################	

// 오늘의 모든 취소/환불(현재상태에 상관없이 오늘 취소/환불건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$today 00:00:00' and '$today 23:59:59' and ( (od_status = '취소') OR (od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0) ) ";
    $row = sql_fetch($sql);
    $infotoday_cancle = array();
    $infotoday_cancle['count'] = (int)$row['cnt'];
    $infotoday_cancle['price'] = (int)$row['price'];
    $infotoday_cancle['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($today).'&to_date='.urlencode($today);
	
// 어제의 모든 취소/환불(현재상태에 상관없이 어제 취소/환불건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$yesterday 00:00:00' and '$yesterday 23:59:59' and ( (od_status = '취소') OR (od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0) ) ";
    $row = sql_fetch($sql);
    $infoyesterday_cancle = array();
    $infoyesterday_cancle['count'] = (int)$row['cnt'];
    $infoyesterday_cancle['price'] = (int)$row['price'];
    $infoyesterday_cancle['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($yesterday).'&to_date='.urlencode($yesterday);

// 최근한달의 모든 취소/환불(현재상태에 상관없이 최근한달간의 취소/환불건만 계산)/금액(관리자모드) - 최근한달
    $sql = " select count(*) as cnt, sum(od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$amonthoneday 00:00:00' and '$today 23:59:59' and ( (od_status = '취소') OR (od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0) ) ";
    $row = sql_fetch($sql);
    $infonearmonth_cancle = array();
    $infonearmonth_cancle['count'] = (int)$row['cnt'];
    $infonearmonth_cancle['price'] = (int)$row['price'];
    $infonearmonth_cancle['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($amonthoneday).'&to_date='.urlencode($today);
	
// 이번주의 모든 취소/환불(현재상태에 상관없이 전달 취소/환불건만 계산)/금액(관리자모드) - 일요일~토요일
    $sql = " select count(*) as cnt, sum(od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$weekoneday 00:00:00' and '$today 23:59:59' and ( (od_status = '취소') OR (od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0) ) ";
    $row = sql_fetch($sql);
    $infoweek_cancle = array();
    $infoweek_cancle['count'] = (int)$row['cnt'];
    $infoweek_cancle['price'] = (int)$row['price'];
    $infoweek_cancle['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($weekoneday).'&to_date='.urlencode($today);

// 이번달의 모든 취소/환불(현재상태에 상관없이 이달 취소/환불건만 계산)/금액(관리자모드) - 이달 1일 부터 현재일까지
/* admin.sum_orderdate.php 파일에 있음. 전체파일에 인클루드되는 파일이기에 중복되어 여기서는 빠짐 */

// 이전달의 모든 취소/환불(현재상태에 상관없이 전달 취소/환불건만 계산)/금액(관리자모드) - 전달1일 부터 말일
    $sql = " select count(*) as cnt, sum(od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$lastmonthday 00:00:00' and '$lastmonthendday 23:59:59' and ( (od_status = '취소') OR (od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0) ) ";
    $row = sql_fetch($sql);
    $infolastmonth_cancle = array();
    $infolastmonth_cancle['count'] = (int)$row['cnt'];
    $infolastmonth_cancle['price'] = (int)$row['price'];
    $infolastmonth_cancle['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($lastmonthday).'&to_date='.urlencode($lastmonthendday);

?>

    <div class="tbl_saleboard1"><!-- [표]매출현황 요약 시작 { -->
    <table> 
        <thead>
            <tr>
                <th scope="col" rowspan="2" style="width:120px;border-bottom:1px solid #4E930A;">&nbsp;</th>
                <th scope="col" style="font-weight:bold; color:#222;">오늘</th>
                <th scope="col">어제</th>
                <th scope="col" style="font-weight:bold; color:#222;">최근한달</th>
                <th scope="col" style="font-weight:bold; color:#222;">이번주(일~토)</th>
                <th scope="col" style="font-weight:bold; color:#222;">이번달</th>
                <th scope="col">지난달</th>
                <th scope="col" rowspan="2">전달대비</th> 
            </tr>
            <tr>
                <?php
		        $saleweek = array("일", "월", "화", "수", "목", "금", "토");
		        ?>
                <!-- 행 합침-->
                <th scope="col" style=" font-weight:bold; color:#222;"><?php echo date("m/d", G5_SERVER_TIME);?>(<?php echo $saleweek[date("w")];//요일표시?>)</th>
                <th scope="col"><?php echo date('m/d', strtotime('-1 days', G5_SERVER_TIME));?></th>
                <th scope="col" style="font-weight:bold; color:#222;"><?php echo date('m/d', strtotime('-1 Month', $onemonth_term));?>~<?php echo date("m/d", G5_SERVER_TIME);?></th>
                <th scope="col" style="font-weight:bold; color:#222;"><?php echo date('m/d', strtotime('-'.$date_term.' days', G5_SERVER_TIME));?>~<?php echo date("m/d", G5_SERVER_TIME);?></th>
                <th scope="col" style="font-weight:bold; color:#222;"><?php echo date('m/01', G5_SERVER_TIME); ?>~<?php echo date('m/d', G5_SERVER_TIME); ?></th>
                <th scope="col"><?php echo date('m', strtotime('-1 Month', $lastmonth_term)); ?>월</th>
                <!-- 행 합침--> 
            </tr>
        </thead>
        <tbody>
            <!-- 입금액 -->
            <tr>
                <th scope="col">입금(결제)</th>
                <td class="td_score_sale"><a href="<?php echo $infotoday_receipt['href'];?>"> <?php echo ($infotoday_receipt['price'] > 0) ? number_format($infotoday_receipt['price']) : '<b style="color:#eaeaea;">O</b>';//오늘입금?></a></td>
                <td class="td_score_sale"><a href="<?php echo $infoyesterday_receipt['href'];?>"> <?php echo ($infoyesterday_receipt['price'] > 0) ? number_format($infoyesterday_receipt['price']) : '<b style="color:#eaeaea;">O</b>';//어제입금?></a></td>
                
                <td class="td_score_sale"><a href="<?php echo $infonearmonth_receipt['href'];?>"> <?php echo ($infonearmonth_receipt['price'] > 0) ? number_format($infonearmonth_receipt['price']) : '<b style="color:#eaeaea;">O</b>';//최근한달입금?></a></td>
                <td class="td_score_sale"><a href="<?php echo $infoweek_receipt['href'];?>"> <?php echo ($infoweek_receipt['price'] > 0) ? number_format($infoweek_receipt['price']) : '<b style="color:#eaeaea;">O</b>';//이번주입금?></a></td>
                <td class="td_score_sale"><a href="<?php echo $infomonth_receipt['href'];?>"> <?php echo ($infomonth_receipt['price'] > 0) ? number_format($infomonth_receipt['price']) : '<b style="color:#eaeaea;">O</b>';//이번달입금?></a></td>
                <td class="td_score_sale"><a href="<?php echo $infolastmonth_receipt['href'];?>"> <?php echo ($infolastmonth_receipt['price'] > 0) ? number_format($infolastmonth_receipt['price']) : '<b style="color:#eaeaea;">O</b>';//지난달입금?></a></td>
                <td class="td_score_sale">
                    <?php //전달 대비 계산 (이번달입금 - 전달입금)
				        $lastmonth_receipt_contrast = number_format($infomonth_receipt['price'] - $infolastmonth_receipt['price']);
				    ?>
                    <?php echo ($lastmonth_receipt_contrast >= 0) ? '<span class="lightpink">'.$lastmonth_receipt_contrast.' ▲</span>' : '<span class="blue">'.$lastmonth_receipt_contrast.' ▼</span>';//전달대비산출금액?>
                </td>
            </tr>
           <!--//-->
           <!-- 취소금액 -->
            <tr>
                <th scope="col" style="background:#8ED34A;">취소/환불</th>
                <td class="td_score_sale lightpink"><?php echo ($infotoday_cancle['price'] > 0) ? number_format($infotoday_cancle['price']) : '<b style="color:#eaeaea;">O</b>';//오늘취소?> <?php echo ($infotoday_cancle['count'] > 0) ? '<span class="gray">('.$infotoday_cancle['count'].')</span>' : '';//건수?></td>
                <td class="td_score_sale lightpink"><?php echo ($infoyesterday_cancle['price'] > 0) ? number_format($infoyesterday_cancle['price']) : '<b style="color:#eaeaea;">O</b>';//어제취소?> <?php echo ($infoyesterday_cancle['count'] > 0) ? '<span class="gray">('.$infoyesterday_cancle['count'].')</span>' : '';//건수?></td>
                
                <td class="td_score_sale lightpink"><?php echo ($infonearmonth_cancle['price'] > 0) ? number_format($infonearmonth_cancle['price']) : '<b style="color:#eaeaea;">O</b>';//최근한달취소?><?php echo ($infonearmonth_cancle['count'] > 0) ? '<span class="gray">('.$infonearmonth_cancle['count'].')</span>' : '';//건수?></td>
                <td class="td_score_sale lightpink"><?php echo ($infoweek_cancle['price'] > 0) ? number_format($infoweek_cancle['price']) : '<b style="color:#eaeaea;">O</b>';//이번주취소?><?php echo ($infoweek_cancle['count'] > 0) ? '<span class="gray">('.$infoweek_cancle['count'].')</span>' : '';//건수?></td>
                <td class="td_score_sale lightpink"><?php echo ($infomonth_cancle['price'] > 0) ? number_format($infomonth_cancle['price']) : '<b style="color:#eaeaea;">O</b>';//이번달취소?><?php echo ($infomonth_cancle['count'] > 0) ? '<span class="gray">('.$infomonth_cancle['count'].')</span>' : '';//건수?></td>
                <td class="td_score_sale lightpink"><?php echo ($infolastmonth_cancle['price'] > 0) ? number_format($infolastmonth_cancle['price']) : '<b style="color:#eaeaea;">O</b>';//지난달취소?><?php echo ($infolastmonth_cancle['count'] > 0) ? '<span class="gray">('.$infolastmonth_cancle['count'].')</span>' : '';//건수?></td>
                <td class="td_score_sale">
                    <?php //전달 대비 계산 (이번달취소 - 전달취소)
				        $lastmonth_cancle_contrast = number_format($infomonth_cancle['price'] - $infolastmonth_cancle['price']);
				    ?>
                    <?php echo ($lastmonth_cancle_contrast >= 0) ? '<span class="lightpink">'.$lastmonth_cancle_contrast.' ▲</span>' : '<span class="blue">'.$lastmonth_cancle_contrast.' ▼</span>';//전달대비산출금액?>
                </td>
            </tr>
           <!--//-->
           <!-- 매출금액 -->
            <tr>
                <th scope="col">매출금액</th>
                <td class="td_score_sale"><a href="<?php echo $infotoday_sale['href'];?>"> <?php echo ($infotoday_sale['price'] > 0) ? number_format($infotoday_sale['price']) : '<b style="color:#eaeaea;">O</b>';//오늘매출?></a></td>
                <td class="td_score_sale"><a href="<?php echo $infoyesterday_sale['href'];?>"> <?php echo ($infoyesterday_sale['price'] > 0) ? number_format($infoyesterday_sale['price']) : '<b style="color:#eaeaea;">O</b>';//어제매출?></a></td>
                
                <td class="td_score_sale"><a href="<?php echo $infonearmonth_sale['href'];?>"> <?php echo ($infonearmonth_sale['price'] > 0) ? number_format($infonearmonth_sale['price']) : '<b style="color:#eaeaea;">O</b>';//최근한달매출?></a></td>
                <td class="td_score_sale"><a href="<?php echo $infoweek_sale['href'];?>"> <?php echo ($infoweek_sale['price'] > 0) ? number_format($infoweek_sale['price']) : '<b style="color:#eaeaea;">O</b>';//이번주매출?></a></td>
                <td class="td_score_sale"><a href="<?php echo $infomonth_sale['href'];?>"> <?php echo ($infomonth_sale['price'] > 0) ? number_format($infomonth_sale['price']) : '<b style="color:#eaeaea;">O</b>';//이번달매출?></a></td>
                <td class="td_score_sale"><a href="<?php echo $infolastmonth_sale['href'];?>"> <?php echo ($infolastmonth_sale['price'] > 0) ? number_format($infolastmonth_sale['price']) : '<b style="color:#eaeaea;">O</b>';//지난달매출?></a></td>
                <td class="td_score_sale">
                    <?php //전달 대비 계산 (이번달매출 - 전달매출)
				        $lastmonth_sale_contrast = number_format($infomonth_sale['price'] - $infolastmonth_sale['price']);
				    ?>
                    <?php echo ($lastmonth_sale_contrast >= 0) ? '<span class="lightpink">'.$lastmonth_sale_contrast.' ▲</span>' : '<span class="blue">'.$lastmonth_sale_contrast.' ▼</span>';//전달대비산출금액?>
                </td>
            </tr>
           <!--//-->  
           <!-- 주문금액 -->
            <tr>
                <th scope="col" style="background:#8ED34A;">주문금액</th>
                <td class="td_score_sale"><a href="<?php echo $infotoday['href'];?>"> <?php echo ($infotoday['price'] > 0) ? number_format($infotoday['price']) : '<b style="color:#eaeaea;">O</b>';//오늘주문?><?php echo ($infotoday['count'] > 0) ? '<span class="gray">('.$infotoday['count'].')</span>' : '';//건수?></a></td>
                <td class="td_score_sale"><a href="<?php echo $infoyesterday['href'];?>"> <?php echo ($infoyesterday['price'] > 0) ? number_format($infoyesterday['price']) : '<b style="color:#eaeaea;">O</b>';//어제주문?><?php echo ($infoyesterday['count'] > 0) ? '<span class="gray">('.$infoyesterday['count'].')</span>' : '';//건수?></a></td>
                
                <td class="td_score_sale"><a href="<?php echo $infonearmonth['href'];?>"> <?php echo ($infonearmonth['price'] > 0) ? number_format($infonearmonth['price']) : '<b style="color:#eaeaea;">O</b>';//최근한달주문?><?php echo ($infonearmonth['count'] > 0) ? '<span class="gray">('.$infonearmonth['count'].')</span>' : '';//건수?></a></td>
                <td class="td_score_sale"><a href="<?php echo $infoweek['href'];?>"> <?php echo ($infoweek['price'] > 0) ? number_format($infoweek['price']) : '<b style="color:#eaeaea;">O</b>';//이번주주문?><?php echo ($infoweek['count'] > 0) ? '<span class="gray">('.$infoweek['count'].')</span>' : '';//건수?></a></td>
                <td class="td_score_sale"><a href="<?php echo $infomonth['href'];?>"> <?php echo ($infomonth['price'] > 0) ? number_format($infomonth['price']) : '<b style="color:#eaeaea;">O</b>';//이번달주문?><?php echo ($infomonth['count'] > 0) ? '<span class="gray">('.$infomonth['count'].')</span>' : '';//건수?></a></td>
                <td class="td_score_sale"><a href="<?php echo $infolastmonth['href'];?>"> <?php echo ($infolastmonth['price'] > 0) ? number_format($infolastmonth['price']) : '<b style="color:#eaeaea;">O</b>';//지난달주문?><?php echo ($infolastmonth['count'] > 0) ? '<span class="gray">('.$infolastmonth['count'].')</span>' : '';//건수?></a></td>
                <td class="td_score_sale">
                    <?php //전달 대비 계산 (이번달주문 - 전달주문)
				        $lastmonth_contrast = number_format($infomonth['price'] - $infolastmonth['price']);
						$lastmonth_cnt_contrast = number_format($infomonth['count'] - $infolastmonth['count']);
				    ?>
                    <?php echo ($lastmonth_contrast >= 0) ? '<span class="lightpink">'.$lastmonth_contrast.' ▲</span>' : '<span class="blue">'.$lastmonth_contrast.' ▼</span>';//전달대비산출금액?>
                </td>
            </tr>
           <!--//--> 
        </tbody>
    </table>
    <h5>┗ <span class="font-11 black font-normal"> 주문/매출/입금/취소별 현황</span> <span class="font-11 gray font-normal">매출현황은 주문일기준으로 계산되며, 입금현황은 입금(결제)일 기준으로 해당일자에 실제입금액을 확인할 수 있습니다</span></h5>
    </div><!-- [표]매출현황 요약 끝 { -->