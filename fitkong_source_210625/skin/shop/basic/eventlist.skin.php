<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div class="shop_event_wrap">
<div class="shop_title_wrap" >
	<div class="shop_title_image"><img src="<?php echo G5_IMG_URL ?>/event_title.png"></div>
    <div class="shop_main_title">다양한 이벤트에 참여하고 특별한 혜택을 누리세요!</div>
    <div class="shop_sub_title"></div>
    <?php if($is_admin) { echo "<a href=".G5_BBS_URL."/board.php?bo_table=event><div class='shop_admin_btn'>핏콩이벤트 관리자</div></a>"; } ?>
</div>
<div id="eventlist_pc_wrap">
<?php echo latest('event', 'event',50,50);?>
</div>
</div>

