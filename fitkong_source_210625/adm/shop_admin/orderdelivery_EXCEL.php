<?php
######################################################
/*
(1) 배송조회버튼을 2가지로 추가
수정파일 : lib/shop.lib.php 파일의 배송조회생성을 2가지로 변경 추가
2016년2월 관리자 배송조회버튼 분류 추가
*/
######################################################
$sub_menu = '411150'; /* 새로 만든 메뉴 */
include_once('./_common.php');
######################################################
auth_check($auth[$sub_menu], "r");
######################################################
$g5['title'] = '송장 Excel 일괄 등록';
include_once (G5_ADMIN_PATH.'/admin.head.php');
//include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
######################################################

$where = array();

######################################################
//주문정보 유출우려 보안소스추가 - 크림장수-2017-01-23
######################################################
$doc = strip_tags($doc);
$sort1 = in_array($sort1, array('od_id', 'od_cart_price', 'od_receipt_price', 'od_cancel_price', 'od_misu', 'od_cash')) ? $sort1 : '';
$sort2 = in_array($sort2, array('desc', 'asc')) ? $sort2 : 'desc';
$sel_field = get_search_string($sel_field);
if( !in_array($sel_field, array('od_id', 'mb_id', 'od_name', 'od_tel', 'od_hp', 'od_b_name', 'od_b_tel', 'od_b_hp', 'od_ip', 'od_deposit_name', 'od_invoice')) ){   //검색할 필드 대상이 아니면 값을 제거
    $sel_field = '';
}
$od_status = get_search_string($od_status);
$search = get_search_string($search);
if(! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = '';
if(! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = '';

######################################################
// 검색결과 산출
######################################################
if ($where) {
    $sql_search = ' where '.implode(' and ', $where);
}

if ($sel_field == "")  $sel_field = "od_name"; //주문분류 최초 선택(현재는 주문자로 되어있음)
if ($sort1 == "") $sort1 = "od_id";
if ($sort2 == "") $sort2 = "desc";

######################################################
// 상품준비중인 주문
######################################################
$sql_common = " from {$g5['g5_shop_order_table']} where od_status = '준비' and od_settle_case != '네이버페이' ";

$sql = " select count(od_id) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];
$total_price = $row['price'];

$rows = $config['cf_page_rows'];
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

//전체보기 echo $listall; - 크림장수
$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'"><button type="button"><i class="fa fa-bars"></i>&nbsp;전체</button></a>';

?>

<div style="padding:15px 0px; line-height:16px;">
택배발송한 내역을 엑셀로 일괄 등록하는 공간입니다. <br />준비상태인 주문건을 다운로드 받아 배송회사/송장번호만 기재해서 올리면 자동으로 배송중으로 변경됩니다. 주문건이 적은 경우에는 온라인상에 하나씩 등록하면 되지만, 주문건이 많거나 택배회사에서 발송내역을 엑셀로 주는 경우 배송회사와 송장번호만 사이트 엑셀 양식으로 옮겨서 한번에 일괄 등록할 수 있도록 하는 곳입니다.
</div>

<section><!-- 배송대상 주문 엑셀 및 송장 엑셀등록 섹션 열기 { -->
<div class="dan-garo1" style="border:solid 5px #9EE5E2; background:#fff; padding:25px 25px 25px;"><!-- 전체박스 열기 { -->

    <!-- @@ (1) 주문내역 다운로드 @@ -->
    <div class="excel_down">
    <h5 style="color:#33CCCC;">STEP1</h5>
    <h5><i class="fa fa-download fa-lg"></i> 배송대상 주문내역 Excel 다운로드</h5>
        <?php if($total_count > '0') { //상품준비중이 있을경우?>
        <div style=" margin:25px 0px;text-align:center; line-height:20px; border:0; cursor:pointer;" class="at-tip" onClick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/orderdeliveryexcel.php'" data-original-title="<nobr>배송대상주문내역<br>Excel 다운로드</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
        <img src="<?php echo G5_ADMIN_URL;?>/img/Exel_down.png">
        <br>
        <br><b class="darkgreen font-14">배송대상주문내역.XLS</b>
        <br><b class="pink font-bold font-14"><?php echo number_format($total_count); ?></b>개의 배송준비중인 주문내역이 있습니다
        </div>
        <?php } else { //없을경우?>
        <div style=" margin:25px 0px;text-align:center; line-height:20px; border:0;" class="at-tip" data-original-title="<nobr>배송대상주문내역이<br>없습니다 (다운로드불가)</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
        <img src="<?php echo G5_ADMIN_URL;?>/img/Exel_down_gray.png">
        <br>
        <br><b class="orangered font-14">배송대상주문내역 없음</b>
        <br><b class="darkgray font-bold font-14"><?php echo number_format($total_count); ?></b>개의 배송준비중인 주문내역이 있습니다
        </div>
        <?php } //닫기?>
        
        <div style="color:#009999;">
            엑셀파일을 다운로드 합니다.<br>
            주문상태가 준비(배송준비중)인 주문만 엑셀파일로 변환됩니다.<br>
            배송회사와 송장번호를 기재하여 업로드하면 됩니다.<br>
            수정 후 <b class="pink">Excel97-2003 통합문서(*.xls)</b> 로 저장합니다.<br>
            수정 후 엑셀파일을 업로드하시면 배송정보가 일괄등록됩니다.<br>
            
        </div>
        
    </div>
    <!-- @@ (1) // @@ -->

    <!-- @@ (2) 송장일괄등록 @@ -->
    <div class="excel_up">
    <h5 style="color:#33CCCC;">STEP2</h5>
    <h5><i class="fa fa-upload fa-lg"></i> 송장 Excel 일괄 등록 <b class="blue font-11">Excel97-2003 통합문서(*.xls)로 저장해서 업로드</b></h5>
    
    <form name="forderdelivery" method="post" action="./orderdeliveryupdate.php" target="sendWin" onsubmit="return submitWin(this);" enctype="MULTIPART/FORM-DATA" autocomplete="off">
    
    <div id="excelfile_upload">
        <label for="excelfile">파일선택</label>
        <input type="file" name="excelfile" id="excelfile">
    </div>

    <div id="excelfile_input">
        <input type="checkbox" name="od_send_mail" value="1" id="od_send_mail" checked="checked">
        <label for="od_send_mail">배송안내 메일</label>
        <input type="checkbox" name="send_sms" value="1" id="od_send_sms" checked="checked">
        <label for="od_send_sms">배송안내 SMS</label>
        <input type="checkbox" name="send_escrow" value="1" id="od_send_escrow">
        <label for="od_send_escrow">에스크로배송등록</label>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="배송정보 등록" class="btn_submit_big">
    </div>
    </form>
    
    <div style="margin-top:35px;color:#4c4c4c; border:solid 1px #d3d3d3; background:#FFF5D7; padding:15px;">
        <b class="violet">[엑셀파일에 택배회사/송장번호 기재시 유의사항]</b><br>
        송장번호를 기재하면 6.87952E+14 같이 변환되는 경우가 있어서, 셀서식을 변경해서<br>저장해 주셔야 합니다.<br>
        (1) 다운받은 엑셀파일을 엽니다.<br>
        (2) 배송회사명과 송장번호 기재후 송장번호 기재한 셀들을 선택해서<br>마우스 우측키를 눌러 <b class="pink">셀서식</b>을 선택합니다.(배송회사명은 <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_delivery.php" style=" text-decoration:underline; color:#0099FF;">배송업체</a> 목록을 참고하세요)<br>
        (3) <b class="pink">표시형식 > 숫자</b> 를 선택후 확인을 눌러 저장합니다.<br>
        
        <b class="violet">[파일저장 및 업로드]</b><br>
        수정 후 <b class="pink">Excel97-2003 통합문서(*.xls)</b> 로 저장합니다.<br>
        송장 Excel 일괄 등록에서 업로드하시면, 자동으로 배송중으로 변경됩니다<br>
    </div>
    
    </div>
    <!-- @@ (2) // @@ -->
    
    <div style="padding:20px 0px 0px; border:0px; line-height:18px;">
    ※ 주문상태 중 "준비"(배송준비중) 상태인 주문내역만 엑셀파일로 변환됩니다.<br>
    ※ 송장 일괄 등록을 위해서는 "준비" 상태의 주문내역 파일을 먼저 다운로드 해야 합니다.<br>
    ※ 입금완료(결제완료) 상태인 주문내역을 "준비"로 변경한 후 주문내역 파일을 다운로드해서 수정 후 업로드하시면 됩니다. <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/orderlist.php?od_status=입금" style="text-decoration:underline; color:#0099FF;">결제완료된 주문내역 보기</a><br>
    </div>

</div><!-- } 전체박스 닫기 //-->
</section><!-- } 배송대상 주문 엑셀 및 송장 엑셀등록 섹션 닫기 //-->


<!-- [배송등록] 바로등록 -->
<div class="darkgray font-12" style="display:block; padding:15px 0px; text-align:center;">
    <i class="fa fa-lightbulb-o fa-lg blue font-12" aria-hidden="true"> 바로등록을 원하시면</i> 송장 엑셀 등록을 하지않고,주문서에서 바로 송장번호를 등록하려면 주문목록으로 이동하세요&nbsp;&nbsp;&nbsp;
    <button class="btn btn-darkgray btn-sm cursor" onClick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/orderlist.php?od_status=준비'">주문서에서 직접등록</button><!-- 바로가기버튼 -->
</div>
<!--//-->


<div class="h5" style=" border-bottom:dotted 1px #ccc; margin:0px 0px 25px;"></div>

<section><!-- 준비상태인 상품목록 섹션 열기 { -->
<!--<h5><i class="fa fa-cubes font-22"></i> 배송준비중 상품 목록</h5>-->

<div style="padding:0px 0px 15px; line-height:16px; text-align:center;">
주문서에서 '준비' 상태의 주문건을 표시합니다. 송장 일괄등록을 하거나 주문서별로 직접 기재하시면 배송중으로 자동 변경되어 목록에서 사라집니다.
</div>

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <span class="orangered font-16">배송준비중</span>인 주문이 <strong><?php echo number_format($total_count); ?></strong> 개 있습니다
	&nbsp;<span class="font-14 blue">￦<?php echo number_format($total_price); ?></span>    
</div>
<!-- // -->
<form name="forderlist" id="forderlist" onsubmit="return forderlist_submit(this);" method="post" autocomplete="off">
<input type="hidden" name="search_od_status" value="<?php echo $od_status; ?>">

<div class="tbl_head02 tbl_wrap">
    <table id="sodr_list">
    <caption>주문 내역 목록</caption>
    <thead>
    <tr>
        <th scope="col" id="th_odrnum" rowspan="2" colspan="2">
        <a href="<?php echo title_sort("od_id", 1)."&amp;$qstr1"; ?>">주문번호</a>
        </th>
        <th scope="col" id="th_odrer"><i class="fa fa-user-o white"></i> 주문자</th>
        <th scope="col" id="th_odrertel">주문자전화</th>
        <th scope="col" rowspan="3" width="100">주문합계<br>선불배송비포함<br>배송비</th>
        <th scope="col" rowspan="3" width="100">입금합계</th>
        <th scope="col" rowspan="3" width="90">주문취소</th>
        <th scope="col" rowspan="3" width="80">쿠폰</th>
        <th scope="col" rowspan="3" width="90">미수금</th>
        <th scope="col" rowspan="3">메모</th>
    </tr>
    <tr>
        <th height="19" id="th_odrid" scope="col">회원ID</th>
        <th scope="col" id="th_odrcnt">주문상품수</th>
    </tr>
    <tr>
        <th scope="col" id="odrstat">주문상태</th>
        <th scope="col" id="odrpay">결제수단</th>
        <th scope="col" id="th_odrid"><i class="fa fa-user-plus skyblue"></i> 받는분</th>
        <th scope="col" id="th_odrcnt">누적주문수</th>
    </tr>
    </thead>
    <tbody style="border-bottom:solid 3px #333;">
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

        $bg = 'bg'.($i%2);
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
		}
    ?>
    <tr class="orderlist<?php echo ' '.$bg; ?>">
        <td headers="th_ordnum" class="td_odrnum2" rowspan="2" colspan="2">
		    <!-- 주문번호 -->
            <input type="hidden" name="od_id[<?php echo $i ?>]" value="<?php echo $row['od_id'] ?>" id="od_id_<?php echo $i ?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only">주문번호 <?php echo $row['od_id']; ?></label>
            <!-- } -->
            <?php echo $od_mobileicon; //모바일주문시 표시아이콘?>
            <a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>" class="orderitem at-tip" data-original-title="<nobr>주문상품목록미리보기</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><?php echo $disp_od_id; ?></a>
            <?php echo $od_paytype; ?>
        </td>
        <td headers="th_odrer" class="td_name" title="주문자로검색"><i class="fa fa-user-o gray"></i> <?php echo $mb_nick; ?></td>
        <td headers="th_odrertel" class="td_tel"><?php echo get_text($row['od_tel']); ?></td>
        <td rowspan="3" class="td_numsum">
		<?php if($row['od_mobile']) { //모바일아이콘표시 ?><?php echo $od_mobileicon; ?><br><?php } ?>
		<?php echo number_format($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']); ?>
        <?php if($row['od_send_cost']) { //배송비표시 ?>
		    <br><span class="tack_cost" title="배송비 <?php echo number_format($row['od_send_cost'] + $row['od_send_cost2']); ?>원"><?php echo number_format($row['od_send_cost'] + $row['od_send_cost2']); ?></span>
		<?php } else { //무료배송 ?>
		    <br><span class="tack_freecost" title="무료배송">무료배송</span>
		<?php } ?>
        </td>
        <td rowspan="3" class="td_numincome">
        <?php if($row['od_mobile'] && $row['od_receipt_price'] > '0') { //모바일아이콘표시 ?><?php echo $od_mobileicon; ?><br><?php } ?>
        <?php echo ($row['od_receipt_price']) ? '<b>'.number_format($row['od_receipt_price']).'</b>' : '-'; //입금액?> 
        <?php if($row['od_receipt_price'] > '0') { //결제방식표시 ?>
            <br>
            <input type="hidden" name="current_settle_case[<?php echo $i ?>]" value="<?php echo $row['od_settle_case'] ?>">
            <span class="tack_pay" title="<?php echo $s_receipt_way; ?>으로 결제(입금)완료"><?php echo $s_receipt_way; ?></span>
		<?php } ?>
        <?php if($row['od_receipt_point'] > '0') { //포인트결제금액 ?>
            <br>
            <span class="round_cnt_blue">P</span> <span class="tack_point_none"><?php echo number_format($row['od_receipt_point']); //포인트결제금액 ?></span>
        <?php } ?>
        </td>
        <td rowspan="3" class="td_numcancel<?php echo $td_color; ?>">
            <?php echo ($row['od_cart_price'] > $row['od_cancel_price'] && $row['od_cancel_price'] > 0) ? '<span class="tack_pcancle">부분취소</span><br>' : ''; //부분취소표시?>
		    <?php echo ($row['od_cancel_price']) ? number_format($row['od_cancel_price']) : '-'; //취소금액?>
        </td>
        <td rowspan="3" class="td_numcoupon"><?php echo ($row['couponprice']) ? '<b>'.number_format($row['couponprice']).'</b>' : '-'; //쿠폰금액?></td>
        <td rowspan="3" class="td_numrdy">
		<?php if($row['od_mobile'] && $row['od_misu'] > '0') { //모바일아이콘표시 ?><?php echo $od_mobileicon; ?><br><?php } ?>
        <?php echo ($row['od_misu']) ? '<b>'.number_format($row['od_misu']).'</b>' : '-'; //미수금액?>
        </td>
        <td rowspan="3" class="td_memoetc"><?php echo $row['od_shop_memo']; ?></td>
    </tr>
    <tr class="<?php echo $bg; ?>">
        <td headers="th_odrid" title="아이디로검색">
            <?php if ($row['mb_id']) { //회원일경우 회원아이디 표시?>
            <?php echo $row['mb_id']; ?>
            <?php } else { ?>
            비회원
            <?php } ?>
        </td>
        <td headers="th_odrcnt"><?php echo $row['od_cart_count']; ?>개</td>
    </tr>
    <!-- 추가행 -->
    <tr class="<?php echo $bg; ?>">
        <td headers="th_odrstat" class="td_odrstatus">
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
			<?php echo $row['od_status'];//현재 상태표시?>
            <?php echo ($row['od_status'] == '취소') ? '<img src="'.G5_ADMIN_URL.'/img/icon/cancel.png" valign="absmiddle">' : '';//취소아이콘?> 
            <!-- } 현재상태표시 끝 --> 
        </td>
        <td headers="th_odrpay" class="td_payby">
            <input type="hidden" name="current_settle_case[<?php echo $i ?>]" value="<?php echo $row['od_settle_case'] ?>">
            <?php echo $s_receipt_way; ?>
        </td>
        <td headers="th_odrid" title="받는분으로검색"><i class="fa fa-user-plus skyblue"></i> <?php echo get_text($row['od_b_name']); ?></td>
        <td headers="th_odrall"><?php echo $od_cnt; ?>건</td>
    </tr>
    <!-- } -->

    
    
    <?php
        $tot_itemcount     += $row['od_cart_count'];
        $tot_orderprice    += ($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']);
        $tot_ordercancel   += $row['od_cancel_price'];
        $tot_receiptprice  += $row['od_receipt_price'] - $row['od_refund_price']; //총결제금액 = 입금액 - 환불금액
        $tot_couponprice   += $row['couponprice'];
        $tot_misu          += $row['od_misu'];
		$tot_cost          += ($row['od_send_cost'] + $row['od_send_cost2']);
		$tot_soon_price    += ($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2'] - $row['od_cancel_price'] - $row['couponprice'] - $row['od_misu'] - $row['od_receipt_point']);
		
		//$tot_soon_price    += ($row['od_receipt_price'] - $row['od_cancel_price']);
		
		//$tot_soon_price    += ($row['od_cart_price'] - $row['od_cancel_price'] - $row['couponprice'] - $row['od_send_cost'] - $row['od_send_cost2'] - $row['od_misu']);
	?>
    <?php
    }
    sql_free_result($result);
    if ($i == 0)
        echo '<tr><td colspan="10" class="empty_table font-14 pink"><b>배송준비중인 주문이 없습니다</b></td></tr>';
    ?>
    </tbody>
    <tfoot>
    <tr class="orderlist">
        <th scope="row" colspan="3">배송준비중인 상품 소계</th>
        <td><?php echo number_format($tot_itemcount); ?>개 상품</td>
        <td><?php echo number_format($tot_orderprice); ?></td>
        <td><?php echo number_format($tot_receiptprice); ?></td>
        <td><?php echo number_format($tot_ordercancel); ?></td>
        <td><?php echo number_format($tot_couponprice); ?></td>
        <td><?php echo number_format($tot_misu); ?></td>
        <td><?php echo number_format($tot_soon_price); ?>
        <!--
		<?php if($tot_cost) { //배송비표시 ?>
		    <span class="tack_cost" title="배송비 <?php echo number_format($tot_cost); ?>원">배송비 <?php echo number_format($tot_cost); ?></span>
		<?php } ?>
        -->
        </td>
    </tr>
    <tr class="orderlist" style="background:#DADADA;">
        <th scope="row" colspan="3">&nbsp;</th>
        <td>주문상품수</td>
        <td>주문합계</td>
        <td>결제금액</td>
        <td>취소금액</td>
        <td>쿠폰할인</td>
        <td>미수금</td>
        <td>순매출액</td>
    </tr>
    </tfoot>
    </table>
</div>
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

</section><!-- } 준비상태인 상품목록 섹션 닫기 -->

<div class="local_desc01 local_desc">
<p>
    &lt;준비&gt; 상태인 주문만 표시됩니다.<br>
    주문서에서 직접 기재 또는 이곳에서 송장일괄등록을 하면, 배송중으로 자동 변경되기에 위의 목록에서 사라집니다.<br>
    <strong>주의!</strong> 준비상태의 주문내역을 다운받아서 송장일괄등록을 하지않고, 임의의 주문서 엑셀을 업로드하면 문제가 생길수 있습니다
</p>
</div>

<script>
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

    /* 엑셀배송처리창 */
    //<![CDATA[ 송장 엑셀 등록처리 (팝업창으로 이동)
    function submitWin(form){
      window.open('',form.target,'width=640,height=450,scrollbars=yes');
      return true;
    }
    //]]>
	

</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>