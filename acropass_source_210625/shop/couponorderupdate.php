<?php
include_once('./_common.php');

$msg = '';

if (!$is_member) {
    $msg = "쿠폰등록은 회원만 가능합니다.";
}

$coupon_code = trim($_POST['coupon_code']);
$hash = trim($_REQUEST['hash']);

$sql = " select * from {$g5['g5_shop_coupon_zone_table']} where cz_code = '$coupon_code' ";
$row = sql_fetch($sql);

if(!$row['cz_id']) {
	$msg = "입력하신 쿠폰코드가 올바르지 않습니다";
} else {

    if($row['cz_code_start'] > G5_TIME_YMD)
    	$msg = "입력하신 쿠폰코드의 사용기간이 아닙니다. 쿠폰사용기간 : ".$row['cz_code_start']." ~ ".$row['cz_code_end'];

    if($row['cz_code_end'] < G5_TIME_YMD)
    	$msg = "입력하신 쿠폰코드의 사용기간이 만료되었습니다";

    $cz_id = $row['cz_id'];
    $mb_id = $member['mb_id'];

    $sql2 = " select count(*) as cnt from {$g5['g5_shop_coupon_code_log_table']} where cz_id = '$cz_id' AND mb_id = '$mb_id' ";
    $row2 = sql_fetch($sql2);

    if($row2['cnt'] > 0)
    	$msg = "이미 사용된 쿠폰코드 입니다";

    $sql0 = " select count(*) as cnt from {$g5['g5_shop_coupon_code_log_table']} where cz_id = '$cz_id' ";
    $row0 = sql_fetch($sql0);

    if($row0['cnt'] >= $row['cz_code_max'])
    	$msg = "쿠폰코드 발행 최대횟수를 초과하였습니다";

}

if($msg == '') {

    $j = 0;
    $create_coupon = false;

    do {
        $cp_id = get_coupon_id();

        $sql3 = " select count(*) as cnt from {$g5['g5_shop_coupon_table']} where cp_id = '$cp_id' ";
        $row3 = sql_fetch($sql3);

        if(!$row3['cnt']) {
            $create_coupon = true;
            break;
        } else {
            if($j > 20)
                break;
        }
    } while(1);

    if($create_coupon) {
        $cp_subject = $row['cz_subject'];
        $cp_method = $row['cp_method'];
        $cp_target = $row['cp_target'];
        $cp_start = $row['cz_start'];
        $cp_end =  $row['cz_end'];
        $cp_type =  $row['cp_type'];
        $cp_price =  $row['cp_price'];
        $cp_trunc =  $row['cp_trunc'];
        $cp_minimum = $row['cp_minimum'];
        $cp_maximum =  $row['cp_maximum'];

        $sql4 = " INSERT INTO {$g5['g5_shop_coupon_table']}
                    ( cp_id, cp_subject, cp_method, cp_target, mb_id, cp_start, cp_end, cp_type, cp_price, cp_trunc, cp_minimum, cp_maximum, cp_datetime )
                VALUES
                    ( '$cp_id', '$cp_subject', '$cp_method', '$cp_target', '$mb_id', '$cp_start', '$cp_end', '$cp_type', '$cp_price', '$cp_trunc', '$cp_minimum', '$cp_maximum', '".G5_TIME_YMDHIS."' ) ";

        $res = sql_query($sql4, false);

        if($res) {
            set_session('ss_member_reg_coupon', 1);

            $sql5 = " INSERT INTO {$g5['g5_shop_coupon_code_log_table']}
                    ( cz_id, mb_id, cp_price, cc_datetime )
                VALUES
                    ( '$cz_id', '$mb_id', '$cp_price', '".G5_TIME_YMDHIS."' ) ";

            $res2 = sql_query($sql5, false);

            if (!$url)
        		$url = G5_URL."/shop/coupon.php";
            
            if($res2)
            	$msg = "쿠폰이 발급 되었습니다";

        }

        echo $msg;
    }

} else {
    echo $msg;
}

?>
