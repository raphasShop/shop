<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<header>
    <div class="mo_page_title_wrap"><a href="javascript:history.back();"><img src="<?php echo G5_IMG_URL; ?>/title_back.png" title=""></a> 적립금</div>
</header>

<div id="mypage_wrap">
    <div class="mypage_con_wrap">
        <div class="point_title">적립금</div>
        <div class="point_count"><span><?php echo number_format($member['mb_point']); ?></span> 원</div>
        <div class="point_top_wrap">
            <div class="point_top_menu1">상세내역</div><div class="point_top_menu2">적립 / 사용</div>
        </div>
        <div class="point_list">
            <ul id="point_ul">
                <?php
                $sum_point1 = $sum_point2 = $sum_point3 = 0;

                $sql = " select *
                            {$sql_common}
                            {$sql_order}
                            limit {$from_record}, {$rows} ";
                $result = sql_query($sql);
                for ($i=0; $row=sql_fetch_array($result); $i++) {
                    $point1 = $point2 = 0;
                    if ($row['po_point'] > 0) {
                        $point1 = number_format($row['po_point']);
                        $sum_point1 += $row['po_point'];
                    } else {
                        $point2 = number_format($row['po_point']);
                        $sum_point2 += $row['po_point'];
                    }

                    $po_content = $row['po_content'];

                    $expr = '';
        //            if($row['po_expired'] == 1)
                        $expr = ' txt_expired';
                ?>
                <li>
                    <div class="point_wrap01">
                        <span class="point_log"><?php echo $po_content; ?></span>
                        <span class="point_date"><?php echo conv_date_format('20y년 m월 d일', $row['po_datetime']); ?></span>
                    </div><div class="point_wrap02">
                        <?php if ($point1) { ?><span class="point_add">적립</span><span class="point_in"><?php echo $point1; ?> 원 </span> 
                        <?php } else { ?><span class="point_use">사용</span><span class="point_out"><?php echo $point2; ?> 원</span><?php } ?>
                        <span class=" point_date point_expdate<?php echo $expr; ?>" style="display: none;">
                            <?php if ($row['po_expired'] == 1) { ?>
                            만료: <?php echo substr(str_replace('-', '', $row['po_expire_date']), 2); ?>
                            <?php } else echo $row['po_expire_date'] == '9999-12-31' ? '&nbsp;' : $row['po_expire_date']; ?>
                        </span>
                    </div>
                </li>
                <?php
                }

               if ($i == 0) { ?>
                    <div class="point_list_none">
                        <img src="<?php echo G5_IMG_URL; ?>/empty_icon.png">
                        <div class="empty_table">적립금 내역이 없습니다.</div>
                    </div>
                <?php }
                else {
                    if ($sum_point1 > 0)
                        $sum_point1 = "+" . number_format($sum_point1);
                    $sum_point2 = number_format($sum_point2);
                }
                ?>
            </ul>

          
            <?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>
        </div>
    </div>
</div>
