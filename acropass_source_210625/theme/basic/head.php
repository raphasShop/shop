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
    <div id="hd_wrapper">

        <div class="logo">
            <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_IMG_URL ?>/ac-acropass-logo.png?0122" alt="<?php echo $config['cf_title']; ?>"></a>
        </div>
        
        <div id="menu" class="menu">
            <a href="<?php echo G5_URL ?>/shop"><h3 class="<?php echo $shop_menu_select?>">Product</h3></a>
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
            <a href="<?php echo G5_SHOP_URL ?>/mypage.php"><span class="login"><?php if($member['mb_10'] == 'kakaosync') { echo $member['mb_name']; } else { echo $member['mb_id'] ; } ?> 님</span></a>
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

    <div id="hd_snb">
        <div class="sub_menu_wrap">
            <div class="sub_menu_1">
                <!--<div class="sub_menu_title" style="padding:0px">BEST</div>-->
                <div class="sub_menu_title"  style="padding:0px 0px 5px 0">유형별</div>
                <a href="<?php echo G5_SHOP_URL ?>/typesearch.php?qtype=type&q=needle"><div class="sub_menu">마이크로니들</div></a>
                <a href="<?php echo G5_SHOP_URL ?>/typesearch.php?qtype=type&q=skincare"><div class="sub_menu">스킨케어</div></a>
                <div class="sub_menu_title">목적별</div>
                <a href="<?php echo G5_SHOP_URL ?>/typesearch.php?qtype=purpose&q=trouble"><div class="sub_menu">트러블/진정</div></a>
                <a href="<?php echo G5_SHOP_URL ?>/typesearch.php?qtype=purpose&q=whitening"><div class="sub_menu">색소침착/미백</div></a>
                <a href="<?php echo G5_SHOP_URL ?>/typesearch.php?qtype=purpose&q=antiaging"><div class="sub_menu">안티에이징</div></a>
            </div>
            <div class="sub_menu_2">
                <a href="<?php echo G5_SHOP_URL ?>/brandstory.php"><div class="sub_menu_title" style="padding:0px">Brand Story</div></a>
                <a href="<?php echo G5_SHOP_URL ?>/brandtech.php"><div class="sub_menu_title">Core Technology</div></a>
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

$("#menu").hover(function(){
  $("#hd_snb").css("opacity", "1");
  $("#hd_snb").css("transform", "translate3d(0, 0, 0)");
  $("#hd_snb").css("pointer-events", "auto");
  }, function(){
  
});

$("#hd_snb").hover(function(){
  $("#hd_snb").css("opacity", "1");
  $("#hd_snb").css("transform", "translate3d(0, 0px, 0)");
  $("#hd_snb").css("pointer-events", "auto");
  }, function(){
  $("#hd_snb").css("opacity", "0");
  $("#hd_snb").css("transform", "translate3d(0, -124px, 0)");
  $("#hd_snb").css("pointer-events", "none");
});
</script>

   

