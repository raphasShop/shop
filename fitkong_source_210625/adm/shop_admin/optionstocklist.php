<?php
$sub_menu = '400500';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$doc = strip_tags($doc);
$sort1 = strip_tags($sort1);
$sort2 = in_array($sort2, array('desc', 'asc')) ? $sort2 : 'desc'; //기본정렬은 상품코드 최근등록수
$sel_ca_id = get_search_string($sel_ca_id);
$sel_field = get_search_string($sel_field);
$search = get_search_string($search);

$g5['title'] = '상품옵션재고관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$sql_search = " where b.it_id is not NULL ";
if ($search != "") {
	if ($sel_field != "") {
    	$sql_search .= " and $sel_field like '%$search%' ";
    }
}

if ($sel_ca_id != "") {
    $sql_search .= " and b.ca_id like '$sel_ca_id%' ";
}

if ($sel_field == "")  $sel_field = "b.it_name";
if ($sort1 == "") $sort1 = "a.io_stock_qty";
if (!in_array($sort1, array('b.it_name', 'a.io_stock_qty', 'a.io_use'))) $sort1 = "a.io_stock_qty";
if ($sort2 == "") $sort2 = "asc";

$sql_common = "  from {$g5['g5_shop_item_option_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id ) ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

//$rows = $config['cf_page_rows']; //기본환경설정의 출력갯수 자동적용
$rows = 100; //출력갯수 수동적용
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select a.it_id,
                 a.io_id,
                 a.io_type,
                 a.io_stock_qty,
                 a.io_noti_qty,
                 a.io_use,
                 b.it_name,
                 b.it_option_subject
           $sql_common
          order by $sort1 $sort2
          limit $from_record, $rows ";
$result = sql_query($sql);

$qstr1 = 'sel_ca_id='.$sel_ca_id.'&amp;sel_field='.$sel_field.'&amp;search='.$search;
$qstr = $qstr1.'&amp;sort1='.$sort1.'&amp;sort2='.$sort2.'&amp;page='.$page;

// 목록 정렬 조건
$sortlist = $_SERVER['SCRIPT_NAME'].'?'.$qstr1.'&amp;sort1=';
?>

<!-- 검색창 -->
<div class="dan-schbox1" style="text-align:center;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
<form name="flist" class="big_sch01 big_sch">
<input type="hidden" name="doc" value="<?php echo $doc; ?>">
<input type="hidden" name="sort1" value="<?php echo $sort1; ?>">
<input type="hidden" name="sort2" value="<?php echo $sort2; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<label for="sel_ca_id" class="sound_only">분류선택</label>
<select name="sel_ca_id" id="sel_ca_id">
    <option value=''>전체분류</option>
    <?php
    $sql1 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} order by ca_order, ca_id ";
    $result1 = sql_query($sql1);
    for ($i=0; $row1=sql_fetch_array($result1); $i++) {
        $len = strlen($row1['ca_id']) / 2 - 1;
        $nbsp = "";
        for ($i=0; $i<$len; $i++) $nbsp .= "－";
        echo '<option value="'.$row1['ca_id'].'" '.get_selected($sel_ca_id, $row1['ca_id']).'>'.$nbsp.' '.$row1['ca_name'].'</option>'.PHP_EOL;
    }
    ?>
</select>

<label for="sel_field" class="sound_only">검색대상</label>
<select name="sel_field" id="sel_field">
    <option value="b.it_name" <?php echo get_selected($sel_field, 'b.it_name'); ?>>상품명</option>
    <option value="a.it_id" <?php echo get_selected($sel_field, 'a.it_id'); ?>>상품코드</option>
</select>

<label for="search" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="search" value="<?php echo $search; ?>" required class="frm_input_big required">
<input type="submit" value="검색" class="btn_submit_big">
<?php echo $listall; //전체보기?>

</form>
    </div><!-- } row 끝 -->
</div><!-- 검색창 -->
<!-- 검색창 끝 -->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <div class="totallist"><strong><?php echo number_format($total_count); ?></strong> 개의 옵션이 검색되었습니다</div>
    <!--@@ 우측공간 전체 감쌈 { @@-->
    <div class="sortlist">
    <!-- 상품 정렬 선택 시작 { -->
    <section id="sct_sort">
    <select id="ssch_sort" onChange="window.location.href=this.value">
        <option value="">정렬선택</option>
        <option value="<?php echo $sortlist; ?>a.io_stock_qty&amp;sort2=asc&amp;page=<?php echo $page;?>">재고 적은순</option>
        <option value="<?php echo $sortlist; ?>a.io_stock_qty&amp;sort2=desc&amp;page=<?php echo $page;?>">재고 많은순</option>
        <option value="<?php echo $sortlist; ?>b.it_id&amp;sort2=desc&amp;page=<?php echo $page;?>">상품코드 최근순</option>
        <option value="<?php echo $sortlist; ?>b.it_id&amp;sort2=asc&amp;page=<?php echo $page;?>">상품코드 과거순</option>
        <option value="<?php echo $sortlist; ?>b.it_name&amp;sort2=asc&amp;page=<?php echo $page;?>">상품명 순</option>
        <option value="<?php echo $sortlist; ?>b.it_name&amp;sort2=desc&amp;page=<?php echo $page;?>">상품명 역순</option>
        <option value="<?php echo $_SERVER['SCRIPT_NAME']; ?>">정렬초기화</option>
    </select>
    </section>
    <!-- } 상품 정렬 선택 끝 -->
    </div>
    <!--@@ } 우측공간 전체 감쌈 끝 @@-->
</div>
<!-- // -->

<form name="fitemstocklist" action="./optionstocklistupdate.php" method="post">
<input type="hidden" name="sort1" value="<?php echo $sort1; ?>">
<input type="hidden" name="sort2" value="<?php echo $sort2; ?>">
<input type="hidden" name="sel_ca_id" value="<?php echo $sel_ca_id; ?>">
<input type="hidden" name="sel_field" value="<?php echo $sel_field; ?>">
<input type="hidden" name="search" value="<?php echo $search; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">사진</th>
        <th scope="col">
            <a href="<?php echo title_sort("b.it_name") . "&amp;$qstr1"; ?>">상품명순</a>&nbsp;&nbsp;
            <a href="<?php echo title_sort("b.it_id") . "&amp;$qstr1"; ?>">상품코드순</a>
        </th>
        <th scope="col">옵션항목</th>
        <th scope="col">옵션타입</th>
        <th scope="col">주문(입금)</th>
        <th scope="col">주문(결제)</th>
        <th scope="col">주문(준비)</th>
        <th scope="col">주문(배송)</th>
        <th scope="col"><a href="<?php echo title_sort("a.io_stock_qty") . "&amp;$qstr1"; ?>">창고재고</a></th>
        <th scope="col">주문대기</th>
        <th scope="col">가재고</th>
        <th scope="col">재고수정</th>
        <th scope="col">통보수량</th>
        <th scope="col"><a href="<?php echo title_sort("a.io_use") . "&amp;$qstr1"; ?>">판매</a></th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $href = G5_SHOP_URL."/item.php?it_id={$row['it_id']}";
        $custom_io_id = '선택 :'.$row['io_id'];
        $custom_io_id2 = '선택:'.$row['io_id'];

        $sql1 = " select SUM(ct_qty) as sum_qty
                    from {$g5['g5_shop_cart_table']}
                   where it_id = '{$row['it_id']}'
                     and ct_stock_use = '0'
                     and (ct_option = '{$custom_io_id}' || ct_option = '{$custom_io_id2}' || io_id = '{$row['io_id']}')
                     and ct_status in ('주문', '입금', '준비') ";
        $row1 = sql_fetch($sql1);
        $wait_qty = $row1['sum_qty'];

        $sql2 = " select SUM(ct_qty) as sum_qty
                    from {$g5['g5_shop_cart_table']}
                   where it_id = '{$row['it_id']}'
                     and (ct_option = '{$custom_io_id}' || ct_option = '{$custom_io_id2}' || io_id = '{$row['io_id']}')
                     and ct_status in ('배송', '완료') ";
        $row2 = sql_fetch($sql2);
        $sell_qty = $row2['sum_qty'];

         $sql3 = " select SUM(ct_qty) as sum_qty
                    from {$g5['g5_shop_cart_table']}
                   where it_id = '{$row['it_id']}'
                     and (ct_option = '{$custom_io_id}' || ct_option = '{$custom_io_id2}' || io_id = '{$row['io_id']}')
                     and ct_status = '주문' ";
        $row3 = sql_fetch($sql3);
        $od_qty = $row3['sum_qty'];

        $sql4 = " select SUM(ct_qty) as sum_qty
                    from {$g5['g5_shop_cart_table']}
                   where it_id = '{$row['it_id']}'
                     and (ct_option = '{$custom_io_id}' || ct_option = '{$custom_io_id2}' || io_id = '{$row['io_id']}')
                     and ct_status = '입금' ";
        $row4 = sql_fetch($sql4);
        $pay_qty = $row4['sum_qty'];

        $sql5 = " select SUM(ct_qty) as sum_qty
                    from {$g5['g5_shop_cart_table']}
                   where it_id = '{$row['it_id']}'
                     and (ct_option = '{$custom_io_id}' || ct_option = '{$custom_io_id2}' || io_id = '{$row['io_id']}')
                     and ct_status = '준비' ";
        $row5 = sql_fetch($sql5);
        $de_wait_qty = $row5['sum_qty'];

        // 가재고 (미래재고)
        $temporary_qty = $row['io_stock_qty'] - $wait_qty;

        $option = '';
        $option_br = '';
        if($row['io_type']) {
            $opt = explode(chr(30), $row['io_id']);
            if($opt[0] && $opt[1])
                $option .= $opt[0].' : '.$opt[1];
        } else {
            $subj = explode(',', $row['it_option_subject']);
            $opt = explode(chr(30), $row['io_id']);
            for($k=0; $k<count($subj); $k++) {
                if($subj[$k] && $opt[$k]) {
                    $option .= '<span class="gray font-11">'.$option_br.$subj[$k].'</span><br><img src="./img/ftv2mlastnode.gif"> '.$opt[$k].'';
                    $option_br = '<br>';
                }
            }
        }

        $type = '<span class="darkgray">선택옵션</span>';
        if($row['io_type'])
            $type = '<span class="pink">추가옵션</span>';

        // 통보수량보다 재고수량이 작을 때
        $io_stock_qty = number_format($row['io_stock_qty']);
        $io_stock_qty_st = ''; // 스타일 정의
        if($row['io_stock_qty'] <= $row['io_noti_qty']) {
            $io_stock_qty_st = ' sit_stock_qty_alert';
            $io_stock_qty = ''.$io_stock_qty.' !<span class="sound_only"> 재고부족 </span>';
        }

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td style="width:50px;">
            <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
            <input type="hidden" name="io_id[<?php echo $i; ?>]" value="<?php echo $row['io_id']; ?>">
            <input type="hidden" name="io_type[<?php echo $i; ?>]" value="<?php echo $row['io_type']; ?>">
            <a href="<?php echo $href; ?>"><?php echo get_it_image($row['it_id'], 50, 50); ?></a>
        </td>
        <td>
            <a href="<?php echo $href; ?>"><?php echo cut_str(stripslashes($row['it_name']), 60, "&#133"); ?></a>
            <br><span class="gray font-11"><?php echo $row['it_id']; ?></span>
        </td>
        <td class="td_itopt" style="background:#FEF5B8; width:220px;"><?php echo $option; ?></td>
        <td class="td_mng" style="width:60px;"><?php echo $type; ?></td>
        <td class="td_num"><?php echo number_format($od_qty); ?></td>
        <td class="td_num"><?php echo number_format($pay_qty); ?></td>
        <td class="td_num"><?php echo number_format($de_wait_qty); ?></td>
        <td class="td_num"><?php echo number_format($sell_qty); ?></td>
        <td class="td_num<?php echo $io_stock_qty_st; ?>"><?php echo $io_stock_qty; ?></td>
        <td class="td_num"><?php echo number_format($wait_qty); ?></td>
        <td class="td_num"><?php echo number_format($temporary_qty); ?></td>
        <td class="td_num">
            <label for="stock_qty_<?php echo $i; ?>" class="sound_only">재고수정</label>
            <input type="text" name="io_stock_qty[<?php echo $i; ?>]" value="<?php echo $row['io_stock_qty']; ?>" id="stock_qty_<?php echo $i; ?>" class="frm_input" size="6" autocomplete="off">
        </td>
        <td class="td_num">
            <label for="noti_qty_<?php echo $i; ?>" class="sound_only">통보수량</label>
            <input type="text" name="io_noti_qty[<?php echo $i; ?>]" value="<?php echo $row['io_noti_qty']; ?>" id="noti_qty_<?php echo $i; ?>" class="frm_input" size="6" autocomplete="off">
        </td>
        <td class="td_chk">
            <label for="use_<?php echo $i; ?>" class="sound_only">판매</label>
            <label class="switch-check-mini">
                <input type="checkbox" name="io_use[<?php echo $i; ?>]" value="1" id="use_<?php echo $i; ?>" <?php echo ($row['io_use'] ? "checked" : ""); ?>>
                <div class="check-slider-mini round"></div>
            </label>
        </td>
        <td class="td_mngsmall"><a href="./itemform.php?w=u&amp;it_id=<?php echo $row['it_id']; ?>&amp;ca_id=<?php echo $row['ca_id']; ?>&amp;<?php echo $qstr; ?>">수정</a></td>
    </tr>
    <?php
    }
    if (!$i)
        echo '<tr><td colspan="11" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_confirm01 btn_confirm">
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

<div class="local_desc01 local_desc">
    <p>
        재고수정의 수치를 수정하시면 창고재고의 수치가 변경됩니다.<br>
        창고재고가 부족한 경우 재고수량 뒤에 <span class="sit_stock_qty_alert">!</span><span class="sound_only"> 혹은 재고부족</span>으로 표시됩니다.
    </p>
</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>