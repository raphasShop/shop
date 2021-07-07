<?php
include_once('./_common.php');
include_once(G5_EDITOR_LIB);
$g5['title'] ='TODAY 실시간 쇼핑몰관리 알림창 팝업';
include_once(G5_ADMIN_PATH.'/admin.head.sub.php');

##################################################
/* 
// 아이스크림 만의 관리자메인 데이터 인크루드
// 모든페이지 노출되는것은 admin.head.php 파일에 적용
*/
##################################################
// 일자별 주문 합계 표시 [아이스크림 소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_orderdate.php');
// 주문 상태별 합계 표시 [아이스크림 소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_order.php');
// 오늘 처리 할일 / 승인 및 답변, 재고확인등 처리해야 할 알림 정보 [아이스크림 소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_alim.php');
// 상품 관련 합계 표시 [아이스크림 소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_item.php');
// 회원 관련 합계 표시 [아이스크림 소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_member.php');
// 잠재 구매 행동 [아이스크림 소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_bigdata.php');
// 오늘 발생한것 알림메세지 [아이스크림 소스] - 2017-10-05 추가됨
include_once(G5_ADMIN_PATH.'/sum/admin.sum_todayalim.php');
// 현재접속자정보 [아이스크림 소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_connect.php');
###################################################


?>
<!-- CSS 시작 -->
<style>
/********************************************************
■ 알림 최신글
********************************************************/
/*탭*/
#alim_tab{padding:0px}
#alim_tab .tabsTit {border-bottom:1px solid #ddd;background:#f7f7f7;font-size:0;text-align:center;}
#alim_tab .tabsTit h2 {position:absolute;font-size:0;line-height:0;overflow:hidden}
#alim_tab .tabsTit li{display:inline-block;line-height:50px;padding:0 14px 0; border-bottom: 4px solid #fff;font-size: 13px; letter-spacing:-1px; cursor:pointer;}
#alim_tab .tabsTita{display:block}
#alim_tab .tabsTit .tabsHover{  border-color:#8183c3;color: #8183c3;font-weight: bold;}
#alim_tab .tabsCon { list-style:none; padding:0; margin:0;}
#alim_dvex{height:auto;margin:20px 0 }
#alim_dvex:after {display:block;visibility:hidden;clear:both;content:""}
#alim_dvex h3{margin-bottom:10px;}
#alim_dvr{float:left;width:49%;text-align:left;background:#f1f1f1;padding:20px;min-height:200px;line-height:1.5em}
#alim_ex{float:right;width:49%;text-align:left;background:#f1f1f1;padding:20px;min-height:200px;line-height:1.5em}

/* 오늘주문 */
#alim_order {margin:0 0 0px;padding:25px 25px 20px;}
/* 1:1상담 */
#alim_1to1 {margin:0 0 0px;padding:25px 25px 20px;}
/* 상품문의 */
#alim_qa {margin:0 0 0px;padding:25px 25px 20px;}
/* 입금확인요청 */
#alim_atmcheck {margin:0 0 0px;padding:25px 25px 20px;}
/* 사용후기 */
#alim_use {margin:0 0 0px;padding:25px 25px 20px;}
/* 결제에러 */
#alim_pgerror {margin:0 0 0px;padding:25px 25px 20px;}
/* 개인결제 */
#alim_ppay {margin:0 0 0px;padding:25px 25px 20px;}

/********************************************************
■ 통합알림카운트
********************************************************/
.alam_alim_none, .alam_alim_none a { margin-left:10px;font-size:5em;color:#888; }
.alam_alim_yes, .alam_alim_yes a {  display:inline-block;color:#111; margin-left:10px;font-size:5em;color:#333; }
.alam_alim_yes .alarm-btn-label, .alam_alim_yes a .alarm-btn-label { position:absolute; display:inline-block; margin-left:-20px; margin-top:-10px; border-radius: 20px;  -webkit-border-radius: 20px; -moz-border-radius: 20px; width:40px; height:40px; line-height:40px !important; font-family: Arial, 'Nanum Gothic', Tahoma, sans-serif; font-weight:800; font-size:24px; font-weight:bold; text-align:center; letter-spacing:-1px; -webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box; }
.alam_none_count, .alam_none_count a { color:#777;font-weight:bold; }
.alam_yes_count, .alam_yes_count a { display:inline;background:#FFF;padding:5px 10px 4px; border:solid 1px #00C73C;text-align:center;color:#00C73C;font-weight:bold;font-size:12px;-moz-border-radius:10px;-webkit-border-radius:10px;border-radius:10px; }
/********************************************************
■ 타이틀
********************************************************/
.pop_h2 { height:40px;margin:0px; padding:0px 15px;font-family: Malgun Gothic,"맑은 고딕",Nanum Gothic,"나눔고딕",AppleGothic,Dotum,"돋움","Helvetica Neue", Helvetica, Arial, sans-serif;font-size:1.2em;color:#2B313F;font-weight:700;letter-spacing:-0.5px;line-height:40px;border-bottom:1px solid #d3d3d3; background-color:#fcfcfc; }
</style>
<!-- CSS 끝 //-->

<!-- 아이스크림 관리자전용 js 삽입 -->
<script type="text/javascript" src="<?php echo G5_ADMIN_URL;?>/js/icecream.js"></script>

<!-- 타이틀표시-->
<div class="pop_h2">
    <a href="javascript:location.reload()" title="새로고침"><i class="fa fa-refresh font-15 skyblue p-lr5"></i></a>
    실시간 쇼핑관리 알림창&nbsp;&nbsp;&nbsp;<span style="font-family:돋움,dotum; font-size:12px; font-weight:normal; color:#666666;">오늘과 어제 발생한건만 알려드립니다</span>
    <div class="pull-right">
	<?php echo $frm_submit; ?>
    <a href="#" onclick="window.close();parent.opener.location.reload();" style="position:absolute; top:0; right:0;  padding:0px 10px; font-family:돋움,dotum; font-size:20px;font-weight:lighter;color:#777;" title="창닫기">×</a>
    </div>
</div>
<!--//-->

<!-- 알림건수표시-->
<div class="center" style="padding:40px 20px 30px;">
                <!-- 쇼핑알림 -->
                <?php if ($todayalim_all > 0) { //오늘 알림건수 있을때?>
                <span class="alam_alim_yes at-tip" data-original-title="<nobr>어제/오늘<br>처리해야할 쇼핑몰업무<br>알림</nobr>" data-toggle="tooltip" data-placement="right" data-html="true">
                    <?php echo ($todayalim_all > 0) ? '<div class="alarm-btn-label bg-skyblue">'.number_format($todayalim_all).'</div>' : '';//알림건수?>    
                    <i class="fa fa-calendar-check-o fa-lg"></i> 
                </span>
                <div style="text-align:center; margin-top:15px;">
				어제/오늘 발생한 <b><?php echo number_format($todayalim_all);?>건</b>의 처리해야할 쇼핑몰업무가 있습니다<br>
                <span class="gray">아래 업무별 목록을 확인해서 처리해주시면 알림목록에서 사라집니다</span>
                </div>
                
                <?php } else { //없을때?>
                <span class="alam_alim_none at-tip cursor" data-original-title="<nobr>어제/오늘<br>처리해야할 쇼핑몰업무<br>알림</nobr>" data-toggle="tooltip" data-placement="right" data-html="true">
                    <i class="fa fa-calendar-check-o fa-lg"></i>
                </span>
                <div style="text-align:center; margin-top:15px;">0건의 알림이 있습니다</div>
                <?php } ?>
                <!--//-->
</div>
<!-- // -->


<!-- [탭] 알림관련 최근게시물 표시 시작 { -->
<div id="alim_tab" class="tab-wr" style="border-top:solid 5px #d5d5d5;">
    <ul class="tabsTit">
        <li class="tabsTab tabsHover tab-first">주문 <?php echo ($toalim_order['count'] > 0) ? '<span class="orangered font-13 font-bold">'.number_format($toalim_order['count']).'</span>' : '';//주문/입금상품?></li>
        <li class="tabsTab">1:1문의 <?php echo ($toalim_1to1['count'] > 0) ? '<span class="orangered font-13 font-bold">'.number_format($toalim_1to1['count']).'</span>' : '';//1:1문의대기중?></li>
        <li class="tabsTab">입금확인 <?php echo ($toalim_atm['count'] > 0) ? '<span class="orangered font-13 font-bold">'.number_format($toalim_atm['count']).'</span>' : '';//입금확인요청대기중?></li>
        <li class="tabsTab">상품문의 <?php echo ($toalim_itemqa['count'] > 0) ? '<span class="orangered font-13 font-bold">'.number_format($toalim_itemqa['count']).'</span>' : '';//상품문의대기중?></li>
        <li class="tabsTab">사용후기 <?php echo ($toalim_itemuse['count'] > 0) ? '<span class="orangered font-13 font-bold">'.number_format($toalim_itemuse['count']).'</span>' : '';//사용후기대기중?></li>
        <li class="tabsTab">개인결제 <?php echo ($toalim_ppay['count'] > 0) ? '<span class="orangered font-13 font-bold">'.number_format($toalim_ppay['count']).'</span>' : '';//개인결제완료?></li>
        <li class="tabsTab tab-last">결제실패 <?php echo ($toalim_pgerror['count'] > 0) ? '<span class="orangered font-13 font-bold">'.number_format($toalim_pgerror['count']).'</span>' : '';//결제실패?></li>
    </ul>
    <ul class="tabsCon">

        <!-- (1) 주문 시작 { -->
        <li id="alim_order" class="tabsList">
        <!-- [최신글]주문,입금상태 시작 -->
        <div class="latest2">
            <ul>
                <?php // 주문내역 주문테이블 전체 출력 (최근주문일순)
               $sql = " select * from {$g5['g5_shop_order_table']}
						  where od_status IN ( '주문', '입금' ) and od_time between '$yesterday 00:00:00' and '$today 23:59:59'
						  order by od_time desc
                          limit 6 "; // 최대 15개출력
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
				?>
                <li>
                    <div class="tooltool">
                    <?php echo ($row['od_status'] == '주문') ? '<span class=noanswer>입금대기</span>' : '<span class=answer>'.$row['od_status'].'</span>';?>
                    &nbsp;<?php echo ($row['od_receipt_price']) ? '<span class="blue">'.number_format($row['od_receipt_price']).'</span>' : '<span class="lightpink">'.number_format($od_od_price).'</span>';?>
                        <span class="date">(상품 <b><?php echo number_format($row['od_cart_count']); ?></b>개)</span><br>

                    <a href="#"  onclick="opener.document.location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/orderform.php?od_id=<?php echo $row['od_id']; ?>'; return false;" title="[주문서보기] <?php echo $row['it_namex']; ?>"><?php echo $row['od_id']; ?> <span class="font-11 darkgray subject"><?php echo cut_str($row['it_namex'],36); ?></span></a><br>

                    <span class="writename"><?php echo $name;//회원닉네임?> (<?php echo $row['od_name'];//주문서에 기재한 주문자?>)</span>
                    <span class="date"><?php echo $od_time2; ?></span>
                    </div>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">어제,오늘 주문(입금)한 상품 중<br>대기중인 주문이 없습니다.</li>';
                ?>
            </ul>
        </div>
        
        <div class="h10"></div>
        <div class="local_desc02">
            ※ 어제/오늘, 무통장입금주문/전자결제완료주문건만 표시됩니다.<br>
            ※ 관리자가 결제확인후 "상품준비중"으로 변경하면 자동으로 실시간 확인 목록에서 사라집니다.<br>
            ※ 어제/오늘 주문건에 대해서만 실시간알림을 해주므로, 전체 주문건의 상태별로 미처리여부를 보시려면 관리자메인이나 주문내역을 보시면 됩니다.
        </div>
        <div class="h10"></div>
        <div class="pull-right"><a href="#" onclick="opener.document.location.href='<?php echo G5_ADMIN_URL;?>/shop_admin/orderlist.php'; return false;"><span class="font-11 lightviolet">주문 전체보기</span></a></div>

        <!-- [최신글]주문/입금상태 끝 //-->
        </li>
        <!-- } (1)주문 끝 -->
        
        
        <!-- (1) 1:1문의 시작 { -->
        <li id="alim_1to1" class="tabsList">
        <!-- [최신글]1:1문의 시작 -->
        <div class="latest2">
            <ul>
                <?php //1:1상담문의
                $sql = " select * from {$g5['qa_content_table']}
                          where qa_status ='0' and qa_datetime between '$yesterday 00:00:00' and '$today 23:59:59'
                          order by qa_num
                          limit 5 "; // 최대 5개출력
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
				?>
                <li>  
                    <?php if($row['qa_category']) { //카테고리가 있을경우 열기 ?>
                        <span class="cate"><?php echo conv_subject($row['qa_category'],20,'..'); ?></span><br>
                    <?php } //카테고리가 있을경우 닫기 ?>
                    <?php echo ($row['qa_status'] == '0') ? '<span class=noanswer>답변대기</span>' : '<span class=answer>답변완료</span>';?>
                    <span class="subject"><a href="<?php echo G5_BBS_URL; ?>/qaview.php?qa_id=<?php echo $row['qa_id']; ?>" target="_blank" title="<?php echo $row['qa_subject']; ?>"><?php echo $row['qa_subject']; ?></a></span><br>
                    <span class="writename"><?php echo $name; ?></span>
                    <span class="date"><?php echo $qa_datetime2; ?></span>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">어제,오늘 등록된 1:1문의 중<br>답변대기중인 1:1문의가 없습니다.</li>';
                ?>
            </ul>
        </div>
        <div class="h10"></div>
        <div class="local_desc02">
            ※ 어제/오늘, 1:1문의에 등록된 질문중 답변이 없는 질문만 표시됩니다.<br>
            ※ 관리자가 확인후 답변을 단 경우에는 자동으로 실시간 확인 목록에서 사라집니다.<br>
            ※ 어제/오늘 1:1문의에 대해서만 실시간알림을 해주므로, 전체 1:1문의 중 답변전인 모든 목록을 보시려면 관리자메인이나 주문내역을 보시면 됩니다.
        </div>
        <div class="h10"></div>
        <div class="pull-right"><a href="<?php echo G5_BBS_URL;?>/qalist.php" target="_blank"><span class="font-11 lightviolet">1:1문의 전체보기</span></a></div>
        <!-- [최신글]1:1문의 끝 //-->
        </li>
        <!-- } (1)1:1문의 끝 -->
        
        
        <!-- (3) 입금확인요청 시작 { -->
        <li id="alim_atmcheck" class="tabsList">
        <!-- [최신글]입금확인요청 시작 -->
        <div class="latest_zine">
            <ul>
                <?php //입금확인요청
               $sql = " select * from {$g5['g5_shop_order_atmcheck_table']} a
			                left join {$g5['g5_shop_item_table']} b on (a.it_id = b.it_id)
			                left join {$g5['member_table']} c on (a.mb_id = c.mb_id)
							where id_confirm ='0' and id_time between '$yesterday 00:00:00' and '$today 23:59:59'
                            order by id_id desc
                            limit 5 "; // 최대 3개출력
               $result = sql_query($sql);
               for ($i=0; $row=sql_fetch_array($result); $i++)
               {
                $sql1 = " select * from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
                $row1 = sql_fetch($sql1);

				if ($row['mb_id'])
				$name = get_sideview($row['mb_id'], get_text($row['id_name']), $row1['mb_email'], $row1['mb_homepage']);
				else
				$name = '<span class="gray">비회원</span>';
                
				// 당일인 경우 시간으로 표시함 시작
                $id_time = substr($row['id_time'],0,10);
                $id_time2 = $row['id_time'];
                if ($id_time == G5_TIME_YMD)
                    $id_time2 = '<span class=today_date>'.substr($id_time2,11,5).'</span>';
                else
                    $id_time2 = substr($id_time2,0,16);
				// 당일인 경우 시간으로 표시함 끝
				?>
                <li>  
                    <div class="toolimg90"><?php echo get_it_image($row['it_id'], 200, 200); ?></div>
					<div class="tooltool">
					<?php echo ($row['id_confirm'] == '0') ? '<span class=noanswer>확인대기</span>' : '<span class=answer>완료</span>';?>
                    <a href="#" onclick="opener.document.location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/atmcheck.php'; return false;" title="<?php echo $row['id_subject']; ?>"><?php echo conv_subject($row['id_subject'],22,'..'); ?></a>
                    <span class="odid">
                    <a href="#" onclick="opener.document.location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/orderform.php?od_id=<?php echo $row['od_id']; ?>'; return false;" title="주문서 바로가기" target="_blank"><span class="gray font-11">(<?php echo $row['od_id']; ?>)</span></a>
                    </span>
                    
                    <br>
                    
                    <?php// echo cut_str($row['it_name'],20); ?>
                    <span class="gray font-11">[<?php echo cut_str($row['od_bank_account'],28); ?>] </span>
                    <span class="acc"><?php echo cut_str($row['id_deposit_name'],8); ?></span>
                    <span class="orangered font-11"><?php echo number_format($row['id_money']); ?></span>
                    
                    <br>
                    <span class="writename"><?php echo $name; ?></span>
                    <span class="date"><?php echo $id_time2; ?></span>
                    </div>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">어제,오늘 입금확인요청 중<br>확인전인 입금확인요청이 없습니다.</li>';
                ?>
            </ul>
        </div>
        <div class="h10"></div>
        <div class="local_desc02">
            ※ 어제/오늘, 입금확인요청건중 관리자가 확인표시하기전것만 표시됩니다.<br>
            ※ 관리자가 확인후 확인표시를 한 경우에는 자동으로 실시간 확인 목록에서 사라집니다.<br>
            ※ 어제/오늘 입금확인요청건에 대해서만 실시간알림을 해주므로, 전체 입금확인요청건 중 확인표시전인 모든 목록을 보시려면 관리자메인이나 주문내역을 보시면 됩니다.
        </div>
        <div class="h10"></div>
        <div class="pull-right"><a href="#" onclick="opener.document.location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/atmcheck.php'; return false;"><span class="font-11 lightviolet">입금확인요청 전체보기</span></a></div>
        <!-- [최신글]입금확인요청 끝 //-->
        </li>
        <!-- } (2) 입금확인요청 끝 -->
        
        
        <!-- (1) 상품문의 시작 { -->
        <li id="alim_qa" class="tabsList">
        <!-- [최신글]상품문의 시작 -->
        <div class="latest_zine">
            <ul>
                <?php //상품문의
               $sql = " select * from {$g5['g5_shop_item_qa_table']} a
                          left join {$g5['g5_shop_item_table']} b on (a.it_id = b.it_id)
						  left join {$g5['member_table']} c on (a.mb_id = c.mb_id)
						  where iq_answer ='' and iq_time between '$yesterday 00:00:00' and '$today 23:59:59'
						  order by iq_id desc
                          limit 5 "; // 최대 7개출력
                $result = sql_query($sql);
				
                for ($i=0; $row=sql_fetch_array($result); $i++)
                {
                    $sql1 = " select * from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
                    $row1 = sql_fetch($sql1);

					if ($row['mb_id'])
					$name = get_sideview($row['mb_id'], get_text($row['iq_name']), $row1['mb_email'], $row1['mb_homepage']);
					else
					$name = '<span class="gray">비회원</span>';
                   
				    // 당일인 경우 시간으로 표시함 시작
                    $iq_time = substr($row['iq_time'],0,10);
                    $iq_time2 = $row['iq_time'];
                    if ($iq_time == G5_TIME_YMD)
                        $iq_time2 = '<span class=today_date>'.substr($iq_time2,11,5).'</span>';
                    else
                        $iq_time2 = substr($iq_time2,0,16);
				    // 당일인 경우 시간으로 표시함 끝
				?>
                <li>  
                    <div class="toolimg90"><?php echo get_it_image($row['it_id'], 200, 200); ?></div>
                    <div class="tooltool">
                    <?php echo ($row['iq_answer'] == '') ? '<span class=noanswer>답변대기</span>' : '<span class=answer>답변완료</span>';?>
                    <a href="#" onclick="opener.document.location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/itemqaform.php?w=u&amp;iq_id=<?php echo $row['iq_id']; ?>'; return false;" title="<?php echo $row['iq_subject']; ?>"><?php echo conv_subject($row['iq_subject'],28,'..'); ?></a>
                    
                    <br><span class="itemid"><a href="<?php echo G5_SHOP_URL; ?>/item.php?it_id=<?php echo $row['it_id']; ?>" onclick="opener.document.location.href='<?php echo G5_SHOP_URL; ?>/item.php?it_id=<?php echo $row['it_id']; ?>'; return false;" title="상품페이지 바로가기"><?php echo $row['it_id']; ?> <?php echo cut_str($row['it_name'],28); ?></a></span>
                    
                    <br>
                    <span class="writename"><?php echo $name; ?></span>
                    <span class="date"><?php echo $iq_time2; ?></span>
                    </div>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">어제,오늘 등록된 상품Q&A 중<br>답변대기중인 상품Q&A가 없습니다.</li>';
                ?>
            </ul>
        </div>
        <div class="h10"></div>
        <div class="local_desc02">
            ※ 어제/오늘, 상품QA에 등록된 질문중 답변이 없는 질문만 표시됩니다.<br>
            ※ 관리자가 확인후 답변을 단 경우에는 자동으로 실시간 확인 목록에서 사라집니다.<br>
            ※ 어제/오늘 상품QA에 대해서만 실시간알림을 해주므로, 전체 상품QA중 답변전인 모든 목록을 보시려면 관리자메인이나 주문내역을 보시면 됩니다.
        </div>
        <div class="h10"></div>
        <div class="pull-right"><a href="#" onclick="opener.document.location.href='<?php echo G5_ADMIN_URL;?>/shop_admin/itemqalist.php'; return false;"><span class="font-11 lightviolet">상품문의 전체보기</span></a></div>
        <!-- [최신글]상품문의 끝 //-->
        </li>
        <!-- } (1)상품문의 끝 -->
        
        <!-- (2) 사용후기 시작 { -->
        <li id="alim_use" class="tabsList">
        <!-- [최신글]사용후기 시작 -->
        <div class="latest_zine">
            <ul>
                <?php //상품후기
               $sql = " select * from {$g5['g5_shop_item_use_table']} a
			                left join {$g5['g5_shop_item_table']} b on (a.it_id = b.it_id)
			                left join {$g5['member_table']} c on (a.mb_id = c.mb_id)
							where is_confirm != '1' and is_time between '$yesterday 00:00:00' and '$today 23:59:59'
                            order by is_id desc
                            limit 5 "; // 최대 5개출력
               $result = sql_query($sql);
               for ($i=0; $row=sql_fetch_array($result); $i++)
               {
                $sql1 = " select * from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
                $row1 = sql_fetch($sql1);
				
				if ($row['mb_id'])
				$name = get_sideview($row['mb_id'], get_text($row['is_name']), $row1['mb_email'], $row1['mb_homepage']);
				else
				$name = '<span class="gray">비회원</span>';
                
				//점수표시
				$is_score = $row['is_score'];
				if ($is_score == '1')
				    $score_name = '<span class=score>매우불만</span>';
				else if ($is_score == '2')
				    $score_name = '<span class=score>불만</span>';
				else if ($is_score == '3')
				    $score_name = '<span class=score>보통</span>';
				else if ($is_score == '4')
				    $score_name = '<span class=score>만족</span>';
				else if ($is_score == '5')
				    $score_name = '<span class=score>매우만족</span>';
				
				// 당일인 경우 시간으로 표시함 시작
                $is_time = substr($row['is_time'],0,10);
                $is_time2 = $row['is_time'];
                if ($is_time == G5_TIME_YMD)
                    $is_time2 = '<span class=today_date>'.substr($is_time2,11,5).'</span>';
                else
                    $is_time2 = substr($is_time2,0,16);
				// 당일인 경우 시간으로 표시함 끝
				?>
                <li>  
                    <div class="toolimg90"><?php echo get_it_image($row['it_id'], 200, 200); ?></div>
					<div class="tooltool">
					<?php echo ($row['is_confirm'] == '0') ? '<span class=noanswer>승인대기</span>' : '<span class=answer>노출중</span>';?>
                    <a href="#" onclick="opener.document.location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/itemuseform.php?w=u&amp;is_id=<?php echo $row['is_id']; ?>'; return false;" title="<?php echo $row['is_subject']; ?>"><?php echo conv_subject($row['is_subject'],28,'..'); ?></a>
                    
                    <br><span class="itemid"><a href="#" onclick="opener.document.location.href='<?php echo G5_SHOP_URL; ?>/item.php?it_id=<?php echo $row['it_id']; ?>'; return false;" title="상품페이지 바로가기"><?php echo $row['it_id']; ?> <?php echo cut_str($row['it_name'],28); ?></a></span>

                    <br>
                    <span class="writename"><?php echo $name; ?></span>
                    <span class="date"><?php echo $is_time2; ?></span>
                    &nbsp;&nbsp;&nbsp;
                    <img src="<?php echo G5_ADMIN_URL; ?>/shop_admin/img/sp<?php echo $row['is_score']; ?>.png" height="12px" align="absmiddle"><?php echo $score_name; ?>
                    
                    </div>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">어제,오늘 등록된 사용후기중<br>승인을 기다리는 사용후기가 없습니다.</li>';
                ?>
            </ul>
        </div>
        <div class="h10"></div>
        <div class="local_desc02">
            ※ 어제/오늘, 상품후기에 등록된 후기중 노출승인전인 후기만 표시됩니다.<br>
            ※ 관리자가 확인후 승인을 한 경우에는 자동으로 실시간 확인 목록에서 사라집니다.<br>
            ※ 어제/오늘 상품후기에 대해서만 실시간알림을 해주므로, 전체 상품후기중 승인전인 모든 목록을 보시려면 관리자메인이나 주문내역을 보시면 됩니다.
        </div>
        <div class="h10"></div>
        <div class="pull-right"><a href="#" onclick="opener.document.location.href='<?php echo G5_ADMIN_URL;?>/shop_admin/itemuselist.php'; return false;"><span class="font-11 lightviolet">사용후기 전체보기</span></a></div>
        <!-- [최신글]사용후기 끝 //-->
        </li>
        <!-- } (2) 사용후기 끝 -->
        
        
        <!-- (3) 개인결제 결제분 시작 { -->
        <li id="alim_ppay" class="tabsList">
        <!-- [최신글]개인결제 시작 -->
        <div class="latest2">
            <ul>
                <?php //입금확인요청
               $sql = " select * from {$g5['g5_shop_personalpay_table']}
			                where pp_receipt_price > '0' and pp_use = '1' and pp_receipt_time between '$today 00:00:00' and '$today 23:59:59'
                            order by pp_id desc
                            limit 5 "; // 최대 3개출력
               $result = sql_query($sql);
               for ($i=0; $row=sql_fetch_array($result); $i++)
               {
                $sql1 = " select * from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
                $row1 = sql_fetch($sql1);

				if ($row['mb_id'])
				$name = get_sideview($row['mb_id'], get_text($row['id_name']), $row1['mb_email'], $row1['mb_homepage']);
				else
				$name = '<span class="gray">비회원</span>';
                
				// 당일인 경우 시간으로 표시함 시작
                $pp_receipt_time = substr($row['pp_receipt_time'],0,10);
                $pp_receipt_time2 = $row['pp_receipt_time'];
                if ($pp_receipt_time == G5_TIME_YMD)
                    $pp_receipt_time2 = '<span class=today_date>'.substr($pp_receipt_time2,11,5).'</span>';
                else
                    $pp_receipt_time2 = substr($pp_receipt_time2,0,16);
				// 당일인 경우 시간으로 표시함 끝
				?>
                <li>  
					<div class="tooltool">
					<?php echo ($row['pp_receipt_price'] !== '0') ? '<span class=noanswer>결제완료</span>' : '<span class=answer>대기중</span>';?>
                    &nbsp;<?php echo ($row['pp_receipt_price']) ? '<span class="blue">'.number_format($row['pp_receipt_price']).'</span>' : '<span class="lightpink">0</span>';?><br>
                    
                    <a href="#"  onclick="opener.document.location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/personalpayform.php?w=u&pp_id=<?php echo $row['pp_id']; ?>'; return false;" title="바로가기"><?php echo $row['pp_id']; ?>&nbsp;<span class="writename"><i class="fa fa-user"></i> <?php echo $row['pp_name']; ?></span>&nbsp;<span class="date"><?php echo $pp_receipt_time2; ?></span></a>
                    </div>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">어제,오늘 결제를 완료한 개인결제 중<br>사이트에 노출중인 개인결제가 없습니다.</li>';
                ?>
            </ul>
        </div>
        <div class="h10"></div>
        <div class="local_desc02">
            ※ 어제/오늘, 개인결제를 완료한것만 표시됩니다.<br>
            ※ 관리자가 확인후 사용안함으로 표시한 경우에는 자동으로 실시간 확인 목록에서 사라집니다.<br>
            ※ 어제/오늘 개인결제를 완료한것만 실시간알림을 해주므로, 전체 개인결제건을 보시려면 관리자메인이나 개인결제목록을 보시면 됩니다.
        </div>
        <div class="h10"></div>
        <div class="pull-right"><a href="#" onclick="opener.document.location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/personalpaylist.php'; return false;"><span class="font-11 lightviolet">개인결제 전체보기</span></a></div>
        <!-- [최신글]개인결제 끝 //-->
        </li>
        <!-- } (2) 개인결제 결제분 끝 -->
        
        
        <!-- (2) 결제오류취소 시작 { -->
        <li id="alim_pgerror" class="tabsList">
        <!-- [최신글]결제오류취소 시작 -->
        <div class="latest2">
            <ul>
               <?php if($toalim_pgerror['count'] > 0) { //개인결제가 있을 경우?>
               <li>
                   <a href="#" onclick="opener.document.location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/inorderlist.php'; return false;" title="결제오류목록가기"><span class="noanswer">결제실패건수있음</span>&nbsp; <span class="orangered">어제,오늘 전자결제 취소 또는 오류로 인한 데이타가 있습니다.</span></a><br>
                   <span class="gray">결제실패목록에서 확인하실 수 있으며, PG사 상점관리페이지에서 결제여부확인하신 후<br>복구 또는 삭제를 하시면 실시간 알림목록에서 사라집니다</span> 
               </li>
               <?php } else { //없을경우?>
               <li class="empty_list">어제,오늘 전자결제 중 결제실패/취소로 인한 오류데이타가 없습니다.</li>
               <?php } ?>
            </ul>
        </div>
        <div class="h10"></div>
        <div class="local_desc02">
            ※ 어제/오늘, 결제실패 목록 중 관리자가 복구하기전것만 표시됩니다.<br>
            ※ 관리자가 확인후 복구를 한 경우에는 자동으로 실시간 확인 목록에서 사라집니다.<br>
            ※ 어제/오늘 결제실패건에 대해서만 실시간알림을 해주므로, 전체 결제실패건 중 확인표시전인 모든 목록을 보시려면 관리자메인이나 결제실패목록을 보시면 됩니다.
        </div>
        <div class="h10"></div>
        <div class="pull-right"><a href="#" onclick="opener.document.location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/inorderlist.php'; return false;"><span class="font-11 lightviolet">결제오류 전체보기</span></a></div>
        <!-- [최신글]결제오류취소 끝 //-->
        </li>
        <!-- } (2) 결제오류취소 끝 -->


        </ul>
    </div>
<!-- [탭] 알림관련 최근게시물 표시 끝 // -->

<!-- [JS쿼리] 탭메뉴 시작 { -->
<script>
$("#alim_tab").UblueTabs({
    eventType:"click"
});

$(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        document.location.reload();
    }
});
</script>
<!-- [JS쿼리] 탭메뉴 끝 // -->

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.sub.php');
?>