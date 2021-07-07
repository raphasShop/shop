<?php
$sub_menu = '200202'; // 회원가입약관 및 개인정보처리방침
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '회원가입약관 및 개인정보처리방침';
include_once (G5_ADMIN_PATH.'/admin.head.php');
/*
$pg_anchor = '<ul class="anchor">
<li><a href="#anc_ch_basic">기본설정</a></li>
<li><a href="#anc_ch_market">추천쇼핑몰관리</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';
*/
$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';
?>

<form name="fconfigform" action="./config_reg_privacyupdate.php" onsubmit="return fconfigform_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="" id="token">

<!-- 회원가입약관 { -->
<section id="anc_cf_join">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">회원가입약관</h2>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>회원가입약관</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_stipulation">회원가입약관</label></th>
            <td><textarea name="cf_stipulation" id="cf_stipulation" rows="20"><?php echo $config['cf_stipulation'] ?></textarea></td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!-- // --> 

<!-- 개인정보처리방침 { -->
<section id="anc_cf_join">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">개인정보처리방침</h2>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>개인정보처리방침</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_privacy">개인정보처리방침</label></th>
            <td><textarea id="cf_privacy" name="cf_privacy" rows="20"><?php echo $config['cf_privacy'] ?></textarea></td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!-- // --> 


<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">   
    <div class="bq_basic_icon">
    <a href="<?php echo G5_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/home_icon.png" border="0" title="홈"></a>
    <a href="<?php echo G5_SHOP_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/shop_icon.png" border="0" title="쇼핑몰">&nbsp;&nbsp;</a>
    </div>
    
    <div class="bq_basic_submit">
    <input type="submit" value="확인" accesskey="s">
    </div>
</div>
<!--//-->

</form>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
