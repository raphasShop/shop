<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div id="top_menu_wrap">
    <a href="<?php echo G5_SHOP_URL ?>/eventprize.php"><div class="top_menu3_button">진행중인 이벤트</div></a><a href="<?php echo G5_SHOP_URL ?>/eventprize.php"><div class="top_menu3_button menu_select">당첨자발표</div></a><a href="<?php echo G5_SHOP_URL ?>/eventclose.php"><div class="top_menu3_button">종료된 이벤트</div></a>
</div>

<div id="eventprize_wrap">
    <div class="eventprize_item">
        <img src="<?php echo G5_IMG_URL; ?>/event04.jpg">
        <p class="eventprize_title">8월 한 달간, 아크로패스가 준비한<br>COOL한 혜택!</p>
        <p class="eventprize_date">2018. 8. 16 - 2018. 8. 31</p>
    </div>
    <div class="eventprize_item">
        <img src="<?php echo G5_IMG_URL; ?>/event05.jpg">
        <p class="eventprize_title">아크로패스 설날 혜택전</p>
        <p class="eventprize_date">2018. 8. 16 - 2018. 8. 31</p>
    </div>
    <div class="eventprize_item">
        <img src="<?php echo G5_IMG_URL; ?>/event06.jpg">
        <p class="eventprize_title">아크로패스 2017 수험생을 위한 <br>50% 세일 이벤트</p>
        <p class="eventprize_date">2018. 8. 16 - 2018. 8. 31</p>
    </div>
    <div class="eventprize_item">
        <img src="<?php echo G5_IMG_URL; ?>/event01.jpg">
        <p class="eventprize_title">8월 한 달간, 아크로패스가 준비한<br>COOL한 혜택!</p>
        <p class="eventprize_date">2018. 8. 16 - 2018. 8. 31</p>
    </div>
    <div class="eventprize_item">
        <img src="<?php echo G5_IMG_URL; ?>/event02.jpg">
        <p class="eventprize_title">아크로패스 설날 혜택전</p>
        <p class="eventprize_date">2018. 8. 16 - 2018. 8. 31</p>
    </div>
</div>

