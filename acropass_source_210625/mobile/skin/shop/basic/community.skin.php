<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<div id="community_list">
    <a href="<?php echo G5_SHOP_URL ?>/communitydetail.php?cm_no=1">
    <div class="community_item">
        <img src="<?php echo G5_IMG_URL; ?>/community01.jpg">
        <p class="community_tag">#피부건조 #여드름 #홍조</p>
        <p class="community_title">상황별 피부 진정 꿀팁!</p>
    </div>
    </a><a href="<?php echo G5_SHOP_URL ?>/communitydetail.php?cm_no=2">
    <div class="community_item">
        <img src="<?php echo G5_IMG_URL; ?>/community02.jpg">
        <p class="community_tag">#트러블큐어 #꽃케이 #꿀피부</p>
        <p class="community_title">365일 받을 수 있는 혜택,<br> 여기 다 모였다!</p>
    </div>
    </a><a href="<?php echo G5_SHOP_URL ?>/communitydetail.php?cm_no=3">
    <div class="community_item">
        <img src="<?php echo G5_IMG_URL; ?>/community03.jpg">
        <p class="community_tag">#소개팅 #응급처치</p>
        <p class="community_title">선착순 이벤트,<br> 아크로패스의 Pink한 그녀는 누구?</p>
    </div>
    </a><a href="<?php echo G5_SHOP_URL ?>/communitydetail.php?cm_no=4">
    <div class="community_item">
        <img src="<?php echo G5_IMG_URL; ?>/community04.jpg">
        <p class="community_tag">#면접프리패스 #얼굴도 #스펙이다</p>
        <p class="community_title">아크로패스 친구추천 이벤트,<br> 15% 할인 쿠폰 증정!</p>
    </div>
    </a><a href="<?php echo G5_SHOP_URL ?>/communitydetail.php?cm_no=5">
    <div class="community_item">
        <img src="<?php echo G5_IMG_URL; ?>/community05.jpg">
        <p class="community_tag">#명절증후군 #지친피부 #원상회복</p>
        <p class="community_title">플러스친구 이벤트,<br> 2000원 할인 쿠폰 증정!</p>
    </div>
    </a>
    
</div>

