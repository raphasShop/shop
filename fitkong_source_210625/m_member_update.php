<?php
include_once('./_common.php');


function update_level($mb_id, $level) {
	global $member, $g5, $config, $default;
	
	sql_query(" update {$g5['member_table']} set mb_level = $level where mb_id = '$mb_id' ");
	
	return 0;
}
                

function issued_coupon($mb_id, $level) {
	global $member, $g5, $config, $default;

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
        $cp_subject = $level.' 무료 배송 쿠폰';
        $cp_method = 3;
        $cp_target = '';
        $cp_start = G5_TIME_YMD;
        $cp_end = date('Y-m-d', strtotime("+30 days", G5_SERVER_TIME));
        $cp_type = 1;
        $cp_price = 100;
        $cp_trunc = 100;
        $cp_minimum = 10;
        $cp_maximum = 0;

        $sql = " INSERT INTO {$g5['g5_shop_coupon_table']}
                    ( cp_id, cp_subject, cp_method, cp_target, mb_id, cp_start, cp_end, cp_type, cp_price, cp_trunc, cp_minimum, cp_maximum, cp_datetime )
                VALUES
                    ( '$cp_id', '$cp_subject', '$cp_method', '$cp_target', '$mb_id', '$cp_start', '$cp_end', '$cp_type', '$cp_price', '$cp_trunc', '$cp_minimum', '$cp_maximum', '".G5_TIME_YMDHIS."' ) ";

        $res = sql_query($sql, false);
    }

    return true;
} 

function birth_coupon($mb_id) {
	global $member, $g5, $config, $default;

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
        $cp_subject = '생일 축하 쿠폰';
        $cp_method = 2;
        $cp_target = '';
        $cp_start = G5_TIME_YMD;
        $cp_end = date('Y-m-d', strtotime("+30 days", G5_SERVER_TIME));
        $cp_type = 0;
        $cp_price = 3000;
        $cp_trunc = 1;
        $cp_minimum = 10000;
        $cp_maximum = 0;

        $sql = " INSERT INTO {$g5['g5_shop_coupon_table']}
                    ( cp_id, cp_subject, cp_method, cp_target, mb_id, cp_start, cp_end, cp_type, cp_price, cp_trunc, cp_minimum, cp_maximum, cp_datetime )
                VALUES
                    ( '$cp_id', '$cp_subject', '$cp_method', '$cp_target', '$mb_id', '$cp_start', '$cp_end', '$cp_type', '$cp_price', '$cp_trunc', '$cp_minimum', '$cp_maximum', '".G5_TIME_YMDHIS."' ) ";

        $res = sql_query($sql, false);
    }

    return true;
} 

if(!$is_admin) {
	alert("관리자만 접근 가능합니다.", G5_URL);
}

$this_month = date('m', strtotime("today", G5_SERVER_TIME));

if($default['de_member_update_month'] != $this_month) {

echo $this_month.'월 멤버 등급 업데이트<br><br>';

$sql = " select * from {$g5['member_table']}";
$result = sql_query($sql);
$level2 = '';
$level3 = '';
$level4 = '';
$level5 = '';
$birth_member = '';
$birth_cnt = 0;
$cnt2 = 0;
$cnt3 = 0;
$cnt4 = 0;
$cnt5 = 0;
$cnt_all = 0;

for($i=0; $row=sql_fetch_array($result); $i++)
{	
	$mb_id = $row['mb_id'];
	$start_date = date('Ym', strtotime("-1 year", G5_SERVER_TIME));
	$end_date =  date('Ym', strtotime("today", G5_SERVER_TIME));

	$start_date = $start_date.'0100000000';
	$end_date = $end_date.'0100000000';
	
	//echo $mb_id;
	//echo $start_date;
	//echo "<br>";
	//echo $end_date;

	$sql2 = " select SUM(od_receipt_price) AS sum_prices from {$g5['g5_shop_order_table']} where mb_id = '$mb_id' and od_id >= '$start_date' and od_id <= '$end_date' ";
	$sum = sql_fetch($sql2);
	$sum_prices = (int)$sum['sum_prices'];
	if($row['mb_level'] < 10) {
		if($sum_prices >= 100000 && $sum_prices < 300000) {
            //echo "3레벨 업데이트 ".$mb_id.' / ';
			update_level($mb_id,3);
			if($row['mb_level'] != 3) {
				$level3 .= $mb_id.' / ';
				$cnt3++;
			}
		} else if($sum_prices >= 300000 && $sum_prices < 500000) {
			update_level($mb_id,4);
			issued_coupon($mb_id,'핏콩서포터');
            //echo "4레벨 업데이트 ".$mb_id.' / ';
			if($row['mb_level'] != 4) {
				$level4 .= $mb_id.' / ';
				$cnt4++;
			}			
		} else if($sum_prices >= 500000) {
			update_level($mb_id,5);
			issued_coupon($mb_id,'핏콩패밀리');
			issued_coupon($mb_id,'핏콩패밀리');
            //echo "5레벨 업데이트 ".$mb_id.' / ';
			if($row['mb_level'] != 5) {
				$level5 .= $mb_id.' / ';
				$cnt5++;
			}
		} else if($sum_prices < 100000 && $row['mb_level'] != 2) {
			update_level($mb_id,2);
            //echo "2레벨 업데이트 ".$mb_id.' / ';
			if($row['mb_level'] != 2) {
				$level2 .= $mb_id.'/';
				$cnt2++;
			}
		} else {

		}
	}

	$cnt_all++;

	$birth_m = substr($row['mb_birth'], 4, 2);
	if($birth_m == $this_month) {
		$res = birth_coupon($mb_id);
        $birth_cnt++;
        $birth_member .= $row['mb_birth'].' '.$mb_id.'/';
	}

}

echo '핏콩프렌즈 변경명단<br>';
echo $level3;
echo '<br>총 '.$cnt3.'명<br><br>';
echo '핏콩서포터 변경명단<br>';
echo $level4;
echo '<br>총 '.$cnt4.'명<br><br>';
echo '핏콩패밀리 변경명단<br>';
echo $level5;
echo '<br>총 '.$cnt5.'명<br><br>';
echo '핏콩웰컴 변경명단<br>';
echo $level2;
echo '<br>총 '.$cnt2.'명<br><br>';
echo $this_month.'월 생일자명단<br>';
echo $birth_member;
echo '<br>총 '.$birth_cnt.'명<br><br>';
echo '<br> 총 회원 '.$cnt_all.'명<br>';

sql_query(" update {$g5['g5_shop_default_table']} set de_member_update_month = '$this_month' ");

} else {
	echo "이번 달 멤버 등급 업데이트는 진행 완료 되었습니다.";
}



?>