<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div id="top_sub_gnb">
    <div class="top_sub_wrap">이벤트 신청</div>
    <div class="top_back_btn"><a href="javascript:history.back();"><i class="xi-angle-left"></i></a></div>
</div>

<div id="eventapply_con">
	<div class="eventapply_con_block">
		<form action="<?php echo G5_SHOP_URL; ?>/eventapply_update.php" id="evtfrm" method="POST">
		<input type="hidden" name="evt_id" value="<?php echo $evt_id; ?>">
		<img src="<?php echo G5_IMG_URL; ?>/event/detail+page/bomi_sign_logo.jpg" class="eventapply_backimg">
		<div class="eventapply_blockline">
			<div class="eventapply_li_title">1. 참여 대상을 선택해주세요</div>
			<div class="eventapply_li_check_text"><div class="checks"><input type="checkbox" name="evt_chk" id="evt_chk"><label for="evt_chk"><h4 class="eventapply_li_check_lg_text">구매고객</h4><h4 class="eventapply_li_check_sm_text">(배송비 제외 30,000원 이상 구매시 응모가능)</h4></label> </div> </div>
			<div class="eventapply_li_check_text"><div class="checks"><input type="checkbox" name="evt_chk2" id="evt_chk2"><label for="evt_chk2"><h4 class="eventapply_li_check_lg_text">비구매고객</h4></label></div></div>
			<div class="eventapply_li_input_text"><input type="text" placeholder="리그램 URL 주소를 붙여넣기 해주세요" class="eventapply_input" name="eventapply_input" id="eventapply_input"></div>
 			<div class="eventapply_li_bullet">• 둘다 해당 시 모두 체크해주세요</div>
 			<div class="eventapply_sep_line">&nbsp;</div>
 			<div class="eventapply_li_title">2. 개인정보 이용동의서</div>
 			<div class="eventapply_li_text">고객은 개인정보 이용에 대하여 동의를 거부를 거부할 권리가 있으며, 개인정보 이용에 대한 미동의시 이벤트에 신청할 수 없습니다. 동의하시겠습니까?</div>
 			<div class="eventapply_li_check_text"><div class="checks"><input type="checkbox" name="evt_chk3" id="evt_chk3"><label for="evt_chk3"><h4 class="eventapply_li_check_lg_text">네. 동의합니다.</h4></label> </div> </div>
			<div class="eventapply_li_text_up">윤보미 사인회 당첨안내는 10월 31일에 당첨된 분들에게만 문자로 개별 안내 될 예정입니다.</div>
			<div class="eventapply_li_check_text"><div class="checks"><input type="checkbox" name="evt_chk4" id="evt_chk4"><label for="evt_chk4"><h4 class="eventapply_li_check_lg_text">확인 하였습니다.</h4></label> </div> </div>
			<div class="eventapply_submit"><button class="eventapply_submit_btn" id="eventapply_btn">이벤트 응모하기</button></div>
		</div>
		</form>
		<!--
		<img src="<?php echo G5_IMG_URL; ?>/event/detail+page/bomi_sign_desc_msg.jpg" class="eventapply_descmsg">
		<div class="eventapply_sm_descmsg">현장에서 선착순 20분을 추가 선정 후<br>팬싸인회 참여 기회를 드립니다!</div>
		-->
		<div class="eventapply_desc_blockline">
			<img src="<?php echo G5_IMG_URL; ?>/event/detail+page/bomi_sign_desc_title.jpg" class="eventapply_desctitle">
			<div class="eventapply_desccon">1) 팬사인회 응모는 공식몰 회원만 가능합니다.</div>
			<div class="eventapply_desccon">2) 팬사인회는 <span>오후 1시가 지나면 바로 종료</span>됩니다.</div>
		    <div class="eventapply_sm_desccon">(팬사인회 시작 30분전 미리 대기해주시길 권장드립니다.)</div>
			<div class="eventapply_desccon">3) 본행사는 악기후, 천재지변 혹은 진행사 사정에 따라 일부 변경 또는 취소될 수도 있습니다.</div>
			<div class="eventapply_desccon">4) 팬사인회 당첨은 <span>당첨자 본인만 가능하며, </span>관련 모든 권한 및 자격은 타인에게 양도가 불가능합니다.</div>
			<div class="eventapply_sm_desccon">(본인 확인 불가시 입장에 제한이 있을 수 있습니다)</div>
			<div class="eventapply_desccon">5) 팬사인회 순서는 현장에서 본인확인 후 <span>선착순으로 줄을 서주시면 됩니다.</span></div>
			<div class="eventapply_desccon">6) 정해진 시간 동안 행사가 원활히 진행되기 위해 한분당 시간 제한이 있음을 양해부탁드립니다.</div>
			<div class="eventapply_desccon">7) 진행요원의 안내 및 지시에 따르지 않을 시 <span>퇴장조치 될 수 있습니다.</span></div>
			<div class="eventapply_desccon">8) 네이버페이 결제시 입금 확인되어 응모가 가능하기까지 다소 시간이 소요될 수 있습니다.</div>
		</div>
	</div>
    
</div>

