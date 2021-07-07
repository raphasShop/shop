<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원정보 찾기 시작 { -->
<div id="find_info" class="new_win">
    <h1 id="win_title">회원정보 찾기</h1>
    <div class="new_win_con">
        <form name="fpasswordfind" action="<?php echo $action_url ?>" onsubmit="return fpasswordfind_submit(this);" method="post" autocomplete="off">
        <fieldset id="info_fs">
            <p>
                가입하신 계정의 아이디와 이름 및 휴대폰 번호를 입력해주세요.<br>
                해당 휴대폰번호로 임시비밀번호를 보내드립니다.
            </p>
            <input type="text" id="mb_id" name="mb_id" placeholder="아이디(필수)" required class="frm_input required">
            <input type="text" id="mb_name" name="mb_name" placeholder="이름(필수)" required class="frm_input required">
            <input type="text" id="mb_phone" name="mb_phone" placeholder="핸드폰번호(필수)" required class="frm_input required">
        </fieldset>
        <input type="submit" value="비밀번호찾기" class="btn_submit">

    </div>
    <button type="button" onclick="window.close();" class="btn_close">창닫기</button>

    </form>
</div>

<script>
function fpasswordfind_submit(f)
{
    return true;
}

$(function() {
    var sw = screen.width;
    var sh = screen.height;
    var cw = document.body.clientWidth;
    var ch = document.body.clientHeight;
    var top  = sh / 2 - ch / 2 - 100;
    var left = sw / 2 - cw / 2;
    moveTo(left, top);
});
</script>
<!-- } 회원정보 찾기 끝 -->