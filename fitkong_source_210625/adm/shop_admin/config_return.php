<?php
$sub_menu = '111113'; /* (새로만듬)반품/교환/환불설정 */
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '반품/교환/환불설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$pg_anchor = '<ul class="anchor">
<li><a href="#anc_return_addr">반품주소</a></li>
<li><a href="#anc_return_info">교환/반품안내</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';
?>

<form name="fconfig" action="./config_returnupdate.php" onsubmit="return fconfig_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="">

<!-- 반품주소설정 { -->
<section id="anc_return_addr">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm">반품주소설정&nbsp;&nbsp;<span class="help2">쇼핑몰기본설정&gt;사업자정보 에서도 반품주소를 등록할 수 있습니다</span></h2>
    
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>반품주소 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <!--반품주소-->
        <tr>
            <th scope="row" colspan="2" style="height:45px;background:#fff;"><i class="fas fa-truck"></i> 반품주소 <span class="help1">※고객이 반품시 상품을 받을 수 있는 반품주소를 기재할 수 있습니다</span></th>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_return_zip">반품주소 우편번호</label></th>
            <td>
                <input type="text" name="de_admin_return_zip" value="<?php echo $default['de_admin_return_zip']; ?>" id="de_admin_return_zip" class="frm_input" size="10">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_return_addr">반품주소</label></th>
            <td>
                <input type="text" name="de_admin_return_addr" value="<?php echo $default['de_admin_return_addr']; ?>" id="de_admin_return_addr" class="frm_input w100per">
            </td>
        </tr>
        <!--//-->
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!-- // -->

<!-- 교환/반품/안내 설정 { -->
<section id="anc_return_info">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm">교환/반품 안내</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>교환/반품 설정 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row">교환/반품</th>
            <td><?php echo editor_html('de_change_content', get_text($default['de_change_content'], 0)); ?></td>
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
    <a href="<?php echo G5_SHOP_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/shop_icon.png" border="0" title="쇼핑몰">&nbsp;&nbsp;</a>
    </div>
    
    <div class="bq_basic_submit">
    <input type="submit" value="확인" accesskey="s">
    </div>
    
</div>
<!--//-->

</form>

<script>
function fconfig_check(f)
{
    <?php echo get_editor_js('de_change_content'); ?>

    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
