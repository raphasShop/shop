<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>
<script>
$(function() {
    $( ".od_process" ).change(function() {
       var url = "<?php echo G5_SHOP_URL; ?>" + "/orderlist.php?ps=" + $( this ).val() + "&month=" + "<?php echo $month_f ?>";
       location.replace(url);
    });
});
</script>
<div class="my_title_wrap">
    <div class="my_main_title"><a href="<?php echo G5_SHOP_URL ?>/mypage.php">마이페이지</a></div>
    <div class="my_sub_title">주문배송조회</div>
</div>

<div id="mypage_pc_wrap">
<div id="order_list">
    <div id="order_board_wrap">
        
        <div class="order_board_title">최근 1년 내 목록만 조회가능합니다.</div>
        <div class="order_board_month_wrap">
          <a href="<?php echo G5_SHOP_URL; ?>/orderlist.php?ps=<?php echo $ps_f; ?>&month=1"><div class="order_board_month <?php if($month_f == 3 || $month_f == 6 || $month_f == 12) {} else { echo "month_select"; } ?>">1개월</div></a><a href="<?php echo G5_SHOP_URL; ?>/orderlist.php?ps=<?php echo $ps_f; ?>&month=3"><div class="order_board_month <?php if($month_f == 3 ) { echo "month_select"; } ?>">3개월</div></a><a href="<?php echo G5_SHOP_URL; ?>/orderlist.php?ps=<?php echo $ps_f; ?>&month=6"><div class="order_board_month <?php if($month_f == 6 ) { echo "month_select"; } ?>">6개월</div></a><a href="<?php echo G5_SHOP_URL; ?>/orderlist.php?ps=<?php echo $ps_f; ?>&month=12"><div class="order_board_month_last <?php if($month_f == 12 ) { echo "month_select"; } ?>">1년</div></a>
        </div>
        <select class="od_process">
            <option value="ps0" <?php if($ps_f == 'ps0') { echo 'selected'; } ?>>전체</option>
            <option value="ps1" <?php if($ps_f == 'ps1') { echo 'selected'; } ?>>입금대기중</option>
            <option value="ps2" <?php if($ps_f == 'ps2') { echo 'selected'; } ?>>결제완료</option>
            <option value="ps3" <?php if($ps_f == 'ps3') { echo 'selected'; } ?>>상품준비중</option>
            <option value="ps4" <?php if($ps_f == 'ps4') { echo 'selected'; } ?>>배송중</option>
            <option value="ps5" <?php if($ps_f == 'ps5') { echo 'selected'; } ?>>배송완료</option>
            <option value="ps6" <?php if($ps_f == 'ps6') { echo 'selected'; } ?>>취소/교환/반품</option>
        </select>
    </div>
    <div id="order_list_wrap">
        <div id="sod_inquiry">
            <ul>
                <?php

                if($ps_f == 'ps0') {
                    $where = '1=1';
                } else if ($ps_f == 'ps1') {
                    $where = "od_status = '주문'";
                } else if ($ps_f == 'ps2') {
                    $where = "od_status = '입금'";
                } else if ($ps_f == 'ps3') {
                    $where = "od_status = '준비'";
                } else if ($ps_f == 'ps4') {
                    $where = "od_status = '배송'";
                } else if ($ps_f == 'ps5') {
                    $where = "od_status = '완료'";
                } else if ($ps_f == 'ps6') {
                    $where = "od_status = '취소' OR od_status = '반품' OR od_status = '교환'";
                }
                $sql = " select *,
                            (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
                           from {$g5['g5_shop_order_table']}
                          where mb_id = '{$member['mb_id']}' AND ({$where})
                          order by od_id desc
                          $limit ";
                $result = sql_query($sql);
                for ($i=0; $row=sql_fetch_array($result); $i++)
                {
                    // 주문상품
                    $sql = " select it_name, ct_option
                                from {$g5['g5_shop_cart_table']}
                                where od_id = '{$row['od_id']}'
                                order by io_type, ct_id
                                limit 1 ";
                    $ct = sql_fetch($sql);
                    $ct_name = get_text($ct['it_name']).' '.get_text($ct['ct_option']);

                    $sql = " select count(*) as cnt
                                from {$g5['g5_shop_cart_table']}
                                where od_id = '{$row['od_id']}' ";
                    $ct2 = sql_fetch($sql);
                    if($ct2['cnt'] > 1)
                        $ct_name .= ' 외 '.($ct2['cnt'] - 1).'건';

                    switch($row['od_status']) {
                        case '주문':
                            $od_status = '<span class="status_00">입금확인중</span>';
                            break;
                        case '입금':
                            $od_status = '<span class="status_00">결제완료</span>';
                            break;
                        case '준비':
                            $od_status = '<span class="status_00">상품준비중</span>';
                            break;
                        case '배송':
                            $od_status = '<span class="status_00">상품배송</span>';
                            break;
                        case '완료':
                            $od_status = '<span class="status_00">배송완료</span>';
                            break;
                        default:
                            $od_status = '<span class="status_00">주문취소</span>';
                            break;
                    }

                    $od_invoice = '';
                    if($row['od_delivery_company'] && $row['od_invoice'])
                        $od_invoice = '<span class="inv_inv"><i class="fa fa-truck" aria-hidden="true"></i> <strong>'.get_text($row['od_delivery_company']).'</strong> '.get_text($row['od_invoice']).'</span>';

                    $uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);
                ?>
               
                <li>
                     <a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>" class="idtime_link">
                    <div class="inquiry_idtime">
                        <span class="inquiry_name"><?php echo $row['it_namex']; ?></span>
                        <span class="idtime_time"><?php echo substr($row['od_time'],0,10); ?></span>
                    </div>
                    <div class="inquiry_id">
                        주문번호 <?php echo $row['od_id']; ?>
                    </div>
                    <div class="inquiry_price">
                        <?php echo display_price($row['od_receipt_price']); ?>
                    </div>
                    </a>
                    <div class="inquiry_inv">
                        <?php echo $od_invoice; ?>
                        <span class="inv_status"><?php echo $od_status; ?></span>

                        
                        <!-- 입금확인-아이스크림 소스추가 --
                        <?php if ($row['od_status'] == '주문') { //입금확인요청?>
                        <div class="btn-group">
                            <button type="button" onclick="popup_form('order​atmcheck​​', '<?php echo G5_SHOP_URL; ?>/orderatmcheck.php?od_id=<?php echo $row['od_id']; ?>');" style="border:0px;">
                                <span class="btn btn-white btn-xs"><i class="fa fa-low-vision" aria-hidden="true"></i>입금확인요청</span><span class="sound_only"> 새 창</span>
                            </button>
                        </div>
                        <?php } ?>
                        <!-- // -->
                        
                    </div>
                    <?php if($row['od_status'] == '완료' || $row['od_status'] == '배송' ) { 
                    $sql = " select it_id
                                from {$g5['g5_shop_cart_table']}
                                where od_id = '{$row['od_id']}' ";
                    $rv = sql_fetch($sql);

                    ?>

                    <a href="<?php echo G5_SHOP_URL; ?>/itemuseform.php?it_id=<?php echo $rv['it_id']; ?>&ps=<?php echo $ps_f; ?>&od_id=<?php echo $row['od_id']; ?>" class="qa_wr itemuse_form" onclick="return false;">
                    <div class="test" style="width:100%;height:40px;background: #fff;color:#000;text-align: center;border:1px solid #000; line-height: 40px;font-size:15px;margin-top:10px;">리뷰 쓰기</div></a>
                    <?php } ?>
                </li>
                

                <?php
                }

                if ($i == 0) {
                ?>
                    <div class="order_list_none">
                        <img src="<?php echo G5_IMG_URL; ?>/acm-none-img.png">
                        <div class="order_none_msg">내역이 없습니다.</div>
                    </div>
                <?php
                }
                ?>
            </ul>
        </div>
        
    </div>
    
</div>

</div>

<script>
$(function(){
    $(".itemuse_form").click(function(){
        window.open(this.href, "itemuse_form", "width=810,height=680,scrollbars=1");
        return false;
    });
});
</script>