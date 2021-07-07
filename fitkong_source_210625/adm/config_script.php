<?php
$sub_menu = '155202'; // 레이아웃추가설정,script/css 추가
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '레이아웃추가설정';
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

//스크립트추가 필드추가
if (!isset($config['cf_add_script'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_add_script` TEXT NOT NULL AFTER `cf_admin_email_name` ", true);
}
?>

<form name="fconfigform" action="./config_scriptupdate.php" onsubmit="return fconfigform_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="" id="token">

<!-- 레이아웃추가설정 { -->
<section id="anc_cf_lay">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm">레이아웃 추가설정</h2>
    <div class="local_desc02 local_desc">
        <p>기본 설정된 파일 경로 및 script, css 를 추가하거나 변경할 수 있습니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>레이아웃 추가설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_add_script">추가 script, css</label></th>
            <td>
                <?php echo help('HTML의 &lt;/HEAD&gt; 태그위로 추가될 JavaScript와 css 코드를 설정합니다.<br>관리자 페이지에서는 이 코드를 사용하지 않습니다.') ?>
                <textarea name="cf_add_script" id="cf_add_script"><?php echo get_text($config['cf_add_script']); ?></textarea>
            </td>
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
