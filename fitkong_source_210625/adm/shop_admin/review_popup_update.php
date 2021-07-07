<?php
$sub_menu = '155601'; /* 수정전 원본 메뉴코드 500500 */
include_once('./_common.php');

check_demo();

if ($W == 'd')
    auth_check($auth[$sub_menu], "d");
else
    auth_check($auth[$sub_menu], "w");

check_admin_token();


/* 이미지 파일 업로드 
@mkdir(G5_DATA_PATH."/reviewpopup", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/reviewpopup", G5_DIR_PERMISSION);

$rvp_bimg      = $_FILES['rvp_bimg']['tmp_name'];
$rvp_bimg_name = $_FILES['rvp_bimg']['name'];

$rvp_id = (int) $rvp_id;

if ($bn_bimg_del)  @unlink(G5_DATA_PATH."/reviewpopup/$rvp_id");

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

*/

$rvp_url = clean_xss_tags($rvp_url);
$rvp_alt = function_exists('clean_xss_attributes') ? clean_xss_attributes(strip_tags($rvp_alt)) : strip_tags($rvp_alt);
$rvp_order = 0;
$rvp_begin_time = $now;
$rvp_end_time = $now;

if ($w=="")
{
    //if (!$bn_bimg_name) alert('배너 이미지를 업로드 하세요.');
    $rvp_use = 1;
    sql_query(" alter table {$g5['g5_shop_review_popup_table']} auto_increment=1 ");

    $sql = " insert into {$g5['g5_shop_review_popup_table']}
                set rvp_alt        = '$rvp_alt',
                    it_id          = '$rvp_pid',
                    rvp_title      = '$rvp_title',
                    rvp_contents   = '$rvp_contents',
                    rvp_url        = '$rvp_url',
                    rvp_img_url    = '$rvp_img_url',
                    rvp_channel    = '$rvp_channel',
                    rvp_reviewer   = '$rvp_reviewer',
                    rvp_begin_time = '$rvp_begin_time',
                    rvp_end_time   = '$rvp_end_time',
                    rvp_time       = '$now',
                    rvp_hit        = '0',
                    rvp_use        = '$rvp_use',
                    rvp_order      = '$rvp_order' ";
    sql_query($sql);

    $rvp_id = sql_insert_id();
}
else if ($w=="u")
{
    $sql = " update {$g5['g5_shop_review_popup_table']}
                set rvp_alt        = '$rvp_alt',
                    it_id          = '$rvp_pid',
                    rvp_title      = '$rvp_title',
                    rvp_contents   = '$rvp_contents',
                    rvp_url        = '$rvp_url',
                    rvp_img_url    = '$rvp_img_url',
                    rvp_channel    = '$rvp_channel',
                    rvp_reviewer   = '$rvp_reviewer',
                    rvp_begin_time = '$rvp_begin_time',
                    rvp_end_time   = '$rvp_end_time',
                    rvp_time       = '$now',
                    rvp_hit        = '0',
                    rvp_use        = '$rvp_use',
                    rvp_order      = '$rvp_order'
              where rvp_id = '$rvp_id' ";
    sql_query($sql);
}
else if ($w=="d")
{
    @unlink(G5_DATA_PATH."/banner/$bn_id");

    $sql = " delete from {$g5['g5_shop_review_popup_table']}  where rvp_id = $rvp_id ";
    $result = sql_query($sql);
}


if ($w == "" || $w == "u")
{
    goto_url("./review_popup_list.php");
} else {
    goto_url("./review_popup_list.php");
}
?>