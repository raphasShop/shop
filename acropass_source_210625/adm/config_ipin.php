<?php
$sub_menu = '200203'; // 본인확인서비스관리(유료/사용설정은 서비스업체 홈페이지에서 가능) 2018-01-31
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '본인확인서비스 설정';
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

// LG유플러스 본인확인 필드 추가
if(!isset($config['cf_lg_mid'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_lg_mid` varchar(255) NOT NULL DEFAULT '' AFTER `cf_cert_kcp_cd`,
                    ADD `cf_lg_mert_key` varchar(255) NOT NULL DEFAULT '' AFTER `cf_lg_mid` ", true);
}
// 본인확인서비스 설정
if(!isset($config['cf_cert_use'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_cert_use` TINYINT(4) NOT NULL DEFAULT '0' AFTER `cf_editor`,
                    ADD `cf_cert_ipin` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_use`,
                    ADD `cf_cert_hp` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_ipin`,
                    ADD `cf_cert_kcb_cd` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_hp`,
                    ADD `cf_cert_kcp_cd` VARCHAR(255) NOT NULL DEFAULT '' AFTER `cf_cert_kcb_cd`,
                    ADD `cf_cert_limit` INT(11) NOT NULL DEFAULT '0' AFTER `cf_cert_kcp_cd` ", true);
    sql_query(" ALTER TABLE `{$g5['member_table']}`
                    CHANGE `mb_hp_certify` `mb_certify` VARCHAR(20) NOT NULL DEFAULT '' ", true);
    sql_query(" update {$g5['member_table']} set mb_certify = 'hp' where mb_certify = '1' ");
    sql_query(" update {$g5['member_table']} set mb_certify = '' where mb_certify = '0' ");
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['cert_history_table']}` (
                  `cr_id` int(11) NOT NULL auto_increment,
                  `mb_id` varchar(255) NOT NULL DEFAULT '',
                  `cr_company` varchar(255) NOT NULL DEFAULT '',
                  `cr_method` varchar(255) NOT NULL DEFAULT '',
                  `cr_ip` varchar(255) NOT NULL DEFAULT '',
                  `cr_date` date NOT NULL DEFAULT '0000-00-00',
                  `cr_time` time NOT NULL DEFAULT '00:00:00',
                  PRIMARY KEY (`cr_id`),
                  KEY `mb_id` (`mb_id`)
                )", true);
}
// 본인확인 필수 필드 추가
if(!isset($config['cf_cert_req'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_cert_req` tinyint(4) NOT NULL DEFAULT '0' AFTER `cf_cert_limit` ", true);
}

?>

<form name="fconfigform" action="./config_ipinupdate.php" onsubmit="return fconfigform_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="" id="token">

<!-- 본인확인서비스설정 { -->
<section id="anc_cf_cert">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">아이핀/휴대폰 본인확인 서비스 사용</h2>
    <div class="local_desc02 local_desc">
        <p>
            회원가입 시 본인확인 수단을 설정합니다.<br>
            실명과 휴대폰 번호 그리고 본인확인 당시에 성인인지의 여부를 저장합니다.<br>
            게시판의 경우 본인확인 또는 성인여부를 따져 게시물 조회 및 쓰기 권한을 줄 수 있습니다.
        </p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>본인확인 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_cert_use">본인확인</label></th>
            <td>
                <select name="cf_cert_use" id="cf_cert_use">
                    <?php echo option_selected("0", $config['cf_cert_use'], "사용안함"); ?>
                    <?php echo option_selected("1", $config['cf_cert_use'], "테스트"); ?>
                    <?php echo option_selected("2", $config['cf_cert_use'], "실서비스"); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_ipin">아이핀 본인확인</label></th>
            <td class="cf_cert_service">
                <select name="cf_cert_ipin" id="cf_cert_ipin">
                    <?php echo option_selected("",    $config['cf_cert_ipin'], "사용안함"); ?>
                    <?php echo option_selected("kcb", $config['cf_cert_ipin'], "코리아크레딧뷰로(KCB) 아이핀"); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_hp">휴대폰 본인확인</label></th>
            <td class="cf_cert_service">
                <select name="cf_cert_hp" id="cf_cert_hp">
                    <?php echo option_selected("",    $config['cf_cert_hp'], "사용안함"); ?>
                    <?php echo option_selected("kcb", $config['cf_cert_hp'], "코리아크레딧뷰로(KCB) 휴대폰 본인확인"); ?>
                    <?php echo option_selected("kcp", $config['cf_cert_hp'], "NHN KCP 휴대폰 본인확인"); ?>
                    <?php echo option_selected("lg",  $config['cf_cert_hp'], "LG유플러스 휴대폰 본인확인"); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_kcb_cd">코리아크레딧뷰로<br>KCB 회원사ID</label></th>
            <td class="cf_cert_service">
                <?php echo help('KCB 회원사ID를 입력해 주십시오.<br>서비스에 가입되어 있지 않다면, KCB와 계약체결 후 회원사ID를 발급 받으실 수 있습니다.<br>이용하시려는 서비스에 대한 계약을 아이핀, 휴대폰 본인확인 각각 체결해주셔야 합니다.<br>아이핀 본인확인 테스트의 경우에는 KCB 회원사ID가 필요 없으나,<br>휴대폰 본인확인 테스트의 경우 KCB 에서 따로 발급 받으셔야 합니다.') ?>
                <input type="text" name="cf_cert_kcb_cd" value="<?php echo $config['cf_cert_kcb_cd'] ?>" id="cf_cert_kcb_cd" class="frm_input" size="20"> <a href="http://sir.kr/main/service/b_ipin.php" target="_blank" class="btn_frmline">KCB 아이핀 서비스 신청페이지</a>
                <a href="http://sir.kr/main/service/b_cert.php" target="_blank" class="btn_frmline">KCB 휴대폰 본인확인 서비스 신청페이지</a>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_kcp_cd">NHN KCP 사이트코드</label></th>
            <td class="cf_cert_service">
                <?php echo help('SM으로 시작하는 5자리 사이트 코드중 뒤의 3자리만 입력해 주십시오.<br>서비스에 가입되어 있지 않다면, 본인확인 서비스 신청페이지에서 서비스 신청 후 사이트코드를 발급 받으실 수 있습니다.') ?>
                <span class="sitecode">SM</span>
                <input type="text" name="cf_cert_kcp_cd" value="<?php echo $config['cf_cert_kcp_cd'] ?>" id="cf_cert_kcp_cd" class="frm_input" size="3"> <a href="http://sir.kr/main/service/p_cert.php" target="_blank" class="btn_frmline">NHN KCP 휴대폰 본인확인 서비스 신청페이지</a>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_lg_mid">LG유플러스 상점아이디</label></th>
            <td class="cf_cert_service">
                <?php echo help('LG유플러스 상점아이디 중 si_를 제외한 나머지 아이디만 입력해 주십시오.<br>서비스에 가입되어 있지 않다면, 본인확인 서비스 신청페이지에서 서비스 신청 후 상점아이디를 발급 받으실 수 있습니다.<br><strong>LG유플러스 휴대폰본인확인은 ActiveX 설치가 필요하므로 Internet Explorer 에서만 사용할 수 있습니다.</strong>') ?>
                <span class="sitecode">si_</span>
                <input type="text" name="cf_lg_mid" value="<?php echo $config['cf_lg_mid'] ?>" id="cf_lg_mid" class="frm_input" size="20"> <a href="http://sir.kr/main/service/lg_cert.php" target="_blank" class="btn_frmline">LG유플러스 본인확인 서비스 신청페이지</a>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_lg_mert_key">LG유플러스 MERT KEY</label></th>
            <td class="cf_cert_service">
                <?php echo help('LG유플러스 상점MertKey는 상점관리자 -> 계약정보 -> 상점정보관리에서 확인하실 수 있습니다.') ?>
                <input type="text" name="cf_lg_mert_key" value="<?php echo $config['cf_lg_mert_key'] ?>" id="cf_lg_mert_key" class="frm_input w100per">
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_limit">본인확인 이용제한</label></th>
            <td class="cf_cert_service">
                <?php echo help('하루동안 아이핀과 휴대폰 본인확인 인증 이용회수를 제한할 수 있습니다.<br>회수제한은 실서비스에서 아이핀과 휴대폰 본인확인 인증에 개별 적용됩니다.<br>0 으로 설정하시면 회수제한이 적용되지 않습니다.'); ?>
                <input type="text" name="cf_cert_limit" value="<?php echo $config['cf_cert_limit']; ?>" id="cf_cert_limit" class="frm_input" size="3"> 회
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_req">본인확인 필수</label></th>
            <td class="cf_cert_service">
                <?php echo help('회원가입 때 본인확인을 필수로 할지 설정합니다. 필수로 설정하시면 본인확인을 하지 않은 경우 회원가입이 안됩니다.'); ?>
                <input type="checkbox" name="cf_cert_req" value="1" id="cf_cert_req"<?php echo get_checked($config['cf_cert_req'], 1); ?>> 예
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

<script>
$(function(){
    <?php
    if(!$config['cf_cert_use'])
        echo '$(".cf_cert_service").addClass("cf_cert_hide");';
    ?>
    $("#cf_cert_use").change(function(){
        switch($(this).val()) {
            case "0":
                $(".cf_cert_service").addClass("cf_cert_hide");
                break;
            default:
                $(".cf_cert_service").removeClass("cf_cert_hide");
                break;
        }
    });
});
</script>

<?php
// 본인확인 모듈 실행권한 체크
if($config['cf_cert_use']) {
    // kcb일 때
    if($config['cf_cert_ipin'] == 'kcb' || $config['cf_cert_hp'] == 'kcb') {
        // 실행모듈
        if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            if(PHP_INT_MAX == 2147483647) // 32-bit
                $exe = G5_OKNAME_PATH.'/bin/okname';
            else
                $exe = G5_OKNAME_PATH.'/bin/okname_x64';
        } else {
            if(PHP_INT_MAX == 2147483647) // 32-bit
                $exe = G5_OKNAME_PATH.'/bin/okname.exe';
            else
                $exe = G5_OKNAME_PATH.'/bin/oknamex64.exe';
        }

        echo module_exec_check($exe, 'okname');
    }

    // kcp일 때
    if($config['cf_cert_hp'] == 'kcp') {
        if(PHP_INT_MAX == 2147483647) // 32-bit
            $exe = G5_KCPCERT_PATH . '/bin/ct_cli';
        else
            $exe = G5_KCPCERT_PATH . '/bin/ct_cli_x64';

        echo module_exec_check($exe, 'ct_cli');
    }

    // LG의 경우 log 디렉토리 체크
    if($config['cf_cert_hp'] == 'lg') {
        $log_path = G5_LGXPAY_PATH.'/lgdacom/log';

        if(!is_dir($log_path)) {
            echo '<script>'.PHP_EOL;
            echo 'alert("'.str_replace(G5_PATH.'/', '', G5_LGXPAY_PATH).'/lgdacom 폴더 안에 log 폴더를 생성하신 후 쓰기권한을 부여해 주십시오.\n> mkdir log\n> chmod 707 log");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        } else {
            if(!is_writable($log_path)) {
                echo '<script>'.PHP_EOL;
                echo 'alert("'.str_replace(G5_PATH.'/', '',$log_path).' 폴더에 쓰기권한을 부여해 주십시오.\n> chmod 707 log");'.PHP_EOL;
                echo '</script>'.PHP_EOL;
            }
        }
    }
}
?>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
