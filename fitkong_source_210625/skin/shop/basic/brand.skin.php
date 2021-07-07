<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div class="brand_wrap">
<div class="brand_bg1">
	<div class="brand_item_wrap">
		<div class="brand_item1"><img src="<?php echo G5_IMG_URL ?>/pc_brand_img1.png"></div>
	</div>
</div>
<div class="brand_bg2">
	<div class="brand_item_wrap">
		<div class="brand_item2"><img src="<?php echo G5_IMG_URL ?>/pc_brand_img2.png"></div>
	</div>
</div>

</div>

