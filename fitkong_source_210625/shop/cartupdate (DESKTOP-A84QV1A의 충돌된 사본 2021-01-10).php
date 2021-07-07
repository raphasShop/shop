<?php
include_once('./_common.php');

// print_r2($_POST); exit;

// 보관기간이 지난 상품 삭제
cart_item_clean();

// cart id 설정
set_cart_id($sw_direct);

if($sw_direct)
    $tmp_cart_id = get_session('ss_cart_direct');
else
    $tmp_cart_id = get_session('ss_cart_id');

// 브라우저에서 쿠키를 허용하지 않은 경우라고 볼 수 있음.
if (!$tmp_cart_id)
{
    alert('더 이상 작업을 진행할 수 없습니다.\\n\\n브라우저의 쿠키 허용을 사용하지 않음으로 설정한것 같습니다.\\n\\n브라우저의 인터넷 옵션에서 쿠키 허용을 사용으로 설정해 주십시오.\\n\\n그래도 진행이 되지 않는다면 쇼핑몰 운영자에게 문의 바랍니다.');
}


// 레벨(권한)이 상품구입 권한보다 작다면 상품을 구입할 수 없음.
if ($member['mb_level'] < $default['de_level_sell'])
{
    //alert('상품을 구입할 수 있는 권한이 없습니다.');
    alert('로그인 후 이용해 주십시오.');
}

if($act == "buy")
{
    if(!count($_POST['ct_chk']))
        alert("주문하실 상품을 하나이상 선택해 주십시오.");

    // 선택필드 초기화
    $sql = " update {$g5['g5_shop_cart_table']} set ct_select = '0' where od_id = '$tmp_cart_id' ";
    sql_query($sql);

    $fldcnt = count($_POST['it_id']);
    for($i=0; $i<$fldcnt; $i++) {
        $ct_chk = $_POST['ct_chk'][$i];
        if($ct_chk) {
            $it_id = $_POST['it_id'][$i];


            // 주문 상품의 재고체크
            $sql = " select ct_qty, it_name, ct_option, io_id, io_type
                        from {$g5['g5_shop_cart_table']}
                        where od_id = '$tmp_cart_id'
                          and it_id = '$it_id' ";
            $result = sql_query($sql);

            for($k=0; $row=sql_fetch_array($result); $k++) {
                $sql = " select SUM(ct_qty) as cnt from {$g5['g5_shop_cart_table']}
                          where od_id <> '$tmp_cart_id'
                            and it_id = '$it_id'
                            and io_id = '{$row['io_id']}'
                            and io_type = '{$row['io_type']}'
                            and ct_stock_use = 0
                            and ct_status = '쇼핑'
                            and ct_select = '1' ";
                $sum = sql_fetch($sql);
                $sum_qty = $sum['cnt'];

                // 재고 구함
                $ct_qty = $row['ct_qty'];
                if(!$row['io_id'])
                    $it_stock_qty = get_it_stock_qty($it_id);
                else
                    $it_stock_qty = get_option_stock_qty($it_id, $row['io_id'], $row['io_type']);

                if ($ct_qty + $sum_qty > $it_stock_qty)
                {
                    $item_option = $row['it_name'];
                    if($row['io_id'])
                        $item_option .= '('.$row['ct_option'].')';

                    alert($item_option." 의 재고수량이 부족합니다.\\n\\n현재 재고수량 : " . number_format($it_stock_qty - $sum_qty) . " 개");
                }
            }

            $sql = " update {$g5['g5_shop_cart_table']}
                        set ct_select = '1',
                            ct_select_time = '".G5_TIME_YMDHIS."'
                        where od_id = '$tmp_cart_id'
                          and it_id = '$it_id' ";
            sql_query($sql);
        }
    }

    if ($is_member) // 회원인 경우
        goto_url(G5_SHOP_URL.'/orderform.php');
    else
        goto_url(G5_BBS_URL.'/login.php?url='.urlencode(G5_SHOP_URL.'/orderform.php'));
}
else if ($act == "alldelete") // 모두 삭제이면
{
    $sql = " delete from {$g5['g5_shop_cart_table']}
              where od_id = '$tmp_cart_id' ";
    sql_query($sql);
}
else if ($act == "seldelete") // 선택삭제
{
    if(!count($_POST['ct_chk']))
        alert("삭제하실 상품을 하나이상 선택해 주십시오.");

    $fldcnt = count($_POST['it_id']);
    for($i=0; $i<$fldcnt; $i++) {
        $ct_chk = $_POST['ct_chk'][$i];
        if($ct_chk) {
            $it_id = $_POST['it_id'][$i];
            $sql = " delete from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and od_id = '$tmp_cart_id' ";
            sql_query($sql);
        }
    }
}
else // 장바구니에 담기
{
    $count = count($_POST['it_id']);
    if ($count < 1)
        alert('장바구니에 담을 상품을 선택하여 주십시오.');

    $ct_count = 0;
    for($i=0; $i<$count; $i++) {
        // 보관함의 상품을 담을 때 체크되지 않은 상품 건너뜀
        if($act == 'multi' && !$_POST['chk_it_id'][$i])
            continue;

        $it_id = $_POST['it_id'][$i];
        $opt_count = count($_POST['io_id'][$it_id]);
        $ct_count = $_POST['ct_qty'][$it_id][0];

        
        if($opt_count && $_POST['io_type'][$it_id][0] != 0)
            alert('상품의 선택옵션을 선택해 주십시오.');

        for($k=0; $k<$opt_count; $k++) {
            if ($_POST['ct_qty'][$it_id][$k] < 1)
                alert('수량은 1 이상 입력해 주십시오.');
        }

        // 상품정보
        $sql = " select * from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
        $it = sql_fetch($sql);
        if(!$it['it_id'])
            alert('상품정보가 존재하지 않습니다.');

        // 바로구매에 있던 장바구니 자료를 지운다.
        if($i == 0 && $sw_direct)
            sql_query(" delete from {$g5['g5_shop_cart_table']} where od_id = '$tmp_cart_id' and ct_direct = 1 ", false);

        // 최소, 최대 수량 체크
        if($it['it_buy_min_qty'] || $it['it_buy_max_qty']) {
            $sum_qty = 0;
            for($k=0; $k<$opt_count; $k++) {
                if($_POST['io_type'][$it_id][$k] == 0)
                    $sum_qty += (int) $_POST['ct_qty'][$it_id][$k];
            }

            if($it['it_buy_min_qty'] > 0 && $sum_qty < $it['it_buy_min_qty'])
                alert($it['it_name'].'의 선택옵션 개수 총합 '.number_format($it['it_buy_min_qty']).'개 이상 주문해 주십시오.');

            if($it['it_buy_max_qty'] > 0 && $sum_qty > $it['it_buy_max_qty'])
                alert($it['it_name'].'의 선택옵션 개수 총합 '.number_format($it['it_buy_max_qty']).'개 이하로 주문해 주십시오.');

            // 기존에 장바구니에 담긴 상품이 있는 경우에 최대 구매수량 체크
            if($it['it_buy_max_qty'] > 0) {
                $sql4 = " select sum(ct_qty) as ct_sum
                            from {$g5['g5_shop_cart_table']}
                            where od_id = '$tmp_cart_id'
                              and it_id = '$it_id'
                              and io_type = '0'
                              and ct_status = '쇼핑' ";
                $row4 = sql_fetch($sql4);

                if(($sum_qty + $row4['ct_sum']) > $it['it_buy_max_qty'])
                    alert($it['it_name'].'의 선택옵션 개수 총합 '.number_format($it['it_buy_max_qty']).'개 이하로 주문해 주십시오.', './cart.php');
            }
        }

        // 구매 수량 제한 체크
        if($it['it_6']) {
          $mb_id = $member['mb_id'];
          $sql = " select * from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and mb_id = '$mb_id' ";
          $res = sql_query($sql);
          $order_cnt = 0;
          for($i=0; $row=sql_fetch_array($res); $i++) {
                if(($row['ct_status'] == '쇼핑' && $row['ct_direct'] == 0)|| $row['ct_status'] == '입금' || $row['ct_status'] == '배송' || $row['ct_status'] == '완료') {
                    $order_cnt = $order_cnt + $row['ct_qty'];
                }  
          }

          $plus_ct_count = (int)$order_cnt + (int)$ct_count;
          if($plus_ct_count > (int)$it['it_6']) {
             alert('최대 구매가능한 수량을 초과하였습니다.');
          }
        }

        // 옵션정보를 얻어서 배열에 저장
        $opt_list = array();
        $sql = " select * from {$g5['g5_shop_item_option_table']} where it_id = '$it_id' and io_use = 1 order by io_no asc ";
        $result = sql_query($sql);
        $lst_count = 0;
        for($k=0; $row=sql_fetch_array($result); $k++) {
            /* 할인율 정의
            if(defined("G5_SHOP_DSICOUNT_RATE"))  {
                $row['io_price'] = round($row['io_price'] * G5_SHOP_DSICOUNT_RATE); 
                echo "<script>alert('hi');</script>";
            }
            */

            $opt_list[$row['io_type']][$row['io_id']]['id'] = $row['io_id'];
            $opt_list[$row['io_type']][$row['io_id']]['use'] = $row['io_use'];
            $opt_list[$row['io_type']][$row['io_id']]['price'] = $row['io_price'];
            $opt_list[$row['io_type']][$row['io_id']]['stock'] = $row['io_stock_qty'];

            // 선택옵션 개수
            if(!$row['io_type'])
                $lst_count++;
        }

        //--------------------------------------------------------
        //  재고 검사, 바로구매일 때만 체크
        //--------------------------------------------------------
        // 이미 주문폼에 있는 같은 상품의 수량합계를 구한다.
        if($sw_direct) {
            for($k=0; $k<$opt_count; $k++) {
                $io_id = preg_replace(G5_OPTION_ID_FILTER, '', $_POST['io_id'][$it_id][$k]);
                $io_type = preg_replace('#[^01]#', '', $_POST['io_type'][$it_id][$k]);
                $io_value = $_POST['io_value'][$it_id][$k];

                $sql = " select SUM(ct_qty) as cnt from {$g5['g5_shop_cart_table']}
                          where od_id <> '$tmp_cart_id'
                            and it_id = '$it_id'
                            and io_id = '$io_id'
                            and io_type = '$io_type'
                            and ct_stock_use = 0
                            and ct_status = '쇼핑'
                            and ct_select = '1' ";
                $row = sql_fetch($sql);
                $sum_qty = $row['cnt'];

                // 재고 구함
                $ct_qty = (int) $_POST['ct_qty'][$it_id][$k];
                if(!$io_id)
                    $it_stock_qty = get_it_stock_qty($it_id);
                else
                    $it_stock_qty = get_option_stock_qty($it_id, $io_id, $io_type);

                if ($ct_qty + $sum_qty > $it_stock_qty)
                {
                    alert($io_value." 의 재고수량이 부족합니다.\\n\\n현재 재고수량 : " . number_format($it_stock_qty - $sum_qty) . " 개");
                }
            }
        }
        //--------------------------------------------------------

        // 옵션수정일 때 기존 장바구니 자료를 먼저 삭제
        if($act == 'optionmod')
            sql_query(" delete from {$g5['g5_shop_cart_table']} where od_id = '$tmp_cart_id' and it_id = '$it_id' ");

        // 장바구니에 Insert
        // 바로구매일 경우 장바구니가 체크된것으로 강제 설정
        if($sw_direct) {
            $ct_select = 1;
            $ct_select_time = G5_TIME_YMDHIS;
        } else {
            $ct_select = 0;
            $ct_select_time = '0000-00-00 00:00:00';
        }

        // 장바구니에 Insert
        $comma = '';
        $sql = " INSERT INTO {$g5['g5_shop_cart_table']}
                        ( od_id, mb_id, it_id, it_name, it_sc_type, it_sc_method, it_sc_price, it_sc_minimum, it_sc_qty, ct_status, ct_price, ct_point, ct_point_use, ct_stock_use, ct_option, ct_qty, ct_notax, io_id, io_type, io_price, ct_time, ct_ip, ct_send_cost, ct_direct, ct_select, ct_select_time )
                    VALUES ";

        for($k=0; $k<$opt_count; $k++) {
            $io_id = preg_replace(G5_OPTION_ID_FILTER, '', $_POST['io_id'][$it_id][$k]);
            $io_type = preg_replace('#[^01]#', '', $_POST['io_type'][$it_id][$k]);
            $io_value = $_POST['io_value'][$it_id][$k];

            //alert($io_id.'|||'.$io_type.'|||'.$io_value);

            // 선택옵션정보가 존재하는데 선택된 옵션이 없으면 건너뜀
            if($lst_count && $io_id == '')
                continue;

            // 구매할 수 없는 옵션은 건너뜀
            if($io_id && !$opt_list[$io_type][$io_id]['use'])
                continue;

            $io_price = $opt_list[$io_type][$io_id]['price'];
            $ct_qty = (int) $_POST['ct_qty'][$it_id][$k];
            

            // 구매가격이 음수인지 체크
            if($io_type) {
                if((int)$io_price < 0)
                    alert('구매금액이 음수인 상품은 구매할 수 없습니다.');
            } else {
                if((int)$it['it_price'] + (int)$io_price < 0)
                    alert('구매금액이 음수인 상품은 구매할 수 없습니다.');

                //comcose_edit_2017.05.08 금액조정 시작
                    //제외아이템
                    $sql_except_it = "select *, group_concat(cose_except_add_it_id) as 'except_it' from comcose_sellprice_item_except";
                    $result_except_it = sql_query($sql_except_it);
                    $add_except_it= sql_fetch_array($result_except_it);
                    $add_except_it_array = explode(',', $add_except_it['except_it']);
                    //제외카테고리
                    $sql_except_cat_cnt="select * from comcose_sellprice_category_except";
                    $result_except_cat_cnt = sql_query($sql_except_cat_cnt);
                    $sql_except_cat = "select *, group_concat(cose_except_add_cat_id) as 'except_cat' from comcose_sellprice_category_except";
                    $result_except_cat = sql_query($sql_except_cat);
                    $add_except_cat= sql_fetch_array($result_except_cat);
                    if (sql_num_rows($result_except_cat_cnt) > 0) {$add_except_cat_array = explode(',', $add_except_cat['except_cat']);}else if (sql_num_rows($result_except_cat_cnt) == 0){$add_except_cat_array = array(comcose);}
                    //아이템별
                    $sql_add_item="select * from comcose_sellprice_item_add";
                    $result_add_item = sql_query($sql_add_item);
                    //카테고리별
                    $sql_add_cat="select * from comcose_sellprice_category_add where cose_cat_add_use = 1";
                    $result_add_cat = sql_query($sql_add_cat);
                    //회원권한별
                    $sql_add_user ="select * from comcose_sellprice_level";
                    $result_add_user = sql_query($sql_add_user);
                    $add_user = sql_fetch_array($result_add_user);
                    $level1 = round($it['it_price'] * ($add_user['cose_add_level_1'] / 100));
                    $level2 = round($it['it_price'] * ($add_user['cose_add_level_2'] / 100));
                    $level3 = round($it['it_price'] * ($add_user['cose_add_level_3'] / 100));
                    $level4 = round($it['it_price'] * ($add_user['cose_add_level_4'] / 100));
                    $level5 = round($it['it_price'] * ($add_user['cose_add_level_5'] / 100));
                    $level6 = round($it['it_price'] * ($add_user['cose_add_level_6'] / 100));
                    $level7 = round($it['it_price'] * ($add_user['cose_add_level_7'] / 100));
                    $level8 = round($it['it_price'] * ($add_user['cose_add_level_8'] / 100));
                    $level9 = round($it['it_price'] * ($add_user['cose_add_level_9'] / 100));
                    //아이템별 적용시
                    if (sql_num_rows($result_add_item) > 0) {
                        //1등급
                        if ($member['mb_level'] == 1){
                            for($i=0; $row_add_item = sql_fetch_array($result_add_item); $i++){
                                if($it['it_id'] == $row_add_item['cose_item_add_it_id']){
                                    if($row_add_item['cose_item_add_set_price_type1'] == '+' ){$cart_price = $it['it_price'] + $row_add_item['cose_item_add_set_price1'];}
                                    else if($row_add_item['cose_item_add_set_price_type1'] == '-' ){$cart_price = $it['it_price'] - $row_add_item['cose_item_add_set_price1'];}
                                    break 1;
                                }
                                //제외아이템
                                else if (in_array($it['it_id'], $add_except_it_array)){$cart_price = $it['it_price'];}
                                //제외카테고리
                                else if (in_array($it['ca_id'], $add_except_cat_array) or in_array($it['ca_id2'], $add_except_cat_array) or in_array($it['ca_id3'], $add_except_cat_array)){$cart_price = $it['it_price'];}
                                //카테고리별 적용시
                                else if (sql_num_rows($result_add_cat) > 0) {
                                    for($i=0; $row_add_cat = sql_fetch_array($result_add_cat); $i++){
                                        if($it['ca_id'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id2'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id3'] == $row_add_cat['cose_cat_add_cat_id']){
                                            if($row_add_cat['cose_cat_add_set_price_type'] == '+' ){$cart_price = $it['it_price'] + $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            else if($row_add_cat['cose_cat_add_set_price_type'] == '-' ){$cart_price = $it['it_price'] - $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            break 2;
                                        } else {
                                            //회원권한별
                                            if ($add_user['cose_add_level_use'] == 1 ){
                                                if($add_user['cose_add_level_1_type'] == '+' or $add_user['cose_add_level_1_type'] == ''){$cart_price = $it['it_price'] + $level1;}else if($add_user['cose_add_level_1_type'] == '-' ){$cart_price = $it['it_price'] - $level1;}
                                            } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                        }
                                    }
                                }
                                //카테고리별 미적용시
                                else if (sql_num_rows($result_add_cat) == 0) {
                                    //회원권한별
                                    if ($add_user['cose_add_level_use'] == 1 ){
                                        if($add_user['cose_add_level_1_type'] == '+' or $add_user['cose_add_level_1_type'] == ''){$cart_price = $it['it_price'] + $level1;}else if($add_user['cose_add_level_1_type'] == '-' ){$cart_price = $it['it_price'] - $level1;}
                                    } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                }
                            }
                        }
                        //2등급
                        else if ($member['mb_level'] == 2){
                            for($i=0; $row_add_item = sql_fetch_array($result_add_item); $i++){
                                if($it['it_id'] == $row_add_item['cose_item_add_it_id']){
                                    if($row_add_item['cose_item_add_set_price_type2'] == '+' ){$cart_price = $it['it_price'] + $row_add_item['cose_item_add_set_price2'];}
                                    else if($row_add_item['cose_item_add_set_price_type2'] == '-' ){$cart_price = $it['it_price'] - $row_add_item['cose_item_add_set_price2'];}
                                    break 1;
                                }
                                //제외아이템
                                else if (in_array($it['it_id'], $add_except_it_array)){$cart_price = $it['it_price'];}
                                //제외카테고리
                                else if (in_array($it['ca_id'], $add_except_cat_array) or in_array($it['ca_id2'], $add_except_cat_array) or in_array($it['ca_id3'], $add_except_cat_array)){$cart_price = $it['it_price'];}
                                //카테고리별 적용시
                                else if (sql_num_rows($result_add_cat) > 0) {
                                    for($i=0; $row_add_cat = sql_fetch_array($result_add_cat); $i++){
                                        if($it['ca_id'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id2'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id3'] == $row_add_cat['cose_cat_add_cat_id']){
                                            if($row_add_cat['cose_cat_add_set_price_type'] == '+' ){$cart_price = $it['it_price'] + $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            else if($row_add_cat['cose_cat_add_set_price_type'] == '-' ){$cart_price = $it['it_price'] - $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            break 2;
                                        } else {
                                            //회원권한별
                                            if ($add_user['cose_add_level_use'] == 1 ){
                                                if($add_user['cose_add_level_2_type'] == '+' ){$cart_price = $it['it_price'] + $level2;}else if($add_user['cose_add_level_2_type'] == '-' ){$cart_price = $it['it_price'] - $level2;}
                                            } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                        }
                                    }
                                }
                                //카테고리별 미적용시
                                else if (sql_num_rows($result_add_cat) == 0) {
                                    //회원권한별
                                    if ($add_user['cose_add_level_use'] == 1 ){
                                        if($add_user['cose_add_level_2_type'] == '+' ){$cart_price = $it['it_price'] + $level2;}else if($add_user['cose_add_level_2_type'] == '-' ){$cart_price = $it['it_price'] - $level2;}
                                    } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                }
                            }
                        }
                        //3등급
                        else if ($member['mb_level'] == 3){
                            for($i=0; $row_add_item = sql_fetch_array($result_add_item); $i++){
                                if($it['it_id'] == $row_add_item['cose_item_add_it_id']){
                                    if($row_add_item['cose_item_add_set_price_type3'] == '+' ){$cart_price = $it['it_price'] + $row_add_item['cose_item_add_set_price3'];}
                                    else if($row_add_item['cose_item_add_set_price_type3'] == '-' ){$cart_price = $it['it_price'] - $row_add_item['cose_item_add_set_price3'];}
                                    break 1;
                                }
                                //제외아이템
                                else if (in_array($it['it_id'], $add_except_it_array)){$cart_price = $it['it_price'];}
                                //제외카테고리
                                else if (in_array($it['ca_id'], $add_except_cat_array) or in_array($it['ca_id2'], $add_except_cat_array) or in_array($it['ca_id3'], $add_except_cat_array)){$cart_price = $it['it_price'];}
                                //카테고리별 적용시
                                else if (sql_num_rows($result_add_cat) > 0) {
                                    for($i=0; $row_add_cat = sql_fetch_array($result_add_cat); $i++){
                                        if($it['ca_id'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id2'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id3'] == $row_add_cat['cose_cat_add_cat_id']){
                                            if($row_add_cat['cose_cat_add_set_price_type'] == '+' ){$cart_price = $it['it_price'] + $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            else if($row_add_cat['cose_cat_add_set_price_type'] == '-' ){$cart_price = $it['it_price'] - $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            break 2;
                                        } else {
                                            //회원권한별
                                            if ($add_user['cose_add_level_use'] == 1 ){
                                                if($add_user['cose_add_level_3_type'] == '+' ){$cart_price = $it['it_price'] + $level3;}else if($add_user['cose_add_level_3_type'] == '-' ){$cart_price = $it['it_price'] - $level3;}
                                                else if ($member['mb_level'] == 10){$cart_price = $it['it_price'];}
                                            } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                        }
                                    }
                                }
                                //카테고리별 미적용시
                                else if (sql_num_rows($result_add_cat) == 0) {
                                    //회원권한별
                                    if ($add_user['cose_add_level_use'] == 1 ){
                                        if($add_user['cose_add_level_3_type'] == '+' ){$cart_price = $it['it_price'] + $level3;}else if($add_user['cose_add_level_3_type'] == '-' ){$cart_price = $it['it_price'] - $level3;}
                                    } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                }
                            }
                        }
                        //4등급
                        else if ($member['mb_level'] == 4){
                            for($i=0; $row_add_item = sql_fetch_array($result_add_item); $i++){
                                if($it['it_id'] == $row_add_item['cose_item_add_it_id']){
                                    if($row_add_item['cose_item_add_set_price_type4'] == '+' ){$cart_price = $it['it_price'] + $row_add_item['cose_item_add_set_price4'];}
                                    else if($row_add_item['cose_item_add_set_price_type4'] == '-' ){$cart_price = $it['it_price'] - $row_add_item['cose_item_add_set_price4'];}
                                    break 1;
                                }
                                //제외아이템
                                else if (in_array($it['it_id'], $add_except_it_array)){$cart_price = $it['it_price'];}
                                //제외카테고리
                                else if (in_array($it['ca_id'], $add_except_cat_array) or in_array($it['ca_id2'], $add_except_cat_array) or in_array($it['ca_id3'], $add_except_cat_array)){$cart_price = $it['it_price'];}
                                //카테고리별 적용시
                                else if (sql_num_rows($result_add_cat) > 0) {
                                    for($i=0; $row_add_cat = sql_fetch_array($result_add_cat); $i++){
                                        if($it['ca_id'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id2'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id3'] == $row_add_cat['cose_cat_add_cat_id']){
                                            if($row_add_cat['cose_cat_add_set_price_type'] == '+' ){$cart_price = $it['it_price'] + $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            else if($row_add_cat['cose_cat_add_set_price_type'] == '-' ){$cart_price = $it['it_price'] - $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            break 2;
                                        } else {
                                            //회원권한별
                                            if ($add_user['cose_add_level_use'] == 1 ){
                                                if($add_user['cose_add_level_4_type'] == '+' ){$cart_price = $it['it_price'] + $level4;}else if($add_user['cose_add_level_4_type'] == '-' ){$cart_price = $it['it_price'] - $level4;}
                                            } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                        }
                                    }
                                }
                                //카테고리별 미적용시
                                else if (sql_num_rows($result_add_cat) == 0) {
                                    //회원권한별
                                    if ($add_user['cose_add_level_use'] == 1 ){
                                        if($add_user['cose_add_level_4_type'] == '+' ){$cart_price = $it['it_price'] + $level4;}else if($add_user['cose_add_level_4_type'] == '-' ){$cart_price = $it['it_price'] - $level4;}
                                    } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                }
                            }
                        }
                        //5등급
                        else if ($member['mb_level'] == 5){
                            for($i=0; $row_add_item = sql_fetch_array($result_add_item); $i++){
                                if($it['it_id'] == $row_add_item['cose_item_add_it_id']){
                                    if($row_add_item['cose_item_add_set_price_type5'] == '+' ){$cart_price = $it['it_price'] + $row_add_item['cose_item_add_set_price5'];}
                                    else if($row_add_item['cose_item_add_set_price_type5'] == '-' ){$cart_price = $it['it_price'] - $row_add_item['cose_item_add_set_price5'];}
                                    break 1;
                                }
                                //제외아이템
                                else if (in_array($it['it_id'], $add_except_it_array)){$cart_price = $it['it_price'];}
                                //제외카테고리
                                else if (in_array($it['ca_id'], $add_except_cat_array) or in_array($it['ca_id2'], $add_except_cat_array) or in_array($it['ca_id3'], $add_except_cat_array)){$cart_price = $it['it_price'];}
                                //카테고리별 적용시
                                else if (sql_num_rows($result_add_cat) > 0) {
                                    for($i=0; $row_add_cat = sql_fetch_array($result_add_cat); $i++){
                                        if($it['ca_id'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id2'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id3'] == $row_add_cat['cose_cat_add_cat_id']){
                                            if($row_add_cat['cose_cat_add_set_price_type'] == '+' ){$cart_price = $it['it_price'] + $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            else if($row_add_cat['cose_cat_add_set_price_type'] == '-' ){$cart_price = $it['it_price'] - $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            break 2;
                                        } else {
                                            //회원권한별
                                            if ($add_user['cose_add_level_use'] == 1 ){
                                                if($add_user['cose_add_level_5_type'] == '+' ){$cart_price = $it['it_price'] + $level5;}else if($add_user['cose_add_level_5_type'] == '-' ){$cart_price = $it['it_price'] - $level5;}
                                            } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                        }
                                    }
                                }
                                //카테고리별 미적용시
                                else if (sql_num_rows($result_add_cat) == 0) {
                                    //회원권한별
                                    if ($add_user['cose_add_level_use'] == 1 ){
                                        if($add_user['cose_add_level_5_type'] == '+' ){$cart_price = $it['it_price'] + $level5;}else if($add_user['cose_add_level_5_type'] == '-' ){$cart_price = $it['it_price'] - $level5;}
                                    } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                }
                            }
                        }
                        //6등급
                        else if ($member['mb_level'] == 6){
                            for($i=0; $row_add_item = sql_fetch_array($result_add_item); $i++){
                                if($it['it_id'] == $row_add_item['cose_item_add_it_id']){
                                    if($row_add_item['cose_item_add_set_price_type6'] == '+' ){$cart_price = $it['it_price'] + $row_add_item['cose_item_add_set_price6'];}
                                    else if($row_add_item['cose_item_add_set_price_type6'] == '-' ){$cart_price = $it['it_price'] - $row_add_item['cose_item_add_set_price6'];}
                                    break 1;
                                }
                                //제외아이템
                                else if (in_array($it['it_id'], $add_except_it_array)){$cart_price = $it['it_price'];}
                                //제외카테고리
                                else if (in_array($it['ca_id'], $add_except_cat_array) or in_array($it['ca_id2'], $add_except_cat_array) or in_array($it['ca_id3'], $add_except_cat_array)){$cart_price = $it['it_price'];}
                                //카테고리별 적용시
                                else if (sql_num_rows($result_add_cat) > 0) {
                                    for($i=0; $row_add_cat = sql_fetch_array($result_add_cat); $i++){
                                        if($it['ca_id'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id2'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id3'] == $row_add_cat['cose_cat_add_cat_id']){
                                            if($row_add_cat['cose_cat_add_set_price_type'] == '+' ){$cart_price = $it['it_price'] + $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            else if($row_add_cat['cose_cat_add_set_price_type'] == '-' ){$cart_price = $it['it_price'] - $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            break 2;
                                        } else {
                                            //회원권한별
                                            if ($add_user['cose_add_level_use'] == 1 ){
                                                if($add_user['cose_add_level_6_type'] == '+' ){$cart_price = $it['it_price'] + $level6;}else if($add_user['cose_add_level_6_type'] == '-' ){$cart_price = $it['it_price'] - $level6;}
                                            } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                        }
                                    }
                                }
                                //카테고리별 미적용시
                                else if (sql_num_rows($result_add_cat) == 0) {
                                    //회원권한별
                                    if ($add_user['cose_add_level_use'] == 1 ){
                                        if($add_user['cose_add_level_6_type'] == '+' ){$cart_price = $it['it_price'] + $level6;}else if($add_user['cose_add_level_6_type'] == '-' ){$cart_price = $it['it_price'] - $level6;}
                                    } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                }
                            }
                        }
                        //7등급
                        else if ($member['mb_level'] == 7){
                            for($i=0; $row_add_item = sql_fetch_array($result_add_item); $i++){
                                if($it['it_id'] == $row_add_item['cose_item_add_it_id']){
                                    if($row_add_item['cose_item_add_set_price_type7'] == '+' ){$cart_price = $it['it_price'] + $row_add_item['cose_item_add_set_price7'];}
                                    else if($row_add_item['cose_item_add_set_price_type7'] == '-' ){$cart_price = $it['it_price'] - $row_add_item['cose_item_add_set_price7'];}
                                    break 1;
                                }
                                //제외아이템
                                else if (in_array($it['it_id'], $add_except_it_array)){$cart_price = $it['it_price'];}
                                //제외카테고리
                                else if (in_array($it['ca_id'], $add_except_cat_array) or in_array($it['ca_id2'], $add_except_cat_array) or in_array($it['ca_id3'], $add_except_cat_array)){$cart_price = $it['it_price'];}
                                //카테고리별 적용시
                                else if (sql_num_rows($result_add_cat) > 0) {
                                    for($i=0; $row_add_cat = sql_fetch_array($result_add_cat); $i++){
                                        if($it['ca_id'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id2'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id3'] == $row_add_cat['cose_cat_add_cat_id']){
                                            if($row_add_cat['cose_cat_add_set_price_type'] == '+' ){$cart_price = $it['it_price'] + $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            else if($row_add_cat['cose_cat_add_set_price_type'] == '-' ){$cart_price = $it['it_price'] - $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            break 2;
                                        } else {
                                            //회원권한별
                                            if ($add_user['cose_add_level_use'] == 1 ){
                                                if($add_user['cose_add_level_7_type'] == '+' ){$cart_price = $it['it_price'] + $level7;}else if($add_user['cose_add_level_7_type'] == '-' ){$cart_price = $it['it_price'] - $level7;}
                                            } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                        }
                                    }
                                }
                                //카테고리별 미적용시
                                else if (sql_num_rows($result_add_cat) == 0) {
                                    //회원권한별
                                    if ($add_user['cose_add_level_use'] == 1 ){
                                        if($add_user['cose_add_level_7_type'] == '+' ){$cart_price = $it['it_price'] + $level7;}else if($add_user['cose_add_level_7_type'] == '-' ){$cart_price = $it['it_price'] - $level7;}
                                    } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                }
                            }
                        }
                        //8등급
                        else if ($member['mb_level'] == 8){
                            for($i=0; $row_add_item = sql_fetch_array($result_add_item); $i++){
                                if($it['it_id'] == $row_add_item['cose_item_add_it_id']){
                                    if($row_add_item['cose_item_add_set_price_type8'] == '+' ){$cart_price = $it['it_price'] + $row_add_item['cose_item_add_set_price8'];}
                                    else if($row_add_item['cose_item_add_set_price_type8'] == '-' ){$cart_price = $it['it_price'] - $row_add_item['cose_item_add_set_price8'];}
                                    break 1;
                                }
                                //제외아이템
                                else if (in_array($it['it_id'], $add_except_it_array)){$cart_price = $it['it_price'];}
                                //제외카테고리
                                else if (in_array($it['ca_id'], $add_except_cat_array) or in_array($it['ca_id2'], $add_except_cat_array) or in_array($it['ca_id3'], $add_except_cat_array)){$cart_price = $it['it_price'];}
                                //카테고리별 적용시
                                else if (sql_num_rows($result_add_cat) > 0) {
                                    for($i=0; $row_add_cat = sql_fetch_array($result_add_cat); $i++){
                                        if($it['ca_id'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id2'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id3'] == $row_add_cat['cose_cat_add_cat_id']){
                                            if($row_add_cat['cose_cat_add_set_price_type'] == '+' ){$cart_price = $it['it_price'] + $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            else if($row_add_cat['cose_cat_add_set_price_type'] == '-' ){$cart_price = $it['it_price'] - $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            break 2;
                                        } else {
                                            //회원권한별
                                            if ($add_user['cose_add_level_use'] == 1 ){
                                                if($add_user['cose_add_level_8_type'] == '+' ){$cart_price = $it['it_price'] + $level8;}else if($add_user['cose_add_level_8_type'] == '-' ){$cart_price = $it['it_price'] - $level8;}
                                            } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                        }
                                    }
                                }
                                //카테고리별 미적용시
                                else if (sql_num_rows($result_add_cat) == 0) {
                                    //회원권한별
                                    if ($add_user['cose_add_level_use'] == 1 ){
                                        if($add_user['cose_add_level_8_type'] == '+' ){$cart_price = $it['it_price'] + $level8;}else if($add_user['cose_add_level_8_type'] == '-' ){$cart_price = $it['it_price'] - $level8;}
                                    } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                }
                            }
                        }
                        //9등급
                        else if ($member['mb_level'] == 9){
                            for($i=0; $row_add_item = sql_fetch_array($result_add_item); $i++){
                                if($it['it_id'] == $row_add_item['cose_item_add_it_id']){
                                    if($row_add_item['cose_item_add_set_price_type9'] == '+' ){$cart_price = $it['it_price'] + $row_add_item['cose_item_add_set_price9'];}
                                    else if($row_add_item['cose_item_add_set_price_type9'] == '-' ){$cart_price = $it['it_price'] - $row_add_item['cose_item_add_set_price9'];}
                                    break 1;
                                }
                                //제외아이템
                                else if (in_array($it['it_id'], $add_except_it_array)){$cart_price = $it['it_price'];}
                                //제외카테고리
                                else if (in_array($it['ca_id'], $add_except_cat_array) or in_array($it['ca_id2'], $add_except_cat_array) or in_array($it['ca_id3'], $add_except_cat_array)){$cart_price = $it['it_price'];}
                                //카테고리별 적용시
                                else if (sql_num_rows($result_add_cat) > 0) {
                                    for($i=0; $row_add_cat = sql_fetch_array($result_add_cat); $i++){
                                        if($it['ca_id'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id2'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id3'] == $row_add_cat['cose_cat_add_cat_id']){
                                            if($row_add_cat['cose_cat_add_set_price_type'] == '+' ){$cart_price = $it['it_price'] + $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            else if($row_add_cat['cose_cat_add_set_price_type'] == '-' ){$cart_price = $it['it_price'] - $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                            break 2;
                                        } else {
                                            //회원권한별
                                            if ($add_user['cose_add_level_use'] == 1 ){
                                                if($add_user['cose_add_level_9_type'] == '+' ){$cart_price = $it['it_price'] + $level9;}else if($add_user['cose_add_level_9_type'] == '-' ){$cart_price = $it['it_price'] - $level9;}
                                            } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                        }
                                    }
                                }
                                //카테고리별 미적용시
                                else if (sql_num_rows($result_add_cat) == 0) {
                                    //회원권한별
                                    if ($add_user['cose_add_level_use'] == 1 ){
                                        if($add_user['cose_add_level_9_type'] == '+' ){$cart_price = $it['it_price'] + $level9;}else if($add_user['cose_add_level_9_type'] == '-' ){$cart_price = $it['it_price'] - $level9;}
                                    } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                }
                            }
                        }
                        //10등급
                        else if ($member['mb_level'] == 10){$cart_price = $it['it_price'];}
                    }
                    //아이템별 미적용시
                    else if (sql_num_rows($result_add_item) == 0) {
                        //제외아이템
                        if (in_array($it['it_id'], $add_except_it_array)){$cart_price = $it['it_price'];}
                        //제외카테고리
                        else if (in_array($it['ca_id'], $add_except_cat_array) or in_array($it['ca_id2'], $add_except_cat_array) or in_array($it['ca_id3'], $add_except_cat_array)){$cart_price = $it['it_price'];}
                        //카테고리별 적용시
                        else if (sql_num_rows($result_add_cat) > 0) {
                            for($i=0; $row_add_cat = sql_fetch_array($result_add_cat); $i++){
                                if($it['ca_id'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id2'] == $row_add_cat['cose_cat_add_cat_id'] or $it['ca_id3'] == $row_add_cat['cose_cat_add_cat_id']){
                                    if($row_add_cat['cose_cat_add_set_price_type'] == '+' ){$cart_price = $it['it_price'] + $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                    else if($row_add_cat['cose_cat_add_set_price_type'] == '-' ){$cart_price = $it['it_price'] - $it['it_price'] * ($row_add_cat['cose_cat_add_set_price'] / 100);}
                                    break;
                                } else {
                                    //회원권한별
                                    if ($add_user['cose_add_level_use'] == 1 ){
                                        if ($member['mb_level'] == 1){if($add_user['cose_add_level_1_type'] == '+' or $add_user['cose_add_level_1_type'] == ''){$cart_price = $it['it_price'] + $level1;}else if($add_user['cose_add_level_1_type'] == '-' ){$cart_price = $it['it_price'] - $level1;}}
                                        else if ($member['mb_level'] == 2){if($add_user['cose_add_level_2_type'] == '+' ){$cart_price = $it['it_price'] + $level2;}else if($add_user['cose_add_level_2_type'] == '-' ){$cart_price = $it['it_price'] - $level2;}}
                                        else if ($member['mb_level'] == 3){if($add_user['cose_add_level_3_type'] == '+' ){$cart_price = $it['it_price'] + $level3;}else if($add_user['cose_add_level_3_type'] == '-' ){$cart_price = $it['it_price'] - $level3;}}
                                        else if ($member['mb_level'] == 4){if($add_user['cose_add_level_4_type'] == '+' ){$cart_price = $it['it_price'] + $level4;}else if($add_user['cose_add_level_4_type'] == '-' ){$cart_price = $it['it_price'] - $level4;}}
                                        else if ($member['mb_level'] == 5){if($add_user['cose_add_level_5_type'] == '+' ){$cart_price = $it['it_price'] + $level5;}else if($add_user['cose_add_level_5_type'] == '-' ){$cart_price = $it['it_price'] - $level5;}}
                                        else if ($member['mb_level'] == 6){if($add_user['cose_add_level_6_type'] == '+' ){$cart_price = $it['it_price'] + $level6;}else if($add_user['cose_add_level_6_type'] == '-' ){$cart_price = $it['it_price'] - $level6;}}
                                        else if ($member['mb_level'] == 7){if($add_user['cose_add_level_7_type'] == '+' ){$cart_price = $it['it_price'] + $level7;}else if($add_user['cose_add_level_7_type'] == '-' ){$cart_price = $it['it_price'] - $level7;}}
                                        else if ($member['mb_level'] == 8){if($add_user['cose_add_level_8_type'] == '+' ){$cart_price = $it['it_price'] + $level8;}else if($add_user['cose_add_level_8_type'] == '-' ){$cart_price = $it['it_price'] - $level8;}}
                                        else if ($member['mb_level'] == 9){if($add_user['cose_add_level_9_type'] == '+' ){$cart_price = $it['it_price'] + $level9;}else if($add_user['cose_add_level_9_type'] == '-' ){$cart_price = $it['it_price'] - $level9;}}
                                        else if ($member['mb_level'] == 10){$cart_price = $it['it_price'];}
                                    } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                                }
                            }
                        }
                        //카테고리별 미적용시
                        else if (sql_num_rows($result_add_cat) == 0) {
                            //회원권한별
                            if ($add_user['cose_add_level_use'] == 1 ){
                                if ($member['mb_level'] == 1){if($add_user['cose_add_level_1_type'] == '+' or $add_user['cose_add_level_1_type'] == ''){$cart_price = $it['it_price'] + $level1;}else if($add_user['cose_add_level_1_type'] == '-' ){$cart_price = $it['it_price'] - $level1;}}
                                else if ($member['mb_level'] == 2){if($add_user['cose_add_level_2_type'] == '+' ){$cart_price = $it['it_price'] + $level2;}else if($add_user['cose_add_level_2_type'] == '-' ){$cart_price = $it['it_price'] - $level2;}}
                                else if ($member['mb_level'] == 3){if($add_user['cose_add_level_3_type'] == '+' ){$cart_price = $it['it_price'] + $level3;}else if($add_user['cose_add_level_3_type'] == '-' ){$cart_price = $it['it_price'] - $level3;}}
                                else if ($member['mb_level'] == 4){if($add_user['cose_add_level_4_type'] == '+' ){$cart_price = $it['it_price'] + $level4;}else if($add_user['cose_add_level_4_type'] == '-' ){$cart_price = $it['it_price'] - $level4;}}
                                else if ($member['mb_level'] == 5){if($add_user['cose_add_level_5_type'] == '+' ){$cart_price = $it['it_price'] + $level5;}else if($add_user['cose_add_level_5_type'] == '-' ){$cart_price = $it['it_price'] - $level5;}}
                                else if ($member['mb_level'] == 6){if($add_user['cose_add_level_6_type'] == '+' ){$cart_price = $it['it_price'] + $level6;}else if($add_user['cose_add_level_6_type'] == '-' ){$cart_price = $it['it_price'] - $level6;}}
                                else if ($member['mb_level'] == 7){if($add_user['cose_add_level_7_type'] == '+' ){$cart_price = $it['it_price'] + $level7;}else if($add_user['cose_add_level_7_type'] == '-' ){$cart_price = $it['it_price'] - $level7;}}
                                else if ($member['mb_level'] == 8){if($add_user['cose_add_level_8_type'] == '+' ){$cart_price = $it['it_price'] + $level8;}else if($add_user['cose_add_level_8_type'] == '-' ){$cart_price = $it['it_price'] - $level8;}}
                                else if ($member['mb_level'] == 9){if($add_user['cose_add_level_9_type'] == '+' ){$cart_price = $it['it_price'] + $level9;}else if($add_user['cose_add_level_9_type'] == '-' ){$cart_price = $it['it_price'] - $level9;}}
                                else if ($member['mb_level'] == 10){$cart_price = $it['it_price'];}
                            } else if ($add_user['cose_add_level_use'] == 0 ){$cart_price = $it['it_price'];}
                        }
                    }
                    //comcose_edit_2017.05.08 금액조정 끝
            }

            // 동일옵션의 상품이 있으면 수량 더함
            $sql2 = " select ct_id, io_type, ct_qty
                        from {$g5['g5_shop_cart_table']}
                        where od_id = '$tmp_cart_id'
                          and it_id = '$it_id'
                          and io_id = '$io_id'
                          and ct_status = '쇼핑' ";
            $row2 = sql_fetch($sql2);
            if($row2['ct_id']) {
                // 재고체크
                $tmp_ct_qty = $row2['ct_qty'];
                if(!$io_id)
                    $tmp_it_stock_qty = get_it_stock_qty($it_id);
                else
                    $tmp_it_stock_qty = get_option_stock_qty($it_id, $io_id, $row2['io_type']);

                if ($tmp_ct_qty + $ct_qty > $tmp_it_stock_qty)
                {
                    alert($io_value." 의 재고수량이 부족합니다.\\n\\n현재 재고수량 : " . number_format($tmp_it_stock_qty) . " 개");
                }

                $sql3 = " update {$g5['g5_shop_cart_table']}
                            set ct_qty = ct_qty + '$ct_qty'
                            where ct_id = '{$row2['ct_id']}' ";
                sql_query($sql3);
                continue;
            }

            // 포인트
            $point = 0;
            if($config['cf_use_point']) {
                $member_point = 1;
                if($member['mb_level'] == 3) {$member_point = 2;}
                if($member['mb_level'] == 4) {$member_point = 3;}
                if($member['mb_level'] == 5) {$member_point = 5;}

                if($io_type == 0) {
                    if($member['mb_level'] >=2) { // 등급별 포인트
                        //$it['it_point'] = number_format($it['it_point']) + (($member['mb_level']-2)*2);
                        //$it['it_point']  = number_format($it['it_point']) * $member_point;
                    }
                    $point = get_item_point($it, $io_id);
                } else {
                    $point = $it['it_supply_point'];
                }
                //$point_new  = $point * (($member['mb_level']-2)*2);
                $point_new = $point * $member_point;
                if($point_new < 0)
                    $point_new = 0;

                if($point < 0)
                    $point = 0;
            }

            // 배송비결제
            if($it['it_sc_type'] == 1)
                $ct_send_cost = 2; // 무료
            else if($it['it_sc_type'] > 1 && $it['it_sc_method'] == 1)
                $ct_send_cost = 1; // 착불
				
			$io_value = sql_real_escape_string($io_value);
            $remote_addr = get_real_client_ip();
            echo $io_price;
            /*
            $sql .= $comma."( '$tmp_cart_id', '{$member['mb_id']}', '{$it['it_id']}', '".addslashes($it['it_name'])."', '{$it['it_sc_type']}', '{$it['it_sc_method']}', '{$it['it_sc_price']}', '{$it['it_sc_minimum']}', '{$it['it_sc_qty']}', '쇼핑', '{$it['it_price']}', '$point', '0', '0', '$io_value', '$ct_qty', '{$it['it_notax']}', '$io_id', '$io_type', '$io_price', '".G5_TIME_YMDHIS."', '$REMOTE_ADDR', '$ct_send_cost', '$sw_direct', '$ct_select', '$ct_select_time' )";
            */

            //comcose_edit_2017.04.26 할인금액 적용으로 {$it['it_price']} -> $cart_price 수정 시작
            $sql .= $comma."( '$tmp_cart_id', '{$member['mb_id']}', '{$it['it_id']}', '".addslashes($it['it_name'])."', '{$it['it_sc_type']}', '{$it['it_sc_method']}', '{$it['it_sc_price']}', '{$it['it_sc_minimum']}', '{$it['it_sc_qty']}', '쇼핑', '$cart_price', '$point_new', '0', '0', '$io_value', '$ct_qty', '{$it['it_notax']}', '$io_id', '$io_type', '$io_price', '".G5_TIME_YMDHIS."', '$REMOTE_ADDR', '$ct_send_cost', '$sw_direct', '$ct_select', '$ct_select_time' )";
            //comcose_edit_2017.04.26 할인금액 적용으로 {$it['it_price']} -> $cart_price 수정 끝
            $comma = ' , ';
            $ct_count++;
        }

        if($ct_count > 0)
            sql_query($sql);
    }
}

?>



<?php

// 바로 구매일 경우
if ($sw_direct)
{
    if ($is_member)
    {
    	goto_url(G5_SHOP_URL."/orderform.php?sw_direct=$sw_direct");
    }
    else
    {
    	goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL."/orderform.php?sw_direct=$sw_direct"));
    }
}
else
{
    goto_url(G5_SHOP_URL.'/cart.php');
}
?>
