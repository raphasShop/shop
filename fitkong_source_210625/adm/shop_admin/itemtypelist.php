<?php
$sub_menu = '400610';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$doc = strip_tags($doc);

$g5['title'] = '상품유형관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

/*
$sql_search = " where 1 ";
if ($search != "") {
	if ($sel_field != "") {
    	$sql_search .= " and $sel_field like '%$search%' ";
    }
}

if ($sel_ca_id != "") {
    $sql_search .= " and (ca_id like '$sel_ca_id%' or ca_id2 like '$sel_ca_id%' or ca_id3 like '$sel_ca_id%') ";
}

if ($sel_field == "")  $sel_field = "it_name";
*/

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
    $sql_search .= " $where (ca_id like '$sca%' or ca_id2 like '$sca%' or ca_id3 like '$sca%') ";
}

if ($sfl == "")  $sfl = "it_name";

if (!$sst)  {
    $sst  = "it_id";
    $sod = "desc";
}
$sql_order = "order by $sst $sod";

$sql_common = "  from {$g5['g5_shop_item_table']} ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

//$rows = $config['cf_page_rows'];
$rows = 100; //출력갯수 수동적용
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select it_id,
                 it_name,
                 it_type1,
                 it_type2,
                 it_type3,
                 it_type4,
                 it_type5
          $sql_common
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page.'&amp;save_stx='.$stx;

// 목록 정렬 조건
$sortlist = $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;sst=';
?>

<!-- 검색창 -->
<div class="dan-schbox1" style="text-align:center;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
<form name="flist" class="big_sch01 big_sch">
<input type="hidden" name="doc" value="<?php echo $doc; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<label for="sca" class="sound_only">분류선택</label>
<select name="sca" id="sca">
    <option value="">전체분류</option>
    <?php
    $sql1 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} order by ca_order, ca_id ";
    $result1 = sql_query($sql1);
    for ($i=0; $row1=sql_fetch_array($result1); $i++) {
        $len = strlen($row1['ca_id']) / 2 - 1;
        $nbsp = "";
        for ($i=0; $i<$len; $i++) $nbsp .= "－";
        echo '<option value="'.$row1['ca_id'].'" '.get_selected($sca, $row1['ca_id']).'>'.$nbsp.' '.$row1['ca_name'].PHP_EOL;
    }
    ?>
</select>

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="it_name" <?php echo get_selected($sfl, 'it_name'); ?>>상품명</option>
    <option value="it_id" <?php echo get_selected($sfl, 'it_id'); ?>>상품코드</option>
</select>

<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" required class="frm_input_big required">
<input type="submit" value="검색" class="btn_submit_big">
<?php echo $listall; //전체보기?>

</form>
    </div><!-- } row 끝 -->
</div><!-- 검색창 -->
<!-- 검색창 끝 -->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <div class="totallist"><strong><?php echo number_format($total_count); ?></strong> 개의 상품이 검색되었습니다</div>
    <!--@@ 우측공간 전체 감쌈 { @@-->
    <div class="sortlist">
    <!-- 상품 정렬 선택 시작 { -->
    <section id="sct_sort">
    <select id="ssch_sort" onChange="window.location.href=this.value">
        <option value="">정렬선택</option>
        <option value="<?php echo $sortlist; ?>it_id&amp;sod=desc">상품코드 최근순</option>
        <option value="<?php echo $sortlist; ?>it_id&amp;sod=asc">상품코드 과거순</option>
        <option value="<?php echo $sortlist; ?>it_name&amp;sod=asc">상품명 순</option>
        <option value="<?php echo $sortlist; ?>it_name&amp;sod=desc">상품명 역순</option>
        <option value="<?php echo $_SERVER['SCRIPT_NAME']; ?>">정렬초기화</option>
    </select>
    </section>
    <!-- } 상품 정렬 선택 끝 -->
    </div>
    <!--@@ } 우측공간 전체 감쌈 끝 @@-->
</div>
<!-- // -->

<form name="fitemtypelist" method="post" action="./itemtypelistupdate.php">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col"><?php echo subject_sort_link("it_id", $qstr, 1); ?>상품코드</a></th>
        <th scope="col" colspan="2"><?php echo subject_sort_link("it_name"); ?>상품명</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type1", $qstr, 1); ?>추천<br>상품</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type2", $qstr, 1); ?>MD's<br>Pick</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type3", $qstr, 1); ?>신규<br>상품</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type4", $qstr, 1); ?>베스트<br>셀러</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type5", $qstr, 1); ?>할인<br>상품</a></th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i=0; $row=sql_fetch_array($result); $i++) {
        $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_code">
            <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
            <?php echo $row['it_id']; ?>
        </td>
        <td style="width:50px;"><?php echo get_it_image($row['it_id'], 50, 50); ?></td>
        <td><a href="<?php echo $href; ?>"><?php echo cut_str(stripslashes($row['it_name']), 60, "&#133"); ?></a></td>
        <td class="td_chk">
            <label for="type1_<?php echo $i; ?>" class="sound_only">히트상품</label>
            <label class="switch-check-mini">
                <input type="checkbox" name="it_type1[<?php echo $i; ?>]" value="1" id="type1_<?php echo $i; ?>" <?php echo ($row['it_type1'] ? 'checked' : ''); ?>>
                <div class="check-slider-mini round"></div>
            </label>
        </td>
        <td class="td_chk">
            <label for="type2_<?php echo $i; ?>" class="sound_only">추천상품</label>
            <label class="switch-check-mini">
                <input type="checkbox" name="it_type2[<?php echo $i; ?>]" value="1" id="type2_<?php echo $i; ?>" <?php echo ($row['it_type2'] ? 'checked' : ''); ?>>
                <div class="check-slider-mini round"></div>
            </label>
        </td>
        <td class="td_chk">
            <label for="type3_<?php echo $i; ?>" class="sound_only">신규상품</label>
            <label class="switch-check-mini">
                <input type="checkbox" name="it_type3[<?php echo $i; ?>]" value="1" id="type3_<?php echo $i; ?>" <?php echo ($row['it_type3'] ? 'checked' : ''); ?>>
                <div class="check-slider-mini round"></div>
            </label>
        </td>
        <td class="td_chk">
            <label for="type4_<?php echo $i; ?>" class="sound_only">인기상품</label>
            <label class="switch-check-mini">
                <input type="checkbox" name="it_type4[<?php echo $i; ?>]" value="1" id="type4_<?php echo $i; ?>" <?php echo ($row['it_type4'] ? 'checked' : ''); ?>>
                <div class="check-slider-mini round"></div>
            </label>
        </td>
        <td class="td_chk">
            <label for="type5_<?php echo $i; ?>" class="sound_only">할인상품</label>
            <label class="switch-check-mini">
                <input type="checkbox" name="it_type5[<?php echo $i; ?>]" value="1" id="type5_<?php echo $i; ?>" <?php echo ($row['it_type5'] ? 'checked' : ''); ?>>
                <div class="check-slider-mini round"></div>
            </label>
        </td>
        <td class="td_mngsmall">
            <a href="./itemform.php?w=u&amp;it_id=<?php echo $row['it_id']; ?>&amp;ca_id=<?php echo $row['ca_id']; ?>&amp;<?php echo $qstr; ?>"><span class="sound_only"><?php echo cut_str(stripslashes($row['it_name']), 60, "&#133"); ?> </span>수정</a>
         </td>
    </tr>
    <?php
    }

    if (!$i)
        echo '<tr><td colspan="9" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_confirm03 btn_confirm">
    <input type="submit" value="일괄수정" class="btn_submit">
</div>

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">
    <div class="bq_basic">
    <input type="submit" value="일괄수정">
    </div>
</div>
<!--//-->

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>