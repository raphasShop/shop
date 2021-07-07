<?php
$sub_menu = '415310'; /* 새로 만든 페이지 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '상품별매출표';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

//if (!$to_date) $to_date = date("Ymd", time());

if ($sort1 == "") $sort1 = "ct_status_sum";
if ($sort2 == "" || $sort2 != "asc") $sort2 = "desc";

$doc = strip_tags($doc);
$sort1 = strip_tags($sort1);

$sql  = " select a.it_id,
                 b.*,
                 SUM(IF(ct_status = '쇼핑',ct_qty, 0)) as ct_status_1,
                 SUM(IF(ct_status = '주문',ct_qty, 0)) as ct_status_2,
                 SUM(IF(ct_status = '입금',ct_qty, 0)) as ct_status_3,
                 SUM(IF(ct_status = '준비',ct_qty, 0)) as ct_status_4,
                 SUM(IF(ct_status = '배송',ct_qty, 0)) as ct_status_5,
                 SUM(IF(ct_status = '완료',ct_qty, 0)) as ct_status_6,
                 SUM(IF(ct_status = '취소',ct_qty, 0)) as ct_status_7,
                 SUM(IF(ct_status = '반품',ct_qty, 0)) as ct_status_8,
                 SUM(IF(ct_status = '품절',ct_qty, 0)) as ct_status_9,
				 SUM(IF(ct_status = '교환',ct_qty, 0)) as ct_status_10,
				 SUM(IF(ct_status = '환불',ct_qty, 0)) as ct_status_11,
                 SUM(ct_qty) as ct_status_sum,
				 b.*,
				 SUM(IF(ct_status = '입금', ((ct_price + io_price) * ct_qty) - ct_point, 0)) as price_3,
				 SUM(IF(ct_status = '준비', ((ct_price + io_price) * ct_qty) - ct_point, 0)) as price_4,
				 SUM(IF(ct_status = '배송', ((ct_price + io_price) * ct_qty) - ct_point, 0)) as price_5,
				 SUM(IF(ct_status = '완료', ((ct_price + io_price) * ct_qty) - ct_point, 0)) as price_6,
				 SUM(IF(ct_status = '취소', ((ct_price + io_price) * ct_qty) - ct_point, 0)) as price_7,
				 SUM(IF(ct_status = '반품', ((ct_price + io_price) * ct_qty) - ct_point, 0)) as price_8,
				 SUM(IF(ct_status = '품절', ((ct_price + io_price) * ct_qty) - ct_point, 0)) as price_9,
				 SUM(IF(ct_status = '교환', ((ct_price + io_price) * ct_qty) - ct_point, 0)) as price_10,
				 SUM(IF(ct_status = '환불', ((ct_price + io_price) * ct_qty) - ct_point, 0)) as price_11

            from {$g5['g5_shop_cart_table']} a, {$g5['g5_shop_item_table']} b ";
$sql .= " where a.it_id = b.it_id ";
if ($fr_date && $to_date)
{
    $fr = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $fr_date);
    $to = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $to_date);
    $sql .= " and ct_time between '$fr 00:00:00' and '$to 23:59:59' ";
}
if ($sel_ca_id)
{
    $sql .= " and b.ca_id like '$sel_ca_id%' ";
}
$sql .= " group by a.it_id
          order by $sort1 $sort2 ";
$result = sql_query($sql);
$total_count = sql_num_rows($result);

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$rank = ($page - 1) * $rows;

$sql = $sql . " limit $from_record, $rows ";
$result = sql_query($sql);

//$qstr = 'page='.$page.'&amp;sort1='.$sort1.'&amp;sort2='.$sort2;
$qstr1 = $qstr.'&amp;fr_date='.$fr_date.'&amp;to_date='.$to_date.'&amp;sel_ca_id='.$sel_ca_id;

//전체보기 echo $listall; - 크림장수
$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'"><button type="button"><i class="fa fa-bars"></i>&nbsp;전체</button></a>';
?>
<!-- [PRINT] 인쇄용 제이쿼리 인클루드 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.5.1/jQuery.print.min.js"></script>
<!--//-->
<div id="this_print"><!-- [PRINT] 인쇄공간 감싸기 시작 this_print -->

<!-- 검색창 시작 { -->
<form name="flist" class="big_sch_out">
<input type="hidden" name="doc" value="<?php echo $doc; ?>">
<input type="hidden" name="sort1" value="<?php echo $sort1; ?>">
<input type="hidden" name="sort2" value="<?php echo $sort2; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="sch_last">
<!-- 분류 -->
<label for="sel_ca_id" class="sound_only">검색대상</label>
<select name="sel_ca_id" id="sel_ca_id">
    <option value=''>전체분류</option>
    <?php
    $sql1 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} order by ca_order, ca_id ";
    $result1 = sql_query($sql1);
    for ($i=0; $row1=sql_fetch_array($result1); $i++) {
        $len = strlen($row1['ca_id']) / 2 - 1;
        $nbsp = "";
        for ($i=0; $i<$len; $i++) $nbsp .= "－";
        echo '<option value="'.$row1['ca_id'].'" '.get_selected($sel_ca_id, $row1['ca_id']).'>'.$nbsp.' '.$row1['ca_name'].'</option>'.PHP_EOL;
    }
    ?>
</select>
<!--//-->

<label for="fr_date" class="sound_only">시작일</label>
<input type="text" name="fr_date" value="<?php echo $fr_date; ?>" id="fr_date" required class="required frm_input" size="8" maxlength="8" style="width:70px"> ~
<label for="to_date" class="sound_only">종료일</label>
<input type="text" name="to_date" value="<?php echo $to_date; ?>" id="to_date" required class="required frm_input" size="8" maxlength="8" style="width:70px">
&nbsp;
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
</div>

<div class="sch_btn">
<input type="submit" value="선택검색" class="btn_submit_big">
<button type="button" onClick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/sale2item.php'"><i class="fa fa-refresh" aria-hidden="true"></i>  전체보기</button>
</div>
</form>
<!-- 검색창 끝 -->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <strong><?php echo number_format($total_count); ?></strong> 개의 판매상품이 검색되었습니다
</div>
<!-- // -->

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" rowspan="2">순위</th>
        <th scope="col" rowspan="2" colspan="2">상품명</th>
        <th scope="col" colspan="2" style="background:#53D0C7;"><a href="<?php echo title_sort("ct_status_6",1)."&amp;$qstr1"; ?>">구매완료</a> <span class="font-normal">(배송완료기준)</span></th>
        <th scope="col" colspan="2" style="background:#53D0C7;"><a href="<?php echo title_sort("ct_status_3",1)."&amp;$qstr1"; ?>">입금완료</a> <span class="font-normal">(입금기준)</span></th>
        <th scope="col" colspan="2"><a href="<?php echo title_sort("ct_status_7",1)."&amp;$qstr1"; ?>">입금전취소</a></th>
        <th scope="col" colspan="2"><a href="<?php echo title_sort("ct_status_8",1)."&amp;$qstr1"; ?>">반품</a></th>
        <!--<th scope="col" colspan="2"><a href="<?php echo title_sort("ct_status_9",1)."&amp;$qstr1"; ?>">품절</a></th>-->
        <th scope="col" colspan="2"><a href="<?php echo title_sort("ct_status_11",1)."&amp;$qstr1"; ?>">환불</a></th>
    </tr>
    <tr>
        <!-- 순위행합침 -->
        <!-- 상품명행합침 -->
        <!-- 완료 -->
        <th scope="col" style="background:#7EDCD5;"><a href="<?php echo title_sort("ct_status_6",1)."&amp;$qstr1"; ?>">개수</a></th>
        <th scope="col" style="background:#7EDCD5;"><a href="<?php echo title_sort("price_6",1)."&amp;$qstr1"; ?>">금액</a></th>
        <!-- 입금기준 -->
        <th scope="col" style="background:#7EDCD5;">개수</th>
        <th scope="col" style="background:#7EDCD5;">금액</th>
        <!-- 취소 -->
        <th scope="col"><a href="<?php echo title_sort("ct_status_7",1)."&amp;$qstr1"; ?>">개수</a></th>
        <th scope="col"><a href="<?php echo title_sort("price_7",1)."&amp;$qstr1"; ?>">금액</a></th>
        <!-- 반품 -->
        <th scope="col"><a href="<?php echo title_sort("ct_status_8",1)."&amp;$qstr1"; ?>">개수</a></th>
        <th scope="col"><a href="<?php echo title_sort("price_8",1)."&amp;$qstr1"; ?>">금액</a></th>
        <!-- 품절 
        <th scope="col"><a href="<?php echo title_sort("ct_status_9",1)."&amp;$qstr1"; ?>">개수</a></th>
        <th scope="col"><a href="<?php echo title_sort("price_9",1)."&amp;$qstr1"; ?>">금액</a></th>
        -->
        <!-- 환불 -->
        <th scope="col"><a href="<?php echo title_sort("ct_status_11",1)."&amp;$qstr1"; ?>">개수</a></th>
        <th scope="col"><a href="<?php echo title_sort("price_11",1)."&amp;$qstr1"; ?>">금액</a></th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $href = G5_SHOP_URL."/item.php?it_id={$row['it_id']}";

        $num = $rank + $i + 1;

        $bg = 'bg'.($i%2);
		
		// 입금완료 금액 (입금+준비+배송+완료+교환)
		$price_pay_cnt = $row['ct_status_3'] + $row['ct_status_4'] + $row['ct_status_5'] + $row['ct_status_6'] + $row['ct_status_10'];
		$price_pay = $row['price_3'] + $row['price_4'] + $row['price_5'] + $row['price_6'] + $row['price_10'];
        ?>
        <tr class="<?php echo $bg; ?>">
            <td class="td_num"><?php echo $num; ?></td>
            <td style="width:50px;"><a href="<?php echo $href; ?>"><?php echo get_it_image($row['it_id'], 50, 50); ?></a></td>
            <td><a href="<?php echo $href; ?>"><?php echo cut_str($row['it_name'],30); ?></a></td>
            <!-- 완료 -->
            <td class="td_sale_nums" style="width:60px;background:#DCFFFF;"><?php echo $row['ct_status_6']; //완료건수?></td>
            <td class="td_sale_price" style="width:80px;background:#E5FFFF;"><?php echo number_format($row['price_6']); //완료금액?></td>
            <!-- 입금(입금+준비+배송+완료+교환) -->
            <td class="td_sale_nums" style="width:60px;background:#DCFFFF;"><?php echo $price_pay_cnt; //입금기준건수?></td>
            <td class="td_sale_price" style="width:80px;background:#E5FFFF;"><?php echo number_format($price_pay); //입금기준금액?></td>
            <!-- 취소 -->
            <td class="td_sale_nums"><?php echo $row['ct_status_7']; //취소건수?></td>
            <td class="td_sale_price"><?php echo number_format($row['price_7']); //취소금액?></td>
            <!-- 반품 -->
            <td class="td_sale_nums"><?php echo $row['ct_status_8']; //반품건수?></td>
            <td class="td_sale_price"><?php echo number_format($row['price_8']); //반품금액?></td>
            <!-- 품절 
            <td class="td_sale_nums"><?php echo $row['ct_status_9']; //품절건수?></td>
            <td class="td_sale_price"><?php echo number_format($row['price_9']); //품절금액?></td>
            -->
            <!-- 환불 -->
            <td class="td_sale_nums"><?php echo $row['ct_status_11']; //환불건수?></td>
            <td class="td_sale_price"><?php echo number_format($row['price_11']); //환불금액?></td>
            
        </tr>
        <?php
    }

    if ($i == 0) {
        echo '<tr><td colspan="13" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr1&amp;page="); ?>

</div><!-- [PRINT] 인쇄공간 감싸기 끝 this_print -->

<div class="local_desc01 local_desc">
    <p>선택기간 동안 상품판매 수량별로 매출금액을 확인할 수 있습니다</p>
</div>

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

function set_date(today)
{
    <?php
    $date_term = date('w', G5_SERVER_TIME); // 일단위
    $week_term = $date_term + 7; //일주일단위
    $last_term = strtotime(date('Y-m-01', G5_SERVER_TIME)); // 매월1일기준
	$month_term = strtotime(date('Y-m-d', G5_SERVER_TIME)); // 매월 오늘날짜 기준
    ?>
    if (today == "오늘") {
        document.getElementById("fr_date").value = "<?php echo date("Ymd", G5_SERVER_TIME); ?>";
        document.getElementById("to_date").value = "<?php echo date("Ymd", G5_SERVER_TIME); ?>";
    } else if (today == "어제") {
        document.getElementById("fr_date").value = "<?php echo date('Ymd', G5_SERVER_TIME - 86400); ?>";
        document.getElementById("to_date").value = "<?php echo date('Ymd', G5_SERVER_TIME - 86400); ?>";
    } else if (today == "이번주") {
        document.getElementById("fr_date").value = "<?php echo date('Ymd', strtotime('-'.$date_term.' days', G5_SERVER_TIME)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Ymd', G5_SERVER_TIME); ?>";
    } else if (today == "이번달") {
        document.getElementById("fr_date").value = "<?php echo date('Ym01', G5_SERVER_TIME); ?>";
        document.getElementById("to_date").value = "<?php echo date('Ymd', G5_SERVER_TIME); ?>";
    } else if (today == "지난주") {
        document.getElementById("fr_date").value = "<?php echo date('Ymd', strtotime('-'.$week_term.' days', G5_SERVER_TIME)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Ymd', strtotime('-'.($week_term - 6).' days', G5_SERVER_TIME)); ?>";
    } else if (today == "지난달") {
        document.getElementById("fr_date").value = "<?php echo date('Ym01', strtotime('-1 Month', $last_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Ymt', strtotime('-1 Month', $last_term)); ?>";    
	} else if (today == "1주일") {
        document.getElementById("fr_date").value = "<?php echo date('Ymd', strtotime('-7 days', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Ymd', G5_SERVER_TIME); ?>";	
	} else if (today == "1개월") {
        document.getElementById("fr_date").value = "<?php echo date('Ymd', strtotime('-1 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Ymd', G5_SERVER_TIME); ?>";	
	
	} else if (today == "3개월") {
        document.getElementById("fr_date").value = "<?php echo date('Ymd', strtotime('-3 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Ymd', G5_SERVER_TIME); ?>";	
	} else if (today == "6개월") {
        document.getElementById("fr_date").value = "<?php echo date('Ymd', strtotime('-6 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Ymd', G5_SERVER_TIME); ?>";	
	} else if (today == "1년") {
        document.getElementById("fr_date").value = "<?php echo date('Ymd', strtotime('-12 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Ymd', G5_SERVER_TIME); ?>";	
	} else if (today == "초기화") {
        document.getElementById("fr_date").value = "";
        document.getElementById("to_date").value = "<?php echo date("Ymd", G5_SERVER_TIME); ?>";
    }
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>