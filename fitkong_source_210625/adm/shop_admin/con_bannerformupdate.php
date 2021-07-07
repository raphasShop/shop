<?php
$sub_menu = '155801'; /* 수정전 원본 메뉴코드 500500 */
include_once('./_common.php');

check_demo();

if ($W == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

check_admin_token();

@mkdir(G5_DATA_PATH."/con_banner", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/con_banner", G5_DIR_PERMISSION);

$bn_bimg      = $_FILES['bn_bimg']['tmp_name'];
$bn_bimg_name = $_FILES['bn_bimg']['name'];

$bn_id = (int) $bn_id;

if ($bn_bimg_del)  @unlink(G5_DATA_PATH."/con_banner/$bn_id");

//파일이 이미지인지 체크합니다.
if( $bn_bimg || $bn_bimg_name ){

    if( !preg_match('/\.(gif|jpe?g|bmp|png)$/i', $bn_bimg_name) ){
        alert("이미지 파일만 업로드 할수 있습니다.");
    }

    $timg = @getimagesize($bn_bimg);
    if ($timg['2'] < 1 || $timg['2'] > 16){
        alert("이미지 파일만 업로드 할수 있습니다.");
    }
}

$bn_url = clean_xss_tags($bn_url);
$bn_alt = function_exists('clean_xss_attributes') ? clean_xss_attributes(strip_tags($bn_alt)) : strip_tags($bn_alt);

if ($w=="")
{
    if (!$bn_bimg_name) alert('배너 이미지를 업로드 하세요.');

    sql_query(" alter table {$g5['g5_shop_con_banner_table']} auto_increment=1 ");

    $sql = " insert into {$g5['g5_shop_con_banner_table']}
                set bn_alt        = '$bn_alt',
                    bn_main_title = '$bn_main_title',
                    bn_sub_title  = '$bn_sub_title',
                    bn_url        = '$bn_url',
                    bn_img_url    = '$bn_img_url',
                    bn_device     = '$bn_device',
                    bn_position   = '$bn_position',
                    bn_border     = '$bn_border',
					bn_bgcolor    = '$bn_bgcolor',
                    bn_new_win    = '$bn_new_win',
                    bn_begin_time = '$bn_begin_time',
                    bn_end_time   = '$bn_end_time',
                    bn_time       = '$now',
                    bn_hit        = '0',
                    bn_use        = '$bn_use',
                    bn_order      = '$bn_order' ";
    sql_query($sql);

    $bn_id = sql_insert_id();
}
else if ($w=="u")
{
    $sql = " update {$g5['g5_shop_con_banner_table']}
                set bn_alt        = '$bn_alt',
                    bn_main_title = '$bn_main_title',
                    bn_sub_title  = '$bn_sub_title',
                    bn_url        = '$bn_url',
                    bn_img_url    = '$bn_img_url',
                    bn_device     = '$bn_device',
                    bn_position   = '$bn_position',
                    bn_border     = '$bn_border',
					bn_bgcolor    = '$bn_bgcolor',
                    bn_new_win    = '$bn_new_win',
                    bn_begin_time = '$bn_begin_time',
                    bn_end_time   = '$bn_end_time',
                    bn_use        = '$bn_use',
                    bn_order      = '$bn_order'
              where bn_id = '$bn_id' ";
    sql_query($sql);
}
else if ($w=="d")
{
    @unlink(G5_DATA_PATH."/con_banner/$bn_id");

    $sql = " delete from {$g5['g5_shop_con_banner_table']} where bn_id = $bn_id ";
    $result = sql_query($sql);
}


if ($w == "" || $w == "u")
{
    if ($_FILES['bn_bimg']['name']) upload_file($_FILES['bn_bimg']['tmp_name'], $bn_id, G5_DATA_PATH."/con_banner");

    goto_url("./con_bannerform.php?w=u&amp;bn_id=$bn_id");
} else {
    goto_url("./con_bannerlist.php");
}
?>