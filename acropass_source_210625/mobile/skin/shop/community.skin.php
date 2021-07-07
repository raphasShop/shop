<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div id="top_sub_gnb">
    <div class="top_sub_wrap">커뮤니티</div>
    <div class="top_back_btn"><a href="javascript:history.back();"><i class="xi-angle-left"></i></a></div>
</div>

<div id="community_list">
    <div class="community_item">
        <img src="<?php echo G5_IMG_URL; ?>/community01.jpg">
        <p class="community_title">추워죽을 것 같은 피부를 위한 완소템</p>
        <p class="community_date">2018. 8. 16 - 2018. 8. 31</p>
    </div>
    <div class="community_item">
        <img src="<?php echo G5_IMG_URL; ?>/community02.jpg">
        <p class="community_title">추워죽을 것 같은 피부를 위한 완소템</p>
        <p class="community_date">2018. 8. 16 - 2018. 8. 31</p>
    </div>
    <div class="community_item">
        <img src="<?php echo G5_IMG_URL; ?>/community03.jpg">
        <p class="community_title">추워죽을 것 같은 피부를 위한 완소템</p>
        <p class="community_date">2018. 8. 16 - 2018. 8. 31</p>
    </div>
</div>

