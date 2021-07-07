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

    <?php if($member_check == 0) { ?>
        <div id="mb_login_msgbox"> <?php echo $error_msg; ?></div>
        <a href="<?php echo G5_BBS_URL ?>/member_login.php"><div id="mb_login_rt_button">돌아가기</div></a>
    <?php } else {  ?>
        <div id="mb_login_msgbox"> 패스워드가 성공적으로 변경되었습니다. 아래 로그인 버튼을 클릭하여, 로그인 후 새롭게 단장한 아크로패스를 경험해보세요!</div>
        <a href="<?php echo G5_BBS_URL ?>/login.php"><div id="mb_login_to_button">로그인</div></a>
    <?php } ?>
    <div id="mb_login_bottom"></div>

    

    


</div>

</div>

<script>
function flogin_submit(f)
{
    return true;
}
</script>
<!-- } 로그인 끝 -->
