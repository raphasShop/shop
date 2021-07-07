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
        <input type="text" name="mb_id" id="login_id" placeholder="아이디" required class="frm_input required" maxLength="20">
        <label for="member_birth" class="sound_only">생년월일<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="mb_birth" id="member_birth" placeholder="생년월일(ex. 19980223)" class="frm_input" maxLength="20">
        <label for="member_email" class="sound_only">이메일<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="mb_email" id="member_email" placeholder="이메일" class="frm_input" maxLength="50">
       
       <input type="submit" value="정보확인" class="btn_submit">
    </div>

    <div id="mb_login_msgbox">기존에 가입하셨던 <b>아이디</b>와 <b>생년월일</b> 또는 <b>이메일</b>을 입력해주시면 인증을 통해 패스워드를 변경하실 수 있습니다.</div>
    <div id="mb_login_msgbox">기존에 소셜 계정으로 가입하셨던 고객님들은 보안 관계로 새로 가입을 진행해주시면 <b>신규회원 혜택인 쿠폰과 적립금을 제공</b>받으실 수 있으며, 기존 회원 정보 확인을 통해 <b>적립금도 같이 이전</b>해드리고 있사오니 조금 불편하시더라도 이 점 양해 부탁드립니다.</div>


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
