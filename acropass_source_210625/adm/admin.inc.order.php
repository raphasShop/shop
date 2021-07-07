<?php
if (!defined('_GNUBOARD_')) exit;
include_once('./_common.php');

#######################################################################################
/* 주문내역 리스트 상단에 표시되는 주문집계표 [크림장수소스] */
// 삽입함수 include_once(G5_ADMIN_PATH.'/admin.inc.order.php');
// 주문리스트/메인/그외페이지에 출력 가능
// 전체주문,PC,모바일,이달,전달 주문합계등 출력
#######################################################################################

$left_today = date("Y-m-d"); //오늘날짜

?>

<!-- [표]전체주문데이터 시작 { -->
<div class="dan-garo-pagetop"><!-- 현재 쇼핑몰 정보 / 투명배경 -->

		<div class="dan"><!-- ### (1) 첫번째칸 ### {-->
		    <ul id="li_garo1">
                <!-- 오늘주문 -->
                <li id="li_garo1_score" onClick="location.href='<?php echo G5_ADMIN_URL.'/shop_admin/orderlist.php?od_term=od_time&fr_date='.urlencode($left_today).'&to_date='.urlencode($left_today); ?>'" style="cursor:pointer;">
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
			</ul>
	    </div><!-- } ### (1) 첫번째칸 ### -->


</div>
<!-- [표]전체주문데이터 끝 { -->
