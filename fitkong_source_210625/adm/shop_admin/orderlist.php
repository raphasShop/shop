<?php
######################################################
/*
(1) 배송조회버튼을 2가지로 추가
수정파일 : lib/shop.lib.php 파일의 배송조회생성을 2가지로 변경 추가
2016년2월 관리자 배송조회버튼 분류 추가
*/
######################################################
$sub_menu = '411400'; /* 수정전 원본 메뉴코드 400400 */
include_once('./_common.php');
######################################################
$is_order_list = true; //주문내역리스트페이지 표시
######################################################
auth_check($auth[$sub_menu], "r");
######################################################
$g5['title'] = '주문내역리스트';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
######################################################

$where = array();

######################################################
//주문정보 유출우려 보안소스추가 - 아이스크림-2017-01-23
######################################################
$doc = strip_tags($doc);
$sort1 = in_array($sort1, array('od_id', 'od_cart_price', 'od_receipt_price', 'od_cancel_price', 'od_misu', 'od_cash')) ? $sort1 : '';
$sort2 = in_array($sort2, array('desc', 'asc')) ? $sort2 : 'desc';
$sel_field = get_search_string($sel_field);
// wetoz : naverpayorder - , 'od_naver_orderid' 추가
if( !in_array($sel_field, array('od_id', 'mb_id', 'od_name', 'od_tel', 'od_hp', 'od_b_name', 'od_b_tel', 'od_b_hp', 'od_ip', 'od_deposit_name', 'od_invoice', 'od_naver_orderid')) ){   //검색할 필드 대상이 아니면 값을 제거
    $sel_field = '';
}
$od_status = get_search_string($od_status);
//echo "<script>console.log( 'PHP_Console: " . $od_status . "' );</script>";


$search = get_search_string($search);
if(! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = '';
if(! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = '';
######################################################

$sql_search = "";
if ($search != "") {
    if ($sel_field != "") {
        $where[] = " $sel_field like '%$search%' ";
    }

    if ($save_search != $search) {
        $page = 1;
    }
}
######################################################
// 주문상태 구분
######################################################
if ($od_status) {
    switch($od_status) {
        case '전체취소':
            $where[] = " od_status = '취소' ";
            break;
        case '부분취소':
            $where[] = " od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0 ";
            break;
		case '취소'://전체취소,부분취소 구분없이 취소된것 모두 검색을 위한 코드추가
            $where[] = " od_status = '취소' or od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0 ";
            break;
        default:
            //$where[] = " od_status = '$od_status' ";
			$where[] = " od_id IN ( SELECT od_id FROM `{$g5['g5_shop_cart_table']}` WHERE ct_status = '$od_status' ) ";//여러상품주문시 상품별 상태가 다를경우 상품별로 검색확장
            break;
    }

    switch ($od_status) {
        case '주문' :
            $sort1 = "od_id";
            $sort2 = "desc";
            break;
        case '입금' :   // 결제완료
            $sort1 = "od_receipt_time";
            $sort2 = "desc";
            break;
        case '배송' :   // 배송중
            $sort1 = "od_invoice_time";
            $sort2 = "desc";
            break;
    }
}
#################################################################
// 모바일/PC구매 구분 ( value값이 '0'을 인식하지 못하는
// 관계로 조건문을 따로 만들어서 '문자'로 변환하여 인식하게끔 함
#################################################################
if ($od_mobile) { // value 값대신 조건문을 따로주어 문자로 변환
	switch($od_mobile) {
        case 'PC':
            $where[] = " od_mobile != '1' ";
            break;
        case '모바일':
            $where[] = " od_mobile = '1' ";
            break;
	}
}
######################################################
// 결제방식 구분
######################################################
if ($od_settle_case) {
    if($od_settle_case == '전체네이버페이제외') {
        $where[] = " od_settle_case != '네이버페이' ";
    } else {
        $where[] = " od_settle_case = '$od_settle_case' ";    
    }
    
}
######################################################
/* 선택항목 검색조건 추가 (1) 선택조건*/
######################################################
// 미수금
if ($od_misu) {
    $where[] = " od_misu != 0 ";
}
// 포인트사용
if ($od_receipt_point) {
    $where[] = " od_receipt_point != 0 ";
}
// 쿠폰사용
if ($od_coupon) {
    $where[] = " ( od_cart_coupon > 0 or od_coupon > 0 or od_send_coupon > 0 ) ";
}
// 에스크로사용
if ($od_escrow) {
    $where[] = " od_escrow = 1 ";
}
// 무료배송
if ($od_free_shipping) {
    $where[] = " od_send_cost = 0 ";
}
// 비회원구매
if ($od_guest) {
    $where[] = " mb_id = '' ";
}
// 주문서에 상점메모
if ($od_shop_memo) {
    $where[] = " od_shop_memo != '' ";
}
######################################################
/* 선택항목 검색조건 추가 완료중 교환 */
######################################################
// 교환상품(order테이블이아니 개별상품 cart테이블 상태검색)
if ($od_change_price) {
    $where[] = " od_id IN ( SELECT od_id FROM `{$g5['g5_shop_cart_table']}` WHERE ct_status = '교환' ) "; //새로추가
}
######################################################
/* 선택항목 검색조건 추가 (2) 취소조건 */
######################################################
// 입금전취소상품(order테이블이아니 개별상품 cart테이블 상태검색)
if ($od_cancel_price) {
    $where[] = " od_receipt_price = 0 and od_id IN ( SELECT od_id FROM `{$g5['g5_shop_cart_table']}` WHERE ct_status = '취소' ) ";
}
// 반품상품(order테이블이아니 개별상품 cart테이블 상태검색)
if ($od_back_price) {
    $where[] = " od_cancel_price != 0 and od_id IN ( SELECT od_id FROM `{$g5['g5_shop_cart_table']}` WHERE ct_status = '반품' ) ";
}
// 품절상품(order테이블이아니 개별상품 cart테이블 상태검색)
if ($od_soldout_price) {
    $where[] = " od_cancel_price != 0 and od_id IN ( SELECT od_id FROM `{$g5['g5_shop_cart_table']}` WHERE ct_status = '품절' ) ";
}
// 환불상품(order테이블이아니 개별상품 cart테이블 상태검색)
if ($od_refund_price) {
    $where[] = " od_refund_price != 0 and od_id IN ( SELECT od_id FROM `{$g5['g5_shop_cart_table']}` WHERE ct_status = '환불' ) ";
}
######################################################
// 기간조건선택 (주문일자,입금일자,배송일자) $od_term
######################################################
if ($fr_date && $to_date) {
    $where[] = " ".$od_term." between '$fr_date 00:00:00' and '$to_date 23:59:59' ";
}
######################################################
// 검색결과 산출
######################################################
if ($where) {
    $sql_search = ' where '.implode(' and ', $where);
}

if ($sel_field == "")  $sel_field = "od_name"; //주문분류 최초 선택(현재는 주문자로 되어있음)
if ($sort1 == "") $sort1 = "od_id";
if ($sort2 == "") $sort2 = "desc";

$sql_common = " from {$g5['g5_shop_order_table']} $sql_search ";

$sql = " select count(od_id) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];
$total_price = $row['price'];

$rows = $config['cf_page_rows'];
//$rows = 50;//목록수 50으로 고정
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select *,
            (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
           $sql_common
           order by $sort1 $sort2
           limit $from_record, $rows ";
$result = sql_query($sql);

/* 검색조건추가시 여기에 꼭 추가해야함(검색시 실제 주소창에 나오는 검색조건) [크림장수소스]*/
$qstr1 = "od_mobile=".urlencode($od_mobile)."&amp;od_status=".urlencode($od_status)."&amp;od_settle_case=".urlencode($od_settle_case)."&amp;od_misu=$od_misu&amp;od_back_price=$od_back_price&amp;od_soldout_price=$od_soldout_price&amp;od_change_price=$od_change_price&amp;od_cancel_price=$od_cancel_price&amp;od_refund_price=$od_refund_price&amp;od_receipt_point=$od_receipt_point&amp;od_coupon=$od_coupon&amp;od_free_shipping=$od_free_shipping&amp;od_guest=$od_guest&amp;od_shop_memo=$od_shop_memo&amp;od_term=$od_term&amp;fr_date=$fr_date&amp;to_date=$to_date&amp;sel_field=$sel_field&amp;search=$search&amp;save_search=$search";

if($default['de_escrow_use'])
    $qstr1 .= "&amp;od_escrow=$od_escrow";
$qstr = "$qstr1&amp;sort1=$sort1&amp;sort2=$sort2&amp;page=$page";

// 목록 정렬 조건
$sortlist = $_SERVER['SCRIPT_NAME'].'?'.$qstr1.'&amp;sort1=';

#######################################################################################

$left_info1 = ($info1['count'] > 0) ? number_format($info1['count']) : '-';

#######################################################################################

// 주문삭제 히스토리 테이블 필드 추가
if(!sql_query(" select mb_id from {$g5['g5_shop_order_delete_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_order_delete_table']}`
                    ADD `mb_id` varchar(20) NOT NULL DEFAULT '' AFTER `de_data`,
                    ADD `de_ip` varchar(255) NOT NULL DEFAULT '' AFTER `mb_id`,
                    ADD `de_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `de_ip` ", true);
}
?>

<div class="h15"></div>
<!-- 주문집계표 불러오기 -->
<?php include_once(G5_ADMIN_PATH.'/admin.inc.order.php'); ?>
<div class="h25"></div>
<!-- // -->

<!-- 검색창 -->
<div class="dan-schbox1" style="text-align:center;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
<form name="frmorderlist" class="big_sch01 big_sch">
<input type="hidden" name="doc" value="<?php echo $doc; ?>">
<input type="hidden" name="sort1" value="<?php echo $sort1; ?>">
<input type="hidden" name="sort2" value="<?php echo $sort2; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="save_search" value="<?php echo $search; ?>">

<label for="sel_field" class="sound_only">검색대상</label>
<select name="sel_field" id="sel_field">
    <option value="od_name" <?php echo get_selected($sel_field, 'od_name'); ?>>주문자</option>
    <option value="od_tel" <?php echo get_selected($sel_field, 'od_tel'); ?>>주문자전화</option>
    <option value="od_hp" <?php echo get_selected($sel_field, 'od_hp'); ?>>주문자핸드폰</option>
    <option value="od_b_name" <?php echo get_selected($sel_field, 'od_b_name'); ?>>받는분</option>
    <option value="od_b_tel" <?php echo get_selected($sel_field, 'od_b_tel'); ?>>받는분전화</option>
    <option value="od_b_hp" <?php echo get_selected($sel_field, 'od_b_hp'); ?>>받는분핸드폰</option>
    <option value="mb_id" <?php echo get_selected($sel_field, 'mb_id'); ?>>회원 ID</option>
    <option value="od_ip" <?php echo get_selected($sel_field, 'od_ip'); ?>>주문자아이피</option>
    <option value="od_deposit_name" <?php echo get_selected($sel_field, 'od_deposit_name'); ?>>입금자</option>
    <option value="od_id" <?php echo get_selected($sel_field, 'od_id'); ?>>주문번호</option>
    <option value="od_naver_orderid" <?php echo get_selected($sel_field, 'od_naver_orderid'); ?>>네이버페이주문번호</option> <!-- wetoz : naverpayorder -->
    <option value="od_invoice" <?php echo get_selected($sel_field, 'od_invoice'); ?>>운송장번호</option>
</select>

<label for="search" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="search" value="<?php echo $search; ?>" id="search" required class="required frm_input_big" autocomplete="off">
<input type="submit" value="검색" class="btn_submit_big">
<?php echo $listall; //전체보기?>

</form>
    </div><!-- } row 끝 -->
</div><!-- 검색창 -->
<!-- 검색창 끝 -->

<div class="dan-schbox2" style="margin-top:-1px;"><!-- 분류별검색창 -->
    <div class="row"><!-- row 시작 { -->
<form class="big_sch02 big_sch">
<div>
    <strong>구매장소</strong>
    <input type="radio" name="od_mobile" value="" id="od_mobile_all" <?php echo get_checked($od_mobile, ''); ?>>
    <label for="od_mobile_all">전체</label>
    <input type="radio" name="od_mobile" value="PC" id="od_mobile_pc" <?php echo get_checked($od_mobile, 'PC'); ?>>
    <label for="od_mobile_pc">PC에서 구매</label>
    <input type="radio" name="od_mobile" value="모바일" id="od_mobile_mobile" <?php echo get_checked($od_mobile, '모바일'); ?>>
    <label for="od_mobile_mobile">모바일에서 구매</label>
</div>

<div>
    <strong>주문상태</strong>
    <input type="radio" name="od_status" value="" id="od_status_all"    <?php echo get_checked($od_status, '');     ?>>
    <label for="od_status_all">전체</label>
    <input type="radio" name="od_status" value="주문" id="od_status_odr" <?php echo get_checked($od_status, '주문'); ?>>
    <label for="od_status_odr">입금대기<?php echo $linfo1; ?></label>
    <input type="radio" name="od_status" value="입금" id="od_status_income" <?php echo get_checked($od_status, '입금'); ?>>
    <label for="od_status_income">결제(입금)완료<?php echo $linfo2; ?></label>
    <input type="radio" name="od_status" value="준비" id="od_status_rdy" <?php echo get_checked($od_status, '준비'); ?>>
    <label for="od_status_rdy">배송준비<?php echo $linfo3; ?></label>
    <input type="radio" name="od_status" value="배송" id="od_status_dvr" <?php echo get_checked($od_status, '배송'); ?>>
    <label for="od_status_dvr">배송중<?php echo $linfo4; ?></label>
    <input type="radio" name="od_status" value="완료" id="od_status_done" <?php echo get_checked($od_status, '완료'); ?>>
    <label for="od_status_done">배송완료</label>
    <input type="radio" name="od_status" value="전체취소" id="od_status_cancel" <?php echo get_checked($od_status, '전체취소'); ?>>
    <label for="od_status_cancel">전체취소</label>
    <input type="radio" name="od_status" value="부분취소" id="od_status_pcancel" <?php echo get_checked($od_status, '부분취소'); ?>>
    <label for="od_status_pcancel">부분취소</label>
    <input type="radio" name="od_status" value="취소" id="od_status_allcancel" <?php echo get_checked($od_status, '취소'); ?>>
    <label for="od_status_allcancel">취소</label>
</div>

<div>
    <strong>결제수단</strong>
    <input type="radio" name="od_settle_case" value="" id="od_settle_case01" <?php echo get_checked($od_settle_case, '');          ?>>
    <label for="od_settle_case01">전체</label>
    <input type="radio" name="od_settle_case" value="전체네이버페이제외" id="od_settle_case11" <?php echo get_checked($od_settle_case, '전체네이버페이제외');    ?>>
    <label for="od_settle_case11">전체(네이버페이제외)</label>
    <input type="radio" name="od_settle_case" value="포인트" id="od_settle_case07" <?php echo get_checked($od_settle_case, '포인트');    ?>>
    <label for="od_settle_case07">포인트</label>
	<input type="radio" name="od_settle_case" value="무통장" id="od_settle_case02" <?php echo get_checked($od_settle_case, '무통장');    ?>>
    <label for="od_settle_case02">무통장</label>
    <input type="radio" name="od_settle_case" value="가상계좌" id="od_settle_case03" <?php echo get_checked($od_settle_case, '가상계좌');  ?>>
    <label for="od_settle_case03">가상계좌</label>
    <input type="radio" name="od_settle_case" value="계좌이체" id="od_settle_case04" <?php echo get_checked($od_settle_case, '계좌이체');  ?>>
    <label for="od_settle_case04">계좌이체</label>
    <input type="radio" name="od_settle_case" value="휴대폰" id="od_settle_case05" <?php echo get_checked($od_settle_case, '휴대폰');    ?>>
    <label for="od_settle_case05">휴대폰</label>
    <input type="radio" name="od_settle_case" value="신용카드" id="od_settle_case06" <?php echo get_checked($od_settle_case, '신용카드');  ?>>
    <label for="od_settle_case06">신용카드</label>
    <input type="radio" name="od_settle_case" value="간편결제" id="od_settle_case09" <?php echo get_checked($od_settle_case, '간편결제');  ?>>
    <label for="od_settle_case09">PG간편결제</label>
    <input type="radio" name="od_settle_case" value="KAKAOPAY" id="od_settle_case08" <?php echo get_checked($od_settle_case, 'KAKAOPAY');  ?>>
    <label for="od_settle_case08">KAKAOPAY</label>
    <input type="radio" name="od_settle_case" value="네이버페이" id="od_settle_case10" <?php echo get_checked($od_settle_case, '네이버페이');  ?>>
    <label for="od_settle_case10">네이버페이</label>
</div>

<div>
    <?php
	#####################################################################
	// [필독] 선택 항목추가시 반드시 같이 해야할 작업!!!!!!!!
	#####################################################################
	/*
	(1) 상단의 검색 where 항목추가 : 60줄부근
	(2) 130줄부근의 $qstr1 = 에 들어가는 항목을 추가해주어야 합니다
	*/
	#####################################################################
	?>
    <strong>포함조건</strong>
    <input type="checkbox" name="od_misu" value="Y" id="od_misu21" <?php echo get_checked($od_misu, 'Y'); ?>>
    <label for="od_misu21">미수금</label>
    <input type="checkbox" name="od_receipt_point" value="Y" id="od_misu22" <?php echo get_checked($od_receipt_point, 'Y'); ?>>
    <label for="od_misu22">포인트주문</label>
    <input type="checkbox" name="od_coupon" value="Y" id="od_misu23" <?php echo get_checked($od_coupon, 'Y'); ?>>
    <label for="od_misu23">쿠폰</label>
    <?php if($default['de_escrow_use']) { ?>
    <input type="checkbox" name="od_escrow" value="Y" id="od_misu24" <?php echo get_checked($od_escrow, 'Y'); ?>>
    <label for="od_misu24">에스크로</label>
    <?php } ?>
    <input type="checkbox" name="od_free_shipping" value="Y" id="od_misu25" <?php echo get_checked($od_free_shipping, 'Y'); ?>>
    <label for="od_misu25">무료배송</label>
    <input type="checkbox" name="od_guest" value="Y" id="od_misu26" <?php echo get_checked($od_guest, 'Y'); ?>>
    <label for="od_misu26">비회원구매</label>
    <input type="checkbox" name="od_shop_memo" value="Y" id="od_misu27" <?php echo get_checked($od_shop_memo, 'Y'); ?>>
    <label for="od_misu27">상점메모</label>

</div>

<div>
    <?php
	#####################################################################
	// [필독] 선택 항목추가시 반드시 같이 해야할 작업!!!!!!!!
	#####################################################################
	/*
	(1) 상단의 검색 where 항목추가 : 60줄부근
	(2) 130줄부근의 $qstr1 = 에 들어가는 항목을 추가해주어야 합니다
	*/
	#####################################################################
	?>
    <strong>취소상태 <font style="color:#FF3061;font-size:0.9em;font-weight:normal;">(1개선택)</font></strong>
    <input type="checkbox" name="od_cancel_price" value="Y" id="od_misu01" <?php echo get_checked($od_cancel_price, 'Y'); ?>>
    <label for="od_misu01">입금전취소</label>
    <input type="checkbox" name="od_soldout_price" value="Y" id="od_misu04" <?php echo get_checked($od_soldout_price, 'Y'); ?>>
    <label for="od_misu04">품절</label>
    <input type="checkbox" name="od_refund_price" value="Y" id="od_misu06" <?php echo get_checked($od_refund_price, 'Y'); ?>>
    <label for="od_misu06">환불완료</label>
    <input type="checkbox" name="od_back_price" value="Y" id="od_misu03" <?php echo get_checked($od_back_price, 'Y'); ?>>
    <label for="od_misu03">반품완료</label>
    <input type="checkbox" name="od_change_price" value="Y" id="od_misu05" <?php echo get_checked($od_change_price, 'Y'); ?>>
    <label for="od_misu05">교환완료</label>

</div>

<div class="sch_last">
    <strong>기간선택</strong>
    <!-- 기간선택조건 -->
    <label for="od_term" class="sound_only">기간선택조건</label>
    <select name="od_term" id="od_term" style="border:1px solid #b5b5b5;padding:0px 4px;height:28px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;">
        <option value="od_time"<?php echo get_selected($od_term, 'od_time') ?>>주문일자</option>
        <option value="od_receipt_time"<?php echo get_selected($od_term, 'od_receipt_time') ?>>결제일</option>
        <option value="od_invoice_time"<?php echo get_selected($od_term, 'od_invoice_time') ?>>택배발송일</option>
    </select>
    <!-- // -->
    <input type="text" id="fr_date"  name="fr_date" value="<?php echo $fr_date; ?>" class="frm_input" size="10" maxlength="10"> ~
    <input type="text" id="to_date"  name="to_date" value="<?php echo $to_date; ?>" class="frm_input" size="10" maxlength="10">
    <button type="button" onclick="javascript:set_date('오늘');">오늘</button>
    <button type="button" onclick="javascript:set_date('어제');">어제</button>
    <button type="button" onclick="javascript:set_date('이번주');">이번주</button>
    <button type="button" onclick="javascript:set_date('이번달');">이번달</button>
    <button type="button" onclick="javascript:set_date('지난주');">지난주</button>
    <button type="button" onclick="javascript:set_date('지난달');">지난달</button>
    <button type="button" onclick="javascript:set_date('1주일');">1주일</button>
    <button type="button" onclick="javascript:set_date('1개월');">1개월</button>
    <button type="button" onclick="javascript:set_date('3개월');">3개월</button>
    <button type="button" onclick="javascript:set_date('6개월');">6개월</button>
    <button type="button" onclick="javascript:set_date('1년');">1년</button>
    <button type="button" onclick="javascript:set_date('전체');"><i class="fa fa-refresh" aria-hidden="true"></i> 초기화</button>
</div>

<div class="sch_btn">
<input type="submit" value="선택검색" class="btn_submit_big">
<button type="button" onClick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/orderlist.php'"><i class="fa fa-refresh" aria-hidden="true"></i> 선택초기화</button>
</div>

</form>
    </div><!-- } row 끝 -->
</div><!-- 검색창 -->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <div class="totallist"><strong><?php echo number_format($total_count); ?></strong> 개의 주문이 검색되었습니다
	&nbsp;<span class="font-14 blue">￦<?php echo number_format($total_price); ?></span></div>
    <!--
	<?php if($od_status == '준비' && $total_count > 0) { ?>
        &nbsp;&nbsp;&nbsp;&nbsp;<a href="./orderdelivery.php" id="order_delivery" class="ov_a">송장 Excel 일괄등록(새창)</a>
        &nbsp;&nbsp;&nbsp;&nbsp;<a href="./orderdelivery_EXCEL.php" class="ov_a">송장 Excel 일괄등록(공식)</a>
    <?php } ?>
    -->

    <!--@@ 우측공간 전체 감쌈 { @@-->
    <div class="sortlist">
    <!-- 정렬 선택 시작 { -->
    <section id="sct_sort">
    <select id="ssch_sort" onChange="window.location.href=this.value">
        <option value="">정렬선택</option>
        <option value="<?php echo $sortlist; ?>od_id&amp;sort2=desc&amp;page=$page">주문번호 최근순</option>
        <option value="<?php echo $sortlist; ?>od_id&amp;sort2=asc&amp;page=$page">주문번호 과거순</option>
        <option value="<?php echo $sortlist; ?>od_receipt_time&amp;sort2=desc&amp;page=$page">결제일 최근순</option>
        <option value="<?php echo $sortlist; ?>od_receipt_time&amp;sort2=asc&amp;page=$page">결제일 과거순</option>
        <option value="<?php echo $sortlist; ?>od_invoice_time&amp;sort2=desc&amp;page=$page">배송일 최근순</option>
        <option value="<?php echo $sortlist; ?>od_invoice_time&amp;sort2=asc&amp;page=$page">배송일 과거순</option>
        <option value="<?php echo $sortlist; ?>od_cart_price&amp;sort2=desc&amp;page=$page">주문합계 많은순</option>
        <option value="<?php echo $sortlist; ?>od_cart_price&amp;sort2=asc&amp;page=$page">주문합계 적은순</option>
        <option value="<?php echo $sortlist; ?>od_receipt_price&amp;sort2=desc&amp;page=$page">입금합계 많은순</option>
        <option value="<?php echo $sortlist; ?>od_receipt_price&amp;sort2=asc&amp;page=$page">입금합계 적은순</option>
        <option value="<?php echo $sortlist; ?>od_misu&amp;sort2=desc&amp;page=$page">미수금 많은순</option>
        <option value="<?php echo $sortlist; ?>od_misu&amp;sort2=asc&amp;page=$page">미수금 적은순</option>
        <option value="<?php echo $sortlist; ?>od_cancel_price&amp;sort2=desc&amp;page=$page">취소금액 많은순</option>
        <option value="<?php echo $sortlist; ?>od_cancel_price&amp;sort2=asc&amp;page=$page">취소금액 적은순</option>
        <option value="<?php echo $sortlist; ?>od_cart_count&amp;sort2=desc&amp;page=$page">상품수 많은순</option>
        <option value="<?php echo $sortlist; ?>od_receipt_point&amp;sort2=desc&amp;page=$page">포인트 사용순</option>
        <option value="<?php echo $sortlist; ?>couponprice&amp;sort2=desc&amp;page=$page">쿠폰 사용순</option>
        <option value="<?php echo $sortlist; ?>od_status&amp;sort2=asc&amp;page=$page">주문상태 가나다순</option>
        <option value="<?php echo $sortlist; ?>od_id&amp;sort2=desc&amp;page=$page">정렬초기화</option>
    </select>
    </section>
    <!-- } 정렬 선택 끝 -->
    </div>
    <!--@@ } 우측공간 전체 감쌈 끝 @@-->

</div>
<!-- // -->

<?php
/*
#####################################################################################
#####################################################################################
if(G5_IS_MOBILE) { //모바일스킨 인클루드
    include_once(G5_ADMIN_PATH.'/icecream_skin/mobile/orderlist.skin.php'); //모바일페이지
} else { //PC스킨 인클루드
    include_once(G5_ADMIN_PATH.'/icecream_skin/pc/orderlist.skin.php'); //PC페이지
}
#####################################################################################
#####################################################################################
*/
?>

<!-- wetoz : naverpayorder -->
<?php
if ($default['de_naverpayorder_AccessLicense'] && $default['de_naverpayorder_SecretKey']) {
    @include_once(G5_DATA_PATH.'/cache/naverpayorder-ordersync.php');
    ?>
    <div class="btn_confirm01 btn_confirm"><a href="#none" onclick="sync_naverapi();" id="btn-naverapi">네이버 주문정보 동기화 <?php if ($InqTimeFrom) echo '(최종 : '.str_replace('T', ' ', $InqTimeFrom).')';?></a></div>
    <script type="text/javascript">
    <!--
    function sync_naverapi() {
        $.ajax({
            url: g5_url+'/plugin/wznaverpay/sync_rotation.php',
            dataType: 'html',
            type:'post',
            beforeSend : function() {
                $('#btn-naverapi').html('네이버 주문정보 동기화 처리중.. <img src="'+g5_url+'/plugin/wznaverpay/img/loading.gif" />');
            },
            success:function(req) {
                //if (req == 'RESULT=TRUE') {
                    location.reload();
                //}
                //else {
                //    alert('동기화에 실패하였습니다.');
                //    location.reload();
                //}
            }
        });
    }
    //-->
    </script>
<?php } ?>
<!-- wetoz : naverpayorder -->

<form name="forderlist" id="forderlist" onsubmit="return forderlist_submit(this);" method="post" autocomplete="off">
<input type="hidden" name="search_od_status" value="<?php echo $od_status; ?>">

<div id="ice_list"><!-- 주문목록전체 감싸기 시작 { -->

    <!-- (공통) 전체선택체크박스 -->
    <div id="ice_chk">
        <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        <label for="chkall">전체선택</label>
    </div>
    <!--//-->

    <!-- (목록) 주문정보표시 -->
    <ul>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        // 결제 수단
        $s_receipt_way = $s_br = "";
        if ($row['od_settle_case'])
        {
            $s_receipt_way = $row['od_settle_case'];
            $s_br = '<br>';

            // 간편결제
            if($row['od_settle_case'] == '간편결제') {
                switch($row['od_pg']) {
                    case 'lg':
                        $s_receipt_way = 'PAYNOW';
                        break;
                    case 'inicis':
                        $s_receipt_way = 'KPAY';
                        break;
                    case 'kcp':
                        $s_receipt_way = 'PAYCO';
                        break;
                    default:
                        $s_receipt_way = $row['od_settle_case'];
                        break;
                }
            }
        }
        else
        {
            $s_receipt_way = '결제수단없음';
            $s_br = '<br>';
        }

        if ($row['od_receipt_point'] > 0)
            $s_receipt_way .= "/포인트";

        $mb_nick = get_sideview($row['mb_id'], get_text($row['od_name']), $row['od_email'], '');

        $od_cnt = 0;
        if ($row['mb_id'])
        {
            $sql2 = " select count(*) as cnt from {$g5['g5_shop_order_table']} where mb_id = '{$row['mb_id']}' ";
            $row2 = sql_fetch($sql2);
            $od_cnt = $row2['cnt'];
        }

        // 주문 번호에 device 표시 2016-01-01수정추가 모바일구매건은 아이콘으로 변경
        $od_mobileicon = '';
        if($row['od_mobile'])
            $od_mobileicon = '<img src="'.G5_ADMIN_URL.'/img/icon_mobile.gif" title="모바일주문">';

        // 주문번호에 - 추가
        switch(strlen($row['od_id'])) {
            case 16:
                $disp_od_id = substr($row['od_id'],0,8).'-'.substr($row['od_id'],8);
                break;
            default:
                $disp_od_id = substr($row['od_id'],0,6).'-'.substr($row['od_id'],6);
                break;
        }

        // 주문 번호에 에스크로 표시
        $od_paytype = '';
        if($row['od_test'])
            $od_paytype .= '<span class="list_test">테스트</span>';

        if($default['de_escrow_use'] && $row['od_escrow'])
            $od_paytype .= '<span class="list_escrow">에스크로</span>';

        $uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);

        $invoice_time = is_null_time($row['od_invoice_time']) ? G5_TIME_YMDHIS : $row['od_invoice_time'];
        $delivery_company = $row['od_delivery_company'] ? $row['od_delivery_company'] : $default['de_delivery_company'];

		// 몇일전등으로 표시
		$diff = time() - strtotime($row['od_time']);
		if($diff < 60) $nr_datetime = "<span class=today_date2><i class='fas fa-check-circle'></i>".$diff."초전</span>";
		else if( $diff < 3600 && $diff > 59) $nr_datetime = "<span class=today_date2><i class='fas fa-check-circle'></i>".round($diff/60)."분전</span>";
		else if( 86400 > $diff && $diff > 3599 ) $nr_datetime = "<span class=today_date><i class='fas fa-check-circle'></i>".round($diff/3600)."시간전</span>";
		//else if( 604800 > $diff && $diff > 86399 ) $nr_datetime = round($diff/86400). "일전</span>";
		else if( 604800 > $diff && $diff > 86399 ) $nr_datetime = "<span class=today_date><i class='far fa-check-circle'></i>".round($diff/86400)."일전</span>";//최대7일
		else if( 1296000 > $diff && $diff > 604799 ) $nr_datetime = "<span class=date><i class='far fa-check-circle'></i>".round($diff/86400)."일전</span>";//최대15일
        else if( 2592000 > $diff && $diff > 1295999 ) $nr_datetime = "<span class=date><i class='far fa-check-circle'></i>".round($diff/86400)."일전</span>";//최대30일
		else $nr_datetime = "<span class='darkgray font-11'>".substr($row['od_time'],0,10)."</span> <span class='gray font-11'>". substr($row['od_time'],11,18)."</span>"; //날짜,시간으로 표시

        $bg = 'ice_list_';
        $td_color = 0;
        if($row['od_cancel_price'] > 0 && $row['od_cancel_price'] == $row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2'] && $row['od_status'] !== '완료') { //전체취소
            $bg .= 'cancel';
            $td_color = 1;
        } else if($row['od_cancel_price'] > 0 && $row['od_cancel_price'] < $row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2'] && $row['od_status'] !== '완료') { //부분취소
		    $bg .= 'cancel2';
            $td_color = 1;
		} else if($row['od_status'] == '배송') { //배송중 - 옐로우로 눈에띄게
		    $bg .= 'delivery';
            $td_color = 1;
		} else if($row['od_status'] == '완료') { //완료
		    $bg .= 'finish';
            $td_color = 1;
		} else { //그외전체 기본박스색상
		    $bg .= 'basic';
            $td_color = 1;
		}

        // wetoz : naverpayorder
        $is_naverapi = false;
        if ($row['od_naver_orderid']) {
            $is_naverapi = true;
        }
        // wetoz : naverpayorder
    ?>
    <style>
    /* [토글] 메모 */
    .ice_list_memo<?php echo $row['od_id'];?> {display: none; padding:15px; border:solid 1px #93BDFB; background:#FAFBFE; margin-top:-9px; margin-bottom:8px;}
    </style>

    <li class="<?php echo $bg; ?>">
        <!-- (1단 타이틀) 주문번호 -->
        <div class="listtitle">
            <div class="listtitle_right">
			    <!-- 현재상태표시 시작 { -->
                <input type="hidden" name="current_status[<?php echo $i ?>]" value="<?php echo $row['od_status'] ?>">
			    <?php
			    // 오늘,어제 상태변화시킨것 오늘아이콘 표시
		    	// admin.sum_orderdate.php 에 $today, $yesterday 정의함수 있음. 중복지정하면 않됨
			    $od_time = substr($row['od_time'],0,10); //주문시간 (예) 2017-05-01
			    $od_receipt_time = substr($row['od_receipt_time'],0,10); //입금시간 (예) 2017-05-01
			    $od_invoice_time = substr($row['od_invoice_time'],0,10); //배송시간 (예) 2017-05-01
			    ?>
                <?php echo ($od_time == $today || $od_receipt_time == $today || $od_invoice_time == $today) ? '<span class="round_sm_lightorange">오늘</span>' : ''; //오늘표시텍스트아이콘?>
                <?php echo ($od_time == $yesterday && $od_receipt_time !== $today && $od_invoice_time !== $today || $od_receipt_time == $yesterday && $od_time !== $today && $od_invoice_time !== $today|| $od_invoice_time == $yesterday && $od_time !== $today && $od_receipt_time !== $today) ? '<span class="round_sm_gray">어제</span>' : ''; //오늘표시텍스트아이콘?>
			    <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/orderlist.php?od_status=<?php echo $row['od_status']; ?>" title="<?php echo $row['od_status']; ?> 모두보기">
			    <?php echo ($row['od_status'] == '취소') ? '<img src="'.G5_ADMIN_URL.'/img/icon/cancel.png" valign="absmiddle">' : '';//취소아이콘?> <strong><?php echo $row['od_status'];//현재 상태표시?></strong>
                </a>
                <!-- } 현재상태표시 끝 -->
            </div>

            <div class="listtitle_left">
            <?php if (!$is_naverapi) { // wetoz : naverpayorder?>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
            <?php } // wetoz : naverpayorder?>

            <!-- 첫구매고객표시 -->
            <?php echo ($od_cnt == '1') ? '<span class="boxx_dg">첫구매</span>' : '<span class="skyblue font-13">재구매</span>';//첫주문표시?>
            <!--//-->

            <!--주문번호-->
            <input type="hidden" name="od_id[<?php echo $i ?>]" value="<?php echo $row['od_id'] ?>" id="od_id_<?php echo $i ?>"><label for="chk_<?php echo $i; ?>" class="sound_only">주문번호 <?php echo $row['od_id']; ?></label>
            <?php echo $od_mobileicon; //모바일주문시 표시아이콘?>

            <?php if (!$is_naverapi) { // wetoz : naverpayorder?>
                <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/orderform.php?od_id=<?php echo $row['od_id']; ?>&amp;<?php echo $qstr; ?>" class="at-tip" data-original-title="<nobr>주문서보기</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><strong><?php echo $disp_od_id; ?></strong></a>
            <?php } else { ?>
                <a href="./orderformnaverapi.php?od_id=<?php echo $row['od_id']; ?>&amp;<?php echo $qstr; ?>" class="at-tip" data-original-title="<nobr>주문서보기</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><strong><?php echo $disp_od_id; ?></strong></a>
            <?php } // wetoz : naverpayorder ?>

            <?php echo $od_paytype; ?>
            <!--//-->
            </div>

        </div>
        <!--//-->

        <!-- (3단 주문자) 주문자정보 -->
        <div class="dan">
            <?php echo $mb_nick; //회원정보?>
            <?php if ($row['mb_id']) { //회원일경우 회원아이디 표시?>
            <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?sort1=<?php echo $sort1; ?>&amp;sort2=<?php echo $sort2; ?>&amp;sel_field=mb_id&amp;search=<?php echo $row['mb_id']; ?>">(<?php echo $row['mb_id']; ?>)</a>
            <?php } else { ?>
            (비회원구매)
            <?php } ?>
            <?php echo get_text($row['od_hp']); //전화번호?>
        </div>
        <!--//-->

        <!-- (4단 표) [표]가격 및 바로가기 -->
        <div class="li_prqty">

            <div class="prqty_price li_prqty_sp"><div class="tit">주문합계</div>
			    <?php if($row['od_mobile']) { //모바일아이콘표시 ?><?php echo $od_mobileicon; ?> <?php } ?>
		        <span class="td_numsum"><?php echo number_format($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']); ?></span>
                <?php if($row['od_send_cost']) { //배송비표시 ?>
		            <br><span class="tack_cost" title="배송비 <?php echo number_format($row['od_send_cost'] + $row['od_send_cost2']); ?>원"><?php echo number_format($row['od_send_cost'] + $row['od_send_cost2']); ?></span>
		        <?php } else { //무료배송 ?>
		            <br><span class="tack_freecost" title="무료배송">무료배송</span>
		        <?php } ?>
            </div>

            <div class="prqty_price li_prqty_sp"><div class="tit">주문취소</div>
			    <?php echo ($row['od_cart_price'] > $row['od_cancel_price'] && $row['od_cancel_price'] > 0) ? '<span class="tack_pcancle">부분취소</span><br>' : ''; //부분취소표시?>
		        <span class="td_numcancel<?php echo $td_color; ?>"><?php echo ($row['od_cancel_price']) ? number_format($row['od_cancel_price']) : '-'; //취소금액?></span>
            </div>

            <div class="prqty_price li_prqty_sp"><div class="tit">쿠폰</div>
                <?php echo ($row['couponprice']) ? '<span class="td_numcoupon"><strong>'.number_format($row['couponprice']).'</strong></span>' : '-'; //쿠폰금액?>
            </div>

            <div class="prqty_price li_prqty_sp"><div class="tit">주문상품/누적주문</div>
			    <?php echo $row['od_cart_count']; ?>개/<?php echo $od_cnt; ?>건<br>
                <?php echo $nr_datetime; //몇일전으로표시 ?>

            </div>

            <div class="prqty_price li_prqty_sp"><div class="tit">배송회사</div>
            <?php if ($od_status == '준비') { ?>
                <select name="od_delivery_company[<?php echo $i; ?>]">
                    <?php echo get_delivery_company($delivery_company); ?>
                </select>
            <?php } else { ?>
            <?php

				echo "<span class='at-tip' data-original-title='<nobr>";
				echo (is_null_time($row['od_invoice_time']) ? '' : substr($row['od_invoice_time'],0,16));//배송등록일자
				echo " 발송</nobr>' data-toggle='tooltip' data-placement='bottom' data-html='true'>";
				echo ($row['od_delivery_company'] ? $row['od_delivery_company'] : '');//배송회사
				echo "</span>";
            ?>
            <?php } ?>
            </div>

            <div class="prqty_price li_prqty_sp"><div class="tit">운송장번호</div>
            <?php if ($od_status == '준비') { ?>
                <input type="hidden" name="od_invoice_time[<?php echo $i; ?>]" value="<?php echo $invoice_time; ?>">
                <input type="text" name="od_invoice[<?php echo $i; ?>]" value="<?php echo $row['od_invoice']; ?>" class="frm_input" size="14">
            <?php } else { ?>
            <?php
                //echo ($row['od_invoice'] ? $row['od_invoice'] : '-');
				echo "<span class='at-tip' data-original-title='<nobr>";
				echo (is_null_time($row['od_invoice_time']) ? '' : substr($row['od_invoice_time'],0,16));//배송등록일자
				echo " 발송</nobr>' data-toggle='tooltip' data-placement='bottom' data-html='true' style='color:#FF648A;'>";
                echo get_delivery_list_inquiry($row['od_delivery_company'], $row['od_invoice'], 'dvr_link');
				echo "</span>";
            ?>
            <?php } ?>
            </div>

        </div>
        <!--//-->

        <!-- (4단 받는분) 수령자정보 -->
        <div class="dan2">
            [받는분] <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?sort1=<?php echo $sort1; ?>&amp;sort2=<?php echo $sort2; ?>&amp;sel_field=od_b_name&amp;search=<?php echo get_text($row['od_b_name']); ?>"><i class="fas fa-user-plus skyblue"></i><b><?php echo get_text($row['od_b_name']); ?></b></a>
            <?php echo get_text($row['od_b_hp']); //받는분전화번호?>
            <?php echo get_text($row['od_b_addr1']); //주소1?><?php echo get_text($row['od_b_addr2']); //주소2?><?php echo get_text($row['od_b_addr3']); //주소3?>

        </div>
        <!--//-->

        <!-- (5단 합계금액) -->
        <div class="li_total">
            <!-- 결제금액 -->
            <div class="total_price total_span">
                <div class="tit"><input type="hidden" name="current_settle_case[<?php echo $i ?>]" value="<?php echo $row['od_settle_case'] ?>"><?php echo $s_receipt_way; ?> <?php echo ($s_receipt_way == '무통장' || $s_receipt_way == '무통장/포인트') ? '입금액' : '결제금액'; //문구?> </div>
                <?php if($row['od_mobile'] && $row['od_receipt_price'] > '0') { //모바일아이콘표시 ?><?php echo $od_mobileicon; ?><?php } ?>
                <?php echo ($row['od_receipt_price']) ? '<strong>'.number_format($row['od_receipt_price']).'</strong>' : '-'; //입금액?>
                <?php if($row['od_receipt_price'] > '0') { //결제방식표시 ?>
                    <input type="hidden" name="current_settle_case[<?php echo $i ?>]" value="<?php echo $row['od_settle_case'] ?>">
                    <span class="tack_pay" title="<?php echo $s_receipt_way; ?>으로 결제(입금)완료"><?php echo $s_receipt_way; ?></span>
		        <?php } ?>
                <?php if($row['od_receipt_point'] > '0') { //포인트결제금액 ?>
                    <span class="round_cnt_blue">P</span> <span class="tack_point_none"><?php echo number_format($row['od_receipt_point']); //포인트결제금액 ?></span>
                <?php } ?>
            </div>
            <!--//-->

            <!-- 미수금 -->
            <?php if($row['od_misu'] > '0') { //미수금이있을때만표시 ?>
            <div class="total_point total_span"><div class="tit blue">미수금</div>
		    <?php if($row['od_mobile'] && $row['od_misu'] > '0') { //모바일아이콘표시 ?><?php echo $od_mobileicon; ?><?php } ?>
            <?php echo ($row['od_misu']) ? '<strong class="td_numrdy">'.number_format($row['od_misu']).'</strong>' : '-'; //미수금액?>
            <?php if($row['od_misu'] > '0') { //입금확인 ?>
                <?php if (!$is_naverapi) { // wetoz : naverpayorder?>
                    <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/orderform.php?od_id=<?php echo $row['od_id']; ?>&amp;<?php echo $qstr; ?>#anc_sodr_paymo" class="at-tip" data-original-title="<nobr>입금확인되셨나요?<br>입금내역을 기재해주세요!</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true">
                        <span class="tack_account">입금확인</span>
                    </a>
                <?php } else { ?>
                    <a href="./orderformnaverapi.php?od_id=<?php echo $row['od_id']; ?>&amp;<?php echo $qstr; ?>" class="at-tip" data-original-title="<nobr>입금확인되셨나요?<br>입금내역을 기재해주세요!</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true">
                        <span class="tack_account">입금확인</span>
                    </a>
                <?php } // wetoz : naverpayorder ?>
		    <?php } else if($row['od_misu'] < '0') { //취소환불금액입력 ?>
                <?php if (!$is_naverapi) { // wetoz : naverpayorder?>
                    <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/orderform.php?od_id=<?php echo $row['od_id']; ?>&amp;<?php echo $qstr; ?>#anc_sodr_paymo" class="at-tip" data-original-title="<nobr>취소하셨나요?<br>취소금액을 기재해주세요!</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true">
                        <span class="tack_refund">취소입력</span>
                    </a>
                <?php } else { ?>
                    <a href="./orderformnaverapi.php?od_id=<?php echo $row['od_id']; ?>&amp;<?php echo $qstr; ?>" class="at-tip" data-original-title="<nobr>취소하셨나요?<br>취소금액을 기재해주세요!</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true">
                        <span class="tack_refund">취소입력</span>
                    </a>
                <?php } // wetoz : naverpayorder ?>
		    <?php } ?>
            </div>
            <?php } //미수금이있을때만표시 ?>
            <!--//-->
        </div>
        <!--//-->
        <div class="li_total">
            <div class="total_price total_span">
                <?php

                   $sql = " select ct_id, it_id, ct_price, ct_point, ct_qty, ct_option, ct_status, cp_price, ct_stock_use, ct_point_use, ct_send_cost, io_type, io_price
                                    from {$g5['g5_shop_cart_table']}
                                    where od_id = '{$row['od_id']}'
                                    order by io_type asc, ct_id asc ";
                    $cart_rst = sql_query($sql);

                    for($j=0; $ct=sql_fetch_array($cart_rst); $j++) {
                        $image = get_it_image($ct['it_id'], 50, 50);

                        // 상품의 옵션정보
                        //$res = sql_query($sql);
                        $rowspan = sql_num_rows($res);
                        echo $image;
                        echo " / ";
                        echo get_text($ct['ct_option']);
                        echo " / ";
                        echo $ct['ct_qty'];
                        echo "개   ";


                    }
                ?>

            </div>
        </div>
        <!-- (6단 버튼) -->
        <div id="ice_list_btn">
            <div class="ice_list_btn_basic">
            <!--주문서보기 버튼-->
            <?php if (!$is_naverapi) { // wetoz : naverpayorder?>
                <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/orderform.php?od_id=<?php echo $row['od_id']; ?>&amp;<?php echo $qstr; ?>" class="at-tip" data-original-title="<nobr>주문서보기</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true"><i class="fas fa-search-plus darkgray"></i></a>
            <?php } else { ?>
                <a href="./orderformnaverapi.php?od_id=<?php echo $row['od_id']; ?>&amp;<?php echo $qstr; ?>" class="at-tip" data-original-title="<nobr>주문서보기</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true"><i class="fas fa-search-plus darkgray"></i></a>
            <?php } // wetoz : naverpayorder ?>
            <!--상품보기 버튼-->
            <input type="hidden" name="od_id[<?php echo $i ?>]" value="<?php echo $row['od_id'] ?>" id="od_id_<?php echo $i ?>">
            <a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>" class="orderitem at-tip" data-original-title="<nobr>주문상품<br>미리보기</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true"><i class="fas fa-shopping-basket darkgray"></i></a>
            <!--메모보기 버튼(토글)-->
            <?php if ($row['od_shop_memo']) { //메모가있을경우 ?>
            <div class="memobtn" onclick="$('.ice_list_memo<?php echo $row['od_id'];?>').toggle()"><i class="fas fa-edit"></i></div>
            <?php } ?>
            </div>
        </div>
        <!--//-->
    </li>

    <!-- 토글 -->
    <div class="ice_list_memo<?php echo $row['od_id'];?>">
        <?php echo nl2br($row['od_shop_memo']); ?>
    </div>
    <!--//-->

    <?php //페이지합계산출을 위한 계산식
        $tot_itemcount     += $row['od_cart_count'];//상품갯수 소계
        $tot_orderprice    += ($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']);//주문금액 소계
        $tot_ordercancel   += $row['od_cancel_price'];//취소금액 소계
		$tot_orderrefund   += $row['od_refund_price'];//환불금액 소계
        $tot_receiptprice  += $row['od_receipt_price'] - $row['od_refund_price']; //총결제금액 = 입금액 - 환불금액
        $tot_couponprice   += $row['couponprice'];//쿠폰할인가격 소계
        $tot_misu          += $row['od_misu'];//미결제 미수금 소계
		$tot_cost          += ($row['od_send_cost'] + $row['od_send_cost2']);//배송비 소계
		$tot_soon_price    += ($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2'] - $row['od_cancel_price'] - $row['couponprice'] - $row['od_misu'] - $row['od_receipt_point']);//순매출액 소계(배송비차감)

		//$tot_soon_price    += ($row['od_receipt_price'] - $row['od_cancel_price']);

		//$tot_soon_price    += ($row['od_cart_price'] - $row['od_cancel_price'] - $row['couponprice'] - $row['od_send_cost'] - $row['od_send_cost2'] - $row['od_misu']);
	?>

    <?php
	} // for문 끝
    sql_free_result($result);

    if ($i == 0) {
        echo '<li class="empty_list">주문목록이 없습니다.</li>';
    }
    ?>

    </ul>
</div><!-- 주문목록전체 감싸기 닫기 { -->


<!-- (소계) [표] 현재 페이지 소계 -->
<div class="li_subtot">

    <div class="subtot_price li_subtot_sp"><div class="tit">상품갯수 소계</div>
        <?php echo number_format($tot_itemcount); //상품갯수 소계?>개
    </div>

    <div class="subtot_price li_subtot_sp"><div class="tit">주문금액 소계</div>
        <?php echo number_format($tot_orderprice); //주문금액 소계?>
    </div>

    <div class="subtot_price li_subtot_sp"><div class="tit">결제완료 소계</div>
        <b><?php echo number_format($tot_receiptprice); //입금금액 소계?></b>
    </div>

    <div class="subtot_price li_subtot_sp"><div class="tit">쿠폰할인 소계</div>
        <b class="darkgreen"><?php echo number_format($tot_couponprice); //쿠폰할인 소계?></b>
    </div>

    <div class="subtot_price li_subtot_sp"><div class="tit">미수금 소계</div>
        <b class="blue"><?php echo number_format($tot_misu); //미수금 소계?></b>
    </div>

    <div class="subtot_price li_subtot_sp"><div class="tit">취소/환불 소계</div>
        <span class="lightpink"><?php echo number_format($tot_ordercancel); //취소 소계?></span>/<span class="pink"><?php echo number_format($tot_orderrefund); //환불 소계?></span>
    </div>

</div>
<!--//-->


<!-- 스크롤시 나타나는 버튼 추가 #scroll_button_order (관련수정 : admin.css파일 272줄부근/admin.head.php 155줄부근 스크립트) -->
<?php if (($od_status == '' || $od_status == '완료' || $od_status == '전체취소' || $od_status == '부분취소' || $od_status == '취소') == false) { // (1) 검색된 주문상태가 '전체', '완료', '전체취소', '부분취소' 가 아니라면 ?>
<div id="scroll_button_order" style="display:none; padding-left:10px; padding-right:10px;">
    <div class="btn_scroll_text btn_list" style="color:#000;">
    <strong>선택주문상태변경&nbsp;</strong>
    <?php
    $change_status = "";
    if ($od_status == '주문') $change_status = "입금";
    if ($od_status == '입금') $change_status = "준비";
    if ($od_status == '준비') $change_status = "배송";
    if ($od_status == '배송') $change_status = "완료";
    ?>
    <input type="checkbox" name="od_status" value="<?php echo $change_status; ?>" id="od_status">
    <label for="od_status">'<?php echo $od_status ?>'상태에서 '<b><?php echo $change_status ?></b>'상태로 변경합니다&nbsp;&nbsp;</label>
    <?php if($od_status == '주문' || $od_status == '준비') { ?>
    <input type="checkbox" name="od_send_mail" value="1" id="od_send_mail">
    <label for="od_send_mail" style="color:#FF3300; font-size:11px; letter-spacing:-1px;"><?php echo $change_status; ?>안내메일</label>
    <input type="checkbox" name="send_sms" value="1" id="od_send_sms">
    <label for="od_send_sms" style="color:#FF3300; font-size:11px; letter-spacing:-1px;"><?php echo $change_status; ?>안내SMS</label>
    <?php } ?>
    <?php if($od_status == '준비') { ?>
    <input type="checkbox" name="send_escrow" value="1" id="od_send_escrow">
    <label for="od_send_escrow" style="color:#FF3300; font-size:11px; letter-spacing:-1px;">에스크로배송등록</label>
    <?php } ?>
    &nbsp;&nbsp;<input type="submit" value="선택변경" onclick="document.pressed=this.value">


    <?php if($od_status == '주문') { ?>

    <input type="submit" value="선택삭제" onclick="document.pressed=this.value">

	<?php } ?>

    <?php if($od_status == '준비') { ?>

    <input type="button" value="송장Excel일괄등록" onclick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/orderdelivery_EXCEL.php'">

	<?php } ?>
    </div>
</div>
<?php } else if ($od_status == '전체취소') { //(2) 전체취소일경우 삭제버튼 ?>
<div id="scroll_button_order" style="display:none; padding-left:10px; padding-right:10x;">
    <div class="btn_scroll_text btn_list" style="color:#000;">
    <strong>선택주문상태변경&nbsp;</strong>
    입금액이 없는 입금대기(주문)과 전체취소 주문만 삭제가능합니다&nbsp;
    <input type="submit" value="선택삭제" onclick="document.pressed=this.value">
    </div>
</div>
<?php } else { //(3) 수정/삭제없는 안내문구 ?>
<div id="scroll_button_order" style="display:none; padding-left:10px; padding-right:10px;">
    <div class="btn_scroll_text" style="color:#000;">
    <strong>주문상태로 검색하면 목록에서 주문상태를 변경할 수 있습니다&nbsp;</strong>
    <input type="button" value="입금대기" onclick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/orderlist.php?od_status=주문'">
    <input type="button" value="입금완료" onclick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/orderlist.php?od_status=입금'">
    <input type="button" value="준비중" onclick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/orderlist.php?od_status=준비'">
    <input type="button" value="배송중" onclick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/orderlist.php?od_status=배송'">
    </div>

    <div class="btn_scroll_pc btn_list" style="color:#000; border-left:solid 1px #FEE598; margin-left:10px; padding-left:13px;">
    <input type="button" value="주문서일괄출력" onclick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/orderprint.php'">
    <input type="button" value="송장Excel등록" onclick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/orderdelivery_EXCEL.php'">
    </div>
</div>
<?php } //(4) 선택수정/삭제 바 완료?>
<!--//-->

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<div class="local_desc01 local_desc">
<p>
    &lt;무통장&gt;인 경우에만 &lt;주문&gt;에서 &lt;입금&gt;으로 변경됩니다. 가상계좌는 입금시 자동으로 &lt;입금&gt;처리됩니다.<br>
    &lt;준비&gt;에서 &lt;배송&gt;으로 변경시 &lt;에스크로배송등록&gt;을 체크하시면 에스크로 주문에 한해 PG사에 배송정보가 자동 등록됩니다.<br>
    <strong>주의!</strong> 주문번호를 클릭하여 나오는 주문상세내역의 주소를 외부에서 조회가 가능한곳에 올리지 마십시오.
</p>
</div>

<!-- 주문서일괄출력 링크 버튼 -->
<div class="btn_Big01 btn_add">
    <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/orderprint.php"><i class="fa fa-print fa-lg"></i> 주문서일괄출력</a>
</div>
<!-- // -->

<div style=" display:block;height:350px;"></div>

<script>
$(function(){
    $("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });

    // 주문상품보기
    $(".orderitem").on("click", function() {
        var $this = $(this);
        var od_id = $this.text().replace(/[^0-9]/g, "");

        if($this.next("#orderitemlist").size())
            return false;

        $("#orderitemlist").remove();

        $.post(
            "./ajax/ajax.orderitem.php",
            { od_id: od_id },
            function(data) {
                $this.after("<div id=\"orderitemlist\"><div class=\"itemlist\"></div></div>");
                $("#orderitemlist .itemlist")
                    .html(data)
                    .append("<div id=\"orderitemlist_close\"><button type=\"button\" id=\"orderitemlist-x\" class=\"btn_frmline\">닫기</button></div>");
            }
        );

        return false;
    });

    // 상품리스트 닫기
    $(".orderitemlist-x").on("click", function() {
        $("#orderitemlist").remove();
    });

    $("body").on("click", function() {
        $("#orderitemlist").remove();
    });

    // 엑셀배송처리창
    $("#order_delivery").on("click", function() {
        var opt = "width=600,height=450,left=10,top=10";
        window.open(this.href, "win_excel", opt);
        return false;
    });
});

function set_date(today)
{
    <?php
    $date_term = date('w', G5_SERVER_TIME); // 일단위
    $week_term = $date_term + 7; //일주일단위
    $last_term = strtotime(date('Y-m-01', G5_SERVER_TIME)); // 매월1일기준
	$month_term = strtotime(date('Y-m-d', G5_SERVER_TIME)); // 매월 오늘날짜 기준
    ?>
    if (today == "오늘") {
        document.getElementById("fr_date").value = "<?php echo G5_TIME_YMD; ?>";
        document.getElementById("to_date").value = "<?php echo G5_TIME_YMD; ?>";
    } else if (today == "어제") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
    } else if (today == "이번주") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-'.$date_term.' days', G5_SERVER_TIME)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
    } else if (today == "이번달") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-01', G5_SERVER_TIME); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
    } else if (today == "지난주") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-'.$week_term.' days', G5_SERVER_TIME)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', strtotime('-'.($week_term - 6).' days', G5_SERVER_TIME)); ?>";
    } else if (today == "지난달") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-01', strtotime('-1 Month', $last_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-t', strtotime('-1 Month', $last_term)); ?>";
	} else if (today == "1주일") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-7 days', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
	} else if (today == "1개월") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-1 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";

	} else if (today == "3개월") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-3 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
	} else if (today == "6개월") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-6 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
	} else if (today == "1년") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-12 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
	} else if (today == "전체") {
        document.getElementById("fr_date").value = "";
        document.getElementById("to_date").value = "";
    }
}
</script>

<script>
function forderlist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    /*
    switch (f.od_status.value) {
        case "" :
            alert("변경하실 주문상태를 선택하세요.");
            return false;
        case '주문' :

        default :

    }
    */

    if(document.pressed == "선택삭제") {
        if(confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            f.action = "./orderlistdelete.php";
            return true;
        }
        return false;
    }

    var change_status = f.od_status.value;

    if (f.od_status.checked == false) {
        alert("주문상태 변경에 체크하세요.");
        return false;
    }

    var chk = document.getElementsByName("chk[]");

    for (var i=0; i<chk.length; i++)
    {
        if (chk[i].checked)
        {
            var k = chk[i].value;
            var current_settle_case = f.elements['current_settle_case['+k+']'].value;
            var current_status = f.elements['current_status['+k+']'].value;

            switch (change_status)
            {
                case "입금" :
                    if (!(current_status == "주문" && current_settle_case == "무통장")) {
                        alert("'주문' 상태의 '무통장'(결제수단)인 경우에만 '입금' 처리 가능합니다.");
                        return false;
                    }
                    break;

                case "준비" :
                    if (current_status != "입금") {
                        alert("'입금' 상태의 주문만 '준비'로 변경이 가능합니다.");
                        return false;
                    }
                    break;

                case "배송" :
                    if (current_status != "준비") {
                        alert("'준비' 상태의 주문만 '배송'으로 변경이 가능합니다.");
                        return false;
                    }

                    var invoice      = f.elements['od_invoice['+k+']'];
                    var invoice_time = f.elements['od_invoice_time['+k+']'];
                    var delivery_company = f.elements['od_delivery_company['+k+']'];

                    if ($.trim(invoice_time.value) == '') {
                        alert("배송일시를 입력하시기 바랍니다.");
                        invoice_time.focus();
                        return false;
                    }

                    if ($.trim(delivery_company.value) == '') {
                        alert("배송업체를 입력하시기 바랍니다.");
                        delivery_company.focus();
                        return false;
                    }

                    if ($.trim(invoice.value) == '') {
                        alert("운송장번호를 입력하시기 바랍니다.");
                        invoice.focus();
                        return false;
                    }

                    break;
            }
        }
    }

    if (!confirm("선택하신 주문서의 주문상태를 '"+change_status+"'상태로 변경하시겠습니까?"))
        return false;

    f.action = "./orderlistupdate.php";
    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>