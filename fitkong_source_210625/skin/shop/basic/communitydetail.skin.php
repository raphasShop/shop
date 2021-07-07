<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div class="shop_title_wrap" >
    <div class="shop_main_title">Community</div>
    <div class="shop_sub_title"></div>
</div>
<div id="communitydetail_pc_wrap">
<div id="communitydetail_subject_wrap">
    <div class="communitydetail_subject"><?php echo $community_subject; ?></div>
    <div class="communitydetail_tag"><?php echo $community_tag; ?></div>
</div>
<div id="communitydetail_con">
    <img src="<?php echo G5_IMG_URL; ?>/d_community0<?php echo $cmno; ?>.jpg">
</div>

</div>
