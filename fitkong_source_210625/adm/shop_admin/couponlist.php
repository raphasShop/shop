<?php
$sub_menu = '422800'; /* 수정전 원본 메뉴코드 400800 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$sql_common = " from {$g5['g5_shop_coupon_table']} ";

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
    $sst  = "cp_no";
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

$g5['title'] = '쿠폰관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$colspan = 9;

// 목록 정렬 조건 - 아이스크림
$sortlist = $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;sst=';
?>
<!-- 안내 -->
<div class="local_desc01">
    <ul>
        <li class="title1">
        발행과 동시에 상품 및 기타할인(배송/주문할인)에 자동 적용되는 쿠폰
        </li>
        <li class="txt1">
        쿠폰등록과 동시에 상품목록/상품상세페이지에 표시되며, 별도 다운로드없이 주문시 쿠폰을 선택/적용 가능합니다<br />
        내쿠폰관리에서도 쿠폰을 확인할 수 있습니다
        </li>
    </ul>
</div>
<!-- // -->

<!-- 검색창 -->
<div class="dan-schbox1" style="text-align:center;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
<form name="fsearch" id="fsearch" class="big_sch01 big_sch" method="get">
<select name="sfl" title="검색대상">
    <option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id"); ?>>회원아이디</option>
    <option value="cp_subject"<?php echo get_selected($_GET['sfl'], "cp_subject"); ?>>쿠폰이름</option>
    <option value="cp_id"<?php echo get_selected($_GET['sfl'], "cp_id"); ?>>쿠폰코드</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input_big">
<input type="submit" value="검색" class="btn_submit_big">
<?php echo $listall; //전체보기?>

</form>
    </div><!-- } row 끝 -->
</div><!-- 검색창 -->
<!-- 검색창 끝 -->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <div class="totallist"><strong><?php echo number_format($total_count) ?></strong> 개의 쿠폰이 검색되었습니다.</div>
    
    <!--@@ 우측공간 전체 감쌈 시작 { @@-->
    <div class="sortlist">
    <!-- 정렬 선택 시작 { -->
    <section id="sct_sort">
    <select id="ssch_sort" onChange="window.location.href=this.value">
        <option value="">정렬선택</option>
        <option value="<?php echo $sortlist; ?>cp_end&amp;sod=desc">종료일 많이남은순</option>
        <option value="<?php echo $sortlist; ?>cp_end&amp;sod=asc">종료일 과거순</option>
        <option value="<?php echo $sortlist; ?>cp_start&amp;sod=desc">시작일 최근순</option>
        <option value="<?php echo $sortlist; ?>cp_start&amp;sod=asc">시작일 과거순</option>
        <option value="<?php echo $sortlist; ?>cp_subject&amp;sod=asc">쿠폰이름 가나다순</option>
        <option value="<?php echo $sortlist; ?>cp_no&amp;sod=desc">정렬초기화</option>
    </select>
    </section>
    <!-- } 정렬 선택 끝 -->
    </div>
    <!--@@ } 우측공간 전체 감쌈 끝 @@-->
    
</div>
<!-- // -->

<form name="fcouponlist" id="fcouponlist" method="post" action="./couponlist_delete.php" onsubmit="return fcouponlist_submit(this);">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="token" value="">

<div class="tbl_head02 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">쿠폰 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col">쿠폰종류</th>
        <th scope="col">쿠폰코드</th>
        <th scope="col">쿠폰이름</th>
        <th scope="col">적용대상</th>
        <th scope="col"><?php echo subject_sort_link('mb_id') ?>회원아이디</a></th>
        <th scope="col"><?php echo subject_sort_link('cp_start') ?>시작일</a></th>
        <th scope="col"><?php echo subject_sort_link('cp_end') ?>종료일</a></th>
        <th scope="col">사용회수</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        switch($row['cp_method']) {
            case '0':
                $sql3 = " select it_name from {$g5['g5_shop_item_table']} where it_id = '{$row['cp_target']}' ";
                $row3 = sql_fetch($sql3);
                $cp_method = '개별상품할인';
                $cp_target = get_text($row3['it_name']);
                break;
            case '1':
                $sql3 = " select ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$row['cp_target']}' ";
                $row3 = sql_fetch($sql3);
                $cp_method = '카테고리할인';
                $cp_target = get_text($row3['ca_name']);
                break;
            case '2':
                $cp_method = '주문금액할인';
                $cp_target = '주문금액';
                break;
            case '3':
                $cp_method = '배송비할인';
                $cp_target = '배송비';
                break;
        }

        $link1 = '<a href="./orderform.php?od_id='.$row['od_id'].'">';
        $link2 = '</a>';

        // 쿠폰사용회수
        $sql = " select count(*) as cnt from {$g5['g5_shop_coupon_log_table']} where cp_id = '{$row['cp_id']}' ";
        $tmp = sql_fetch($sql);
        $used_count = $tmp['cnt'];

        $bg = 'bg'.($i%2);
		
		// 완료,진행중 테이블색상 class 지정 - 아이스크림
		$td_color = 0;
        if($row['cp_end'] >= G5_TIME_YMD) { // 사용기한이 남았을때
            $bg .= '';
            $td_color = 1;
		} else { // 기한종료시
		    $bg .= 'end';
            $td_color = 1;
		}
    ?>

    <tr class="<?php echo ' '.$bg; ?>">
    <!--<tr class="<?php// echo $bg; ?>">-->
        <td class="td_chk">
            <input type="hidden" id="cp_id_<?php echo $i; ?>" name="cp_id[<?php echo $i; ?>]" value="<?php echo $row['cp_id']; ?>">
            <input type="checkbox" id="chk_<?php echo $i; ?>" name="chk[]" value="<?php echo $i; ?>" title="내역선택">
        </td>
        <td><?php echo $cp_method; ?></td>
        <td><?php echo $row['cp_id']; ?></td>
        <td><?php echo $row['cp_subject']; ?></td>
        <td class="td_mng">
        <!-- 쿠폰대상 상품보기 링크 -->
        <?php if($row['cp_method'] == '0') { //개별상품일때?>
            <button type="button" class="btn btn-skyblue btn-xs font-11" onclick="window.open('<?php echo G5_SHOP_URL; ?>/item.php?it_id=<?php echo $row['cp_target'];//개별상품?>')">상품보기</button><br>
        <?php } else if($row['cp_method'] == '1') { //개별상품일때?>
            <button type="button" class="btn btn-skyblue btn-xs font-11" onclick="window.open('<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $row['cp_target'];//카테고리?>')">상품보기</button><br>
        <?php } //닫기?>
        <!--//-->
		<span class="font-11 darkgray"><?php echo $cp_target; ?></span>
        </td>
        <td class="td_name sv_use"><div><?php echo $row['mb_id']; ?></div></td>
        <!-- 시작일/종료일 구분 - 아이스크림 -->
        <td class="td_date">
        <?php if($row['cp_end'] >= G5_TIME_YMD) { //기한이남았을때?>
		    <span class="violet font-bold"><?php echo $row['cp_start']; ?></span>
		<?php } else { //종료되었을때?>
		    <?php echo $row['cp_start']; ?>
		<?php } //닫기?>
        </td>
        <!-- 종료일표시 -->
        <td class="<?php echo ($row['cp_end'] >= G5_TIME_YMD) ? 'td_date_end' : 'td_date';//기간여부?>" title="<?php echo $row['cp_end']; ?>">
		<?php if($row['cp_end'] >= G5_TIME_YMD) { //기한이남았을때?>
		    <b><?php echo substr($row['cp_end'], 5, 8); ?></b> 까지
		<?php } else { //종료되었을때?>
		    <?php echo $row['cp_end']; ?>
		<?php } //닫기?>
        </td>
        <!-- // -->
        <td class="td_cntsmall"><?php echo number_format($used_count); ?></td>
        <td class="td_mngsmall">
            <a href="./couponform.php?w=u&amp;cp_id=<?php echo $row['cp_id']; ?>&amp;<?php echo $qstr; ?>"><span class="sound_only"><?php echo $row['cp_id']; ?> </span>수정</a>
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
    
    <div class="bq_basic_add">
    <a href="./couponform.php" id="coupon_add"><i class="fas fa-plus"></i> 쿠폰추가</a>
    </div>
</div>
<!--//-->

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
function fcouponlist_submit(f)
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