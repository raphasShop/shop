<?php
$sub_menu = '411640'; /* 수정전 원본 메뉴코드 400640 */
include_once('./_common.php');

check_demo();

check_admin_token();

if (!count($_POST['chk'])) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($_POST['act_button'] == "선택수정") {
    auth_check($auth[$sub_menu], 'w');
} else if ($_POST['act_button'] == "선택삭제") {
    auth_check($auth[$sub_menu], 'd');
} else {
    alert("선택수정이나 선택삭제 작업이 아닙니다.");
}

for ($i=0; $i<count($_POST['chk']); $i++)
{
    $k = $_POST['chk'][$i]; // 실제 번호를 넘김

    if ($_POST['act_button'] == "선택수정")
    {
        $sql = "update {$g5['g5_shop_order_atmcheck_table']}
                   set id_deposit_name   = '{$_POST['id_deposit_name'][$k]}',
				       id_money          = '{$_POST['id_money'][$k]}',
                       id_confirm        = '{$_POST['id_confirm'][$k]}'
                 where id_id             = '{$_POST['id_id'][$k]}' ";
        sql_query($sql);
    }
    else if ($_POST['act_button'] == "선택삭제")
    {
        $sql = "delete from {$g5['g5_shop_order_atmcheck_table']} where id_id = '{$_POST['id_id'][$k]}' ";
        sql_query($sql);
    }

    update_use_cnt($_POST['od_id'][$k]);
    update_use_avg($_POST['od_id'][$k]);
}

goto_url("./atmcheck.php?sca=$sca&amp;sst=$sst&amp;sod=$sod&amp;sfl=$sfl&amp;stx=$stx&amp;page=$page");
?>
