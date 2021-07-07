<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<div id="top_sub_gnb">
    <div class="top_sub_wrap">회원정보수정</div>
    <div class="top_back_btn"><a href="javascript:history.back();"><i class="xi-angle-left"></i></a></div>
</div>
<div id="mb_confirm" class="mbskin">
    <div class="member_symbol_icon"><i class="xi-user"></i></div>
    <p>
        <strong>비밀번호를 한번 더 입력해주세요.</strong>
        <?php if ($url == 'member_leave.php') { ?>
        비밀번호를 입력하시면 회원탈퇴가 완료됩니다.
        <?php }else{ ?>
        회원님의 정보를 안전하게 보호하기 위해 비밀번호를 한번 더 확인합니다.
        <?php }  ?>
    </p>

    <form name="fmemberconfirm" action="<?php echo $url ?>" onsubmit="return fmemberconfirm_submit(this);" method="post">
    <input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
    <input type="hidden" name="w" value="u">

    <fieldset>
        <input type="text" name="mb_id" id="mb_confirm_id" value="<?php echo $member['mb_id'] ?>" class="frm_input" size="15" maxLength="20" disabled="disabled">
        <input type="password" name="mb_password" id="mb_confirm_pw" placeholder="비밀번호(필수)" required class="frm_input" size="15" maxLength="20">
        <input type="submit" value="확인" id="btn_submit" class="btn_submit">
    </fieldset>

    </form>

</div>

<script>
function fmemberconfirm_submit(f)
{
    document.getElementById("btn_submit").disabled = true;

    return true;
}
</script>
