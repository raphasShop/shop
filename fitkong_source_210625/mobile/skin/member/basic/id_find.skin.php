<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css?date=20190506">', 0);
?>

<div id="mo_color_background">
<div id="login_mo_wrap">
<!-- 로그인 시작 { -->
<div id="mb_login" class="mbskin">
    <div class="login_logo"><img src="<?php echo G5_IMG_URL ?>/login_logo.png" alt="<?php echo $g5['title'] ?>"></div>
    <?php if (preg_match("/password_find.php$/", $url)) { ?>
    <div id="login_menu_wrap">
        <a href="<?php echo G5_BBS_URL ?>/id_find.php"><div class="login_menu_button">아이디 찾기</div></a><a href="<?php echo G5_BBS_URL ?>/password_find.php"><div class="login_menu_button menu_select">비밀번호 찾기</div></a>
    </div>
    <?php } else { ?>
    <div id="login_menu_wrap">
        <a href="<?php echo G5_BBS_URL ?>/id_find.php"><div class="login_menu_button menu_select">아이디 찾기</div></a><a href="<?php echo G5_BBS_URL ?>/password_find.php"><div class="login_menu_button">비밀번호 찾기</div></a>
    </div>
    <?php } ?>
<!-- 회원정보 찾기 시작 { -->
    <div class="mbskin" id="mb_login_find">
    <div id="find_info">
        <div id="flogin">
            <form name="fidfind" action="<?php echo $action_url ?>" onsubmit="return fidfind_submit(this);" method="post" autocomplete="off">
            <fieldset id="info_fs">
                <input type="text" id="mb_name" name="mb_name" placeholder="이름(필수)" required class="frm_input">
                <input type="text" id="mb_phone" name="mb_phone" placeholder="핸드폰번호(필수)" required class="frm_input">
                <div class="login_notice">
                    <img src="<?php echo G5_IMG_URL ?>/register_error_icon.png" alt="" class="login_find_notice">
                    <p>
                        가입하신 계정의 이름과 휴대폰 번호를 입력해주세요. 해당 휴대폰번호로 아이디 정보를 보내드립니다.
                    </p>
                </div>
            </fieldset>
            <input type="submit" value="비밀번호찾기" class="btn_submit">

        </div>
        </form>
    </div>
    </div>

</div>
</div>
</div>

<script>
function fidfind_submit(f)
{
    return true;
}


</script>
