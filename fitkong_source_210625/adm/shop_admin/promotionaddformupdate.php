<?php
$sub_menu = '422500'; /* 수정전 원본 메뉴코드 400800 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

check_admin_token();

$_POST = array_map('trim', $_POST);

if(!$_POST['pa_name'])
    alert('프로모션 이름을 입력해 주십시오.');

if(!$_POST['pa_url'])
    alert('연결한 페이지 URL을 입력해 주십시오.');

if(!$_POST['pa_purl'])
    alert('프로모션 개별 URL이 등록되지 않았습니다.');


if($_POST['pa_start'] && $_POST['pa_end']) {

    if($_POST['pa_start'] > $_POST['pa_end'])
    alert('사용 시작일은 종료일 이전으로 입력해 주십시오.');

    if($_POST['pa_end'] < G5_TIME_YMD)
    alert('종료일은 오늘('.G5_TIME_YMD.')이후로 입력해 주십시오.');
}



$pa_code = $_POST['pa_code'];
    


if($w == '') {

    if($_POST['pa_purl']) {
        $sql = " select count(*) as cnt from {$g5['promotion_address_table']} where pa_code = '$pa_code' ";
        $row = sql_fetch($sql);
        if($row['cnt'])
            alert('입력하신 프로모션개별URL코드는 이미 등록하신 코드입니다.');
    }
    

    $sql = " INSERT INTO {$g5['promotion_address_table']}
                ( pa_name, pa_code, pa_url, pa_title, pa_desc, pa_start, pa_end, pa_channel, pa_datetime )
            VALUES
                ( '$pa_name', '$pa_code', '$pa_url', '$pa_title', '$pa_desc', '$pa_start', '$pa_end', '$pa_channel', '".G5_TIME_YMDHIS."' ) ";

    sql_query($sql);
    echo $sql;
} else if($w == 'u') {
    $sql = " select * from {$g5['promotion_address_table']} where pa_id = '$pa_id' ";
    $pa = sql_fetch($sql);

    if(!$pa['pa_id'])
        alert('프로모션개별URL 정보가 존재하지 않습니다.', './promotionaddlist.php');

 
    $sql = " update {$g5['promotion_address_table']}
                set pa_name  = '$pa_name',
                    pa_url     = '$pa_url',
                    pa_title   = '$pa_title',
                    pa_desc     = '$pa_desc',
                    pa_start    = '$pa_start',
                    pa_end      = '$pa_end',
                    pa_channel  = '$pa_channel'
                where pa_id = '$pa_id' ";
    sql_query($sql);
}


goto_url('./promotionaddlist.php');
?>