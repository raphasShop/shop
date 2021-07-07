<?php
$sub_menu = '422500'; /* 수정전 원본 메뉴코드 422500a */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$sql_common = " from {$g5['promotion_address_table']} ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and pa_name like '%$stx%' ";
}

if (!$sst) {
    $sst  = "pa_id";
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

$g5['title'] = '프로모션 URL 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$colspan = 9;

// 목록 정렬 조건 - 아이스크림
$sortlist = $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;sst=';
?>
<!-- 안내 -->
<div class="local_desc01">
    <ul>
        <li class="title1">
        프로모션 URL 관리 
        </li>
        <li class="txt1">
        프로모션/채널별 개별 URL을 생성/수정/삭제를 통해 관리할 수 있습니다. <br>
        프로모션/채널별 개별 URL을 활용하여 접속수 파악 및 구매전환율을 체크할 수 있습니다.<br>
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
    <div class="totallist"><strong><?php echo number_format($total_count) ?></strong> 개의 프로모션 URL이 검색되었습니다</div>
    
    <!--@@ 우측공간 전체 감쌈 시작 { @@-->
    <div class="sortlist">
    <!-- 정렬 선택 시작 { -->
    <section id="sct_sort">
    <select id="ssch_sort" onChange="window.location.href=this.value">
        <option value="">정렬선택</option>
        <option value="<?php echo $sortlist; ?>pa_end&amp;sod=desc">종료일 많이남은순</option>
        <option value="<?php echo $sortlist; ?>pa_end&amp;sod=asc">종료일 과거순</option>
        <option value="<?php echo $sortlist; ?>pa_start&amp;sod=desc">시작일 최근순</option>
        <option value="<?php echo $sortlist; ?>pa_start&amp;sod=asc">시작일 과거순</option>
        <option value="<?php echo $sortlist; ?>pa_hit&amp;sod=desc">조회 많은순</option>
        <option value="<?php echo $sortlist; ?>pa_hit&amp;sod=asc">조회 적은순</option>
        <option value="<?php echo $sortlist; ?>pa_pur_val&amp;sod=desc">매출 많은순</option>
        <option value="<?php echo $sortlist; ?>pa_pur_val&amp;sod=asc">매출 적은순</option>
        <option value="<?php echo $sortlist; ?>pa_name&amp;sod=asc">프로모션이름 가나다순</option>
        <option value="<?php echo $sortlist; ?>pa_id&amp;sod=desc">정렬초기화</option>
    </select>
    </section>
    <!-- } 정렬 선택 끝 -->
    </div>
    <!--@@ } 우측공간 전체 감쌈 끝 @@-->
    
</div>
<!-- // -->

<form name="paddresslist" id="fpaddresslist" method="post" action="./promotionaddlist_delete.php" onsubmit="return paddresslist_submit(this);">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="token" value="">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">프로모션 URL 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col">프로모션이름</th>
        <th scope="col">프로모션URL</th>
        <th scope="col">연결할페이지URL</th>
        <th scope="col">접속자 수</th>
        <th scope="col">접속자 수(PC)</th>
        <th scope="col">접속자 수(Mobile)</th>
        <th scope="col">매출전환 수</th>
        <th scope="col">매출전환 금액</th>
        <?php if($member['mb_id'] == 'acropass') { ?>
        <th scope="col">프로모션URL시작일</a></th>
        <th scope="col">프로모션URL종료일</a></th>
        <?php } ?>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
      
        $pa_price = number_format($row['pa_pur_val']).'원';
        $pa_purl = 'http://fitkong.co.kr/l/?c='.$row['pa_code'];
        //$pa_purl = 'http://acropass.com/l/?c='.$row['pa_code'];

        $bg = 'bg'.($i%2);
        
        // 완료,진행중 테이블색상 class 지정 - 아이스크림
        $td_color = 0;
        if($row['pa_end'] >= G5_TIME_YMD) { // 사용기한이 남았을때
            $bg .= '';
            $td_color = 1;
        } else { // 기한종료시
            $bg .= 'end';
            $td_color = 1;
        }



        $pa_id = $row['pa_id'];
        $sql0 = " select count(*) as cnt from {$g5['g5_shop_coupon_code_log_table']} where pa_id = '$pa_id' ";
        $row0 = sql_fetch($sql0);

        $pa_count = $row0['cnt'];

        $pa_code = $row['pa_code'];
        $sql1 = " select count(*) as cnt from {$g5['promotion_access_table']} where pa_code = '$pa_code' and apa_device = 'pc' ";
        $row1 = sql_fetch($sql1);

        $sql2 = " select count(*) as cnt from {$g5['promotion_access_table']} where pa_code = '$pa_code' and apa_device = 'mobile' ";
        $row2 = sql_fetch($sql2);

        $sql3 = " select count(*) as cnt from {$g5['promotion_access_table']} where pa_code = '$pa_code'";
        $row3 = sql_fetch($sql3);

        $bl_search_code = $pa_code.'%';
        $sql4 = " select * from {$g5['behavior_log_table']} where bl_desc like '$bl_search_code'";
        $rst1 = sql_query($sql4);

        $np_od_id = '';
        $np_cnt = 0;
        $np_order_sum = 0;
        for ($j=0; $row4=sql_fetch_array($rst1); $j++) {
            $np_code = $row4['bl_naver_code'];
            $sql5 = " select * from {$g5['behavior_log_table']} where bl_naver_code = '$np_code' and bl_naver_type != 'naverpayorder'";
            $row5 = sql_fetch($sql5);
            if($row5['bl_od_id'] != $np_od_id && $row5['bl_price'] != '') {
                $np_cnt++;
                $np_order_sum = $np_order_sum + $row5['bl_price'];
                $np_od_id = $row5['bl_od_id'];
            }
            
        }

        $pa_code_pc = $row1['cnt'];
        $pa_code_mobile = $row2['cnt'];
        $pa_code_all = $row3['cnt'];

        $fr_date = date('Y-m-01', G5_SERVER_TIME);
        $to_date = date('Y-m-d', G5_SERVER_TIME);
        $dayhit_url = G5_ADMIN_URL.'/shop_admin/promotiondatelist.php?fr_date='.$fr_date.'&to_date='.$to_date.'&pa_code='.$pa_code;
    ?>

    <tr class="<?php echo ' '.$bg; ?>">
    <!--<tr class="<?php// echo $bg; ?>">-->
        <td class="td_chk">
            <input type="hidden" id="pa_id_<?php echo $i; ?>" name="pa_id[<?php echo $i; ?>]" value="<?php echo $row['pa_id']; ?>">
            <input type="checkbox" id="chk_<?php echo $i; ?>" name="chk[]" value="<?php echo $i; ?>" title="내역선택">
        </td>
        <td><a href="<?php echo $dayhit_url; ?>"><?php echo get_text($row['pa_name']); ?></a></td>
        <td>
            <?php echo $pa_purl; ?></span> <a href="javascript:get_purl_copy('<?php echo $pa_purl; ?>');"><span class="btn_frmline" style="cursor: pointer;">복사</span></a>
        </td>
        <td><a href="<?php echo $row['pa_url']; ?>" target="_blank"><?php echo get_text($row['pa_url']); ?></a></td>
        <td class="td_num"><?php echo number_format($pa_code_all); ?></td>
        <td class="td_num"><?php echo number_format($pa_code_pc); ?></td>
        <td class="td_num"><?php echo number_format($pa_code_mobile); ?></td>
        <td class="td_num"><?php echo number_format($row['pa_purchase']); ?><br>(<?php echo number_format($np_cnt); ?>)</td>
        <td class="td_odrnum3"><?php echo $pa_price; ?><br>(<?php echo number_format($np_order_sum); ?>)</td>
        
        <!-- 시작일/종료일 구분 - 아이스크림 -->
        <?php if($member['mb_id'] == 'acropass') { ?>
        <td class="td_date">
        <?php if($row['pa_end'] >= G5_TIME_YMD) { //기한이남았을때?>
            <span class="violet font-bold"><?php echo $row['pa_start']; ?></span>
        <?php } else { //종료되었을때?>
            <?php echo $row['pa_start']; ?>
        <?php } //닫기?>
        </td>
        
        <!-- 종료일표시 -->
        <td class="<?php echo ($row['pa_end'] >= G5_TIME_YMD) ? 'td_date_end' : 'td_date';//기간여부?>" title="<?php echo $row['pa_end']; ?>">
        <?php if($row['pa_end'] >= G5_TIME_YMD) { //기한이남았을때?>
            <b><?php echo substr($row['pa_end'], 5, 8); ?></b> 까지
        <?php } else { //종료되었을때?>
            <?php echo $row['pa_end']; ?>
        <?php } //닫기?>
        </td>
        <!-- // -->
        <?php } ?>

        <td class="td_mngsmall">
            <a href="./promotionaddform.php?w=u&amp;pa_id=<?php echo $row['pa_id']; ?>&amp;<?php echo $qstr; ?>"><span class="sound_only"><?php echo get_text($row['pa_name']); ?> </span>수정</a>
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
    <a href="./promotionaddform.php" id="promotion_add"><i class="fas fa-plus"></i> 프로모션URL추가</a>
    </div>
</div>
<!--//-->

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
function paddresslist_submit(f)
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

function get_purl_copy(url) 
{
    var t = document.createElement("textarea");
    document.body.appendChild(t);
    t.value = url;
    t.select();
    document.execCommand('copy');
    document.body.removeChild(t);

    alert("URL이 클립보드에 복사되었습니다"); 
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>