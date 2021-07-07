<?php
$sub_menu = '600900';
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$doc = strip_tags($doc);

$g5['title'] = '상품유형관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

/*
$sql_search = " where 1 ";
if ($search != "") {
	if ($sel_field != "") {
    	$sql_search .= " and $sel_field like '%$search%' ";
    }
}

if ($sel_ca_id != "") {
    $sql_search .= " and (ca_id like '$sel_ca_id%' or ca_id2 like '$sel_ca_id%' or ca_id3 like '$sel_ca_id%') ";
}

if ($sel_field == "")  $sel_field = "it_name";
*/

$where = " where ";
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
    $sql_search .= " $where (ca_id like '$sca%' or ca_id2 like '$sca%' or ca_id3 like '$sca%') ";
}

if ($sfl == "")  $sfl = "it_name";

if (!$sst)  {
    $sst  = "it_id";
    $sod = "desc";
}
$sql_order = "order by $sst $sod";

$sql_common = "  from {$g5['g5_shop_item_table']} ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select it_id,
                 it_name,
                 it_type1,
                 it_type2,
                 it_type3,
                 it_type4,
                 it_type5
          $sql_common
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);

$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page.'&amp;save_stx='.$stx;

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';
?>

<div class="local_ov01 local_ov">
    <?php echo $listall; ?>
        <span class="btn_ov01"><span class="ov_txt">전체 상품</span><span class="ov_num">  <?php echo $total_count; ?>개</span></span>
</div>

<form name="flist" class="local_sch01 local_sch">
<input type="hidden" name="doc" value="<?php echo $doc; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<label for="sca" class="sound_only">분류선택</label>
<select name="sca" id="sca">
    <option value="">전체분류</option>
    <?php
    $sql1 = " select ca_id, ca_name from {$g5['g5_shop_category_table']} order by ca_order, ca_id ";
    $result1 = sql_query($sql1);
    for ($i=0; $row1=sql_fetch_array($result1); $i++) {
        $len = strlen($row1['ca_id']) / 2 - 1;
        $nbsp = "";
        for ($i=0; $i<$len; $i++) $nbsp .= "&nbsp;&nbsp;&nbsp;";
        echo '<option value="'.$row1['ca_id'].'" '.get_selected($sca, $row1['ca_id']).'>'.$nbsp.$row1['ca_name'].PHP_EOL;
    }
    ?>
</select>

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="it_name" <?php echo get_selected($sfl, 'it_name'); ?>>상품명</option>
    <option value="it_id" <?php echo get_selected($sfl, 'it_id'); ?>>상품코드</option>
</select>

<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" required class="frm_input required">
<input type="submit" value="검색" class="btn_submit">

</form>

<?php // comcose_edit_2018.04.24 상품유형 카테고리 선택 시작 ?>
<style>
.comcose_acs_div {width:250px;margin-right:5px;float:left;text-align:center;font-weight:bold;color:#ff4600; }
.comcose_acs {width:250px; height:200px; padding:.5em;color:#222;margin-top:10px}
</style>
<?php $he_size = '15'; ?>

<div style="padding:0 0 256px 20px;">

<?php //1차 카테고리 ?>
<div class="comcose_acs_div">
1차 분류
<select class="comcose_acs" size="<?php echo $he_size ?>" name="ca_id1" onChange="comcose_acs(this)">

<?php 
$sql_ca_id1="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '2' order by ca_id ";
$result_ca_id1 = sql_query($sql_ca_id1);
for($i=0; $row_ca_id1 = sql_fetch_array($result_ca_id1); $i++){
?>

<option value=<?php echo $row_ca_id1[ca_id]; ?> <?php if($row_ca_id1[ca_id] == substr($sca, 0, 2)) echo 'selected'?>><?php echo $row_ca_id1[ca_name]; ?></option>

<?php } ?>

</select>
</div>

<?php //2차 카테고리 ?>
<div class="comcose_acs_div">
2차 분류
<select class="comcose_acs" size="<?php echo $he_size ?>"  name="ca_id2" onChange="comcose_acs(this)">

<?php 
$sql_ca_id2="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '4' and substring(ca_id,1,2) = substring('$sca',1,2) order by ca_id ";
$result_ca_id2 = sql_query($sql_ca_id2);
for($i=0; $row_ca_id2 = sql_fetch_array($result_ca_id2); $i++){
?>

<option value=<?php echo $row_ca_id2[ca_id]; ?> <?php if($row_ca_id2[ca_id] == substr($sca, 0, 4)) echo 'selected'?>><?php echo $row_ca_id2[ca_name]; ?></option>

<?php } ?>

</select>
</div>

<?php //3차 카테고리 ?>
<div class="comcose_acs_div">
3차 분류
<select class="comcose_acs" size="<?php echo $he_size ?>" name="ca_id3" onChange="comcose_acs(this)">  

<?php 
$sql_ca_id3="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '6' and substring(ca_id,1,4) = substring('$sca',1,4) order by ca_id ";
$result_ca_id3 = sql_query($sql_ca_id3);
for($i=0; $row_ca_id3 = sql_fetch_array($result_ca_id3); $i++){
?>

<option value=<?php echo $row_ca_id3[ca_id]; ?> <?php if($row_ca_id3[ca_id] == substr($sca, 0, 6)) echo 'selected'?>><?php echo $row_ca_id3[ca_name]; ?></option>

<?php } ?>

</select>
</div>

<?php //4차 카테고리 ?>
<div class="comcose_acs_div">
4차 분류
<select class="comcose_acs" size="<?php echo $he_size ?>" name="ca_id4" onChange="comcose_acs(this)">  

<?php 
$sql_ca_id4="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '8' and substring(ca_id,1,6) = substring('$sca',1,6) order by ca_id ";
$result_ca_id4 = sql_query($sql_ca_id4);
for($i=0; $row_ca_id4 = sql_fetch_array($result_ca_id4); $i++){
?>

<option value=<?php echo $row_ca_id4[ca_id]; ?> <?php if($row_ca_id4[ca_id] == substr($sca, 0, 8)) echo 'selected'?>><?php echo $row_ca_id4[ca_name]; ?></option>

<?php } ?>

</select>
</div>

<?php //5차 카테고리 ?>
<div class="comcose_acs_div">
5차 분류
<select class="comcose_acs" size="<?php echo $he_size ?>" name="ca_id5" onChange="comcose_acs(this)">  

<?php 
$sql_ca_id5="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '10' and substring(ca_id,1,8) = substring('$sca',1,8) order by ca_id ";
$result_ca_id5 = sql_query($sql_ca_id5);
for($i=0; $row_ca_id5 = sql_fetch_array($result_ca_id5); $i++){
?>

<option value=<?php echo $row_ca_id5[ca_id]; ?> <?php if($row_ca_id5[ca_id] == substr($sca, 0, 10)) echo 'selected'?>><?php echo $row_ca_id5[ca_name]; ?></option>

<?php } ?>

</select>
</div>

<script type="text/javascript">
function comcose_acs(sel_ca){ 
sel_ca= sel_ca.options[sel_ca.selectedIndex].value; 
location.replace("_comcose_itemtypelist.php?sca="+sel_ca+"&sfl=it_name&stx=");
}
</script>

</div>
<?php // comcose_edit_2018.04.24 상품유형 카테고리 선택 끝 ?>

<form name="fitemtypelist" method="post" action="./itemtypelistupdate.php">
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
    <tr>
        <th scope="col"><?php echo subject_sort_link("it_id", $qstr, 1); ?>상품코드</a></th>
        <th scope="col"><?php echo subject_sort_link("it_name"); ?>상품명</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type1", $qstr, 1); ?>히트<br>상품</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type2", $qstr, 1); ?>추천<br>상품</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type3", $qstr, 1); ?>신규<br>상품</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type4", $qstr, 1); ?>인기<br>상품</a></th>
        <th scope="col"><?php echo subject_sort_link("it_type5", $qstr, 1); ?>할인<br>상품</a></th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i=0; $row=sql_fetch_array($result); $i++) {
        $href = G5_SHOP_URL.'/item.php?it_id='.$row['it_id'];

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_code">
            <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
            <?php echo $row['it_id']; ?>
        </td>
        <td class="td_left"><a href="<?php echo $href; ?>"><?php echo get_it_image($row['it_id'], 50, 50); ?><?php echo cut_str(stripslashes($row['it_name']), 60, "&#133"); ?></a></td>
        <td class="td_chk2">
            <label for="type1_<?php echo $i; ?>" class="sound_only">히트상품</label>
            <input type="checkbox" name="it_type1[<?php echo $i; ?>]" value="1" id="type1_<?php echo $i; ?>" <?php echo ($row['it_type1'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_chk2">
            <label for="type2_<?php echo $i; ?>" class="sound_only">추천상품</label>
            <input type="checkbox" name="it_type2[<?php echo $i; ?>]" value="1" id="type2_<?php echo $i; ?>" <?php echo ($row['it_type2'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_chk2">
            <label for="type3_<?php echo $i; ?>" class="sound_only">신규상품</label>
            <input type="checkbox" name="it_type3[<?php echo $i; ?>]" value="1" id="type3_<?php echo $i; ?>" <?php echo ($row['it_type3'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_chk2">
            <label for="type4_<?php echo $i; ?>" class="sound_only">인기상품</label>
            <input type="checkbox" name="it_type4[<?php echo $i; ?>]" value="1" id="type4_<?php echo $i; ?>" <?php echo ($row['it_type4'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_chk2">
            <label for="type5_<?php echo $i; ?>" class="sound_only">할인상품</label>
            <input type="checkbox" name="it_type5[<?php echo $i; ?>]" value="1" id="type5_<?php echo $i; ?>" <?php echo ($row['it_type5'] ? 'checked' : ''); ?>>
        </td>
        <td class="td_mng td_mng_s">
            <a href="./itemform.php?w=u&amp;it_id=<?php echo $row['it_id']; ?>&amp;ca_id=<?php echo $row['ca_id']; ?>&amp;<?php echo $qstr; ?>" class="btn btn_03"><span class="sound_only"><?php echo cut_str(stripslashes($row['it_name']), 60, "&#133"); ?> </span>수정</a>
         </td>
    </tr>
    <?php
    }

    if (!$i)
        echo '<tr><td colspan="8" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <input type="submit" value="일괄수정" class="btn btn_01">
</div>
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
