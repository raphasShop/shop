<?php
$sub_menu = '455650'; /* 수정전 원본 메뉴코드 400650 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '사용후기';
include_once (G5_ADMIN_PATH.'/admin.head.php');

// wetoz : naverpayorder
include_once(G5_PLUGIN_PATH.'/wznaverpay/config.php');
$aor = new NHNAPIORDER();
$aor->PurchaseReviewClassType = 'GENERAL'; // 일반평가져오기
$aor->customersync_rotation('GetPurchaseReviewList-GENERAL');

$aor = new NHNAPIORDER();
$aor->PurchaseReviewClassType = 'PREMIUM'; // 프리미엄평가져오기
$aor->customersync_rotation('GetPurchaseReviewList-PREMIUM');
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

if ($sfl == "")  $sfl = "a.it_name";
if (!$sst) {
    $sst = "is_id";
    $sod = "desc";
}

$sql_common = "  from {$g5['g5_shop_item_use_table']} a
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
          order by $sst $sod, is_id desc
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
    <option value=''>전체분류</option>
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
    <option value="is_name" <?php echo get_selected($sfl, 'is_name'); ?>>이름</option>
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
    <div class="totallist"><strong><?php echo number_format($total_count); ?></strong> 개의 후기가 검색되었습니다</div>

    <!--@@ 우측공간 전체 감쌈 시작 { @@-->
    <div class="sortlist">
    <!-- 정렬 선택 시작 { -->
    <section id="sct_sort">
    <select id="ssch_sort" onChange="window.location.href=this.value">
        <option value="">정렬선택</option>
        <option value="<?php echo $sortlist; ?>is_confirm&amp;sod=asc">승인대기중을 맨위로</option>
        <option value="<?php echo $sortlist; ?>is_time&amp;sod=desc">후기등록일 최근순</option>
        <option value="<?php echo $sortlist; ?>is_time&amp;sod=asc">후기등록일 과거순</option>
        <option value="<?php echo $sortlist; ?>is_score&amp;sod=desc">상품평점 높은순</option>
        <option value="<?php echo $sortlist; ?>is_score&amp;sod=asc">상품평점 낮은순</option>
        <option value="<?php echo $sortlist; ?>a.it_id&amp;sod=desc">상품코드 최근순</option>
        <option value="<?php echo $sortlist; ?>a.it_id&amp;sod=asc">상품코드 과거순</option>
        <option value="<?php echo $sortlist; ?>it_name&amp;sod=asc">상품명 가나다순</option>
        <option value="<?php echo $sortlist; ?>is_id&amp;sod=desc">정렬초기화</option>
    </select>
    </section>
    <!-- } 정렬 선택 끝 -->
    </div>
    <!--@@ } 우측공간 전체 감쌈 끝 @@-->

</div>
<!-- // -->

<form name="fitemuselist" method="post" action="./itemuselistupdate.php" onsubmit="return fitemuselist_submit(this);" autocomplete="off">
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
            <label for="chkall" class="sound_only">사용후기 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
		<th scope="col" colspan="2"><?php echo subject_sort_link("it_name"); ?>상품명</a>&nbsp;&nbsp;<?php echo subject_sort_link("it_id"); ?>상품코드</a></th>
        <th scope="col"><?php echo subject_sort_link("mb_name"); ?>작성자</a></th>
        <th scope="col"><?php echo subject_sort_link("is_time"); ?>작성일</a></th>
        <th scope="col"><?php echo subject_sort_link("is_subject"); ?>사용후기제목</a></th>
        <th scope="col"><?php echo subject_sort_link("is_score"); ?>평점</a></th>
		<th scope="col" colspan="2"><?php echo subject_sort_link("is_confirm"); ?>승인</a></th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
        $name = get_sideview($row['mb_id'], get_text($row['is_name']), $row['mb_email'], $row['mb_homepage']);
		$time = '<span class="gray font-11">'.substr($row['is_time'],0,4).'</span><br><span class="lightviolet font-12">'.substr($row['is_time'],5,6).'</span><br><span class="lightviolet font-11">'.substr($row['is_time'],11,8);//후기등록일시

		$is_content = $row['is_confirm'] ? '<img src="'.G5_ADMIN_URL.'/shop_admin/img/left-plus.gif"> <span class="blue">[노출중]</span> <span class="darkgray font-11">쇼핑몰에 사용후기가 노출되고 있습니다</span>'.get_view_thumbnail(conv_content($row['is_content'], 1), 300) : '<img src="'.G5_ADMIN_URL.'/shop_admin/img/left-minus.gif"> <span class=orangered>승인대기중입니다</span>'.get_view_thumbnail(conv_content($row['is_content'], 1), 300);
		//$is_content = get_view_thumbnail(conv_content($row['is_content'], 1), 300);

        $bg = 'bg'.($i%2);

		// 완료,진행중 테이블색상 class 지정 - 아이스크림
		$td_color = 0;
        if($row['is_confirm'] == '1') { // 승인완료
            $bg .= 'end';
            $td_color = 1;
		} else { // 승인전
		    $bg .= '';
            $td_color = 1;
		}
    ?>

    <tr class="<?php echo ' '.$bg; ?>">
    <!--<tr class="<?php// echo $bg; ?>">-->
        <td class="td_chk">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['is_subject']) ?> 사용후기</label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i; ?>">
            <input type="hidden" name="is_id[<?php echo $i; ?>]" value="<?php echo $row['is_id']; ?>">
            <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
        </td>
        <td style="width:50px;"><a href="<?php echo $href; ?>" target="_blank"><?php echo get_it_image($row['it_id'], 50, 50); ?></a></td>
        <td style="width:160px;">
            <a href="<?php echo $href; ?>" target="_blank"><?php echo cut_str($row['it_name'],30); ?></a>
            <br><span class="font-11 gray"><?php echo $row['it_id']; ?></span>
        </td>
        <td class="td_writename"><?php echo $name; ?></td>
        <td class="td_mngsmall" style="line-height:12px; letter-spacing:0px;"><?php echo $time; ?></td>
        <td class="sit_use_subject" style="background:#FEFAD7;">
            <?php if ($row['is_purchasereviewid']) { // wetoz : naverpayorder ?>
                [네이버리뷰]
            <?php } ?>
            <a href="#" class="use_href" onclick="return false;" target="<?php echo $i; ?>" style="background:#FEFAD7;">
			    <?php echo ($row['is_confirm']) ? '<img src="'.G5_ADMIN_URL.'/img/icon/lightbulb.png">' : '<img src="'.G5_ADMIN_URL.'/img/icon/cancel.png">'; ?>
				<?php echo get_text($row['is_content']); ?>
            </a>


        </td>
        <td class="td_num">
            <label for="score_<?php echo $i; ?>" class="sound_only">평점</label>
            <select name="is_score[<?php echo $i; ?>]" id="score_<?php echo $i; ?>">
            <option value="5" <?php echo get_selected($row['is_score'], "5"); ?>>매우만족</option>
            <option value="4" <?php echo get_selected($row['is_score'], "4"); ?>>만족</option>
            <option value="3" <?php echo get_selected($row['is_score'], "3"); ?>>보통</option>
            <option value="2" <?php echo get_selected($row['is_score'], "2"); ?>>불만</option>
            <option value="1" <?php echo get_selected($row['is_score'], "1"); ?>>매우불만</option>
            </select>
            <br><img src="<?php echo G5_ADMIN_URL; ?>/shop_admin/img/sly<?php echo $row['is_score']; ?>.png" height="13px">
        </td>
        <td class="td_chk" colspan="1">
            <label for="confirm_<?php echo $i; ?>" class="sound_only">확인</label>
            <input type="checkbox" name="is_confirm[<?php echo $i; ?>]" <?php echo ($row['is_confirm'] ? 'checked' : ''); ?> value="1" id="confirm_<?php echo $i; ?>">
        </td>
        <td class="td_mngsmall" colspan="1">
            <?php echo ($row['is_confirm'] ? '<span class=gray font-11>노출중</span>' : '<label for="confirm_'.$i.'"><span class=orangered font-11>승인대기</span></label>'); ?>
        </td>
        <td class="td_mngsmall">
            <a href="./itemuseform.php?w=u&amp;is_id=<?php echo $row['is_id']; ?>&amp;<?php echo $qstr; ?>"><span class="sound_only"><?php echo get_text($row['is_subject']); ?> </span>수정</a>
        </td>
    </tr>

    <?php
    }

    if ($i == 0) {
        echo '<tr><td colspan="10" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>
<!--
<div class="btn_list01 btn_list">
    <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value">
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
</div>
-->
<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">
    <div class="bq_basic">
    <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value">
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">

    <?php if (file_exists(G5_ADMIN_PATH.'/shop_admin/itemusenpayreview.php')) { // wetoz : naverpayorder?>
    <input type="button" value="네이버페이 상품리뷰 일괄 등록" class="btn btn_01" onclick="window.open('./itemusenpayreview.php', 'copywin', 'left=100, top=100, width=550, height=300, scrollbars=1')">
    <?php } ?>

    </div>
</div>
<!--//-->

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
function fitemuselist_submit(f)
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

$(function(){
    $(".use_href").click(function(){
        var $content = $("#use_div"+$(this).attr("target"));
        $(".use_div").each(function(index, value){
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