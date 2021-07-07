<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div class="customer_title_wrap">
    <div class="customer_main_title">고객센터</div>
    <div class="customer_sub_title">Membership</div>
</div>
<div id="membership_pc_wrap">
<div id="customer_contact_info">
    <div class="contact_info_logo"><img src="<?php echo G5_IMG_URL ?>/ac-acropass-logo.png?0122"></div>
    <div class="contact_info">
        <p class="contact_call">고객문의 <span>070-7712-2015</span></p>
        <p class="contact_time">평일 10:00~18:00, 점심시간 12:00~13:00</p>
        <p class="contact_mail">sales@raphas.com</p>
    </div>
    <div class="contact_btn_wrap">
        <a href="http://pf.kakao.com/_CrTxgu" target="_blank"><div class="contact_btn_kakao">카카오톡<br>상담</div></a>
        <a href="<?php echo G5_BBS_URL ?>/qalist.php"><div class="contact_btn_1on1">1:1 문의</div></a>
    </div> 
</div>
<div id="customer_top_menu">
    <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=notice"><div class="top_menu_pc_button">Notice</div></a><a href="<?php echo G5_BBS_URL ?>/faq.php"><div class="top_menu_pc_button">FAQ</div></a><a href="<?php echo G5_SHOP_URL ?>/membership.php"><div class="top_menu_pc_button menu_select">Membership</div></a><a href="<?php echo G5_SHOP_URL ?>/store.php"><div class="top_menu_pc_button">Store</div></a>
</div>
<div id="membership_list">
    <div class="membership_title">아크로패스 등급별 혜택</div>
    <div class="membership_sub_title">&middot; 회원별 등급 변경 조건 충족 시 해당 등급으로 업그레이드 됩니다.</div>
    <div class="membership_table">
        <div class="membership_level">
            <div class="level_title">회원 등급</div><div class="level_normal">실버</div><div class="level_best">골드</div><div class="level_vip">VIP</div>
        </div>
        <div class="membership_condition">
            <div class="level_title">등급 변경<br>조건</div><div class="level_normal">가입 시<br>기본 설정</div><div class="level_best">10만원 이상<br>구매 시</div><div class="level_vip">30만원 이상<br>구매시</div>
        </div>
        <div class="membership_advantage">
            <div class="level_title">멤버쉽<br>혜택</div><div class="level_normal">적립금 3%</div><div class="level_best">적립금 5%</div><div class="level_vip">적립금 7%</div>
        </div>
    </div>
</div>
</div>