<?php
$sub_menu = '400913'; /* (새로만듬) 상품이미지 기본사이즈 */
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

check_admin_token();

// 로그인을 바로 이 주소로 하는 경우 쇼핑몰설정값이 사라지는 현상을 방지
//if (!$_POST['de_simg_width']) goto_url("./config_listimgsize.php");

#######################################################################################

//상품이미지 기본사이즈 설정 업데이트 (쇼핑몰설정 configform.php에서 분할되어나옴 - 아이스크림)

#######################################################################################

$sql = " update {$g5['g5_shop_default_table']}
            set de_simg_width                 = '{$_POST['de_simg_width']}',
                de_simg_height                = '{$_POST['de_simg_height']}',
                de_mimg_width                 = '{$_POST['de_mimg_width']}',
                de_mimg_height                = '{$_POST['de_mimg_height']}'
                ";
sql_query($sql);

goto_url("./config_listimgsize.php");
?>
