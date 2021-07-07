<?php
$sub_menu = "100602";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '사용자접속제한';
include_once ('./admin.head.php');

$pg_anchor = '<ul class="anchor">
    <li><a href="#anc_cf_ip">접근 허용/차단 아이피</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';
?>
<SCRIPT LANGUAGE="Javascript">
<!-- 중복체크검사
function dedupe_list() {
	var count = 0;
	var cf_intercept_ip = document.fconfigform.cf_intercept_ip.value;
	cf_intercept_ip = cf_intercept_ip.replace(/\r/gi, "\n");
	cf_intercept_ip = cf_intercept_ip.replace(/\n+/gi, "\n");
	
	var listvalues = new Array();
	var newlist = new Array();
	
	listvalues = cf_intercept_ip.split("\n");
	
	var hash = new Object();
	
	for (var i=0; i<listvalues.length; i++)
	{
		if (hash[listvalues[i].toLowerCase()] != 1)
		{
			newlist = newlist.concat(listvalues[i]);
			hash[listvalues[i].toLowerCase()] = 1
		}
		else { count++; }
	}
	document.fconfigform.cf_intercept_ip.value = newlist.join("\r\n");
	alert(count + '개의 중복을 찾아서 정리하였습니다 ..');
}
//-->
</SCRIPT>

<form name="fconfigform" action="./config_contactupdate.php" onsubmit="return fconfigform_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="" id="token">


<!-- 접근차단IP 설정 -->
<section id="anc_cf_ip">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">접근 허용/차단 IP설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>접근차단IP 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_possible_ip" class="deepblue">접근 가능 IP</label></th>
            <td>
                <?php echo help('입력된 IP의 컴퓨터만 접근할 수 있습니다.<br>123.123.+ 도 입력 가능. (엔터로 구분)') ?>
                <textarea name="cf_possible_ip" id="cf_possible_ip"><?php echo $config['cf_possible_ip'] ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_intercept_ip" class="red">접근 차단 IP</label></th>
            <td>
                <?php echo help('입력된 IP의 컴퓨터는 접근할 수 없음.<br>123.123.+ 도 입력 가능. (엔터로 구분)') ?>
                <textarea name="cf_intercept_ip" id="cf_intercept_ip" class="red"><?php echo $config['cf_intercept_ip'] ?></textarea>
                <br><input type="button" onClick="dedupe_list();" class="btn_frmline" style="cursor:pointer; margin-top:5px; margin-right:10px;" value="중복체크">
                <span class="blue">※ 중복체크를 누르시면, 중복되는 아이피를 검사해서 자동으로 삭제하여 정리해줍니다</span>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!--//-->


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
include_once ('./admin.tail.php');
?>
