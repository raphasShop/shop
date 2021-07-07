<?php
include_once('./_common.php');

##################################################
// 소셜로그인 디버그 파일 24시간 지난것은 삭제
##################################################
@include_once('./safe_check.php');
if(function_exists('social_log_file_delete')){
    social_log_file_delete(86400);      //소셜로그인 디버그 파일 24시간 지난것은 삭제
}

##################################################
// 관리자메인과 다른페이지 다르게 노출하기위한
// 메인페이지 구분소스
// if($is_admindex) 로 구분
##################################################
define('_INDEX_', true);
$is_admindex = true;
$is_admmain = true;
##################################################

$g5['title'] = '관리자메인';
include_once ('./admin.head.php');
##################################################
/* 
// 아이스크림만의 관리자메인 데이터 인크루드
// 모든페이지 노출되는것은 admin.head.php 파일에 적용
*/
##################################################
// [취소신청] 취소진행중 표시 - 반품/환불/교환 신청 및 진행중 표시 [아이스크림소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_ordercancle.php');
##################################################

$new_member_rows = 5;
$new_point_rows = 5;

$sql_common = " from {$g5['member_table']} ";
$sql_search = " where (1) ";
if ($is_admin != 'super')
    $sql_search .= " and mb_level <= '{$member['mb_level']}' ";
if (!$sst) {
    $sst = "mb_datetime";
    $sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$new_member_rows} ";
$result = sql_query($sql);

$colspan = 12;

###############################################################################################
/* 결제수단별 합계 [아이스크림소스]*/
###############################################################################################
// 일자별 결제수단 주문 합계 금액
function get_order_settle_sum($date)
{
    global $g5, $default;

    $case = array('신용카드', '계좌이체', '가상계좌', '무통장', '휴대폰');
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
/* 주문 그래프 [아이스크림소스]*/
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

###############################################################################################
/* 관리자 정보 [아이스크림소스]*/
###############################################################################################
// SMS 정보
    if ($config['cf_sms_use'] && $config['cf_icode_id'] && $config['cf_icode_pw']) {
        $userinfo = get_icode_userinfo($config['cf_icode_id'], $config['cf_icode_pw']);
    }
###############################################################################################
?>

<?php
// 메인컨텐츠감싸기 시작
// 메인컨텐츠 가독성을 위해 가로사이즈를 제한(관리자메인페이지만 적용)
echo '<div style="max-width:980px;">';
?>

<!-- [불러오기] 관리자 현황판 -->
<?php include_once(G5_ADMIN_PATH.'/index.inc.tab_main.php');// 관리자 현황판 불러오기?>
<!-- [불러오기] 관리자 현황판// -->

<!-- <div class="line-lightgray"></div> //-->


<?php 
    // 쇼핑몰게시판 출력 섹션 시작
	echo '<section>';
?>
<div class="div_board1">
<!-- ### 가로 전체 시작 ### -->

    <!-- (1단 가로1) [탭] 알림글불러오기표시 -->
    <div class="box boxwidth3" style="padding:0;"><!-- 가로1열기 -->
        <?php include_once(G5_ADMIN_PATH.'/index.inc.tab_cs.php');//알림글불러오기?>
    </div><!-- 가로1닫기 //-->
    <!--//-->
    
    <!-- (1단 가로2) 1:1상담문의 -->
    <div class="box boxwidth9"><!-- 가로1열기 -->
        <h5><i class="fa fa-retweet fa-lg"></i> 1:1상담 <span class="pull-right"><a href="<?php echo G5_BBS_URL;?>/qalist.php" target="_blank"><?php echo ($total_oneqa_count > 0) ? '<span class="orangered font-12 font-normal">대기중인 질문 : <b>'.number_format($total_oneqa_count).'</b> 개</span>' : '<button>전체보기</button>';//1:1상담문의?></a></span></h5>
        <div class="h15"></div>
        <div class="latest2">
            <ul>
                <?php //1:1상담문의
                $sql = " select * from {$g5['qa_content_table']}
                          where qa_type = '0'
                          order by qa_num
                          limit 5 "; // 최대 4개출력
                $result = sql_query($sql);
                for ($i=0; $row=sql_fetch_array($result); $i++)
                {
                    $sql1 = " select * from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
                    $row1 = sql_fetch($sql1);

					if ($row['mb_id'])
				    $name = get_sideview($row['mb_id'], get_text($row['qa_name']), $row1['mb_email'], $row1['mb_homepage']);
				    else
				    $name = '<span class="gray">비회원</span>';
                
				    // 당일인 경우 시간으로 표시함 시작
                    $qa_datetime = substr($row['qa_datetime'],0,10);
                    $qa_datetime2 = $row['qa_datetime'];
                    if ($qa_datetime == G5_TIME_YMD)
                        $qa_datetime2 = '<span class=today_date>'.substr($qa_datetime2,11,5).'</span>';
                    else
                        $qa_datetime2 = substr($qa_datetime2,0,16);
				    // 당일인 경우 시간으로 표시함 끝
					
					// 글자수 자르기 설정
					$row['qa_category'] = cut_str($row['qa_category'],20); //카테고리
				    $row['qa_subject'] = cut_str($row['qa_subject'],22); //제목
				?>
                <li>  
                    <?php echo ($row['qa_status'] == '0') ? '<span class=noanswer>답변대기</span>' : '<span class=answer>답변완료</span>';?>
                    <?php if($row['qa_category']) { //카테고리가 있을경우 열기 ?>
                        <span class="cate"> <?php echo $row['qa_category']; ?></span>
                    <?php } //카테고리가 있을경우 닫기 ?>
                    <br>
                    <span class="subject"><a href="<?php echo G5_BBS_URL; ?>/qaview.php?qa_id=<?php echo $row['qa_id']; ?>" target="_blank" title="<?php echo $row['qa_subject']; ?>"><?php echo $row['qa_subject']; ?></a></span>
                    <br>
                    <span class="writename"><?php echo $name; ?></span>
                    <span class="date"><?php echo $qa_datetime2; ?></span>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">자료가 없습니다.</li>';
                ?>
            </ul>
        </div>
    </div><!-- 가로2닫기 //-->
    <!--//-->
    
    <!-- (1단 가로3) 최근 주문목록 -->
    <div class="box boxwidth9"><!-- 가로1열기 -->
        <h5><i class="fa fa-credit-card fa-lg"></i> 최근주문목록 <span class="pull-right"><a href="<?php echo G5_ADMIN_URL;?>/shop_admin/orderlist.php"><button>주문전체보기</button></a></span></h5>
        <div class="h20"></div>
        <div class="latest2">
            <ul>
                <?php // 주문내역 주문테이블 전체 출력 (최근주문일순)
               $sql = " select * from {$g5['g5_shop_order_table']}
						  order by od_time desc
                          limit 5 "; // 최대 5개출력
                $result = sql_query($sql);
				
                for ($i=0; $row=sql_fetch_array($result); $i++)
                {
                    $sql1 = " select * from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
                    $row1 = sql_fetch($sql1);

                    if ($row['mb_id'])
					$name = get_sideview($row['mb_id'], get_text($row1['mb_nick']), $row1['mb_email'], $row1['mb_homepage']);
					else
					$name = '<span class="gray">비회원</span>';
					
					// 주문금액(입금전금액계산)
					$od_od_price = $row['od_cart_price'] - $row['od_cart_coupon'] - $row['od_coupon'] - $row['od_send_coupon'] - $row['od_receipt_point'];
                   
				    // 당일인 경우 시간으로 표시함 시작
                    $od_time = substr($row['od_time'],0,10);
                    $od_time2 = $row['od_time'];
                    if ($od_time == G5_TIME_YMD)
                        $od_time2 = '<span class=today_date>'.substr($od_time2,11,5).'</span>';
                    else
                        $od_time2 = substr($od_time2,0,16);
				    // 당일인 경우 시간으로 표시함 끝
					
					// 글자수 자르기 설정
					$row['it_namex'] = cut_str($row['it_namex'],18); //상품명
				?>
                <li>

                    <?php echo ($row['od_status'] == '주문') ? '<span class=noanswer>입금대기</span>' : '<span class=answer>'.$row['od_status'].'</span>';?>
                    &nbsp;<?php echo ($row['od_receipt_price']) ? '<span class="blue">'.number_format($row['od_receipt_price']).'</span>' : '<span class="lightpink">'.number_format($od_od_price).'</span>';?>
                    <span class="date">(상품 <b><?php echo number_format($row['od_cart_count']); ?></b>개)</span>
                    <br>
                    <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/orderform.php?od_id=<?php echo $row['od_id']; ?>" target="_blank" title="[주문서보기] <?php echo $row['it_namex']; ?>"><?php echo $row['od_id']; ?> <span class="font-11 darkgray subject"><?php echo $row['it_namex']; ?></span></a>
                    <br>
                    <span class="writename"><?php echo $name;//회원닉네임?> (<?php echo $row['od_name'];//주문서에 기재한 주문자?>)</span>
                    <span class="date"><?php echo $od_time2; ?></span>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">자료가 없습니다.</li>';
                ?>
            </ul>
        </div>
    </div><!-- 가로3닫기 //-->
    <!--//-->



    <!-- (2단 가로1) [탭] 회원 잠재적구매행동 불러오기표시 -->
    <div class="box boxwidth4" style="padding:0;"><!-- 가로1열기 -->
        <?php include_once(G5_ADMIN_PATH.'/index.inc.tab_mb.php');//알림글불러오기?>
    </div><!-- 가로1닫기 //-->
    <!--//-->
    
    <!-- (2단 가로2) 판매상품 -->
    <div class="box boxwidth8"><!-- 가로1열기 -->
        <h5><i class="fa fa-credit-card fa-lg"></i> 최근에 판매된 상품 <span class="pull-right"><a href="<?php echo G5_ADMIN_URL;?>/shop_admin/orderlist.php"><button>주문내역보기</button></a></span></h5>
        <div class="h25"></div>
        <div class="latest_zine">
            <ul id="today-order-cart" class="ticker">
                <?php //장바구니에서 구매한상품 관리
               $sql = " select * from {$g5['g5_shop_cart_table']}
						  where ct_status != '쇼핑'
						  order by ct_select_time desc
                          limit 15 "; // 최대 15개출력
                $result = sql_query($sql);
				
                for ($i=0; $row=sql_fetch_array($result); $i++)
                {
                    $sql1 = " select * from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
                    $row1 = sql_fetch($sql1);

                    if ($row['mb_id'])
					$name = get_sideview($row['mb_id'], get_text($row1['mb_nick']), $row1['mb_email'], $row1['mb_homepage']);
					else
					$name = '<span class="gray">비회원</span>';
                   
				    // 당일인 경우 시간으로 표시함 시작
                    $ct_select_time = substr($row['ct_select_time'],0,10);
                    $ct_select_time2 = $row['ct_select_time'];
                    if ($ct_select_time == G5_TIME_YMD)
                        $ct_select_time2 = '<span class=today_date>'.substr($ct_select_time2,11,5).'</span>';
                    else
                        $ct_select_time2 = substr($ct_select_time2,0,16);
				    // 당일인 경우 시간으로 표시함 끝
					
					// 총합계계산 (기본/추가옵션가격 구분)
		            $price = ($row['ct_price'] + $row['io_price']) * $row['ct_qty']; //기본상품,선택옵션 구매금액 
		            $ioprice = $row['io_price'] * $row['ct_qty']; //추가옵션 구매금액
				?>
                <li>  
                    <div class="toolimg90"><?php echo get_it_image($row['it_id'], 200, 200); ?></div>
                    <div class="tooltool">
                    <?php echo ($row['ct_status'] == '주문') ? '<span class=noanswer>입금대기</span>' : '<span class=answer>'.$row['ct_status'].'</span>';?>
                    <!-- 가격표시 -->
					<?php echo ($row['io_type'] == '1') ? '&nbsp;<span class="blue">￦'.number_format($ioprice).'</span>' : '&nbsp;<span class="blue">￦'.number_format($price).'</span>';//추가옵션구매금액 구분 표시 ?>
                    <!--//-->
                    <span class="date">(구매수량<b><?php echo number_format($row['ct_qty']); ?></b>개)</span>
                   
                    <br>
                    
                    <a href="<?php echo G5_SHOP_URL; ?>/item.php?it_id=<?php echo $row['it_id']; ?>" target="_blank" title="<?php echo $row['it_name']; ?>"><span class="subject"><?php echo conv_subject($row['it_name'],24,'..'); ?></span></a>
                    <br>
                    
                    <span class="writename"><?php echo $name; ?></span>
                    <span class="date"><?php echo $ct_select_time2; ?></span>
                    </div>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">자료가 없습니다.</li>';
                ?>
            </ul>
        </div>
        <script><!-- 자동롤링 js쿼리 시작 -->
            function ticker(){
                $('#today-order-cart li:first').slideUp( function(){
                    $(this).appendTo($('#today-order-cart')).slideDown();
                });
            }
            setInterval(function(){ticker()}, 3000);
        </script><!-- 자동롤링 js쿼리 끝// -->
    </div><!-- 가로2닫기 //-->
    <!--//-->
    
    <!-- (2단 가로3) 쿠폰 -->
    <div class="box boxwidth9"><!-- 가로1열기 -->
        <h5><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/couponlist.php" title="쿠폰 전체보기"><i class="fa fa-chevron-circle-down fa-lg"></i> 할인쿠폰<span class="lightpink font-11 font-normal">(쿠폰존제외)</span></a></h5>
        <div class="latest2">
            <ul>
                <?php // 할인쿠폰 출력 (종료일 지나지않은것만 출력)
               $sql = " select * from {$g5['g5_shop_coupon_table']}
						  where cp_end >= '".G5_TIME_YMD."'
						  order by cp_no desc
                          limit 5 "; // 최대 3개출력
                $result = sql_query($sql);
				
                for ($i=0; $row=sql_fetch_array($result); $i++)
                {
				?>
                <li>
                    <div class="tooltool">
                    <?php echo ($row['cp_end'] >= G5_TIME_YMD) ? '<span class=answer>진행중</span>' : '<span class=answer>종료</span>';//진행중표시?>
                    
                    <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/couponform.php?w=u&cp_id=<?php echo $row['cp_id']; ?>" title="[쿠폰수정] <?php echo $row['cp_subject']; //쿠폰제목?>"><span class="subject"><?php echo cut_str($row['cp_subject'],12); //쿠폰제목?></span></a>
                    <br>
                    
                    <span class="blue">
                    <?php echo ($row['cp_type'] == '1') ? '<span class="blue">'.number_format($row['cp_price']).'%</span>' : '<span class="blue">￦'.number_format($row['cp_price']).'</span>';//진행중표시?>
                    </span>
                    <span class="date"><?php echo $row['cp_end']; ?> 까지</span>
                    </div>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list" style="height:120px;">등록된 할인쿠폰이 없습니다.</li>';
                ?>
            </ul>
        </div>
        <!-- // -->
        
        <div class="h10"><!--//--></div>
        
        
    </div><!-- 가로3닫기 //-->
    <!--//-->

<!-- ### 가로전체 끝 ### -->
</div>
<?php 
	echo '</section>';
    // 쇼핑몰게시판 출력 섹션 끝
?>



<?php
    //모바일에서는 않보여지게 숨김 (매출현황/결제수단/그래프) 시작 {
    if(!G5_IS_MOBILE) {
?>
<section><!-- 매출현황요약 시작 -->
<h5><i class="fa fa-bar-chart"></i> 매출현황요약&nbsp;&nbsp;&nbsp;<a href="<?php echo G5_ADMIN_URL;?>/shop_admin/sale1.php"><span class="font-11 font-normal gray">매출분석바로가기</span></a></h5>
    <?php include_once (G5_ADMIN_PATH.'/shop_admin/sale1.include.php');//매출현황요약표?>
</section><!-- 매출현황요약 끝 -->

<section>
<div class="dan-garo-transparent"><!-- 결제 및 기타정보 / 투명배경 -->
    <div class="row"><!-- row 시작 { -->
        
		<div class="dan" style="width:100%"><!-- ### 전체 ### {-->
		    <ul id="li_garo2">
                
                <!-- (2) 두번째 -->
                <li style="width:65%;padding-right:15px;">
                    <div class="tbl_head02">
                    <h5><i class="fa fa-credit-card"></i> 결제수단</h5>
                    <table>
                    <thead>
                    <tr align="center">
                        <th scope="col" rowspan="2">구분</th>
                        <?php
                        $term = 3;
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
                    $case = array('신용카드', '계좌이체', '가상계좌', '무통장', '휴대폰', '포인트', '쿠폰');
            
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
                </li>
                
                <!-- (3) 세번째 -->
                <li style="width:31%;">

                    <section id="anc_sidx_ord">
                    <h5 style="padding-left:10px;"><i class="fa fa-bar-chart"></i> 주문/취소현황 <span class="font-11 font-normal gray">(단위:천원, 데이터:최근일주일)</span></h5>
	                	<?php
                        $arr_order = array();
                        $x_val = array();
                        for($i=6; $i>=0; $i--) {
                            $date = date('Y-m-d', strtotime('-'.$i.' days', G5_SERVER_TIME));

                            $x_val[] = $date;
                            $arr_order[] = get_order_date_sum($date);
                        }

                        $max_y = get_max_value($arr_order);
                        $max_y = ceil(($max_y) / 1000) * 1000;
                        $y_val = array();
                        $y_val[] = $max_y;

                        for($i=4; $i>=1; $i--) {
                            $y_val[] = $max_y * (($i * 2) / 10);
                        }

                        $max_height = 210;
                        $h_val = array();
                        $js_val = array();
                        $offset = 10; // 금액이 상대적으로 작아 높이가 0일 때 기본 높이로 사용
                        foreach($arr_order as $val) {
                            if($val['order'] > 0)
                                $h1 = intval(($max_height * $val['order']) / $max_y) + $offset;
                            else
                                $h1 = 0;

                            if($val['cancel'] > 0)
                                $h2 = intval(($max_height * $val['cancel']) / $max_y) + $offset;
                            else
                                $h2 = 0 ;

                            $h_val['order'][] = $h1;
                            $h_val['cancel'][] = $h2;
                        }
                        ?>

                        <div id="sidx_graph">
                            <ul id="sidx_graph_price">
                                <?php foreach($y_val as $val) { ?>
                                <?php $val_number = number_format($val); //금액을 화폐단위로 수정?>
                                <li><span></span>
								    <?php 
									echo substr($val_number, 0, -4); 
									//금액뒤4자리(쉼표포함) 문자열 자르기
									//(예) 384,580 → 384
									?>
                                </li>
                                <?php } ?>
                            </ul>
                            <ul id="sidx_graph_area">
                                <?php
                                for($i=0; $i<count($x_val); $i++) {
                                    $order_title = '<b style=color:#6DA5D8;>'.date("n월j일", strtotime($x_val[$i])).' 주문</b><br>'.display_price($arr_order[$i]['order']);
                                    $cancel_title = '<b style=color:#C674E7;>'.date("n월j일", strtotime($x_val[$i])).' 취소</b><br>'.display_price($arr_order[$i]['cancel']);
                                    $k = 10 - $i;
                                    $li_bg = 'bg'.($i%2);
                                ?>
                                <li style="z-index:<?php echo $k; ?>">
                                    <div class="graph order" title="<?php echo $order_title; ?>">

                                    </div>
                                    <div class="graph cancel" title="<?php echo $cancel_title; ?>">

                                    </div>
                                </li>
                                <?php } ?>
                            </ul>
                            <ul id="sidx_graph_date">
                                <?php foreach($x_val as $val) { ?>
                                <li><span></span><?php echo substr($val, 5, 5).'<br>'.get_yoil($val).''; ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </section>
                </li>
                
			</ul>
	    </div><!-- } ### 전체 ### -->

    </div><!-- } row 끝 -->
</div><!-- 결제 및 기타정보 / 투명배경 -->
<div class="h15"><!--//--></div>
</section>
<?php   
    }
	// } 모바일에서는 않보여지게 숨김 (매출현황/결제수단/그래프) 끝
?>


<?php 
    // 커뮤니티 최신글 출력 섹션 시작
	echo '<section>';
?>
<div class="div_board1">
<!-- ### 가로 전체 시작 ### -->

    <!-- (가로1) 최근 게시물 -->
    <div class="box boxwidth3"><!-- 가로1열기 -->
        <h5><i class="fa fa-file-text fa-lg"></i> 최근 게시물 <span class="pull-right"><a href="<?php echo G5_BBS_URL ?>/new.php" target="_blank"><button>전체보기</button></a></span></h5>
        <div class="h10"></div>
        <!-- [최신글] 전체게시물 시작 -->
        <div class="latest1">
            <ul>
                <?php //최근게시물 전체 정보가져오기 (new테이블에서 뽑음)
                $sql_common = " from {$g5['board_new_table']} a, {$g5['board_table']} b, {$g5['group_table']} c where a.bo_table = b.bo_table and b.gr_id = c.gr_id and a.wr_id = a.wr_parent ";

                if ($gr_id)
                    $sql_common .= " and b.gr_id = '$gr_id' ";

                $sql_order = " order by a.bn_id desc ";

                $sql = " select count(*) as cnt {$sql_common} ";
                $row = sql_fetch($sql);
                $total_count = $row['cnt'];

                $colspan = 10;
                ?>
                
                <?php //최근게시물 출력하기 (new테이블에서 뽑음)
				
				$new_write_rows = 15; // 출력갯수지정
				
                $sql = " select a.*, b.bo_subject, c.gr_subject, c.gr_id {$sql_common} {$sql_order} limit {$new_write_rows} ";
                $result = sql_query($sql);
                for ($i=0; $row=sql_fetch_array($result); $i++)
                {
                    $tmp_write_table = $g5['write_prefix'] . $row['bo_table'];

                    if ($row['wr_id'] == $row['wr_parent']) // 원글
                    {
                        $comment = "";
                        $comment_link = "";
                        $row2 = sql_fetch(" select * from $tmp_write_table where wr_id = '{$row['wr_id']}' ");

                        $name = get_sideview($row2['mb_id'], get_text(cut_str($row2['wr_name'], $config['cf_cut_name'])), $row2['wr_email'], $row2['wr_homepage']);
                        // 당일인 경우 시간으로 표시함
                        $datetime = substr($row2['wr_datetime'],0,10);
                        $datetime2 = $row2['wr_datetime'];
                        if ($datetime == G5_TIME_YMD)
                            $datetime2 = '<span class=today_date>'.substr($datetime2,11,5).'</span>';
                        else
                            $datetime2 = substr($datetime2,5,5);

                    }
                    else // 코멘트
                    {
                        $comment = '댓글. ';
                        $comment_link = '#c_'.$row['wr_id'];
                        $row2 = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$row['wr_parent']}' ");
                        $row3 = sql_fetch(" select mb_id, wr_name, wr_email, wr_homepage, wr_datetime from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");

                        $name = get_sideview($row3['mb_id'], get_text(cut_str($row3['wr_name'], $config['cf_cut_name'])), $row3['wr_email'], $row3['wr_homepage']);
                        // 당일인 경우 시간으로 표시함
                        $datetime = substr($row3['wr_datetime'],0,10);
                        $datetime2 = $row3['wr_datetime'];
                        if ($datetime == G5_TIME_YMD)
                            $datetime2 = substr($datetime2,11,5);
                        else
                            $datetime2 = substr($datetime2,5,5);
                    }
                ?>
                <li>  
                    <span class="group"><a href="<?php echo G5_BBS_URL ?>/new.php?gr_id=<?php echo $row['gr_id'] ?>" target="_blank"><?php echo cut_str($row['gr_subject'],15,'..') ?></a></span>
                    <span class="cate"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $row['bo_table'] ?>" target="_blank" title="<?php echo $row['bo_subject']; ?>"><?php echo cut_str($row['bo_subject'],15,'..') ?></a></span>
                    <br>
                    <i class="fa fa-file-text"></i> <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $row['bo_table'] ?>&amp;wr_id=<?php echo $row2['wr_id'] ?><?php echo $comment_link ?>" target="_blank" title="<?php echo $row2['wr_subject']; ?> (<?php echo $row2['wr_datetime'];?>)"><?php echo $comment ?><?php echo conv_subject($row2['wr_subject'],34,'..') ?></a>                   
                    <?php echo ($row['as_comment'] > '0') ? '&nbsp;<span class=orangered font-11><b>'.$row['as_comment'].'</b></span>' : ''; //코멘트수표시?>
                    &nbsp;&nbsp;<span class="writename"><?php echo $name; ?></span>
                    <span class="date"><?php echo $datetime2 ?></span>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">자료가 없습니다.</li>';
                ?>
            </ul>
        </div>
    </div><!-- 가로1닫기 //-->
    <!--//-->
    
    <!-- (가로1) 최근 게시물 -->
    <div class="box boxwidth3"><!-- 가로1열기 -->
        <h5><i class="fa fa-comments fa-lg"></i> 최근 댓글 <span class="pull-right"><a href="<?php echo G5_BBS_URL ?>/new.php?gr_id=&view=c" target="_blank"><button>전체보기</button></a></span></h5>
        <div class="h10"></div>
        <div class="latest1">
            <ul>
                <?php //최근 댓글 전체 정보가져오기 (new테이블에서 뽑음)
                $sql_common = " from {$g5['board_new_table']} a, {$g5['board_table']} b, {$g5['group_table']} c where a.bo_table = b.bo_table and b.gr_id = c.gr_id and a.wr_id <> a.wr_parent ";

                if ($gr_id)
                    $sql_common .= " and b.gr_id = '$gr_id' ";

                $sql_order = " order by a.bn_id desc ";

                $sql = " select count(*) as cnt {$sql_common} ";
                $row = sql_fetch($sql);
                $total_count = $row['cnt'];

                $colspan = 10;
                ?>
                
                <?php //최근 댓글 출력하기 (new테이블에서 뽑음)
				
				$new_write_cmt_rows = 15; // 출력갯수지정
				
                $sql = " select a.*, b.bo_subject, c.gr_subject, c.gr_id {$sql_common} {$sql_order} limit {$new_write_cmt_rows} ";
                $result = sql_query($sql);
                for ($i=0; $row=sql_fetch_array($result); $i++)
                {
                    $tmp_write_table = $g5['write_prefix'] . $row['bo_table'];

                    if ($row['wr_id'] == $row['wr_parent']) // 원글
                    {
                        $comment = "";
                        $comment_link = "";
                        $row2 = sql_fetch(" select * from $tmp_write_table where wr_id = '{$row['wr_id']}' ");

                        $name = get_sideview($row2['mb_id'], get_text(cut_str($row2['wr_name'], $config['cf_cut_name'])), $row2['wr_email'], $row2['wr_homepage']);
                        // 당일인 경우 시간으로 표시함
                        $datetime = substr($row2['wr_datetime'],0,10);
                        $datetime2 = $row2['wr_datetime'];
                        if ($datetime == G5_TIME_YMD)
                            $datetime2 = substr($datetime2,11,5);
                        else
                            $datetime2 = substr($datetime2,5,5);

                    }
                    else // 코멘트
                    {
                        $comment = '<i class="fa fa-comments lightgreen"></i> ';
                        $comment_link = '#c_'.$row['wr_id'];
                        $row2 = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$row['wr_parent']}' ");
                        $row3 = sql_fetch(" select mb_id, wr_name, wr_email, wr_content, wr_homepage, wr_datetime from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");

                        $name = get_sideview($row3['mb_id'], get_text(cut_str($row3['wr_name'], $config['cf_cut_name'])), $row3['wr_email'], $row3['wr_homepage']);
                        // 당일인 경우 시간으로 표시함
                        $datetime = substr($row3['wr_datetime'],0,10);
                        $datetime2 = $row3['wr_datetime'];
                        if ($datetime == G5_TIME_YMD)
                            $datetime2 = '<span class=today_date>'.substr($datetime2,11,5).'</span>';
                        else
                            $datetime2 = substr($datetime2,5,5);
                    }
                ?>
                <li>
                    <span class="cate"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $row['bo_table'] ?>" target="_blank" title="<?php echo $row['bo_subject']; ?>"><?php echo cut_str($row['bo_subject'],15,'..') ?></a></span>
                    <br>
                    
                    <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $row['bo_table'] ?>&amp;wr_id=<?php echo $row2['wr_id'] ?><?php echo $comment_link ?>" target="_blank" title="[원글] <?php echo $row2['wr_subject']; ?> (<?php echo $row2['wr_datetime'];?>)"><?php echo $comment ?><?php echo cut_str($row3['wr_content'],22,'..') ?></a>                   

                    &nbsp;&nbsp;<span class="writename"><?php echo $name; ?></span>
                    <span class="date"><?php echo $datetime2 ?></span>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">자료가 없습니다.</li>';
                ?>
            </ul>
        </div>
    </div><!-- 가로1닫기 //-->
    <!--//-->

<!-- ### 가로전체 끝 ### -->
</div>
<?php 
	echo '</section>';
    // 커뮤니티 최신글 출력 섹션 끝
?>

<?php
// 메인컨텐츠감싸기 끝
// 메인컨텐츠 가독성을 위해 가로사이즈를 제한(관리자메인페이지만 적용)
echo "</div>";
?>

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
include_once ('./admin.tail.php');
?>
