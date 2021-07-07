<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div class="shop_title_wrap" >
    <div class="shop_main_title">Event</div>
    <div class="shop_sub_title"></div>
</div>
<div id="eventlist_pc_wrap">
<div id="eventlist_top_menu">
    <a href="<?php echo G5_SHOP_URL ?>/eventlist.php"><div class="top_menu_pc_button menu_select">진행중인 이벤트</div></a><a href="<?php echo G5_SHOP_URL ?>/eventprize.php"><div class="top_menu_pc_button">당첨자발표</div></a><a href="<?php echo G5_SHOP_URL ?>/eventclose.php"><div class="top_menu_pc_button">종료된 이벤트</div></a>
</div>

<div id="eventlist_wrap">
    <div class="eventlist_item eventlist_left">
        <img src="<?php echo G5_IMG_URL; ?>/event04.jpg">
        <p class="eventlist_title">8월 한 달간, 아크로패스가 준비한 COOL한 혜택!</p>
        <p class="eventlist_date">2018. 8. 16 - 2018. 8. 31</p>
    </div><div class="eventlist_item eventlist_right">
        <img src="<?php echo G5_IMG_URL; ?>/event05.jpg">
        <p class="eventlist_title">아크로패스 설날 혜택전</p>
        <p class="eventlist_date">2018. 8. 16 - 2018. 8. 31</p>
    </div><div class="eventlist_item eventlist_left">
        <img src="<?php echo G5_IMG_URL; ?>/event06.jpg">
        <p class="eventlist_title">아크로패스 2017 수험생을 위한 50% 세일 이벤트</p>
        <p class="eventlist_date">2018. 8. 16 - 2018. 8. 31</p>
    </div><div class="eventlist_item eventlist_right">
        <img src="<?php echo G5_IMG_URL; ?>/event01.jpg">
        <p class="eventlist_title">8월 한 달간, 아크로패스가 준비한 COOL한 혜택!</p>
        <p class="eventlist_date">2018. 8. 16 - 2018. 8. 31</p>
    </div><div class="eventlist_item eventlist_left">
        <img src="<?php echo G5_IMG_URL; ?>/event02.jpg">
        <p class="eventlist_title">아크로패스 설날 혜택전</p>
        <p class="eventlist_date">2018. 8. 16 - 2018. 8. 31</p>
    </div><div class="eventlist_item eventlist_right">
        <img src="<?php echo G5_IMG_URL; ?>/event03.jpg">
        <p class="eventlist_title">아크로패스 설날 혜택전</p>
        <p class="eventlist_date">2018. 8. 16 - 2018. 8. 31</p>
    </div>
</div>
</div>
