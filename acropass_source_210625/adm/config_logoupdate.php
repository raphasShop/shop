<?php
$sub_menu = '155201'; /* 사이트로고,파비콘관리 */
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

#####################################################################

// 파비콘 favicon.ico 업로드

#####################################################################

// favicon.ico파일 삭제
if ($_POST['favicon_ico_del'])  @unlink(G5_PATH."/favicon.ico");
// favicon.ico파일 등록
if ($_FILES['favicon_ico']['name']) upload_file($_FILES['favicon_ico']['tmp_name'], "favicon.ico", G5_PATH."/");

#######################################################################################

//사이트 로고 설정 업데이트 (쇼핑몰설정 configform.php에서 분할되어나옴 - 크림장수소스)

#######################################################################################

#####################################################################
//쇼핑몰로고 등록/삭제
#####################################################################
// 쇼핑몰로고이미지 삭제
if ($_POST['logo_img_del'])  @unlink(G5_DATA_PATH."/common/logo_img");
if ($_POST['logo_img_del2'])  @unlink(G5_DATA_PATH."/common/logo_img2");
if ($_POST['mobile_logo_img_del'])  @unlink(G5_DATA_PATH."/common/mobile_logo_img");
if ($_POST['mobile_logo_img_del2'])  @unlink(G5_DATA_PATH."/common/mobile_logo_img2");
// 쇼핑몰로고이미지 등록
if ($_FILES['logo_img']['name']) upload_file($_FILES['logo_img']['tmp_name'], "logo_img", G5_DATA_PATH."/common");
if ($_FILES['logo_img2']['name']) upload_file($_FILES['logo_img2']['tmp_name'], "logo_img2", G5_DATA_PATH."/common");
if ($_FILES['mobile_logo_img']['name']) upload_file($_FILES['mobile_logo_img']['tmp_name'], "mobile_logo_img", G5_DATA_PATH."/common");
if ($_FILES['mobile_logo_img2']['name']) upload_file($_FILES['mobile_logo_img2']['tmp_name'], "mobile_logo_img2", G5_DATA_PATH."/common");

#####################################################################
//커뮤니티로고 등록/삭제
#####################################################################
// 커뮤니티로고이미지 삭제
if ($_POST['clogo_img_del'])  @unlink(G5_DATA_PATH."/common/clogo_img");
if ($_POST['clogo_img_del2'])  @unlink(G5_DATA_PATH."/common/clogo_img2");
if ($_POST['mobile_clogo_img_del'])  @unlink(G5_DATA_PATH."/common/mobile_clogo_img");
if ($_POST['mobile_clogo_img_del2'])  @unlink(G5_DATA_PATH."/common/mobile_clogo_img2");
// 커뮤니티로고이미지 등록
if ($_FILES['clogo_img']['name']) upload_file($_FILES['clogo_img']['tmp_name'], "clogo_img", G5_DATA_PATH."/common");
if ($_FILES['clogo_img2']['name']) upload_file($_FILES['clogo_img2']['tmp_name'], "clogo_img2", G5_DATA_PATH."/common");
if ($_FILES['mobile_clogo_img']['name']) upload_file($_FILES['mobile_clogo_img']['tmp_name'], "mobile_clogo_img", G5_DATA_PATH."/common");
if ($_FILES['mobile_clogo_img2']['name']) upload_file($_FILES['mobile_clogo_img2']['tmp_name'], "mobile_clogo_img2", G5_DATA_PATH."/common");

goto_url("./config_logo.php");
?>
