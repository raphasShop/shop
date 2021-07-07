<?php
$sub_menu = '416170';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '위시리스트관리(전체보기)';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$where = " where ";
$sql_search = "";
if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx != $stx)
        $page = 1;
}

if ($sca != "") {
    $sql_search .= " and ca_id like '$sca%' ";
}

if ($sfl == "")  $sfl = "it_name";
if (!$sst) {
    $sst = "wi_id";
    $sod = "desc";
}

// 테이블의 전체 레코드수만 얻음
$sql_common = "  from {$g5['g5_shop_wish_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id ) ";
$sql_common .= $sql_search;

$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql_confirm = " select count(*) as cnt " . $sql_common1;
$row_confirm = sql_fetch($sql_confirm);
$total_confirm_count = $row_confirm['cnt'];


$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select a.wi_id, a.wi_time, a.mb_id, a.wi_ip, b.* 
          $sql_common
          order by $sst $sod, a.wi_id desc
          limit $from_record, $rows ";
$result = sql_query($sql);

//$qstr = 'page='.$page.'&amp;sst='.$sst.'&amp;sod='.$sod.'&amp;stx='.$stx;
$qstr .= ($qstr ? '&amp;' : '').'sca='.$sca.'&amp;save_stx='.$stx;

/*
$sql2 = " select mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_point from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
$row2 = sql_fetch($sql2);
$mb_nick = get_sideview($row2['mb_id'], get_text($row2['mb_nick']), $row2['mb_email'], $row2['mb_homepage']);
*/
?>

<!-- 검색창 -->
<div class="dan-schbox1" style="text-align:center;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
<form name="flist" class="big_sch01 big_sch">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="it_name" <?php echo get_selected($sfl, 'id_name'); ?>>상품명</option>
    <option value="a.it_id" <?php echo get_selected($sfl, 'a.it_id'); ?>>상품번호</option>
    <option value="mb_id" <?php echo get_selected($sfl, 'mb_id'); ?>>회원아이디</option>  
</select>

<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx; ?>" required class="frm_input_big required">
<input type="submit" value="검색" class="btn_submit_big">
<?php echo $listall; //전체보기?>
</form>
    </div><!-- } row 끝 -->
</div><!-- 검색창 -->
<!-- 검색창 끝 -->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <strong><?php echo number_format($total_count) ?></strong> 개의 위시리스트(찜)에 담긴 상품이 검색되었습니다.
</div>
<!-- // -->


<!-- @@@@@@@@@@ 리스트 출력 @@@@@@@@@@ -->
<form name="fwishlistallview" method="post" action="./wishlist_allview_update.php" onsubmit="return fwishlistallview_submit(this);" autocomplete="off">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <thead>
    <tr>
        <th scope="col"><label for="chkall" class="sound_only">전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)"></th>
        <th scope="col">상품코드</th>
        <th scope="col" colspan="2">상품명</th>
        <th scope="col">기본판매가</th>
        <th scope="col">담은날짜</th>
        <th scope="col">회원/접속IP</th>
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
        <td class="td_num">
               <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i; ?>">
               <input type="hidden" name="wi_id[<?php echo $i; ?>]" value="<?php echo $row['wi_id']; ?>">
        </td>
        <td class="td_code" style="white-space:nowrap;">
			<b><?php echo $row['it_id']; ?></b>
        </td>
		<td style="width:50px;">
            <a href="<?php echo $href; ?>" target="_blank"><?php echo get_it_image($row['it_id'], 50, 50); ?></a>
        </td>
        <td>
            <a href="<?php echo $href; ?>" target="_blank"><?php echo cut_str($row['it_name'],30); ?></a>
        </td>
        <td align="center">
            \<?php echo number_format($row['it_price']); //가격?>
        </td>
        <td align="center">
            <?php echo $row['wi_time']; //위시리스트에 담은시간?>
        </td>
         <td class="td_writename">
            <?php echo $row['mb_id']; ?>
			<?php echo ($is_admin == 'super') ? '<br>'.$row['wi_ip'] : '';//최고관리자만 보임?>
        </td>
    </tr>
    <?php
    }

    if ($i == 0) {
        echo '<tr><td colspan="7" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>

<!--
<div class="btn_list01 btn_list">
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
</div>
-->

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">
    <div class="bq_basic">
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
    </div>
</div>
<!--//-->

</form>


<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<div class="local_desc01 local_desc">
    위시리스트 삭제안내<br>
    찜 해놓은 상품으로 이후 구매할 수 있는 상품입니다. 주문등에 연동된 데이터가 아니기에 삭제를 해도 다른 데이터에 영향을 주지는 않습니다.<br>
    회원이 직접 찜한것으로, 일정기간이 지난 위시리스트는 데이타 용량을 위해서 삭제하셔도 됩니다.</div>

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

function fwishlistallview_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
