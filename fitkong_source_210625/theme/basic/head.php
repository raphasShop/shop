<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

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

$server = ($_SERVER['SERVER_PORT'] != '80' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//$base_filename = basename($server); //현재 페이지 파일명
if(strpos($server,'shop') !== false){
    //파일명에 test가 들어간 경로 접근시
    $shop_menu_select = "menu_bold";
}

if(strpos($server,'event') !== false){
    //파일명에 test가 들어간 경로 접근시
    $shop_menu_select = "";
    $event_menu_select = "menu_bold";
}

if(strpos($server,'community') !== false){
    //파일명에 test가 들어간 경로 접근시
    $shop_menu_select = "";
    $community_menu_select = "menu_bold";
}

if(strpos($server,'brand') !== false){
    //파일명에 test가 들어간 경로 접근시
    $shop_menu_select = "";
    $brand_menu_select = "menu_bold";
}

// 쿠폰
$cp_count = 0;
$sql = " select cp_id
            from {$g5['g5_shop_coupon_table']}
            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."' ";
$res = sql_query($sql);

for($k=0; $cp=sql_fetch_array($res); $k++) {
    if(!is_used_coupon($member['mb_id'], $cp['cp_id']))
        $cp_count++;
}

?>

<!-- 상단 시작 { -->
<div id="pchd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>

   
    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
    ?>
    <div id="tnb" style="display: none;">
        <ul>
            <?php if ($is_member) {  ?>

            <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php"><i class="fa fa-cog" aria-hidden="true"></i> 정보수정</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> 로그아웃</a></li>
            <?php if ($is_admin) {  ?>
            <li class="tnb_admin"><a href="<?php echo G5_ADMIN_URL ?>"><b><i class="fa fa-user-circle" aria-hidden="true"></i> 관리자</b></a></li>
            <?php }  ?>
            <?php } else {  ?>
            <li><a href="<?php echo G5_BBS_URL ?>/register.php"><i class="fa fa-user-plus" aria-hidden="true"></i> 회원가입</a></li>
            <li><a href="<?php echo G5_BBS_URL ?>/login.php"><b><i class="fa fa-sign-in" aria-hidden="true"></i> 로그인</b></a></li>
            <?php }  ?>

            <?php if(G5_COMMUNITY_USE) { ?>
            <li class="tnb_left tnb_shop"><a href="<?php echo G5_SHOP_URL; ?>/"><i class="fa fa-shopping-bag" aria-hidden="true"></i> 쇼핑몰</a></li>
            <li class="tnb_left tnb_community"><a href="<?php echo G5_URL; ?>/"><i class="fa fa-home" aria-hidden="true"></i> 커뮤니티</a></li>
            <?php } ?>

        </ul>
  
    </div>
    <div id="hd_wrapper">

        <div class="logo">
            <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_IMG_URL ?>/ac-acropass-logo.png?0122" alt="<?php echo $config['cf_title']; ?>"></a>
        </div>
        
        <div class="menu">
            <a href="<?php echo G5_URL ?>/shop"><h3 class="<?php echo $shop_menu_select?>">Shop</h3></a>
            <a href="<?php echo G5_SHOP_URL ?>/eventlist.php"><h3 class="<?php echo $event_menu_select?>">Event</h3></a>
            <a href="<?php echo G5_SHOP_URL ?>/brandstory.php"><h3 class="<?php echo $brand_menu_select?>">Brand</h3></a>
            <a href="<?php echo G5_SHOP_URL ?>/community.php"><h3 class="<?php echo $community_menu_select?>">Community</h3></a>
        </div>

        <div class="foreign_language">
            <span><a href="http://en.acropass.com">ENG</a> &middot; <a href="http://cn.acropass.com">中文</a> &middot; <a href="http://jp.acropass.com">日本語</a></span>
        </div>
        
        <a href="<?php echo G5_SHOP_URL ?>/cart.php"><div class="cart_area"><i class="xi-cart"></i></div></a>


        <?php if($member['mb_id']) { ?>
        <a href="<?php echo G5_SHOP_URL ?>/coupon.php"><div class="coupon_area"><i class="xi-coupon"></i><span><?php echo $cp_count; ?></span></div></a>
        <div class="login_area">
            <a href="<?php echo G5_SHOP_URL ?>/mypage.php"><span class="login"><?php echo $member['mb_id'] ?> 님</span></a>
             <?php if($is_admin) { ?> <span class="sep-line">|</span><a href="<?php echo G5_URL ?>/adm"><span class="register">관리자</span></a> <?php } else { ?><span class="sep-line">|</span><a href="<?php echo G5_BBS_URL ?>/logout.php"><span>로그아웃</span></a><?php } ?>
        </div>
        <?php } else { ?>
        <div class="login_area">
            <a href="<?php echo G5_BBS_URL ?>/login.php"><span class="login">로그인</span></a>
            <span class="sep-line">|</span>
            <a href="<?php echo G5_BBS_URL ?>/register.php"><span class="register">회원가입</span></a>
        </div>
        <?php } ?>

        <div class="search_area">
            <div class="search_wrap">
                 <input class="search_input" id="searchText" placeholder="어떤 상품을 찾으세요?"><div class="search_submit"><i class="xi-search" onclick="shopSearch()"></i></div>
            </div>
        </div>
    
    </div>
    
   





   
</div>
<!-- } 상단 끝 -->



<!-- 콘텐츠 시작 { -->

<script>

$(document).ready(function() {
  $('#searchText').focus(function() { 
    window.location.href = '<?php echo G5_SHOP_URL ?>/search.php';
  });

});  

var shopSearch = function shopSearch() {
    window.location.href = '<?php echo G5_SHOP_URL ?>/search.php';
}

</script>

   

