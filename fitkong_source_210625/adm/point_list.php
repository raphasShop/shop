<?php
$sub_menu = "200160"; /*원본메뉴 200200*/
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$sql_common = " from {$g5['point_table']} ";

$sql_search = " where (1) ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'mb_id' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "po_id";
    $sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search}
            {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

//$rows = $config['cf_page_rows'];
$rows = 200;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            {$sql_order}
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$mb = array();
if ($sfl == 'mb_id' && $stx)
    $mb = get_member($stx);

$g5['title'] = '포인트관리';
include_once ('./admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$colspan = 9;

$po_expire_term = '';
if($config['cf_point_term'] > 0) {
    $po_expire_term = $config['cf_point_term'];
}

if (strstr($sfl, "mb_id"))
    $mb_id = $stx;
else
    $mb_id = "";
?>

<!-- 검색창 -->
<div class="dan-schbox1" style="text-align:center;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
<form name="fsearch" id="fsearch" class="big_sch01 big_sch" method="get">
<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id"); ?>>회원아이디</option>
    <option value="po_content"<?php echo get_selected($_GET['sfl'], "po_content"); ?>>내용</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input_big">
<input type="submit" class="btn_submit_big" value="검색">
<?php echo $listall; //전체보기?>
<?php /* 사용안함- 그누5.0.30버전에서 삭제된기능 - 이유가있을것으로보임
    if ($is_admin == "super") { 
        echo "<a href='javascript:point_clear();'>포인트정리</a>";
    }
*/ ?> 
</form>
    </div><!-- } row 끝 -->
</div><!-- 검색창 -->
<!-- 검색창 끝 -->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <div class="totallist">
    <strong><?php echo number_format($total_count) ?></strong> 건의 포인트내역이 있습니다
    <?php
    if (isset($mb['mb_id']) && $mb['mb_id']) {
        echo '&nbsp;(' . $mb['mb_id'] .' 님의 포인트 합계 : ' . number_format($mb['mb_point']) . '점)';
    } else {
        $row2 = sql_fetch(" select sum(po_point) as sum_point from {$g5['point_table']} ");
        echo '&nbsp;(전체 합계 '.number_format($row2['sum_point']).'점)';
    }
    ?>
    </div>
</div>
<!-- // -->

<form name="fpointlist" id="fpointlist" method="post" action="./point_list_delete.php" onsubmit="return fpointlist_submit(this);">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">포인트 내역 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col"><?php echo subject_sort_link('mb_id') ?>회원아이디</a></th>
        <th scope="col">이름</th>
        <th scope="col">닉네임</th>
        <th scope="col"><?php echo subject_sort_link('po_content') ?>포인트 내용</a></th>
        <th scope="col"><?php echo subject_sort_link('po_point') ?>포인트</a></th>
        <th scope="col"><?php echo subject_sort_link('po_datetime') ?>일시</a></th>
        <th scope="col">만료일</th>
        <th scope="col">포인트합</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        if ($i==0 || ($row2['mb_id'] != $row['mb_id'])) {
            $sql2 = " select mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_point from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
            $row2 = sql_fetch($sql2);
        }

        $mb_nick = get_sideview($row['mb_id'], $row2['mb_nick'], $row2['mb_email'], $row2['mb_homepage']);

        $link1 = $link2 = '';
        if (!preg_match("/^\@/", $row['po_rel_table']) && $row['po_rel_table']) {
            $link1 = '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$row['po_rel_table'].'&amp;wr_id='.$row['po_rel_id'].'" target="_blank">';
            $link2 = '</a>';
        }

        $expr = '';
        if($row['po_expired'] == 1)
            $expr = ' txt_expired';

        // 포인트 차감일경우 바탕색변경
		$bg = 'bg'.($i%2);
		$td_color = 0;
		if ($row['po_point'] < 0) {
		    $bg .= 'minus';
            $td_color = 1;
		}
		// 포인트 차감일경우 바탕색변경
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_chk">
            <input type="hidden" name="mb_id[<?php echo $i ?>]" value="<?php echo $row['mb_id'] ?>" id="mb_id_<?php echo $i ?>">
            <input type="hidden" name="po_id[<?php echo $i ?>]" value="<?php echo $row['po_id'] ?>" id="po_id_<?php echo $i ?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo $row['po_content'] ?> 내역</label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
        <td class="td_mbid"><a href="?sfl=mb_id&amp;stx=<?php echo $row['mb_id'] ?>"><?php echo $row['mb_id'] ?></a></td>
        <td class="td_mbname"><?php echo get_text($row2['mb_name']); ?></td>
        <td class="td_name sv_use"><div><?php echo $mb_nick ?></div></td>
        <td class="td_pt_log"><?php echo $link1 ?><?php echo $row['po_content'] ?><?php echo $link2 ?></td>
        <td class="td_nummiddle td_pt">
		<?php if ($row['po_point'] > 0) { ?>
            <?php echo number_format($row['po_point']) ?>
        <?php } else { ?>
            <b style="color:#FF4E50;"><?php echo number_format($row['po_point']) ?></b>
        <?php } ?>
        </td>
        <td class="td_datetime"><?php echo $row['po_datetime'] ?></td>
        <td class="td_date<?php echo $expr; ?>">
            <?php if ($row['po_expired'] == 1) { ?>
            만료<?php echo substr(str_replace('-', '', $row['po_expire_date']), 2); ?>
            <?php } else echo $row['po_expire_date'] == '9999-12-31' ? '&nbsp;' : $row['po_expire_date']; ?>
        </td>
        <td class="td_numbig td_pt">
		<?php if ($row['po_mb_point'] > 0) { ?>
            <?php echo number_format($row['po_mb_point']) ?>
        <?php } else { ?>
            <b style="color:#FF4E50;"><?php echo number_format($row['po_mb_point']) ?></b>
        <?php } ?>   
        </td>
    </tr>

    <?php
    }

    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_list01 btn_list">
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
</div>

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">
    <div class="bq_basic">
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
    </div>
</div>
<!--//-->

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<section><!-- 포인트 내역출력 섹션 열기 { -->
<h5><i class="fa fa-download"></i> 포인트 내역 엑셀출력</h5>
<div class="local_sch02 local_sch" style="border:solid 5px #aaa; background:#fff; padding:25px 25px 25px;"><!-- 포인트 내역 출력 선택창 열기 { -->

    <div>
        <form name="pointprint" action="./pointprintresult.php" onsubmit="return fpointprintcheck(this);" autocomplete="off">
        <input type="hidden" name="case" value="1">

        <strong class="sch_long">기간별 출력</strong>
        <input type="radio" name="csv" value="xls" id="xls">
        <label for="xls1">MS엑셀 XLS 파일</label>
        <input type="radio" name="csv" value="csv" id="csv">
        <label for="csv1">MS엑셀 CSV 파일</label>
        <label for="fr_date" class="sound_only">기간 시작일</label>
        <input type="text" name="fr_date" value="<?php echo date("Ymd"); ?>" id="fr_date" required class="required frm_input" size="8" maxlength="8">
        ~
        <label for="to_date" class="sound_only">기간 종료일</label>
        <input type="text" name="to_date" value="<?php echo date("Ymd"); ?>" id="to_date" required class="required frm_input" size="8" maxlength="8">
        <input type="submit" value="출력 (새창)" class="btn_submit">

        </form>
    </div>

   

</div><!-- } 포인트내역출력 선택창 닫기 //-->
</section><!-- } 포인트내역출력 섹션 닫기 //-->

<section id="point_mng">
    <h2 class="h2_frm">개별회원 포인트 증감 설정</h2>

    <form name="fpointlist2" method="post" id="fpointlist2" action="./point_update.php" autocomplete="off">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="token" value="<?php echo $token ?>">

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="mb_id">회원아이디<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="mb_id" value="<?php echo $mb_id ?>" id="mb_id" class="required frm_input" required></td>
        </tr>
        <tr>
            <th scope="row"><label for="po_content">포인트 내용<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="po_content" id="po_content" required class="required frm_input w100per"></td>
        </tr>
        <tr>
            <th scope="row"><label for="po_point">포인트<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="po_point" id="po_point" required class="required frm_input"></td>
        </tr>
        <?php if($config['cf_point_term'] > 0) { ?>
        <tr>
            <th scope="row"><label for="po_expire_term">포인트 유효기간</label></th>
            <td><input type="text" name="po_expire_term" value="<?php echo $po_expire_term; ?>" id="po_expire_term" class="frm_input" size="5"> 일</td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="확인" class="btn_submit">
    </div>

    </form>

</section>
<script>
$(function(){
    $("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yymmdd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});

function fpointprintcheck(f)
{
    if (f.csv[0].checked || f.csv[1].checked)
    {
        f.target = "_top";
    }
    else
    {
        var win = window.open("", "winprint", "left=10,top=10,width=750,height=800,menubar=yes,toolbar=yes,scrollbars=yes");
        f.target = "winprint";
    }

    f.submit();
}
</script>

<script>
function fpointlist_submit(f)
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
include_once ('./admin.tail.php');
?>
