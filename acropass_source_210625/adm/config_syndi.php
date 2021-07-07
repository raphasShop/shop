<?php
$sub_menu = '100104'; // 네이버신디케이션
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '네이버 신디케이션';
include_once (G5_ADMIN_PATH.'/admin.head.php');
/*
$pg_anchor = '<ul class="anchor">
<li><a href="#anc_ch_basic">기본설정</a></li>
<li><a href="#anc_ch_market">추천쇼핑몰관리</a></li>
</ul>';
*/
$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

// 신디케이션
if (!isset($config['cf_syndi_token'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_syndi_token` VARCHAR(255) NOT NULL AFTER `cf_add_meta` ", true);
}
// 신디케이션
if (!isset($config['cf_syndi_except'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_syndi_except` TEXT NOT NULL AFTER `cf_syndi_token` ", true);
}

?>

<form name="fconfigform" action="./config_syndiupdate.php" onsubmit="return fconfigform_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="" id="token">

<!-- 네이버신디케이션 { -->
<section id="anc_cf_syndi">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">네이버 신디케이션</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>네이버신디케이션</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_syndi_token">네이버 신디케이션 연동키</label></th>
            <td>
                <?php if (!function_exists('curl_init')) echo help('<b>경고) curl이 지원되지 않아 네이버 신디케이션을 사용할수 없습니다.</b>'); ?>
                <?php echo help('네이버 신디케이션 연동키(token)을 입력하면 네이버 신디케이션을 사용할 수 있습니다.<br>연동키는 <a href="http://webmastertool.naver.com/" target="_blank"><u>네이버 웹마스터도구</u></a> -> 네이버 신디케이션에서 발급할 수 있습니다.') ?>
                <input type="text" name="cf_syndi_token" value="<?php echo $config['cf_syndi_token'] ?>" id="cf_syndi_token" class="frm_input w100per">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_syndi_except">네이버 신디케이션 제외게시판</label></th>
            <td>
                <?php echo help('네이버 신디케이션 수집에서 제외할 게시판 아이디를 | 로 구분하여 입력하십시오. 예) notice|adult<br>참고로 그룹접근사용 게시판, 글읽기 권한 2 이상 게시판, 비밀글은 신디케이션 수집에서 제외됩니다.') ?>
                <input type="text" name="cf_syndi_except" value="<?php echo $config['cf_syndi_except'] ?>" id="cf_syndi_except" class="frm_input w100per">
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>
<!-- // --> 

<?php// echo $frm_submit; //저장버튼?>

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
