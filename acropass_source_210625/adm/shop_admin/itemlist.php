<?php
$sub_menu = '400300';
include_once('./_common.php');
######################################################
$is_item_list = true; //상품리스트페이지 표시
######################################################
auth_check($auth[$sub_menu], "r");
######################################################
$g5['title'] = '상품관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
######################################################

// 분류
$ca_list  = '<option value="" style="background:#FFD040;">분류선택</option>'.PHP_EOL;
$sql = " select * from {$g5['g5_shop_category_table']} ";
/*
부운영자인경우 자신이 등록한 상품만 볼수 있게 해놓은것을
전체상품을 볼수있게 소스숨김 - 아이스크림
if ($is_admin != 'super')
    $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
*/
$sql .= " order by ca_order, ca_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $len = strlen($row['ca_id']) / 2 - 1;
    $nbsp = '';
    for ($i=0; $i<$len; $i++) {
        $nbsp .= '－';
    }

    $ca_list .= '<option value="'.$row['ca_id'].'">'.$nbsp.' '.$row['ca_name'].'</option>'.PHP_EOL;
}

#################################################################
// 검색시 판매/미판매 선택 검색추가
// 관계로 조건문을 따로 만들어서 '문자'로 변환하여 인식하게끔 함
#################################################################
if ($it_use) { // value 값대신 조건문을 따로주어 문자로 변환
	switch($it_use) {
        case '판매중지':
            $where[] = " it_use != '1' ";
            break;
        case '판매':
            $where[] = " it_use = '1' ";
            break;
	}
}
#################################################################

$where = " and ";
$sql_search = "";
if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx != $stx)
        $page = 1;
}

if ($sca != "") {
    $sql_search .= " $where (a.ca_id like '$sca%' or a.ca_id2 like '$sca%' or a.ca_id3 like '$sca%') ";
}

if ($sfl == "")  $sfl = "it_name";

$sql_common = " from {$g5['g5_shop_item_table']} a ,
                     {$g5['g5_shop_category_table']} b
               where (a.ca_id = b.ca_id";
/*
부운영자인경우 자신이 등록한 상품만 볼수 있게 해놓은것을
전체상품을 볼수있게 소스숨김 - 아이스크림
if ($is_admin != 'super')
    $sql_common .= " and b.ca_mb_id = '{$member['mb_id']}'";
*/
$sql_common .= ") ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

if (!$sst) {
	$sst = "it_id";
    $sod = "desc";
}

$sql_order = "order by $sst $sod";

$sql  = " select *
           $sql_common
           $sql_order
           limit $from_record, $rows ";
$result = sql_query($sql);

//$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page;
//$qstr  = $qstr.'&amp;sca='.$sca.'&amp;it_use='.urlencode($it_use).'&amp;page='.$page.'&amp;save_stx='.$stx;
$qstr  = $qstr.'&amp;sca='.$sca.'&amp;it_use='.$it_use.'&amp;page='.$page.'&amp;save_stx='.$stx;

// 목록 정렬 조건
$sortlist = $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;sst=';
?>

<section>

<div class="dan-garo-transparent"><!-- 현재 상품 정보 / 투명배경 -->
    <div class="row"><!-- row 시작 { --> 
		<div class="dan"><!-- ### (1) 첫번째칸 ### {-->
		    <ul id="li_garo_TOP">
                <!-- 전체 -->
                <li id="li_garo_TOP_score2" onClick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/itemlist.php'" style="cursor:pointer;">
                    <?php echo ($item_sell_all > 0) ? '<span class="round_score font-20">'.number_format($item_sell_all).'</span>' : '<span class="round_score_none font-22">-</span>';?>
                    <br>전체상품
                </li>
                <!-- 판매중 -->
                <li id="li_garo_TOP_score2" onClick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/itemlist.php?save_stx=&sca=&sfl=it_use&stx=1'" style="cursor:pointer;">
                    <?php echo ($item_sell_use > 0) ? '<span class="round_score2 font-20">'.number_format($item_sell_use).'</span>' : '<span class="round_score_none font-22">-</span>';?>
                    <br>판매중
                </li>
                <!-- 미판매 -->
                <li id="li_garo_TOP_score2" onClick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/itemlist.php?save_stx=&sca=&sfl=it_use&stx=0'" style="cursor:pointer;">
                    <?php echo ($item_sell_stop > 0) ? '<span class="round_score_pink font-20" style="width:80px;">'.number_format($item_sell_stop).'</span>' : '<span class="round_score_none font-22" style="width:80px;">-</span>';?>
                    <br><span class="lightpink">판매중지</span>
                </li>
                <!-- 품절 -->
                <li id="li_garo_TOP_score2" onClick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/itemlist.php?save_stx=&sca=&sfl=it_soldout&stx=1'" style="cursor:pointer;">
                    <?php echo ($item_sell_soldout > 0) ? '<span class="round_score_pink font-22" style="width:80px;">'.number_format($item_sell_soldout).'</span>' : '<span class="round_score_none font-20" style="width:80px;">-</span>';?>
                    <br><span class="lightpink">품절</span>
                </li>
                <!-- 네이버페이 -->
                <li id="li_garo_TOP_score2" onClick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/itemlist.php'" style="cursor:pointer;">
                    <?php echo ($item_naverpay > 0) ? '<span class="round_score2 font-20">'.number_format($item_naverpay).'</span>' : '<span class="round_score_none font-22" style="width:80px;">-</span>';?>
                    <br>네이버쇼핑
                </li>
                <!-- 판매자이메일 - 다른판매자 -->
                <li id="li_garo_TOP_score2" onClick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/itemlist.php'" style="cursor:pointer;">
                    <?php echo ($item_sell_email > 0) ? '<span class="round_score2 font-20">'.number_format($item_sell_email).'</span>' : '<span class="round_score_none font-22" style="width:80px;">-</span>';?>
                    <br>다른판매자
                </li>
                <!-- 재고부족 -->
                <li id="li_garo_TOP_score2" onClick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/itemstocklist.php'" style="cursor:pointer;">
                    <?php echo ($item_noti > 0) ? '<span class="round_score_none font-20" style="width:80px;">'.number_format($item_noti).'</span>' : '<span class="round_score_none font-22" style="width:80px;">-</span>';?>
                    <br><span class="gray">재고부족</span>
                </li>
                <!-- 옵션재고부족 -->
                <li id="li_garo_TOP_score2" onClick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/optionstocklist.php'" style="cursor:pointer;">
                    <?php echo ($option_noti > 0) ? '<span class="round_score_none font-20" style="width:80px;">'.number_format($option_noti).'</span>' : '<span class="round_score_none font-22" style="width:80px;">-</span>';?>
                    <br><span class="gray">옵션부족</span>
                </li>
                <!-- 재입고알림요청 -->
                <li id="li_garo_TOP_score2" onClick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/itemstocksms.php'" style="cursor:pointer;">
                    <?php echo ($sms_alim > 0) ? '<span class="round_score_none font-20" style="width:80px;">'.number_format($sms_alim).'</span>' : '<span class="round_score_none font-22" style="width:80px;">-</span>';?>
                    <br><span class="gray">재고알림요청</span>
                </li>
			</ul>
	    </div><!-- } ### (1) 첫번째칸 ### -->

    </div><!-- } row 끝 -->
</div><!-- 현재 상품 정보 / 투명배경 -->

</section>


<div class="dan-schbox2" style="padding-bottom:10px;"><!-- 분류셀렉트박스 -->
    <div class="row"><!-- row 시작 { -->
<?php //카테고리 선택 시작 ?> 
<?php $he_size = '15'; ?> 
<div style="padding:0 0 10px 20px;"> 

<?php //1차 카테고리 ?> 
<select class="cream_selectbox" size="<?php echo $he_size ?>" name="ca_id1" onChange="cream_selectbox(this)">
<option style="color:#ff3100;font-weight:bold; padding-bottom:10px; margin-bottom:10px; border-bottom:solid 1px #bbb;" value="" >1차 분류</option> 
<?php 
$sql_ca_id1="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '2' order by ca_id "; 
$result_ca_id1 = sql_query($sql_ca_id1); 
for($i=0; $row_ca_id1 = sql_fetch_array($result_ca_id1); $i++){ 
?> 
<option value=<?php echo $row_ca_id1[ca_id]; ?> <?php if($row_ca_id1[ca_id] == substr($sca, 0, 2)) echo 'selected'?>><?php echo $row_ca_id1[ca_name]; ?></option> 
<?php } ?> 
</select> 

<?php //2차 카테고리 ?> 
<select class="cream_selectbox" size="<?php echo $he_size ?>"  name="ca_id2" onChange="cream_selectbox(this)">  
<option style="color:#ff3100;font-weight:bold; padding-bottom:10px; margin-bottom:10px; border-bottom:solid 1px #bbb;" value="<?php echo substr($sca, 0, 2); ?>" >2차 분류</option>  
<?php 
$sql_ca_id2="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '4' and substring(ca_id,1,2) = substring('$sca',1,2) order by ca_id "; 
$result_ca_id2 = sql_query($sql_ca_id2); 
for($i=0; $row_ca_id2 = sql_fetch_array($result_ca_id2); $i++){ 
?> 
<option value=<?php echo $row_ca_id2[ca_id]; ?> <?php if($row_ca_id2[ca_id] == substr($sca, 0, 4)) echo 'selected'?>><?php echo $row_ca_id2[ca_name]; ?></option> 
<?php } ?> 
</select> 

<?php //3차 카테고리 ?> 
<select class="cream_selectbox" size="<?php echo $he_size ?>" name="ca_id3" onChange="cream_selectbox(this)">  
<option style="color:#ff3100;font-weight:bold; padding-bottom:10px; margin-bottom:10px; border-bottom:solid 1px #bbb;" value="<?php echo substr($sca, 0, 4); ?>" >3차 분류</option> 
<?php 
$sql_ca_id3="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '6' and substring(ca_id,1,4) = substring('$sca',1,4) order by ca_id "; 
$result_ca_id3 = sql_query($sql_ca_id3); 
for($i=0; $row_ca_id3 = sql_fetch_array($result_ca_id3); $i++){ 
?> 
<option value=<?php echo $row_ca_id3[ca_id]; ?> <?php if($row_ca_id3[ca_id] == substr($sca, 0, 6)) echo 'selected'?>><?php echo $row_ca_id3[ca_name]; ?></option> 
<?php } ?> 
</select> 

<?php //4차 카테고리 ?> 
<select class="cream_selectbox4" size="<?php echo $he_size ?>" name="ca_id4" onChange="cream_selectbox(this)">  
<option style="color:#ff3100;font-weight:bold; padding-bottom:10px; margin-bottom:10px; border-bottom:solid 1px #bbb;" value="<?php echo substr($sca, 0, 6); ?>" >4차 분류</option> 
<?php 
$sql_ca_id4="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '8' and substring(ca_id,1,6) = substring('$sca',1,6) order by ca_id "; 
$result_ca_id4 = sql_query($sql_ca_id4); 
for($i=0; $row_ca_id4 = sql_fetch_array($result_ca_id4); $i++){ 
?> 
<option value=<?php echo $row_ca_id4[ca_id]; ?> <?php if($row_ca_id4[ca_id] == substr($sca, 0, 8)) echo 'selected'?>><?php echo $row_ca_id4[ca_name]; ?></option> 
<?php } ?> 
</select> 

<?php //5차 카테고리 ?> 
<select class="cream_selectbox5" size="<?php echo $he_size ?>" name="ca_id5" onChange="cream_selectbox(this)">  
<option style="color:#ff3100;font-weight:bold; padding-bottom:10px; margin-bottom:10px; border-bottom:solid 1px #bbb;" value="<?php echo substr($sca, 0, 8); ?>" >5차 분류</option> 
<?php 
$sql_ca_id5="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '10' and substring(ca_id,1,8) = substring('$sca',1,8) order by ca_id "; 
$result_ca_id5 = sql_query($sql_ca_id5); 
for($i=0; $row_ca_id5 = sql_fetch_array($result_ca_id5); $i++){ 
?> 
<option value=<?php echo $row_ca_id5[ca_id]; ?> <?php if($row_ca_id5[ca_id] == substr($sca, 0, 10)) echo 'selected'?>><?php echo $row_ca_id5[ca_name]; ?></option> 
<?php } ?> 
</select> 

<script type="text/javascript"> 
function cream_selectbox(sel_ca){ 
sel_ca= sel_ca.options[sel_ca.selectedIndex].value; 
location.replace("itemlist.php?sca="+sel_ca+"&sfl=it_name&stx="); 
} 
</script> 

</div> 
<?php //카테고리 선택 끝 ?>
    </div><!-- } row 끝 -->
</div><!-- } 분류선택 셀렉트창 -->

<!-- 검색창 -->
<div class="dan-schbox1" style="text-align:center;margin-bottom:10px;margin-top:-1px;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
<form name="flist" class="big_sch01 big_sch">
<!--<input type="hidden" name="page" value="<?php// echo $page; ?>">-->
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">

<!-- 검색시 판매중 선택할 경우 작업하다가 놔둠
<div>
    <input type="checkbox" name="it_use" value="1" id="it_use" <?php echo get_checked($row['it_use'], '1'); ?>>
    <label for="it_use">판매중</label>
</div>
-->

<label for="sca" class="sound_only">분류선택</label>
<select name="sca" id="sca" >
    <option value="">전체분류</option>
    <?php
    $sql1 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} order by ca_order, ca_id ";
    $result1 = sql_query($sql1);
    for ($i=0; $row1=sql_fetch_array($result1); $i++) {
        $len = strlen($row1['ca_id']) / 2 - 1;
        $nbsp = '';
        for ($i=0; $i<$len; $i++) $nbsp .= '－';
        echo '<option value="'.$row1['ca_id'].'" '.get_selected($sca, $row1['ca_id']).'>'.$nbsp.' '.$row1['ca_name'].'</option>'.PHP_EOL;
    }
    ?>
</select>

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="it_name" <?php echo get_selected($sfl, 'it_name'); ?>>상품명</option>
    <option value="it_id" <?php echo get_selected($sfl, 'it_id'); ?>>상품코드</option>
    <option value="it_maker" <?php echo get_selected($sfl, 'it_maker'); ?>>제조사</option>
    <option value="it_origin" <?php echo get_selected($sfl, 'it_origin'); ?>>원산지</option>
    <option value="it_sell_email" <?php echo get_selected($sfl, 'it_sell_email'); ?>>판매자 e-mail</option>
    <option value="it_use" <?php echo get_selected($sfl, 'it_use'); ?>>판매여부</option>
</select>

<label for="stx" class="sound_only">검색어</label>
<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" class="frm_input_big">
<input type="submit" value="검색" class="btn_submit_big">
<?php echo $listall; //전체보기?>

</form>
    </div><!-- } row 끝 -->
</div><!-- 검색창 -->
<!-- 검색창 끝 -->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <div class="totallist"><strong><?php echo number_format($total_count); ?></strong> 개의 상품이 검색되었습니다</div>
    <!--@@ 우측공간 전체 감쌈 { @@-->
    <div class="sortlist">
    <!-- 상품 정렬 선택 시작 { -->
    <section id="sct_sort">
    <select id="ssch_sort" onChange="window.location.href=this.value">
        <option value="">정렬선택</option>
        <option value="<?php echo $sortlist; ?>it_id&amp;sod=desc">상품코드 최근순</option>
        <option value="<?php echo $sortlist; ?>it_id&amp;sod=asc">상품코드 과거순</option>
        <option value="<?php echo $sortlist; ?>it_price&amp;sod=asc">판매가격 낮은순</option>
        <option value="<?php echo $sortlist; ?>it_price&amp;sod=desc">판매가격 높은순</option>
        <option value="<?php echo $sortlist; ?>it_stock_qty&amp;sod=asc">재고 적은순</option>
        <option value="<?php echo $sortlist; ?>it_stock_qty&amp;sod=desc">재고 많은순</option>
        <option value="<?php echo $sortlist; ?>it_hit&amp;sod=desc">조회수 많은순</option>
        <option value="<?php echo $sortlist; ?>it_hit&amp;sod=asc">조회수 적은순</option>
        <option value="<?php echo $sortlist; ?>it_update_time&amp;sod=desc">최종수정일 최근순</option>
        <option value="<?php echo $sortlist; ?>it_update_time&amp;sod=asc">최종수정일 과거순</option>
        <option value="<?php echo $sortlist; ?>it_time&amp;sod=desc">상품등록일 최근순</option>
        <option value="<?php echo $sortlist; ?>it_time&amp;sod=asc">상품등록일 과거순</option>
        <option value="<?php echo $sortlist; ?>it_name&amp;sod=asc">상품명 순</option>
        <option value="<?php echo $sortlist; ?>it_name&amp;sod=desc">상품명 역순</option>
        <option value="<?php echo $sortlist; ?>it_order&amp;sod=asc">순서번호 순</option>
        <option value="<?php echo $sortlist; ?>it_order&amp;sod=desc">순서번호 역순</option>
        <option value="<?php echo $sortlist; ?>it_id&amp;sod=desc">정렬초기화</option>
    </select>
    </section>
    <!-- } 상품 정렬 선택 끝 -->
    </div>
    <!--@@ } 우측공간 전체 감쌈 끝 @@-->
</div>
<!-- // -->

<form name="fitemlistupdate" method="post" action="./itemlistupdate.php" onsubmit="return fitemlist_submit(this);" autocomplete="off">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<!-- 상품 목록전체 감싸기 열기 { -->
<div id="ice_list"><!-- 상품목록 전체감싸기 시작 { -->
    
    <!-- (공통) 전체선택체크박스 -->
    <div id="ice_chk">
        <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        <label for="chkall">전체선택</label>
        &nbsp;&nbsp;&nbsp;
        <div class="pull-right">
        <input type="checkbox" id="pdcheck" value="모두선택"/>
		<!--<?php echo subject_sort_link('it_use', 'sca='.$sca, 1); ?> 판매</a>-->
        <label for="pdcheck" class="font-normal font-11">모든상품 판매로 체크</label>
        </div>
        <script type="text/javascript">
	    $(document).ready(function(){
	        //체크박스 모두선택
	        $("#pdcheck").click(function(){
		        if($("#pdcheck").prop("checked")){
				    $("input[class=chkpd]").prop("checked",true);
		        } else {
			        $("input[class=chkpd]").prop("checked",false);
			    }
		    });
        });
        </script> 
    </div>
    <!--//-->
    
    <!-- (목록) 상품정보표시 -->
    <ul>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];
        $bg = 'bg'.($i%2);
		
		// 품절,판매중지 테이블색상 class 지정 - 아이스크림
		$td_color = 0;
        if($row['it_soldout'] == '1' || $row['it_use'] == '0') { // 품절,판매중지
            $bg .= 'end';
            $td_color = 1;
		} else { // 정상판매
		    $bg .= '';
            $td_color = 1;
		}

        //포인트
		$it_point = $row['it_point'];
        if($row['it_point_type'])
            $it_point .= '%';
		
		// 고객후기평가 참여자수 합계 ($score_user)
		$it_id = $row['it_id'];
        $score_user = 0;
        $sql_score = " select count(*) as cnt from {$g5['g5_shop_item_use_table']} where it_id = '$it_id' ";
        $score = sql_fetch($sql_score);
        $score_user = (int)$score['cnt'];
		
		// 상품판매갯수 합계 ($sales_qty)
        $sales_qty = 0;
        $sql_sales_qty = " select count(*) as cnt, sum(ct_qty) as qty from {$g5['g5_shop_cart_table']} where ct_status = '완료' and it_id = '$it_id' ";
        $sales = sql_fetch($sql_sales_qty);
        $sales_qty = (int)$sales['qty'];
		
		// 몇일전등으로 표시
		$diff = time() - strtotime($row['it_update_time']);
		if($diff < 60) $nr_datetime = "<span class=today_date2><i class='fas fa-check-circle'></i>".$diff."초전</span>";
		else if( $diff < 3600 && $diff > 59) $nr_datetime = "<span class=today_date2><i class='fas fa-check-circle'></i>".round($diff/60)."분전</span>";
		else if( 86400 > $diff && $diff > 3599 ) $nr_datetime = "<span class=today_date><i class='fas fa-check-circle'></i>".round($diff/3600)."시간전</span>";
		//else if( 604800 > $diff && $diff > 86399 ) $nr_datetime = round($diff/86400). "일전</span>";
		else if( 604800 > $diff && $diff > 86399 ) $nr_datetime = "<span class=today_date><i class='far fa-check-circle'></i>".round($diff/86400)."일전</span>";//최대7일
		else if( 1296000 > $diff && $diff > 604799 ) $nr_datetime = "<span class=date><i class='far fa-check-circle'></i>".round($diff/86400)."일전</span>";//최대15일
        else if( 2592000 > $diff && $diff > 1295999 ) $nr_datetime = "<span class=date><i class='far fa-check-circle'></i>".round($diff/86400)."일전</span>";//최대30일
		else $nr_datetime = '<span class="darkgray font-11">'.substr($row['it_update_time'],0,10).'</span> <span class="gray font-11">'. substr($row['it_update_time'],11,18).'</span>'; //날짜,시간으로 표시
		
    ?>
    <style>
    /* [토글] 메모 */
    .ice_list_toggle<?php echo $row['it_id'];?> {display: none; padding:15px; border:solid 1px #93BDFB; background:#FAFBFE; margin-top:-9px; margin-bottom:8px;}
    </style>
    
    <li class="<?php echo $bg; ?>">        
        <!-- (1단 타이틀) 상품번호 -->
        <div class="listtitle">
            <div class="listtitle_right">
			    <!-- 우측에 표시할 내용 시작 { -->
                <!-- 네이버표시 -->
                <?php echo ($row['ec_mall_pid']) ? '<div class="tack_icon_naver">N</div>' : '';//네이버표시?>
            <!--//-->
                <!-- } 우측에 표시할 내용 끝 --> 
            </div>
            
            <div class="listtitle_left">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['it_name']); ?></label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i; ?>">
            <!-- 상품번호 및 표시택 -->
            <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
                <!-- 품절/판매중지 표시 tack -->
                <?php echo ($row['it_soldout'] == '1') ? '<div class="tack_soldout">품절</div>' : '';//품절표시?><?php echo ($row['it_use'] == '0') ? '<div class="tack_stop">판매중지</div>' : '';//판매중지?>
                <!-- // -->
                <!-- 상품번호 -->
                <a href="<?php echo $href; ?>" target="_blank" class="at-tip" data-original-title="<nobr>상품보기</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><b><?php echo $row['it_id']; ?></b></a>
                
            </div>

        </div>
        <!--//-->
        
        <!-- (2단 사용후기) 사용후기정보 -->
        <?php if ($score = get_star_image($row['it_id'])) { //사용후기가 있을경우?>
        <div class="dan-block">
            <!-- 고객후기평점 -->
            <span class="sound_only"> 고객선호도별<?php echo $score?>개</span>
            <span class="lightpink">고객후기평점</span>
            <img src="<?php echo G5_ADMIN_URL; ?>/shop_admin/img/s_star<?php echo $score?>.png" alt="" class="sit_star">&nbsp;
            <span class="gray">상품평 </span> <span class="darkgray"><b><?php echo number_format($score_user); ?></b>건</span>
            <span class="go_link"><a href="<?php echo G5_ADMIN_URL;?>/shop_admin/itemuselist.php?sfl=a.it_id&stx=<?php echo $row['it_id']; ?>" target="_blank">후기보기</a></span>
            <!-- 고객후기평점// -->
        </div>
        <?php } //사용후기가 있을경우?>
        <!--//-->
        
        <!-- (3단 카테고리) 카테고리선택 -->
        <div class="dan-block">
            <label for="ca_id_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['it_name']); ?> 기본분류</label>
            <select name="ca_id[<?php echo $i; ?>]" id="ca_id_<?php echo $i; ?>" required>
                <?php echo conv_selected_option($ca_list, $row['ca_id']); ?>
            </select>
            <label for="ca_id2_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['it_name']); ?> 2차분류</label>
            <select name="ca_id2[<?php echo $i; ?>]" id="ca_id2_<?php echo $i; ?>">
                <?php echo conv_selected_option($ca_list, $row['ca_id2']); ?>
            </select>
            <label for="ca_id3_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['it_name']); ?> 3차분류</label>
            <select name="ca_id3[<?php echo $i; ?>]" id="ca_id3_<?php echo $i; ?>">
                <?php echo conv_selected_option($ca_list, $row['ca_id3']); ?>
            </select>
        </div>
        <!--//-->
        
        <!-- (4단 상품명) 상품명 -->
        <div class="dan-block">
            <input type="text" name="it_name[<?php echo $i; ?>]" value="<?php echo htmlspecialchars2(cut_str($row['it_name'],250, "")); ?>" id="name_<?php echo $i; ?>" required class="frm_input required w100per">
        </div>
        <!--//-->
        
<table style="width:100%; margin:0; margin-top:5px; padding:0; border:solid 0px #fff;">
  <tr>
    <td class="td_img">
        <!-- (5단 상품이미지) -->
        <div class="imgplus at-tip cursor" onclick="popup_itemimg('imgplus​​', '<?php echo G5_ADMIN_URL; ?>/shop_admin/itemlist_img.php?w=u&it_id=<?php echo $row['it_id']; ?>');" data-original-title="<nobr>상품이미지<br>변경/추가</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
            <div class="plus">＋</div>
			<?php echo get_it_image($row['it_id'], 200, 200); ?>
        </div>
        <!--//-->
    </td>
    <td class="td_list">
        <!-- (5단 표) [표]상품정보 -->
        <div class="li_zinelist">    
            <div class="zinelist_price li_zinelist_sp"><div class="tit">판매가격</div>
			    <label for="price_<?php echo $i; ?>" class="sound_only">판매가격</label>
                <input type="text" name="it_price[<?php echo $i; ?>]" value="<?php echo $row['it_price']; ?>" id="price_<?php echo $i; ?>" class="frm_input sit_amt w90per">
            </div>
            
            <div class="zinelist_price li_zinelist_sp"><div class="tit">시중가격</div>
			    <label for="cust_price_<?php echo $i; ?>" class="sound_only">시중가격</label>
            <input type="text" name="it_cust_price[<?php echo $i; ?>]" value="<?php echo $row['it_cust_price']; ?>" id="cust_price_<?php echo $i; ?>" class="frm_input sit_camt w90per">
            </div>
            
            <div class="zinelist_price li_zinelist_sp"><div class="tit">재고</div>
                <label for="stock_qty_<?php echo $i; ?>" class="sound_only">재고</label>
                <input type="text" name="it_stock_qty[<?php echo $i; ?>]" value="<?php echo $row['it_stock_qty']; ?>" id="stock_qty_<?php echo $i; ?>" class="frm_input sit_qty w90per">
            </div>
            
            <div class="zinelist_price li_zinelist_sp"><div class="tit">적립금</div>
			    <?php echo $it_point; //적립금?>
            </div>
            
            <div class="zinelist_price li_zinelist_sp"><div class="tit">출력순서</div>
                <label for="order_<?php echo $i; ?>" class="sound_only">순서</label>
            <input type="text" name="it_order[<?php echo $i; ?>]" value="<?php echo $row['it_order']; ?>" id="order_<?php echo $i; ?>" class="frm_input" size="5">
            </div>
            
            <div class="zinelist_price li_zinelist_sp"><div class="tit">조회/구매</div>
                <span class="darkgray font-11"><?php echo $row['it_hit']; //조회수?></span> <span class="gray">/</span>
                <?php echo ($sales_qty > '0') ? '<span class="screen_tack1">'.number_format($sales_qty).'<span class="gray font-11">개</span></span>' : '<span class="darkgray font-11">-</span>';//판매상품갯수?>
            </div>
        </div>
        <!--//-->
        
        <div class="dan-block">
            <div class="pull-right mobile_hidden">
                <span class="gray font-11">최종수정</span>
                <?php echo $nr_datetime; //몇일전으로표시 ?>
            </div>
            
            <div class="pull-left">
                <label for="it_skin_<?php echo $i; ?>" class="sound_only">PC 스킨</label>
                <label for="it_skin_<?php echo $i; ?>">PC</label>
                <?php echo get_skin_select('shop', 'it_skin_'.$i, 'it_skin['.$i.']', $row['it_skin']); ?>
                
                <label for="it_mobile_skin_<?php echo $i; ?>" class="sound_only">모바일 스킨</label>
                <label for="it_mobile_skin_<?php echo $i; ?>">모바일</label>
                <?php echo get_mobile_skin_select('shop', 'it_mobile_skin_'.$i, 'it_mobile_skin['.$i.']', $row['it_mobile_skin']); ?>
            </div>
        </div>
    </td>
  </tr>
</table>
        
        <!-- 판매/품절 선택 -->
        <div class="dan-block" style="text-align:right;">
            <label for="use_<?php echo $i; ?>" class="sound_only">판매여부</label>
            <label for="use_<?php echo $i; ?>">판매</label>
            <label class="switch-check-mini">
                <input type="checkbox" class="chkpd" name="it_use[<?php echo $i; ?>]" <?php echo ($row['it_use'] ? 'checked' : ''); ?> value="1" id="use_<?php echo $i; ?>">
                <div class="check-slider-mini round"></div>
            </label>
            
            <label for="soldout_<?php echo $i; ?>" class="sound_only">품절</label>
            <label for="soldout_<?php echo $i; ?>">품절</label>
            <label class="switch-check-mini">
                <input type="checkbox" name="it_soldout[<?php echo $i; ?>]" <?php echo ($row['it_soldout'] ? 'checked' : ''); ?> value="1" id="soldout_<?php echo $i; ?>">
                <div class="check-slider-mini round"></div>
            </label>
        </div>
        <!--//-->
        
        <!-- (단축고정버튼) -->
        <div id="ice_list_btn">
            <div class="ice_list_btn_basic">
            <!--상품수정 버튼-->
            <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/itemform.php?w=u&amp;it_id=<?php echo $row['it_id']; ?>&amp;ca_id=<?php echo $row['ca_id']; ?>&amp;<?php echo $qstr; ?>" class="at-tip" data-original-title="<nobr>상품수정</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true">수정</a>
            <!--복사 버튼-->
            <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/itemcopy.php?it_id=<?php echo $row['it_id']; ?>&amp;ca_id=<?php echo $row['ca_id']; ?>" target="_blank" class="at-tip itemcopy" data-original-title="<nobr>상품복사</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true"><i class="far fa-clone darkgray"></i></a>
            <!--상품보기 버튼-->
            <a href="<?php echo $href; ?>" target="_blank" class="at-tip" data-original-title="<nobr>상품미리보기</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true"><span class="sound_only"><?php echo htmlspecialchars2(cut_str($row['it_name'],250, "")); ?> </span><i class="fas fa-laptop darkgray"></i></a>
            
            <!--메모보기 버튼(토글)-->
            <?php if ($row['it_shop_memo']) { //메모가있을경우 ?>
            <div class="togglebtn" onclick="$('.ice_list_toggle<?php echo $row['it_id'];?>').toggle()"><i class="fas fa-edit"></i></div>
            <?php } ?>
            </div>
        </div>
        <!--//-->

    </li>

    <!-- 토글 (클릭시나타나는내용) -->
    <div class="ice_list_toggle<?php echo $row['it_id'];?>">
        <?php echo nl2br($row['it_shop_memo']); ?>
    </div>
    <!--//-->
    
    
    <?php
	} // for문 끝
    
    if ($i == 0) {
        echo '<li class="empty_list">등록된 상품이 없습니다. 상품을 등록해 주세요!</li>';
    }
    ?>
    
    </ul>
</div><!-- } 상품 목록전체 감싸기 닫기 -->
<!-- } 상품 목록전체 감싸기 닫기 -->

<div class="btn_list01 btn_list">
    <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value">
    <?php if ($is_admin == 'super') { ?>
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
    <?php } ?>
</div>

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">
    <div class="bq_basic">
    <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value">
	<?php if ($is_admin == 'super') { ?>
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
	<?php } ?>
    </div>
    
    <div class="bq_basic_add">
    <a href="./itemform.php"><i class="fas fa-plus"></i> 상품등록</a>
    <a href="./item_EXCEL.php"><i class="fas fa-upload"></i> 엑셀</a>
    </div>
</div>
<!--//-->

<!-- <div class="btn_confirm01 btn_confirm">
    <input type="submit" value="일괄수정" class="btn_submit" accesskey="s">
</div> -->
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
function fitemlist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}

$(function() {
    $(".itemcopy").click(function() {
        var href = $(this).attr("href");
        window.open(href, "copywin", "left=100, top=100, width=300, height=200, scrollbars=0");
        return false;
    });
});

function excelform(url)
{
    var opt = "width=600,height=450,left=10,top=10";
    window.open(url, "win_excel", opt);
    return false;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>