<?php
$sub_menu = '422500'; /* 원본메뉴코드 500110 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$fr_date = preg_replace('/[^0-9]/i', '', $fr_date);
$to_date = preg_replace('/[^0-9]/i', '', $to_date);

$fr_date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $fr_date);
$to_date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $to_date);



$g5['title'] = $fr_date.' ~ '.$to_date.' 일별 접속현황';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');




function get_date( $date, $gap ) {
    // 년월일로 되어 있는 포멧인 경우
    $date = preg_replace("/[^0-9]/", "", $date); // 숫자 이외 제거
    $y = substr( $date, 0, 4 );
    $m = substr( $date, 4, 2 );
    $d = substr( $date, 6, 2 );
    return date("Y-m-d", mktime(0,0,0, $m, $d + $gap, $y));
}

function get_time_range ($date) {
    $date = preg_replace("/[^0-9]/", "", $date);
    $h = substr( $date, 0, 2 );
    if($h == '01' || $h == '02' || $h == '03' || $h == '04' || $h == '05' || $h == '06' || $h == '07') $t = '01';
    if($h == '08' || $h == '09' || $h == '10' || $h == '11') $t = '08';
    if($h == '12' || $h == '13' || $h == '14' || $h == '15' || $h == '16' || $h == '17' || $h == '18') $t = '12';
    if($h == '19' || $h == '20' || $h == '21' || $h == '22' || $h == '23' || $h == '00') $t = '19';

    return $t;
}

?>
<div id="this_print"><!-- [PRINT] 인쇄공간 감싸기 시작 this_print -->

<!-- 검색창 시작 { -->
<div class="dan-datebox_mobile" style="margin-bottom:20px;"><!-- 분류별검색창 -->
    <div class="row"><!-- row 시작 { -->
        <form name="frm_sale_date" action="./promotiondatelist.php" class="big_sch02 big_sch" method="get">
        <strong>일별접속자현황</strong>
        <input type="text" name="fr_date" value="<?php echo $fr_date; ?>" id="fr_date" required class="frm_input" size="10" maxlength="10" style="width:85px;">
        ~
        <input type="text" name="to_date" value="<?php echo $to_date; ?>" id="to_date" required class="frm_input" size="10" maxlength="10" style="width:85px;">
        <input type="hidden" name="pa_code" value="<?php echo $pa_code; ?>" id="pa_code" required class="frm_input" size="30" maxlength="50" style="width:85px;">
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

<div class="tbl_head01 tbl_wrap">

    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <thead>
    <tr>
        <th scope="col">접속일</th>
        <th scope="col">접속자수</th>
        <th scope="col">접속자수(PC)</th>
        <th scope="col">접속자수(Mobile)</th>
        <th scope="col">매출전환 수</th>
        <th scope="col">매출전환 금액</th>
        <th scope="col">접속자수(01~08)</th>
        <th scope="col">접속자수(08~12)</th>
        <th scope="col">접속자수(12~19)</th>
        <th scope="col">접속자수(19~25)</th>
    </tr>
    </thead>
    <tbody>
    <?php
    unset($save);
    unset($tot);

    $update = $to_date;

    while(1) {
        $sql = " select * from {$g5['promotion_access_table']} where apa_date = '$update' and pa_code = '$pa_code' ";
        $result = sql_query($sql);

        $dayhit = 0;
        $dayhit_mo = 0;
        $dayhit_pc = 0;
        $daypurchase = 0;
        $daypurchase_val = 0;
        $dayhit_time01 = 0;
        $dayhit_time08 = 0;
        $dayhit_time12 = 0;
        $dayhit_time19 = 0;

        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            if($row['apa_purchase']){
                $daypurchase++;
                $daypurchase_val = $daypurchase_val + (int)$row['apa_purchase_val'];
            }

            if($row['apa_device'] == 'pc') {
                $dayhit_pc++;
            } else {
                $dayhit_mo++;
            }

            $dayhit++;

            $ti = get_time_range($row['apa_time']);
            if($ti == '01') {
                $dayhit_time01++;
            } else if ($ti == '08') {
                $dayhit_time08++;
            } else if ($ti == '12') {
                $dayhit_time12++;
            } else if ($ti == '19') {
                $dayhit_time19++;
            }
        }
        $bg = 'bg'.($i%2);
    ?>
        
   
        <tr class="<?php echo $bg; ?>">
            <td class="td_alignc" style="width:50px;"><?php echo $update; ?></td>
            <td class="td_num"><?php echo number_format($dayhit); ?></td>
            <td class="td_num"><?php echo number_format($dayhit_pc); ?></td>
            <td class="td_num"><?php echo number_format($dayhit_mo); ?></td>
            <td class="td_num"><?php echo number_format($daypurchase); ?></td>
            <td class="td_num"><?php echo number_format($daypurchase_val); ?></td>
            <td class="td_num"><?php echo number_format($dayhit_time01); ?></td>
            <td class="td_num"><?php echo number_format($dayhit_time08); ?></td>
            <td class="td_num"><?php echo number_format($dayhit_time12); ?></td>
            <td class="td_num"><?php echo number_format($dayhit_time19); ?></td>
        </tr>

    <?       
        
        if ($fr_date == $update || $fr_date > $update) {
            break;
        }

        $update = get_date($update,-1);

    }
    
    
    ?>
    </tbody>
    </table>
</div>

</div><!-- [PRINT] 인쇄공간 감싸기 끝 this_print -->



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
        document.getElementById("fr_date").value = "<?php echo G5_TIME_YMD; ?>";
        document.getElementById("to_date").value = "<?php echo G5_TIME_YMD; ?>";
    } else if (today == "어제") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
    } else if (today == "이번주") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-'.$date_term.' days', G5_SERVER_TIME)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
    } else if (today == "이번달") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-01', G5_SERVER_TIME); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
    } else if (today == "지난주") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-'.$week_term.' days', G5_SERVER_TIME)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', strtotime('-'.($week_term - 6).' days', G5_SERVER_TIME)); ?>";
    } else if (today == "지난달") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-01', strtotime('-1 Month', $last_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-t', strtotime('-1 Month', $last_term)); ?>";    
	} else if (today == "1주일") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-7 days', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "1개월") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-1 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	
	} else if (today == "3개월") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-3 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "6개월") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-6 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "1년") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-12 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "초기화") {
        document.getElementById("fr_date").value = "";
        document.getElementById("to_date").value = "";
    }
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
