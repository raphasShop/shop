<?php
$sub_menu = '111502';
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

// 로그인을 바로 이 주소로 하는 경우 쇼핑몰설정값이 사라지는 현상을 방지
//if (!$_POST['ch_link_tel_number']) goto_url("./config_link.php");

#######################################################################################

//추천쇼핑몰관련 설정 업데이트 (쇼핑몰설정 configform.php에서 하지않고 새로만듦 - 크림장수소스)

#######################################################################################

// 추천쇼핑몰이미지 삭제
if ($_POST['market_logo_del1'])  @unlink(G5_DATA_PATH."/common/market_logo1");
if ($_POST['market_logo_del2'])  @unlink(G5_DATA_PATH."/common/market_logo2");
if ($_POST['market_logo_del3'])  @unlink(G5_DATA_PATH."/common/market_logo3");
if ($_POST['market_logo_del4'])  @unlink(G5_DATA_PATH."/common/market_logo4");
if ($_POST['market_logo_del5'])  @unlink(G5_DATA_PATH."/common/market_logo5");
if ($_POST['market_logo_del6'])  @unlink(G5_DATA_PATH."/common/market_logo6");
if ($_POST['market_logo_del7'])  @unlink(G5_DATA_PATH."/common/market_logo7");
if ($_POST['market_logo_del8'])  @unlink(G5_DATA_PATH."/common/market_logo8");
if ($_POST['market_logo_del9'])  @unlink(G5_DATA_PATH."/common/market_logo9");
if ($_POST['market_logo_del10'])  @unlink(G5_DATA_PATH."/common/market_logo10");

// 추천쇼핑몰이미지 업로드
if ($_FILES['market_logo1']['name']) upload_file($_FILES['market_logo1']['tmp_name'], "market_logo1", G5_DATA_PATH."/common");
if ($_FILES['market_logo2']['name']) upload_file($_FILES['market_logo2']['tmp_name'], "market_logo2", G5_DATA_PATH."/common");
if ($_FILES['market_logo3']['name']) upload_file($_FILES['market_logo3']['tmp_name'], "market_logo3", G5_DATA_PATH."/common");
if ($_FILES['market_logo4']['name']) upload_file($_FILES['market_logo4']['tmp_name'], "market_logo4", G5_DATA_PATH."/common");
if ($_FILES['market_logo5']['name']) upload_file($_FILES['market_logo5']['tmp_name'], "market_logo5", G5_DATA_PATH."/common");
if ($_FILES['market_logo6']['name']) upload_file($_FILES['market_logo6']['tmp_name'], "market_logo6", G5_DATA_PATH."/common");
if ($_FILES['market_logo7']['name']) upload_file($_FILES['market_logo7']['tmp_name'], "market_logo7", G5_DATA_PATH."/common");
if ($_FILES['market_logo8']['name']) upload_file($_FILES['market_logo8']['tmp_name'], "market_logo8", G5_DATA_PATH."/common");
if ($_FILES['market_logo9']['name']) upload_file($_FILES['market_logo9']['tmp_name'], "market_logo9", G5_DATA_PATH."/common");
if ($_FILES['market_logo10']['name']) upload_file($_FILES['market_logo10']['tmp_name'], "market_logo10", G5_DATA_PATH."/common");

//
// 영카트 default 추천쇼핑몰관련 설정정보 업데이트
//

$sql = " update {$g5['g5_shop_default_table']}
            set ch_link_tel_number          = '{$_POST['ch_link_tel_number']}',
				ch_link_kakaoplus_url       = '{$_POST['ch_link_kakaoplus_url']}',
                ch_link_baro_use            = '{$_POST['ch_link_baro_use']}',
			    ch_link_market_name1        = '{$_POST['ch_link_market_name1']}',
			    ch_link_market_name2        = '{$_POST['ch_link_market_name2']}',
				ch_link_market_name3        = '{$_POST['ch_link_market_name3']}',
				ch_link_market_name4        = '{$_POST['ch_link_market_name4']}',
				ch_link_market_name5        = '{$_POST['ch_link_market_name5']}',
				ch_link_market_name6        = '{$_POST['ch_link_market_name6']}',
				ch_link_market_name7        = '{$_POST['ch_link_market_name7']}',
				ch_link_market_name8        = '{$_POST['ch_link_market_name8']}',
				ch_link_market_name9        = '{$_POST['ch_link_market_name9']}',
				ch_link_market_name10       = '{$_POST['ch_link_market_name10']}'				
                ";
sql_query($sql);

goto_url("./config_link.php");
?>
