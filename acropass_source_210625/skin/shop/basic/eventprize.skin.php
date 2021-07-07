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
<div id="eventprize_pc_wrap">
<div id="eventprize_top_menu">
    <a href="<?php echo G5_SHOP_URL ?>/eventlist.php"><div class="top_menu_pc_button">진행중인 이벤트</div></a><a href="<?php echo G5_SHOP_URL ?>/eventprize.php"><div class="top_menu_pc_button menu_select">당첨자발표</div></a><a href="<?php echo G5_SHOP_URL ?>/eventclose.php"><div class="top_menu_pc_button">종료된 이벤트</div></a>
</div>

<div id="eventprize_wrap">
    <div class="eventprize_index">
        <div class="index_notice"></div>
        <div class="index_title">제목</div>
        <div class="index_date">이벤트기간</div>
    </div>
    <div class="eventprize_list">
        <div class="event_notice">당첨자발표</div>
        <div class="event_title"><a href="#">SNS 인증 할인 쿠폰 이벤트!</a></div>
        <div class="event_date">2017.11.01 ~ 2017.11.15</div>
    </div>
    <div class="eventprize_list">
        <div class="event_notice">당첨자발표</div>
        <div class="event_title"><a href="#">수험생 응원 댓글 이벤트</a></div>
        <div class="event_date">2017.11.01 ~ 2017.11.15</div>
    </div>
    <div class="eventprize_list">
        <div class="event_notice">당첨자발표</div>
        <div class="event_title"><a href="#">트러블큐어 1+1 구매 이벤트</a></div>
        <div class="event_date">2017.08.01 ~ 2017.08.31</div>
    </div>
    
</div>
</div>
