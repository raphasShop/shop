<?php
$sub_menu = '416180'; /* 새로만든 페이지 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '장바구니삭제 ( '.$default['de_cart_keep_term'].'일이 경과한 장바구니상품 삭제 )';

include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

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

if ($sfl == "")  $sfl = "it_name";
if (!$sst) {
    $sst = "ct_id";
    $sod = "desc";
}

// 장바구니 기간 데이타 추출을 위한 기간설정 - 2017-05-25 크림장수
$cart_month_term = strtotime(date('Y-m-d', G5_SERVER_TIME)); // 매월 오늘날짜 기준
$default_cart_keep_term = $default['de_cart_keep_term'];
$cart_keep_yearsago = date('Y-m-d', strtotime('-120 Month', $cart_month_term)); //장바구니기간검색시작일
$cart_keep_term = date('Y-m-d', strtotime('-'.$default_cart_keep_term.' days', G5_SERVER_TIME)); // 오늘부터 장바구니보관일기간

// 테이블의 전체 레코드수만 얻음
$sql_common = "  from {$g5['g5_shop_cart_table']} where ct_time between '$cart_keep_yearsago 00:00:00' and '$cart_keep_term 23:59:59' and ((ct_status = '쇼핑') or (ct_status = '삭제')) ";
//$sql_common = "  from {$g5['g5_shop_cart_table']} where ct_time between '$cart_keep_yearsago 00:00:00' and '$cart_keep_term 23:59:59' and ct_status = '쇼핑' or ct_status = '삭제' ";
$sql_common .= $sql_search;

$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql_confirm = " select count(*) as cnt " . $sql_common1;
$row_confirm = sql_fetch($sql_confirm);
$total_confirm_count = $row_confirm['cnt'];


$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select *
          $sql_common
          order by $sst $sod, ct_id desc
          limit $from_record, $rows ";
$result = sql_query($sql);

//$qstr = 'page='.$page.'&amp;sst='.$sst.'&amp;sod='.$sod.'&amp;stx='.$stx;
$qstr .= ($qstr ? '&amp;' : '').'&amp;fr_date='.$fr_date.'&amp;to_date='.$to_date.'&amp;save_stx='.$stx;

/*
$sql2 = " select mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_point from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
$row2 = sql_fetch($sql2);
$mb_nick = get_sideview($row2['mb_id'], get_text($row2['mb_nick']), $row2['mb_email'], $row2['mb_homepage']);
*/
?>

<!-- 안내창 -->
<div class="local_desc01 local_desc">
    <b class="font-14">장바구니 삭제안내</b><br>
    <b class="violet">※ 이곳의 장바구니 상품은 주문하지않은 상품들로 마음껏 삭제하셔도 상관없습니다</b><br>
    장바구니에 담은 날로부터 <strong><?php echo $default['de_cart_keep_term']; ?>일이 경과</strong>된 장바구니 상품만 조회되며 삭제할 수 있습니다 (장바구니에 담기만한 상품만 해당됩니다)<br>
    경과되는 기간은 관리자가 마음대로 바꿀수 있습니다. <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/configform.php#anc_scf_etc">경과되는 기간 설정하기</a><br>
    <i class="fa fa-shopping-basket" aria-hidden="true" title="장바구니에만 담음" style="color:#666666;"></i> : 장바구니에만 담은 상품&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-trash-o fa-lg" aria-hidden="true" title="장바구니에서 삭제" style="color:#ff9900;"></i> : 장바구니에 담았다가 삭제한 상품<br>
    주문후 취소/반품/환불/품절/교환 등의 경우에도 매출현황표나 기타 통계에서 문제가 생길수 있어 영구보존합니다.<br>
    주문이후의 장바구니 테이블은 용량이 많다고해서 삭제해선 않되고, 영구보존해야합니다.
</div>
<!--//-->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <strong><?php echo number_format($total_count) ?></strong> 개의 장바구니에 담긴 상품이 검색되었습니다.
</div>
<!-- // -->

<!-- @@@@@@@@@@ 리스트 출력 @@@@@@@@@@ -->
<form name="fcartlistallview" method="post" action="./cartlist_alldel_update.php" onsubmit="return fcartlistallview_submit(this);" autocomplete="off">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <thead>
    <tr>
        <th scope="col"><label for="chkall" class="sound_only">전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)"></th>
        <th scope="col">상품코드</th>
        <th scope="col" colspan="2">상품명</th>
        <th scope="col">수량/가격</th>
        <th scope="col">상태</th>
        <th scope="col">담은날짜</th>
        <th scope="col">회원/접속IP</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        // $s_mod = icon("수정", "./itemqaform.php?w=u&amp;iq_id={$row['iq_id']}&amp;$qstr");
        // $s_del = icon("삭제", "javascript:del('./itemqaupdate.php?w=d&amp;iq_id={$row['iq_id']}&amp;$qstr');");

        $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
        $num = $rank + $i + 1;

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_num">
            <?php if($row['ct_status'] == '쇼핑' || $row['ct_status'] == '삭제') { ?>
               <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i; ?>">
               <input type="hidden" name="ct_id[<?php echo $i; ?>]" value="<?php echo $row['ct_id']; ?>">
			<?php } else { ?>
               <i class="fa fa-times-circle fa-lg" aria-hidden="true" title="삭제불가" style="font-size:28px;color:#DDD;"></i>
            <?php } ?>

        </td>
        <td class="td_code" style="white-space:nowrap;">

			<b><?php echo $row['it_id']; ?></b>

        </td>
		<td style="width:50px;">
            <a href="<?php echo $href; ?>" target="_blank"><?php echo get_it_image($row['it_id'], 50, 50); ?></a>
        </td>
        <td>
            <a href="<?php echo $href; ?>" target="_blank"><?php echo cut_str($row['it_name'],30); ?></a>
            <!-- 선택옵션표시 -->
			<?php echo ($row['it_name'] == $row['ct_option']) ? '' : '<br><img src="'.G5_ADMIN_URL.'/img/left-plus.gif"> <span class="darkgreen font-11">'.$row['ct_option'].'</span>';//선택옵션표시 ?>
            <!--//-->
        </td>
        <td align="center">
        <?php
		//총합계계산
		$price = ($row['ct_price'] + $row['io_price']) * $row['ct_qty']; //기본상품,선택옵션 구매금액 
		$ioprice = $row['io_price'] * $row['ct_qty']; //추가옵션 구매금액
		?>
            <?php echo $row['ct_qty']; //옵션수량?>개
            <!-- 가격표시 -->
			<?php echo ($row['io_type'] == '1') ? '&nbsp;<span class="blue">￦'.number_format($ioprice).'</span>' : '&nbsp;<span class="blue">￦'.number_format($price).'</span>';//추가옵션구매금액 구분 표시 ?>
            <!--//-->
        </td>
        <td align="center">
            <?php if($row['ct_status'] == '쇼핑') { ?>
               <i class="fa fa-shopping-basket" aria-hidden="true" title="장바구니에만 담음" style="font-size:14px;color:#6DA5D8;"></i>
            <?php } else if($row['ct_status'] == '삭제') { ?>
               <i class="fa fa-trash-o fa-lg" aria-hidden="true" title="장바구니에서 삭제" style="font-size:14px;color:#C674E7;"></i>
			<?php } else { ?>
               <?php echo $row['ct_status']; //현재상태?>
            <?php } ?>
        </td>
        <td align="center">
            <?php echo $row['ct_time']; //장바구니에 담은시간?>
        </td>
         <td class="td_writename">
            <?php if($row['mb_id']) { //회원일경우?>
              <i class="fa fa-user"></i> <?php echo $row['mb_id']; ?>
            <?php } ?>
			<?php echo ($is_admin == 'super') ? '<br>'.$row['ct_ip'] : '';//최고관리자만 보임?>
        </td>
    </tr>
    <?php
    }

    if ($i == 0) {
        echo '<tr><td colspan="8" class="empty_table">자료가 없습니다.</td></tr>';
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
$(function() {
    $("#fr_date, #to_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        showButtonPanel: true,
        yearRange: "c-99:c+99",
        maxDate: "+0d"
    });
});

function fcartlistallview_submit(f)
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
