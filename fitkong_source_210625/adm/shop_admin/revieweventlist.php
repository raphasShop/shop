<?php
$sub_menu = '422400'; /* 수정전 원본 메뉴코드 400810 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$sql_common = " from {$g5['g5_shop_review_event_table']} ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and re_subject like '%$stx%' ";
}

if (!$sst) {
    $sst  = "re_id";
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

$g5['title'] = '리뷰혜택관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$colspan = 9;

// 목록 정렬 조건
$sortlist = $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;sst=';
?>
<!-- 안내 -->
<div class="local_desc01">
    <ul>
        <li class="title1">
        리뷰 햬택(쿠폰/포인트)
        </li>
        <li class="txt1">
        리뷰혜택 상품 구매자가 리뷰를 입력 시, 기존 설정된 포인트 혜택과 상관없이 설정된 쿠폰발급 및 포인트 혜택을 제공할 수 있습니다.<br>
        이벤트/프로모션 용도로 쿠폰/포인트를 발급하여 마케팅으로 활용할 수 있습니다<br>
        </li>
    </ul>
</div>
<!-- // -->

<!-- 검색창 -->
<div class="dan-schbox1" style="text-align:center;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
<form name="fsearch" id="fsearch" class="big_sch01 big_sch" method="get">
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
    <div class="totallist"><strong><?php echo number_format($total_count) ?></strong> 개의 리뷰혜택상품이 검색되었습니다</div>
    
    <!--@@ 우측공간 전체 감쌈 시작 { @@-->
    <div class="sortlist">
    <!-- 정렬 선택 시작 { -->
    <section id="sct_sort">
    <select id="ssch_sort" onChange="window.location.href=this.value">
        <option value="">정렬선택</option>
        <option value="<?php echo $sortlist; ?>re_end&amp;sod=desc">종료일 많이남은순</option>
        <option value="<?php echo $sortlist; ?>re_end&amp;sod=asc">종료일 과거순</option>
        <option value="<?php echo $sortlist; ?>re_start&amp;sod=desc">시작일 최근순</option>
        <option value="<?php echo $sortlist; ?>re_start&amp;sod=asc">시작일 과거순</option>
        <option value="<?php echo $sortlist; ?>re_subject&amp;sod=asc">리뷰혜택이름 가나다순</option>
        <option value="<?php echo $sortlist; ?>re_id&amp;sod=desc">정렬초기화</option>
    </select>
    </section>
    <!-- } 정렬 선택 끝 -->
    </div>
    <!--@@ } 우측공간 전체 감쌈 끝 @@-->
    
</div>
<!-- // -->

<form name="reventlist" id="reventlist" method="post" action="./revieweventlist_delete.php" onsubmit="return reventlist_submit(this);">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="token" value="">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <thead>
    <tr>
        <th scope="col" rowspan="2">
            <label for="chkall" class="sound_only">쿠폰 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col" rowspan="2">리뷰혜택이름</th>
        <th scope="col" rowspan="2">적용상품</th>
        <th scope="col" rowspan="2">혜택유형</th>
        <th scope="col">시작일</th>
        <th scope="col">포인트(일반)</th>
        <th scope="col">쿠폰이름(일반)</th>
        <th scope="col">적용대상(일반)</a></th>
        <th scope="col">쿠폰금액(일반)</a></th>
        <th scope="col">쿠폰시작일(일반)</a></th>
        <th scope="col">쿠폰종료일(일반)</a></th>
        <th scope="col" rowspan="2">관리</th>
    </tr>
    <tr>
        <th scope="col">종료일</th>
        <th scope="col">포인트(포토)</th>
        <th scope="col">쿠폰이름(포토)</th>
        <th scope="col">적용대상(포토)</th>
        <th scope="col">쿠폰금액(포토)</th>
        <th scope="col">쿠폰시작일(포토)</a></th>
        <th scope="col">쿠폰종료일(포토)</a></th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        switch($row['re_type']) {
            case '1':
                $re_type = '포인트';
                break;
            default:
                $re_type = '쿠폰';
                break;
        }

        $sql3 = " select it_name from {$g5['g5_shop_item_table']} where it_id = '{$row['it_id']}' ";
        $row3 = sql_fetch($sql3);
        $it_name = get_text($row3['it_name']);

        switch($row['pr_cp_method']) {
            case '0':
                $sql3 = " select it_name from {$g5['g5_shop_item_table']} where it_id = '{$row['pr_cp_target']}' ";
                $row3 = sql_fetch($sql3);
                $pr_cp_method = '개별상품할인';
                $pr_cp_target = get_text($row3['it_name']);
                break;
            case '1':
                $sql3 = " select ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$row['pr_cp_target']}' ";
                $row3 = sql_fetch($sql3);
                $pr_cp_method = '카테고리할인';
                $pr_cp_target = get_text($row3['ca_name']);
                break;
            case '2':
                $pr_cp_method = '주문금액할인';
                $pr_cp_target = '주문금액';
                break;
            case '3':
                $pr_cp_method = '배송비할인';
                $pr_cp_target = '배송비';
                break;
        }

        switch($row['br_cp_method']) {
            case '0':
                $sql3 = " select it_name from {$g5['g5_shop_item_table']} where it_id = '{$row['br_cp_target']}' ";
                $row3 = sql_fetch($sql3);
                $br_cp_method = '개별상품할인';
                $br_cp_target = get_text($row3['it_name']);
                break;
            case '1':
                $sql3 = " select ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$row['br_cp_target']}' ";
                $row3 = sql_fetch($sql3);
                $br_cp_method = '카테고리할인';
                $br_cp_target = get_text($row3['ca_name']);
                break;
            case '2':
                $br_cp_method = '주문금액할인';
                $br_cp_target = '주문금액';
                break;
            case '3':
                $br_cp_method = '배송비할인';
                $br_cp_target = '배송비';
                break;
        }

        if($row['pr_cp_type'])
            $pr_cp_price = $row['pr_cp_price'].'%';
        else
            $pr_cp_price = number_format($row['pr_cp_price']).'원';

         if($row['br_cp_type'])
            $br_cp_price = $row['br_cp_price'].'%';
        else
            $br_cp_price = number_format($row['br_cp_price']).'원';

        $bg = 'bg'.($i%2);
        
        // 완료,진행중 테이블색상 class 지정 
        $td_color = 0;
        if($row['re_end'] >= G5_TIME_YMD) { // 사용기한이 남았을때
            $bg .= '';
            $td_color = 1;
        } else { // 기한종료시
            $bg .= 'end';
            $td_color = 1;
        }

        $re_id = $row['re_id'];
        //$sql0 = " select count(*) as cnt from {$g5['g5_shop_coupon_code_log_table']} where cz_id = '$cz_id' ";
        //$row0 = sql_fetch($sql0);

        //$cz_count = $row0['cnt'];
    ?>

    <tr class="<?php echo ' '.$bg; ?>">
    <!--<tr class="<?php// echo $bg; ?>">-->
        <td class="td_chk" rowspan="2">
            <input type="hidden" id="re_id_<?php echo $i; ?>" name="re_id[<?php echo $i; ?>]" value="<?php echo $row['re_id']; ?>">
            <input type="checkbox" id="chk_<?php echo $i; ?>" name="chk[]" value="<?php echo $i; ?>" title="내역선택">
        </td>
        <td rowspan="2"><?php echo get_text($row['re_subject']); ?></td>
        <td rowspan="2"><?php echo get_text($it_name); ?></td>
        <td rowspan="2"><?php echo get_text($re_type); ?></td>
        <!-- 시작일/종료일 구분  -->
        <td class="td_date">
        <?php if($row['re_end'] >= G5_TIME_YMD) { ?>
            <span class="violet font-bold"><?php echo $row['re_start']; ?></span>
        <?php } else { //종료되었을때?>
            <?php echo $row['re_start']; ?>
        <?php } //닫기?>
        </td>
        <td class="td_num"><?php echo number_format($row['br_point']); ?></td>
        <td><?php echo get_text($row['br_cp_subject']); ?></td>
        <td class="td_mng darkgray">
        <!-- 쿠폰대상 상품보기 링크 -->
        <?php if($row['br_cp_method'] == '0') { //개별상품일때?>
            <button type="button" class="btn btn-skyblue btn-sm font-11" onclick="window.open('<?php echo G5_SHOP_URL; ?>/item.php?it_id=<?php echo $row['br_cp_target'];//개별상품?>')">상품보기</button><br>
        <?php } else if($row['br_cp_method'] == '1') { //개별상품일때?>
            <button type="button" class="btn btn-skyblue btn-sm font-11" onclick="window.open('<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $row['br_cp_target'];//카테고리?>')">상품보기</button><br>
        <?php } //닫기?>
        <!--//-->
        <?php echo $br_cp_target; ?>
        </td>
        <td><?php echo get_text($br_cp_price); ?></td>
        <td class="td_date"><?php echo $row['br_cp_start']; ?></td>
        <td class="td_date"><?php echo $row['br_cp_end']; ?></td>
        <td class="td_mngsmall" rowspan="2">
            <a href="./revieweventform.php?w=u&amp;re_id=<?php echo $row['re_id']; ?>&amp;<?php echo $qstr; ?>"><span class="sound_only"><?php echo get_text($row['re_subject']); ?> </span>수정</a>
        </td>
    </tr>

    <tr class="<?php echo ' '.$bg; ?>">
        <td class="td_date">
        <?php if($row['re_end'] >= G5_TIME_YMD) { //기한이남았을때?>
            <span class="violet font-bold"><?php echo $row['re_end']; ?></span>
        <?php } else { //종료되었을때?>
            <?php echo $row['re_end']; ?>
        <?php } //닫기?>
        </td>
        <td class="td_num"><?php echo number_format($row['pr_point']); ?></td>
        <td><?php echo get_text($row['pr_cp_subject']); ?></td>
        <td class="td_mng darkgray">
        <!-- 쿠폰대상 상품보기 링크 -->
        <?php if($row['pr_cp_method'] == '0') { //개별상품일때?>
            <button type="button" class="btn btn-skyblue btn-sm font-11" onclick="window.open('<?php echo G5_SHOP_URL; ?>/item.php?it_id=<?php echo $row['pr_cp_target'];//개별상품?>')">상품보기</button><br>
        <?php } else if($row['pr_cp_method'] == '1') { //개별상품일때?>
            <button type="button" class="btn btn-skyblue btn-sm font-11" onclick="window.open('<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $row['pr_cp_target'];//카테고리?>')">상품보기</button><br>
        <?php } //닫기?>
        <!--//-->
        <?php echo $br_cp_target; ?>
        </td>
        <td><?php echo get_text($pr_cp_price); ?></td>
        <td class="td_date"><?php echo $row['pr_cp_start']; ?></td>
        <td class="td_date"><?php echo $row['pr_cp_end']; ?></td>
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
    <a href="./revieweventform.php" id="coupon_add"><i class="fas fa-plus"></i> 리뷰혜택추가</a>
    </div>
</div>
<!--//-->

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
function reventlist_submit(f)
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