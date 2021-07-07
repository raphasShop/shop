<?php
include_once('./_common.php');

define("_INDEX_", TRUE);

include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');

add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/main.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 5);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/swiper.css">', 0);
add_stylesheet('<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">', 0);
?>



<script src="<?php echo G5_JS_URL; ?>/swipe.js"></script>
<script src="<?php echo G5_JS_URL; ?>/shop.mobile.main.js"></script>

<?php
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

<?php if($member['mb_id'] && $cp_count > 0) { ?>
<a href="<?php echo G5_SHOP_URL ?>/coupon.php"><div id="float_mohd_banner">사용가능한 쿠폰이 <strong><?php echo $cp_count; ?>개</strong> 있습니다</div></a>   
<?php } else if(!$member['mb_id']){ ?>
<a href="<?php echo G5_BBS_URL ?>/register.php"><div id="float_mohd_banner"><img src="<?php echo G5_IMG_URL ?>/acpc_home_top_bn.jpg"></div></a>
<?php } else { ?>

<?php } ?>

<?php if($member['mb_id'] && $cp_count > 0) { ?>
<section class="mainBanner_withhd">
<?php } else if(!$member['mb_id']) { ?>
<section class="mainBanner_withhd">
<?php } else { ?>
<section class="mainBanner">    
<?php } ?>
    <div class="swiper-container banner-container">
        <div class="swiper-wrapper">
            <?php echo display_banner('샵', 'mainbanner.10.skin.php', '10'); ?>
            <!-- 고정 배너 소스
            <div class="swiper-slide banner-slide">
                 <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1551499616"><img src="<?php echo G5_IMG_URL ?>/acmo_shop_banner4.jpg" alt="">
                <div class="mainTitle">#주름고민 싹#선물고민 싹#가격부담 싹<br>가정의 달 세가지 고민 싹!</div>
                <div class="subTitle">라인케어 스페셜에디션<br>초특가 2배 구성</div></a>
            </div>
            <div class="swiper-slide banner-slide">
                <a href="<?php echo G5_SHOP_URL ?>/eventdetail.php?ev_no=2"><img src="<?php echo G5_IMG_URL ?>/acmo_shop_banner1.jpg" alt="">
                <div class="mainTitle">포토 후기 작성하면<br>더블 적립금 혜택 </div>
                <div class="subTitle">신규회원 가입 시 적립금 2,000원 + 포토후기 1,000원<br>지금작성하면 더블 적립금 혜택이!!</div></a>
            </div>
            <div class="swiper-slide banner-slide">
                <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1551578034"><img src="<?php echo G5_IMG_URL ?>/acmo_shop_banner2.jpg" alt="">
                <div class="mainTitle">트러블 SOS #동전패치<br>트러블 큐어</div>
                <div class="subTitle">손 안대고 끝내는<br>트러블 원스탑 토탈케어</div></a>
            </div>
            <div class="swiper-slide banner-slide">
                <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1551498754"><img src="<?php echo G5_IMG_URL ?>/acmo_shop_banner3.jpg" alt="">
                <div class="mainTitle">다크서클탈출템 #팬더탈출<br>언더아이케어</div>
                <div class="subTitle">피부속 탄력부터 튼튼하게 채워<br>중력을 거스르는 피부탄력을 회복하세요</div></a>
            </div>
            
            <div class="swiper-slide banner-slide">
                 <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1551460184"><img src="<?php echo G5_IMG_URL ?>/acmo_shop_banner5.jpg" alt="">
                <div class="mainTitle">색소침착엔 #멜라닌뿌셔<br>스팟이레이저 </div>
                <div class="subTitle">피부 속 색소 침착 근본원인 해결</div></a>
            </div>
             <div class="swiper-slide banner-slide">
                <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1551499976"><img src="<?php echo G5_IMG_URL ?>/acmo_shop_banner6.jpg" alt="">
                <div class="mainTitle">피부를 촘촘히 채워주는 #REAL FILLING<br>에이지리스리프터 </div>
                <div class="subTitle">내 피부를 촘촘히 채워 탱탱한 피부로 완성</div></a>
            </div>
            -->
        </div>
        <div class="swiper-scrollbar"></div>
        <!-- Add Arrows -->
       
    </div>
</section>

<section class="shopMenu">
    <div class="shop-btn-wrap">
        <a href="<?php echo G5_SHOP_URL ?>/planshop.php"><div class="shop-btn">기획전</div></a>
        <a href="<?php echo G5_SHOP_URL ?>/itemuselist.php"><div class="shop-btn2">상품리뷰</div></a>
    </div>
</section>

  



    <?php if($default['de_mobile_type5_list_use']) { ?>
    <div class="sct_wrap" style="display: none">
        <h2><a href="<?php echo G5_SHOP_URL; ?>/listtype.php?type=5">할인상품</a></h2>
        <?php
        $list = new item_list();
        $list->set_mobile(true);
        $list->set_type(5);
        $list->set_view('it_id', true);
        $list->set_view('it_name', true);
        $list->set_view('it_cust_price', true);
        $list->set_view('it_price', true);
        $list->set_view('it_icon', false);
        $list->set_view('sns', false);
        echo $list->run();
        ?>
    </div>
    <?php } ?>
<section class="shopList">
    <div class="shop-list-menu">
         <?php
            $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' order by it_order, it_id desc ";

            $list->set_query($sql);
            $list->run();
            $count = $list->total_count;
            
        ?>
        <div class="shop-total-count">총 <span><? echo $count; ?></span> 개</div>
        <div class="shop-filter">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">최신순</li> | 
                <li class="tab-link" data-tab="tab-2">인기순</li> 
            </ul>               
         </div>   
    </div>

    <div id="tab-1" class="tab-content current">
        <div class="sct_wrap">

        <?php
            $skin = G5_MSHOP_SKIN_PATH.'/main.10.skin.php'; // 스킨
            $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' order by it_order, it_id desc ";

            $list->set_list_skin($skin);
            $list->set_list_mod(2);
            $list->set_query($sql);
            $list->set_view('it_img', true);
            $list->set_view('it_id', false);
            $list->set_view('it_name', true);
            $list->set_view('it_basic', true);
            $list->set_view('it_cust_price', true);
            $list->set_view('it_price', true);
            $list->set_view('it_icon', false);
            $list->set_view('sns', false);
            echo $list->run();
            $count = $list->total_count;
            
         ?>
        </div> 
    </div>

    <div id="tab-2" class="tab-content">
        <div class="sct_wrap">
            
        <?php
            $skin = G5_MSHOP_SKIN_PATH.'/main.10.skin.php'; // 스킨
            $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' order by it_hit desc ";

            $list->set_list_skin($skin);
            $list->set_list_mod(2);
            $list->set_query($sql);
            $list->set_view('it_img', true);
            $list->set_view('it_id', false);
            $list->set_view('it_name', true);
            $list->set_view('it_basic', true);
            $list->set_view('it_cust_price', true);
            $list->set_view('it_price', true);
            $list->set_view('it_icon', false);
            $list->set_view('sns', false);
            echo $list->run();
            $count = $list->total_count;

         ?>
        </div> 
    </div>
</section>
<script src="<?php echo G5_THEME_URL ?>/js/swiper.min.js"></script>
<script>
var swiper = new Swiper('.banner-container', {
  scrollbar: {
    el: '.swiper-scrollbar',
    clickable: true,
  },
  autoplay: {
    delay: 5000,
  },
});

var swiper2 = new Swiper('.best-product-container', {
  pagination: {
    el: '.swiper-pagination',
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});

var swiper3 = new Swiper('.online-product-container', {
  pagination: {
    el: '.swiper-pagination',
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});

var swiper4 = new Swiper('.best-review-container', {
  slidesPerView: 'auto',
  spaceBetween: 15,
  centeredSlides: true,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
});

var swiper5 = new Swiper('.best-community-container', {
  slidesPerView: 'auto',
  spaceBetween: 15,
  centeredSlides: true,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
});
</script>
<script>
    $(document).ready(function(){
   
      $('.tabs li').click(function(){
        var tab_id = $(this).attr('data-tab');
     
        $('.tabs li').removeClass('current');
        $('.tab-content').removeClass('current');
     
        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
      })
     
    })
</script>
   
<?php
include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
?>