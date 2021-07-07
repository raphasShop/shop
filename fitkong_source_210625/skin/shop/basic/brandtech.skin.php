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
            <section class="brand-tech-wrap">
                <div class="brand-tech-container">
                    <div class="brand-title">Brand</div>
                    <div class="brand-menu-wrap">
                       <a href="<?php echo G5_SHOP_URL ?>/brandstory.php"><div class="brand-menu">Acroapss story</div></a>
                       <div class="brand-menu brand-select">Core technology</div>
                    </div>
                    <div class="brand-tech-diagram"><img src="<?php echo G5_IMG_URL ?>/ac-brand-story-diagram.png"></div>
                    <div class="brand-tech-main-con">생명의 섭리를 순응, 모방, 창조하는 과정을 통해 만들어진 <span>“건강하고 아름다운 완벽한 뷰티 솔루션”</span><br>아크로패스는 4가지 핵심 바이오 기술이 담긴 고기능성 바이오 더마 화장품 브랜드입니다.</div>
                </div>
            </section>
        </div>
        <div class="swiper-slide main-vslide">
            <section class="brand-tech-wrap2">
                <div class="brand-tech-container">
                    <div class="brand-title">Brand</div>
                    <div class="brand-menu-wrap">
                       <a href="<?php echo G5_SHOP_URL ?>/brandstory.php"><div class="brand-menu">Acroapss story</div></a>
                       <div class="brand-menu brand-select">Core technology</div>
                    </div>
                    <div class="core-tech-con-wrap">
                        <div class="core-tech-full-wrap">
                            <div class="core-tech-lg-con">생물마다 독특한 생장, 보호방식은<br>수억 년의 경험과 지혜가 진화되어 완성된 자연의 설계도!</div>
                            <div class="core-tech-sm-con">우리는 이에 큰 영감을 받고 자연을 닮은 첨단 바이오 기술을<br>완성도 높게 실현해 나가는 브랜드입니다.</div>
                        </div>
                    </div>
                </div>  
            </section>
        </div>
        <div class="swiper-slide main-vslide">
            <section class="brand-tech-wrap3">
                <div class="brand-tech-container">
                    <div class="brand-title">Brand</div>
                    <div class="brand-menu-wrap">
                       <a href="<?php echo G5_SHOP_URL ?>/brandstory.php"><div class="brand-menu">Acroapss story</div></a>
                       <div class="brand-menu brand-select">Core technology</div>
                    </div>
                    <div class="core-tech-con-wrap">
                        <div class="core-tech-full-wrap">
                            <div class="core-tech-lg-con">Microneedle 구조체는 생명공학과 나노구조공학의<br>융합으로 탄생한 아크로패스의 핵심기술입니다.</div>
                            <div class="core-tech-sm-con">개방적 사고와 유연한 바이오 지성(BQ)을 통해 이종의 기술을 적극 접목해,<br>새로운 길을 개척해 나갑니다.</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="swiper-slide main-vslide">
            <section class="brand-tech-wrap4">
                <div class="brand-tech-container">
                    <div class="brand-title">Brand</div>
                    <div class="brand-menu-wrap">
                       <a href="<?php echo G5_SHOP_URL ?>/brandstory.php"><div class="brand-menu">Acroapss story</div></a>
                       <div class="brand-menu brand-select">Core technology</div>
                    </div>
                    <div class="core-tech-con-wrap">
                        <div class="core-tech-full-wrap">
                            <div class="core-tech-lg-con">반도체의 대량생산 기술을 접목하여 탄생한<br>유효성분 전달기술인 ‘용해성 마이크로 니들’</div>
                            <div class="core-tech-sm-con">바이오 엔지니어링 기술은 섬세하고 정교합니다.<br>그렇기에 우리의 제품은 고객에게 최고의 만족감을 전달합니다.</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="swiper-slide main-vslide">
            <section class="brand-tech-wrap5">
                <div class="brand-tech-container">
                    <div class="brand-title">Brand</div>
                    <div class="brand-menu-wrap">
                       <a href="<?php echo G5_SHOP_URL ?>/brandstory.php"><div class="brand-menu">Acroapss story</div></a>
                       <div class="brand-menu brand-select">Core technology</div>
                    </div>
                    <div class="core-tech-con-wrap">
                        <div class="core-tech-full-wrap">
                            <div class="core-tech-lg-con">자극 없이 피부에 유효약물 성분을 전달하는<br>Trans Dermal Delivery 기술의 글로벌 선두주자!</div>
                            <div class="core-tech-sm-con">아크로패스는 의료, 바이오, 화장품 분야의 박사급 전문가 그룹에 의해 의해 탄생한 기술 중심 브랜드입니다.<br>끊임없는 실험과 깐깐한 자체 기준을 통한 검증을 실천하며, 앞으로도 현재에 안주하지 않고 혁신을 만들겠습니다.</div>
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
