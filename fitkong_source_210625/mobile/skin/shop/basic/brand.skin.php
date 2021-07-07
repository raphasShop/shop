<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/swiper_brand.css">', 0);
?>


<section class="brand">    
    <div class="swiper-container brand-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide brand_item"><img src="<?php echo G5_IMG_URL ?>/mo_brand_img1.png"></div>
            <div class="swiper-slide brand_item"><img src="<?php echo G5_IMG_URL ?>/mo_brand_img2.png"></div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>
<script src="<?php echo G5_JS_URL ?>/swiper.min.js"></script>
<script>
var swiper = new Swiper('.brand-container', {
  slidesPerView: 1,
  spaceBetween: 0,
  pagination: {
    el: '.swiper-pagination',
  },
  autoplay: {
    delay: 3000,
  },
});
</script>