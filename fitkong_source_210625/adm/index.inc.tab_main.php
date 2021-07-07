<?php
if (!defined('_GNUBOARD_')) exit;
include_once('./_common.php');
#######################################################################################
// 관리자 현황판
/* 관리자모드 메인 페이지 최상단의 오늘할일/오늘발생/매출액 등 표시 [아이스크림 소스] */
// 삽입함수 include_once(G5_ADMIN_PATH.'/index.inc.tab_main.php');
// 관리자메인/그외페이지에 출력 가능
// 주문상태/오늘할일/오늘일어난일/매출액 요약표시 등 알림과 관련된 카운트 표시
#######################################################################################

################################################
/* 입금/매출/주문 현황표 */
################################################	

// 오늘의 모든 입금(현재상태에 상관없이 오늘 입금건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_refund_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$today 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $main_infotoday_receipt = array();
    $main_infotoday_receipt['count'] = (int)$row['cnt'];
    $main_infotoday_receipt['price'] = (int)$row['price'];
    $main_infotoday_receipt['href'] = G5_ADMIN_URL.'/shop_admin/sale1receipttoday.php?receipt_date='.urlencode($today);
	
// 어제의 모든 입금(현재상태에 상관없이 어제 입금건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_refund_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$yesterday 00:00:00' and '$yesterday 23:59:59'";
    $row = sql_fetch($sql);
    $main_infoyesterday_receipt = array();
    $main_infoyesterday_receipt['count'] = (int)$row['cnt'];
    $main_infoyesterday_receipt['price'] = (int)$row['price'];
    $main_infoyesterday_receipt['href'] = G5_ADMIN_URL.'/shop_admin/sale1receipttoday.php?receipt_date='.urlencode($yesterday);

// 이번달의 모든 입금(현재상태에 상관없이 이달 입금건만 계산)/금액(관리자모드) - 이달 1일 부터 현재일까지
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_refund_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$moneday 00:00:00' and '$mnowday 23:59:59'";
    $row = sql_fetch($sql);
    $main_infomonth_receipt = array();
    $main_infomonth_receipt['count'] = (int)$row['cnt'];
    $main_infomonth_receipt['price'] = (int)$row['price'];
    $main_infomonth_receipt['href'] = G5_ADMIN_URL.'/shop_admin/sale1receiptdate.php?fr_receipt_date='.urlencode($moneday).'&to_receipt_date='.urlencode($mnowday);

################################################
/* 매출현황표 */
// admin.sum_order.php에 추가하면 모든페이지에서 데이타를 불러오기위한 과부하가 예상되어
// 따로 매출관리페이지에만 표시함
################################################	

// 오늘의 모든 매출(현재상태에 상관없이 오늘 매출건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$today 00:00:00' and '$today 23:59:59'";
    $row = sql_fetch($sql);
    $main_infotoday_sale = array();
    $main_infotoday_sale['count'] = (int)$row['cnt'];
    $main_infotoday_sale['price'] = (int)$row['price'];
    $main_infotoday_sale['href'] = G5_ADMIN_URL.'/shop_admin/sale1today.php?date='.urlencode($today);
	
// 어제의 모든 매출(현재상태에 상관없이 어제 매출건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_receipt_price - od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_receipt_time between '$yesterday 00:00:00' and '$yesterday 23:59:59'";
    $row = sql_fetch($sql);
    $main_infoyesterday_sale = array();
    $main_infoyesterday_sale['count'] = (int)$row['cnt'];
    $main_infoyesterday_sale['price'] = (int)$row['price'];
    $main_infoyesterday_sale['href'] = G5_ADMIN_URL.'/shop_admin/sale1today.php?date='.urlencode($yesterday);

// 이번달의 모든 매출(현재상태에 상관없이 이달 매출건만 계산)/금액(관리자모드) - 이달 1일 부터 현재일까지
/* admin.sum_orderdate.php 파일에 있음. 전체파일에 인클루드되는 파일이기에 중복되어 여기서는 빠짐 */

################################################
/* 취소/환불현황표 */
// admin.sum_order.php에 추가하면 모든페이지에서 데이타를 불러오기위한 과부하가 예상되어
// 따로 취소/환불관리페이지에만 표시함
################################################	

// 오늘의 모든 취소/환불(현재상태에 상관없이 오늘 취소/환불건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$today 00:00:00' and '$today 23:59:59' and ( (od_status = '취소') OR (od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0) ) ";
    $row = sql_fetch($sql);
    $main_infotoday_cancle = array();
    $main_infotoday_cancle['count'] = (int)$row['cnt'];
    $main_infotoday_cancle['price'] = (int)$row['price'];
    $main_infotoday_cancle['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($today).'&to_date='.urlencode($today);
	
// 어제의 모든 취소/환불(현재상태에 상관없이 어제 취소/환불건만 계산)/금액(관리자모드)
    $sql = " select count(*) as cnt, sum(od_cancel_price) as price from {$g5['g5_shop_order_table']} where od_time between '$yesterday 00:00:00' and '$yesterday 23:59:59' and ( (od_status = '취소') OR (od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0) ) ";
    $row = sql_fetch($sql);
    $main_infoyesterday_cancle = array();
    $main_infoyesterday_cancle['count'] = (int)$row['cnt'];
    $main_infoyesterday_cancle['price'] = (int)$row['price'];
    $main_infoyesterday_cancle['href'] = G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($yesterday).'&to_date='.urlencode($yesterday);

// 이번달의 모든 취소/환불(현재상태에 상관없이 이달 취소/환불건만 계산)/금액(관리자모드) - 이달 1일 부터 현재일까지
/* admin.sum_orderdate.php 파일에 있음. 전체파일에 인클루드되는 파일이기에 중복되어 여기서는 빠짐 */
?>

<!-- [섹션] 주문상태표시 줄 { -->
<section>

<div class="dan-garo-transparent2"><!-- 현재 쇼핑몰 정보 / 투명배경 -->
    <div class="row"><!-- row 시작 { --> 
		<div class="dan"><!-- ### (1) 첫번째칸 ### {-->
		    <ul id="li_garo1">
                <!-- 입금대기 -->
                <li id="li_garo1_score" onClick="location.href='<?php echo $info1['href']; ?>'" style="cursor:pointer;">
                    <!-- 전체/오늘숫자표시 -->
					<?php if ($info1['count'] > 0) { ?>
                        <span class="round_score">
						<?php echo ($info1_odtoday['count'] > 0) ? '<span class="score-round-sm">'.number_format($info1_odtoday['count']).'</span>' : '';//오늘입금대기?>
						<?php echo number_format($info1['count']); ?>
                        </span>
                    <?php } else { ?>
                        <span class="round_score_none">
                        <?php echo ($info1_odtoday['count'] > 0) ? '<span class="score-round-sm">'.number_format($info1_odtoday['count']).'</span>' : '';//오늘입금대기?>
                        -
                        </span>
                    <?php } ?>
                    <!--//-->
                    <br><?php echo ($info1['price'] > 0) ? '￦'.number_format($info1['price']) : '';?>
                    <br><font style="font-family:Dotum,'돋움',tahoma;font-size:11px;color:#FF4E50;font-weight:normal;line-height:14px;">입금대기 <?php echo ($info1['price'] > 0) ? '<button>확인</button>' : '';?></font>
                </li>
                <!-- 결제완료 -->
                <li id="li_garo1_score" onClick="location.href='<?php echo $info2['href']; ?>'" style="cursor:pointer;">
                    <!-- 전체/오늘숫자표시 -->
					<?php if ($info2['count'] > 0) { ?>
                        <span class="round_score">
						<?php echo ($info2_odtoday['count'] > 0) ? '<span class="score-round-sm">'.number_format($info2_odtoday['count']).'</span>' : '';//오늘입금대기?>
						<?php echo number_format($info2['count']); ?>
                        </span>
                    <?php } else { ?>
                        <span class="round_score_none">
                        <?php echo ($info2_odtoday['count'] > 0) ? '<span class="score-round-sm">'.number_format($info2_odtoday['count']).'</span>' : '';//오늘입금대기?>
                        -
                        </span>
                    <?php } ?>
                    <!--//-->
                    <br><?php echo ($info2['price'] > 0) ? '￦'.number_format($info2['price']) : '';?>
                    <br><font style="font-family:Dotum,'돋움',tahoma;font-size:11px;color:#68C40E;font-weight:normal;">결제완료  <?php echo ($info2['price'] > 0) ? '<button>확인</button>' : '';?></font>
                </li>
                <!-- 상품준비 -->
                <li id="li_garo1_score" onClick="location.href='<?php echo $info3['href']; ?>'" style="cursor:pointer;">
				    <!-- 전체/오늘숫자표시 -->
					<?php if ($info3['count'] > 0) { ?>
                        <span class="round_score_todo">
						<?php echo ($info3['count'] > 0) ? '<span class="score-round-sm">배송하세요</span>' : '';//상품준비중?>
						<?php echo number_format($info3['count']); ?>
                        </span>
                    <?php } else { ?>
                        <span class="round_score_none">
                        <?php echo ($info3['count'] > 0) ? '<span class="score-round-sm">배송하세요</span>' : '';//상품준비중?>
                        -
                        </span>
                    <?php } ?>
                    <!--//-->
                    <br><?php echo ($info3['price'] > 0) ? '￦'.number_format($info3['price']) : '';?>
                    <br><font style="font-family:Dotum,'돋움',tahoma;font-size:11px;color:#FF4E50;font-weight:normal;">상품준비중  <?php echo ($info3['price'] > 0) ? '<button>확인</button>' : '';?></font>
                </li>
                <!-- 배송중 -->
                <li id="li_garo1_score" onClick="location.href='<?php echo $info4['href']; ?>'" style="cursor:pointer;">
                    <!-- 전체/오늘숫자표시 -->
					<?php if ($info4['count'] > 0) { ?>
                        <span class="round_score">
						<?php echo ($info4_odtoday['count'] > 0) ? '<span class="score-round-sm">'.number_format($info4_odtoday['count']).'</span>' : '';//오늘입금대기?>
						<?php echo number_format($info4['count']); ?>
                        </span>
                    <?php } else { ?>
                        <span class="round_score_none">
                        <?php echo ($info4_odtoday['count'] > 0) ? '<span class="score-round-sm">'.number_format($info4_odtoday['count']).'</span>' : '';//오늘입금대기?>
                        -
                        </span>
                    <?php } ?>
                    <!--//-->
                    <br><?php echo ($info4['price'] > 0) ? '￦'.number_format($info4['price']) : '';?>
                    <br><font style="font-family:Dotum,'돋움',tahoma;font-size:11px;color:#68C40E;font-weight:normal;">배송중  <?php echo ($info4['price'] > 0) ? '<button>확인</button>' : '';?></font>
                </li>
                <!-- 개인결제 -->
                <li id="li_garo1_score" onClick="location.href='<?php echo $info_personal['href']; ?>'" style="cursor:pointer;">
                    <!-- 전체/오늘숫자표시 -->
					<?php if ($info_personal['count'] > 0) { ?>
                        <span class="round_score2">
						<?php echo ($info_personal_odtoday['count'] > 0) ? '<span class="score-round-sm">'.number_format($info_personal_odtoday['count']).'</span>' : '';//오늘입금대기?>
						<?php echo number_format($info_personal['count']); ?>
                        </span>
                    <?php } else { ?>
                        <span class="round_score_none">
                        <?php echo ($info_personal_odtoday['count'] > 0) ? '<span class="score-round-sm">'.number_format($info_personal_odtoday['count']).'</span>' : '';//오늘입금대기?>
                        -
                        </span>
                    <?php } ?>
                    <!--//-->
                    <br><?php echo ($info_personal['price'] > 0) ? '￦'.number_format($info_personal['price']) : '';?>
                    <br><font style="font-family:Dotum,'돋움',tahoma;font-size:11px;color:#9457AD;font-weight:normal;">개인결제  <?php echo ($info_personal['price'] > 0) ? '<button>결제대기</button>' : '';?></font>
                </li>
                <!-- 오늘주문 -->
                <li id="li_garo1_score" onClick="location.href='<?php echo $info1['href']; ?>'" style="cursor:pointer;">
					<!-- 전체/오늘숫자표시 -->
					<?php if ($infotoday['count'] > 0) { ?>
                        <span class="round_score_today">
						<?php echo ($infotoday['count'] > 0) ? '<span class="score-round-sm">TODAY</span>' : '';//오늘주문?>
						<?php echo number_format($infotoday['count']); ?>
                        </span>
                    <?php } else { ?>
                        <span class="round_score_none">
                        <?php echo ($infotoday['count'] > 0) ? '<span class="score-round-sm">'.number_format($infotoday['count']).'</span>' : '';//오늘주문?>
                        -
                        </span>
                    <?php } ?>
                    <!--//-->
                    <br><?php echo ($infotoday['price'] > 0) ? '￦'.number_format($infotoday['price']) : '';?>
                    <br><font style="font-family:Dotum,'돋움',tahoma;font-size:11px;color:#555;font-weight:normal;line-height:14px;">오늘의주문</font>
                </li>
                
			</ul>
	    </div><!-- } ### (1) 첫번째칸 ### -->

    </div><!-- } row 끝 -->
</div><!-- 현재 쇼핑몰 정보 / 투명배경 -->
</section>
<!-- [섹션] 주문상태표시 줄 // -->


<!-- [섹션] 오늘할일알림 표 { -->
<?php 
    // 오늘할일 알림 출력 섹션 시작
	echo '<section>';
?>
<div class="div_alpha_board1">
<!-- ### 가로 전체 시작 ### -->

    <!-- (가로1) 할일알림 -->
    <div class="box boxwidth6" style="margin-bottom:3px;"><!-- 가로1열기 -->

    <div class="tbl_scoreboard1"><!-- [표]승인대상 시작 { -->
    <table> 
        <thead>
            <tr>
                <th scope="col" style="background:#68C40E;color:#FCE756;font-weight:bold;border:1px solid #4E930A;">할일</th>
                <th scope="col">입금확인</th>
                <th scope="col">1:1문의</th>
                <th scope="col">상품문의</th>
                <th scope="col">사용후기</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="col">대기</th>
                <td class="td_score"><a href="<?php echo G5_ADMIN_URL;?>/shop_admin/atmcheck.php"><?php echo ($total_confirm_count > 0) ? '<span class="scoreround-sm-green">'.number_format($total_confirm_count).'</span>' : '<b style="color:#eaeaea;">O</b>';//입금확인요청?></a></td>
                <td class="td_score"><a href="<?php echo G5_BBS_URL;?>/qalist.php" target="_blank"><?php echo ($total_oneqa_count > 0) ? '<span class="scoreround-sm-green">'.number_format($total_oneqa_count).'</span>' : '<b style="color:#eaeaea;">O</b>';//1:1상담문의?></a></td>
                <td class="td_score"><a href="<?php echo G5_ADMIN_URL;?>/shop_admin/itemqalist.php"><?php echo ($total_qa_count > 0) ? '<span class="scoreround-sm-green">'.number_format($total_qa_count).'</span>' : '<b style="color:#eaeaea;">O</b>';//상품문의?></a></td>
                <td class="td_score"><?php echo use_notconfirm($it);//사용후기?></td>
            </tr>
        </tbody>
    </table>
    <!--<h5>┗ <span class="font-11 black font-normal"> 고객요청처리대상/오늘처리할일</span> <span class="font-11 gray font-normal">(관리자가 처리하지 않은 알림)</span></h5>-->
    </div><!-- [표]승인대상 끝 { -->

    </div><!-- 가로1닫기 //-->
    <!--//-->
    
    
    <!-- (가로1-1) 할일2 -->
    <div class="box boxwidth6" style="margin-bottom:3px;"><!-- 가로1-1열기 -->

    <div class="tbl_scoreboard1"><!-- [표]승인대상 시작 { -->
    <table> 
        <thead>
            <tr>
                <th scope="col" style="background:#68C40E;color:#FCE756;font-weight:bold;border:1px solid #4E930A;">할일</th>
                <th scope="col">주문에러</th>
                <th scope="col">재입고알림</th>
                <th scope="col">재고부족</th>
                <th scope="col">옵션부족</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="col">대기</th>
                <td class="td_score"><a href="<?php echo G5_ADMIN_URL;?>/shop_admin/inorderlist.php"><?php echo ($pg_error > 0) ? '<span class="scoreround-sm-green">'.number_format($pg_error).'</span>' : '<b style="color:#eaeaea;">O</b>';//주문에러?></a></td>
                <td class="td_score"><a href="<?php echo G5_ADMIN_URL;?>/shop_admin/itemstocksms.php"><?php echo ($sms_alim > 0) ? number_format($sms_alim) : '<b style="color:#eaeaea;">O</b>';//재입고SMS알림?></a></td>
                <td class="td_score"><a href="<?php echo G5_ADMIN_URL;?>/shop_admin/itemstocklist.php"><?php echo ($item_noti > 0) ? number_format($item_noti) : '<b style="color:#eaeaea;">O</b>';//재고부족?></a></td>
                <td class="td_score"><a href="<?php echo G5_ADMIN_URL;?>/shop_admin/optionstocklist.php?sel_ca_id=&sel_field=b.it_name&search=&sort1=a.io_stock_qty&sort2=asc&page=1"><?php echo ($option_noti > 0) ? number_format($option_noti) : '<b style="color:#eaeaea;">O</b>';//재고부족(옵션)?></a></td>
            </tr>
        </tbody>
    </table>
    </div><!-- [표]승인대상 끝 { -->

    </div><!-- 가로1-1닫기 //-->
    <!--//-->
    
    
    <!-- (가로2) 취소진행상황 -->
    <div class="box boxwidth8" style="margin-bottom:3px;"><!-- 가로1열기 -->

    <div class="tbl_scoreboard1"><!-- [표]승인대상 시작 { -->
    <table> 
        <thead>
            <tr>
                <th scope="col" style="background:#68C40E;color:#FCE756;font-weight:bold;border:1px solid #4E930A;">취소</th>
                <th scope="col">환불신청/진행</th>
                <th scope="col">반품신청/진행</th>
                <th scope="col">교환신청/진행</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="col">진행</th>
                <td class="td_score">
                <a href="<?php echo $now_refund['href']; ?>"><?php echo ($now_refund['count'] > 0) ? '<span class="scoreround-sm-green">'.number_format($now_refund['count']).'</span>' : '<b style="color:#eaeaea;">O</b>';?></a>
                <span class="lightgray font-normal">/</span>
                <a href="<?php echo $now_refunding['href']; ?>"><?php echo ($now_refunding['count'] > 0) ? '<span class="scoreround-sm-green">'.number_format($now_refunding['count']).'</span>' : '<b style="color:#eaeaea;">O</b>';?></a>
                </td>
                <td class="td_score"><a href="<?php echo $now_back['href']; ?>"><?php echo ($now_back['count'] > 0) ? '<span class="scoreround-sm-green">'.number_format($now_back['count']).'</span>' : '<b style="color:#eaeaea;">O</b>';?></a>
                <span class="lightgray font-normal">/</span>
                <a href="<?php echo $now_backing['href']; ?>"><?php echo ($now_backing['count'] > 0) ? '<span class="scoreround-sm-green">'.number_format($now_backing['count']).'</span>' : '<b style="color:#eaeaea;">O</b>';?></a>
                </td>
                <td class="td_score">
                <a href="<?php echo $now_change['href']; ?>"><?php echo ($now_change['count'] > 0) ? '<span class="scoreround-sm-green">'.number_format($now_change['count']).'</span>' : '<b style="color:#eaeaea;">O</b>';?></a>
                <span class="lightgray font-normal">/</span>
                <a href="<?php echo $now_changeing['href']; ?>"><?php echo ($now_changeing['count'] > 0) ? '<span class="scoreround-sm-green">'.number_format($now_changeing['count']).'</span>' : '<b style="color:#eaeaea;">O</b>';?></a>
                </td>
            </tr>
        </tbody>
    </table>
    <!--<h5>┗ <span class="font-11 black font-normal"> 고객크레임처리현황</span> <span class="font-11 gray font-normal">(취소/환불/반품진행상황)</span></h5>-->
    </div><!-- [표]승인대상 끝 { -->

    </div><!-- 가로1닫기 //-->
    <!--//-->

<!-- ### 가로전체 끝 ### -->
</div>
<?php 
	echo '</section>';
    // 오늘할일 알림 출력 섹션 시작
?>
<!-- [섹션] 오늘할일알림 표 // -->


<!-- [섹션] 오늘/어제/한달간 일어난 일 { -->
<?php 
    // 한달간일어난일/매출요약 출력 섹션 시작
	echo '<section>';
?>
<div class="div_alpha_board1">
<!-- ### 가로 전체 시작 ### -->

    <!-- (가로1) 오늘/어제/한달간 일어난 일 -->
    <div class="box boxwidth11"><!-- 가로1열기 -->

    <div class="tbl_scoreboard3"><!-- [표] 오늘발생한이벤트 { -->
    <table> 
        <thead>
            <tr>
                <th scope="col" colspan="2" style="height:22px; color:#222; background:#fff;"><b>쇼핑몰운영현황</b></th>
                <th scope="col">회원<br>가입</th>
                <th scope="col">회원<br>탈퇴</th>
                <th scope="col">장바<br>구니</th>
                <th scope="col">찜한<br>상품</th>
                <th scope="col">쿠폰존<br>다운</th>
                <th scope="col">상품<br>등록</th>
            </tr>
        </thead>
        <tbody>
            <!-- 오늘 { -->
            <tr style="font-weight:bold;">
                <th scope="col" style="width:24px;background:#FDED80;text-align:center;">오늘</th>
                <th scope="col" style="width:44px;background:#FDED80;color:#222;font-weight:normal;text-align:center;">
                <?php $tweek = array("일", "월", "화", "수", "목", "금", "토"); //오늘의 요일표시 함수?>
                <b><?php echo substr($today, 5, 10);//월-일 만표시 ?></b> (<?php echo $tweek[date("w")];//요일표시?>)
                </th>
                <td style="background:#FFF1CC;"><a href="<?php echo G5_ADMIN_URL; ?>/member_list.php"><?php echo ($today_mship_cnt > 0) ? '<span class="darkgreen">'.number_format($today_mship_cnt).'</span>' : '<span class="gray">-</span>';//[오늘]회원가입?></a></td>
                <td style="background:#FFF1CC;"><a href="<?php echo G5_ADMIN_URL; ?>/member_list.php?sst=mb_leave_date&sod=desc&sfl=&stx="><?php echo ($today_mleave_cnt > 0) ? '<span class="lightpink">'.number_format($today_mleave_cnt).'</span>' : '<span class="gray">-</span>';//[오늘]회원탈퇴?></a></td>
                <td style="background:#FFF1CC;"><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/cartlist_allview.php"><?php echo ($today_cart_cnt > 0) ? '<span class="darkgreen">'.number_format($today_cart_cnt).'</span>' : '<span class="gray">-</span>';//[오늘]장바구니?></a></td>
                <td style="background:#FFF1CC;"><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/wishlist_allview.php"><?php echo ($today_wish_cnt > 0) ? '<span class="darkgreen">'.number_format($today_wish_cnt).'</span>' : '<span class="gray">-</span>';//[오늘]찜?></a></td>
                <td style="background:#FFF1CC;"><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/couponzonelist.php"><?php echo ($today_czone['download'] > 0) ? '<span class="darkgreen">'.number_format($today_czone['download']).'</span>' : '<span class="gray">-</span>';//[오늘]쿠폰다운?></a></td>
                <td style="background:#FFF1CC;"><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/itemlist.php"><?php echo ($today_item_cnt > 0) ? '<span class="darkgreen">'.number_format($today_item_cnt).'</span>' : '<span class="gray">-</span>';//[오늘]상품등록?></a></td>
            </tr>
            <!-- } 오늘 //-->
            <!-- 어제 { -->
            <tr>
                <th scope="col" style="width:24px;text-align:center;">어제</th>
                <th scope="col" style="width:44px;font-weight:normal;text-align:center;">
                <?php echo date('m/d', strtotime('-1 days', G5_SERVER_TIME));?>
                </th>
                <td><a href="<?php echo G5_ADMIN_URL; ?>/member_list.php"><?php echo ($yesterday_mship_cnt > 0) ? number_format($yesterday_mship_cnt) : '<span class="gray">-</span>';//[어제]회원가입?></a></td>
                <td><a href="<?php echo G5_ADMIN_URL; ?>/member_list.php?sst=mb_leave_date&sod=desc&sfl=&stx="><?php echo ($yesterday_mleave_cnt > 0) ? '<span class="lightpink">'.number_format($yesterday_mleave_cnt).'</span>' : '<span class="gray">-</span>';//[어제]회원탈퇴?></a></td>
                <td><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/cartlist_allview.php"><?php echo ($yesterday_cart_cnt > 0) ? number_format($yesterday_cart_cnt) : '<span class="gray">-</span>';//[어제]장바구니?></a></td>
                <td><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/wishlist_allview.php"><?php echo ($yesterday_wish_cnt > 0) ? number_format($yesterday_wish_cnt) : '<span class="gray">-</span>';//[어제]찜?></a></td>
                <td><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/couponzonelist.php"><?php echo ($yesterday_czone['download'] > 0) ? number_format($yesterday_czone['download']) : '<span class="gray">-</span>';//[어제]쿠폰다운?></a></td>
                <td><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/itemlist.php"><?php echo ($yesterday_item_cnt > 0) ? number_format($yesterday_item_cnt) : '<span class="gray">-</span>';//[어제]상품등록?></a></td>
            </tr>
            <!-- } 어제 //-->
            <!-- 이달 (1일~말일) { -->
            <tr>
                <th scope="col" style="width:24px;text-align:center;">이달</th>
                <th scope="col" style="width:44px;color:#222;font-weight:normal;text-align:center;">
                <?php echo substr($moneday, 8, 10);//월-일 만표시 ?> ~ <?php echo substr($mnowday, 8, 10);//월-일 만표시 ?>일                </th>
              <td><a href="<?php echo G5_ADMIN_URL; ?>/member_list.php"><?php echo ($month_mship_cnt > 0) ? number_format($month_mship_cnt) : '<span class="gray">-</span>';//[이달]회원가입?></a></td>
                <td><a href="<?php echo G5_ADMIN_URL; ?>/member_list.php?sst=mb_leave_date&sod=desc&sfl=&stx="><?php echo ($month_mleave_cnt > 0) ? '<span class="lightpink">'.number_format($month_mleave_cnt).'</span>' : '<span class="gray">-</span>';//[이달]회원탈퇴?></a></td>
                <td><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/cartlist_allview.php"><?php echo ($month_cart_cnt > 0) ? number_format($month_cart_cnt) : '<span class="gray">-</span>';//[이달]장바구니?></a></td>
                <td><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/wishlist_allview.php"><?php echo ($month_wish_cnt > 0) ? number_format($month_wish_cnt) : '<span class="gray">-</span>';//[이달]찜?></a></td>
                <td><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/couponzonelist.php"><?php echo ($month_czone['download'] > 0) ? number_format($month_czone['download']) : '<span class="gray">-</span>';//[이달]쿠폰다운?></a></td>
                <td><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/itemlist.php"><?php echo ($month_item_cnt > 0) ? number_format($month_item_cnt) : '<span class="gray">-</span>';//[이달]상품등록?></a></td>
            </tr>
            <!-- } 이달(1일~말일) //--> 
        </tbody>
    </table>
    </div><!-- [표] 오늘발생한이벤트 끝// -->

    </div><!-- 가로1닫기 //-->
    <!--//-->
    
    
    <!-- (가로2) 매출요약 -->
    <div class="box boxwidth11"><!-- 가로1열기 -->

    <div class="tbl_scoreboard3"><!-- [표] 오늘발생한이벤트 { -->
    <table> 
        <thead>
            <tr>
                <th scope="col" colspan="2" style="height:22px; color:#222; background:#fff;"><b>주문/매출현황</b></th>
                <!--<th scope="col">입금<br>완료</th>-->
                <th scope="col">매출<br>발생</th>
                <th scope="col">주문<br>금액</th>
                <th scope="col">취소환불</th>
            </tr>
        </thead>
        <tbody>

            <!-- 오늘 { -->
            <tr style="font-weight:bold;">
                <th scope="col" style="width:24px;background:#FDED80;text-align:center;">오늘</th>
                <th scope="col" style="width:44px;background:#FDED80;color:#222;font-weight:normal;text-align:center;">
                <?php $tweek = array("일", "월", "화", "수", "목", "금", "토"); //오늘의 요일표시 함수?>
                <b><?php echo substr($today, 5, 10);//월-일 만표시 ?></b> (<?php echo $tweek[date("w")];//요일표시?>)
                </th>
                <!--<td style="background:#FFF1CC;"><a href="<?php echo $main_infotoday_receipt['href'];?>"> <?php echo ($main_infotoday_receipt['price'] > 0) ? number_format($main_infotoday_receipt['price']) : '<b style="color:#eaeaea;">O</b>';//오늘입금?></a></td>-->
                <td style="background:#FFF1CC;"><a href="<?php echo $main_infotoday_sale['href'];?>"> <?php echo ($main_infotoday_sale['price'] > 0) ? number_format($main_infotoday_sale['price']) : '<b style="color:#eaeaea;">O</b>';//오늘매출?></a></td>
                <td class="lightpink" style="background:#FFF1CC;"><a href="<?php echo $infotoday['href'];?>"> <?php echo ($infotoday['price'] > 0) ? number_format($infotoday['price']) : '<b style="color:#eaeaea;">O</b>';//오늘주문?><?php echo ($infotoday['count'] > 0) ? '<span class="gray">('.$infotoday['count'].')</span>' : '';//건수?></a></td>
                <td style="background:#FFF1CC;"><?php echo ($main_infotoday_cancle['price'] > 0) ? number_format($main_infotoday_cancle['price']) : '<b style="color:#eaeaea;">O</b>';//오늘취소?> <?php echo ($main_infotoday_cancle['count'] > 0) ? '<span class="gray">('.$main_infotoday_cancle['count'].')</span>' : '';//건수?></td>
            </tr>
            <!-- } 오늘 //-->
            
            <!-- 어제 { -->
            <tr>
                <th scope="col" style="width:24px;text-align:center;">어제</th>
                <th scope="col" style="width:44px;font-weight:normal;text-align:center;">
                <?php echo date('m/d', strtotime('-1 days', G5_SERVER_TIME));?>
                </th>
                <!--<td><a href="<?php echo $main_infoyesterday_receipt['href'];?>"> <?php echo ($main_infoyesterday_receipt['price'] > 0) ? number_format($main_infoyesterday_receipt['price']) : '<b style="color:#eaeaea;">O</b>';//어제입금?></a></td>-->
                <td><a href="<?php echo $main_infoyesterday_sale['href'];?>"> <?php echo ($main_infoyesterday_sale['price'] > 0) ? number_format($main_infoyesterday_sale['price']) : '<b style="color:#eaeaea;">O</b>';//어제매출?></a></td>
                <td><a href="<?php echo $infoyesterday['href'];?>"> <?php echo ($infoyesterday['price'] > 0) ? number_format($infoyesterday['price']) : '<b style="color:#eaeaea;">O</b>';//어제주문?><?php echo ($infoyesterday['count'] > 0) ? '<span class="gray">('.$infoyesterday['count'].')</span>' : '';//건수?></a></td>
                <td class="lightpink"><?php echo ($main_infoyesterday_cancle['price'] > 0) ? number_format($main_infoyesterday_cancle['price']) : '<b style="color:#eaeaea;">O</b>';//어제취소?> <?php echo ($main_infoyesterday_cancle['count'] > 0) ? '<span class="gray">('.$main_infoyesterday_cancle['count'].')</span>' : '';//건수?></td> 
            </tr>
            <!-- } 어제 //-->
            
            <!-- 이달 (1일~말일) { -->
            <tr>
                <th scope="col" style="width:24px;text-align:center;">이달</th>
                <th scope="col" style="width:44px;color:#222;font-weight:normal;text-align:center;">
                <?php echo substr($moneday, 8, 10);//월-일 만표시 ?> ~ <?php echo substr($mnowday, 8, 10);//월-일 만표시 ?>일                </th>
              <!--<td><a href="<?php echo $main_infomonth_receipt['href'];?>"> <?php echo ($main_infomonth_receipt['price'] > 0) ? number_format($main_infomonth_receipt['price']) : '<b style="color:#eaeaea;">O</b>';//이번달입금?></a></td>-->
                <td><a href="<?php echo $infomonth_sale['href'];?>"> <?php echo ($infomonth_sale['price'] > 0) ? number_format($infomonth_sale['price']) : '<b style="color:#eaeaea;">O</b>';//이번달매출?></a></td>
                <td><a href="<?php echo $infomonth['href'];?>"> <?php echo ($infomonth['price'] > 0) ? number_format($infomonth['price']) : '<b style="color:#eaeaea;">O</b>';//이번달주문?><?php echo ($infomonth['count'] > 0) ? '<span class="gray">('.$infomonth['count'].')</span>' : '';//건수?></a></td>
                <td class="lightpink"><?php echo ($infomonth_cancle['price'] > 0) ? number_format($infomonth_cancle['price']) : '<b style="color:#eaeaea;">O</b>';//이번달취소?><?php echo ($infomonth_cancle['count'] > 0) ? '<span class="gray">('.$infomonth_cancle['count'].')</span>' : '';//건수?></td>
            </tr>
            <!-- } 이달(1일~말일) //-->
            
        </tbody>
    </table>
    </div><!-- [표] 오늘발생한이벤트 끝// -->

    </div><!-- 가로1닫기 //-->
    <!--//-->

<!-- ### 가로전체 끝 ### -->
</div>
<?php 
	echo '</section>';
    // 한달간일어난일/매출요약 출력 섹션 시작
?>
<!-- [섹션] 오늘/어제/한달간 일어난 일 끝 // -->
