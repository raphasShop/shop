<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div class="customer_title_wrap">
    <div class="customer_main_title">고객센터</div>
    <div class="customer_sub_title">Store</div>
</div>
<div id="store_pc_wrap">
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
    <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=notice"><div class="top_menu_pc_button">Notice</div></a><a href="<?php echo G5_BBS_URL ?>/faq.php"><div class="top_menu_pc_button">FAQ</div></a><a href="<?php echo G5_SHOP_URL ?>/membership.php"><div class="top_menu_pc_button">Membership</div></a><a href="<?php echo G5_SHOP_URL ?>/store.php"><div class="top_menu_pc_button menu_select">Store</div></a>
</div>

<div id="store_list">
    <div class="store_item">
        <div class="store_title">아리따움 Live</div>
        <div class="store_sub_title">강남점, 신촌점</div>
    </div>
    <div class="store_item">
        <div class="store_title">Lohp's</div>
        <div class="store_sub_title">전국매장</div>
    </div>
    <div class="store_item">
        <div class="store_title">랄라블라</div>
        <div class="store_sub_title">전국매장</div>
    </div>
    <div class="store_item">
        <div class="store_title">삐에로</div>
        <div class="store_sub_title">전국매장</div>
    </div>
    <div class="store_item">
        <div class="store_title">시코르</div>
        <div class="store_sub_title">전국매장</div>
    </div>
    <div class="store_item">
        <div class="store_title">아트박스</div>
        <div class="store_sub_title">고속터미널점 포함 일부 대표 매장</div>
    </div>
    <div class="store_item">
        <div class="store_title">판도라</div>
        <div class="store_sub_title">전국매장</div>
    </div>
    <div class="store_item">
        <div class="store_title">현대백화점</div>
        <div class="store_sub_title">&nbsp;</div>
    </div>
    <div class="store_item">
        <div class="store_title">신세계백화점</div>
        <div class="store_sub_title">&nbsp;</div>
    </div>
    <div class="store_item">
        <div class="store_title">롯데백화점</div>
        <div class="store_sub_title">&nbsp;</div>
    </div>
</div>
</div>
