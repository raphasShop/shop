<?php
$sub_menu = '411500'; /* 수정전 원본 메뉴코드 400410 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$sql_common = " from {$g5['g5_shop_order_data_table']} ";

$sql_search = " where cart_id <> '0' ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'od_id' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "od_id";
    $sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search}
            {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            {$sql_order}
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$g5['title'] = '결제중단/실패처리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$colspan = 10;
?>

<!-- 검색창 -->
<div class="dan-schbox1" style="text-align:center;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
<form name="fsearch" id="fsearch" class="big_sch01 big_sch" method="get">
    <select name="sfl" title="검색대상">
        <option value="od_id"<?php echo get_selected($_GET['sfl'], "od_id"); ?>>주문번호</option>
    </select>
    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
    <input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input_big">
    <input type="submit" class="btn_submit_big" value="검색">
    <?php echo $listall; //전체보기?>
</form>
    </div><!-- } row 끝 -->
</div><!-- 검색창 -->
<!-- 검색창 끝 -->

<div class="local_desc01 local_desc">
<p>
    <strong>[통신에러]</strong> 주문완료 되었는데 통신에러로 인해 주문서에는 들어오지 않는 경우<br>
    <strong>[주문자취소]</strong> 결제중 주문자가 취소한 경우<br>
    미완료주문건은 결제요청자체가 실패한 주문건으로 통신에러 또는 주문자가 결제완료전 취소에 의해, 실결제가 이루어지지 않은 주문 실패건입니다.<br>
    통신에러는 웹브라우저 문제로 결제사와의 통신이 에러가 나는 경우가 많습니다.<br>
    미완료주문처리에 뜨면,PG사 거래내역과 비교하여 바로 처리하세요.<br>
    <strong>&lt;주문복구&gt;</strong> 버튼을 클릭해서 재결제요청을 할 수 있으며, 정상처리되면 주문내역리스트에 노출됩니다.<br>
    <strong>주의!</strong> 장바구니 저장기간이 지나면 이데이터도 삭제되므로,빠른 시간에 확인하여 처리하세요.
</p>
</div>

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <strong><?php echo number_format($total_count) ?></strong> 개의 미완료주문이 검색되었습니다.
</div>
<!-- // -->

<form name="finorderlist" id="finorderlist" method="post" action="./inorderlistdelete.php" onsubmit="return finorderlist_submit(this);">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="token" value="">

<div class="tbl_head01 tbl_wrap" id="inorderlist">
    <table class="tbl_minwidth900">
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">미완료주문 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col"><?php echo subject_sort_link('od_id') ?>주문번호</a></th>
        <th scope="col">PG</th>
        <th scope="col">주문자</th>
        <th scope="col">주문자전화</th>
        <th scope="col">받는분</a></th>
        <th scope="col">주문금액</a></th>
        <th scope="col">결제방법</th>
        <th scope="col">주문일시</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $data = unserialize(base64_decode($row['dt_data']));

        switch($row['dt_pg']) {
            case 'inicis':
                $pg = 'KG이니시스';
                break;
            case 'lg':
                $pg = 'LGU+';
                break;
            default:
                $pg = 'KCP';
                break;
        }

        // 주문금액
        $sql = " select sum(if(io_type = '1', io_price, (ct_price + io_price)) * ct_qty) as price from {$g5['g5_shop_cart_table']} where od_id = '{$row['cart_id']}' and ct_status = '쇼핑' ";
        $ct = sql_fetch($sql);

        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_chk">
            <input type="hidden" id="od_id_<?php echo $i; ?>" name="od_id[<?php echo $i; ?>]" value="<?php echo $row['od_id']; ?>">
            <input type="checkbox" id="chk_<?php echo $i; ?>" name="chk[]" value="<?php echo $i; ?>" title="내역선택">
        </td>
        <td class="td_odrnum2"><?php echo $row['od_id']; ?></td>
        <td class="td_center"><?php echo $pg; ?></td>
        <td class="td_name"><?php echo get_text($data['od_name']); ?></td>
        <td class="td_center"><?php echo get_text($data['od_tel']); ?></td>
        <td class="td_name"><?php echo get_text($data['od_b_name']); ?></td>
        <td class="td_price"><?php echo number_format($ct['price']); ?></td>
        <td class="td_center"><?php echo $data['od_settle_case']; ?></td>
        <td class="td_time"><?php echo $row['dt_time']; ?></td>
        <td class="td_mngsmall">
            <a href="./inorderform.php?od_id=<?php echo $row['od_id']; ?>&amp;<?php echo $qstr; ?>"><span class="sound_only"><?php echo $row['od_id']; ?> </span>보기</a>
            <a href="./inorderformupdate.php?w=d&amp;od_id=<?php echo $row['od_id']; ?>&amp;<?php echo $qstr; ?>" onclick="return delete_confirm(this);"><span class="sound_only"><?php echo $row['od_id']; ?> </span>삭제</a>
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

<?php echo get_paging($config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
function finorderlist_submit(f)
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