<?php
$sub_menu = '600300';
include_once('./_common.php');
auth_check($auth[$sub_menu], "w");
$g5['title'] = '제외 분류설정 [분류등록]';
include_once (G5_ADMIN_PATH.'/admin.head.php');


$sql = " select it_id from {$g5['g5_shop_item_table']} a, {$g5['g5_shop_item_option_sub_table']} b where a.it_id = '$it_id' and a.ca_id = b.ca_id ";
$row = sql_fetch($sql);

$sql = " select * from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
$it = sql_fetch($sql);

if (!$ca_id)
	$ca_id = $it['ca_id'];
	
	$sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' ";
	$ca = sql_fetch($sql);
	
	$sql_io_sub = " select * from {$g5['g5_shop_item_option_sub_table']} where it_id = '$it_id'";
	$io_sub = sql_fetch($sql_io_sub);
?>

<?php 
$cat_add_caname_sql="SELECT ca_id, ca_name FROM g5_shop_category where ca_id = '$stx' order by ca_id ";
$cat_add_caname_result= sql_query($cat_add_caname_sql);
$cat_add_caname= sql_fetch_array($cat_add_caname_result);
$cat_set_caname = $cat_add_caname['ca_name'];
?>
<form name="fitemform" action="./_comcose_sellprice_category_except_form_update.php" onsubmit="return fwrite_submit(this);" method="post" autocomplete="off">
<input type="hidden" name="cose_except_add_cat_caname" value="<?php echo $cat_set_caname; ?>">
<input type="hidden" name="cose_except_add_cat_id" value="<?php echo $stx; ?>">

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
        		<?php echo help("위 분류에서 선택하시면 자동 입력됩니다."); ?>
               <input type="text" value="<?php echo $cat_set_caname; ?>" style="padding-left:5px" class="frm_input" size="50" disabled>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<div class="btn_fixed_top">
    <input type="submit" value="선택등록" accesskey="s" class="btn btn_01">
    <a href="./_comcose_sellprice_category_except.php" class="btn btn_02">목록</a>
</div>
</form>

<script type="text/javascript"> 
function comcose_acs(sel_ca){ 
sel_ca= sel_ca.options[sel_ca.selectedIndex].value; 
location.replace("_comcose_sellprice_category_except_form.php?&sfl=ca_id&stx="+sel_ca); 
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