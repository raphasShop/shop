<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<script type="text/javascript">
window.onload = function() {
    document.getElementById('eventapply_btn').onclick = function() {
        document.getElementById('evtfrm').submit();
        return false;
    };
};


</script>

<div class="shop_title_wrap" >
    <div class="shop_main_title">Event</div>
    <div class="shop_sub_title">이벤트 신청</div>
</div>
<div id="eventapply_pc_wrap">
<div id="eventapply_subject_wrap">
    
</div>
<div id="eventapply_con">
	<img src="<?php echo G5_IMG_URL; ?>/event/detail+page/bomi_sign_back.jpg" class="eventapply_backimg">
	<div class="eventapply_con_block">
		<form action="<?php echo G5_SHOP_URL; ?>/eventapply_update.php" id="evtfrm" method="POST">
		<input type="hidden" name="evt_id" value="<?php echo $evt_id; ?>">
		<div class="eventapply_blockline">
			<div class="eventapply_li_title">1. 참여 대상을 선택해주세요</div>
			<div class="eventapply_li_check_text"><div class="checks"><input type="checkbox" name="evt_chk" id="evt_chk"><label for="evt_chk"><h4 class="eventapply_li_check_lg_text">구매고객</h4><h4 class="eventapply_li_check_sm_text">(배송비 제외 30,000원 이상 구매시 응모가능)</h4></label> </div> </div>
			<div class="eventapply_li_check_text"><div class="checks"><input type="checkbox" name="evt_chk2" id="evt_chk2"><label for="evt_chk2"><h4 class="eventapply_li_check_lg_text">비구매고객</h4></label></div></div>
			<div class="eventapply_li_input_text"><input type="text" placeholder="리그램 URL 주소를 붙여넣기 해주세요" class="eventapply_input" name="eventapply_input" id="eventapply_input"></div>
 			<div class="eventapply_li_bullet">• 둘다 해당 시 모두 체크해주세요</div>
 			<div class="eventapply_sep_line">&nbsp;</div>
 			<div class="eventapply_li_title">2. 개인정보 이용동의서</div>
 			<div class="eventapply_li_text">고객은 개인정보 이용에 대하여 동의를 거부를 거부할 권리가 있으며, 개인정보 이용에 대한<br>미동의시 이벤트에 신청할 수 없습니다. 동의하시겠습니까?</div>
 			<div class="eventapply_li_check_text"><div class="checks"><input type="checkbox" name="evt_chk3" id="evt_chk3"><label for="evt_chk3"><h4 class="eventapply_li_check_lg_text">네. 동의합니다.</h4></label> </div> </div>
			<div class="eventapply_li_text_up">윤보미 사인회 당첨안내는 10월 31일에 당첨된 분들에게만 문자로<br>개별 안내 될 예정입니다.</div>
			<div class="eventapply_li_check_text"><div class="checks"><input type="checkbox" name="evt_chk4" id="evt_chk4"><label for="evt_chk4"><h4 class="eventapply_li_check_lg_text">확인 하였습니다.</h4></label> </div> </div>
			<div class="eventapply_submit"><button class="eventapply_submit_btn" id="eventapply_btn">이벤트 응모하기</button></div>
		</div>
		</form>
	</div>
	<img src="<?php echo G5_IMG_URL; ?>/event/detail+page/d_event17_bomi_sign_event2(edit).jpg" class="eventapply_descimg">
    
</div>

</div>
