<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<div id="pc_register_background">
<div id="register_top_wrap">

    <?php
    // 소셜로그인 사용시 소셜로그인 버튼
    //@include_once(get_social_skin_path().'/social_register.skin.php');
    ?>
    <img src="<?php echo G5_IMG_URL ?>/register_icon.png" class="register_top_image">
    <div class="register_intro">
        <div class="main_intro">FitKong의 회원이 되었습니다</div>
    </div>
</div>
<!-- 회원가입결과 시작 { -->
<div id="register_con_wrap">
<div id="reg_result">
    <div class="register_celebrate"><span><?php echo get_text($mb['mb_nick']); ?></span> 님 회원가입을 축하합니다.<br>고객님의 아이디는 <span><?php echo get_text($mb['mb_id']); ?></span> 입니다.</div>

    <div class="register_result_msg">
        <img src="<?php echo G5_IMG_URL ?>/login_coupon.png"> 
        <div class="result_main_msg">회원가입 축하쿠폰이 지급되었습니다.<br>지금 바로 핏콩몰에서 사용하실 수 있습니다.</div>
    </div>

    <a href="<?php echo G5_URL ?>/" class="btn_main">
    <div class="btn_confirm">
        메인으로 가기
    </div>
    </a>

</div>
</div>
<!-- } 회원가입결과 끝 -->
</div>
<script type="text/javascript">
      kakaoPixel('5283012127697450968').pageView();
      kakaoPixel('5283012127697450968').completeRegistration('회원가입완료');
</script>
