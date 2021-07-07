<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div class="shop_title_wrap" >
    <div class="shop_main_title">Event</div>
    <div class="shop_sub_title">진행중 이벤트</div>
</div>
<div id="eventdetail_pc_wrap">
<div id="eventdetail_subject_wrap">
    <div class="eventdetail_subject"><?php echo $event_subject; ?></div>
    <div class="eventdetail_date"><?php echo $event_date; ?></div>
</div>
<div id="eventdetail_con">
    <img src="<?php echo G5_IMG_URL; ?>/d_event0<?php echo $evno; ?>.jpg" <?php if($evno == 1) echo "usemap=#imgmap201942819447" ?>>
</div>
<?php if($evno == 4) { ?> 
<div class="eventdetail_bg">
	<!--<img id="btn1" src="<?php echo G5_IMG_URL; ?>/dmo_event0<?php echo $evno; ?>_btn1.jpg">-->
	<a href="<?php echo G5_BBS_URL; ?>/register.php"><img src="<?php echo G5_IMG_URL; ?>/dmo_event0<?php echo $evno; ?>_btn2.jpg"></a>
</div>
<?php } ?>
</div>
<div class="eventdetail_blank"></div>

<map id="imgmap201942819447" name="imgmap201942819447"><area shape="rect" alt="" title="" coords="246,2747,956,2823" href="<?php echo G5_SHOP_URL; ?>/item.php?it_id=1551498754" target="_self" />
