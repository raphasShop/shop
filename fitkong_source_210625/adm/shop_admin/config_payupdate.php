<?php
$sub_menu = '111114'; /* (새로만듬)결제/적립설정 */
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

// 로그인을 바로 이 주소로 하는 경우 쇼핑몰설정값이 사라지는 현상을 방지
//if (!$_POST['de_bank_use']) goto_url("./config_pay.php");

#######################################################################################

//결제 기본 설정 업데이트 (쇼핑몰설정 configform.php에서 분할되어나옴 - 아이스크림)

#######################################################################################

$sql = " update {$g5['g5_shop_default_table']}
            set de_bank_use                   = '{$_POST['de_bank_use']}',
                de_bank_account               = '{$_POST['de_bank_account']}',
				de_iche_use                   = '{$_POST['de_iche_use']}',
				de_vbank_use                  = '{$_POST['de_vbank_use']}',
				de_hp_use                     = '{$_POST['de_hp_use']}',
				de_card_use                   = '{$_POST['de_card_use']}',
				de_card_noint_use             = '{$_POST['de_card_noint_use']}',
				de_easy_pay_use               = '{$_POST['de_easy_pay_use']}',
				de_taxsave_use                = '{$_POST['de_taxsave_use']}',
				de_settle_min_point           = '{$_POST['de_settle_min_point']}',
                de_settle_max_point           = '{$_POST['de_settle_max_point']}',
                de_settle_point_unit          = '{$_POST['de_settle_point_unit']}',
				de_card_point                 = '{$_POST['de_card_point']}',
				de_point_days                 = '{$_POST['de_point_days']}'
                ";
sql_query($sql);

// 환경설정 > 포인트 사용
sql_query(" update {$g5['config_table']} set cf_use_point = '{$_POST['cf_use_point']}' ");

goto_url("./config_pay.php");
?>
