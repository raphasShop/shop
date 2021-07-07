<?php
$sub_menu = '400200';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '분류관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$where = " where ";
$sql_search = "";
if ($stx != "") {
    if ($sfl == "ca_id") {
        $sql_search .= " $where $sfl like '$stx%' ";
        $where = " and ";
	} else {
	    $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
	}
	/*검색결과페이지 원본소스
    if ($save_stx != $stx)
        $page = 1;
	*/
	//검색결과페이지 수정소스 - 2페이지 에러수정
	if ($save_stx && ($save_stx != $stx)) {
        $page = 1;
    }
}

$sql_common = " from {$g5['g5_shop_category_table']} ";
/*
부운영자인경우 자신이 등록한 분류만 볼수 있게 해놓은것을
전체상품을 볼수있게 소스숨김 - 크림장수
if ($is_admin != 'super')
    $sql_common .= " $where ca_mb_id = '{$member['mb_id']}' ";
*/
$sql_common .= $sql_search;


// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

// 한페이지당 출력 목록수 100개로 고정(환경설정 라인수 무시) - 크림장수
$rows = 100;
//$rows = $config['cf_page_rows'];//환경설정 : 한페이지당 라인수

$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

if (!$sst)
{
    $sst  = "ca_id";
    $sod = "asc";
}
$sql_order = "order by $sst $sod";

// 출력할 레코드를 얻음
$sql  = " select *
             $sql_common
             $sql_order
             limit $from_record, $rows ";
$result = sql_query($sql);

if(USE_G5_THEME) {
	$htxt = array('PC스킨폴더', 'PC스킨파일', '모바일스킨폴더', '모바일스킨파일');
}
?>

<!-- 검색창 -->
<div class="dan-schbox1" style="text-align:center;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
<form name="flist" class="big_sch01 big_sch">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="ca_name"<?php echo get_selected($_GET['sfl'], "ca_name", true); ?>>분류명</option>
    <option value="ca_id"<?php echo get_selected($_GET['sfl'], "ca_id", true); ?>>분류코드</option>
    <option value="ca_mb_id"<?php echo get_selected($_GET['sfl'], "ca_mb_id", true); ?>>회원아이디</option>
</select>

<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" required class="required frm_input_big">
<input type="submit" value="검색" class="btn_submit_big">
<?php echo $listall; //전체보기?>

</form>
    </div><!-- } row 끝 -->
 </div><!-- 검색창 -->
<!-- 검색창 끝 -->

<div class="dan-schbox2" style="padding-bottom:20px; margin-top:-1px;"><!-- 분류셀렉트박스 -->
    <div class="row"><!-- row 시작 { -->
<?php //카테고리 선택 시작 ?> 
<?php $he_size = '15'; ?> 

<div style="padding:0 0 10px 20px;"> 

<?php //1차 카테고리 ?> 
<select class="cream_selectbox" size="<?php echo $he_size ?>" name="ca_id1" onChange="cream_selectbox(this)">
<option style="color:#ff3100;font-weight:bold;padding-bottom:10px;margin-bottom:10px;border-bottom:solid 1px #bbb;" value="" title="1차분류 모두보기">1차분류</option> 
<?php 
$sql_ca_id1="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '2' order by ca_id "; 
$result_ca_id1 = sql_query($sql_ca_id1); 
for($i=0; $row_ca_id1 = sql_fetch_array($result_ca_id1); $i++){ 
?> 
<option value=<?php echo $row_ca_id1[ca_id]; ?> <?php if($row_ca_id1[ca_id] == substr($stx, 0, 2)) echo 'selected'?>><?php echo $row_ca_id1[ca_name]; ?></option> 
<?php } ?> 

</select> 

<?php //2차 카테고리 ?> 
<select class="cream_selectbox" size="<?php echo $he_size ?>"  name="ca_id2" onChange="cream_selectbox(this)">  
<option style="color:#ff3100;font-weight:bold; padding-bottom:10px; margin-bottom:10px; border-bottom:solid 1px #bbb;" value="<?php echo substr($stx, 0, 2); ?>" title="2차분류 모두보기">2차 분류</option> 

<?php 
$sql_ca_id2="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '4' and substring(ca_id,1,2) = substring('$stx',1,2) order by ca_id "; 
$result_ca_id2 = sql_query($sql_ca_id2); 
for($i=0; $row_ca_id2 = sql_fetch_array($result_ca_id2); $i++){ 
?> 

<option value=<?php echo $row_ca_id2[ca_id]; ?> <?php if($row_ca_id2[ca_id] == substr($stx, 0, 4)) echo 'selected'?>><?php echo $row_ca_id2[ca_name]; ?></option> 

<?php } ?> 

</select> 

<?php //3차 카테고리 ?> 
<select class="cream_selectbox" size="<?php echo $he_size ?>" name="ca_id3" onChange="cream_selectbox(this)">  
<option style="color:#ff3100;font-weight:bold; padding-bottom:10px; margin-bottom:10px; border-bottom:solid 1px #bbb;" value="<?php echo substr($stx, 0, 4); ?>" title="3차분류 모두보기">3차 분류</option> 

<?php 
$sql_ca_id3="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '6' and substring(ca_id,1,4) = substring('$stx',1,4) order by ca_id "; 
$result_ca_id3 = sql_query($sql_ca_id3); 
for($i=0; $row_ca_id3 = sql_fetch_array($result_ca_id3); $i++){ 
?> 

<option value=<?php echo $row_ca_id3[ca_id]; ?> <?php if($row_ca_id3[ca_id] == substr($stx, 0, 6)) echo 'selected'?>><?php echo $row_ca_id3[ca_name]; ?></option> 

<?php } ?> 

</select> 

<?php //4차 카테고리 ?> 
<select class="cream_selectbox4" size="<?php echo $he_size ?>" name="ca_id4" onChange="cream_selectbox(this)">  
<option style="color:#ff3100;font-weight:bold; padding-bottom:10px; margin-bottom:10px; border-bottom:solid 1px #bbb;" value="<?php echo substr($stx, 0, 6); ?>" title="4차분류 모두보기">4차 분류</option> 

<?php 
$sql_ca_id4="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '8' and substring(ca_id,1,6) = substring('$stx',1,6) order by ca_id "; 
$result_ca_id4 = sql_query($sql_ca_id4); 
for($i=0; $row_ca_id4 = sql_fetch_array($result_ca_id4); $i++){ 
?> 

<option value=<?php echo $row_ca_id4[ca_id]; ?> <?php if($row_ca_id4[ca_id] == substr($stx, 0, 8)) echo 'selected'?>><?php echo $row_ca_id4[ca_name]; ?></option> 

<?php } ?> 

</select> 

<?php //5차 카테고리 ?> 
<select class="cream_selectbox5" size="<?php echo $he_size ?>" name="ca_id5" onChange="cream_selectbox(this)">  
<option style="color:#ff3100;font-weight:bold; padding-bottom:10px; margin-bottom:10px; border-bottom:solid 1px #bbb;" value="<?php echo substr($stx, 0, 8); ?>" title="5차분류 모두보기">5차 분류</option> 

<?php 
$sql_ca_id5="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '10' and substring(ca_id,1,8) = substring('$stx',1,8) order by ca_id "; 
$result_ca_id5 = sql_query($sql_ca_id5); 
for($i=0; $row_ca_id5 = sql_fetch_array($result_ca_id5); $i++){ 
?> 

<option value=<?php echo $row_ca_id5[ca_id]; ?> <?php if($row_ca_id5[ca_id] == substr($stx, 0, 10)) echo 'selected'?>><?php echo $row_ca_id5[ca_name]; ?></option> 

<?php } ?> 

</select> 

<script type="text/javascript"> 
function cream_selectbox(sel_ca){ 
sel_ca= sel_ca.options[sel_ca.selectedIndex].value; 
location.replace("categorylist.php?&sfl=ca_id&stx="+sel_ca); 
} 
</script> 

</div> 
<?php //카테고리 선택 끝 ?> 
    </div><!-- } row 끝 -->
</div><!-- } 분류선택 셀렉트창 -->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <div class="totallist"><strong><?php echo number_format($total_count); ?></strong> 개의 분류(카테고리)가 있습니다</div>
</div>
<!-- // -->

<form name="fcategorylist" method="post" action="./categorylistupdate.php" autocomplete="off">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<!-- 상품 목록전체 감싸기 열기 { -->
<div id="ice_list"><!-- 상품목록 전체감싸기 시작 { -->
    
    <!-- (목록) 상품정보표시 -->
    <ul>
    <?php
	for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $level = strlen($row['ca_id']) / 2 - 1;
        $p_ca_name = '';

        if ($level > 0) {
            $class = 'class="name_lbl"'; // 2단 이상 분류의 label 에 스타일 부여 - 지운아빠 2013-04-02
            // 상위단계의 분류명
            $p_ca_id = substr($row['ca_id'], 0, $level*2);
            $sql = " select ca_name from {$g5['g5_shop_category_table']} where ca_id = '$p_ca_id' ";
            $temp = sql_fetch($sql);
            $p_ca_name = $temp['ca_name'].'의하위';
        } else {
            $class = '';
        }

        $s_level = '<div style="z-index:1"><label for="ca_name_'.$i.'" '.$class.'><span class="sound_only">'.$p_ca_name.''.($level+1).'단 분류</span></label></div>';
        $s_level_input_size = 16 - $level *2; // 하위 분류일 수록 입력칸 넓이 작아짐 - 지운아빠 2013-04-02

        if ($level+2 < 6) $s_add = '<a href="./categoryform.php?ca_id='.$row['ca_id'].'&amp;'.$qstr.'" class="at-tip" data-original-title="<nobr>하위분류추가</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true">+추가</a> '; // 분류는 5단계까지만 가능
        else $s_add = '';
        $s_upd = '<a href="./categoryform.php?w=u&amp;ca_id='.$row['ca_id'].'&amp;'.$qstr.'" class="at-tip itemcopy" data-original-title="<nobr>수정</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true"><span class="sound_only">'.get_text($row['ca_name']).' </span>수정</a> ';

        if ($is_admin == 'super')
            $s_del = '<a href="./categoryformupdate.php?w=d&amp;ca_id='.$row['ca_id'].'&amp;'.$qstr.'" onclick="return delete_confirm(this);" class="at-tip" data-original-title="<nobr>삭제</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true"><span class="sound_only">'.get_text($row['ca_name']).' </span><i class="far fa-trash-alt"></i></a> ';

        // 해당 분류에 속한 상품의 수
        $sql1 = " select COUNT(*) as cnt from {$g5['g5_shop_item_table']}
                      where ca_id = '{$row['ca_id']}'
                      or ca_id2 = '{$row['ca_id']}'
                      or ca_id3 = '{$row['ca_id']}' ";
        $row1 = sql_fetch($sql1);

        // 스킨 Path
		if(USE_G5_THEME) {
			if(!$row['ca_skin_dir'])
				$g5_shop_skin_path = G5_SHOP_SKIN_PATH;
			else {
				if(preg_match('#^theme/(.+)$#', $row['ca_skin_dir'], $match))
					$g5_shop_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1];
				else
					$g5_shop_skin_path  = G5_PATH.'/'.G5_SKIN_DIR.'/shop/'.$row['ca_skin_dir'];
			}

			if(!$row['ca_mobile_skin_dir'])
				$g5_mshop_skin_path = G5_MSHOP_SKIN_PATH;
			else {
				if(preg_match('#^theme/(.+)$#', $row['ca_mobile_skin_dir'], $match))
					$g5_mshop_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1];
				else
					$g5_mshop_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$row['ca_mobile_skin_dir'];
			}
		}

        $bg = 'bg'.($i%2);
        /*
		$td_color = 0;
        if(strlen($row['ca_id']) == 2) {
            $bg .= 'step';
            $td_color = 1;
		}
		*/
		// 카테고리 판매정지 테이블색상 class 지정 - 아이스크림
		$td_color = 0;
        if($row['ca_use'] == '0') { // 품절,판매중지
            $bg .= 'cancel';
            $td_color = 1;
		} else { // 정상판매
		    $bg .= '';
            $td_color = 1;
		}
		
		$category_new_level = '<span class="cate_'.($level+1).'">'.($level+1).'차분류</span>'; //카테고리 보여지는 몇차메뉴 표시
    ?>
    <style>
    /* [토글] 숨김열림내용 */
    .ice_list_toggle<?php echo $row['ca_id']; ?> {display: none; padding:15px; border:solid 1px #93BDFB; background:#FAFBFE; margin-top:-9px; margin-bottom:8px;}
    </style>
    
    <li class="<?php echo $bg; ?>">        
        
        <!-- (1단 분류명) 분류명표시 -->
        <div class="dan-block sct_name">
            <!-- 분류단 Depth 표시 -->
			<?php echo $s_level; ?>
            <!-- 분류명(카테고리명) -->
            <div class="sct_name<?php echo $level; ?>" style="z-index:3;">
		    <?php if(strlen($row['ca_id']) == 2) { // 1차메뉴 ?>
            <input type="text" name="ca_name[<?php echo $i; ?>]" value="<?php echo get_text($row['ca_name']); ?>" id="ca_name<?php echo $i; ?>" required class="frm_input_special1 w100per">
            <?php } else { //2차메뉴이상?>
            <input type="text" name="ca_name[<?php echo $i; ?>]" value="<?php echo get_text($row['ca_name']); ?>" id="ca_name<?php echo $i; ?>" required class="frm_input w100per">
            <?php } ?>
            </div>
            <!--//-->
        </div>
        <!--//-->


        <!-- (5단 표) [표]상품정보 -->
        <div class="li_signfour">  
          
            <div class="signfour_price li_signfour_sp"><div class="tit">분류코드</div>
			    <input type="hidden" name="ca_id[<?php echo $i; ?>]" value="<?php echo $row['ca_id']; ?>">
                <?php if(strlen($row['ca_id']) == 2) { // 1차메뉴 ?>
                <a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $row['ca_id']; ?>"><b><?php echo $row['ca_id']; ?></b></a>
                <?php } else { //2차메뉴이상?>
                <a href="<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $row['ca_id']; ?>"><?php echo $row['ca_id']; ?></a>
                <?php } ?>
                <br>
                <?php echo $category_new_level; //몇차분류표시?>
            </div>
            
            <div class="signfour_price li_signfour_sp"><div class="tit">출력순서</div>
			   <label for="ca_order<?php echo $i; ?>" class="sound_only">출력순서</label>
                <?php if(strlen($row['ca_id']) == 2) { // 1차메뉴 ?>
                <input type="text" name="ca_order[<?php echo $i; ?>]" value='<?php echo $row['ca_order']; ?>' id="ca_order<?php echo $i; ?>" required class="frm_input_special1 center" size="4">
                <?php } else { //2차메뉴이상?>
                <input type="text" name="ca_order[<?php echo $i; ?>]" value='<?php echo $row['ca_order']; ?>' id="ca_order<?php echo $i; ?>" required class="frm_input" size="4">
                <?php } ?>
            </div>

            <div class="signfour_price li_signfour_sp"><div class="tit">기본재고</div>
                <label for="ca_stock_qty<?php echo $i; ?>" class="sound_only">기본재고</label>
                <input type="text" name="ca_stock_qty[<?php echo $i; ?>]" value="<?php echo $row['ca_stock_qty']; ?>" id="ca_stock_qty<?php echo $i; ?>" required class="required frm_input" size="4" > <span class="sound_only">개</span>
            </div>
            
            <div class="signfour_price li_signfour_sp"><div class="tit">관리회원</div>
                <?php if ($is_admin == 'super') {?>
                <label for="ca_mb_id<?php echo $i; ?>" class="sound_only">관리회원아이디</label>
                <input type="text" name="ca_mb_id[<?php echo $i; ?>]" value="<?php echo $row['ca_mb_id']; ?>" id="ca_mb_id<?php echo $i; ?>" class="frm_input_transparent gray w90per" maxlength="20" placeholder="아이디기재">
                <?php } else { ?>
                <input type="hidden" name="ca_mb_id[<?php echo $i; ?>]" value="<?php echo $row['ca_mb_id']; ?>" class="frm_input w90per" placeholder="아이디기재">
                <?php echo $row['ca_mb_id']; ?>
                <?php } ?>
            </div>

            <div class="signfour_price li_signfour_sp"><div class="tit">PC(폭×높이)</div>
			    <label for="ca_out_width<?php echo $i; ?>" class="sound_only">출력이미지 폭</label>
                <input type="text" name="ca_img_width[<?php echo $i; ?>]" value="<?php echo get_text($row['ca_img_width']); ?>" id="ca_out_width<?php echo $i; ?>" required class="required frm_input" size="2" ><span class="sound_only">픽셀</span>×<label for="ca_img_height<?php echo $i; ?>" class="sound_only">출력이미지 높이</label><input type="text" name="ca_img_height[<?php echo $i; ?>]" value="<?php echo $row['ca_img_height']; ?>" id="ca_img_height<?php echo $i; ?>" required class="required frm_input" size="2" > <span class="sound_only">픽셀</span>
            </div>
            
            <div class="signfour_price li_signfour_sp"><div class="tit">PC(가로×세로수)</div>
                <label for="ca_lineimg_num<?php echo $i; ?>" class="sound_only">1줄당 이미지 수</label>
                <input type="text" name="ca_list_mod[<?php echo $i; ?>]" size="1" value="<?php echo $row['ca_list_mod']; ?>" id="ca_lineimg_num<?php echo $i; ?>" required class="required frm_input"><span class="sound_only">개</span>×<label for="ca_imgline_num<?php echo $i; ?>" class="sound_only">이미지 줄 수</label><input type="text" name="ca_list_row[<?php echo $i; ?>]" value='<?php echo $row['ca_list_row']; ?>' id="ca_imgline_num<?php echo $i; ?>" required class="required frm_input" size="1"> <span class="sound_only">줄</span>
            </div>
            
            <div class="signfour_price li_signfour_sp"><div class="tit">모바일(폭×높이)</div>
			    <label for="ca_mobile_out_width<?php echo $i; ?>" class="sound_only">출력이미지 폭</label>
                <input type="text" name="ca_mobile_img_width[<?php echo $i; ?>]" value="<?php echo get_text($row['ca_mobile_img_width']); ?>" id="ca_mobile_out_width<?php echo $i; ?>" required class="required frm_input" size="2" ><span class="sound_only">픽셀</span>×<label for="ca_mobile_img_height<?php echo $i; ?>" class="sound_only">출력이미지 높이</label><input type="text" name="ca_mobile_img_height[<?php echo $i; ?>]" value="<?php echo $row['ca_mobile_img_height']; ?>" id="ca_mobile_img_height<?php echo $i; ?>" required class="required frm_input" size="2" > <span class="sound_only">픽셀</span>
            </div>
            
            <div class="signfour_price li_signfour_sp"><div class="tit">모바일(가로×세로수)</div>
                <label for="ca_mobileimg_num<?php echo $i; ?>" class="sound_only">모바일 1줄당 이미지 수</label>
                <input type="text" name="ca_mobile_list_mod[<?php echo $i; ?>]" size="1" value="<?php echo $row['ca_mobile_list_mod']; ?>" id="ca_mobileimg_num<?php echo $i; ?>" required class="required frm_input"><span class="sound_only">개</span>×<label for="ca_mobileimg_row<?php echo $i; ?>" class="sound_only">모바일 이미지 줄 수</label><input type="text" name="ca_mobile_list_row[<?php echo $i; ?>]" value='<?php echo $row['ca_mobile_list_row']; ?>' id="ca_mobileimg_row<?php echo $i; ?>" required class="required frm_input" size="1">
            </div>

        </div>
        <!--//-->
        
        <!-- 본인인증/성인인증 선택 -->
        <div class="dan-block" style="text-align:right;">

            <label for="ca_cert_use_yes<?php echo $i; ?>">본인</label>
            <label class="switch-check-mini">
                <input type="checkbox" name="ca_cert_use[<?php echo $i; ?>]" value="1" id="ca_cert_use_yes<?php echo $i; ?>" <?php if($row['ca_cert_use']) echo 'checked="checked"'; ?>>
                <div class="check-slider-mini round"></div>
            </label>
            
            <label for="ca_adult_use_yes<?php echo $i; ?>">성인</label>
            <label class="switch-check-mini">
                <input type="checkbox" name="ca_adult_use[<?php echo $i; ?>]" value="1" id="ca_adult_use_yes<?php echo $i; ?>" <?php if($row['ca_adult_use']) echo 'checked="checked"'; ?>>
                <div class="check-slider-mini round"></div>
            </label>

            <label for="ca_use<?php echo $i; ?>">판매</label>
            <label class="switch-check-mini">
                <input type="checkbox" name="ca_use[<?php echo $i; ?>]" value="1" id="ca_use<?php echo $i; ?>" <?php echo ($row['ca_use'] ? "checked" : ""); ?>>
                <div class="check-slider-mini round"></div>
            </label>

        </div>
        <!--//-->
        
        <div class="h10"></div>
        
        <!-- (단축고정버튼) -->
        <div id="ice_list_btn">
            <div class="ice_list_btn_basic">
            <!--하위분류추가 버튼-->
            <?php echo $s_add; ?>
            <!--수정 버튼-->
            <?php echo $s_upd; ?>
            <!--삭제 버튼-->
            <?php echo $s_del; ?>
            <!--스킨보기 버튼(토글)-->
            <div class="togglebtn" onclick="$('.ice_list_toggle<?php echo $row['ca_id']; ?>').toggle()">스킨설정 <i class="fas fa-magic"></i></div>
            <!--상품수-->
            <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/itemlist.php?sca=<?php echo $row['ca_id']; ?>" target="_blank" class="at-tip cntbtn" data-original-title="<nobr>등록상품수</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true">
            <?php echo ($row1['cnt'] > 0) ? number_format($row1['cnt']).'개' : '-';//회원접속자수?>
            </a>
            </div>
        </div>
        <!--//-->

    </li>
    
    <!-- 토글 (클릭시나타나는내용-스킨) -->
    <div class="ice_list_toggle<?php echo $row['ca_id']; ?>">
        <div style="display:inline-block; margin-right:5px;">
        <!--PC 스킨폴더/파일-->
                <?php if(USE_G5_THEME) { ?>
				<label for="ca_skin_dir<?php echo $i; ?>">PC스킨</label>
				<?php echo get_skin_select('shop', 'ca_skin_dir'.$i, 'ca_skin_dir['.$i.']', $row['ca_skin_dir'], 'class="skin_dir"'); ?>
			    <?php } else { ?>
				<label for="ca_skin<?php echo $i; ?>">PC목록스킨</label>
		        <select id="ca_skin<?php echo $i; ?>" name="ca_skin[<?php echo $i; ?>]">
				<?php for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($row['ca_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} ?>
	            </select>
			    <?php } ?>
                
                <?php if(USE_G5_THEME) { ?>
				<label for="ca_skin<?php echo $i; ?>" class="sound_only">PC스킨파일</label>
				<select id="ca_skin<?php echo $i; ?>" name="ca_skin[<?php echo $i; ?>]">
					<?php echo get_list_skin_options("^list.[0-9]+\.skin\.php", $g5_shop_skin_path, $row['ca_skin']); ?>
				</select>
			    <?php } else { ?>
				<label for="ca_skin_dir<?php echo $i; ?>" class="sound_only">PC상품스킨</label>
				<select id="ca_skin_dir<?php echo $i; ?>" name="ca_skin_dir[<?php echo $i; ?>]">
				<?php for ($k=0; $k<count($itemskin); $k++) {
					echo "<option value=\"".$itemskin[$k]."\"".get_selected($row['ca_skin_dir'], $itemskin[$k]).">".$itemskin[$k]."</option>\n";
				} ?>
				</select>
			    <?php } ?>
                <!--//-->
        </div>
        
        <div style="display:inline-block; margin-right:5px;">      
                <!--모바일 스킨폴더/파일-->
                <?php if(USE_G5_THEME) { ?>
				<label for="ca_mobile_skin_dir<?php echo $i; ?>">모바일스킨</label>
				<?php echo get_mobile_skin_select('shop', 'ca_mobile_skin_dir'.$i, 'ca_mobile_skin_dir['.$i.']', $row['ca_mobile_skin_dir'], 'class="skin_dir"'); ?>
			<?php } else { ?>
				<label for="ca_mobile_skin<?php echo $i; ?>" class="sound_only">모바일목록스킨</label>
				<select id="ca_mobile_skin<?php echo $i; ?>" name="ca_mobile_skin[<?php echo $i; ?>]">
				<?php for ($k=0; $k<count($listskin); $k++) {
					echo "<option value=\"".$listskin[$k]."\"".get_selected($row['ca_mobile_skin'], $listskin[$k]).">".$listskin[$k]."</option>\n";
				} ?>
				</select>
			<?php } ?>
                
                <?php if(USE_G5_THEME) { ?>
				<label for="ca_mobile_skin<?php echo $i; ?>" class="sound_only">모바일스킨파일</label>
				<select id="ca_mobile_skin<?php echo $i; ?>" name="ca_mobile_skin[<?php echo $i; ?>]">
					<?php echo get_list_skin_options("^list.[0-9]+\.skin\.php", $g5_mshop_skin_path, $row['ca_mobile_skin']); ?>
				</select>
			    <?php } else { ?>
				<label for="ca_mobile_skin_dir<?php echo $i; ?>" class="sound_only">모바일상품스킨</label>
				<select id="ca_mobile_skin_dir<?php echo $i; ?>" name="ca_mobile_skin_dir[<?php echo $i; ?>]">
				<?php for ($k=0; $k<count($itemskin); $k++) {
					echo "<option value=\"".$itemskin[$k]."\"".get_selected($row['ca_mobile_skin_dir'], $itemskin[$k]).">".$itemskin[$k]."</option>\n";
				} ?>
				</select>
			    <?php } ?>
                <!--//-->
         </div>
    </div>
    <!--//-->
    
    <?php
	} // for문 끝
    
    if ($i == 0) {
        echo '<li class="empty_list">등록된 분류가 없습니다. 분류를 등록해 주세요!</li>';
    }
    ?>
    
    </ul>
</div><!-- } 상품 목록전체 감싸기 닫기 -->
<!-- } 상품 목록전체 감싸기 닫기 -->


<div class="btn_list01 btn_list">
    <input type="submit" value="일괄수정">
</div>

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">
    <div class="bq_basic_submit_mini">
    <input type="submit" value="일괄수정">
    </div>
    
    <?php if ($is_admin == 'super') {?>
    <div class="bq_basic_add">
        <a href="./categoryform.php" id="cate_add"><i class="fa fa-plus"></i> 분류추가</a>
    </div>
    <?php } ?>
</div>
<!--//-->

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
$(function() {
    $("select.skin_dir").on("change", function() {
        var type = "";
        var dir = $(this).val();
        if(!dir)
            return false;

        var id = $(this).attr("id");
        var $sel = $(this).siblings("select");
        var sval = $sel.find("option:selected").val();

        if(id.search("mobile") > -1)
            type = "mobile";

        $sel.load(
            "./ajax/ajax.skinfile.php",
            { dir : dir, type : type, sval: sval }
        );
    });
});
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>