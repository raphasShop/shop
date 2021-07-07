<?php
if (!defined('_GNUBOARD_')) exit;
include_once('./_common.php');
#######################################################################################
/* 관리자모드 메인 페이지에 알림관련 최근게시물 표시 [아이스크림 소스] */
// 삽입함수 include_once(G5_ADMIN_PATH.'/index.inc.tab_cs.php');
// [JS쿼리] adm/js/icecream.js 파일에 탭메뉴활성화를 위한 j쿼리소스있음
// 관리자메인/그외페이지에 출력 가능
// 상품문의/사용후기/1:1문의/입금확인요청 등 알림과 관련된 최근게시물을 출력함(대기중인글 숫자로 표시)
#######################################################################################
?>
<!-- CSS 시작 -->
<style>
/*탭*/
#alim_tab{padding:0px}
#alim_tab .tabsTit {border-bottom:1px solid #ddd;background:#f7f7f7;font-size:0;text-align:center; overflow:hidden;text-overflow:ellipsis;white-space:nowrap;} /* [줄바꿈않되게지정] */
#alim_tab .tabsTit h2 {position:absolute;font-size:0;line-height:0;overflow:hidden}
#alim_tab .tabsTit li{display:inline-block;line-height:50px;padding:0 6px 0; border-bottom: 4px solid #fff;font-size: 13px; letter-spacing:-1px; cursor:pointer;}
#alim_tab .tabsTita{display:block}
#alim_tab .tabsTit .tabsHover{  border-color:#8183c3;color: #8183c3;font-weight: bold;}
#alim_tab .tabsCon { list-style:none; padding:0; margin:0;}
#alim_dvex{height:auto;margin:20px 0 }
#alim_dvex:after {display:block;visibility:hidden;clear:both;content:""}
#alim_dvex h3{margin-bottom:10px;}
#alim_dvr{float:left;width:49%;text-align:left;background:#f1f1f1;padding:20px;min-height:200px;line-height:1.5em}
#alim_ex{float:right;width:49%;text-align:left;background:#f1f1f1;padding:20px;min-height:200px;line-height:1.5em}

/* 사용후기 */
#alim_use {margin:0 0 0px;padding:25px 15px 20px;}

/* 상품문의 */
#alim_qa {margin:0 0 0px;padding:25px 15px 20px;}

/* 입금확인요청 */
#alim_atmcheck {margin:0 0 0px;padding:25px 15px 20px;}
</style>
<!-- CSS 끝 //-->

<!-- [JS쿼리] adm/js/icecream.js 파일에 탭메뉴활성화를 위한 j쿼리소스있음 -->

<!-- [탭] 알림관련 최근게시물 표시 시작 { -->
<div id="alim_tab" class="tab-wr">
    <ul class="tabsTit">
        <li class="tabsTab tabsHover tab-first">상품문의 <?php echo ($total_qa_count > 0) ? '<span class="orangered font-13 font-bold">'.number_format($total_qa_count).'</span>' : '';//상품문의대기중?></li>
        <li class="tabsTab">사용후기 <?php echo ($review_alim > 0) ? '<span class="orangered font-13 font-bold">'.number_format($review_alim).'</span>' : '';//사용후기대기중?></li>
        <li class="tabsTab tab-last">입금확인요청 <?php echo ($total_confirm_count > 0) ? '<span class="orangered font-13 font-bold">'.number_format($total_confirm_count).'</span>' : '';//입금확인요청대기중?></li>
    </ul>
    <ul class="tabsCon">

        <!-- (1) 상품문의 시작 { -->
        <li id="alim_qa" class="tabsList">
        <!-- [최신글]상품문의 시작 -->
        <div class="latest_zine">
            <ul>
                <?php //상품문의
               $sql = " select * from {$g5['g5_shop_item_qa_table']} a
                          left join {$g5['g5_shop_item_table']} b on (a.it_id = b.it_id)
						  left join {$g5['member_table']} c on (a.mb_id = c.mb_id)
						  order by iq_id desc
                          limit 5 "; // 최대 5개출력
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
					
					// 글자수 자르기 설정
					$row['iq_subject'] = cut_str($row['iq_subject'],20); //제목
					$row['it_name'] = cut_str($row['it_name'],22); //상품명
				?>
                <li>  
                    <div class="toolimg90"><?php echo get_it_image($row['it_id'], 200, 200); ?></div>
                    <div class="tooltool">
                        <?php echo ($row['iq_answer'] == '') ? '<span class=noanswer>답변대기</span>' : '<span class=answer>답변완료</span>';?>
                        <span class="subject"><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/itemqaform.php?w=u&amp;iq_id=<?php echo $row['iq_id']; ?>" title="<?php echo $row['iq_subject']; ?>"><?php echo $row['iq_subject']; ?></a></span>
                        <br>
                        <span class="itemid"><a href="<?php echo G5_SHOP_URL; ?>/item.php?it_id=<?php echo $row['it_id']; ?>" target="_blank" title="상품페이지 바로가기"><?php echo $row['it_id']; ?> <?php echo $row['it_name']; ?></a></span>
                        <br>
                        <span class="writename"><?php echo $name; ?></span>
                        <span class="date"><?php echo $iq_time2; ?></span>
                    </div>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">자료가 없습니다.</li>';
                ?>
            </ul>
        </div>
        <div class="pull-right"><a href="<?php echo G5_ADMIN_URL;?>/shop_admin/itemqalist.php"><span class="font-11 lightviolet">상품문의 전체보기</span></a></div>
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
                
				// 점수표시
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
				
				// 글자수 자르기 설정
				$row['is_subject'] = cut_str($row['is_subject'],20); //제목
				$row['it_name'] = cut_str($row['it_name'],22); //상품명 
				?>
                <li>  
                    <div class="toolimg90"><?php echo get_it_image($row['it_id'], 200, 200); ?></div>
					<div class="tooltool">
				        <?php echo ($row['is_confirm'] == '0') ? '<span class=noanswer>승인대기</span>' : '<span class=answer>노출중</span>';?>
                        <span class="subject"><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/itemuseform.php?w=u&amp;is_id=<?php echo $row['is_id']; ?>"  title="<?php echo $row['is_subject']; ?>"><?php echo $row['is_subject']; ?></a></span>
                    
                        <br>
                        <span class="itemid"><a href="<?php echo G5_SHOP_URL; ?>/item.php?it_id=<?php echo $row['it_id']; ?>" target="_blank" title="상품페이지 바로가기"><?php echo $row['it_id']; ?> <?php echo $row['it_name']; ?></a></span>
                        <br>
                        <span class="writename"><?php echo $name; ?></span>
                        <span class="date"><?php echo $is_time; ?></span>
                        &nbsp;&nbsp;&nbsp;
                        <img src="<?php echo G5_ADMIN_URL; ?>/shop_admin/img/sp<?php echo $row['is_score']; ?>.png" height="12px" align="absmiddle"><?php echo $score_name; ?>
                    </div>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">자료가 없습니다.</li>';
                ?>
            </ul>
        </div>
        <div class="pull-right"><a href="<?php echo G5_ADMIN_URL;?>/shop_admin/itemuselist.php"><span class="font-11 lightviolet">사용후기 전체보기</span></a></div>
        <!-- [최신글]사용후기 끝 //-->
        </li>
        <!-- } (2) 사용후기 끝 -->
        
        <!-- (3) 입금확인요청 시작 { -->
        <li id="alim_atmcheck" class="tabsList">
        <!-- [최신글]입금확인요청 시작 -->
        <div class="latest_zine">
            <ul>
                <?php //입금확인요청
               $sql = " select * from {$g5['g5_shop_order_atmcheck_table']} a
			                left join {$g5['g5_shop_item_table']} b on (a.it_id = b.it_id)
			                left join {$g5['member_table']} c on (a.mb_id = c.mb_id)
                            order by id_id desc
                            limit 5 "; // 최대 5개출력
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
				
				// 글자수 자르기 설정
				$row['id_subject'] = cut_str($row['id_subject'],20); //제목
				$row['od_bank_account'] = cut_str($row['od_bank_account'],30); //입금계좌
				$row['id_deposit_name'] = cut_str($row['id_deposit_name'],8); //입금자명 
				?>
                <li>  
                    <div class="toolimg90"><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/orderform.php?od_id=<?php echo $row['od_id']; ?>" title="주문서 바로가기" target="_blank"><?php echo get_it_image($row['it_id'], 200, 200); ?></a></div>
					<div class="tooltool">
					    <?php echo ($row['id_confirm'] == '0') ? '<span class=noanswer>확인대기</span>' : '<span class=answer>완료</span>';?>
                        <span class="subject"><a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/atmcheck.php"  title="<?php echo $row['id_subject']; ?>"><?php echo $row['id_subject']; ?></a></span>
                        <br>
                        <?php// echo cut_str($row['it_name'],20); ?>
                        <span class="gray font-11">[<?php echo $row['od_bank_account']; ?>] </span>
                        <span class="acc"><?php echo $row['id_deposit_name']; ?></span>
                        <span class="orangered font-11"><?php echo number_format($row['id_money']); ?></span>
                        <br>
                        <span class="writename"><?php echo $name; ?></span>
                        <span class="date"><?php echo $id_time2; ?></span>
                    </div>
                </li>
                <?php
                }

                if ($i == 0)
                    echo '<li class="empty_list">자료가 없습니다.</li>';
                ?>
            </ul>
        </div>
        <div class="pull-right"><a href="<?php echo G5_ADMIN_URL;?>/shop_admin/atmcheck.php"><span class="font-11 lightviolet">입금확인요청 전체보기</span></a></div>
        <!-- [최신글]입금확인요청 끝 //-->
        </li>
        <!-- } (2) 입금확인요청 끝 -->


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

<div style="height:20px;"><!--칸띄우기--></div>

