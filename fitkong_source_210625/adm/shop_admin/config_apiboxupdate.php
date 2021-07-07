<?php
$sub_menu = '100501'; // 무통장입금 자동확인 서비스관련(유료/사용설정은 서비스업체 홈페이지에서 가능) 2017-12-07
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

check_admin_token();

// 로그인을 바로 이 주소로 하는 경우 쇼핑몰설정값이 사라지는 현상을 방지
//if (!$_POST['ch_link_tel_number']) goto_url("./config_link.php");

#######################################################################################

//알뱅킹 사용 설정 업데이트 (쇼핑몰설정 configform.php에서 하지않고 새로만듦 - 크림장수소스)

#######################################################################################

//
// 영카트 default 알뱅킹 설정정보 업데이트
//

$sql = " update {$g5['g5_shop_default_table']}
            set apibox_use          = '{$_POST['apibox_use']}',
				apibox_id           = '{$_POST['apibox_id']}'				
                ";
sql_query($sql);

goto_url("./config_apibox.php");
?>
