<?php
$sub_menu = '600200';
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$sel_ca_add_sql="select * from comcose_sellprice_category_add where order by cose_cat_add_cat_id asc ";
$sel_ca_add_result= sql_query($sel_ca_add_sql);
$sel_ca_add = sql_fetch_array($sel_ca_add_result);

$g5['title'] = '분류별 금액설정 [분류등록]';
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>





<style>
.comcose_dc_level_use {width:80px; height:24px; padding: 2px 2px 2px 2px;}
.comcose_dc_level_select {width:45px; height:35px; font-size:15px; color:red; padding: 2px 2px 2px 2px;}
</style>

<?php 
$cat_add_caname_sql="SELECT ca_id, ca_name FROM g5_shop_category where ca_id = '$stx' order by ca_id ";
$cat_add_caname_result= sql_query($cat_add_caname_sql);
$cat_add_caname= sql_fetch_array($cat_add_caname_result);
$cat_set_caname = $cat_add_caname['ca_name'];
?>

<script src="_comcose_sellprice.js"></script>
<form name="fitemform" action="./_comcose_sellprice_category_add_form_update.php" onsubmit="return fwrite_submit(this);" method="post" autocomplete="off">
<input type="hidden" name="cose_cat_add_cat_caname" value="<?php echo $cat_set_caname; ?>">
<input type="hidden" name="cose_cat_add_cat_id" value="<?php echo $stx; ?>">

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

<option style="color:#000" value=<?php echo $row_ca_id1[ca_id]; ?> <?php if($row_ca_id1[ca_id] == substr($stx, 0, 2)) echo 'selected'?>><?php echo $row_ca_id1[ca_name]; ?></option> 

<?php } ?> 
</optgroup>
</select> 

<?php //2차 분류 ?> 
<select class="comcose_acs" size="<?php echo $he_size ?>"  name="ca_id2" id="ca_id2" onChange="comcose_acs(this)">  
<optgroup style="color:#ef4b24" label="2차 분류">

<?php 
$sql_ca_id2="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '4' and substring(ca_id,1,2) = substring('$stx',1,2) order by ca_id "; 
$result_ca_id2 = sql_query($sql_ca_id2); 
for($i=0; $row_ca_id2 = sql_fetch_array($result_ca_id2); $i++){ 
?> 

<option style="color:#000" value=<?php echo $row_ca_id2[ca_id]; ?> <?php if($row_ca_id2[ca_id] == substr($stx, 0, 4)) echo 'selected'?>><?php echo $row_ca_id2[ca_name]; ?></option> 

<?php } ?> 
</optgroup>
</select> 

<?php //3차 분류 ?> 
<select class="comcose_acs" size="<?php echo $he_size ?>" name="ca_id3" onChange="comcose_acs(this)">  
<optgroup style="color:#ef4b24" label="3차 분류">-------------------------------</option>  

<?php 
$sql_ca_id3="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '6' and substring(ca_id,1,4) = substring('$stx',1,4) order by ca_id "; 
$result_ca_id3 = sql_query($sql_ca_id3); 
for($i=0; $row_ca_id3 = sql_fetch_array($result_ca_id3); $i++){ 
?> 

<option style="color:#000" value=<?php echo $row_ca_id3[ca_id]; ?> <?php if($row_ca_id3[ca_id] == substr($stx, 0, 6)) echo 'selected'?>><?php echo $row_ca_id3[ca_name]; ?></option> 

<?php } ?> 
</optgroup>
</select> 

<?php //4차 분류 ?> 
<select class="comcose_acs" size="<?php echo $he_size ?>" name="ca_id4" onChange="comcose_acs(this)">  
<optgroup style="color:#ef4b24" label="4차 분류">
<?php 
$sql_ca_id4="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '8' and substring(ca_id,1,6) = substring('$stx',1,6) order by ca_id "; 
$result_ca_id4 = sql_query($sql_ca_id4); 
for($i=0; $row_ca_id4 = sql_fetch_array($result_ca_id4); $i++){ 
?> 

<option style="color:#000" value=<?php echo $row_ca_id4[ca_id]; ?> <?php if($row_ca_id4[ca_id] == substr($stx, 0, 8)) echo 'selected'?>><?php echo $row_ca_id4[ca_name]; ?></option> 

<?php } ?> 
</optgroup>
</select> 

<?php //5차 분류 ?> 
<select class="comcose_acs" size="<?php echo $he_size ?>" name="ca_id5" onChange="comcose_acs(this)">  
<optgroup style="color:#ef4b24" label="5차 분류">

<?php 
$sql_ca_id5="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '10' and substring(ca_id,1,8) = substring('$stx',1,8) order by ca_id "; 
$result_ca_id5 = sql_query($sql_ca_id5); 
for($i=0; $row_ca_id5 = sql_fetch_array($result_ca_id5); $i++){ 
?> 

<option style="color:#000" value=<?php echo $row_ca_id5[ca_id]; ?> <?php if($row_ca_id5[ca_id] == substr($stx, 0, 10)) echo 'selected'?>><?php echo $row_ca_id5[ca_name]; ?></option> 

<?php } ?>
</optgroup>
</select> 

</div> 
<?php //분류 선택 끝 ?> 

<section id="cose_cat_set_caname">

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row">설정분류</th>
            <td>
        		<?php echo help("위 분류에서 선택하시면 자동 입력됩니다. <b>2차분류이상 선택해주세요!</b>"); ?>
               <input type="text" value="<?php echo $cat_set_caname; ?>" style="padding-left:5px" class="frm_input" size="50" disabled>
            </td>
        </tr>

        <tr>
            <th scope="row">설정금액 [%]</th>
            <td>
                <?php echo help("+,- 로 입력 하신 값 '%'로 설정됩니다."); ?>
                <select id="cose_cat_add_set_price_type" name="cose_cat_add_set_price_type" class="comcose_dc_level_select">
                    <option value="+" <?php if($sel_ca_add['cose_cat_add_set_price_type'] == '+') echo 'selected'; ?>>+</option>
                    <option value="-" <?php if($sel_ca_add['cose_cat_add_set_price_type'] == '-') echo 'selected'; ?>>-</option>
                </select>
                <input type="text" name="cose_cat_add_set_price" value="<?php echo $sel_ca_add['cose_cat_add_set_price']; ?>" id=cose_cat_add_set_price" style="padding-left:3px" class="frm_input num_only" size="3"> %
            </td>
        </tr>
        
        <tr>
            <th scope="row">사용 여·부</th>
            <td style="border-top:none">
                <?php echo help("해당 분류 금액설정 사용을 가능하게 할것인지를 설정합니다."); ?>
                <select id="cose_cat_add_use" name="cose_cat_add_use" class="comcose_dc_level_use">
                    <option value="0" <?php if($sel_ca_add['cose_cat_add_use'] == '0') echo 'selected'; ?>>사용안함</option>
                    <option value="1" <?php if($sel_ca_add['cose_cat_add_use'] == '1') echo 'selected'; ?>>사용</option>
                </select>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<div class="btn_fixed_top">
    <input type="submit" value="확인" accesskey="s" class="btn btn_01">
    <a href="./_comcose_sellprice_category_add.php?" class="btn btn_02">목록</a>
</div>
</form>

<script type="text/javascript"> 
function comcose_acs(sel_ca){ 
sel_ca= sel_ca.options[sel_ca.selectedIndex].value; 
location.replace("_comcose_sellprice_category_add_form.php?&sfl=ca_id&stx="+sel_ca); 
}

function fwrite_submit(f) {
	if (f.ca_id2.value == ""){
        alert('"2차분류"이상 등록이 가능합니다.');
           f.ca_id2.focus();
        return false;
    }
}
</script> 

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>     
