<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>

<div id="hd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>


    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_MOBILE_PATH.'/newwin.inc.php'; // 팝업레이어
    } ?>

    <a id="snbOpen"><b><i class="xi-bars menuIcon" aria-hidden="true"></i> <span class="sound_only">사이드메뉴 열기</span></b></a>

    <nav id="gnb">
        <h2>메인메뉴</h2>
        <div class="gnb_wrap">
            <div id="logo">
                <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_IMG_URL ?>/acropass_logo.png?0122" alt="<?php echo $config['cf_title']; ?>"></a>
            </div>
            <ul>
                <li class="allSchBoxWr">
                    <a  href="javascript:void(0)" onclick="openNav()"><button type="button" id="btnSchbox" title="전체검색 열기"><i class="xi-search"></i></button></a>
                </li>
                <li class="allSchBoxWr">
                    <a href="<?php echo G5_SHOP_URL ?>/cart.php"><button type="button" id="btnCartbox" title="장바구니 열기"><i class="xi-cart"></i></button></a>
                </li>
            </ul>
        </div>

        <p class="clb"></p>
    </nav>
</div>
<aside id="topSpacer"><?php /* !!지우지마세요 : 상단메뉴 고정 시 사용됩니다. */?></aside>
<aside id="sideBarCover"><?php /* mobile nav cover !!지우지마세요 : 모바일 화면에서 출력되는 메뉴배경입니다. */?></aside>
<!-- } 상단 끝 --><hr>

<!-- 콘텐츠 시작 { -->



<div id="ctWrap">

<?php if (!defined("_INDEX_")) {  /*인덱스에서 사용하지 않음*/ ?>
    <div id="container">
<?php }  //인덱스에서 사용하지 않음?>