<?php
$sub_menu = "416220"; /* 원본코드300400 */
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

if (empty($fr_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = date('Y-m-d', G5_SERVER_TIME - 2592000);
if (empty($to_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = G5_TIME_YMD;

$qstr = "fr_date={$fr_date}&amp;to_date={$to_date}";

$sql_common = " from {$g5['popular_table']} a ";
$sql_search = " where trim(pp_word) <> '' and pp_date between '{$fr_date}' and '{$to_date}' ";
$sql_group = " group by pp_word ";
$sql_order = " order by cnt desc ";

$sql = " select pp_word {$sql_common} {$sql_search} {$sql_group} ";
$result = sql_query($sql);
$total_count = sql_num_rows($result);

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select pp_word, count(*) as cnt {$sql_common} {$sql_search} {$sql_group} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

//전체보기 echo $listall; - 크림장수
$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'"><button type="button"><i class="fa fa-bars"></i>&nbsp;전체</button></a>';

$g5['title'] = '인기검색어순위';
include_once('./admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$colspan = 3;
?>

<script>
$(function(){
    $("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});
</script>

<div class="dan-datebox_mobile" style=" text-align:center;margin-bottom:10px;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
<form name="fsearch" id="fsearch" class="big_sch02 big_sch" method="get">
<div class="sch_last">
    <b style="font-size:14px;margin-right:15px;">기간별검색</b>
    <input type="text" name="fr_date" value="<?php echo $fr_date ?>" id="fr_date" class="frm_input" size="11" maxlength="10" style="width:90px;">
    <label for="fr_date" class="sound_only">시작일</label>
    ~
    <input type="text" name="to_date" value="<?php echo $to_date ?>" id="to_date" class="frm_input" size="11" maxlength="10" style="width:90px;">
    <label for="to_date" class="sound_only">종료일</label>
    <input type="submit" class="btn_submit" value="검색">
    <?php echo $listall; //전체보기?>
    <!-- 기간선택버튼 -->
    &nbsp;&nbsp;
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
    <button type="submit" onclick="javascript:set_date('1년');">1 년</button>
    <button type="button" onclick="javascript:set_date('전체');"><i class="fa fa-refresh" aria-hidden="true"></i> 초기화</button>
    <!--//-->
</div>
</form>
    </div><!-- } row 끝 -->
 </div><!-- 검색창 -->
<!-- 검색창 끝 -->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <strong><?php echo number_format($total_count) ?></strong> 개의 검색어가 검색되었습니다
</div>
<!-- // -->
<form name="fpopularrank" id="fpopularrank" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="<?php echo $token ?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">순위</th>
        <th scope="col">검색어</th>
        <th scope="col">검색회수</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {

        $word = get_text($row['pp_word']);
        $rank = ($i + 1 + ($rows * ($page - 1)));

    ?>

    <tr>
        <td class="td_num"><?php echo $rank ?></td>
        <td><?php echo $word ?></td>
        <td class="td_numbig"><?php echo $row['cnt'] ?></td>
    </tr>

    <?php
    }

    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

</form>

<?php
echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page=");
?>

<script>
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
	} else if (today == "전체") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-1 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo G5_TIME_YMD; ?>";
    }
}
</script>

<?php
include_once('./admin.tail.php');
?>
