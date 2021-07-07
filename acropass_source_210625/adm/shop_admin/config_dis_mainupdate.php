<?php
$sub_menu = '400911'; /* (새로만듬) 메인상품 진열 */
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

check_admin_token();

// 로그인을 바로 이 주소로 하는 경우 쇼핑몰설정값이 사라지는 현상을 방지
//if (!$_POST['de_type1_title']) goto_url("./config_dis_main.php");

#######################################################################################

//메인 상품정렬 설정 업데이트 (쇼핑몰설정 configform.php에서 분할되어나옴 - 아이스크림)

#######################################################################################

$sql = " update {$g5['g5_shop_default_table']}
            set de_type1_title                = '{$_POST['de_type1_title']}',
				de_type2_title                = '{$_POST['de_type2_title']}',
				de_type3_title                = '{$_POST['de_type3_title']}',
				de_type4_title                = '{$_POST['de_type4_title']}',
				de_type5_title                = '{$_POST['de_type5_title']}',
                de_type1_list_use             = '{$_POST['de_type1_list_use']}',
                de_type1_list_skin            = '{$_POST['de_type1_list_skin']}',
                de_type1_list_mod             = '{$_POST['de_type1_list_mod']}',
                de_type1_list_row             = '{$_POST['de_type1_list_row']}',
                de_type1_img_width            = '{$_POST['de_type1_img_width']}',
                de_type1_img_height           = '{$_POST['de_type1_img_height']}',
                de_type2_list_use             = '{$_POST['de_type2_list_use']}',
                de_type2_list_skin            = '{$_POST['de_type2_list_skin']}',
                de_type2_list_mod             = '{$_POST['de_type2_list_mod']}',
                de_type2_list_row             = '{$_POST['de_type2_list_row']}',
                de_type2_img_width            = '{$_POST['de_type2_img_width']}',
                de_type2_img_height           = '{$_POST['de_type2_img_height']}',
                de_type3_list_use             = '{$_POST['de_type3_list_use']}',
                de_type3_list_skin            = '{$_POST['de_type3_list_skin']}',
                de_type3_list_mod             = '{$_POST['de_type3_list_mod']}',
                de_type3_list_row             = '{$_POST['de_type3_list_row']}',
                de_type3_img_width            = '{$_POST['de_type3_img_width']}',
                de_type3_img_height           = '{$_POST['de_type3_img_height']}',
                de_type4_list_use             = '{$_POST['de_type4_list_use']}',
                de_type4_list_skin            = '{$_POST['de_type4_list_skin']}',
                de_type4_list_mod             = '{$_POST['de_type4_list_mod']}',
                de_type4_list_row             = '{$_POST['de_type4_list_row']}',
                de_type4_img_width            = '{$_POST['de_type4_img_width']}',
                de_type4_img_height           = '{$_POST['de_type4_img_height']}',
                de_type5_list_use             = '{$_POST['de_type5_list_use']}',
                de_type5_list_skin            = '{$_POST['de_type5_list_skin']}',
                de_type5_list_mod             = '{$_POST['de_type5_list_mod']}',
                de_type5_list_row             = '{$_POST['de_type5_list_row']}',
                de_type5_img_width            = '{$_POST['de_type5_img_width']}',
                de_type5_img_height           = '{$_POST['de_type5_img_height']}',
                de_mobile_type1_title         = '{$_POST['de_mobile_type1_title']}',
				de_mobile_type2_title         = '{$_POST['de_mobile_type2_title']}',
				de_mobile_type3_title         = '{$_POST['de_mobile_type3_title']}',
				de_mobile_type4_title         = '{$_POST['de_mobile_type4_title']}',
				de_mobile_type5_title         = '{$_POST['de_mobile_type5_title']}',
				de_mobile_type1_list_use      = '{$_POST['de_mobile_type1_list_use']}',
                de_mobile_type1_list_skin     = '{$_POST['de_mobile_type1_list_skin']}',
                de_mobile_type1_list_mod      = '{$_POST['de_mobile_type1_list_mod']}',
                de_mobile_type1_list_row      = '{$_POST['de_mobile_type1_list_row']}',
                de_mobile_type1_img_width     = '{$_POST['de_mobile_type1_img_width']}',
                de_mobile_type1_img_height    = '{$_POST['de_mobile_type1_img_height']}',
                de_mobile_type2_list_use      = '{$_POST['de_mobile_type2_list_use']}',
                de_mobile_type2_list_skin     = '{$_POST['de_mobile_type2_list_skin']}',
                de_mobile_type2_list_mod      = '{$_POST['de_mobile_type2_list_mod']}',
                de_mobile_type2_list_row      = '{$_POST['de_mobile_type2_list_row']}',
                de_mobile_type2_img_width     = '{$_POST['de_mobile_type2_img_width']}',
                de_mobile_type2_img_height    = '{$_POST['de_mobile_type2_img_height']}',
                de_mobile_type3_list_use      = '{$_POST['de_mobile_type3_list_use']}',
                de_mobile_type3_list_skin     = '{$_POST['de_mobile_type3_list_skin']}',
                de_mobile_type3_list_mod      = '{$_POST['de_mobile_type3_list_mod']}',
                de_mobile_type3_list_row      = '{$_POST['de_mobile_type3_list_row']}',
                de_mobile_type3_img_width     = '{$_POST['de_mobile_type3_img_width']}',
                de_mobile_type3_img_height    = '{$_POST['de_mobile_type3_img_height']}',
                de_mobile_type4_list_use      = '{$_POST['de_mobile_type4_list_use']}',
                de_mobile_type4_list_skin     = '{$_POST['de_mobile_type4_list_skin']}',
                de_mobile_type4_list_mod      = '{$_POST['de_mobile_type4_list_mod']}',
                de_mobile_type4_list_row      = '{$_POST['de_mobile_type4_list_row']}',
                de_mobile_type4_img_width     = '{$_POST['de_mobile_type4_img_width']}',
                de_mobile_type4_img_height    = '{$_POST['de_mobile_type4_img_height']}',
                de_mobile_type5_list_use      = '{$_POST['de_mobile_type5_list_use']}',
                de_mobile_type5_list_skin     = '{$_POST['de_mobile_type5_list_skin']}',
                de_mobile_type5_list_mod      = '{$_POST['de_mobile_type5_list_mod']}',
                de_mobile_type5_list_row      = '{$_POST['de_mobile_type5_list_row']}',
                de_mobile_type5_img_width     = '{$_POST['de_mobile_type5_img_width']}',
                de_mobile_type5_img_height    = '{$_POST['de_mobile_type5_img_height']}'
                ";
sql_query($sql);

goto_url("./config_dis_main.php");
?>
