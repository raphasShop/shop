<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/swiper_pc.css">', 0);
?>
<style>
::-webkit-scrollbar {display: none;}    
</style>
<div id="brand_story_pc_container">
<div class="swiper-container main-vcontainer">
     <div class="swiper-wrapper">
        <div class="swiper-slide main-vslide">
            <section class="brand-story-wrap">
                <div class="brand-story-container">
                    <div class="brand-title">Brand</div>
                    <div class="brand-menu-wrap">
                       <div class="brand-menu brand-select">Acropass story</div>
                       <a href="<?php echo G5_SHOP_URL ?>/brandtech.php"><div class="brand-menu">Core technology</div></a>
                    </div>
                    <div class="brand-circle-color wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s" data-wow-offset="1">
                        <div class="philosophy-sm-con-w">뷰티 솔루션을<br>창조하는 새로운 방법</div>
                        <div class="philosophy-lg-con-w">New<br>Beauty Solution<br>Creator</div>
                    </div>
                    <div class="brand-circle1 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s" data-wow-offset="1">
                        <div class="philosophy-sm-con">생명, 자연의 지혜, 고객의<br>니즈를 탐구하다</div>
                        <div class="philosophy-lg-con">True<br>Researcher</div>
                    </div>
                    <div class="brand-circle2 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s" data-wow-offset="1">
                        <div class="philosophy-sm-con">새로운 방법이 고객에게<br>최고의 만족을 제공</div>
                        <div class="philosophy-lg-con">Solution<br>Provider</div>
                    </div>
                </div>
            </section>
        </div>
        <div class="swiper-slide main-vslide">
            <section class="brand-story-wrap2">
                <div class="brand-story-container">
                    <div class="brand-title">Brand</div>
                    <div class="brand-menu-wrap">
                        <div class="brand-menu brand-select">Acropass story</div>
                        <a href="<?php echo G5_SHOP_URL ?>/brandtech.php"><div class="brand-menu">Core technology</div></a>
                    </div>
                    <div class="logo-story-wrap1">
                        <div class="logo-story-sub-wrap">
                            <div class="logo-story-icon"><img src="<?php echo G5_IMG_URL ?>/logo-story-icon1.png" class="logo-story-icon"></div>
                            <div class="logo-story-lg">ACRO</div>
                            <div class="logo-story-sm">높은, 정점의, 극상의</div>
                        </div>
                    </div>
                    <div class="logo-story-plus">+</div>
                    <div class="logo-story-wrap2">
                        <div class="logo-story-sub-wrap">
                            <div class="logo-story-icon"><img src="<?php echo G5_IMG_URL ?>/logo-story-icon2.png" class="logo-story-icon"></div>
                            <div class="logo-story-lg">PASS</div>
                            <div class="logo-story-sm">지나가다, Path(통로, 길)</div>
                        </div>
                    </div>
                    <div class="logo-story-con-wrap">
                        <div class="logo-story-full-wrap">
                            <div class="logo-story-con-lg">궁극의 정점에 도달하는 새로운 길</div>
                            <div class="logo-story-con-sm">아크로패스는 세포에 직접 효능을 전달하는 마이크로니들 기술을 통해 당신이 바라던 그 이상의 피부를 경험하게 합니다.<br>아크로 패스는 높은, 고도의 라는 뜻의 acro-와, 지나가다, path(통로, 길)을 뜻하는 pass의 합성어 입니다.</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="swiper-slide main-vslide">
            <section class="brand-story-wrap3">
                <div class="brand-story-container">
                    <div class="brand-title">Brand</div>
                    <div class="brand-menu-wrap">
                       <div class="brand-menu brand-select">Acropass story</div>
                       <a href="<?php echo G5_SHOP_URL ?>/brandtech.php"><div class="brand-menu">Core technology</div></a>
                    </div>
                    <div id="origins_circle1" class="origins-circle1 circle_select">Dream</div>
                    <div id="origins_circle2" class="origins-circle2 ">Imagine</div>
                    <div id="origins_circle3" class="origins-circle3 ">Think<br>Different</div>
                    <div id="origins_circle4" class="origins-circle4 ">Create<br>Technology</div>
                    <div class="origins-con-wrap">
                        <div class="logo-story-full-wrap">
                            <div id="q_con" class="origins-con-lg">인체에 효과적인 유효성분들을 고통 없이, 가장 효율적으로 전달하는 방법은 없을까?</div>
                            <div id="a_con" class="origins-con-sm">아크로패스는 생명공학을 공부해온 연구자들의 작은 꿈에서 시작되었습니다.</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="swiper-slide main-vslide">
            <section class="brand-story-wrap4">
                <div class="brand-story-container">
                    <div class="brand-title">Brand</div>
                    <div class="brand-menu-wrap">
                       <div class="brand-menu brand-select">Acropass story</div>
                       <a href="<?php echo G5_SHOP_URL ?>/brandtech.php"><div class="brand-menu">Core technology</div></a>
                    </div>
                    <div class="core-value-con-wrap">
                        <div class="logo-story-full-wrap">
                            <div class="core-sm-title">Essense</div>
                            <div class="core-main-title">Home<br>Derma filling System</div>
                            <div class="core-sub-con-wrap">
                                <div class="core-sub-con">
                                    <div class="core-con-lg">Expert<br>&nbsp;</div>
                                    <div class="core-con-sm">Bio-Science를 기반으로<br>New Beauty Solution이라는<br>새로운 가치와 효능을<br><span>탐구하는 ‘전문가 그룹’</span></div>
                                </div>
                                <div class="core-sub-con">
                                    <div class="core-con-lg">Customized Solution</div>
                                    <div class="core-con-sm">현대인의 라이프 스타일,<br>감성과 호흡하며 상황별 고민,<br>생애주기를 고려한 <br><span>‘New Beauty Solution’</span></div>
                                </div>
                                <div class="core-sub-con-end">
                                    <div class="core-con-lg">Trust<br>&nbsp;</div>
                                    <div class="core-con-sm">도덕적 기준을 준수한<br>Bio-centric 원천 기술 상품, <br>믿을 수 있는 원료 수급부터 <br><span>완제품 생산의 ‘진실된 판매’</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
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
  scrollbar: {
    el: '.swiper-banner-scrollbar',
    clickable: true,
  },
  autoplay: {
    delay: 5000,
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
$('#origins_circle1').on('click', function(){
    stopOrigins();
    $('#origins_circle1').removeClass('circle_select');
    $('#origins_circle2').removeClass('circle_select');
    $('#origins_circle3').removeClass('circle_select');
    $('#origins_circle4').removeClass('circle_select');
    $('#origins_circle1').addClass('circle_select');
    $('#q_con').html('인체에 효과적인 유효성분들을 고통 없이, 가장 효율적으로 전달하는 방법은 없을까?');
    $('#a_con').html('아크로패스는 생명공학을 공부해온 연구자들의 작은 꿈에서 시작되었습니다.');
});

$('#origins_circle2').on('click', function(){
    stopOrigins();
    $('#origins_circle1').removeClass('circle_select');
    $('#origins_circle2').removeClass('circle_select');
    $('#origins_circle3').removeClass('circle_select');
    $('#origins_circle4').removeClass('circle_select');
    $('#origins_circle2').addClass('circle_select');
    $('#q_con').html('언제 어디서든, 누구에게든 효과적으로 유효성분을 통증 없이 전달할 수는 없을까?');
    $('#a_con').html('기존 방식의 한계를 깨닫고, 인류의 건강과 아름다움을 위한 더 나은 길을 상상했습니다.');

});

$('#origins_circle3').on('click', function(){
    stopOrigins();
    $('#origins_circle1').removeClass('circle_select');
    $('#origins_circle2').removeClass('circle_select');
    $('#origins_circle3').removeClass('circle_select');
    $('#origins_circle4').removeClass('circle_select');
    $('#origins_circle3').addClass('circle_select');
    $('#q_con').html('Convergence of Biotechnology and Nano Technology');
    $('#a_con').html('Micro Needle Patch라는  유효성분 전달 시스템을 세계 최초로 상용화시킨, 늘 다른 생각, 늘 다른 실행을 하는 우리의 DNA!');
});

$('#origins_circle4').on('click', function(){
    stopOrigins();
    $('#origins_circle1').removeClass('circle_select');
    $('#origins_circle2').removeClass('circle_select');
    $('#origins_circle3').removeClass('circle_select');
    $('#origins_circle4').removeClass('circle_select');
    $('#origins_circle4').addClass('circle_select');
    $('#q_con').html('유효성분을 피부를 통해 전달해야 하는 다양한 산업에서 새로운 대안!');
    $('#a_con').html('우리는 이 기술을 통해 아름답고 건강해질 수 있는 혁신적 솔루션을 제공합니다.');
});

var i = 2;
var myVar = setInterval(setOrigins, 3000);
function setOrigins() {
  $('#origins_circle1').removeClass('circle_select');
  $('#origins_circle2').removeClass('circle_select');
  $('#origins_circle3').removeClass('circle_select');
  $('#origins_circle4').removeClass('circle_select');
  if(i == 1) {
        $('#origins_circle1').addClass('circle_select');
        $('#q_con').html('인체에 효과적인 유효성분들을 고통 없이, 가장 효율적으로 전달하는 방법은 없을까?');
        $('#a_con').html('아크로패스는 생명공학을 공부해온 연구자들의 작은 꿈에서 시작되었습니다.');
        i++;
  } else if (i == 2) { 
        $('#origins_circle2').addClass('circle_select');
        $('#q_con').html('언제 어디서든, 누구에게든 효과적으로 유효성분을 통증 없이 전달할 수는 없을까?');
        $('#a_con').html('기존 방식의 한계를 깨닫고, 인류의 건강과 아름다움을 위한 더 나은 길을 상상했습니다.');
        i++;
  } else if(i == 3) { 
        $('#origins_circle3').addClass('circle_select');
        $('#q_con').html('Convergence of Biotechnology and Nano Technology');
        $('#a_con').html('Micro Needle Patch라는 유효성분 전달 시스템을 세계 최초로 상용화시킨, 늘 다른 생각, 늘 다른 실행을 하는 우리의 DNA!');
        i++;
  } else if(i == 4) { 
        $('#origins_circle4').addClass('circle_select');
        $('#q_con').html('유효성분을 피부를 통해 전달해야 하는 다양한 산업에서 새로운 대안!');
        $('#a_con').html('우리는 이 기술을 통해 아름답고 건강해질 수 있는 혁신적 솔루션을 제공합니다.');
        i = 1;
  }
}

function stopOrigins() {
    clearInterval(myVar);
}

</script>