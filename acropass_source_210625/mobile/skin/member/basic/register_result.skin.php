<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<div id="top_sub_gnb">
    <div class="top_sub_wrap">회원가입</div>
    <div class="top_back_btn"><a href="javascript:history.back();"><i class="xi-angle-left"></i></a></div>
</div>
<div id="reg_result">
    <div class="register_intro">
        <div class="main_intro"><img src="<?php echo G5_IMG_URL ?>/acropass_logo.png?0122"> 에 오신 것을 환영합니다.</div>
        <div class="sub_intro">가입 후 다양한 혜택을 만나보세요!</div>
    </div>

    <div class="register_celebrate"><span><?php echo get_text($mb['mb_nick']); ?></span> 님 회원가입을 축하합니다.<br>고객님의 Acropass 아이디는 <span><?php echo get_text($mb['mb_id']); ?></span> 입니다.</div>

    <div class="register_result_msg">
        <img src="<?php echo G5_IMG_URL ?>/ac-join-coupon.png"> 
        <div class="result_main_msg">가입 축하 적립금 2,000원이 적립되었습니다.<br>즐거운 쇼핑되세요!</div>
        <div class="result_sub_msg">적립금은 마이페이지에서 확인 가능합니다.</div>
    </div>

    <div class="btn_confirm">
        <a href="<?php echo G5_URL ?>/" class="btn_main">메인으로</a>
    </div>

</div>


<!-- LOGGER(TM) SCRIPT FOR SETTING ENVIRONMENT V.27 :  / FILL THE VALUE TO SET. -->
<script type="text/javascript">
    _TRK_PI = "RGR";
    _TRK_SX = "";
    _TRK_AG = "";
</script>
<!-- END OF ENVIRONMENT SCRIPT -->

<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script> 
<script type="text/javascript"> 
if (!wcs_add) var wcs_add={};
wcs_add["wa"] = "s_396f449064f2";
if (!_nasa) var _nasa={};
_nasa["cnv"] = wcs.cnv("2","1"); // 구매완료 전환 스크립트
wcs_do(_nasa);
</script> 