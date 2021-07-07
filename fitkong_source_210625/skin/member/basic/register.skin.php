<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원가입약관 동의 시작 { -->
<div id="pc_register_background">
<div id="register_top_wrap">

    <?php
    // 소셜로그인 사용시 소셜로그인 버튼
    //@include_once(get_social_skin_path().'/social_register.skin.php');
    ?>
    <img src="<?php echo G5_IMG_URL ?>/register_icon.png" class="register_top_image">
    <div class="register_intro">
        <div class="main_intro">FitKong 에 오신 것을 환영합니다.</div>
        <div class="sub_intro">가입 후 다양한 혜택을 만나보세요!</div>
    </div>
</div>
<div id="register_kakao_wrap">
    <?php 
    $rd_url = G5_BBS_URL.'/login.php';
    $rd_url = urlencode($rd_url); ?>
    <a href="<?php echo G5_BBS_URL ?>/login.php?provider=kakao&amp;url=<?php echo $rd_url;?>" title="카카오">
    <img src="<?php echo G5_IMG_URL ?>/kakao_register_bn.png">
    </a>
</div>
<div id="register_basic_wrap">
    <div class="register_basic_title">일반 회원가입</div>
</div>
<div id="register_step_wrap">
    <div class="register_process_wrap">
        <div class="register_process process_now">약관동의</div><div class="process_arrow"><img src="<?php echo G5_IMG_URL ?>/register_arrow.png"></div><div class="register_process">본인인증</div><div class="process_arrow"><img src="<?php echo G5_IMG_URL ?>/register_arrow.png"></div><div class="register_process">정보입력</div>
    </div>
</div>
<div id="register_con_wrap">
    <form name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">
    <input type="hidden" name="rc_id" value="<?php echo $rc_id; ?>">

    
    <div class="register_con_title">FitKong 회원 약관 동의</div>
    <div class="register_con_subtitle">회원 가입 및 서비스 이용을 위해 약관 동의를 해주세요.</div>
    
    <div class="chk_age">
        <input type="checkbox" name="chk_age" id="chk_age">
        <label for="chk_age"><span></span>본인은 만 14세 이상입니다.</label>
    </div>
        
    <div class="chk_all">
        <input type="checkbox" name="chk_all" id="chk_all">
        <label for="chk_all"><span></span>전체동의</label>
    </div>
    <div class="fregister_wrap">
    <section id="fregister_term">
        <fieldset class="fregister_agree">
            <input type="checkbox" name="agree" value="1" id="agree11">
            <label for="agree11"><span></span>서비스 이용약관 (필수)</label>
            <img src="<?php echo G5_IMG_URL ?>/register_terms.png" class="register_terms_image" onclick="cf_stipulation_view()">
        </fieldset>
        <div class="register_terms_detail" id="cf_stipulation" style="display: none;"><textarea readonly><?php echo get_text($config['cf_stipulation']) ?></textarea></div>
    </section>

    <section id="fregister_private">
        <fieldset class="fregister_agree">
            <input type="checkbox" name="agree2" value="1" id="agree21">
             <label for="agree21"><span></span>개인정보 수집이용안내 (필수)</label>
             <img src="<?php echo G5_IMG_URL ?>/register_terms.png" class="register_terms_image" onclick="cf_privacy_view()">
       </fieldset>
       <div class="register_terms_detail" id="cf_privacy" style="display: none;"><textarea readonly><?php echo get_text($config['cf_privacy']) ?></textarea></div>
    </section>
    </div>

    <input type="submit" class="btn_submit" value="다음">
    

    </form>

    <script>
    function fregister_submit(f)
    {
        if (!f.agree.checked) {
            alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree.focus();
            return false;
        }

        if (!f.agree2.checked) {
            alert("개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree2.focus();
            return false;
        }

        if (!f.chk_age.checked) {
            alert("만 14세 이상만 가입이 가능합니다.");
            f.chk_age.focus();
            return false;
        }

        return true;
    }

    function cf_stipulation_view() {
        $("#cf_stipulation").css("display","block");
    }

    function cf_privacy_view() {
        $("#cf_privacy").css("display","block");
    }
    
    jQuery(function($){
        // 모두선택
        $("input[name=chk_all]").click(function() {
            if ($(this).prop('checked')) {
                $("input[name^=agree]").prop('checked', true);
            } else {
                $("input[name^=agree]").prop("checked", false);
            }
        });
    });

    </script>
</div>
</div>
<!-- } 회원가입 약관 동의 끝 -->
