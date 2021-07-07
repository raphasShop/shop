<?php
define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가



if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/main.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 5);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/swiper_pc.css">', 0);
?>
<?php if($member['mb_id']) {} else { ?>
<a href="<?php echo G5_BBS_URL ?>/register.php"><div id="float_hd_banner"><img src="<?php echo G5_IMG_URL ?>/acpc_home_top_bn.jpg"></div></a>
<?php } ?>
<?php if($member['mb_id']) { ?>
   <div id="pc_fcontainer"> 
<? } else { ?>
    <div id="pc_fcontainer_b">
<? } ?>
<div id="swiper_reset"></div>
<div class="swiper-container main-vcontainer">
     <div class="swiper-wrapper">
        <div class="swiper-slide main-vslide">
            <section class="mainBanner">
                <div class="swiper-container banner-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide banner-slide" style="background: #4C3C2D;">
                            <img src="https://acropass2019.s3.ap-northeast-2.amazonaws.com/img/main_banner_back_210601.jpg" style="width:100%;height: 100%;object-fit: cover;">
                            <iframe width="1120" height="630" src="https://www.youtube.com/embed/8uWkR0Y6gOY?autoplay=0&amp;playlist=8uWkR0Y6gOY&amp;loop=1&amp;showinfo=0&amp;rel=0" frameborder="0" allow="accelerometer; autoplay; loop; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="z-index: 10000;outline:10px solid #fff;position: absolute;top:calc(50% - 236.25px);left:calc(50% - 420px);width:840px;height:472.5px;"></iframe>
                        </div>
                        <?php echo display_banner('메인', 'mainbanner.20.skin.php', '10'); ?>
                    </div>
                    <div class="swiper-pagination main-banner-number"></div>
                    <div class="main-banner-right swiper-button-next "><i class="xi-angle-right-thin"></i></div>
                    <div class="main-banner-left swiper-button-prev "><i class="xi-angle-left-thin"></i></div>
                    
                    <!-- Add Arrows -->
                   
                </div>
            </section>
        </div>

        <div class="swiper-slide main-vslide">
            <section class="brandBanner">
                <img src="<?php echo G5_IMG_URL ?>/acpc_home_brand.jpg" alt="">
                <div class="brandBannerLogo"><img src="<?php echo G5_IMG_URL ?>/acropass_logo.png?0122" alt=""></div>
                <div class="brandSubTitle">Home Dermal Filling & Feeling<br>깊숙히 채워지는 변화를 느껴보세요</div>
                <a href="<?php echo G5_SHOP_URL ?>/brandstory.php"><div class="mainBannerBtn">자세히보기</div></a>
            </section>
        </div>
        <div class="swiper-slide main-vslide">
            <section class="bestProduct5">
                <div class="bestProductTitle">베스트셀러 Top 5</div>
                <?php
                    $skin = G5_SHOP_SKIN_PATH.'/main.10.skin.php'; // 스킨
                    $sql = " select * from {$g5['g5_shop_item_table']} where it_type4 = '1' AND it_use = '1' and it_5 != '1' order by it_1,  it_id asc ";
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
            </section>
        </div>
        <div class="swiper-slide main-vslide">
            <section class="bestPcReview">
                <div class="swiper-container best-review-container">
                    <h4><span>#홈더마필러</span><span> #Filling&Feeling</span></h4>
                    <h3>베스트 리뷰</h3>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide best-review-slide">
                            <a href="https://cookey11.blog.me/221717320683" target="_blank">
                            <img src="<?php echo G5_IMG_URL ?>/ac_bestreview_tn_7.jpg" alt="">
                            <div class="review-title">올리브영 여드름패치! 트러블큐어 대용량팩 리뷰</div>
                            <div class="review-contents">안 그래도 피부가 좋지 않은데 트러블까지 생기니까 거울볼 때 마다 어찌나 신경쓰이던지... 여드름을 빨리 없애기 위해 친구의...</div>
                            <div class="review-write">링구 <span>|</span> 2019.11.24 <span>|</span> 네이버블로그</div>
                            </a>
                        </div>
                        <div class="swiper-slide best-review-slide">
                            <a href="https://blog.naver.com/yona_73/221540012434" target="_blank">
                            <img src="<?php echo G5_IMG_URL ?>/ac_bestreview_tn_8.jpg" alt="">
                            <div class="review-title">팔자주름, 라인케어패치로 얼굴주름리프팅하자</div>
                            <div class="review-contents">나이가 들어가면서 어쩔 수 없이 생기는 것이 주름이지요. 머..요즘에는 피부과에서도 관리를 받고 피부 관리실을 다니기도 하고요...</div>
                            <div class="review-write">요나<span>|</span> 2019.05.17 <span>|</span> 네이버블로그</div>
                            </a>
                        </div>
                        <div class="swiper-slide best-review-slide">
                            <a href="https://blog.naver.com/seo670722/221546153618" target="_blank">
                            <img src="<?php echo G5_IMG_URL ?>/ac_bestreview_tn_2.jpg" alt="">
                            <div class="review-title">언더아이패치 : 다크서클 없애는 법 아크로패스</div>
                            <div class="review-contents">요즘 왜이리 피곤한지 잠을 자도 자도 피곤해서 힘드네요ㅠ.ㅠ 기력보충도 필요하지만 눈가가 칙칙한게 몇일은 잠 못잔 사람마냥...</div>
                            <div class="review-write">시녀나<span>|</span> 2019.05.25 <span>|</span> 네이버블로그</div>
                            </a>
                        </div>
                        <div class="swiper-slide best-review-slide">
                            <a href="https://blog.naver.com/sakdlem1004/221314122299" target="_blank">
                            <img src="<?php echo G5_IMG_URL ?>/ac_bestreview_tn_9.jpg" alt="">
                            <div class="review-title">벌레물림 걱정끝!!! 아크로패스 수딩큐 하나면...</div>
                            <div class="review-contents">오늘은 꼬미를 위한 제품을 만나보았는데여 아래 두 아이도 물론 모기에 민감하지만 요즘 알러지 체질이 되어서 모기에도 확 반응하는...</div>
                            <div class="review-write">온뤼마루<span>|</span> 2018.07.07 <span>|</span> 네이버블로그</i></div>
                            </a>
                        </div>
                        <div class="swiper-slide best-review-slide">
                            <a href="https://blog.naver.com/hanr7/221499124627" target="_blank">
                            <img src="<?php echo G5_IMG_URL ?>/ac_bestreview_tn_1.jpg" alt="">
                            <div class="review-title">여드름패치 물건이네~ 아크로패스 트러블큐어</div>
                            <div class="review-contents">이게 안개인지 미세먼지인지 분간이 안될정도로 공기질이 안좋은 날들이 반복되고 있어요. 더군다나 저희 도에는 지하철역 공사까지 하고 있어...</div>
                            <div class="review-write">보니비<span>|</span> 2017.03.27 <span>|</span> 네이버블로그</div>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-button-next review-angle-right"><i class="xi-angle-right-thin"></i></div>
                    <div class="swiper-button-prev review-angle-left"><i class="xi-angle-left-thin"></i></div>
                    
                </div>
            </section>
        </div>
        <div class="swiper-slide main-vslide">
           <section class="bestProduct5">
                <div class="bestProductTitle">온라인 혜택제품</div>
                <?php
                    $skin = G5_SHOP_SKIN_PATH.'/main.10.skin.php'; // 스킨
                    $sql = " select * from {$g5['g5_shop_item_table']} where it_type1 = '1' AND it_use = '1' and it_5 != '1' order by it_2, it_id desc ";
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
            </section>
        </div>
        <!--
        <div class="swiper-slide main-vslide">
           <section class="instagram-wrap">
                <?php include_once(G5_PATH.'/Instagram/pc/index.php'); ?>
            </section>
        </div>
        -->
        <a href="<?php echo G5_SHOP_URL ?>/csr_beauty.php">
        <div class="csr_banner_wrap">
            <div class="csr_banner"><span>SAVE THE CHILDREN CAMPAIGN</span><br>GIVING VACCINE</div>
        </div>
        </a>
        <div id="shop_ft"> 
           
            <div class="shop_footer_menu">
                <div class="shop_site_use"><a href="<?php echo G5_BBS_URL ?>/content.php?co_id=provision">이용약관</a><span class="footer_text_sep">|</span><a href="<?php echo G5_BBS_URL ?>/content.php?co_id=privacy">개인정보처리방침</a><span class="footer_text_sep">|</span><a href="http://www.ftc.go.kr/bizCommPop.do?wrkr_no=1058690704&apv_perm_no=" target="_blank">사업자정보확인</a></div>
                <div class="shop_footer_customer"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=notice">고객센터</a><span class="footer_text_sep">|</span><a href="<?php echo G5_BBS_URL ?>/faq.php">FAQ</a><span class="footer_text_sep">|</span><a href="http://pf.kakao.com/_CrTxgu" target="_blank">1:1 카카오톡 상담</a><span class="footer_text_sep">|</span><a href="<?php echo G5_BBS_URL ?>/qalist.php">1:1 문의</a><a href="https://www.instagram.com/acropass_official" target=_blank"><i class="xi-instagram"></i></a></div>
            </div>
            <div class="shop_footer_info">
                <img src="<?php echo G5_IMG_URL; ?>/ac-footer-raphas-logo.png">
                <div class="shop_info_detail">
                    (주)라파스<span class="footer_info_sep">|</span>서울시 강서구 마곡중앙8로 1길 62 (마곡동, 라파스)<span class="footer_text_sep">|</span>대표자 : 정도현<br><br>사업자등록번호 : 105-86-90704<br>통신판매업신고번호: 제 2018-서울 강서-0354호
                </div>
                <div class="shop_footer_contact">
                    <div class="shop_footer_call">고객문의 070-7712-2015</div>
                    <div class="shop_contact_info">평일 10:00~18:00, 점심시간 12:00~13:00<br>sales@raphas.com</div>
                </div>
            </div>
        </div>
    
    </div>
    <div class="swiper-pagination swiper-main-pagination"></div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js"></script>
<script>

var interleaveOffset = 0.5;

var swiperOptions = {
  loop: true,
  speed: 1000,
  grabCursor: true,
  watchSlidesProgress: true,
  keyboardControl: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev"
  },
  on: {
    progress: function() {
      var swiper = this;
      for (var i = 0; i < swiper.slides.length; i++) {
        var slideProgress = swiper.slides[i].progress;
        var innerOffset = swiper.width * interleaveOffset;
        var innerTranslate = slideProgress * innerOffset;
        swiper.slides[i].querySelector(".slide-inner").style.transform =
          "translate3d(" + innerTranslate + "px, 0, 0)";
      }      
    },
    touchStart: function() {
      var swiper = this;
      for (var i = 0; i < swiper.slides.length; i++) {
        swiper.slides[i].style.transition = "";
      }
    },
    setTransition: function(speed) {
      var swiper = this;
      for (var i = 0; i < swiper.slides.length; i++) {
        swiper.slides[i].style.transition = speed + "ms";
        swiper.slides[i].querySelector(".slide-inner").style.transition =
          speed + "ms";
      }
    }
  }
};

var swiper2 = new Swiper('.main-vcontainer', {
    direction: 'vertical',
    slidesPerView: 1,
    spaceBetween: 0,
    mousewheel: true,
    mousewheelSensitivity: 0,
    mousewheelReleaseOnEdges: true,
    pagination: {
      el: '.swiper-main-pagination',
      clickable: true,
    },
    slidesOffsetAfter: 550,
});

var swiper = new Swiper('.banner-container', {
  pagination: {
    el: '.swiper-pagination',
    type: 'fraction',
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  
});

swiper.on('slideChange', function () {
  console.log('slide changed');
});
 
var swiper4 = new Swiper('.best-review-container', {
  slidesPerView: 3,
  spaceBetween: 60,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});

$(function(){
    $("body").on('mousewheel DOMMouseScroll', function(e) {
        //swiper2.update();
    });

    window_size();
});

$(window).resize(function() {
   window_size();
});

$(window).bind("load", function() {
   $("#swiper_reset").css("display","block");
   setTimeout("clear_swiper_reset()", 1000);
});

function clear_swiper_reset(){
    $("#swiper_reset").css("display","none");
}


function window_size(){
    var windowWidth = $( window ).width();
    var windowHeight = $( window ).height();
    var ratio = windowWidth / windowHeight;
    console.log(ratio);

    if(ratio > 1.92) {
        $(".banner-slide-back").css({width:"100%", height:"100%"});
        $(".banner-slide-back").css("object-fit","cover");
        $(".banner-slide-img").css("height","100%");
        $(".banner-slide a").css({width:"100%", height:"100%"});
    } else {
        $(".banner-slide-back").css({height:"100%"});
        $(".banner-slide-back").css("object-fit","cover");
        $(".banner-slide-img").css("height","auto");
        $(".banner-slide a").css("height","auto");
    }
}



</script>

<?php
 include_once(G5_THEME_PATH.'/tail.php');
?>