<?php
$sub_menu = '400912'; /* (새로만듬) 상품목록페이지 상품 진열 */
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

check_admin_token();

// 로그인을 바로 이 주소로 하는 경우 쇼핑몰설정값이 사라지는 현상을 방지
//if (!$_POST['de_shop_skin']) goto_url("./config_dis_list.php");

#######################################################################################

//상품목록페이지 상품정렬 설정 업데이트 (쇼핑몰설정 configform.php에서 분할되어나옴 - 아이스크림)

#######################################################################################

$sql = " update {$g5['g5_shop_default_table']}
            set de_shop_skin                  = '{$_POST['de_shop_skin']}',
                de_shop_mobile_skin           = '{$_POST['de_shop_mobile_skin']}',
                de_rel_list_use               = '{$_POST['de_rel_list_use']}',
                de_rel_list_skin              = '{$_POST['de_rel_list_skin']}',
                de_rel_list_mod               = '{$_POST['de_rel_list_mod']}',
                de_rel_img_width              = '{$_POST['de_rel_img_width']}',
                de_rel_img_height             = '{$_POST['de_rel_img_height']}',
                de_mobile_rel_list_use        = '{$_POST['de_mobile_rel_list_use']}',
                de_mobile_rel_list_skin       = '{$_POST['de_mobile_rel_list_skin']}',
                de_mobile_rel_list_mod        = '{$_POST['de_mobile_rel_list_mod']}',
                de_mobile_rel_img_width       = '{$_POST['de_mobile_rel_img_width']}',
                de_mobile_rel_img_height      = '{$_POST['de_mobile_rel_img_height']}',
                de_search_list_skin           = '{$_POST['de_search_list_skin']}',
                de_search_list_mod            = '{$_POST['de_search_list_mod']}',
                de_search_list_row            = '{$_POST['de_search_list_row']}',
                de_search_img_width           = '{$_POST['de_search_img_width']}',
                de_search_img_height          = '{$_POST['de_search_img_height']}',
                de_mobile_search_list_skin    = '{$_POST['de_mobile_search_list_skin']}',
                de_mobile_search_list_mod     = '{$_POST['de_mobile_search_list_mod']}',
                de_mobile_search_list_row     = '{$_POST['de_mobile_search_list_row']}',
                de_mobile_search_img_width    = '{$_POST['de_mobile_search_img_width']}',
                de_mobile_search_img_height   = '{$_POST['de_mobile_search_img_height']}',
                de_listtype_list_skin         = '{$_POST['de_listtype_list_skin']}',
                de_listtype_list_mod          = '{$_POST['de_listtype_list_mod']}',
                de_listtype_list_row          = '{$_POST['de_listtype_list_row']}',
                de_listtype_img_width         = '{$_POST['de_listtype_img_width']}',
                de_listtype_img_height        = '{$_POST['de_listtype_img_height']}',
                de_mobile_listtype_list_skin  = '{$_POST['de_mobile_listtype_list_skin']}',
                de_mobile_listtype_list_mod   = '{$_POST['de_mobile_listtype_list_mod']}',
                de_mobile_listtype_list_row   = '{$_POST['de_mobile_listtype_list_row']}',
                de_mobile_listtype_img_width  = '{$_POST['de_mobile_listtype_img_width']}',
                de_mobile_listtype_img_height = '{$_POST['de_mobile_listtype_img_height']}'
                ";
sql_query($sql);

goto_url("./config_dis_list.php");
?>
