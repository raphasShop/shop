<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<div id="pc_color_background">
<div id="login_pc_wrap">
<!-- 로그인 시작 { -->
<div id="mb_login" class="mbskin">
    
    <?php if (preg_match("/orderinquiry.php$/", $url)) { ?>
    <div id="login_menu_wrap">
        <a href="<?php echo G5_BBS_URL ?>/login.php"><div class="login_menu_button">회원 로그인</div></a><a href="<?php echo G5_SHOP_URL ?>/orderinquiry.php"><div class="login_menu_button menu_select">비회원 주문조회</div></a>
    </div>
    <?php } else { ?>
    <div id="login_menu_wrap">
        <a href="<?php echo G5_BBS_URL ?>/login.php"><div class="login_menu_button menu_select">회원 로그인</div></a><a href="<?php echo G5_SHOP_URL ?>/orderinquiry.php"><div class="login_menu_button">비회원 주문조회</div></a>
    </div>
    <?php } ?>
    

    <?php if (preg_match("/orderinquiry.php$/", $url)) { ?>
    <div class="mbskin" id="mb_login_od_wr">
       
        <fieldset id="c">
       
            <form name="forderinquiry" method="post" action="<?php echo urldecode($url); ?>" autocomplete="off">

            <label for="od_id" class="od_id sound_only">주문서번호<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="od_id" value="<?php echo $od_id; ?>" id="od_id" required class="frm_input" size="20" placeholder="주문서번호">
            <label for="id_pwd" class="od_pwd sound_only" >비밀번호<strong class="sound_only"> 필수</strong></label>
            <input type="password" name="od_pwd" size="20" id="od_pwd" required class="frm_input" placeholder="비밀번호">
            <input type="submit" value="주문확인" class="btn_submit">

            </form>
        </fieldset>

        <section class="login_register_banner">
            <a href="<?php echo G5_BBS_URL ?>/register.php"><img src="<?php echo G5_IMG_URL ?>/register_coupon.png?210610" alt="" class=""></a>
        </section>


    </div>
    <?php } else { ?>
    <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post" id="flogin">
    <input type="hidden" name="url" value="<?php echo $login_url ?>">

    <div id="login_frm">
        <div class="login_input_box">
            <label for="login_id" class="sound_only">아이디<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="mb_id" id="login_id" placeholder="아이디" required class="frm_input" maxLength="20">
            <label for="login_pw" class="sound_only">비밀번호<strong class="sound_only"> 필수</strong></label>
            <input type="password" name="mb_password" id="login_pw" placeholder="비밀번호" required class="frm_input" maxLength="20">
        </div>
        <div class="login_submit_box">
            <input type="submit" value="로그인" class="btn_submit">
        </div>
        <div class="login_check_box">
            <div class="login_id_check">
                <input type="checkbox" name="id_save" id="login_id_save">
                <label for="login_id_save"><span></span>아이디저장</label>
            </div>
            <div class="login_auto_check">
                <input type="checkbox" name="auto_login" id="login_auto_login">
                <label for="login_auto_login"><span></span>자동로그인</label>
            </div>
        </div>
        <div class="login_social_box" style="display:none;">
            <a href="<?php echo G5_BBS_URL ?>/register.php"><img src="<?php echo G5_IMG_URL ?>/login_naver.png" alt="" class="login_social_naver"></a><a href="<?php echo G5_BBS_URL ?>/register.php"><img src="<?php echo G5_IMG_URL ?>/login_kakao.png" alt="" class="login_social_kakao"></a>
        </div>
       
    </div>

    <section class="login_kakao_banner">
        <a href="<?php echo $self_url;?>?provider=kakao&amp;url=<?php echo $urlencode;?>" title="카카오">
            <img src="<?php echo G5_IMG_URL ?>/kakao_login_bn.png" alt="" class="">
        </a>
    </section>

    <section class="mb_login_join">
        <h2>회원로그인 안내</h2>
        
        <div>
            <a href="<?php echo G5_BBS_URL ?>/register.php" class="login_register">회원 가입</a>
            <a href="<?php echo G5_BBS_URL ?>/id_find.php" class="login_lost">아이디 찾기</a>
            <a href="<?php echo G5_BBS_URL ?>/password_find.php" class="password_lost">비밀번호 찾기</a>
        </div>
    </section>

    <section class="login_register_banner">
        <a href="<?php echo G5_BBS_URL ?>/register.php"><img src="<?php echo G5_IMG_URL ?>/register_coupon_bn1.png?210610" alt="" style="margin-bottom:7px;"></a>
        <a href="<?php echo G5_BBS_URL ?>/register.php"><img src="<?php echo G5_IMG_URL ?>/register_coupon_bn.png?210610" alt="" class=""></a>
    
    </section>

    <?php
    // 소셜로그인 사용시 소셜로그인 버튼
        if($_SERVER['REMOTE_ADDR']=="121.172.7.103") {
        //@include_once(get_social_skin_path().'/social_login.skin.php');
        }   
    ?>
    
    </form>

    <?php }  ?>


    <?php // 쇼핑몰 사용시 여기부터 ?>
    <?php if ($default['de_level_sell'] == 1) { // 상품구입 권한 ?>

        <!-- 주문하기, 신청하기 -->
        <?php if (preg_match("/orderform.php/", $url)) { ?>

    <section id="mb_login_notmb" class="mbskin">
        <h2>비회원 구매</h2>

        <p>
            비회원으로 주문하시는 경우 포인트는 지급하지 않습니다.
        </p>
        <div class="privacy_check">
            <input type="checkbox" name="chk_all" id="chk_all">
            <label for="chk_all"><span></span>전체동의</label>

        </div>

        <div id="guest_privacy">
            <?php echo $default['de_guest_privacy']; ?>
            
        </div>

        <div class="privacy_check">
            <input type="checkbox" id="agree" value="1">
            <label for="agree"><span></span>구매이용약관 대한 내용을 읽었으며 이에 동의합니다.</label>
        </div>
        <div class="privacy_check">
            <input type="checkbox" id="agree2" value="1">
            <label for="agree2"><span></span>개인정보수집에 대한 내용을 읽었으며 이에 동의합니다.</label>
        </div>
        <div class="privacy_check">
            <input type="checkbox" id="agree3" value="1">
            <label for="agree3"><span></span>개인정보 취급 위탁에 대한 내용을 읽었으며 이에 동의합니다.</label>
        </div>

        <div class="btn_confirm">
            <a href="javascript:guest_submit(document.flogin);" class="btn_submit">비회원으로 구매하기</a>
        </div>

        <script>
        function guest_submit(f)
        {
            if (document.getElementById('agree')) {
                if (!document.getElementById('agree').checked) {
                    alert("구매이용약관에 대한 내용을 읽고 이에 동의하셔야 합니다.");
                    return;
                }
            }
            if (document.getElementById('agree2')) {
                if (!document.getElementById('agree2').checked) {
                    alert("개인정보수집에 대한 내용을 읽고 이에 동의하셔야 합니다.");
                    return;
                }
            }
            if (document.getElementById('agree3')) {
                if (!document.getElementById('agree3').checked) {
                    alert("개인정보 취급 위탁에 대한 내용을 읽고 이에 동의하셔야 합니다.");
                    return;
                }
            }
            f.url.value = "<?php echo $url; ?>";
            f.action = "<?php echo $url; ?>";
            f.submit();
        }
        jQuery(function($){
            // 모두선택
            $("input[name=chk_all]").click(function() {
                if ($(this).prop('checked')) {
                    $("input[id^=agree]").prop('checked', true);
                } else {
                    $("input[id^=agree]").prop("checked", false);
                }
            });
        });

        </script>
    </section>

    <?php } ?>

    <?php } ?>
    <?php // 쇼핑몰 사용시 여기까지 반드시 복사해 넣으세요 ?>


</div>

</div>
</div>
<script>
$(function(){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f)
{
    return true;
}
</script>
<!-- } 로그인 끝 -->
