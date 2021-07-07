<?php
if (!defined('_GNUBOARD_')) exit;
include_once('./_common.php');
#######################################################################################
/* 관리자모드 메인 페이지에 회원관련 최근게시물 표시 [아이스크림 소스] */
// 삽입함수 include_once(G5_ADMIN_PATH.'/index.inc.tab_mb.php');
// [JS쿼리] adm/js/icecream.js 파일에 탭메뉴활성화를 위한 j쿼리소스있음
// 관리자메인/그외페이지에 출력 가능
// 회원가입/포인트/주문/상품 등 알림과 관련된 최근등록기준으로 추력
#######################################################################################
?>
<!-- CSS 시작 -->
<style>
/*탭*/
#mbmove_tab{padding:0px}
#mbmove_tab .tabsTit {border-bottom:1px solid #ddd;background:#f7f7f7;font-size:0;text-align:center;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
#mbmove_tab .tabsTit h2 {position:absolute;font-size:0;line-height:0;overflow:hidden}
#mbmove_tab .tabsTit li{display:inline-block;line-height:50px;padding:0 6px 0; border-bottom: 4px solid #fff;font-size: 13px; letter-spacing:-1px; cursor:pointer;}
#mbmove_tab .tabsTita{display:block}
#mbmove_tab .tabsTit .tabsHover{  border-color:#8183c3;color: #8183c3;font-weight: bold;}
#mbmove_tab .tabsCon { list-style:none; padding:0; margin:0;}
#mbmove_dvex{height:auto;margin:20px 0 }
#mbmove_dvex:after {display:block;visibility:hidden;clear:both;content:""}
#mbmove_dvex h3{margin-bottom:10px;}
#mbmove_dvr{float:left;width:49%;text-align:left;background:#f1f1f1;padding:20px;min-height:200px;line-height:1.5em}
#mbmove_ex{float:right;width:49%;text-align:left;background:#f1f1f1;padding:20px;min-height:200px;line-height:1.5em}

/* 회원가입 */
#mbmove_register {margin:0 0 0px;padding:25px 15px 20px;}

/* 회원포인트사용 */
#mbmove_point {margin:0 0 0px;padding:25px 15px 20px;}

/* 회원장바구니 */
#mbmove_cart {margin:0 0 0px;padding:25px 15px 20px;}

/* 회원위시리스트 */
#mbmove_wish {margin:0 0 0px;padding:25px 15px 20px;}
</style>
<!-- CSS 끝 //-->

<!-- [JS쿼리] adm/js/icecream.js 파일에 탭메뉴활성화를 위한 j쿼리소스있음 -->

<!-- [탭] 알림관련 최근게시물 표시 시작 { -->
<div id="mbmove_tab" class="tab-wr">
    <ul class="tabsTit">
        <li class="tabsTab tabsHover tab-first">회원가입 <?php echo ($today_mship_cnt > 0) ? '<span class="orangered font-13 font-bold">'.number_format($today_mship_cnt).'</span>' : '';//오늘 회원가입 수?></li>
        <li class="tabsTab">회원포인트</li>
        <li class="tabsTab">장바구니 <?php echo ($today_cart_cnt > 0) ? '<span class="orangered font-13 font-bold">'.number_format($today_cart_cnt).'</span>' : '';//오늘 장바구니 담은수?></li>
        <li class="tabsTab tab-last">회원찜 <?php echo ($today_wish_cnt > 0) ? '<span class="orangered font-13 font-bold">'.number_format($today_wish_cnt).'</span>' : '';//오늘 위시리스트 담은수?></li>
    </ul>
    <ul class="tabsCon">

        <!-- (1) 회원가입 시작 { -->
        <li id="mbmove_register" class="tabsList">
        <!-- [최신글]회원가입 시작 -->
        <div class="member_latest1">
            <ul>
                <?php //회원목록
                $sql = " select * from {$g5['member_table']}
						  order by mb_datetime desc
                          limit 4 "; // 최대 4개 출력
                $result = sql_query($sql);
				
                for ($i=0; $row=sql_fetch_array($result); $i++)
                {
                    $name = get_sideview($row['mb_id'], get_text($row['mb_nick']), $row['mb_email'], $row['mb_homepage']);
                   
				    // 당일인 경우 시간으로 표시함 시작
                    $mb_datetime = substr($row['mb_datetime'],0,10);
                    $mb_datetime2 = $row['mb_datetime'];
                    if ($mb_datetime == G5_TIME_YMD)
                        $mb_datetime2 = '<span class=today_date><b>'.substr($mb_datetime2,11,5).'</b> 오늘가입</span>'; //오늘등록(시간만표시)
                    else
                        $mb_datetime2 = substr($mb_datetime2,0,16); //월-일 표시
				    // 당일인 경우 시간으로 표시함 끝
				?>
                <li>  
                    <!-- 회원아이디정보 -->
                    <span class="memberid"><a href="<?php echo G5_ADMIN_URL; ?>/member_form.php?sst=&sod=&sfl=&stx=&page=&w=u&mb_id=<?php echo $row['mb_id']; ?>" target="_blank" title="회원정보 바로가기"><?php echo $row['mb_id'];//회원아이디?></a></span>
                    <span class="lightgray">|</span>&nbsp;<span class="membername" title="이름"><span class="gray font-11">이름</span> <?php echo get_text($row['mb_name']); ?></span>
                    <span class="lightgray">|</span>&nbsp;<span class="memberlevel"><span class="gray font-11 font-normal">등급</span> <?php echo $row['mb_level']; ?></span>
                    
                    <?php echo ($row['mb_hp']) ? '<span class="lightgray">|</span>&nbsp;<span class=membertel>'.$row['mb_hp'].'</span>' : '<span class="lightgray">|</span>&nbsp;<span class="gray font-11 font-normal">휴대폰없음</span>';//휴대폰전화?>
                    <br>
                    <!-- // -->
                    <!-- 가입승인/포인트정보 -->
					<?php echo ($row['mb_email_certify']) ? '<span class=memberok>승인완료</span>' : '<span class=membernotok>승인대기</span>';?>
                    <?php echo ($row['mb_point'] == '0') ? '<span class="lightgray">|</span>&nbsp;<span class="memberpoint" title="포인트">0</span>' : '<span class="lightgray">|</span>&nbsp;<span class="gray font-11 font-normal">포인트</span> <span class="memberpoint" title="포인트">'.number_format($row['mb_point']).'</span>';?>
                    <?php echo ($row['mb_email']) ? '<span class="lightgray">|</span>&nbsp;<span class=membermail font-10>'.$row['mb_email'].'</span>' : '<span class="lightgray">|</span>&nbsp;<span class="gray font-11 font-normal">이메일없음</span>';//이메일?>
                    <!-- // -->
                    <!-- 주소정보 -->
					<?php if($row['mb_zip1']) { //우편번호가 있을경우 주소표시 ?>
                        <br>
                        <span class="memberaddr">
						    [ <?php echo $row['mb_zip1'];?><?php echo $row['mb_zip2'];?> ] <?php echo $row['mb_addr1'];?> , <?php echo $row['mb_addr2'];?> <?php// echo $row['mb_addr3'];?>
                        </span>
                    <?php } //닫기 ?>
                    <br>
                    <!-- // -->
                    <!-- 가입일 -->
                    <span class="nickname"><?php echo $name;//닉네임?></span>
                    <span class="date"><?php echo $mb_datetime2;//회원가입일?></span>
                    <!-- // -->
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">회원정보가 없습니다.</li>';
                ?>
            </ul>
        </div>
        <div class="pull-right"><a href="<?php echo G5_ADMIN_URL;?>/member_list.php"><span class="font-11 lightviolet">회원 전체보기</span></a></div>
        <!-- [최신글]회원가입 끝 //-->
        </li>
        <!-- } (1) 회원가입 끝 -->
        
        
        <!-- (2) 회원포인트사용 시작 { -->
        <li id="mbmove_point" class="tabsList">
        <!-- [최신글]회원포인트사용 시작 -->
        <div class="member_latest1">
            <ul>
                <?php //포인트목록
                $sql = " select * from {$g5['point_table']}
						  order by po_id desc
                          limit 6 "; // 최대 6개 출력
                $result = sql_query($sql);
				$row2['mb_id'] = '';
				
                for ($i=0; $row=sql_fetch_array($result); $i++)
                {
                    if ($row2['mb_id'] != $row['mb_id']) {
                        $sql2 = " select mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_point, mb_hp, mb_level from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
                        $row2 = sql_fetch($sql2);
						}
					$name = get_sideview($row['mb_id'], get_text($row2['mb_nick']), $row2['mb_email'], $row2['mb_homepage']);

					// 당일인 경우 시간으로 표시함 시작
                    $po_datetime = substr($row['po_datetime'],0,10);
                    $po_datetime2 = $row['po_datetime'];
                    if ($po_datetime == G5_TIME_YMD)
                        $po_datetime2 = '<span class=today_date>'.substr($po_datetime2,11,5).' 오늘발생</span>'; //오늘등록(시간만표시)
                    else
                        $po_datetime2 = substr($po_datetime2,0,10); //월-일 표시
				    // 당일인 경우 시간으로 표시함 끝
					
					// 글자수 자르기 설정
				    $row['po_content'] = cut_str($row['po_content'],15); //제목
					$row2['mb_name'] = cut_str($row2['mb_name'],5); //회원이름
				?>
                <li>  
                    <!-- 포인트박스 시작 -->
                    <?php if ($row['po_point'] > 0) { //포인트양수일때?>
					    <div class="point-plus"><?php echo number_format($row['po_point']) ?></div>
                    <?php } else { //포인트음수일때?>
                        <div class="point-minus"><?php echo number_format($row['po_point']) ?></div>
                    <?php } //포인트닫기?>
                    <!-- 포인트박스 끝 //-->
                    
                    <div class="pointtool">
                    
                    <!-- 포인트발생내역 -->
                     <?php if ($row['po_point'] > 0) { //포인트양수일때?>
					    <span class="blue"><a href="./point_list.php?sfl=mb_id&amp;stx=<?php echo $row['po_id'] ?>"><?php echo $row['po_content']; ?></a></span>
                    <?php } else { //포인트음수일때?>
                        <span class="cate"><a href="./point_list.php?sfl=mb_id&amp;stx=<?php echo $row['po_id'] ?>"><?php echo $row['po_content']; ?></a></span>
                    <?php } //포인트닫기?>
                    &nbsp;&nbsp;<span class="date"><?php echo $po_datetime2;//포인트발생일?></span>
                    <br>
                    <!-- // -->
                    
                    <!-- 회원아이디정보 -->
                    <span class="nickname"><?php echo $name;//닉네임?></span>
                    <span class="lightgray">|</span>&nbsp;<a href="<?php echo G5_ADMIN_URL; ?>/member_form.php?sst=&sod=&sfl=&stx=&page=&w=u&mb_id=<?php echo $row2['mb_id']; ?>" target="_blank" title="회원정보 바로가기"><span class="memberid"><?php echo $row2['mb_id'];//회원아이디?></span></a>
                    <span class="lightgray">|</span>&nbsp;<span class="membername" title="이름"><?php echo get_text($row2['mb_name']); ?></span>
                    <span class="lightgray">|</span>&nbsp;<span class="memberlevel"><?php echo $row2['mb_level']; ?></span>
                    <!-- // -->
                    
                    </div>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">회원정보가 없습니다.</li>';
                ?>
            </ul>
        </div>
        <div class="pull-right"><a href="<?php echo G5_ADMIN_URL;?>/point_list.php"><span class="font-11 lightviolet">포인트 전체보기</span></a></div>
        <!-- [최신글]회원포인트사용 끝 //-->
        </li>
        <!-- } (2)회원포인트사용 끝 -->
        
        
        <!-- (3) 장바구니 시작 { -->
        <li id="mbmove_cart" class="tabsList">
        <!-- [최신글]장바구니 시작 -->
        <div class="latest_zine">
            <ul>
                <?php //장바구니에 담기만한 상품관리
               $sql = " select * from {$g5['g5_shop_cart_table']}
						  where ct_status = '쇼핑'
						  order by ct_time desc
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
                   
				    // 당일인 경우 시간으로 표시함 시작
                    $ct_time = substr($row['ct_time'],0,10);
                    $ct_time2 = $row['ct_time'];
                    if ($ct_time == G5_TIME_YMD)
                        $ct_time2 = '<span class=today_date>'.substr($ct_time2,11,5).'</span>';
                    else
                        $ct_time2 = substr($ct_time2,0,16);
				    // 당일인 경우 시간으로 표시함 끝
					
					// 총합계계산 (기본/추가옵션가격 구분)
		            $price = ($row['ct_price'] + $row['io_price']) * $row['ct_qty']; //기본상품,선택옵션 구매금액 
		            $ioprice = $row['io_price'] * $row['ct_qty']; //추가옵션 구매금액
					
					// 글자수 자르기 설정
				    $row['it_name'] = cut_str($row['it_name'],20); //상품명
				?>
                <li>  
                    <div class="toolimg90"><?php echo get_it_image($row['it_id'], 200, 200); ?></div>
                    <div class="tooltool">
                    <?php echo ($row['ct_status'] == '쇼핑') ? '<span class=answer>장바구니추가</span>' : '';?>
                    <!-- 가격표시 -->
					<?php echo ($row['io_type'] == '1') ? '&nbsp;<span class="blue">￦'.number_format($ioprice).'</span>' : '&nbsp;<span class="blue">￦'.number_format($price).'</span>';//추가옵션구매금액 구분 표시 ?>
                    <!--//-->
                    <span class="date">(<b><?php echo number_format($row['ct_qty']); ?></b>개)</span>
                    &nbsp;
                    <?php echo ($row['io_id']) ? '<span class="darkgray font-11"><i class="fa fa-lightbulb-o"></i> '.cut_str($row['io_id'],16).'</span>' : '';?>                   
                    <br>
                    
                    <a href="<?php echo G5_SHOP_URL; ?>/item.php?it_id=<?php echo $row['it_id']; ?>" target="_blank" title="상품페이지 바로가기"><b><?php echo $row['it_id']; ?></b> <?php echo $row['it_name']; ?></a>
                    <br>
                    
                    <span class="writename"><?php echo $name; ?></span>
                    <span class="date"><?php echo $ct_time2; ?></span>
                    </div>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">자료가 없습니다.</li>';
                ?>
            </ul>
        </div>
        <div class="pull-right"><a href="<?php echo G5_ADMIN_URL;?>/shop_admin/cartlist_allview.php"><span class="font-11 lightviolet">장바구니 전체보기</span></a></div>
        <!-- [최신글]장바구니 끝 //-->
        </li>
        <!-- } (3) 장바구니 끝 -->
        
        
        <!-- (4) 위시리스트 시작 { -->
        <li id="mbmove_cart" class="tabsList">
        <!-- [최신글]위시리스트 시작 -->
        <div class="latest_zine">
            <ul>
                <?php //위시리스트에 저장한 상품
               $sql = " select * from {$g5['g5_shop_wish_table']} a 
			              left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
						  order by wi_time desc
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
                   
				    // 당일인 경우 시간으로 표시함 시작
                    $wi_time = substr($row['wi_time'],0,10);
                    $wi_time2 = $row['wi_time'];
                    if ($wi_time == G5_TIME_YMD)
                        $wi_time2 = '<span class=today_date>'.substr($wi_time2,11,5).' 오늘찜함</span>';
                    else
                        $wi_time2 = substr($wi_time2,0,16);
				    // 당일인 경우 시간으로 표시함 끝
					
					// 글자수 자르기 설정
					$row['io_id'] = cut_str($row['io_id'],10); //상품코드
				    $row['it_name'] = cut_str($row['it_name'],20); //상품명
				?>
                <li>  
                    <div class="toolimg90"><?php echo get_it_image($row['it_id'], 200, 200); ?></div>
                    <div class="tooltool">
                    <span class="answer">위시리스트추가</span>
                    &nbsp;<span class="blue">￦<?php echo number_format($row['it_price']); ?></span>
                    &nbsp;
                    <?php echo ($row['io_id']) ? '<span class="darkgray font-11"><i class="fa fa-lightbulb-o"></i> '.cut_str($row['io_id'],16).'</span>' : '';?>                   
                    <br>
                    
                    <a href="<?php echo G5_SHOP_URL; ?>/item.php?it_id=<?php echo $row['it_id']; ?>" target="_blank" title="상품페이지 바로가기"><b><?php echo $row['it_id']; ?></b> <?php echo $row['it_name']; ?></a>
                    <br>
                    
                    <span class="writename"><?php echo $name; ?></span>
                    <span class="date"><?php echo $wi_time2; ?></span>
                    </div>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">자료가 없습니다.</li>';
                ?>
            </ul>
        </div>
        <div class="pull-right"><a href="<?php echo G5_ADMIN_URL;?>/shop_admin/wishlist_allview.php"><span class="font-11 lightviolet">찜상품 전체보기</span></a></div>
        <!-- [최신글]위시리스트 끝 //-->
        </li>
        <!-- } (4) 위시리스트 끝 -->


        </ul>
    </div>
<!-- [탭] 알림관련 최근게시물 표시 끝 // -->

<!-- [JS쿼리] 탭메뉴 시작 { -->
<script>
$("#mbmove_tab").UblueTabs({
    eventType:"click"
});

$(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        document.location.reload();
    }
});
</script>
<!-- [JS쿼리] 탭메뉴 끝 // -->

<div style="height:20px;"><!--칸띄우기--></div>


