<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div id="top_menu_wrap">
    <a href="<?php echo G5_SHOP_URL ?>/brandstory.php"><div class="top_menu2_button menu_select">Brand Story</div></a><a href="<?php echo G5_SHOP_URL ?>/brandtech.php"><div class="top_menu2_button">Core Technology</div></a>
</div>

<div id="brand_story">
    <div class="brand_story_item">
        <img src="<?php echo G5_IMG_URL ?>/acm-brand-story1.jpg">
        <div class="circle_back_top">
            <div class="philosophy_sm_con">생명, 자연의 지혜, 고객의<br>니즈를 탐구하다</div>
            <div class="philosophy_lg_con">True<br>Researcher</div>
        </div>
        <div class="circle_back_middle">
            <div class="philosophy_sm_con_w">뷰티 솔루션을<br>창조하는 새로운 방법</div>
            <div class="philosophy_lg_con_w">NEW<br>Beauty Solution<br>Creator</div>
        </div>
        <div class="circle_back_bottom">
            <div class="philosophy_sm_con">새로운 방법이 고객에게<br>최고의 만족을 제공</div>
            <div class="philosophy_lg_con">Solution<br>Provider</div>
        </div>
        <div class="brand_sm_title">Philosophy</div>
    </div>    
</div>
<div id="brand_item_wrap">
    <div class="brand_story_item">
        <div class="brand_story_back"></div>
        <div class="logo_story_slogan_icon1"><img src="<?php echo G5_IMG_URL ?>/logo-story-icon1.png"></div>
        <div class="logo_story_slogan_text1">
            <div class="logo_story_lg_slogan">ACRO</div>
            <div class="logo_story_sm_slogan">높은, 정점의, 극상의</div>
        </div>
        <div class="logo_story_plus">+</div>
        <div class="logo_story_slogan_icon2"><img src="<?php echo G5_IMG_URL ?>/logo-story-icon2.png"></div>
        <div class="logo_story_slogan_text2">
            <div class="logo_story_lg_slogan">PASS</div>
            <div class="logo_story_sm_slogan">지나가다, Path(통로, 길)</div>
        </div>
        
        <div class="logo_story_con_wrap">
            <div class="logo_story_lg_con">궁극의 정점에<br>도달하는 새로운 길</div>
            <div class="logo_story_sm_con">아크로패스는 세포에 직접 효능을 전달하는 마이크로니들<br>기술을 통해 당신이 바라던 그 이상의 피부를 경험하게 합니다.<br>아크로패스는 높은, 고도의 라는 뜻의 acro-와, 지나가다,<br>path(통로, 길)을 뜻하는 pass의 합성어 입니다.</div>
        </div>
        <div class="brand_sm_title">Logo Story</div>
    </div>    
</div>
<div id="brand_item_wrap">
    <div class="origins_item">
        <img src="<?php echo G5_IMG_URL ?>/acm-brand-story2.jpg">
        <div id="origins_circle1" class="origins_circle1 circle_select">Dream</div>
        <div id="origins_circle2" class="origins_circle2">Imagine</div>
        <div id="origins_circle3" class="origins_circle3">Think<br>Diffrent</div>
        <div id="origins_circle4" class="origins_circle4">Create<br>Technology</div>
        <div id="q_con" class="origins_q_con">인체에 효과적인 유효성분들을 고통 없이,<br>가장 효율적으로 전달하는 방법은 없을까?</div>
        <div id="a_con" class="origins_a_con">아크로패스는 생명공학을 공부해온 연구자들의<br>작은 꿈에서 시작되었습니다.</div>
        <div class="brand_sm_title">Origins</div>
    </div>    
</div>
<div id="brand_item_wrap">
    <div class="corevalue_item">
        <img src="<?php echo G5_IMG_URL ?>/acm-brand-story3.jpg">
        <div class="core_sub_title">Essence</div>
        <div class="core_main_title">Home<br>Derma filling System</div>
        <div class="core_con_wrap">
            <div class="core_lg_con">Expert</div>
            <div class="core_sm_con">Bio-Science를 기반으로 New Beauty Solution이라는<br>새로운 가치와 효능을 탐구하는 <span>‘전문가 그룹’</span></div>
            <div class="core_sep_line"></div>
            <div class="core_lg_con">Customized Solution</div>
            <div class="core_sm_con">현대인의 라이프 스타일, 감성과 호흡하며 상황별 고민,<br>생애주기를 고려한 <span>‘New Beauty Solution’</span></div>
            <div class="core_sep_line"></div>
            <div class="core_lg_con">Trust</div>
            <div class="core_sm_con">도덕적 기준을 준수한 Bio-centric 원천 기술 상품,<br>믿을 수 있는 원료 수급부터 완제품 생산의 <span>‘진실된 판매’</span></div>
        </div>
        <div class="brand_sm_title">Core value</div>
    </div>    
</div>

<script>
$('#origins_circle1').on('click', function(){
    stopOrigins();
    $('#origins_circle1').removeClass('circle_select');
    $('#origins_circle2').removeClass('circle_select');
    $('#origins_circle3').removeClass('circle_select');
    $('#origins_circle4').removeClass('circle_select');
    $('#origins_circle1').addClass('circle_select');
    $('#q_con').html('인체에 효과적인 유효성분들을 고통 없이,<br>가장 효율적으로 전달하는 방법은 없을까?');
    $('#a_con').html('아크로패스는 생명공학을 공부해온 연구자들의<br>작은 꿈에서 시작되었습니다.');
});

$('#origins_circle2').on('click', function(){
    stopOrigins();
    $('#origins_circle1').removeClass('circle_select');
    $('#origins_circle2').removeClass('circle_select');
    $('#origins_circle3').removeClass('circle_select');
    $('#origins_circle4').removeClass('circle_select');
    $('#origins_circle2').addClass('circle_select');
    $('#q_con').html('언제 어디서든, 누구에게든 효과적으로 <br>유효성분을 통증 없이 전달할 수는 없을까?');
    $('#a_con').html('기존 방식의 한계를 깨닫고, 인류의 건강과<br>아름다움을 위한 더 나은 길을 상상했습니다.');

});

$('#origins_circle3').on('click', function(){
    stopOrigins();
    $('#origins_circle1').removeClass('circle_select');
    $('#origins_circle2').removeClass('circle_select');
    $('#origins_circle3').removeClass('circle_select');
    $('#origins_circle4').removeClass('circle_select');
    $('#origins_circle3').addClass('circle_select');
    $('#q_con').html('Convergence of Biotechnology<br>and Nano Technology');
    $('#a_con').html('Micro Needle Patch라는<br> 유효성분 전달 시스템을 세계 최초로 상용화시킨,<br>늘 다른 생각, 늘 다른 실행을 하는 우리의 DNA!');
});

$('#origins_circle4').on('click', function(){
    stopOrigins();
    $('#origins_circle1').removeClass('circle_select');
    $('#origins_circle2').removeClass('circle_select');
    $('#origins_circle3').removeClass('circle_select');
    $('#origins_circle4').removeClass('circle_select');
    $('#origins_circle4').addClass('circle_select');
    $('#q_con').html('유효성분을 피부를 통해 전달해야 하는 <br>다양한 산업에서 새로운 대안!');
    $('#a_con').html('우리는 이 기술을 통해 아름답고 건강해질 수 있는<br>혁신적 솔루션을 제공합니다.');
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
        $('#q_con').html('인체에 효과적인 유효성분들을 고통 없이,<br>가장 효율적으로 전달하는 방법은 없을까?');
        $('#a_con').html('아크로패스는 생명공학을 공부해온 연구자들의<br>작은 꿈에서 시작되었습니다.');
        i++;
  } else if (i == 2) { 
        $('#origins_circle2').addClass('circle_select');
        $('#q_con').html('언제 어디서든, 누구에게든 효과적으로 <br>유효성분을 통증 없이 전달할 수는 없을까?');
        $('#a_con').html('기존 방식의 한계를 깨닫고, 인류의 건강과<br>아름다움을 위한 더 나은 길을 상상했습니다.');
        i++;
  } else if(i == 3) { 
        $('#origins_circle3').addClass('circle_select');
        $('#q_con').html('Convergence of Biotechnology<br>and Nano Technology');
        $('#a_con').html('Micro Needle Patch라는<br> 유효성분 전달 시스템을 세계 최초로 상용화시킨,<br>늘 다른 생각, 늘 다른 실행을 하는 우리의 DNA!');
        i++;
  } else if(i == 4) { 
        $('#origins_circle4').addClass('circle_select');
        $('#q_con').html('유효성분을 피부를 통해 전달해야 하는 <br>다양한 산업에서 새로운 대안!');
        $('#a_con').html('우리는 이 기술을 통해 아름답고 건강해질 수 있는<br>혁신적 솔루션을 제공합니다.');
        i = 1;
  }
}

function stopOrigins() {
    clearInterval(myVar);
}

</script>