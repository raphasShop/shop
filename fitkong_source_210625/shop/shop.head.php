<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_SHOP_PATH.'/shop.head.php');
    return;
}

include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
?>

<!-- 상단 시작 { -->
<div id="pchd">
    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
    ?>
    <section id="top_menu">
    <div id="hd_wrapper">

        <div class="logo">
            <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_IMG_URL ?>/logo.png" alt="<?php echo $config['cf_title']; ?>"></a>
        </div>

        <?php if($member['mb_id']) { ?>
        <div class="login_area">
            <a href="<?php echo G5_BBS_URL ?>/faq.php"><span class="login">고객센터</span></a><span class="sep-line">|</span><a href="<?php echo G5_SHOP_URL ?>/mypage.php"><span class="login"><?php echo $member['mb_name'] ?> 님</span></a>
             <?php if($is_admin) { ?> <span class="sep-line">|</span><a href="<?php echo G5_URL ?>/adm"><span class="register">관리자</span></a> <?php } else { ?><span class="sep-line">|</span><a href="<?php echo G5_BBS_URL ?>/logout.php"><span>로그아웃</span></a><?php } ?>
        </div>
        <?php } else { ?>
        <div class="coupon_popup_area">
            <img src="<?php echo G5_IMG_URL ?>/coupon_popup.png?210610">
        </div>
        <div class="login_area">
            <a href="<?php echo G5_BBS_URL ?>/faq.php"><span class="login">고객센터</span></a><span class="sep-line">|</span>
            <a href="<?php echo G5_BBS_URL ?>/login.php"><span class="login">로그인</span></a>
            <span class="sep-line">|</span>
            <a href="<?php echo G5_BBS_URL ?>/register.php"><span class="login">회원가입</span></a>
        </div>
        <?php } ?>

        <div class="search_area">
            <div class="search_wrap">
              <form name="frmdetailsearch" action="search.php" id="frmsearch" onsubmit="return searchSubmit();">
              <input type="hidden" name="qsort" id="qsort" value="<?php echo $qsort ?>">
              <input type="hidden" name="qorder" id="qorder" value="<?php echo $qorder ?>">
              <input type="hidden" name="qcaid" id="qcaid" value="<?php echo $qcaid ?>">
              <input class="search_input" id="searchText" name="q"><div class="search_submit"><img src="<?php echo G5_IMG_URL ?>/search-icon.png" onclick="return searchSubmit();"></div>
              </form>
            </div>
            <div class="cart_wrap">
                <a href="<?php echo G5_SHOP_URL ?>/cart.php"><img src="<?php echo G5_IMG_URL ?>/cart-icon.png" class="search_cart_icon"></a>
            </div>
        </div>
    
    </div>
    <div id="hd_menu_bar">
       <a href="<?php echo G5_SHOP_URL ?>/brand.php"><div class="top_menu_text">핏콩 소개</div></a>
       <div class="top_menu_sep_line">|</div>
       <a href="<?php echo G5_SHOP_URL ?>"><div class="top_menu_text">핏콩 마켓</div></a>
       <div class="top_menu_sep_line">|</div>
       <a href="<?php echo G5_SHOP_URL ?>/community.php"><div class="top_menu_text">커뮤니티</div></a>
       <div class="top_menu_sep_line">|</div>
       <a href="<?php echo G5_SHOP_URL ?>/eventlist.php"><div class="top_menu_text">핏콩 이벤트</div></a>
       <div class="top_menu_sep_line">|</div>
       <a href="<?php echo G5_SHOP_URL ?>/review.php"><div class="top_menu_text">핏콩 리뷰</div></a>
    </div>
    </section>
   
</div>
<!-- } 상단 끝 -->


<!-- 콘텐츠 시작 { -->

<script>

var searchSubmit = function searchSubmit() {
  var q = document.getElementById( 'searchText' ).value;
  if(!q) {
    alert("검색어를 입력해주세요!");
    return false;
  } else {
    document.getElementById('frmsearch').submit();
  }
}


</script>

   