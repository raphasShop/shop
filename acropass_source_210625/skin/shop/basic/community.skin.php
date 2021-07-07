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
<div id="community_pc_wrap">


<div id="community_wrap">
    <a href="<?php echo G5_SHOP_URL ?>/communitydetail.php?cm_no=1">
    <div class="community_item community_left wow fadeInUp" data-wow-duration="1s" data-wow-delay=".1s" data-wow-offset="1">
        <img src="<?php echo G5_IMG_URL; ?>/community01.jpg">
        <p class="community_tag">#피부건조 &nbsp;#여드름 &nbsp;#홍조</p>
        <p class="community_title">상황별 피부 진정 꿀팁!</p>
    </div></a><a href="<?php echo G5_SHOP_URL ?>/communitydetail.php?cm_no=2"><div class="community_item community_right wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s" data-wow-offset="1">
        <img src="<?php echo G5_IMG_URL; ?>/community02.jpg">
        <p class="community_tag">#트러블큐어 &nbsp;#꽃케이 &nbsp; #꿀피부</p>
        <p class="community_title">러블리즈 꽃케이님 예쁨 ㅠㅠ</p>
    </div></a><a href="<?php echo G5_SHOP_URL ?>/communitydetail.php?cm_no=3"><div class="community_item community_left wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s" data-wow-offset="1">
        <img src="<?php echo G5_IMG_URL; ?>/community03.jpg">
        <p class="community_tag">#소개팅 &nbsp;#응급처치 &nbsp;#시술한줄알아</p>
        <p class="community_title">소개팅 응급처치 방법!</p>
    </div></a><a href="<?php echo G5_SHOP_URL ?>/communitydetail.php?cm_no=4"><div class="community_item community_right wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s" data-wow-offset="1">
        <img src="<?php echo G5_IMG_URL; ?>/community04.jpg">
        <p class="community_tag">#면접프리패스 &nbsp;#얼굴도 &nbsp; #스펙이다</p>
        <p class="community_title">면접 프리패스 뷰티템!</p>
    </div></a><a href="<?php echo G5_SHOP_URL ?>/communitydetail.php?cm_no=5"><div class="community_item community_left wow fadeInUp" data-wow-duration="1s" data-wow-delay=".1s" data-wow-offset="">
        <img src="<?php echo G5_IMG_URL; ?>/community05.jpg">
        <p class="community_tag">#명절증후군 &nbsp;#지친피부 &nbsp;#원상회복</p>
        <p class="community_title">요즘 핫한 뷰티템!</p>
    </div></a>
</div>
</div>
