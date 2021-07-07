<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/index.php');
    return;
}

define("_INDEX_", TRUE);

include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/swiper_pc.css">', 0);
?>
<?php if($member['mb_id']) {} else { ?>
<a href="<?php echo G5_BBS_URL ?>/register.php"><div id="float_hd_banner"><img src="<?php echo G5_IMG_URL ?>/acpc_home_top_bn.jpg"></div></a>
<?php } ?>
<div id="pc_shop_container">
    <div class="shop_title_wrap" style="display: none">
        <div class="shop_main_title">Shop</div>
        <div class="shop_sub_title"></div>
    </div>
    <div class="shop_main_banner">
        <section class="mainBanner">
            <div class="swiper-container banner-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide banner-slide" style="background: #4C3C2D;">
                        <img src="https://acropass2019.s3.ap-northeast-2.amazonaws.com/img/main_banner_back_210601.jpg" style="width:100%;height: 100%;object-fit: cover;">
                        <iframe width="1120" height="630" src="https://www.youtube.com/embed/8uWkR0Y6gOY?autoplay=0&amp;playlist=8uWkR0Y6gOY&amp;loop=1&amp;showinfo=0&amp;rel=0" frameborder="0" allow="accelerometer; autoplay; loop; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="z-index: 10000;outline:10px solid #fff;position: absolute;top:calc(50% - 236.25px);left:calc(50% - 420px);width:840px;height:472.5px;"></iframe>
                    </div>
                    <?php echo display_banner('샵', 'mainbanner.10.skin.php', '10'); ?>
                    <!-- 다이렉트 배너 
                    <div class="swiper-slide banner-slide" style="background: #cca773">
                        <img src="<?php echo G5_IMG_URL ?>/acpc_shop_banner4.jpg" alt="" class="slide-inner">
                        <div class="mainTitle">#주름고민 싹 #선물고민 싹 #가격부담 싹<br>가정의 달 세가지 고민 싹!</div>
                        <div class="subTitle">라인케어 스페셜에디션<br>초특가 2배 구성</div></a>
                        <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1551499616"><div class="mainBannerBtn">자세히보기</div></a>
                    </div>
                    <div class="swiper-slide banner-slide" style="background: #e8d78f">
                        <img src="<?php echo G5_IMG_URL ?>/acpc_shop_banner1.jpg" alt="" >
                        <div class="mainTitle">포토 후기 작성하면<br>더블 적립금 혜택 </div>
                        <div class="subTitle">신규회원 가입 시 적립금 2,000원 + 포토후기 1,000원<br>지금작성하면 더블 적립금 혜택이!!</div>
                        <a href="<?php echo G5_SHOP_URL ?>/eventdetail.php?ev_no=2"><div class="mainBannerBtn">자세히보기</div></a>
                    </div>
                    <div class="swiper-slide banner-slide" style="background: #f8f6f7">
                            <img src="<?php echo G5_IMG_URL ?>/acpc_shop_banner2.jpg" alt="" class="slide-inner">
                            <div class="mainTitle">트러블 SOS #동전패치<br>트러블 큐어 </div>
                            <div class="subTitle">손 안대고 끝내는<br>트러블 원스탑 토탈케어</div>
                            <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1551578034"><div class="mainBannerBtn">자세히보기</div></a>
                    </div>
                    <div class="swiper-slide banner-slide" style="background: #f2eac5">
                        <img src="<?php echo G5_IMG_URL ?>/acpc_shop_banner3.jpg" alt="" class="slide-inner">
                        <div class="mainTitle">다크서클탈출템 #팬더탈출<br>언더아이케어 </div>
                        <div class="subTitle">피부속 탄력부터 튼튼하게 채워<br>중력을 거스르는 피부탄력을 회복하세요</div>
                        <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1551498754"><div class="mainBannerBtn">자세히보기</div></a>
                    </div>
                    <div class="swiper-slide banner-slide" style="background: #e7d942">
                        <img src="<?php echo G5_IMG_URL ?>/acpc_shop_banner5.jpg" alt="" class="slide-inner">
                        <div class="mainTitle">색소침착엔 #멜라닌뿌셔<br>스팟이레이저 </div>
                        <div class="subTitle">피부 속 색소 침착 근본원인 해결</div>
                        <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1551460184"><div class="mainBannerBtn">자세히보기</div></a>
                    </div>
                    <div class="swiper-slide banner-slide" style="background: #d1b07d">
                        <img src="<?php echo G5_IMG_URL ?>/acpc_shop_banner6.jpg" alt="" class="slide-inner">
                        <div class="mainTitle">피부를 촘촘히 채워주는 #REAL FILLING<br>에이지리스리프터 </div>
                        <div class="subTitle">내 피부를 촘촘히 채워 탱탱한 피부로 완성</div>
                        <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1551499976"><div class="mainBannerBtn">자세히보기</div></a>
                    </div>
                    -->

                </div>
                <div class="swiper-pagination main-banner-number"></div>
                <div class="main-banner-right swiper-button-next "><i class="xi-angle-right-thin"></i></div>
                <div class="main-banner-left swiper-button-prev "><i class="xi-angle-left-thin"></i></div>
                <!-- Add Arrows -->
               
            </div>
        </section>
    </div>
    <div class="best_product_area">
         <div class="shop-best-filter">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">베스트셀러 TOP5</li>
                <li class="tab-link" data-tab="tab-2">온라인 혜택제품</li> 
            </ul>               
        </div>   
        <section class="bestProduct5 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s" data-wow-offset="1">
            <div id="tab-1" class="tab-content current">
                <?php
                    $skin = G5_SHOP_SKIN_PATH.'/main.10.skin.php'; // 스킨
                    $sql = " select * from {$g5['g5_shop_item_table']} where it_type4 = '1' AND it_use = '1' and it_5 != '1' order by it_1, it_id asc ";
                    $list = new item_list();
                    $list->set_list_skin($skin);
                    $list->set_list_mod(5);
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
            <div id="tab-2" class="tab-content">
                <?php
                    $skin = G5_SHOP_SKIN_PATH.'/main.10.skin.php'; // 스킨
                    $sql = " select * from {$g5['g5_shop_item_table']} where it_type1 = '1' AND it_use = '1' and it_5 != '1' order by it_2, it_order, it_id asc ";
                    $list = new item_list();
                    $list->set_list_skin($skin);
                    $list->set_list_mod(5);
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
            </section>
    </div>
    <div class="event_banner_area wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s" data-wow-offset="1" >
        <section class="event_banner">
            <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1571199100"><img src="<?php echo G5_IMG_URL ?>/banner/PC/shop_middle_banner.jpg" alt=""></a>
        </section>
    </div>

    <div class="shop_item_area">
        <section class="shop_total_item">
            <?php
                $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' and it_5 != '1' order by it_order, it_id desc ";

                $list->set_query($sql);
                $list->run();
                $count = $list->total_count;
                
            ?>
            <div class="shop-item-filter">
                <div class="shop-item-total-count">총 <span><? echo $count; ?></span> 개</div><div class="shop-item-filter-wrap">
                    <ul class="shop-tabs">
                        <li class="shop-tab-link current" data-tab="shop-tab-1">최신순</li> |
                        <li class="shop-tab-link" data-tab="shop-tab-2">인기순</li> |
                        <li class="shop-tab-link" data-tab="shop-tab-3">높은가격순</li> | 
                        <li class="shop-tab-link" data-tab="shop-tab-4">낮은가격순</li> 
                    </ul>   
                </div>            
            </div>
            <div class="shop-item-list wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s" data-wow-offset="1" > 
                <div id="shop-tab-1" class="shop-tab-content current">
                    <div class="sct_wrap">

                    <?php
                        $skin = G5_SHOP_SKIN_PATH.'/main.10.skin.php'; // 스킨
                        $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' and it_5 != '1' order by it_order, it_id desc ";

                        $list->set_list_skin($skin);
                        $list->set_list_mod(5);
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

                <div id="shop-tab-2" class="shop-tab-content">
                    <div class="sct_wrap">
                        
                    <?php
                        $skin = G5_SHOP_SKIN_PATH.'/main.10.skin.php'; // 스킨
                        $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' and it_5 != '1' order by it_hit desc ";

                        $list->set_list_skin($skin);
                        $list->set_list_mod(5);
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

                 <div id="shop-tab-3" class="shop-tab-content">
                    <div class="sct_wrap">
                        
                    <?php
                        $skin = G5_SHOP_SKIN_PATH.'/main.10.skin.php'; // 스킨
                        $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' and it_5 != '1' order by it_price desc ";

                        $list->set_list_skin($skin);
                        $list->set_list_mod(5);
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

                 <div id="shop-tab-4" class="shop-tab-content">
                    <div class="sct_wrap">
                        
                    <?php
                        $skin = G5_SHOP_SKIN_PATH.'/main.10.skin.php'; // 스킨
                        $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1'  and it_5 != '1' order by it_price asc ";

                        $list->set_list_skin($skin);
                        $list->set_list_mod(5);
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
            </div>
        </section>
    </div>

    <div class="best_review_area">
        <div class="swiper-slide main-vslide">
            <section class="bestReview">
                <div class="swiper-container best-review-container wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s" data-wow-offset="1">
                    <h4><span>#홈더마필러</span><span> #Filling&Feeling</span></h4>
                    <h3>베스트 리뷰</h3>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide best-review-slide">
                            <a href="https://blog.naver.com/by_kry/221484319612" target="_blank">
                            <img src="<?php echo G5_IMG_URL ?>/ac_bestreview_tn_1.jpg" alt="">
                            <div class="review-title">아크로패스 트러블큐어 :) 여드름 빨리없애는법 트러블패치</div>
                            <div class="review-contents">아크로 패스 트러블 큐어는 트러블 부위 케어를 위한 최적의 솔루션으로 유효성분을 피부속으로 직접 침투시켜 트러블의 원인을 제거해준다고...</div>
                            <div class="review-write">란아 <span>|</span> 2019.03.09 <span>|</span> 네이버블로그</div>
                            </a>
                        </div>
                        <div class="swiper-slide best-review-slide">
                            <a href="https://blog.naver.com/parkmybp8933/221391611785" target="_blank">
                            <img src="<?php echo G5_IMG_URL ?>/ac_bestreview_tn_2.jpg" alt="">
                            <div class="review-title">눈 밑 다크서클 때문에 고민이셨다면, 언더아이케어로...</div>
                            <div class="review-contents">잇님들께서는 지금..ㅠ.ㅠ 제 심각한 고민... 흉한 눈밑 다크서클을 보고 계십니다. 헬육아에.. 활동량 많은 미운 세살 아들을 키우다보니...</div>
                            <div class="review-write">유아모델 정민준<span>|</span> 2019.02.27 <span>|</span> 네이버블로그</div>
                            </a>
                        </div>
                        <div class="swiper-slide best-review-slide">
                            <a href="https://blog.naver.com/flowerjjung81/221287704925" target="_blank">
                            <img src="<?php echo G5_IMG_URL ?>/ac_bestreview_tn_3.jpg" alt="">
                            <div class="review-title">아크로패스라인케어 마이크로니들패치로 주름고민 끝!</div>
                            <div class="review-contents">한해 한해... 나이가 먹는게 두려운 요즘... 20대때는 얼른 결혼해서 정착을 하고 안정된 미래를 꿈꿔보았지만... 막상 결혼하고 바쁜 일상 속.. 현실은...</div>
                            <div class="review-write">플라워쩡<span>|</span> 2018.05.30 <span>|</span> 네이버블로그</div>
                            </a>
                        </div>
                        <div class="swiper-slide best-review-slide">
                            <a href="https://jaetoo56.blog.me/221271254096" target="_blank">
                            <img src="<?php echo G5_IMG_URL ?>/ac_bestreview_tn_4.jpg" alt="">
                            <div class="review-title">롭스추천템 아크로패스스팟이레이저로 트러블흔적제거</div>
                            <div class="review-contents">피부가 잠잠하다 싶더니 요 근래 확~ 뒤집어졌어요. ㅠㅠ 연휴동안 집에만 있기 아까워 바다 구경도 할 겸 산지에서 신선한 회도 먹고 오자 하여...</div>
                            <div class="review-write">재투성이 <span>|</span> 2018.05.10 <span>|</span> 네이버블로그</i></div>
                            </a>
                        </div>
                        <div class="swiper-slide best-review-slide">
                            <a href="https://blog.naver.com/mirang1227/221038261075" target="_blank">
                            <img src="<?php echo G5_IMG_URL ?>/ac_bestreview_tn_5.jpg" alt="">
                            <div class="review-title">에이지리스리프터 마이크로니들패치로 눈가주름관리 고고!</div>
                            <div class="review-contents">주름 고민 안 하는 분 계실까요? 물론 어린 아이들이야 예외일 수 있겠지만 나이가 들수록 하나 둘 늘어나는 주름에 신경 쓰일 수 밖에 없는데요...</div>
                            <div class="review-write">뷰스타 네온바니 <span>|</span> 2017.06.27 <span>|</span> 네이버블로그</div>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-button-next review-angle-right"><i class="xi-angle-right"></i></div>
                    <div class="swiper-button-prev review-angle-left"><i class="xi-angle-left"></i></div>
                    
                </div>
            </section>
        </div>
    </div>
    <?php 
        if($member['mb_id'] == 'acropass') {
            $apa_referer = $_SERVER["HTTP_REFERER"];
            echo $apa_referer;
        }    
    ?>
</div>
<script src="<?php echo G5_THEME_URL ?>/js/swiper.min.js"></script>
<script>
var swiper = new Swiper('.banner-container', {
  pagination: {
    el: '.swiper-pagination',
    type: 'fraction',
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  autoplay: {
    delay: 3000,
  },
});
var swiper4 = new Swiper('.best-review-container', {
  slidesPerView: 3,
  spaceBetween: 60,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
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

      $('.shop-tabs li').click(function(){
        var tab_id = $(this).attr('data-tab');
        console.log(tab_id);
     
        $('.shop-tabs li').removeClass('current');
        $('.shop-tab-content').removeClass('current');
     
        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
      })
     
    })
</script>

<?php
include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
?>