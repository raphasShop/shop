<?php
$sub_menu = '416410'; /* 원본메뉴코드 500140 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '위시리스트 순위표';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

if (!$to_date) $to_date = date("Ymd", time());

$doc = strip_tags($doc);
$sort1 = strip_tags($sort1);
$sel_ca_id = get_search_string($sel_ca_id);

if( preg_match("/[^0-9]/", $fr_date) ) $fr_date = '';
if( preg_match("/[^0-9]/", $to_date) ) $to_date = '';

if ($sort1 == "") $sort1 = "it_id_cnt";
if (!in_array($sort1, array('mb_id', 'it_id', 'wi_time', 'wi_ip'))) $sort1 = "it_id_cnt";
if ($sort2 == "" || $sort2 != "asc") $sort2 = "desc";

$sql  = " select a.it_id,
                 b.it_name,
                 COUNT(a.it_id) as it_id_cnt
            from {$g5['g5_shop_wish_table']} a, {$g5['g5_shop_item_table']} b ";
$sql .= " where a.it_id = b.it_id ";
if ($fr_date && $to_date)
{
    $fr = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $fr_date);
    $to = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $to_date);
    $sql .= " and a.wi_time between '$fr 00:00:00' and '$to 23:59:59' ";
}
if ($sel_ca_id)
{
    $sql .= " and b.ca_id like '$sel_ca_id%' ";
}
$sql .= " group by a.it_id, b.it_name
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

$qstr1 = $qstr.'&amp;fr_date='.$fr_date.'&amp;to_date='.$to_date.'&amp;sel_ca_id='.$sel_ca_id;

//전체보기 echo $listall; - 크림장수
$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'"><button type="button"><i class="fa fa-bars"></i>&nbsp;전체</button></a>';
?>

<!-- 검색창 -->
<form name="flist" class="big_sch_out">
<input type="hidden" name="doc" value="<?php echo $doc; ?>">
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
        echo "<option value='{$row1['ca_id']}'".get_selected($row1['ca_id'], $sel_ca_id).">$nbsp {$row1['ca_name']}\n";
    }
    ?>
</select>
<!--//-->

<label for="fr_date" class="sound_only">시작일</label>
<input type="text" name="fr_date" value="<?php echo $fr_date; ?>" id="fr_date" required class="required frm_input" size="8" maxlength="8">
~
<label for="to_date" class="sound_only">종료일</label>
<input type="text" name="to_date" value="<?php echo $to_date; ?>" id="to_date" required class="required frm_input" size="8" maxlength="8">
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
<button type="button" onClick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/wishlist.php'"><i class="fa fa-refresh" aria-hidden="true"></i> 선택초기화</button>
</div>
</form>
<!-- 검색창 끝 -->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <strong><?php echo number_format($total_count); ?></strong> 개의 찜된 상품이 검색되었습니다
</div>
<!-- // -->

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <thead>
    <tr>
        <th scope="col">순위</th>
        <th scope="col">상품명</th>
        <th scope="col">건수</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        // $s_mod = icon("수정", "./itemqaform.php?w=u&amp;iq_id={$row['iq_id']}&amp;$qstr");
        // $s_del = icon("삭제", "javascript:del('./itemqaupdate.php?w=d&amp;iq_id={$row['iq_id']}&amp;$qstr');");

        $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
        $num = $rank + $i + 1;

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_num"><?php echo $num; ?></td>
        <td>
            <a href="<?php echo $href; ?>"><?php echo get_it_image($row['it_id'], 50, 50); ?> <?php echo cut_str($row['it_name'],30); ?></a>
        </td>
        <td class="td_numbig" style="background:#FEF8CA;"><?php echo $row['it_id_cnt']; ?></td>
    </tr>
    <?php
    }

    if ($i == 0) {
        echo '<tr><td colspan="3" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr1&amp;page="); ?>

<div class="local_desc01 local_desc">
    <p>고객님들이 보관함에 가장 많이 넣은 순으로 순위를 출력합니다.</p>
</div>

<!-- 스크롤시 나타나는 버튼 추가 #scroll-button (관련수정 : admin.css파일 272줄부근/admin.head.php 155줄부근 스크립트) -->
<div id="scroll-button" style="display:none;">
    <div class="btn_scroll_basic btn_list">
		<?php if(!$fr_date && !$to_date) { //전체기간?>
            분류나 기간별로 보실 수 있습니다.
        <?php } else { //기간선택?>
		    위시리스트순위 적용기간&nbsp;&nbsp;<span class="black"><?php echo $fr_date; ?> ~ <?php echo $to_date; ?></span>
        <?php } ?>
    </div>
</div>
<!--//-->

<script>
$(function() {
    $("#fr_date, #to_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yymmdd",
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
    $last_term = strtotime(date('Ym01', G5_SERVER_TIME)); // 매월1일기준
	$month_term = strtotime(date('Ymd', G5_SERVER_TIME)); // 매월 오늘날짜 기준
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