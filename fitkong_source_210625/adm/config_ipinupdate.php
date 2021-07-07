<?php
$sub_menu = '200203'; // 본인확인서비스관리(유료/사용설정은 서비스업체 홈페이지에서 가능) 2018-01-31
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

#######################################################################################

//본인확인 사용 설정 업데이트 (기본설정 config_form.php에서 하지않고 새로만듦 - 아이스크림)

#######################################################################################

//
// 본인확인서비스 설정정보 업데이트
//

// 본인확인을 사용할 경우 아이핀, 휴대폰인증 중 하나는 선택되어야 함
if($_POST['cf_cert_use'] && !$_POST['cf_cert_ipin'] && !$_POST['cf_cert_hp'])
    alert('본인확인을 위해 아이핀 또는 휴대폰 본인확인 서비스를 하나이상 선택해 주십시오');

if(!$_POST['cf_cert_use']) {
    $_POST['cf_cert_ipin'] = '';
    $_POST['cf_cert_hp'] = '';
}

$sql = " update {$g5['config_table']}
            set cf_cert_use = '{$_POST['cf_cert_use']}',
                cf_cert_ipin = '{$_POST['cf_cert_ipin']}',
                cf_cert_hp = '{$_POST['cf_cert_hp']}',
                cf_cert_kcb_cd = '{$_POST['cf_cert_kcb_cd']}',
                cf_cert_kcp_cd = '{$_POST['cf_cert_kcp_cd']}',
                cf_lg_mid = '{$_POST['cf_lg_mid']}',
                cf_lg_mert_key = '{$_POST['cf_lg_mert_key']}',
                cf_cert_limit = '{$_POST['cf_cert_limit']}',
                cf_cert_req = '{$_POST['cf_cert_req']}'
                ";
sql_query($sql);

goto_url("./config_ipin.php");
?>
