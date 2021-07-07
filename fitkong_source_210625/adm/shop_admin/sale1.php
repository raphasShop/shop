<?php
$sub_menu = '415100'; /* 원본메뉴코드 500110 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '매출현황';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
##################################################
// [취소신청] 취소진행중 표시 - 반품/환불/교환 신청 및 진행중 표시 [아이스크림소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_ordercancle.php');
##################################################
###############################################################################################
/* 결제수단별 합계 [크림장수소스]*/
###############################################################################################
// 일자별 결제수단 주문 합계 금액
function get_order_settle_sum($date)
{
    global $g5, $default;

    $case = array('신용카드', '계좌이체', '가상계좌', '무통장', '휴대폰','네이버페이');
    $info = array();

    // 결제수단별 합계
    foreach($case as $val)
    {
        $sql = " select sum(od_cart_price + od_send_cost + od_send_cost2 - od_receipt_point - od_cart_coupon - od_coupon - od_send_coupon) as price,
                        count(*) as cnt
                    from {$g5['g5_shop_order_table']}
                    where SUBSTRING(od_time, 1, 10) = '$date'
                      and od_settle_case = '$val' ";
        $row = sql_fetch($sql);

        $info[$val]['price'] = (int)$row['price'];
        $info[$val]['count'] = (int)$row['cnt'];
    }

    // 포인트 합계
    $sql = " select sum(od_receipt_point) as price,
                    count(*) as cnt
                from {$g5['g5_shop_order_table']}
                where SUBSTRING(od_time, 1, 10) = '$date'
                  and od_receipt_point > 0 ";
    $row = sql_fetch($sql);
    $info['포인트']['price'] = (int)$row['price'];
    $info['포인트']['count'] = (int)$row['cnt'];

    // 쿠폰 합계
    $sql = " select sum(od_cart_coupon + od_coupon + od_send_coupon) as price,
                    count(*) as cnt
                from {$g5['g5_shop_order_table']}
                where SUBSTRING(od_time, 1, 10) = '$date'
                  and ( od_cart_coupon > 0 or od_coupon > 0 or od_send_coupon > 0 ) ";
    $row = sql_fetch($sql);
    $info['쿠폰']['price'] = (int)$row['price'];
    $info['쿠폰']['count'] = (int)$row['cnt'];

    return $info;
}
###############################################################################################
/* 주문 그래프 [크림장수소스]*/
###############################################################################################
function get_max_value($arr)
{
    foreach($arr as $key => $val)
    {
        if(is_array($val))
        {
            $arr[$key] = get_max_value($val);
        }
    }

    sort($arr);

    return array_pop($arr);
}
// 일자별 주문 합계 금액
function get_order_date_sum($date)
{
    global $g5;

    $sql = " select sum(od_cart_price + od_send_cost + od_send_cost2) as orderprice,
                    sum(od_cancel_price) as cancelprice
                from {$g5['g5_shop_order_table']}
                where SUBSTRING(od_time, 1, 10) = '$date' ";
    $row = sql_fetch($sql);

    $info = array();
    $info['order'] = (int)$row['orderprice'];
    $info['cancel'] = (int)$row['cancelprice'];

    return $info;
}

#######################################################################################
/* 종류별 전체 주문합계 표시 [크림장수소스] */
// admin.sum_order.php에 추가하면 모든페이지에서 데이타를 불러오기위한 과부하가 예상되어
// 따로 매출관리페이지에만 표시함 [전체/PC/모바일 등]
#######################################################################################

// 전체 주문 건수/금액(상태와 상관없이 전체주문)
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} ";
    $row = sql_fetch($sql);
    $info_all = array();
    $info_all['count'] = (int)$row['cnt'];
    $info_all['price'] = (int)$row['price'];
    $info_all['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';

// PC 주문 전체 건수/금액
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_mobile != '1' ";
    $row = sql_fetch($sql);
    $info_pc = array();
    $info_pc['count'] = (int)$row['cnt'];
    $info_pc['price'] = (int)$row['price'];
    $info_pc['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_mobile=PC';

// MOBILE 주문 전체 건수/금액
    $sql = " select count(*) as cnt, sum(od_cart_price + od_send_cost + od_send_cost2 - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_mobile = '1' ";
    $row = sql_fetch($sql);
    $info_mobile = array();
    $info_mobile['count'] = (int)$row['cnt'];
    $info_mobile['price'] = (int)$row['price'];
    $info_mobile['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_mobile=모바일';

################################################
/* 매출관리 메인페이지에서만 추출하는 데이터 */
// admin.sum_order.php에 추가하면 모든페이지에서 데이타를 불러오기위한 과부하가 예상되어
// 따로 매출관리페이지에만 표시함
################################################
// 전체 매출 건수/금액(상태와 상관없이 전체주문)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_cancel_price) as price from {$g5['g5_shop_order_table']} ";
    $row = sql_fetch($sql);
    $info_saleonly = array();
    $info_saleonly['count'] = (int)$row['cnt'];
    $info_saleonly['price'] = (int)$row['price'];
    $info_saleonly['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';

// PC 매출 건수/금액(상태와 상관없이 전체주문)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_mobile != '1' ";
    $row = sql_fetch($sql);
    $info_saleonly_pc = array();
    $info_saleonly_pc['count'] = (int)$row['cnt'];
    $info_saleonly_pc['price'] = (int)$row['price'];
    $info_saleonly_pc['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';

// 모바일 매출 건수/금액(상태와 상관없이 전체주문)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_mobile = '1' ";
    $row = sql_fetch($sql);
    $info_saleonly_mobile = array();
    $info_saleonly_mobile['count'] = (int)$row['cnt'];
    $info_saleonly_mobile['price'] = (int)$row['price'];
    $info_saleonly_mobile['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';

################################################
/* 입금관리 메인페이지에서만 추출하는 데이터 */
// admin.sum_order.php에 추가하면 모든페이지에서 데이타를 불러오기위한 과부하가 예상되어
// 따로 입금관리페이지에만 표시함
################################################
// 전체 입금 건수/금액(상태와 상관없이 전체주문)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_refund_price) as price from {$g5['g5_shop_order_table']} ";
    $row = sql_fetch($sql);
    $info_receiptonly = array();
    $info_receiptonly['count'] = (int)$row['cnt'];
    $info_receiptonly['price'] = (int)$row['price'];
    $info_receiptonly['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';

// PC 입금 건수/금액(상태와 상관없이 전체주문)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_refund_price) as price from {$g5['g5_shop_order_table']} where od_mobile != '1' ";
    $row = sql_fetch($sql);
    $info_receiptonly_pc = array();
    $info_receiptonly_pc['count'] = (int)$row['cnt'];
    $info_receiptonly_pc['price'] = (int)$row['price'];
    $info_receiptonly_pc['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';

// 모바일 입금 건수/금액(상태와 상관없이 전체주문)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_refund_price) as price from {$g5['g5_shop_order_table']} where od_mobile = '1' ";
    $row = sql_fetch($sql);
    $info_receiptonly_mobile = array();
    $info_receiptonly_mobile['count'] = (int)$row['cnt'];
    $info_receiptonly_mobile['price'] = (int)$row['price'];
    $info_receiptonly_mobile['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';

################################################
/* 취소관리 메인페이지에서만 추출하는 데이터 */
// admin.sum_order.php에 추가하면 모든페이지에서 데이타를 불러오기위한 과부하가 예상되어
// 따로 취소관리페이지에만 표시함
################################################
// 전체 취소환불 건수/금액(상태와 상관없이 전체주문)
    $sql = " select count(*) as cnt, sum(od_cancel_price) as price from {$g5['g5_shop_order_table']} where ( (od_status = '취소') OR (od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0) ) ";
    $row = sql_fetch($sql);
    $info_cancleonly = array();
    $info_cancleonly['count'] = (int)$row['cnt'];
    $info_cancleonly['price'] = (int)$row['price'];
    $info_cancleonly['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';

// PC 취소환불 건수/금액(상태와 상관없이 전체주문)
    $sql = " select count(*) as cnt, sum(od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_mobile != '1' and ( (od_status = '취소') OR (od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0) ) ";
    $row = sql_fetch($sql);
    $info_cancleonly_pc = array();
    $info_cancleonly_pc['count'] = (int)$row['cnt'];
    $info_cancleonly_pc['price'] = (int)$row['price'];
    $info_cancleonly_pc['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';

// 모바일 취소환불 건수/금액(상태와 상관없이 전체주문)
    $sql = " select count(*) as cnt, sum(od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_mobile = '1' and ( (od_status = '취소') OR (od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0) ) ";
    $row = sql_fetch($sql);
    $info_cancleonly_mobile = array();
    $info_cancleonly_mobile['count'] = (int)$row['cnt'];
    $info_cancleonly_mobile['price'] = (int)$row['price'];
    $info_cancleonly_mobile['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php';
?>
<div class="h10"></div>

<section>
<h5><i class="fa fa-calculator"></i> 전체매출요약</h5>
<!-- [표]전체주문데이터 시작 { -->
<div class="tbl_orderboard1">
  <table>
      <thead>
          <tr>
              <th colspan="1" style="width:120px;height:45px;">
                  구분
              </th>
              <th colspan="1" style="background:#1C252F;">
                  전체주문
              </th>
              <th colspan="1" style="background:#1C252F;">
                  전체매출
              </th>
              <th colspan="1" style="background:#1C252F;">
                  전체입금(결제)
              </th>
              <th colspan="1" style="background:#1C252F;">
                  전체취소/환불
              </th>
          </tr>
      </thead>
      <tbody>
          <!-- 전체 -->
          <tr style="height:40px;">
              <th>전체</th>
              <td class="td_scorebasic">
				  <?php echo ($info_all['price'] > 0) ? '<span class="violet font-bold">￦'.number_format($info_all['price']).'</span>' : '<b style="color:#eaeaea;">O</b>';?>
                  <?php echo ($info_all['count'] > 0) ? '<span class="gray">('.number_format($info_all['count']).'</span>)' : '';?>
              </td>
              <td class="td_scorebasic">
				  <?php echo ($info_saleonly['price'] > 0) ? '<span class="violet font-bold">￦'.number_format($info_saleonly['price']).'</span>' : '<b style="color:#eaeaea;">O</b>';?>
                  <?php echo ($info_saleonly['count'] > 0) ? '<span class="gray">('.number_format($info_saleonly['count']).'</span>)' : '';?>
              </td>
              <td class="td_scorebasic">
				  <?php echo ($info_receiptonly['price'] > 0) ? '<span class="violet font-bold">￦'.number_format($info_receiptonly['price']).'</span>' : '<b style="color:#eaeaea;">O</b>';?>
                  <?php echo ($info_receiptonly['count'] > 0) ? '<span class="gray">('.number_format($info_receiptonly['count']).'</span>)' : '';?>
              </td>
              <td class="td_scorebasic">
				  <?php echo ($info_cancleonly['price'] > 0) ? '<span class="violet font-bold">￦'.number_format($info_cancleonly['price']).'</span>' : '<b style="color:#eaeaea;">O</b>';?>
                  <?php echo ($info_cancleonly['count'] > 0) ? '<span class="gray">('.number_format($info_cancleonly['count']).'</span>)' : '';?>
              </td>
          </tr>
          <!-- PC -->
          <tr style="height:40px;">
              <th style="background:#8ED34A;">PC</th>
              <td class="td_scorebasic">
				  <?php echo ($info_pc['price'] > 0) ? number_format($info_pc['price']) : '<b style="color:#eaeaea;">O</b>';?>
                  <?php echo ($info_pc['count'] > 0) ? '<span class="gray">('.number_format($info_pc['count']).'</span>)' : '';?> 
                  <?php //PC 주문율 계산
				  if($info_pc['price'] > 0) {
				      $pc_percent = ($info_pc['price'] / $info_all['price']) * 100;
				  } else {
				      $pc_percent = '0';
				  }
				  ?>
                  <span class="round_cnt_lightgray"><b><?php echo sprintf("%.1f",$pc_percent);//PC구매율?></b>%</span>
              </td>
              <td class="td_scorebasic">
				  <?php echo ($info_saleonly_pc['price'] > 0) ? number_format($info_saleonly_pc['price']) : '<b style="color:#eaeaea;">O</b>';?>
                  <?php //PC 매출율 계산
				  if($info_saleonly_pc['price'] > 0) {
				      $pc_saleonly_percent = ($info_saleonly_pc['price'] / $info_saleonly['price']) * 100;
				  } else {
				      $pc_saleonly_percent = '0';
				  }
				  ?>
                  <span class="round_cnt_lightgray"><b><?php echo sprintf("%.1f",$pc_saleonly_percent);//PC구매율?></b>%</span>
         
              </td>
              <td class="td_scorebasic">
				  <?php echo ($info_receiptonly_pc['price'] > 0) ? number_format($info_receiptonly_pc['price']) : '<b style="color:#eaeaea;">O</b>';?>
                  <?php //PC 입금율 계산
				  if($info_receiptonly_pc['price'] > 0) {
				      $pc_receiptonly_percent = ($info_receiptonly_pc['price'] / $info_receiptonly['price']) * 100;
				  } else {
				      $pc_receiptonly_percent = '0';
				  }
				  ?>
                  <span class="round_cnt_lightgray"><b><?php echo sprintf("%.1f",$pc_receiptonly_percent);//PC구매율?></b>%</span>
              </td>
              <td class="td_scorebasic">
				  <?php echo ($info_cancleonly_pc['price'] > 0) ? number_format($info_cancleonly_pc['price']) : '<b style="color:#eaeaea;">O</b>';?>
                  <?php //PC 취소율 계산
				  if($info_cancleonly_pc['price'] > 0) {
				      $pc_cancleonly_percent = ($info_cancleonly_pc['price'] / $info_cancleonly['price']) * 100;
				  } else {
				      $pc_cancleonly_percent = '0';
				  }
				  ?>
                  <span class="round_cnt_lightgray"><b><?php echo sprintf("%.1f",$pc_cancleonly_percent);//PC구매율?></b>%</span>
              </td>
          </tr>
          <!-- 모바일 -->
          <tr style="height:40px;">
              <th style="background:#8ED34A;">모바일</th>
              <td class="td_scorebasic">
				  <?php echo ($info_mobile['price'] > 0) ? number_format($info_mobile['price']) : '<b style="color:#eaeaea;">O</b>';?>
                  <?php echo ($info_mobile['count'] > 0) ? '<span class="gray">('.number_format($info_mobile['count']).'</span>)' : '';?>
                  <?php //모바일 주문율 계산
				  if($info_mobile['price'] > 0) {
				      $mobile_percent = ($info_mobile['price'] / $info_all['price']) * 100;
				  } else {
				      $mobile_percent = '0';
				  }
				  ?>
                  <span class="round_cnt_lightgray"><b><?php echo sprintf("%.1f",$mobile_percent);//모바일구매율?></b>%</span>
              </td>
              <td class="td_scorebasic">
				  <?php echo ($info_saleonly_mobile['price'] > 0) ? number_format($info_saleonly_mobile['price']) : '<b style="color:#eaeaea;">O</b>';?>
                  <?php //모바일 매출율 계산
				  if($info_saleonly_mobile['price'] > 0) {
				      $mobile_saleonly_percent = ($info_saleonly_mobile['price'] / $info_saleonly['price']) * 100;
				  } else {
				      $mobile_saleonly_percent = '0';
				  }
				  ?>
                  <span class="round_cnt_lightgray"><b><?php echo sprintf("%.1f",$mobile_saleonly_percent);//모바일구매율?></b>%</span>
              </td>
              <td class="td_scorebasic">
				  <?php echo ($info_receiptonly_mobile['price'] > 0) ? number_format($info_receiptonly_mobile['price']) : '<b style="color:#eaeaea;">O</b>';?>
                  <?php //모바일 입금율 계산
				  if($info_receiptonly_mobile['price'] > 0) {
				      $mobile_receiptonly_percent = ($info_receiptonly_mobile['price'] / $info_receiptonly['price']) * 100;
				  } else {
				      $mobile_receiptonly_percent = '0';
				  }
				  ?>
                  <span class="round_cnt_lightgray"><b><?php echo sprintf("%.1f",$mobile_receiptonly_percent);//모바일구매율?></b>%</span>
              </td>
              <td class="td_scorebasic">
				  <?php echo ($info_cancleonly_mobile['price'] > 0) ? number_format($info_cancleonly_mobile['price']) : '<b style="color:#eaeaea;">O</b>';?>
                  <?php //모바일 취소율 계산
				  if($info_cancleonly_mobile['price'] > 0) {
				      $mobile_cancleonly_percent = ($info_cancleonly_mobile['price'] / $info_cancleonly['price']) * 100;
				  } else {
				      $mobile_cancleonly_percent = '0';
				  }
				  ?>
                  <span class="round_cnt_lightgray"><b><?php echo sprintf("%.1f",$mobile_cancleonly_percent);//모바일구매율?></b>%</span>
              </td>
          </tr>
      </tbody>
  </table>
</div>
<!-- [표]전체주문데이터 끝 { -->
<div class="h10"></div>
</section>

<section>
<h5><i class="fa fa-bar-chart"></i> 최근매출현황비교</h5>
    <?php include_once (G5_ADMIN_PATH.'/shop_admin/sale1.include.php');//매출현황요약표?>
</section>  

<section>
<h5><i class="fa fa-line-chart"></i> 종류별 매출분석표 바로가기</h5>
<!-- 매출표 바로가기 시작 -->
<div class="local_sch02 local_sch" style="border:solid 5px #888; background:#fff; padding:10px 25px 10px;">
 
    <!-- 입금현황 -->
    <div style="display:block; width:100%; padding:7px 0px 7px; margin:0; border-bottom:solid 1px #eee;">
        <form name="frm_receipt_date" action="./sale1receiptdate.php" class="big_sch02 big_sch" method="get">
        <strong>일별 입금 현황</strong>
        <input type="text" name="fr_receipt_date" value="<?php echo date("Y-m-01", G5_SERVER_TIME); ?>" id="fr_receipt_date" required class="frm_input" size="10" maxlength="10" style="width:80px;">
        ~
        <input type="text" name="to_receipt_date" value="<?php echo date("Y-m-d", G5_SERVER_TIME); ?>" id="to_receipt_date" required class="frm_input" size="10" maxlength="10" style="width:80px;">
        <input type="submit" value="검색" class="btn_submit">&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" onclick="javascript:set_receipt_date('이번주');">이번주</button>
        <button type="button" style="background:#FDED80; border:solid 1px #AAAAAA;" onclick="javascript:set_receipt_date('이번달');">이번달</button>
        <button type="button" onclick="javascript:set_receipt_date('지난주');">지난주</button>
        <button type="button" onclick="javascript:set_receipt_date('지난달');">지난달</button>
        <button type="button" onclick="javascript:set_receipt_date('1주일');">1주일</button>
        <button type="button" onclick="javascript:set_receipt_date('1개월');">1개월</button>
        <button type="button" onclick="javascript:set_receipt_date('3개월');">3개월</button>
        <button type="button" onclick="javascript:set_receipt_date('6개월');">6개월</button>
        <button type="button" onclick="javascript:set_receipt_date('1년');">1년</button>
        <button type="button" onclick="javascript:set_receipt_date('초기화');"><i class="fa fa-refresh" aria-hidden="true"></i> 초기화</button>
        </form>
    </div>
    
    <div style="display:block; width:100%; padding:7px 0px 7px; margin:0; border-bottom:solid 1px #eee;">
        <form name="frm_receipt_month" action="./sale1receiptmonth.php" class="big_sch02 big_sch" method="get">
        <strong>월별 입금 현황</strong>
        <input type="text" name="fr_receipt_month" value="<?php echo date("Y01", G5_SERVER_TIME); ?>" id="fr_receipt_month" required class="required frm_input" size="7" maxlength="7" style="width:60px;">
        <label for="fr_receipt_month">월 ~</label>
        <input type="text" name="to_receipt_month" value="<?php echo date("Ym", G5_SERVER_TIME); ?>" id="to_receipt_month" required class="required frm_input" size="7" maxlength="7" style="width:60px;">
        <label for="to_receipt_month">월</label>
        <input type="submit" value="검색" class="btn_submit">&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" style="background:#FDED80; border:solid 1px #AAAAAA;" onclick="javascript:set_receipt_month('올해');"><?php echo date('Y', G5_SERVER_TIME); ?> 년도(올해)</button>
        <button type="button" onclick="javascript:set_receipt_month('작년');"><?php echo date('Y', strtotime('-1 year', G5_SERVER_TIME)); ?> 년도</button>
        <button type="button" onclick="javascript:set_receipt_month('재작년');"><?php echo date('Y', strtotime('-2 year', G5_SERVER_TIME)); ?> 년도</button>
        <button type="button" onclick="javascript:set_receipt_month('재재작년');"><?php echo date('Y', strtotime('-3 year', G5_SERVER_TIME)); ?> 년도</button>
        &nbsp;
        <button type="button" onclick="javascript:set_receipt_month('1년');">1 년</button>
        <button type="button" onclick="javascript:set_receipt_month('2년');">2 년</button>
        <button type="button" onclick="javascript:set_receipt_month('3년');">3 년</button>
        <button type="button" onclick="javascript:set_receipt_month('5년');">5 년</button>
        <button type="button" onclick="javascript:set_receipt_month('10년');">10 년</button>
        <button type="button" onclick="javascript:set_receipt_month('초기화');"><i class="fa fa-refresh" aria-hidden="true"></i> 초기화</button>
        </form>
    </div>
    
    <div style="display:block; width:100%; padding:7px 0px 7px; margin:0; border-bottom: dashed 1px #7EDCD5;">
        <form name="frm_receipt_today" action="./sale1receipttoday.php" class="big_sch02 big_sch" method="get">

        <strong>일일 입금 현황</strong>
        <input type="text" name="receipt_date" value="<?php echo date("Y-m-d", G5_SERVER_TIME); ?>" id="receipt_date" required class="required frm_input" size="10" maxlength="10" style="width:80px;">
        <label for="receipt_date">일 하루</label>
        <input type="submit" value="검색" class="btn_submit">&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" style="background:#FDED80; border:solid 1px #AAAAAA;" onclick="javascript:set_receipt_today('오늘');">오늘</button>
        <button type="button" onclick="javascript:set_receipt_today('어제');"><?php echo date('m-d', strtotime('-1 day', G5_SERVER_TIME)); ?></button>
        <button type="button" onclick="javascript:set_receipt_today('이일전');"><?php echo date('m-d', strtotime('-2 day', G5_SERVER_TIME)); ?></button>
        <button type="button" onclick="javascript:set_receipt_today('삼일전');"><?php echo date('m-d', strtotime('-3 day', G5_SERVER_TIME)); ?></button>
        <button type="button" onclick="javascript:set_receipt_today('사일전');"><?php echo date('m-d', strtotime('-4 day', G5_SERVER_TIME)); ?></button>
        <button type="button" onclick="javascript:set_receipt_today('오일전');"><?php echo date('m-d', strtotime('-5 day', G5_SERVER_TIME)); ?></button>
        <button type="button" onclick="javascript:set_receipt_today('육일전');"><?php echo date('m-d', strtotime('-6 day', G5_SERVER_TIME)); ?></button>
        <button type="button" onclick="javascript:set_receipt_today('칠일전');"><?php echo date('m-d', strtotime('-7 day', G5_SERVER_TIME)); ?></button>
        <button type="button" onclick="javascript:set_receipt_today('초기화');"><i class="fa fa-refresh" aria-hidden="true"></i> 초기화</button>
        </form>
    </div>
    <!--//-->
    
    <!-- 매출현황 -->
    <div style="display:block; width:100%; padding:7px 0px 7px; margin:0; border-bottom:solid 1px #eee;">
        <form name="frm_sale_date" action="./sale1date.php" class="big_sch02 big_sch" method="get">
        <strong>일별 매출 현황</strong>
        <input type="text" name="fr_date" value="<?php echo date("Y-m-01", G5_SERVER_TIME); ?>" id="fr_date" required class="frm_input" size="10" maxlength="10" style="width:80px;">
        ~
        <input type="text" name="to_date" value="<?php echo date("Y-m-d", G5_SERVER_TIME); ?>" id="to_date" required class="frm_input" size="10" maxlength="10" style="width:80px;">
        <input type="submit" value="검색" class="btn_submit">&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" onclick="javascript:set_date('이번주');">이번주</button>
        <button type="button" style="background:#FDED80; border:solid 1px #AAAAAA;" onclick="javascript:set_date('이번달');">이번달</button>
        <button type="button" onclick="javascript:set_date('지난주');">지난주</button>
        <button type="button" onclick="javascript:set_date('지난달');">지난달</button>
        <button type="button" onclick="javascript:set_date('1주일');">1주일</button>
        <button type="button" onclick="javascript:set_date('1개월');">1개월</button>
        <button type="button" onclick="javascript:set_date('3개월');">3개월</button>
        <button type="button" onclick="javascript:set_date('6개월');">6개월</button>
        <button type="button" onclick="javascript:set_date('1년');">1년</button>
        <button type="button" onclick="javascript:set_date('초기화');"><i class="fa fa-refresh" aria-hidden="true"></i> 초기화</button>
        </form>
    </div>
    
    <div style="display:block; width:100%; padding:7px 0px 7px; margin:0; border-bottom:solid 1px #eee;">
        <form name="frm_sale_month" action="./sale1month.php" class="big_sch02 big_sch" method="get">
        <strong>월별 매출 현황</strong>
        <input type="text" name="fr_month" value="<?php echo date("Y01", G5_SERVER_TIME); ?>" id="fr_month" required class="required frm_input" size="7" maxlength="7" style="width:60px;">
        <label for="fr_month">월 ~</label>
        <input type="text" name="to_month" value="<?php echo date("Ym", G5_SERVER_TIME); ?>" id="to_month" required class="required frm_input" size="7" maxlength="7" style="width:60px;">
        <label for="to_month">월</label>
        <input type="submit" value="검색" class="btn_submit">&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" style="background:#FDED80; border:solid 1px #AAAAAA;" onclick="javascript:set_month('올해');"><?php echo date('Y', G5_SERVER_TIME); ?> 년도(올해)</button>
        <button type="button" onclick="javascript:set_month('작년');"><?php echo date('Y', strtotime('-1 year', G5_SERVER_TIME)); ?> 년도</button>
        <button type="button" onclick="javascript:set_month('재작년');"><?php echo date('Y', strtotime('-2 year', G5_SERVER_TIME)); ?> 년도</button>
        <button type="button" onclick="javascript:set_month('재재작년');"><?php echo date('Y', strtotime('-3 year', G5_SERVER_TIME)); ?> 년도</button>
        &nbsp;
        <button type="button" onclick="javascript:set_month('1년');">1 년</button>
        <button type="button" onclick="javascript:set_month('2년');">2 년</button>
        <button type="button" onclick="javascript:set_month('3년');">3 년</button>
        <button type="button" onclick="javascript:set_month('5년');">5 년</button>
        <button type="button" onclick="javascript:set_month('10년');">10 년</button>
        <button type="button" onclick="javascript:set_month('초기화');"><i class="fa fa-refresh" aria-hidden="true"></i> 초기화</button>
        </form>
    </div>
    
    <div style="display:block; width:100%; padding:7px 0px 7px; margin:0; border-bottom:solid 1px #eee;">
        <form name="frm_sale_today" action="./sale1today.php" class="big_sch02 big_sch" method="get">
        <strong>일일 매출 현황</strong>
        <input type="text" name="date" value="<?php echo date("Y-m-d", G5_SERVER_TIME); ?>" id="date" required class="required frm_input" size="10" maxlength="10" style="width:80px;">
        <label for="date">일 하루</label>
        <input type="submit" value="검색" class="btn_submit">&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" style="background:#FDED80; border:solid 1px #AAAAAA;" onclick="javascript:set_today('오늘');">오늘</button>
        <button type="button" onclick="javascript:set_today('어제');"><?php echo date('m-d', strtotime('-1 day', G5_SERVER_TIME)); ?></button>
        <button type="button" onclick="javascript:set_today('이일전');"><?php echo date('m-d', strtotime('-2 day', G5_SERVER_TIME)); ?></button>
        <button type="button" onclick="javascript:set_today('삼일전');"><?php echo date('m-d', strtotime('-3 day', G5_SERVER_TIME)); ?></button>
        <button type="button" onclick="javascript:set_today('사일전');"><?php echo date('m-d', strtotime('-4 day', G5_SERVER_TIME)); ?></button>
        <button type="button" onclick="javascript:set_today('오일전');"><?php echo date('m-d', strtotime('-5 day', G5_SERVER_TIME)); ?></button>
        <button type="button" onclick="javascript:set_today('육일전');"><?php echo date('m-d', strtotime('-6 day', G5_SERVER_TIME)); ?></button>
        <button type="button" onclick="javascript:set_today('칠일전');"><?php echo date('m-d', strtotime('-7 day', G5_SERVER_TIME)); ?></button>
        <button type="button" onclick="javascript:set_today('초기화');"><i class="fa fa-refresh" aria-hidden="true"></i> 초기화</button>
        </form>
    </div>
    
    <div style="display:block; width:100%; padding:7px 0px 7px; margin:0; border-bottom:solid 0px #eee;">
        <form name="frm_sale_year" action="./sale1year.php" class="big_sch02 big_sch" method="get">
        <strong>연간 매출 현황</strong>
        <input type="text" name="fr_year" value="<?php echo date("Y", G5_SERVER_TIME)-1; ?>" id="fr_year" required class="required frm_input" size="4" maxlength="4" style="width:40px;">
        년 ~
        <input type="text" name="to_year" value="<?php echo date("Y", G5_SERVER_TIME); ?>" id="to_year" required class="required frm_input" size="4" maxlength="4" style="width:40px;">
        년
        <input type="submit" value="검색" class="btn_submit">
        </form>
    </div>
    <!--//-->

</div>
<!-- 매출표 바로가기 끝 -->
</section>

<section>
<div class="dan-garo-transparent"><!-- 결제 및 기타정보 / 투명배경 -->
    <div class="row"><!-- row 시작 { -->

                <div class="tbl_head02">
                    <h5><i class="fa fa-credit-card"></i> 결제수단별 주문 (최근 일주일)</h5>
                    <table>
                    <thead>
                    <tr align="center">
                        <th scope="col" rowspan="2">구분</th>
                        <?php
                        $term = 7;
                        $info = array();
                        $info_key = array();
                        for($i=($term - 1); $i>=0; $i--) {
                            $date = date("Y-m-d", strtotime('-'.$i.' days', G5_SERVER_TIME));
                            $info[$date] = get_order_settle_sum($date);

                            $day = substr($date, 5, 5).' ('.get_yoil($date).')';
                            $info_key[] = $date;
                        ?>
                        <th scope="col" colspan="2" style="background:#B1B1B1;"><?php echo $day; ?></th>
                        <?php } ?>
                    </tr>
                    <tr align="center">
                        <?php for($i=0; $i<$term; $i++) { ?>
                        <th scope="col">건수</th>
                        <th scope="col">금액</th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $case = array('신용카드', '계좌이체', '가상계좌', '무통장', '휴대폰', '포인트', '쿠폰', '네이버페이');
            
                    foreach($case as $val) {
                        $val_cnt ++;
                    ?>
                    <tr align="center">
                        <th scope="row" id="th_val_<?php echo $val_cnt; ?>" class="th_category"><?php echo $val; ?></th>
                        <?php foreach($info_key as $date) { ?>
                        <td><?php echo number_format($info[$date][$val]['count']); ?></td>
                        <td><?php echo number_format($info[$date][$val]['price']); ?></td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                    </tbody>
                    </table>
                </div>

    </div><!-- } row 끝 -->
</div><!-- 결제 및 기타정보 / 투명배경 -->
<div class="h15"><!--//--></div>
</section>


<script>
$(function() {
    $("#date, #receipt_date, #fr_date, #to_date, #fr_receipt_date, #to_receipt_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        showButtonPanel: true,
        yearRange: "c-99:c+99",
        maxDate: "+0d"
    });
});

/* 매출일별 */
function set_date(today)
{
    <?php
    $date_term = date('w', G5_SERVER_TIME); // 일단위
    $week_term = $date_term + 7; //일주일단위
    $last_term = strtotime(date('Y-m-01', G5_SERVER_TIME)); // 매월1일기준
	$month_term = strtotime(date('Y-m-d', G5_SERVER_TIME)); // 매월 오늘날짜 기준
    ?>
    if (today == "오늘") {
        document.getElementById("fr_date").value = "<?php echo G5_TIME_YMD; ?>";
        document.getElementById("to_date").value = "<?php echo G5_TIME_YMD; ?>";
    } else if (today == "어제") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
    } else if (today == "이번주") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-'.$date_term.' days', G5_SERVER_TIME)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
    } else if (today == "이번달") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-01', G5_SERVER_TIME); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
    } else if (today == "지난주") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-'.$week_term.' days', G5_SERVER_TIME)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', strtotime('-'.($week_term - 6).' days', G5_SERVER_TIME)); ?>";
    } else if (today == "지난달") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-01', strtotime('-1 Month', $last_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-t', strtotime('-1 Month', $last_term)); ?>";    
	} else if (today == "1주일") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-7 days', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "1개월") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-1 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	
	} else if (today == "3개월") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-3 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "6개월") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-6 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "1년") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-12 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "초기화") {
        document.getElementById("fr_date").value = "";
        document.getElementById("to_date").value = "";
    }
}
</script>
<script>
/* 매출월별 */
function set_month(tomonth)
{
    <?php
    $date_term = date('w', G5_SERVER_TIME); // 일단위
    $week_term = $date_term + 7; //일주일단위
    $lastyear_term = strtotime(date('Y-01-01', G5_SERVER_TIME)); // 매년 1월1일기준
	$year_term = strtotime(date('Y-m-01', G5_SERVER_TIME)); // 매년 오늘 월 기준
    ?>
    if (tomonth == "올해") {
        document.getElementById("fr_month").value = "<?php echo date('Y-01', G5_SERVER_TIME); ?>";
        document.getElementById("to_month").value = "<?php echo date('Y-m', G5_SERVER_TIME); ?>";
    } else if (tomonth == "작년") {
        document.getElementById("fr_month").value = "<?php echo date('Y-01', strtotime('-1 year', $lastyear_term)); ?>";
        document.getElementById("to_month").value = "<?php echo date('Y-12', strtotime('-1 year', $lastyear_term)); ?>";
	} else if (tomonth == "재작년") {
        document.getElementById("fr_month").value = "<?php echo date('Y-01', strtotime('-2 year', $lastyear_term)); ?>";
        document.getElementById("to_month").value = "<?php echo date('Y-12', strtotime('-2 year', $lastyear_term)); ?>";
    } else if (tomonth == "재재작년") {
        document.getElementById("fr_month").value = "<?php echo date('Y-01', strtotime('-3 year', $lastyear_term)); ?>";
        document.getElementById("to_month").value = "<?php echo date('Y-12', strtotime('-3 year', $lastyear_term)); ?>";
	} else if (tomonth == "1년") {
        document.getElementById("fr_month").value = "<?php echo date('Y-m', strtotime('-1 year', $year_term)); ?>";
        document.getElementById("to_month").value = "<?php echo date('Y-m', G5_SERVER_TIME); ?>";
    } else if (tomonth == "2년") {
        document.getElementById("fr_month").value = "<?php echo date('Y-m', strtotime('-2 year', $year_term)); ?>";
        document.getElementById("to_month").value = "<?php echo date('Y-m', G5_SERVER_TIME); ?>";
	} else if (tomonth == "3년") {
        document.getElementById("fr_month").value = "<?php echo date('Y-m', strtotime('-3 year', $year_term)); ?>";
        document.getElementById("to_month").value = "<?php echo date('Y-m', G5_SERVER_TIME); ?>";
	} else if (tomonth == "5년") {
        document.getElementById("fr_month").value = "<?php echo date('Y-m', strtotime('-5 year', $year_term)); ?>";
        document.getElementById("to_month").value = "<?php echo date('Y-m', G5_SERVER_TIME); ?>";	
	} else if (tomonth == "10년") {
        document.getElementById("fr_month").value = "<?php echo date('Y-m', strtotime('-10 year', $year_term)); ?>";
        document.getElementById("to_month").value = "<?php echo date('Y-m', G5_SERVER_TIME); ?>";
	} else if (today == "초기화") {
        document.getElementById("fr_month").value = "<?php echo date('Y-01', G5_SERVER_TIME); ?>";
        document.getElementById("to_month").value = "<?php echo date('Y-m', G5_SERVER_TIME); ?>";
    }
}
</script>
<script>
/* 매출일일 today */
function set_today(today)
{
    <?php
    $date_term = date('w', G5_SERVER_TIME); // 일단위
    $week_term = $date_term + 7; //일주일단위
    $last_term = strtotime(date('Y-m-01', G5_SERVER_TIME)); // 매월1일기준
	$month_term = strtotime(date('Y-m-d', G5_SERVER_TIME)); // 매월 오늘날짜 기준
    ?>
    if (today == "오늘") {
        document.getElementById("date").value = "<?php echo G5_TIME_YMD; ?>";
    } else if (today == "어제") {
        document.getElementById("date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
    } else if (today == "이일전") {
        document.getElementById("date").value = "<?php echo date('Y-m-d', strtotime('-2 day', G5_SERVER_TIME)); ?>";
	} else if (today == "삼일전") {
        document.getElementById("date").value = "<?php echo date('Y-m-d', strtotime('-3 day', G5_SERVER_TIME)); ?>";
	} else if (today == "사일전") {
        document.getElementById("date").value = "<?php echo date('Y-m-d', strtotime('-4 day', G5_SERVER_TIME)); ?>";
	} else if (today == "오일전") {
        document.getElementById("date").value = "<?php echo date('Y-m-d', strtotime('-5 day', G5_SERVER_TIME)); ?>";
	} else if (today == "육일전") {
        document.getElementById("date").value = "<?php echo date('Y-m-d', strtotime('-6 day', G5_SERVER_TIME)); ?>";
	} else if (today == "칠일전") {
        document.getElementById("date").value = "<?php echo date('Y-m-d', strtotime('-7 day', G5_SERVER_TIME)); ?>";
	} else if (today == "초기화") {
        document.getElementById("date").value = "<?php echo G5_TIME_YMD; ?>";
    }
}
</script>

<script>
/* 입금일별 */
function set_receipt_date(today)
{
    <?php
    $date_term = date('w', G5_SERVER_TIME); // 일단위
    $week_term = $date_term + 7; //일주일단위
    $last_term = strtotime(date('Y-m-01', G5_SERVER_TIME)); // 매월1일기준
	$month_term = strtotime(date('Y-m-d', G5_SERVER_TIME)); // 매월 오늘날짜 기준
    ?>
    if (today == "오늘") {
        document.getElementById("fr_receipt_date").value = "<?php echo G5_TIME_YMD; ?>";
        document.getElementById("to_receipt_date").value = "<?php echo G5_TIME_YMD; ?>";
    } else if (today == "어제") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
    } else if (today == "이번주") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-d', strtotime('-'.$date_term.' days', G5_SERVER_TIME)); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
    } else if (today == "이번달") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-01', G5_SERVER_TIME); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
    } else if (today == "지난주") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-d', strtotime('-'.$week_term.' days', G5_SERVER_TIME)); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', strtotime('-'.($week_term - 6).' days', G5_SERVER_TIME)); ?>";
    } else if (today == "지난달") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-01', strtotime('-1 Month', $last_term)); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-t', strtotime('-1 Month', $last_term)); ?>";    
	} else if (today == "1주일") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-d', strtotime('-7 days', $month_term)); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "1개월") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-d', strtotime('-1 Month', $month_term)); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	
	} else if (today == "3개월") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-d', strtotime('-3 Month', $month_term)); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "6개월") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-d', strtotime('-6 Month', $month_term)); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "1년") {
        document.getElementById("fr_receipt_date").value = "<?php echo date('Y-m-d', strtotime('-12 Month', $month_term)); ?>";
        document.getElementById("to_receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "초기화") {
        document.getElementById("fr_receipt_date").value = "";
        document.getElementById("to_receipt_date").value = "";
    }
}
</script>
<script>
/* 입금월별 */
function set_receipt_month(tomonth)
{
    <?php
    $date_term = date('w', G5_SERVER_TIME); // 일단위
    $week_term = $date_term + 7; //일주일단위
    $lastyear_term = strtotime(date('Y-01-01', G5_SERVER_TIME)); // 매년 1월1일기준
	$year_term = strtotime(date('Y-m-01', G5_SERVER_TIME)); // 매년 오늘 월 기준
    ?>
    if (tomonth == "올해") {
        document.getElementById("fr_receipt_month").value = "<?php echo date('Y-01', G5_SERVER_TIME); ?>";
        document.getElementById("to_receipt_month").value = "<?php echo date('Y-m', G5_SERVER_TIME); ?>";
    } else if (tomonth == "작년") {
        document.getElementById("fr_receipt_month").value = "<?php echo date('Y-01', strtotime('-1 year', $lastyear_term)); ?>";
        document.getElementById("to_receipt_month").value = "<?php echo date('Y-12', strtotime('-1 year', $lastyear_term)); ?>";
	} else if (tomonth == "재작년") {
        document.getElementById("fr_receipt_month").value = "<?php echo date('Y-01', strtotime('-2 year', $lastyear_term)); ?>";
        document.getElementById("to_receipt_month").value = "<?php echo date('Y-12', strtotime('-2 year', $lastyear_term)); ?>";
    } else if (tomonth == "재재작년") {
        document.getElementById("fr_receipt_month").value = "<?php echo date('Y-01', strtotime('-3 year', $lastyear_term)); ?>";
        document.getElementById("to_receipt_month").value = "<?php echo date('Y-12', strtotime('-3 year', $lastyear_term)); ?>";
	} else if (tomonth == "1년") {
        document.getElementById("fr_receipt_month").value = "<?php echo date('Y-m', strtotime('-1 year', $year_term)); ?>";
        document.getElementById("to_receipt_month").value = "<?php echo date('Y-m', G5_SERVER_TIME); ?>";
    } else if (tomonth == "2년") {
        document.getElementById("fr_receipt_month").value = "<?php echo date('Y-m', strtotime('-2 year', $year_term)); ?>";
        document.getElementById("to_receipt_month").value = "<?php echo date('Y-m', G5_SERVER_TIME); ?>";
	} else if (tomonth == "3년") {
        document.getElementById("fr_receipt_month").value = "<?php echo date('Y-m', strtotime('-3 year', $year_term)); ?>";
        document.getElementById("to_receipt_month").value = "<?php echo date('Y-m', G5_SERVER_TIME); ?>";
	} else if (tomonth == "5년") {
        document.getElementById("fr_receipt_month").value = "<?php echo date('Y-m', strtotime('-5 year', $year_term)); ?>";
        document.getElementById("to_receipt_month").value = "<?php echo date('Y-m', G5_SERVER_TIME); ?>";	
	} else if (tomonth == "10년") {
        document.getElementById("fr_receipt_month").value = "<?php echo date('Y-m', strtotime('-10 year', $year_term)); ?>";
        document.getElementById("to_receipt_month").value = "<?php echo date('Y-m', G5_SERVER_TIME); ?>";
	} else if (today == "초기화") {
        document.getElementById("fr_receipt_month").value = "<?php echo date('Y-01', G5_SERVER_TIME); ?>";
        document.getElementById("to_receipt_month").value = "<?php echo date('Y-m', G5_SERVER_TIME); ?>";
    }
}
</script>
<script>
/* 입금일일 today */
function set_receipt_today(today)
{
    <?php
    $date_term = date('w', G5_SERVER_TIME); // 일단위
    $week_term = $date_term + 7; //일주일단위
    $last_term = strtotime(date('Y-m-01', G5_SERVER_TIME)); // 매월1일기준
	$month_term = strtotime(date('Y-m-d', G5_SERVER_TIME)); // 매월 오늘날짜 기준
    ?>
    if (today == "오늘") {
        document.getElementById("receipt_date").value = "<?php echo G5_TIME_YMD; ?>";
    } else if (today == "어제") {
        document.getElementById("receipt_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
    } else if (today == "이일전") {
        document.getElementById("receipt_date").value = "<?php echo date('Y-m-d', strtotime('-2 day', G5_SERVER_TIME)); ?>";
	} else if (today == "삼일전") {
        document.getElementById("receipt_date").value = "<?php echo date('Y-m-d', strtotime('-3 day', G5_SERVER_TIME)); ?>";
	} else if (today == "사일전") {
        document.getElementById("receipt_date").value = "<?php echo date('Y-m-d', strtotime('-4 day', G5_SERVER_TIME)); ?>";
	} else if (today == "오일전") {
        document.getElementById("receipt_date").value = "<?php echo date('Y-m-d', strtotime('-5 day', G5_SERVER_TIME)); ?>";
	} else if (today == "육일전") {
        document.getElementById("receipt_date").value = "<?php echo date('Y-m-d', strtotime('-6 day', G5_SERVER_TIME)); ?>";
	} else if (today == "칠일전") {
        document.getElementById("receipt_date").value = "<?php echo date('Y-m-d', strtotime('-7 day', G5_SERVER_TIME)); ?>";
	} else if (today == "초기화") {
        document.getElementById("receipt_date").value = "<?php echo G5_TIME_YMD; ?>";
    }
}
</script>

<script>
$(function() {
    graph_draw();

    $("#sidx_graph_area div").hover(
        function() {
            if($(this).is(":animated"))
                return false;

            var title = $(this).attr("title");
            if(title && $(this).data("title") == undefined)
                $(this).data("title", title);
            var left = parseInt($(this).css("left")) + 10;
            var bottom = $(this).height() + 5;

            $(this)
                .attr("title", "")
                .append("<div id=\"price_tooltip\"><div></div></div>");
            $("#price_tooltip")
                .find("div")
                .html(title)
                .end()
//                .css({ left: left+"px", bottom: bottom+"px" })
                .show(200);
        },
        function() {
            if($(this).is(":animated"))
                return false;

            $(this).attr("title", $(this).data("title"));
            $("#price_tooltip").remove();
        }
    );
});

function graph_draw()
{
    var g_h1 = new Array("<?php echo implode('", "', $h_val['order']); ?>");
    var g_h2 = new Array("<?php echo implode('", "', $h_val['cancel']); ?>");
    var duration = 600;

    var $el = $("#sidx_graph_area li");
    var h1, h2;
    var $g1, $g2;

    $el.each(function(index) {
        h1 = g_h1[index];
        h2 = g_h2[index];

        $g1 = $(this).find(".order");
        $g2 = $(this).find(".cancel");

        $g1.animate({ height: h1+"px" }, duration);
        $g2.animate({ height: h2+"px" }, duration);
    });
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
