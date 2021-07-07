<?php
$sub_menu = '600400';
include_once('./_common.php');

//comcose_edit_2018.04.23 추가테이블 생성 여부
$sql_add_level = " select count(*) as cnt from comcose_sellprice_level ";
$result_add_level = sql_fetch($sql_add_level);
$add_level_cnt = $result_add_level['cnt'];
if($add_level_cnt == 0) {
    goto_url("./_comcose_sellprice_setting.php");
}

auth_check($auth[$sub_menu], "r");
$g5['title'] = '제외 상품설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<?php 

$sql_common = " from comcose_sellprice_item_except ";
$sql_search = " where (1) ";

if ($stx) {$sql_search .= "and (($sfl like '%$stx%'))";}

if (!$sst) {
	$sst  = "cose_except_it_id";
	$sod = "asc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';
?>

<div class="local_ov01 local_ov">
    <?php echo $listall; ?>
    등록상품 <?php echo $total_count; ?>건
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="cose_except_add_it_name"<?php echo get_selected($_GET['sfl'], "cose_except_add_it_name", true); ?>>상품명</option>
    <option value="cose_except_add_it_id"<?php echo get_selected($_GET['sfl'], "cose_except_add_it_id"); ?>>상품코드</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
<input type="submit" value="검색" class="btn_submit">

</form>

<form name="fitemlistupdate" method="post" action="./_comcose_sellprice_item_except_form_update.php" onsubmit="return fitemlist_submit(this);" autocomplete="off">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th style="width:50px">
            <label for="chkall" class="sound_only">상품 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th style="width:50px">번호</th>
        <th style="width:400px">설정상품</th>
        <th id="th_img" style="width:80px">이미지</th>
        <th style="width:200px">상품코드</th>
        <th>전체분류</th>
    </tr>

    </thead>
    <tbody>
    <?php for ($i=1; $row=sql_fetch_array($result); $i++){ ?>
    
    <tr>
    	<?php //선택 ?>
        <td style="text-align:center">
        	<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i; ?>">
        </td>
        
        <?php //번호 ?>
        <td style="text-align:center">
            <input type="hidden" name="cose_except_it_id[<?php echo $i; ?>]" value="<?php echo $row['cose_except_it_id']; ?>">
            <?php echo $from_record + $i; ?>
        </td>
        
        <?php //설정상품 ?>
        <td style="text-align:left;padding-left:10px">
        <?php echo $row['cose_except_add_it_name'] ?>
        </td>
        
        <?php //이미지 ?>
        <td class="td_img"><?php echo get_it_image($row['cose_except_add_it_id'], 50, 50); ?></td>
        
        <?php //상품코드 ?>
        <td style="text-align:center">
        <?php echo $row['cose_except_add_it_id']; ?>
        </td>
        
        <?php //전체카테고리 ?>
        <td style="padding-left:10px">
        <?php
        $cat1_id = substr($row['cose_except_add_it_caid'], 0, 2);
        $cat1_ca_id_sql="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '2' and ca_id = '$cat1_id' order by ca_id ";
        $cat1_ca_id_result= sql_query($cat1_ca_id_sql);
        $cat1_ca_id_row = sql_fetch_array($cat1_ca_id_result);
        $cat1 = $cat1_ca_id_row['ca_name'];
        $cat2_id = substr($row['cose_except_add_it_caid'], 0, 4);
        $cat2_ca_id_sql="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '4' and ca_id = '$cat2_id' order by ca_id ";
        $cat2_ca_id_result= sql_query($cat2_ca_id_sql);
        $cat2_ca_id_row = sql_fetch_array($cat2_ca_id_result);
        $cat2 = $cat2_ca_id_row['ca_name'];
        $cat3_id = substr($row['cose_except_add_it_caid'], 0, 6);
        $cat3_ca_id_sql="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '6' and ca_id = '$cat3_id' order by ca_id ";
        $cat3_ca_id_result= sql_query($cat3_ca_id_sql);
        $cat3_ca_id_row = sql_fetch_array($cat3_ca_id_result);
        $cat3 = $cat3_ca_id_row['ca_name'];
        $cat4_id = substr($row['cose_except_add_it_caid'], 0, 8);
        $cat4_ca_id_sql="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '8' and ca_id = '$cat4_id' order by ca_id ";
        $cat4_ca_id_result= sql_query($cat4_ca_id_sql);
        $cat4_ca_id_row = sql_fetch_array($cat4_ca_id_result);
        $cat4 = $cat4_ca_id_row['ca_name'];
        $cat5_id = substr($row['cose_except_add_it_caid'], 0, 10);
        $cat5_ca_id_sql="SELECT ca_id, ca_name FROM g5_shop_category where length(ca_id) = '10' and ca_id = '$cat5_id' order by ca_id ";
        $cat5_ca_id_result= sql_query($cat5_ca_id_sql);
        $cat5_ca_id_row = sql_fetch_array($cat5_ca_id_result);
        $cat5 = $cat5_ca_id_row['ca_name'];
        $cat_id_level = strlen($row['cose_except_add_it_caid']) / 2;
        $tag = ' ▷ ';
        if ($cat_id_level== 1){echo '<b>'.$cat1.'</b>';}
        else if ($cat_id_level== 2){echo $cat1.$tag.'<b>'.$cat2.'</b>';}
        else if ($cat_id_level== 3){echo $cat1.$tag.$cat2.$tag.'<b>'.$cat3.'<b>';}
        else if ($cat_id_level== 4){echo $cat1.$tag.$cat2.$tag.$cat3.$tag.'<b>'.$cat4.'</b>';}
        else if ($cat_id_level== 5){echo $cat1.$tag.$cat2.$tag.$cat3.$tag.$cat4.$tag.'<b>'.$cat5.'</b>';}
		?>
        </td>
        
    </tr>
    <?php }
    if ($total_count == 0)
        echo '<tr><td colspan="12" class="empty_table">등록된 상품이 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
	<a href="./_comcose_sellprice_item_except_form.php" class="btn btn_01">상품등록</a>
    <?php if ($is_admin == 'super') { ?>
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_02">
    <?php } ?>
</div>

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
        if(!confirm("선택한 상품을 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>