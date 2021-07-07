<?php
$sub_menu = '411600'; /* 수정전 원본 메뉴코드 400440 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$sql_common = " from {$g5['g5_shop_personalpay_table']} ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'pp_id' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
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
    $sst  = "pp_id";
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

$g5['title'] = '개인결제 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$colspan = 10;

// 목록 정렬 조건 - 아이스크림
$sortlist = $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;sst=';
?>

<!-- 검색창 -->
<div class="dan-schbox1" style="text-align:center;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
<form name="fsearch" id="fsearch" class="big_sch01 big_sch" method="get">
    <select name="sfl" title="검색대상">
        <option value="pp_id"<?php echo get_selected($_GET['sfl'], "pp_id"); ?>>개인결제번호</option>
        <option value="pp_name"<?php echo get_selected($_GET['sfl'], "pp_name"); ?>>이름</option>
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

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <div class="totallist"><strong><?php echo number_format($total_count) ?></strong> 개의 개인결제가 검색되었습니다</div>
    
    <!--@@ 우측공간 전체 감쌈 시작 { @@-->
    <div class="sortlist">
    <!-- 정렬 선택 시작 { -->
    <section id="sct_sort">
    <select id="ssch_sort" onChange="window.location.href=this.value">
        <option value="">정렬선택</option>
        <option value="<?php echo $sortlist; ?>pp_receipt_price&amp;sod=asc">미입금을 맨위로</option>
        <option value="<?php echo $sortlist; ?>pp_receipt_time&amp;sod=desc">입금일 최근순</option>
        <option value="<?php echo $sortlist; ?>pp_receipt_time&amp;sod=asc">입금일 과거순</option>
        <option value="<?php echo $sortlist; ?>pp_settle_case&amp;sod=asc">입금방법순</option>
        <option value="<?php echo $sortlist; ?>pp_name&amp;sod=asc">결제대상자 가나다순</option>
        <option value="<?php echo $sortlist; ?>od_id&amp;sod=desc">주문번호 최근순</option>
        <option value="<?php echo $sortlist; ?>od_id&amp;sod=asc">주문번호 과거순</option>
        <option value="<?php echo $sortlist; ?>pp_id&amp;sod=desc">정렬초기화</option>
    </select>
    </section>
    <!-- } 정렬 선택 끝 -->
    </div>
    <!--@@ } 우측공간 전체 감쌈 끝 @@-->
    
</div>
<!-- // -->

<form name="fpersonalpaylist" id="fpersonalpaylist" method="post" action="./personalpaylistdelete.php" onsubmit="return fpersonalpaylist_submit(this);">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="token" value="">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">개인결제 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col">결제대상자</th>
        <th scope="col"><?php echo subject_sort_link('od_id') ?>주문번호</a></th>
        <th scope="col">주문금액</th>
        <th scope="col">입금금액</th>
        <th scope="col">미수금액</th>
        <th scope="col">입금방법</a></th>
        <th scope="col"><?php echo subject_sort_link('pp_receipt_time') ?>입금일</a></a></th>
        <th scope="col">사용</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        if($row['od_id'])
            $od_id = '<a href="./orderform.php?od_id='.$row['od_id'].'" target="_blank">'.$row['od_id'].'</a>';
        else
            $od_id = '&nbsp;';

        $bg = 'bg'.($i%2);
		
		// 확인,미확인 테이블색상 class 지정 - 아이스크림
		$td_color = 0;
        if($row['pp_price'] == $row['pp_receipt_price']) { // 주문금액과 입금금액이 동일할때
            $bg .= 'end';
            $td_color = 1;
		} else { // 다를떄
		    $bg .= '';
            $td_color = 1;
		}
    ?>
    <tr class="<?php echo ' '.$bg; ?>">
    <!--<tr class="<?php// echo $bg; ?>">-->
        <td class="td_chk">
            <input type="hidden" id="pp_id_<?php echo $i; ?>" name="pp_id[<?php echo $i; ?>]" value="<?php echo $row['pp_id']; ?>">
            <input type="checkbox" id="chk_<?php echo $i; ?>" name="chk[]" value="<?php echo $i; ?>" title="내역선택">
        </td>
        <td><?php echo $row['pp_name']; ?></td>
        <td class="td_odrnum3"><?php echo $od_id; ?></td>
        <td class="td_numsum"><?php echo number_format($row['pp_price']); ?></td>
        <td class="td_numincome"><?php echo number_format($row['pp_receipt_price']); ?></td>
        <!-- 미수금이 있을떄 라운드표시 - 아이스크림 -->
        <td class="td_numincome">
        <?php if($row['pp_price'] - $row['pp_receipt_price'] > 0) { //미수금있을때?>
        <span class="price_round"><?php echo number_format($row['pp_price'] - $row['pp_receipt_price']); ?></span>
        <?php } else { //미수금0원?>
        <span class="lightviolet">결제완료</span>
        <?php } ?>
        </td>
        <!--//-->
        <td class="td_payby"><?php echo $row['pp_settle_case']; ?></td>
        <td class="td_date"><?php echo is_null_time($row['pp_receipt_time']) ? '' : substr($row['pp_receipt_time'], 0, 16); ?></td>
        <td class="td_boolean"><?php echo $row['pp_use'] ? '예' : '아니오'; ?></td>
        <td class="td_mngsmall">
            <a href="./personalpayform.php?w=u&amp;pp_id=<?php echo $row['pp_id']; ?>&amp;<?php echo $qstr; ?>"><span class="sound_only"><?php echo $row['pp_id']; ?> </span>수정</a>
            <a href="./personalpaycopy.php?pp_id=<?php echo $row['pp_id']; ?>" class="personalpaycopy"><span class="sound_only"><?php echo $row['pp_id']; ?> </span>복사</a>
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
    
    <?php if ($is_admin == 'super') { ?>
    <div class="bq_basic_add">
    <a href="./personalpayform.php" id="personalpay_add"><i class="fas fa-plus"></i> 개인결제추가</a>
    </div>
    <?php } ?>
</div>
<!--//-->

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
$(function() {
    $(".personalpaycopy").on("click", function() {
        var href = this.href;
        window.open(href, "copywin", "left=100, top=100, width=600, height=300, scrollbars=0");
        return false;
    });
});

function fpersonalpaylist_submit(f)
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