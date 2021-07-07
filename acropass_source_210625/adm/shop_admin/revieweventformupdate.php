<?php
$sub_menu = '422400'; /* 수정전 원본 메뉴코드 400810 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

check_admin_token();

@mkdir(G5_DATA_PATH."/coupon", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/coupon", G5_DIR_PERMISSION);

$_POST = array_map('trim', $_POST);


if(!$_POST['rep_id'])
    alert('리뷰혜택을 적용할 상품을 선택해 주십시오.');

if(!$_POST['re_subject'])
    alert('리뷰혜택이름을 입력해 주십시오.');

if(!$_POST['re_start'] || !$_POST['re_end'])
    alert('리뷰혜택시작일과 종료일을 입력해 주십시오.');

 if($_POST['re_start'] > $_POST['re_end'])
        alert('리뷰혜택시작일은 종료일 이전으로 입력해 주십시오.');

if($_POST['re_type'] == "1") {
    if(!$_POST['br_point'] || !$_POST['pr_point'])
        alert('리뷰혜택 포인트를 입력주십시오.');
} else {
    if($_POST['pr_cp_start'] > $_POST['pr_cp_end'] || $_POST['br_cp_start'] > $_POST['br_cp_end'])
        alert('쿠폰 사용 시작일은 종료일 이전으로 입력해 주십시오.');

    if($_POST['br_cp_end'] < G5_TIME_YMD || $_POST['pr_cp_end'] < G5_TIME_YMD)
        alert('종료일은 오늘('.G5_TIME_YMD.')이후로 입력해 주십시오.');

    if($_POST['br_cp_method'] == 0 && !$_POST['br_cp_target'])
    alert('일반리뷰 혜택의 적용상품을 입력해 주십시오.');

    if($_POST['pr_cp_method'] == 0 && !$_POST['pr_cp_target'])
        alert('포토리뷰 혜택의 적용상품을 입력해 주십시오.');

    if($_POST['br_cp_method'] == 1 && !$_POST['br_cp_target'])
        alert('일반리뷰 혜택의 적용분류를 입력해 주십시오.');

    if($_POST['pr_cp_method'] == 1 && !$_POST['pr_cp_target'])
        alert('포토리뷰 혜택의 적용분류를 입력해 주십시오.');

     if(!$_POST['br_cp_subject'] || !$_POST['pr_cp_subject'])
        alert('쿠폰의 이름을 입력해 주십시오.');

    if(!$_POST['br_cp_price']) {
        if($_POST['br_cp_type'])
            alert('일반리뷰 혜택의 할인비율을 입력해 주십시오.');
        else
            alert('일반리뷰 혜택의 할인금액을 입력해 주십시오.');
    }

    if(!$_POST['pr_cp_price']) {
        if($_POST['pr_cp_type'])
            alert('포토리뷰 혜택의 할인비율을 입력해 주십시오.');
        else
            alert('포토리뷰 혜택의 할인금액을 입력해 주십시오.');
    }

    if($_POST['br_cp_type'] && ($_POST['br_cp_price'] < 1 || $_POST['br_cp_price'] > 100))
        alert('일반리뷰 혜택의 할인비율을은 1과 100사이 값으로 입력해 주십시오.');

    if($_POST['pr_cp_type'] && ($_POST['pr_cp_price'] < 1 || $_POST['pr_cp_price'] > 100))
        alert('포토리뷰 혜택의 할인비율을은 1과 100사이 값으로 입력해 주십시오.');

    if($_POST['br_cp_method'] == 0) {
        $sql = " select count(*) as cnt from {$g5['g5_shop_item_table']} where it_id = '$br_cp_target' and it_nocoupon = '0' ";
        $row = sql_fetch($sql);
        if(!$row['cnt'])
            alert('입력하신 상품코드는 존재하지 않는 코드이거나 쿠폰적용안함으로 설정된 상품입니다.');
    } else if($_POST['br_cp_method'] == 1) {
        $sql = " select count(*) as cnt from {$g5['g5_shop_category_table']} where ca_id = '$br_cp_target' and ca_nocoupon = '0' ";
        $row = sql_fetch($sql);
        if(!$row['cnt'])
            alert('입력하신 분류코드는 존재하지 않는 분류코드이거나 쿠폰적용안함으로 설정된 분류입니다.');
    }

    if($_POST['pr_cp_method'] == 0) {
        $sql = " select count(*) as cnt from {$g5['g5_shop_item_table']} where it_id = '$pr_cp_target' and it_nocoupon = '0' ";
        $row = sql_fetch($sql);
        if(!$row['cnt'])
            alert('입력하신 상품코드는 존재하지 않는 코드이거나 쿠폰적용안함으로 설정된 상품입니다.');
    } else if($_POST['pr_cp_method'] == 1) {
        $sql = " select count(*) as cnt from {$g5['g5_shop_category_table']} where ca_id = '$pr_cp_target' and ca_nocoupon = '0' ";
        $row = sql_fetch($sql);
        if(!$row['cnt'])
            alert('입력하신 분류코드는 존재하지 않는 분류코드이거나 쿠폰적용안함으로 설정된 분류입니다.');
    }
    
}

if( isset($_FILES['cp_img']) && !empty($_FILES['cp_img']['name']) ){
    if( !preg_match('/\.(gif|jpe?g|bmp|png)$/i', $_FILES['cp_img']['name']) ){
        alert("이미지 파일만 업로드 할수 있습니다.");
    }

    $timg = @getimagesize($_FILES['cp_img']['tmp_name']);
    if ($timg['2'] < 1 || $timg['2'] > 16){
        alert("이미지 파일만 업로드 할수 있습니다.");
    }
}





$sql_common = " it_id       = '{$_POST['rep_id']}',
                re_subject  = '{$_POST['re_subject']}',
                re_type     = '{$_POST['re_type']}',
                re_start    = '{$_POST['re_start']}',
                re_end      = '{$_POST['re_end']}',
                br_point    = '{$_POST['br_point']}',
                pr_point    = '{$_POST['pr_point']}',
                br_cp_subject   = '{$_POST['br_cp_subject']}',
                br_cp_method    = '{$_POST['br_cp_method']}',
                br_cp_target    = '{$_POST['br_cp_target']}',
                br_cp_start     = '{$_POST['br_cp_start']}',
                br_cp_end       = '{$_POST['br_cp_end']}',
                br_cp_price     = '{$_POST['br_cp_price']}',
                br_cp_type      = '{$_POST['br_cp_type']}',
                br_cp_trunc     = '{$_POST['br_cp_trunc']}',
                br_cp_minimum   = '{$_POST['br_cp_minimum']}',
                br_cp_maximum   = '{$_POST['br_cp_maximum']}',
                pr_cp_subject   = '{$_POST['pr_cp_subject']}',
                pr_cp_method    = '{$_POST['pr_cp_method']}',
                pr_cp_target    = '{$_POST['pr_cp_target']}',
                pr_cp_start     = '{$_POST['pr_cp_start']}',
                pr_cp_end       = '{$_POST['pr_cp_end']}',
                pr_cp_price     = '{$_POST['pr_cp_price']}',
                pr_cp_type      = '{$_POST['pr_cp_type']}',
                pr_cp_trunc     = '{$_POST['pr_cp_trunc']}',
                pr_cp_minimum   = '{$_POST['pr_cp_minimum']}',
                pr_cp_maximum   = '{$_POST['pr_cp_maximum']}' ";

if($w == '') {
    $sql = " INSERT INTO {$g5['g5_shop_review_event_table']}
                set $sql_common,
                    re_datetime = '".G5_TIME_YMDHIS."' ";
    sql_query($sql, true);

    $re_id = sql_insert_id();
} else if($w == 'u') {
    $sql = " select * from {$g5['g5_shop_review_event_table']} where re_id = '$re_id' ";
    $re = sql_fetch($sql);

    if(!$re['re_id'])
        alert('쿠폰정보가 존해하지 않습니다.', './revieweventlist.php');

    $sql = " update {$g5['g5_shop_review_event_table']}
                set $sql_common
                where re_id = '$re_id' ";
    $res = sql_query($sql);

}




goto_url('./revieweventlist.php?'.$qstr);
?>