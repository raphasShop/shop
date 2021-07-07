<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_MSHOP_PATH.'/shop.head.php');
    return;
}

include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
?>

    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_MOBILE_PATH.'/newwin.inc.php'; // 팝업레이어
    } ?>

<header id="hd">
    <div id="head_wrapper">
        <?php if(!$member['mb_id']) { ?>
        <a href="<?php echo G5_BBS_URL ?>/register.php"><div class="hd_promotion_banner"><img src="<?php echo G5_IMG_URL ?>/mo_line_banner.png?210610"></div></a>
        <?php } ?>
        <div class="hd_gnb_wrap">
            <div class="hd_gnb_logo"><a href="<?php echo G5_URL ?>"><img src="<?php echo G5_IMG_URL ?>/logo.png"></a></div>
            <div class="hd_gnb_menu"><a id="snbOpen"><img src="<?php echo G5_IMG_URL ?>/menu_icon.png"></a></div>
            <div class="hd_gnb_mywrap">
                <a href="<?php echo G5_SHOP_URL ?>/cart.php"><img src="<?php echo G5_IMG_URL ?>/mo_cart_icon.png" class="hd_gnb_cart"></a>
                <a href="<?php echo G5_SHOP_URL ?>/mypage.php"><img src="<?php echo G5_IMG_URL ?>/mo_mypage_icon.png" class="hd_gnb_mypage"></a>
            </div>
        </div>
    </div>
</header>


