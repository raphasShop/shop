<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div id="top_menu_wrap">
    <a href="<?php echo G5_SHOP_URL ?>/brandstory.php"><div class="top_menu2_button">Brand Story</div></a><a href="<?php echo G5_SHOP_URL ?>/brandtech.php"><div class="top_menu2_button menu_select">Core Technology</div></a>
</div>

<div id="brand_tech">
    <div class="brand_tech_item">
        <img src="<?php echo G5_IMG_URL ?>/acm-brand-tech1.jpg">
        <div class="brand_tech_diagram"><img src="<?php echo G5_IMG_URL ?>/acm-brand-tech-diagram.png"></div>
        <div class="brand_tech_sm_top_con">생명의 섭리를 순응, 모방, 창조하는 과정을<br>통해 만들어진 <span>“건강하고 아름다운 완벽한 뷰티 솔루션”</span><br>아크로패스는 4가지 핵심 바이오 기술이 담긴<br>고기능성 바이오 더마 화장품 브랜드입니다.</div>
    </div>
    <div class="brand_tech_item">
        <img src="<?php echo G5_IMG_URL ?>/acm-brand-tech2.jpg">
        <div class="brand_tech_lg_con">생물마다 독특한 생장,<br>보호방식은  수억 년의 경험과<br>지혜가 진화되어 완성된<br>자연의 설계도!</div>
        <div class="brand_tech_sm_con">우리는 이에 큰 영감을 받고 자연을 닮은<br>첨단 바이오 기술을  완성도 높게 실현해 나가는<br>브랜드입니다.</div>
        <div class="brand_sm_title">Bio-Mimetics</div>
    </div>     
    <div class="brand_tech_item">
        <img src="<?php echo G5_IMG_URL ?>/acm-brand-tech3.jpg">
        <div class="brand_tech_lg_con">Microneedle 구조체는<br>생명공학과 나노구조공학의<br>융합으로 탄생한 아크로패스의<br>핵심기술입니다.</div>
        <div class="brand_tech_sm_con">개방적 사고와 유연한 바이오 지성(BQ)을<br>통해 이종의 기술을 적극 접목해, 새로운 길을<br>개척해 나갑니다.</div>
        <div class="brand_sm_title">Bio-Convergence</div>
    </div>
    <div class="brand_tech_item">
        <img src="<?php echo G5_IMG_URL ?>/acm-brand-tech4.jpg">
        <div class="brand_tech_lg_con">반도체의 대량생산 기술을<br>접목하여 탄생한 유효성분<br>전달기술인 ‘용해성 마이크로 니들’</div>
        <div class="brand_tech_sm_con">바이오 엔지니어링 기술은<br>섬세하고 정교합니다. 그렇기에 우리의 제품은 고객에게<br>최고의 만족감을 전달합니다.</div>
        <div class="brand_sm_title">Bio-Engineering</div>
    </div>
    <div class="brand_tech_item">
        <img src="<?php echo G5_IMG_URL ?>/acm-brand-tech5.jpg">
        <div class="brand_tech_lg_con">자극 없이 피부에 유효약물<br>성분을 전달하는<br>Trans Dermal Delivery<br>기술의 글로벌 선두주자!</div>
        <div class="brand_tech_sm_con">아크로패스는 의료, 바이오, 화장품 분야의<br>박사급 전문가 그룹에 의해 탄생한 기술 중심 브랜드입니다.<br>끊임없는 실험과 깐깐한 자체 기준을 통한<br>검증을 실천하며, 앞으로도 현재에 안주하지 않고<br>혁신을 만들겠습니다.</div>
        <div class="brand_sm_title">Bio-Derma</div>
    </div>
</div>
