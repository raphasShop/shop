<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<div id="top_sub_gnb">
    <div class="top_sub_wrap">회원가입</div>
    <div class="top_back_btn"><a href="javascript:history.back();"><i class="xi-angle-left"></i></a></div>
</div>


<div id="mb_register" class="mbskin">

    <?php 
    // 소셜로그인 사용시 소셜로그인 버튼

    //@include_once(get_social_skin_path().'/social_register.skin.php');
    ?>

    <form name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">

    <div class="register_intro">
        <div class="main_intro"><img src="<?php echo G5_IMG_URL ?>/acropass_logo.png?0122"> 에 오신 것을 환영합니다.</div>
        <div class="sub_intro">가입 후 다양한 혜택을 만나보세요!</div>
    </div>

    <div class="register_process_wrap">
        <div class="register_process process_now">약관동의</div><div class="process_arrow"><i class="xi-angle-right"></i></div><div class="register_process">본인인증</div><div class="process_arrow"><i class="xi-angle-right"></i></div><div class="register_process">정보입력</div>
    </div>

    <div class="register_title_wrap">
        <div class="register_main_title">Acropass 회원 약관 동의</div>
        <div class="register_sub_title">회원 가입 및 서비스 이용을 위해 약관 동의를 해주세요.</div>
    </div>
        
    <div class="chk_all">
        <input type="checkbox" name="chk_all" id="chk_all">
        <label for="chk_all"><span></span>전체동의</label>

    </div>
    <section id="fregister_term">
        <h2>회원가입약관</h2>
        <textarea readonly><?php echo get_text($config['cf_stipulation']) ?></textarea>
        <fieldset class="fregister_agree">
            <input type="checkbox" name="agree" value="1" id="agree11">
            <label for="agree11"><span></span>회원가입약관의 내용에 동의합니다.</label>
        </fieldset>
    </section>

    <section id="fregister_private">
        <h2>개인정보처리방침안내</h2>
        <textarea readonly><?php echo get_text($config['cf_privacy']) ?></textarea>
        <fieldset class="fregister_agree">
            <input type="checkbox" name="agree2" value="1" id="agree21">
             <label for="agree21"><span></span>개인정보처리방침안내의 내용에 동의합니다.</label>
       </fieldset>
    </section>

    <input type="submit" class="btn_submit" value="동의">
    

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

        return true;
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
