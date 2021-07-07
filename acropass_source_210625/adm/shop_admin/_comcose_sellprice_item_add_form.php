<?php
$sub_menu = '600500';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$sel_item_add_sql ="select * from comcose_sellprice_item_add where order by cose_item_add_it_id asc ";
$sel_item_add_result = sql_query($sel_item_add_sql);
$sel_item_add = sql_fetch_array($sel_item_add_result);

$g5['title'] = '상품별 금액설정 [상품등록]';
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>



<?php 
// 분류
$ca_list  = '<option value="">선택</option>'.PHP_EOL;
$sql = " select * from {$g5['g5_shop_category_table']} ";
if ($is_admin != 'super')
	$sql .= " where ca_mb_id = '{$member['mb_id']}' ";
	$sql .= " order by ca_order, ca_id ";
	$result = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($result); $i++)
	{
		$len = strlen($row['ca_id']) / 2 - 1;
		$nbsp = '';
		for ($i=0; $i<$len; $i++) {
			$nbsp .= '&nbsp;&nbsp;&nbsp;';
		}
		$ca_list .= '<option value="'.$row['ca_id'].'">'.$nbsp.$row['ca_name'].'</option>'.PHP_EOL;
	}
	
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
	if ($is_admin != 'super')
		$sql_common .= " and b.ca_mb_id = '{$member['mb_id']}'";
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
			$sst  = "it_id";
			$sod = "desc";
		}
		$sql_order = "order by $sst $sod";
		
		
		$sql  = " select *
		$sql_common
		$sql_order
		limit $from_record, $rows ";
		$result = sql_query($sql);
		
		//$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page;
		$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page.'&amp;save_stx='.$stx;
		
		$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';
		?>

<div class="local_ov01 local_ov">
    <?php echo $listall; ?>
    등록된 상품 <?php echo $total_count; ?>건
</div>


<?php //분류 선택 시작 ?> 
<style> 
.comcose_acs {width:250px; height:200px; padding:.5em;color:#222;} 
</style> 
<?php $he_size = '15'; ?> 

<div style="padding:0 0 10px 20px;width:1300px"> 

<?php //1차 분류 ?> 
<select class="comcose_acs" size="<?php echo $he_size ?>" name="ca_id1" onChange="comcose_acs(this)"> 
<optgroup style="color:#ef4b24" label="1차 분류"> 

<?php 
$sql_ca_id1="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '2' order by ca_id "; 
$result_ca_id1 = sql_query($sql_ca_id1); 
for($i=0; $row_ca_id1 = sql_fetch_array($result_ca_id1); $i++){ 
?> 

<option style="color:#000" value=<?php echo $row_ca_id1[ca_id]; ?> <?php if($row_ca_id1[ca_id] == substr($sca, 0, 2)) echo 'selected'?>><?php echo $row_ca_id1[ca_name]; ?></option> 

<?php } ?> 
</optgroup>
</select> 

<?php //2차 분류 ?> 
<select class="comcose_acs" size="<?php echo $he_size ?>"  name="ca_id2" onChange="comcose_acs(this)">  
<optgroup style="color:#ef4b24" label="2차 분류">  

<?php 
$sql_ca_id2="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '4' and substring(ca_id,1,2) = substring('$sca',1,2) order by ca_id "; 
$result_ca_id2 = sql_query($sql_ca_id2); 
for($i=0; $row_ca_id2 = sql_fetch_array($result_ca_id2); $i++){ 
?> 

<option style="color:#000" value=<?php echo $row_ca_id2[ca_id]; ?> <?php if($row_ca_id2[ca_id] == substr($sca, 0, 4)) echo 'selected'?>><?php echo $row_ca_id2[ca_name]; ?></option> 

<?php } ?> 
</optgroup>
</select> 

<?php //3차 분류 ?> 
<select class="comcose_acs" size="<?php echo $he_size ?>" name="ca_id3" onChange="comcose_acs(this)">  
<optgroup style="color:#ef4b24" label="3차 분류"> 

<?php 
$sql_ca_id3="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '6' and substring(ca_id,1,4) = substring('$sca',1,4) order by ca_id "; 
$result_ca_id3 = sql_query($sql_ca_id3); 
for($i=0; $row_ca_id3 = sql_fetch_array($result_ca_id3); $i++){ 
?> 

<option style="color:#000" value=<?php echo $row_ca_id3[ca_id]; ?> <?php if($row_ca_id3[ca_id] == substr($sca, 0, 6)) echo 'selected'?>><?php echo $row_ca_id3[ca_name]; ?></option> 

<?php } ?> 
</optgroup>
</select> 

<?php //4차 분류 ?> 
<select class="comcose_acs" size="<?php echo $he_size ?>" name="ca_id4" onChange="comcose_acs(this)">  
<optgroup style="color:#ef4b24" label="4차 분류"> 

<?php 
$sql_ca_id4="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '8' and substring(ca_id,1,6) = substring('$sca',1,6) order by ca_id "; 
$result_ca_id4 = sql_query($sql_ca_id4); 
for($i=0; $row_ca_id4 = sql_fetch_array($result_ca_id4); $i++){ 
?> 

<option value=<?php echo $row_ca_id4[ca_id]; ?> <?php if($row_ca_id4[ca_id] == substr($sca, 0, 8)) echo 'selected'?>><?php echo $row_ca_id4[ca_name]; ?></option> 

<?php } ?> 
</optgroup>
</select> 

<?php //5차 분류 ?> 
<select class="comcose_acs" size="<?php echo $he_size ?>" name="ca_id5" onChange="comcose_acs(this)">  
<optgroup style="color:#ef4b24" label="5차 분류"> 

<?php 
$sql_ca_id5="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '10' and substring(ca_id,1,8) = substring('$sca',1,8) order by ca_id "; 
$result_ca_id5 = sql_query($sql_ca_id5); 
for($i=0; $row_ca_id5 = sql_fetch_array($result_ca_id5); $i++){ 
?> 

<option style="color:#000" value=<?php echo $row_ca_id5[ca_id]; ?> <?php if($row_ca_id5[ca_id] == substr($sca, 0, 10)) echo 'selected'?>><?php echo $row_ca_id5[ca_name]; ?></option> 

<?php } ?> 
</optgroup>
</select> 

<script type="text/javascript"> 
function comcose_acs(sel_ca){ 
sel_ca= sel_ca.options[sel_ca.selectedIndex].value; 
location.replace("_comcose_sellprice_item_add_form.php?sca="+sel_ca+"&sfl=it_name&stx="); 
} 
</script> 

</div> 
<?php //분류 선택 끝 ?>

<style>
.comcose_dc_level_select {max-width:45px;color:#ff3600;}
.item_add_frm_input {max-width:80px;padding:3px 0 3px 0}
</style>

<script src="_comcose_sellprice.js"></script>
<form name="fitemlistupdate" method="post" action="./_comcose_sellprice_item_add_form_update.php" onsubmit="return fitemlist_submit(this);" autocomplete="off">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <?php echo help("상품별 금액설정은 +,- 로 입력 하신 값 '원'로 설정됩니다."); ?>
    <tr>
        <th style="width:5px">
            <label for="chkall" class="sound_only">상품 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th id="th_amt" style="width:100px">판매가격</th>
        <th style="width:210px">금액설정</th>
        <th id="th_img" style="width:240px">이미지</th>
        <th id="th_pc_title">상품명</th>
        
        <th style="width:100px">상품코드</th>
        
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $bg = 'bg'.($i%2);        
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_chk">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['it_name']); ?></label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i; ?>">
        </td>
        
        <?php //판매가격 ?>
        <td headers="th_amt" class="td_numbig td_input">
            <label for="price_<?php echo $i; ?>" class="sound_only">판매가격</label>
            <input type="text" name="it_price[<?php echo $i; ?>]" value="<?php echo number_format($row['it_price']); ?>" id="price_<?php echo $i; ?>" class="frm_input sit_amt" style="padding-right:3px" disabled>
        </td>
        
        <?php //금액설정 ?>
        <td style="text-align:center">
        	1 등급 : 
            <select name="cose_item_add_set_price_type1[<?php echo $i; ?>]" id="cose_item_add_set_price_type1<?php echo $i; ?>" class="comcose_dc_level_select">
            	<option value="+" <?php if($sel_item_add['cose_item_add_set_price_type1'] == '+') echo 'selected'; ?>>+</option>
                <option value="-" <?php if($sel_item_add['cose_item_add_set_price_type1'] == '-') echo 'selected'; ?>>-</option>
            </select>
            <input type="text" name="cose_item_add_set_price1[<?php echo $i; ?>]" value="<?php echo $sel_item_add['cose_item_add_set_price1']; ?>" id=cose_item_add_set_price1<?php echo $i; ?>" style="padding-right:3px;text-align:right" class="item_add_frm_input num_only"> 원
            
            2 등급 : 
            <select name="cose_item_add_set_price_type2[<?php echo $i; ?>]" id="cose_item_add_set_price_type2<?php echo $i; ?>" class="comcose_dc_level_select">
            	<option value="+" <?php if($sel_item_add['cose_item_add_set_price_type2'] == '+') echo 'selected'; ?>>+</option>
                <option value="-" <?php if($sel_item_add['cose_item_add_set_price_type2'] == '-') echo 'selected'; ?>>-</option>
            </select>
            <input type="text" name="cose_item_add_set_price2[<?php echo $i; ?>]" value="<?php echo $sel_item_add['cose_item_add_set_price2']; ?>" id=cose_item_add_set_price2<?php echo $i; ?>" style="padding-right:3px;text-align:right" class="item_add_frm_input num_only"> 원
            
            3 등급 : 
            <select name="cose_item_add_set_price_type3[<?php echo $i; ?>]" id="cose_item_add_set_price_type3<?php echo $i; ?>" class="comcose_dc_level_select">
            	<option value="+" <?php if($sel_item_add['cose_item_add_set_price_type3'] == '+') echo 'selected'; ?>>+</option>
                <option value="-" <?php if($sel_item_add['cose_item_add_set_price_type3'] == '-') echo 'selected'; ?>>-</option>
            </select>
            <input type="text" name="cose_item_add_set_price3[<?php echo $i; ?>]" value="<?php echo $sel_item_add['cose_item_add_set_price3']; ?>" id=cose_item_add_set_price3<?php echo $i; ?>" style="padding-right:3px;text-align:right" class="item_add_frm_input num_only"> 원
            
            4 등급 : 
            <select name="cose_item_add_set_price_type4[<?php echo $i; ?>]" id="cose_item_add_set_price_type4<?php echo $i; ?>" class="comcose_dc_level_select">
            	<option value="+" <?php if($sel_item_add['cose_item_add_set_price_type4'] == '+') echo 'selected'; ?>>+</option>
                <option value="-" <?php if($sel_item_add['cose_item_add_set_price_type4'] == '-') echo 'selected'; ?>>-</option>
            </select>
            <input type="text" name="cose_item_add_set_price4[<?php echo $i; ?>]" value="<?php echo $sel_item_add['cose_item_add_set_price4']; ?>" id=cose_item_add_set_price4<?php echo $i; ?>" style="padding-right:3px;text-align:right" class="item_add_frm_input num_only"> 원
            
            5 등급 : 
            <select name="cose_item_add_set_price_type5[<?php echo $i; ?>]" id="cose_item_add_set_price_type5<?php echo $i; ?>" class="comcose_dc_level_select">
            	<option value="+" <?php if($sel_item_add['cose_item_add_set_price_type5'] == '+') echo 'selected'; ?>>+</option>
                <option value="-" <?php if($sel_item_add['cose_item_add_set_price_type5'] == '-') echo 'selected'; ?>>-</option>
            </select>
            <input type="text" name="cose_item_add_set_price5[<?php echo $i; ?>]" value="<?php echo $sel_item_add['cose_item_add_set_price5']; ?>" id=cose_item_add_set_price5<?php echo $i; ?>" style="padding-right:3px;text-align:right" class="item_add_frm_input num_only"> 원
            
            6 등급 : 
            <select name="cose_item_add_set_price_type6[<?php echo $i; ?>]" id="cose_item_add_set_price_type6<?php echo $i; ?>" class="comcose_dc_level_select">
            	<option value="+" <?php if($sel_item_add['cose_item_add_set_price_type6'] == '+') echo 'selected'; ?>>+</option>
                <option value="-" <?php if($sel_item_add['cose_item_add_set_price_type6'] == '-') echo 'selected'; ?>>-</option>
            </select>
            <input type="text" name="cose_item_add_set_price6[<?php echo $i; ?>]" value="<?php echo $sel_item_add['cose_item_add_set_price6']; ?>" id=cose_item_add_set_price6<?php echo $i; ?>" style="padding-right:3px;text-align:right" class="item_add_frm_input num_only"> 원
            
            7 등급 : 
            <select name="cose_item_add_set_price_type7[<?php echo $i; ?>]" id="cose_item_add_set_price_type7<?php echo $i; ?>" class="comcose_dc_level_select">
            	<option value="+" <?php if($sel_item_add['cose_item_add_set_price_type7'] == '+') echo 'selected'; ?>>+</option>
                <option value="-" <?php if($sel_item_add['cose_item_add_set_price_type7'] == '-') echo 'selected'; ?>>-</option>
            </select>
            <input type="text" name="cose_item_add_set_price7[<?php echo $i; ?>]" value="<?php echo $sel_item_add['cose_item_add_set_price7']; ?>" id=cose_item_add_set_price7<?php echo $i; ?>" style="padding-right:3px;text-align:right" class="item_add_frm_input num_only"> 원
            
            8 등급 : 
            <select name="cose_item_add_set_price_type8[<?php echo $i; ?>]" id="cose_item_add_set_price_type8<?php echo $i; ?>" class="comcose_dc_level_select">
            	<option value="+" <?php if($sel_item_add['cose_item_add_set_price_type8'] == '+') echo 'selected'; ?>>+</option>
                <option value="-" <?php if($sel_item_add['cose_item_add_set_price_type8'] == '-') echo 'selected'; ?>>-</option>
            </select>
            <input type="text" name="cose_item_add_set_price8[<?php echo $i; ?>]" value="<?php echo $sel_item_add['cose_item_add_set_price8']; ?>" id=cose_item_add_set_price8<?php echo $i; ?>" style="padding-right:3px;text-align:right" class="item_add_frm_input num_only"> 원
            
            9 등급 : 
            <select name="cose_item_add_set_price_type9[<?php echo $i; ?>]" id="cose_item_add_set_price_type9<?php echo $i; ?>" class="comcose_dc_level_select">
            	<option value="+" <?php if($sel_item_add['cose_item_add_set_price_type9'] == '+') echo 'selected'; ?>>+</option>
                <option value="-" <?php if($sel_item_add['cose_item_add_set_price_type9'] == '-') echo 'selected'; ?>>-</option>
            </select>
            <input type="text" name="cose_item_add_set_price9[<?php echo $i; ?>]" value="<?php echo $sel_item_add['cose_item_add_set_price9']; ?>" id=cose_item_add_set_price9<?php echo $i; ?>" style="padding-right:3px;text-align:right" class="item_add_frm_input num_only"> 원
        </td>
        
        
        
        <?php //이미지 ?>
        <input type="hidden" name="cose_item_add_it_img[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
        <td class="td_img"><?php echo get_it_image($row['it_id'], 200, 200); ?></td>
        
        
        <?php //상품명 ?>
        <td headers="th_pc_title" class="td_input">
            <label for="name_<?php echo $i; ?>" class="sound_only">상품명</label>
            <input type="hidden" name="cose_item_add_it_name[<?php echo $i; ?>]" value="<?php echo htmlspecialchars2(cut_str($row['it_name'],250, "")); ?>" id="cose_item_add_it_name<?php echo $i; ?>">
            <input type="text" name="cose_item_add_it_name[<?php echo $i; ?>]" value="<?php echo htmlspecialchars2(cut_str($row['it_name'],250, "")); ?>" id="cose_item_add_it_name<?php echo $i; ?>" class="frm_input required" style="padding-left:3px" disabled>
        </td>
        

        
        <?php //상품코드 ?>
        <td class="td_num">
        	<input type="hidden" name="cose_item_add_ca_id[<?php echo $i; ?>]" value="<?php if ($row['ca_id'] !== '' and $row['ca_id2'] == '' and $row['ca_id3'] == ''){ echo $row['ca_id']; } else if ($row['ca_id'] !== '' and $row['ca_id2'] !== '' and $row['ca_id3'] == '') { echo $row['ca_id2']; } else if ($row['ca_id'] !== '' and $row['ca_id2'] !== '' and $row['ca_id3'] !== '') { echo $row['ca_id3']; } ?>">
            <input type="hidden" name="cose_item_add_it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
            <?php echo $row['it_id']; ?>
        </td>
    </tr>

    <?php
    }
    if ($i == 0)
        echo '<tr><td colspan="12" class="empty_table">자료가 한건도 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <input type="submit" name="act_button" value="선택등록" onclick="document.pressed=this.value" class="btn btn_01">
    <a href="./_comcose_sellprice_item_add.php" class="btn btn_02">목록</a>
</div>
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
function fitemlist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert("등록하실 상품을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>

    