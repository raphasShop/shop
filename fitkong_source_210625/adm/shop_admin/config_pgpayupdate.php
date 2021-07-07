<?php
$sub_menu = '111115'; /* (새로만듬) PG/간편페이 설정 */
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

// 로그인을 바로 이 주소로 하는 경우 쇼핑몰설정값이 사라지는 현상을 방지
//if (!$_POST['de_bank_use']) goto_url("./config_pay.php");

#######################################################################################

//PG/간편페이 설정 업데이트 (쇼핑몰설정 configform.php에서 분할되어나옴 - 아이스크림)

#######################################################################################

$de_kcp_mid = substr($_POST['de_kcp_mid'],0,3);

// kcp 전자결제를 사용할 때 site key 입력체크
if($_POST['de_pg_service'] == 'kcp' && !$_POST['de_card_test'] && ($_POST['de_iche_use'] || $_POST['de_vbank_use'] || $_POST['de_hp_use'] || $_POST['de_card_use'])) {
    if(trim($_POST['de_kcp_site_key']) == '')
        alert('NHN KCP SITE KEY를 입력해 주십시오.');
}

$sql = " update {$g5['g5_shop_default_table']}
            set de_card_test                  = '{$_POST['de_card_test']}',
			    de_escrow_use                 = '{$_POST['de_escrow_use']}',
				de_tax_flag_use               = '{$_POST['de_tax_flag_use']}',
				de_pg_service                 = '{$_POST['de_pg_service']}',
				de_kcp_mid                    = '{$_POST['de_kcp_mid']}',
                de_kcp_site_key               = '{$_POST['de_kcp_site_key']}',
				de_inicis_mid                 = '{$_POST['de_inicis_mid']}',
                de_inicis_admin_key           = '{$_POST['de_inicis_admin_key']}',
                de_inicis_sign_key            = '{$_POST['de_inicis_sign_key']}',
				de_samsung_pay_use            = '{$_POST['de_samsung_pay_use']}',
				de_inicis_lpay_use            = '{$_POST['de_inicis_lpay_use']}',
				de_inicis_cartpoint_use       = '{$_POST['de_inicis_cartpoint_use']}',
				de_kakaopay_mid               = '{$_POST['de_kakaopay_mid']}',
                de_kakaopay_key               = '{$_POST['de_kakaopay_key']}',
                de_kakaopay_enckey            = '{$_POST['de_kakaopay_enckey']}',
                de_kakaopay_hashkey           = '{$_POST['de_kakaopay_hashkey']}',
                de_kakaopay_cancelpwd         = '{$_POST['de_kakaopay_cancelpwd']}',
				de_naverpay_mid               = '{$_POST['de_naverpay_mid']}',
                de_naverpay_cert_key          = '{$_POST['de_naverpay_cert_key']}',
                de_naverpay_button_key        = '{$_POST['de_naverpay_button_key']}',
                de_naverpay_test              = '{$_POST['de_naverpay_test']}',
                de_naverpay_mb_id             = '{$_POST['de_naverpay_mb_id']}',
                de_naverpay_sendcost          = '{$_POST['de_naverpay_sendcost']}'
                ";
sql_query($sql);

// LG 전자결제 설정
$sql = " update {$g5['config_table']}
            set cf_lg_mid               = '{$_POST['cf_lg_mid']}',
                cf_lg_mert_key          = '{$_POST['cf_lg_mert_key']}' ";
sql_query($sql);

// wetoz : naverpayorder
$sql = " update {$g5['g5_shop_default_table']}
            set de_naverpayorder_AccessLicense  = '{$_POST['de_naverpayorder_AccessLicense']}',
                de_naverpayorder_SecretKey      = '{$_POST['de_naverpayorder_SecretKey']}',
                de_naverpayorder_test           = '{$_POST['de_naverpayorder_test']}',
                de_naverpayorder_test_mb_id     = '{$_POST['de_naverpayorder_test_mb_id']}'
                ";
sql_query($sql);

goto_url("./config_pgpay.php");
?>
