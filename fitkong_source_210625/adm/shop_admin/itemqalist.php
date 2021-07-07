<?php
$sub_menu = '455660'; /* 수정전 원본 메뉴코드 400660 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '상품문의';
include_once (G5_ADMIN_PATH.'/admin.head.php');

// wetoz : naverpayorder
if ($default['de_naverpayorder_AccessLicense'] && $default['de_naverpayorder_SecretKey']) {
    include_once(G5_PLUGIN_PATH.'/wznaverpay/config.php');
    $aor = new NHNAPIORDER();
    $aor->IsAnswered = 'full'; // true, false, full
    $aor->customersync_rotation('GetCustomerInquiryList');
}
// wetoz : naverpayorder

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
    $sst = "iq_id";
    $sod = "desc";
}

$sql_common = "  from {$g5['g5_shop_item_qa_table']} a
                 left join {$g5['g5_shop_item_table']} b on (a.it_id = b.it_id)
                 left join {$g5['member_table']} c on (a.mb_id = c.mb_id) ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select *
          $sql_common
          order by $sst $sod, iq_id desc
          limit $from_record, $rows ";
$result = sql_query($sql);

//$qstr = 'page='.$page.'&amp;sst='.$sst.'&amp;sod='.$sod.'&amp;stx='.$stx;
$qstr .= ($qstr ? '&amp;' : '').'sca='.$sca.'&amp;save_stx='.$stx;

// 목록 정렬 조건 - 아이스크림
$sortlist = $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;sst=';
?>
<!-- 검색창 -->
<div class="dan-schbox1" style="text-align:center;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
<form name="flist" class="big_sch01 big_sch">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">

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
        $selected = ($row1['ca_id'] == $sca) ? ' selected="selected"' : '';
        echo '<option value="'.$row1['ca_id'].'"'.$selected.'>'.$nbsp.' '.$row1['ca_name'].'</option>'.PHP_EOL;
    }
    ?>
</select>

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="it_name" <?php echo get_selected($sfl, 'it_name'); ?>>상품명</option>
    <option value="a.it_id" <?php echo get_selected($sfl, 'a.it_id'); ?>>상품코드</option>
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
    <div class="totallist"><strong><?php echo number_format($total_count); ?></strong> 개의 상품문의가 검색되었습니다</div>

    <!--@@ 우측공간 전체 감쌈 시작 { @@-->
    <div class="sortlist">
    <!-- 정렬 선택 시작 { -->
    <section id="sct_sort">
    <select id="ssch_sort" onChange="window.location.href=this.value">
        <option value="">정렬선택</option>
        <option value="<?php echo $sortlist; ?>iq_answer&amp;sod=asc">답변없는것을 맨위로</option>
        <option value="<?php echo $sortlist; ?>iq_time&amp;sod=desc">질문등록일 최근순</option>
        <option value="<?php echo $sortlist; ?>iq_time&amp;sod=asc">질문등록일 과거순</option>
        <option value="<?php echo $sortlist; ?>a.it_id&amp;sod=desc">상품코드 최근순</option>
        <option value="<?php echo $sortlist; ?>a.it_id&amp;sod=asc">상품코드 과거순</option>
        <option value="<?php echo $sortlist; ?>it_name&amp;sod=asc">상품명 가나다순</option>
        <option value="<?php echo $sortlist; ?>iq_id&amp;sod=desc">정렬초기화</option>
    </select>
    </section>
    <!-- } 정렬 선택 끝 -->
    </div>
    <!--@@ } 우측공간 전체 감쌈 끝 @@-->

</div>
<!-- // -->

<form name="fitemqalist" method="post" action="./itemqalistupdate.php" onsubmit="return fitemqalist_submit(this);" autocomplete="off">
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
        <th scope="col">
            <label for="chkall" class="sound_only">상품문의 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col" colspan="2"><?php echo subject_sort_link('it_name'); ?>상품명</a></th>
        <th scope="col"><?php echo subject_sort_link('iq_subject'); ?>질문 / 답변</a></th>
        <th scope="col"><?php echo subject_sort_link('mb_name'); ?>이름</a></th>
        <th scope="col"><?php echo subject_sort_link('iq_time'); ?>질문</a></th>
        <th scope="col"><?php echo subject_sort_link('iq_timeanswer'); ?>답변</a></th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $row['iq_subject'] = cut_str($row['iq_subject'], 30, "...");
        $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
        $name = get_sideview($row['mb_id'], get_text($row['iq_name']), $row['mb_email'], $row['mb_homepage']);
		$time = '<span class="gray font-11">'.substr($row['iq_time'],0,4).'</span><br><span class="lightviolet font-13">'.substr($row['iq_time'],5,6).'</span><br><span class="lightviolet font-11">'.substr($row['iq_time'],11,8);//질문등록일시
		$timeanswer = '<span class="gray font-11">'.substr($row['iq_timeanswer'],0,4).'</span><br><span class="violet font-13">'.substr($row['iq_timeanswer'],5,6).'</span><br><span class="lightviolet font-11">'.substr($row['iq_timeanswer'],11,8);//답변등록일시
        $answer = $row['iq_answer'] ? '<span class="darkgray font-11">'.$timeanswer.'</span>' : '<a href="./itemqaform.php?w=u&amp;iq_id='.$row['iq_id'].'&amp;'.$qstr.'"><span class="orangered font-11">답변대기</span></a>';
        $iq_question = get_view_thumbnail(conv_content($row['iq_question'], 1), 300);

		$iq_answer = $row['iq_answer'] ? '<img src="'.G5_ADMIN_URL.'/shop_admin/img/left-plus.gif"> <span class="blue">[답변]</span> <span class="darkgray font-11">'.$row['iq_timeanswer'].'</span>'.get_view_thumbnail(conv_content($row['iq_answer'], 1), 300) : '<img src="'.G5_ADMIN_URL.'/shop_admin/img/left-minus.gif"> <span class=orangered>답변이 등록되지 않았습니다</span>';

        $bg = 'bg'.($i%2);

        // 완료,진행중 테이블색상 class 지정 - 아이스크림
		$td_color = 0;
        if($row['iq_answer']) { // 답변완료
            $bg .= 'end';
            $td_color = 1;
		} else { // 답변없음
		    $bg .= '';
            $td_color = 1;
		}
     ?>
    <tr class="<?php echo ' '.$bg; ?>">
    <!--<tr class="<?php// echo $bg; ?>">-->
        <td class="td_chk">
            <?php if (!$row['iq_inquiryid']) { // wetoz : naverpayorder ?>
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['iq_subject']) ?> 상품문의</label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i; ?>">
            <input type="hidden" name="iq_id[<?php echo $i; ?>]" value="<?php echo $row['iq_id']; ?>">
            <?php } ?>
        </td>
        <td style="width:50px;"><a href="<?php echo $href; ?>" target="_blank"><?php echo get_it_image($row['it_id'], 50, 50); ?></a></td>
        <td style="width:220px;">
            <?php if ($row['iq_inquiryid']) { // wetoz : naverpayorder ?>
                [네이버페이문의]
            <?php } ?>
            <a href="<?php echo $href; ?>" target="_blank" class="darkgray"><?php echo cut_str($row['it_name'],30); ?></a>
        </td>
        <td style="background:#FEFAD7;">
            <a href="#" class="qa_href" onclick="return false;" target="<?php echo $i; ?>" style="background:#FEFAD7;">
			    <?php echo ($row['iq_answer']) ? '<img src="'.G5_ADMIN_URL.'/img/icon/lightbulb.png">' : '<img src="'.G5_ADMIN_URL.'/img/icon/cancel.png">'; ?>
			    <?php echo get_text($row['iq_subject']); ?>
            </a>
            <div id="qa_div<?php echo $i; ?>" class="qa_div" style="display:none; margin-top:5px;">
                <?php echo $iq_answer; ?>
            </div>
        </td>
        <td class="td_writename"><?php echo $name; ?></td>
        <td class="td_boolean" style="line-height:12px;"><?php echo $time; ?></td>
        <td class="td_boolean" style="line-height:12px;"><?php echo $answer; ?></td>
        <td class="td_mngsmall">
            <!--수정버튼div로변경-->
            <div onClick="location.href='./itemqaform.php?w=u&amp;iq_id=<?php echo $row['iq_id']; ?>&amp;<?php echo $qstr; ?>'"><span class="sound_only"><?php echo get_text($row['iq_subject']); ?></span>수정</div>
            <!--//-->
        </td>
    </tr>
    <?php
    }
    if ($i == 0) {
        echo '<tr><td colspan="8" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
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

<script>
function fitemqalist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed  == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}

$(function(){
    $(".qa_href").click(function(){
        var $content = $("#qa_div"+$(this).attr("target"));
        $(".qa_div").each(function(index, value){
            if ($(this).get(0) == $content.get(0)) { // 객체의 비교시 .get(0) 를 사용한다.
                $(this).is(":hidden") ? $(this).show() : $(this).hide();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>