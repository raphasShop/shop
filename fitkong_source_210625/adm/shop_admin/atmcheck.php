<?php
$sub_menu = '411640'; /* 수정전 원본 메뉴코드 400640 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '무통장입금 확인요청 리스트';
include_once (G5_ADMIN_PATH.'/admin.head.php');

// 관리자 > 최적화 > 아이스크림DB업데이트를 실행하시면, DB가 정상적으로 설치됩니다.

$sql_common = " from {$g5['g5_shop_order_atmcheck_table']} ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'od_id' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        case 'it_id' :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "id_id";
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

//$qstr = 'page='.$page.'&amp;sst='.$sst.'&amp;sod='.$sod.'&amp;stx='.$stx;
$qstr .= ($qstr ? '&amp;' : '').'&amp;save_stx='.$stx;

// 목록 정렬 조건 - 아이스크림
$sortlist = $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;sst=';
?>
<!-- 검색창 -->
<div class="dan-schbox1" style="text-align:center;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
<form name="flist" class="big_sch01 big_sch">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="id_name" <?php echo get_selected($sfl, 'id_name'); ?>>주문자이름</option>
    <option value="id_deposit_name" <?php echo get_selected($sfl, 'id_deposit_name'); ?>>입금자이름</option>
    <option value="od_id" <?php echo get_selected($sfl, 'od_id'); ?>>주문번호</option>
    <option value="it_id" <?php echo get_selected($sfl, 'it_id'); ?>>상품번호</option>
</select>

<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx; ?>" required class="frm_input_big required">
<input type="submit" value="검색" class="btn_submit_big">
<?php echo $listall; //전체보기?>
</form>
    </div><!-- } row 끝 -->
</div><!-- 검색창 -->
<!-- 검색창 끝 -->

<div class="local_desc01 local_desc">
무통장입금주문 후 입금후에 전화나 상담게시판에 남기는 번거로움없이<br>
주문조회페이지에서 "입금확인요청"을 통해 관리자에게 알리는 방식입니다.<br>
관리자모드 메인페이지에도 입금확인요청시 바로 숫자로 뜨게되고, 입금된것이 확인되면 확인처리에 체크후 선택저장하시면 됩니다.<br>
주문번호를 클릭해서 주문서 정보에서도 입금정보를 입력해서 입금완료상태로 변경합니다. (주문서에서 꼭 입금정보 입력해야 적용됩니다)
</div>

<!-- 대기건표시 -->
<span class="font-12 font-normal">
    <img src="<?php echo G5_ADMIN_URL;?>/img/icon/cancel.png" align="absmiddle">
    아직 입금 확인하지않은 대기건은 총 <strong><?php echo number_format($total_confirm_count) ?></strong> 건이 있습니다
</span>
<!-- // -->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <div class="totallist">
    입금확인요청 <strong><?php echo number_format($total_count) ?></strong> 개가 검색되었습니다
    </div>
    <div class="sortlist">
        <!-- 정렬 선택 시작 { -->
        <section id="sct_sort">
        <select id="ssch_sort" onChange="window.location.href=this.value">
            <option value="">정렬선택</option>
            <option value="<?php echo $sortlist; ?>id_confirm&amp;sod=asc">확인대기중을 맨위로</option>
            <option value="<?php echo $sortlist; ?>id_deposit_date&amp;sod=desc">입금일 최근순</option>
            <option value="<?php echo $sortlist; ?>id_deposit_date&amp;sod=asc">입금일 과거순</option>
            <option value="<?php echo $sortlist; ?>id_time&amp;sod=desc">확인요청일 최근순</option>
            <option value="<?php echo $sortlist; ?>id_time&amp;sod=asc">확인요청일 과거순</option>
            <option value="<?php echo $sortlist; ?>od_id&amp;sod=desc">주문번호 최근순</option>
            <option value="<?php echo $sortlist; ?>od_id&amp;sod=asc">주문번호 과거순</option>
            <option value="<?php echo $sortlist; ?>id_money&amp;sod=desc">입금액 많은순</option>
            <option value="<?php echo $sortlist; ?>id_money&amp;sod=asc">입금액 적은순</option>
            <option value="<?php echo $sortlist; ?>id_deposit_name&amp;sod=asc">입금자 가나다순</option>
            <option value="<?php echo $sortlist; ?>id_id&amp;sod=desc">정렬초기화</option>
        </select>
        </section>
        <!-- } 정렬 선택 끝 -->
    </div>
</div>
<!-- // -->

<form name="fatmchecklist" method="post" action="./atmcheckupdate.php" onsubmit="return fatmchecklist_submit(this);" autocomplete="off">
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
        <th scope="col"><?php echo subject_sort_link("od_id"); ?>주문번호</a></th>
		<th scope="col" colspan="2"><?php echo subject_sort_link("id_name"); ?>입금확인요청</a></th>
        <th scope="col"><?php echo subject_sort_link("id_time"); ?>요청일시</a></th>
        <th scope="col"><?php echo subject_sort_link("od_bank_account"); ?>입금계좌</a></th>
        <th scope="col"><?php echo subject_sort_link("id_money"); ?>입금액</a></th>
        <th scope="col"><?php echo subject_sort_link("id_deposit_name"); ?>입금자</a></th>
        <th scope="col"><?php echo subject_sort_link("id_deposit_time"); ?>입금일</a></th>
		<th scope="col"><?php echo subject_sort_link("id_confirm"); ?>확인처리</a></th>
        <th scope="col"><?php echo subject_sort_link("id_confirm"); ?>상태</a></th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
		$odhref = G5_ADMIN_URL.'/shop_admin/orderform.php?od_id='.$row['od_id'];
        $name = get_sideview($row['mb_id'], get_text($row['id_name']), $row['mb_email'], $row['mb_homepage']);
		$time = '<span class="gray font-11">'.substr($row['id_time'],0,4).'</span><br><span class="violet font-12">'.substr($row['id_time'],5,6).'</span><br><span class="lightviolet font-11">'.substr($row['id_time'],11,8);//후기등록일시
        $is_content = get_view_thumbnail(conv_content($row['id_content'], 1), 300);

        $bg = 'bg'.($i%2);
		
		// 확인,미확인 테이블색상 class 지정 - 아이스크림
		$td_color = 0;
        if($row['id_confirm'] == '1') { // 확인완료
            $bg .= 'end';
            $td_color = 1;
		} else { // 확인전
		    $bg .= '';
            $td_color = 1;
		}
    ?>
    <tr class="<?php echo ' '.$bg; ?>">
    <!--<tr class="<?php// echo $bg; ?>">-->
        <td class="td_chk">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['id_subject']) ?> 사용후기</label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i; ?>">
            <input type="hidden" name="id_id[<?php echo $i; ?>]" value="<?php echo $row['id_id']; ?>">
            <input type="hidden" name="od_id[<?php echo $i; ?>]" value="<?php echo $row['od_id']; ?>">
        </td>
        <td class="td_code" style="font-size:11px;font-weight:bold;text-align:center;white-space:nowrap;">
            <a href="<?php echo $odhref; ?>" target="_blank"><?php echo $row['od_id']; ?>
            <br><span class="gray font-11 font-normal">주문서보기</span>
            </a>
        </td>
        <td colspan="1" style="width:50px;"><a href="<?php echo $href; ?>" target="_blank"><?php echo get_it_image($row['it_id'], 50, 50); ?></a></td>
        <td colspan="1" style="width:170px;">		
		<?php echo ($row['id_confirm']) ? '<img src="'.G5_ADMIN_URL.'/img/icon/lightbulb.png">' : '<img src="'.G5_ADMIN_URL.'/img/icon/cancel.png">'; ?>
		<?php if($row['mb_id']) { //회원일경우?>
            <?php echo get_text($row['id_name']); ?> <span class="violet"><?php echo get_text($row['mb_id']); ?></span>
        <?php } else { //비회원일경우?>
            <?php echo get_text($row['id_subject']); ?>
        <?php } ?>
        </td>
        <td class="td_mngsmall" style="line-height:12px;letter-spacing:0px;"><?php echo $time; ?></td>
        <td>
             <div align="center"><?php echo $row['od_bank_account']; ?><br />
             </div>
        </td>
        <td class="td_num" style="text-align:center;">
        <input type="text" name="id_money[<?php echo $i; ?>]" value="<?php echo $row['id_money']; ?>" id="money<?php echo $i; ?>" class="frm_input" size="5" style="text-align:right;" autocomplete="off">
        </td>
        <td class="td_num" style="text-align:center;">
        <input type="text" name="id_deposit_name[<?php echo $i; ?>]" value="<?php echo $row['id_deposit_name']; ?>" id="deposit_name<?php echo $i; ?>" class="frm_input" size="8" autocomplete="off">
        </td>
        <td class="td_mngsmall font-12 blue" style="letter-spacing:0px;">
			<?php echo substr($row['id_deposit_date'],5,10); ?><span class="gray"><?php echo get_yoil($row['id_deposit_date']); ?></span>
        </td>
        <td class="td_mngsmall">
            <label for="confirm_<?php echo $i; ?>" class="sound_only">확인</label>
            <input type="checkbox" name="id_confirm[<?php echo $i; ?>]" <?php echo ($row['id_confirm'] ? 'checked' : ''); ?> value="1" id="confirm_<?php echo $i; ?>">
        </td>
        <td style="text-align:center;">	
		<?php echo ($row['id_confirm'] ? '<span class=gray font-11>완료</span>' : '<label for="confirm_'.$i.'"><span class=orangered font-11>확인대기</span></label>'); ?>
        </td>
    </tr>

    <?php
    }

    if ($i == 0) {
        echo '<tr><td colspan="11" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
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
    </div>
</div>
<!--//-->

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
function fatmchecklist_submit(f)
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
