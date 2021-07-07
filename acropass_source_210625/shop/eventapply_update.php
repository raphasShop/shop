<?php
include_once('./_common.php');

if (!$is_member) {
    alert("이벤트응모는 회원만 가능합니다.");
}
$mb_id = $member['mb_id'];
$sql = " select * from {$g5['g5_shop_order_table']} where mb_id = '$mb_id' ";
$userorder = sql_query($sql);
$sum_order = 0;
$total_order = 0;

for ($i=0; $row=sql_fetch_array($userorder); $i++)
{
    if(($row['od_status'] == '완료' || $row['od_status'] == '입금' || $row['od_status'] == '배송' || $row['od_status'] == '준비') && $row['od_pg'] != 'naverpay')
        $sum_order = $sum_order + $row['od_cart_price']; 
}

$mb_hp = str_replace('-','',$member['mb_hp']);
$mb_name = $member['mb_name'];
$sql2 = " select * from {$g5['g5_shop_order_table']} where od_tel = '$mb_hp' AND od_name = '$mb_name' AND od_pg = 'naverpay' ";
$naverpayorder = sql_query($sql2);
$naverpay_sum_order = 0;

for ($i=0; $row=sql_fetch_array($naverpayorder); $i++)
{
    if($row['od_status'] == '완료' || $row['od_status'] == '입금' || $row['od_status'] == '배송' || $row['od_status'] == '준비')
        $naverpay_sum_order = $naverpay_sum_order + $row['od_cart_price']; 
}

$total_order = $sum_order + $naverpay_sum_order;

$evt_id = trim($_POST['evt_id']);
$evt_chk = trim($_POST['evt_chk']);
$evt_chk2 = trim($_POST['evt_chk2']);
$evt_chk3 = trim($_POST['evt_chk3']);
$evt_url = trim($_POST['eventapply_input']);

if (!$evt_id) {
    alert("잘못된 접근 입니다. 고객센터로 문의주세요");
}

$sql3 = " select count(*) as cnt from {$g5['g5_shop_event_apply_table']} where mb_id = '$mb_id' AND evt_id = '$evt_id' ";
$evt_cnt = sql_fetch($sql3);

if ($evt_cnt['cnt'] > 0) {
    alert("이벤트 응모는 1번만 가능합니다.");
}

if (!$evt_chk == 'on' && !$evt_chk2 =='on') {
    alert("참여대상을 선택해주세요");
}

if ($evt_chk2 == 'on' && !$evt_url) {
    alert("리그램 URL주소를 입력해주세요");
}

if (!$evt_chk3 == 'on') {
    alert("고객정보 이용에 동의해주셔야 이벤트 응모가 가능합니다.");
}

if (!$evt_chk4 == 'on') {
    alert("당첨 문자 안내에 확인하셔야 이벤트 응모가 가능합니다.");
}

if ($evt_chk == 'on' && $total_order < 30000) {
    alert("구매금액이 30,000원 이상인 고객만 이벤트 응모가 가능합니다.");
}


if($evt_chk == 'on' && !$evt_chk2) { $event = '구매고객';}
if(!$evt_chk && $evt_chk2 == 'on') { $event = '비구매고객';}
if($evt_chk == 'on' && $evt_chk2 == 'on') { $event = '모두해당';}

$sql = "insert into {$g5['g5_shop_event_apply_table']}
           set evt_id = '$evt_id',
               mb_id = '{$member['mb_id']}',
               mb_name = '{$member['mb_name']}',
               mb_nick = '{$member['mb_nick']}',
               mb_email = '{$member['mb_email']}',
               mb_hp  = '{$member['mb_hp']}',
               mb_addr1  = '{$member['mb_addr1']}',
               mb_addr2  = '{$member['mb_addr2']}',
               mb_birth  = '{$member['mb_birth']}',
               mb_sex  = '{$member['mb_sex']}',
               mb_sumorder = '{$sum_order}',
               mb_naverorder = '{$naverpay_sum_order}',
               mb_totalorder = '{$total_order}',
               evt_type = '{$event}',
               evt_time = '".G5_TIME_YMDHIS."',
               evt_url = '{$evt_url}',
               evt_ip = '$REMOTE_ADDR' ";
$res = sql_query($sql);

if($res) {
    alert("이벤트에 응모해주셔서 감사합니다.");
}


?>
