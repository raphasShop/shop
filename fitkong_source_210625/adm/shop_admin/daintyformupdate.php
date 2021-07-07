<?php
$sub_menu = '155703'; 
include_once('./_common.php');

check_demo();

if ($W == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

check_admin_token();

@mkdir(G5_DATA_PATH."/dainty", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/dainty", G5_DIR_PERMISSION);

$co_bimg      = $_FILES['co_bimg']['tmp_name'];
$co_bimg_name = $_FILES['co_bimg']['name'];

$co_id = (int) $co_id;

if ($co_bimg_del)  @unlink(G5_DATA_PATH."/dainty/$co_id");

//파일이 이미지인지 체크합니다.
if( $co_bimg || $co_bimg_name ){

    if( !preg_match('/\.(gif|jpe?g|bmp|png)$/i', $co_bimg_name) ){
        alert("이미지 파일만 업로드 할수 있습니다.");
    }

    $timg = @getimagesize($co_bimg);
    if ($timg['2'] < 1 || $timg['2'] > 16){
        alert("이미지 파일만 업로드 할수 있습니다.");
    }
}

$co_url = clean_xss_tags($co_url);
$co_img_url = clean_xss_tags($co_img_url);
$co_alt = function_exists('clean_xss_attributes') ? clean_xss_attributes(strip_tags($co_alt)) : strip_tags($co_alt);

if ($w=="")
{
    if (!$co_bimg_name && !$co_img_url) alert('컨텐츠 이미지를 등록하세요.');

    sql_query(" alter table {$g5['g5_shop_dainty_table']} auto_increment=1 ");

    $sql = " insert into {$g5['g5_shop_dainty_table']}
                set co_alt        = '$co_alt',
                    co_url        = '$co_url',
                    co_img_url    = '$co_img_url',
                    co_title      = '$co_title',
                    co_device     = '$co_device',
                    co_time       = '$now',
                    co_hit        = '0',
                    co_use        = '$co_use',
                    co_order      = '$co_order' ";
    sql_query($sql);

    $co_id = sql_insert_id();
    echo $sql;

}
else if ($w=="u")
{
    $sql = " update {$g5['g5_shop_dainty_table']}
                set co_alt        = '$co_alt',
                    co_url        = '$co_url',
                    co_img_url    = '$co_img_url',
                    co_title      = '$co_title',
                    co_device     = '$co_device',
                    co_use        = '$co_use',
                    co_order      = '$co_order'
              where co_id = '$co_id' ";
    sql_query($sql);
}
else if ($w=="d")
{
    @unlink(G5_DATA_PATH."/dainty/$co_id");

    $sql = " delete from {$g5['g5_shop_dainty_table']} where co_id = $co_id ";
    $result = sql_query($sql);
}


if ($w == "" || $w == "u")
{
    if ($_FILES['co_bimg']['name']) upload_file($_FILES['co_bimg']['tmp_name'], $co_id, G5_DATA_PATH."/dainty");
    
    goto_url("./daintyform.php?w=u&amp;co_id=$co_id");
} else {
    goto_url("./daintylist.php");
}
?>