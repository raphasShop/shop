<?php
$sub_menu = '400399'; /* 새로만든 메뉴코드 */
include_once('./_common.php');

if ($w == "u" || $w == "d")
    check_demo();

if ($w == '' || $w == 'u')
    auth_check($auth[$sub_menu], "r");
else if ($w == 'd')
    auth_check($auth[$sub_menu], "d");
	
//check_admin_token();

@mkdir(G5_DATA_PATH."/item", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/item", G5_DIR_PERMISSION);

// input vars 체크
check_input_vars();

// 파일정보
if($w == "u") {
    $sql = " select it_img1, it_img2, it_img3, it_img4, it_img5, it_img6, it_img7, it_img8, it_img9, it_img10
                from {$g5['g5_shop_item_table']}
                where it_id = '$it_id' ";
    $file = sql_fetch($sql);

    $it_img1    = $file['it_img1'];
    $it_img2    = $file['it_img2'];
    $it_img3    = $file['it_img3'];
    $it_img4    = $file['it_img4'];
    $it_img5    = $file['it_img5'];
    $it_img6    = $file['it_img6'];
    $it_img7    = $file['it_img7'];
    $it_img8    = $file['it_img8'];
    $it_img9    = $file['it_img9'];
    $it_img10   = $file['it_img10'];
}

$it_img_dir = G5_DATA_PATH.'/item';

// 파일삭제
if ($it_img1_del) {
    $file_img1 = $it_img_dir.'/'.$it_img1;
    @unlink($file_img1);
    delete_item_thumbnail(dirname($file_img1), basename($file_img1));
    $it_img1 = '';
}
if ($it_img2_del) {
    $file_img2 = $it_img_dir.'/'.$it_img2;
    @unlink($file_img2);
    delete_item_thumbnail(dirname($file_img2), basename($file_img2));
    $it_img2 = '';
}
if ($it_img3_del) {
    $file_img3 = $it_img_dir.'/'.$it_img3;
    @unlink($file_img3);
    delete_item_thumbnail(dirname($file_img3), basename($file_img3));
    $it_img3 = '';
}
if ($it_img4_del) {
    $file_img4 = $it_img_dir.'/'.$it_img4;
    @unlink($file_img4);
    delete_item_thumbnail(dirname($file_img4), basename($file_img4));
    $it_img4 = '';
}
if ($it_img5_del) {
    $file_img5 = $it_img_dir.'/'.$it_img5;
    @unlink($file_img5);
    delete_item_thumbnail(dirname($file_img5), basename($file_img5));
    $it_img5 = '';
}
if ($it_img6_del) {
    $file_img6 = $it_img_dir.'/'.$it_img6;
    @unlink($file_img6);
    delete_item_thumbnail(dirname($file_img6), basename($file_img6));
    $it_img6 = '';
}
if ($it_img7_del) {
    $file_img7 = $it_img_dir.'/'.$it_img7;
    @unlink($file_img7);
    delete_item_thumbnail(dirname($file_img7), basename($file_img7));
    $it_img7 = '';
}
if ($it_img8_del) {
    $file_img8 = $it_img_dir.'/'.$it_img8;
    @unlink($file_img8);
    delete_item_thumbnail(dirname($file_img8), basename($file_img8));
    $it_img8 = '';
}
if ($it_img9_del) {
    $file_img9 = $it_img_dir.'/'.$it_img9;
    @unlink($file_img9);
    delete_item_thumbnail(dirname($file_img9), basename($file_img9));
    $it_img9 = '';
}
if ($it_img10_del) {
    $file_img10 = $it_img_dir.'/'.$it_img10;
    @unlink($file_img10);
    delete_item_thumbnail(dirname($file_img10), basename($file_img10));
    $it_img10 = '';
}

// 이미지업로드
if ($_FILES['it_img1']['name']) {
    if($w == 'u' && $it_img1) {
        $file_img1 = $it_img_dir.'/'.$it_img1;
        @unlink($file_img1);
        delete_item_thumbnail(dirname($file_img1), basename($file_img1));
    }
    $it_img1 = it_img_upload($_FILES['it_img1']['tmp_name'], $_FILES['it_img1']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img2']['name']) {
    if($w == 'u' && $it_img2) {
        $file_img2 = $it_img_dir.'/'.$it_img2;
        @unlink($file_img2);
        delete_item_thumbnail(dirname($file_img2), basename($file_img2));
    }
    $it_img2 = it_img_upload($_FILES['it_img2']['tmp_name'], $_FILES['it_img2']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img3']['name']) {
    if($w == 'u' && $it_img3) {
        $file_img3 = $it_img_dir.'/'.$it_img3;
        @unlink($file_img3);
        delete_item_thumbnail(dirname($file_img3), basename($file_img3));
    }
    $it_img3 = it_img_upload($_FILES['it_img3']['tmp_name'], $_FILES['it_img3']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img4']['name']) {
    if($w == 'u' && $it_img4) {
        $file_img4 = $it_img_dir.'/'.$it_img4;
        @unlink($file_img4);
        delete_item_thumbnail(dirname($file_img4), basename($file_img4));
    }
    $it_img4 = it_img_upload($_FILES['it_img4']['tmp_name'], $_FILES['it_img4']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img5']['name']) {
    if($w == 'u' && $it_img5) {
        $file_img5 = $it_img_dir.'/'.$it_img5;
        @unlink($file_img5);
        delete_item_thumbnail(dirname($file_img5), basename($file_img5));
    }
    $it_img5 = it_img_upload($_FILES['it_img5']['tmp_name'], $_FILES['it_img5']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img6']['name']) {
    if($w == 'u' && $it_img6) {
        $file_img6 = $it_img_dir.'/'.$it_img6;
        @unlink($file_img6);
        delete_item_thumbnail(dirname($file_img6), basename($file_img6));
    }
    $it_img6 = it_img_upload($_FILES['it_img6']['tmp_name'], $_FILES['it_img6']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img7']['name']) {
    if($w == 'u' && $it_img7) {
        $file_img7 = $it_img_dir.'/'.$it_img7;
        @unlink($file_img7);
        delete_item_thumbnail(dirname($file_img7), basename($file_img7));
    }
    $it_img7 = it_img_upload($_FILES['it_img7']['tmp_name'], $_FILES['it_img7']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img8']['name']) {
    if($w == 'u' && $it_img8) {
        $file_img8 = $it_img_dir.'/'.$it_img8;
        @unlink($file_img8);
        delete_item_thumbnail(dirname($file_img8), basename($file_img8));
    }
    $it_img8 = it_img_upload($_FILES['it_img8']['tmp_name'], $_FILES['it_img8']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img9']['name']) {
    if($w == 'u' && $it_img9) {
        $file_img9 = $it_img_dir.'/'.$it_img9;
        @unlink($file_img9);
        delete_item_thumbnail(dirname($file_img9), basename($file_img9));
    }
    $it_img9 = it_img_upload($_FILES['it_img9']['tmp_name'], $_FILES['it_img9']['name'], $it_img_dir.'/'.$it_id);
}
if ($_FILES['it_img10']['name']) {
    if($w == 'u' && $it_img10) {
        $file_img10 = $it_img_dir.'/'.$it_img10;
        @unlink($file_img10);
        delete_item_thumbnail(dirname($file_img10), basename($file_img10));
    }
    $it_img10 = it_img_upload($_FILES['it_img10']['tmp_name'], $_FILES['it_img10']['name'], $it_img_dir.'/'.$it_id);
}

// 등록
$sql_common = " it_img1             = '$it_img1',
                it_img2             = '$it_img2',
                it_img3             = '$it_img3',
                it_img4             = '$it_img4',
                it_img5             = '$it_img5',
                it_img6             = '$it_img6',
                it_img7             = '$it_img7',
                it_img8             = '$it_img8',
                it_img9             = '$it_img9',
                it_img10            = '$it_img10'
                ";
if ($w == "u") {
    $sql_common .= " , it_update_time = '".G5_TIME_YMDHIS."' ";
    $sql = " update {$g5['g5_shop_item_table']}
                set $sql_common
              where it_id = '$it_id' ";
    sql_query($sql);
}
/*
else if ($w == "d")
{
    if ($is_admin != 'super')
    {
        $sql = " select it_id from {$g5['g5_shop_item_table']} a, {$g5['g5_shop_category_table']} b
                  where a.it_id = '$it_id'
                    and a.ca_id = b.ca_id
                    and b.ca_mb_id = '{$member['mb_id']}' ";
        $row = sql_fetch($sql);
        if (!$row['it_id'])
            alert("\'{$member['mb_id']}\' 님께서 삭제 할 권한이 없는 상품입니다.");
    }

    itemdelete($it_id);
}
*/

echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\">";

// 완료안내창 및 창닫기
alert("상품이미지 수정이 완료되었습니다");
?>