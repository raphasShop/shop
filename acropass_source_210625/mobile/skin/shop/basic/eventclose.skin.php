<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div id="top_menu_wrap">
    <a href="<?php echo G5_SHOP_URL ?>/eventlist.php"><div class="top_menu3_button">진행중인 이벤트</div></a><a href="<?php echo G5_SHOP_URL ?>/eventprize.php"><div class="top_menu3_button">당첨자발표</div></a><a href="<?php echo G5_SHOP_URL ?>/eventclose.php"><div class="top_menu3_button  menu_select">종료된 이벤트</div></a>
</div>

<div id="eventclose_wrap">
    <div class="eventclose_item">
        <div class="image_over_wrap"><img src="<?php echo G5_IMG_URL; ?>/event/banner/evnet17_bomisign2.jpg"><div class="over_transparent"></div></div>
        <p class="eventclose_title">윤보미 팬사인회 응모 이벤트</p>
        <p class="eventclose_date">2019. 10. 21 ~ 2019. 10. 30</p>
    </div>
    <div class="eventclose_item">
        <div class="image_over_wrap"><img src="<?php echo G5_IMG_URL; ?>/event/banner/evnet14_trouble_freederm.jpg"><div class="over_transparent"></div></div>
        <p class="eventclose_title">트러블 프리덤 FREE-DERM</p>
        <p class="eventclose_date">2019. 9. 2 ~ 2019. 9. 30</p>
    </div>
    <div class="eventclose_item">
        <div class="image_over_wrap"><img src="<?php echo G5_IMG_URL; ?>/event/banner/event08.jpg"><div class="over_transparent"></div></div>
        <p class="eventclose_title">윤보미 포토카드 3종 증정 이벤트</p>
        <p class="eventclose_date">2019. 7 .16 ~ </p>
    </div>
    <div class="eventclose_item">
        <div class="image_over_wrap"><img src="<?php echo G5_IMG_URL; ?>/event07.png"><div class="over_transparent"></div></div>
        <p class="eventclose_title">아크로패스 언더아이케어 체험단 모집</p>
        <p class="eventclose_date">2019. 6 .8 ~ 2019. 6. 17</p>
    </div>
    <div class="eventclose_item">
        <div class="image_over_wrap"><img src="<?php echo G5_IMG_URL; ?>/b_event01.jpg"><div class="over_transparent"></div></div>
        <p class="eventclose_title">미세먼지로 고통받는 당신의 피부를 위한 통큰 혜택!</p>
        <p class="eventclose_date">2019. 3. 01 - 2019. 3. 15</p>
    </div>
    <div class="eventclose_item">
        <div class="image_over_wrap"><img src="<?php echo G5_IMG_URL; ?>/b_event02.jpg"><div class="over_transparent"></div></div>
        <p class="eventclose_title">아크로패스 설날 혜택전</p>
        <p class="eventclose_date">2018. 8. 16 - 2018. 8. 31</p>
    </div>
    <div class="eventclose_item">
         <div class="image_over_wrap"><img src="<?php echo G5_IMG_URL; ?>/b_event03.jpg"><div class="over_transparent"></div></div>
        <p class="eventclose_title">8월 한 달간, 아크로패스가 준비한<br>COOL한 혜택!</p>
        <p class="eventclose_date">2018. 8. 16 - 2018. 8. 31</p>
    </div>
    <div class="eventclose_item">
        <div class="image_over_wrap"><img src="<?php echo G5_IMG_URL; ?>/b_event04.jpg"><div class="over_transparent"></div></div>
        <p class="eventclose_title">고객 감사 전상품 무료배송 이벤트</p>
        <p class="eventclose_date">2018. 4. 10 - 2018. 4. 23</p>
    </div>
</div>
