<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>


<div id="mypage_wrap">
    <div class="mypage_con_wrap">
        <div class="confirm_title">정보변경</div>
        <div class="confirm_image_wrap"><img src="<?php echo G5_IMG_URL ?>/register_icon.png"></div>
        <div class="confirm_guide">
            <?php if ($url == 'member_leave.php') { ?>
            비밀번호를 입력하시면 회원탈퇴가 완료됩니다.
            <?php }else{ ?>
            고객님의 개인정보를 안전하게 보호하기 위해<br>다시 한 번 비밀번호를 입력해주세요.
            <?php }  ?>
        </div>
        <div class="confirm_password">
            <form name="fmemberconfirm" action="<?php echo $url ?>" onsubmit="return fmemberconfirm_submit(this);" method="post">
            <input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
            <input type="hidden" name="w" value="u">

            <fieldset>
                <input type="hidden" name="mb_id" id="mb_confirm_id" value="<?php echo $member['mb_id'] ?>" class="frm_input" size="15" maxLength="20" disabled="disabled">
                <label for="confirm_mb_password" class="sound_only">비밀번호<strong>필수</strong></label>
                <input type="password" name="mb_password" id="confirm_mb_password" required class="required frm_input" size="15" maxLength="20" placeholder="비밀번호">
                <input type="submit" value="확인" id="btn_submit" class="btn_submit">
            </fieldset>
            </form>
        </div>
    </div>
</div>

<script>
function fmemberconfirm_submit(f)
{
    document.getElementById("btn_submit").disabled = true;

    return true;
}
</script>
<!-- } 회원 비밀번호 확인 끝 -->