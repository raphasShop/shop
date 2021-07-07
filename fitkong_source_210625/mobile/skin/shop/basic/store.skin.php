<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div id="top_menu_wrap">
    <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=notice"><div class="top_menu4_button">Notice</div></a><a href="<?php echo G5_BBS_URL ?>/faq.php"><div class="top_menu4_button">FAQ</div></a><a href="<?php echo G5_SHOP_URL ?>/membership.php"><div class="top_menu4_button">Membership</div></a><a href="<?php echo G5_SHOP_URL ?>/store.php"><div class="top_menu4_button menu_select">Store</div></a>
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

