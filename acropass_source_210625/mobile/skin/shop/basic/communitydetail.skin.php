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

<div id="communitydetail_list">
    <div class="communitydetail_subject"><?php echo $community_subject; ?></div>
    <div class="communitydetail_tag"><?php echo $community_tag; ?></div>
    <div class="communitydetail_con">
        <img src="<?php echo G5_IMG_URL; ?>/dmo_community0<?php echo $cmno; ?>.jpg">
    </div>
</div>

