<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<div id="login_pc_wrap">
<!-- 로그인 시작 { -->
<div id="mb_login" class="mbskin">
    <div class="login_logo"><img src="<?php echo G5_IMG_URL ?>/acropass_logo.png?0122" alt="<?php echo $g5['title'] ?>"></div>
    <div class="login_slogan">Beauty Device 아크로패스</div>

    <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post" id="flogin">
    <input type="hidden" name="url" value="<?php echo $login_url ?>">

    <div id="login_frm">
        <label for="login_id" class="sound_only">아이디<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="mb_id" id="login_id" value="<?php echo $mb_id; ?>" placeholder="아이디" required class="frm_input required" maxLength="20">
        <label for="id_pwd" class="sound_only">비밀번호<strong class="sound_only"> 필수</strong></label>
        <input type="password" name="od_pwd" id="od_pwd" placeholder="비밀번호" required class="frm_input required">
        <label for="id_pwd_re" class="sound_only">비밀번호확인<strong class="sound_only"> 필수</strong></label>
        <input type="password" name="od_pwd_re" id="od_pwd_re" placeholder="비밀번호확인" required class="frm_input required">
        
        <input type="submit" value="정보변경" class="btn_submit">
    </div>
    <div id="mb_login_msgbox">새로운 패스워드를 입력해주세요!</div>

    


</div>

</div>

<script>
function flogin_submit(f)
{
    return true;
}
</script>
<!-- } 로그인 끝 -->
