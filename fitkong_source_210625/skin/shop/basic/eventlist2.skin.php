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

<a href="https://d1wwy9ao3iinzu.cloudfront.net/img/banner/PC/acpc_home_banner12_edit.jpg" type="image/jpeg" download>다운로드</a>

</div>
