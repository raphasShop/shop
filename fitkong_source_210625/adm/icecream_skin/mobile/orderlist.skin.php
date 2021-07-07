<?php
if (!defined('_GNUBOARD_')) exit;
//include_once('./_common.php');
#######################################################################################
/* 주문목록 모바일용 [아이스크림 소스] */
// 삽입함수 include_once(G5_ADMIN_PATH.'/icecream_skin/mobile/orderlist.skin.php');
#######################################################################################
?>

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
    ?>
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
                
			    <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/orderlist.php?od_status=<?php echo $row['od_status']; ?>" title="<?php echo $row['od_status']; ?> 모두보기">
			    <?php echo ($row['od_status'] == '취소') ? '<img src="'.G5_ADMIN_URL.'/img/icon/cancel.png" valign="absmiddle">' : '';//취소아이콘?><?php echo $row['od_status'];//현재 상태표시?>
                </a>
                <?php echo ($od_time == $today || $od_receipt_time == $today || $od_invoice_time == $today) ? '<span class="round_sm_lightorange">오늘</span>' : ''; //오늘표시텍스트아이콘?>
                <?php echo ($od_time == $yesterday && $od_receipt_time !== $today && $od_invoice_time !== $today || $od_receipt_time == $yesterday && $od_time !== $today && $od_invoice_time !== $today|| $od_invoice_time == $yesterday && $od_time !== $today && $od_receipt_time !== $today) ? '<span class="round_sm_gray">어제</span>' : ''; //오늘표시텍스트아이콘?>
                <!-- } 현재상태표시 끝 --> 
            </div>
            
            <div class="listtitle_left">
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
            <!--주문번호-->
            <input type="hidden" name="od_id[<?php echo $i ?>]" value="<?php echo $row['od_id'] ?>" id="od_id_<?php echo $i ?>"><label for="chk_<?php echo $i; ?>" class="sound_only">주문번호 <?php echo $row['od_id']; ?></label>
            <?php echo $od_mobileicon; //모바일주문시 표시아이콘?>
            <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/orderform.php?od_id=<?php echo $row['od_id']; ?>&amp;<?php echo $qstr; ?>" class="at-tip" data-original-title="<nobr>주문서보기</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><strong><?php echo $disp_od_id; ?></strong></a>
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
            
            <div class="prqty_price li_prqty_sp"><div>주문합계</div>
			    <?php if($row['od_mobile']) { //모바일아이콘표시 ?><?php echo $od_mobileicon; ?> <?php } ?>
		        <span class="td_numsum"><?php echo number_format($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']); ?></span>
                <?php if($row['od_send_cost']) { //배송비표시 ?>
		            <br><span class="tack_cost" title="배송비 <?php echo number_format($row['od_send_cost'] + $row['od_send_cost2']); ?>원"><?php echo number_format($row['od_send_cost'] + $row['od_send_cost2']); ?></span>
		        <?php } else { //무료배송 ?>
		            <br><span class="tack_freecost" title="무료배송">무료배송</span>
		        <?php } ?>
            </div>
            
            <div class="prqty_price li_prqty_sp"><div>주문취소</div>
			    <?php echo ($row['od_cart_price'] > $row['od_cancel_price'] && $row['od_cancel_price'] > 0) ? '<span class="tack_pcancle">부분취소</span><br>' : ''; //부분취소표시?>
		        <span class="td_numcancel<?php echo $td_color; ?>"><?php echo ($row['od_cancel_price']) ? number_format($row['od_cancel_price']) : '-'; //취소금액?></span>
            </div>
            
            <div class="prqty_price li_prqty_sp"><div>쿠폰</div>
                <?php echo ($row['couponprice']) ? '<span class="td_numcoupon"><strong>'.number_format($row['couponprice']).'</strong></span>' : '-'; //쿠폰금액?>
            </div>
            
            <div class="prqty_price li_prqty_sp"><div>주문상품/누적주문</div>
			    <?php echo $row['od_cart_count']; ?>개/<?php echo $od_cnt; ?>건
            </div>
            
            <div class="prqty_price li_prqty_sp"><div>배송회사</div>
            <?php if ($od_status == '준비') { ?>
                <select name="od_delivery_company[<?php echo $i; ?>]">
                    <?php echo get_delivery_company($delivery_company); ?>
                </select>
            <?php } else { ?>
            <?php
                
				echo "<span class='at-tip' data-original-title='<nobr>";
				echo (is_null_time($row['od_invoice_time']) ? '' : substr($row['od_invoice_time'],0,16));//배송등록일자
				echo " 발송</nobr>' data-toggle='tooltip' data-placement='top' data-html='true'>";
				echo ($row['od_delivery_company'] ? $row['od_delivery_company'] : '');//배송회사
				echo "</span>";
            ?>
            <?php } ?>
            </div>
            
            <div class="prqty_price li_prqty_sp"><div>운송장번호</div>
            <?php if ($od_status == '준비') { ?>
                <input type="hidden" name="od_invoice_time[<?php echo $i; ?>]" value="<?php echo $invoice_time; ?>">
                <input type="text" name="od_invoice[<?php echo $i; ?>]" value="<?php echo $row['od_invoice']; ?>" class="frm_input" size="14">
            <?php } else { ?>
            <?php
                //echo ($row['od_invoice'] ? $row['od_invoice'] : '-');
				echo "<span class='at-tip' data-original-title='<nobr>";
				echo (is_null_time($row['od_invoice_time']) ? '' : substr($row['od_invoice_time'],0,16));//배송등록일자
				echo " 발송</nobr>' data-toggle='tooltip' data-placement='top' data-html='true' style='color:#FF648A;'>";
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
        
        <div class="li_total">
            <!-- 결제금액 -->
            <div class="total_price total_span">
                <div><input type="hidden" name="current_settle_case[<?php echo $i ?>]" value="<?php echo $row['od_settle_case'] ?>"><?php echo $s_receipt_way; ?> 결제완료</div>
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
            <div class="total_point total_span"><div>미수금</div>
		    <?php if($row['od_mobile'] && $row['od_misu'] > '0') { //모바일아이콘표시 ?><?php echo $od_mobileicon; ?><?php } ?>
            <?php echo ($row['od_misu']) ? '<strong class="td_numrdy">'.number_format($row['od_misu']).'</strong>' : '-'; //미수금액?>
            <?php if($row['od_misu'] > '0') { //입금확인 ?>
            <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/orderform.php?od_id=<?php echo $row['od_id']; ?>&amp;<?php echo $qstr; ?>#anc_sodr_paymo" class="at-tip" data-original-title="<nobr>입금확인되셨나요?<br>입금내역을 기재해주세요!</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true">
                <span class="tack_account">입금확인</span>
            </a>
		    <?php } else if($row['od_misu'] < '0') { //취소환불금액입력 ?>
            <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/orderform.php?od_id=<?php echo $row['od_id']; ?>&amp;<?php echo $qstr; ?>#anc_sodr_paymo" class="at-tip" data-original-title="<nobr>취소하셨나요?<br>취소금액을 기재해주세요!</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true">
                <span class="tack_refund">취소입력</span>
            </a>
		    <?php } ?>
            </div>
            <!--//-->
        </div>

    </li>
    <?php
	} // for문 끝
    sql_free_result($result);
	
    if ($i == 0) {
        echo '<li class="empty_list">주문목록이 없습니다.</li>';
    }
    ?>












    </ul>
</div><!-- 주문목록전체 감싸기 닫기 { -->

























<!-- 스크롤시 나타나는 버튼 추가 #scroll-button (관련수정 : admin.css파일 272줄부근/admin.head.php 155줄부근 스크립트) -->
<?php if (($od_status == '' || $od_status == '완료' || $od_status == '전체취소' || $od_status == '부분취소' || $od_status == '취소') == false) { // (1) 검색된 주문상태가 '전체', '완료', '전체취소', '부분취소' 가 아니라면 ?>
<div id="scroll-button" style="display:none; padding-left:10px; padding-right:10px;">
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
<div id="scroll-button" style="display:none; padding-left:10px; padding-right:10x;">
    <div class="btn_scroll_text btn_list" style="color:#000;">
    <strong>선택주문상태변경&nbsp;</strong>
    입금액이 없는 입금대기(주문)과 전체취소 주문만 삭제가능합니다&nbsp;
    <input type="submit" value="선택삭제" onclick="document.pressed=this.value">
    </div>
</div>
<?php } else { //(3) 수정/삭제없는 안내문구 ?>
<div id="scroll-button" style="display:none; padding-left:10px; padding-right:10px;">
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