<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if( ! $config['cf_social_login_use']) {     //소셜 로그인을 사용하지 않으면
    return;
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/remodal/remodal.css">', 11);
add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/remodal/remodal-default-theme.css">', 12);
add_stylesheet('<link rel="stylesheet" href="'.get_social_skin_url().'/style.css">', 13);
add_javascript('<script src="'.G5_JS_URL.'/remodal/remodal.js"></script>', 10);

$email_msg = $is_exists_email ? '등록할 이메일이 중복되었습니다.다른 이메일을 입력해 주세요.' : '';
?>

<!-- 회원정보 입력/수정 시작 { -->
<div class="mbskin" id="register_member">

    <script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
    <?php
    if ($is_exists_email || $is_exists_phone) { ?>
   
    <!-- 기존 계정 연결 -->
    <div class="social_login_wrap">
        <div class="social_login_title">회원정보 확인</div>
        <div class="social_login_sm_title">카카오톡 계정과 정보가 일치하는 회원이 있습니다. 이미 회원이시라면 기존 계정에 연결해주세요. </div>
    </div>
    <div class="member_connect">
        <button type="button" class="social_connecmart_member_btn" data-remodal-target="modal">
            기존 계정에 연결하기
            <i class="fa fa-angle-double-right"></i>
        </button>
    </div>

    <div id="sns-link-pnl" class="remodal" data-remodal-id="modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
        <button type="button" class="connect-close" data-remodal-action="close">
            <i class="fa fa-close"></i>
            <span class="txt">닫기</span>
        </button>
        <div class="connect-fg">
            <form method="post" action="<?php echo $login_action_url ?>" onsubmit="return social_obj.flogin_submit(this);">
            <input type="hidden" id="url" name="url" value="<?php echo $login_url ?>">
            <input type="hidden" id="provider" name="provider" value="<?php echo $provider_name ?>">
            <input type="hidden" id="action" name="action" value="social_account_linking">

            <div class="connect-title">기존 계정에 연결하기</div>

            <div class="connect-desc">
                기존 계정에 카카오톡 계정을 연결합니다.<br>
                이 후 카카오로 시작하기를 하시면 기존 아이디로 로그인 할 수 있습니다.
            </div>

            <div id="login_fs">
                <label for="login_id" class="login_id">아이디<strong class="sound_only"> 필수</strong></label>
                <span class="lg_id"><input type="text" name="mb_id" id="login_id" class="frm_input required" size="20" maxLength="20" ></span>
                <label for="login_pw" class="login_pw">비밀번호<strong class="sound_only"> 필수</strong></label>
                <span class="lg_pw"><input type="password" name="mb_password" id="login_pw" class="frm_input required" size="20" maxLength="20"></span>
                <br>
                <input type="submit" value="연결하기" class="login_submit btn_submit">
            </div>

            </form>
        </div>
    </div>
    <?php } else { ?>

    <!-- 새로가입 시작 -->
    <form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url; ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="url" value="<?php echo $urlencode; ?>">
    <input type="hidden" name="mb_name" value="<?php echo $user_nick; ?>" >
    <input type="hidden" name="provider" value="<?php echo $provider_name;?>" >
    <input type="hidden" name="action" value="register">

    <input type="hidden" name="mb_id" value="<?php echo $user_id; ?>" id="reg_mb_id">
    <input type="hidden" name="mb_nick_default" value="<?php echo isset($user_nickname)?get_text($user_nickname):''; ?>">
    <input type="hidden" name="mb_nick" value="<?php echo isset($user_nickname)?get_text($user_nickname):''; ?>" id="reg_mb_nick">
    <input type="hidden" name="mb_homepage" value="<?php echo $user_code; ?>" id="reg_mb_homepage">
    <input type="hidden" name="mb_email" value="<?php echo $user_email; ?>" id="reg_mb_email">
    <input type="hidden" name="mb_tel" value="<?php echo $user_tel; ?>" id="reg_mb_tel">
    <input type="hidden" name="mb_zip1" value="<?php echo $zone_number1; ?>" id="reg_mb_zip1">
    <input type="hidden" name="mb_zip2" value="<?php echo $zone_number2; ?>" id="reg_mb_zip2">
    <input type="hidden" name="mb_addr1" value="<?php echo $shipping_base_address1; ?>" id="reg_mb_addr1">
    <input type="hidden" name="mb_addr2" value="<?php echo $shipping_detail_address; ?>" id="reg_mb_addr1">
    <input type="hidden" name="mb_addr3" value="<?php echo $shipping_base_address2; ?>" id="reg_mb_addr3">
    <input type="hidden" name="mb_addr_jibeon" value="<?php echo $mb_addr_jibeon; ?>" id="reg_mb_jibeon">
    <input type="hidden" name="mb_profile" value="<?php echo $mb_profile; ?>" id="reg_mb_profile">
    <input type="hidden" name="mb_hp" value="<?php echo $user_phone; ?>" id="reg_mb_hp">
    <input type="hidden" name="mb_birth" value="<?php echo $user_birthday; ?>" id="reg_mb_birth">
    <input type="hidden" name="mb_sex" value="<?php echo $user_gender; ?>" id="reg_mb_sex">
    <input type="hidden" name="mb_sms" value="<?php echo $terms_sms; ?>" id="reg_mb_sms">
    <input type="hidden" name="mb_mailling" value="<?php echo $terms_mail; ?>" id="reg_mb_mailling">


    <div class="social_login_wrap">
        <div class="social_login_title">회원정보 확인</div>
        <div class="social_login_sm_title">이름 정보를 확인해주시고, 변경이 필요하신 경우 수정 후 회원가입 해주세요.</div>
        <tr>
            <th scope="row"><label for="reg_mb_name">이름<strong class="sound_only">필수</strong></label></th>
            <td>
                <input type="text" name="mb_name" value="<?php echo isset($user_nick)?$user_nick:''; ?>" id="reg_mb_name" required class="frm_input required" size="70" maxlength="100" placeholder="이름을 입력해주세요." >
                
            </td>
        </tr>
    </div>

    <div class="btn_confirm">
        <input type="submit" value="회원가입" id="btn_submit" class="btn_submit" accesskey="s">
    
    </div>
    </form>
    <!-- 새로가입 끝 -->

    <?php } ?>

    <script>

    // submit 최종 폼체크
    function fregisterform_submit(f)
    {

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }

    function flogin_submit(f)
    {
        var mb_id = $.trim($(f).find("input[name=mb_id]").val()),
            mb_password = $.trim($(f).find("input[name=mb_password]").val());

        if(!mb_id || !mb_password){
            return false;
        }

        return true;
    }

    jQuery(function($){
        if( jQuery(".toggle .toggle-title").hasClass('active') ){
            jQuery(".toggle .toggle-title.active").closest('.toggle').find('.toggle-inner').show();
        }
        jQuery(".toggle .toggle-title .right_i").click(function(){

            var $parent = $(this).parent();
            
            if( $parent.hasClass('active') ){
                $parent.removeClass("active").closest('.toggle').find('.toggle-inner').slideUp(200);
            } else {
                $parent.addClass("active").closest('.toggle').find('.toggle-inner').slideDown(200);
            }
        });
        // 모두선택
        $("input[name=chk_all]").click(function() {
            if ($(this).prop('checked')) {
                $("input[name^=agree]").prop('checked', true);
            } else {
                $("input[name^=agree]").prop("checked", false);
            }
        });

        $(".btn_submit_trigger").on("click", function(e){
            e.preventDefault();
            $("#btn_submit").trigger("click");
        });
    });
    </script>

</div>
<!-- } 회원정보 입력/수정 끝 -->