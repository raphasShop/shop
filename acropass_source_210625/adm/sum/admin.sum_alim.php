<?php
if (!defined('_GNUBOARD_')) exit;

#######################################################################################
/* 오늘 처리 할일 / 승인 및 답변, 재고확인등 처리해야 할 알림 정보 [아이스크림소스]*/
// 삽입함수 include_once(G5_ADMIN_PATH.'/sum/admin.sum_alim.php');
// 알림을 메인에 표시해줍니다
// index.php 에서 사용함
#######################################################################################
	
// 사용후기 관리자미승인 건수 표시(관리자승인시 공개일경우)
function use_notconfirm($it)
{
    global $g5;

    // 쿠폰상품
    $sql = " select count(*) as cnt
          from {$g5['g5_shop_item_use_table']} a
                left join {$g5['g5_shop_item_table']} b on (a.it_id = b.it_id)
                left join {$g5['member_table']} c on (a.mb_id = c.mb_id)
          where is_confirm = '$confirm' ";
    $row = sql_fetch($sql);
	
    if($row['cnt']) { //있을때
        $ccnt .= '<a href="'.G5_ADMIN_URL.'/shop_admin/itemuselist.php"><span class="scoreround-sm-green">'.$row['cnt'].'</span></a>';
    } else { //없을때
        $ccnt .= '<a href="'.G5_ADMIN_URL.'/shop_admin/itemuselist.php"><b style="color:#eaeaea;">O</b></a>';
    }
	return $ccnt;
}

// 입금확인요청 - 관리자가 확인안한 레코드수만 얻음
    $sql_common1 = "  from {$g5['g5_shop_order_atmcheck_table']} where id_confirm ='0'";
    $sql_common1 .= $sql_search1;
                    
    $sql_confirm = " select count(*) as cnt " . $sql_common1;
    $row_confirm = sql_fetch($sql_confirm);
    $total_confirm_count = $row_confirm['cnt'];

// 1:1상담 - 관리자가 답변안한 레코드수만 얻음
    $sql_common0 = "  from {$g5['qa_content_table']} where qa_status ='0'";
    $sql_common0 .= $sql_search0;
                    
    $sql_oneqa = " select count(*) as cnt " . $sql_common0;
    $row_oneqa = sql_fetch($sql_oneqa);
    $total_oneqa_count = $row_oneqa['cnt'];
	
// 상품Q&A - 관리자가 답변안한 레코드수만 얻음
    $sql_common2 = "  from {$g5['g5_shop_item_qa_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id = b.it_id) left join {$g5['member_table']} c on (a.mb_id = c.mb_id) where iq_answer =''";
    $sql_common2 .= $sql_search2;
                    
    $sql_qa = " select count(*) as cnt " . $sql_common2;
    $row_qa = sql_fetch($sql_qa);
    $total_qa_count = $row_qa['cnt'];

// [오늘전체] 상품Q&A - 전체
    $sql_common2_1 = "  from {$g5['g5_shop_item_qa_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id = b.it_id) left join {$g5['member_table']} c on (a.mb_id = c.mb_id) where iq_time between '$today 00:00:00' and '$today 23:59:59'";
    $sql_common2_1 .= $sql_search2_1;
                    
    $sql_todayqa = " select count(*) as cnt " . $sql_common2_1;
    $row_todayqa = sql_fetch($sql_todayqa);
    $total_todayqa_count = $row_todayqa['cnt'];

// [이번달전체] 상품Q&A - 전체
    $sql_common2_3 = "  from {$g5['g5_shop_item_qa_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id = b.it_id) left join {$g5['member_table']} c on (a.mb_id = c.mb_id) where iq_time between '$moneday 00:00:00' and '$mnowday 23:59:59'";
    $sql_common2_3 .= $sql_search2_3;
                    
    $sql_mqa = " select count(*) as cnt " . $sql_common2_3;
    $row_mqa = sql_fetch($sql_mqa);
    $total_mqa_count = $row_mqa['cnt'];

// 재입고 SMS 알림
    $sms_alim = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_stocksms_table']} where ss_send = '0' ";
    $row = sql_fetch($sql);
    $sms_alim = (int)$row['cnt'];

// PG사결제 미완료(주문에러) 목록(장바구니CART번호가 공란이아니면 표시)
    $pg_error = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_order_data_table']} where cart_id <> '0' ";
    $row = sql_fetch($sql);
    $pg_error = (int)$row['cnt'];
		
// 재고부족 상품
    $item_noti = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_table']} where it_use = '1' and it_option_subject = '' and it_stock_qty <= it_noti_qty ";
    $row = sql_fetch($sql);
    $item_noti = (int)$row['cnt'];

// 재고부족 옵션
    $option_noti = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_option_table']} where io_use = '1' and io_stock_qty <= io_noti_qty ";
    $row = sql_fetch($sql);
    $option_noti = (int)$row['cnt'];

// 후기 미승인
    $review_alim = 0;
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_use_table']} where is_confirm != '1' ";
    $row = sql_fetch($sql);
    $review_alim = (int)$row['cnt'];
	
#####################################################################################
?>