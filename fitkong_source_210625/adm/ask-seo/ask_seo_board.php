<?php
$sub_menu = "100982";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super'){
    alert('최고관리자만 접근 가능합니다.');
}

$sql_common = " from {$g5['board_table']} a ";
$sql_search = " where (1) ";

if ($is_admin != "super") {
    $sql_common .= " , {$g5['group_table']} b ";
    $sql_search .= " and (a.gr_id = b.gr_id and b.gr_admin = '{$member['mb_id']}') ";
}

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "bo_table" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "a.gr_id" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "a.gr_id, a.bo_table";
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

$g5['title'] = '게시판 SEO 관리';
include_once G5_ADMIN_PATH . '/admin.head.php';
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/ask-seo/style.css">');

$colspan = 7;
?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">생성된 게시판수</span><span class="ov_num"> <?php echo number_format($total_count) ?>개</span></span>
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="bo_table"<?php echo get_selected($_GET['sfl'], "bo_table", true); ?>>TABLE</option>
    <option value="bo_subject"<?php echo get_selected($_GET['sfl'], "bo_subject"); ?>>제목</option>
    <option value="a.gr_id"<?php echo get_selected($_GET['sfl'], "a.gr_id"); ?>>그룹ID</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
<input type="submit" value="검색" class="btn_submit">

</form>


<div class='alert-info'>
    게시판별 Meta keywords 및 description 입력하세요. 
</div>
<div class="alert-info">
    게시판설정 여분필드를 이용합니다. 검색엔진차단은 <?php echo AS_BOARD_NOINDEX_FIELD?>번, Keywords 는 <?php echo AS_BOARD_KEYWORDS_FIELD?>, Description은 <?php echo AS_BOARD_DESCRIPTION_FIELD?> 를 이용합니다.
    /plugin/ask-seo/ask-seo.config.php 파일을 수정하여 변경 할 수 있습니다.
</div>
<div class='alert-info'>
    <strong>SEO 설정을 하여도 검색 결과 출력은 보장하지 않습니다. 검색엔진이 분석하여 검색 노출 여부를 판단하게 됩니다. 따라서 노출을 보장하지는 않습니다.</strong>
</div>
<form name="fboardlist" id="fboardlist" action="./ask_seo_board_update.php" onsubmit="return fboardlist_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="<?php echo $token ?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">게시판 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col"><?php echo subject_sort_link('a.gr_id') ?>그룹</a></th>
        <th scope="col"><?php echo subject_sort_link('bo_table') ?>TABLE</a></th>
        <th scope="col"><?php echo subject_sort_link('bo_subject') ?>제목</a></th>
        <th scope="col">검색엔진차단</th>
        <th scope="col">Keywords</th>
        <th scope="col">Description</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_chk">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['bo_subject']) ?></label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
        <td>
            <?php
                echo $row['gr_id'];
            ?>
        </td>
        <td>
            <input type="hidden" name="board_table[<?php echo $i ?>]" value="<?php echo $row['bo_table'] ?>">
            <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $row['bo_table'] ?>"><?php echo $row['bo_table'] ?></a>
        </td>
        <td>
            <?php echo get_text($row['bo_subject']) ?>
        </td>
        <td>
            <input type='checkbox' name='<?php echo AS_BOARD_NOINDEX_FIELD?>[<?php echo $i ?>]' id='<?php echo AS_BOARD_NOINDEX_FIELD?><?php echo $i ?>' value='1' class='' <?php if($row['bo_6']){echo 'checked';}?>>
            <input type='hidden' name='<?php echo AS_BOARD_NOINDEX_FIELD?>_subj[<?php echo $i ?>]' value='검색엔진차단'/>
        </td>
        <td>
            <!--meta keywords -->
            <input type='text' name='<?php echo AS_BOARD_KEYWORDS_FIELD?>[<?php echo $i ?>]' id='<?php echo AS_BOARD_KEYWORDS_FIELD?><?php echo $i ?>' value='<?php echo $row[AS_BOARD_KEYWORDS_FIELD]?>' class='tbl_input full_input' placeholder=',표 구분해서 입력'>
            <input type='hidden' name='<?php echo AS_BOARD_KEYWORDS_FIELD?>_subj[<?php echo $i ?>]' value='Meta Keywords'/>
        </td>
        <td>
            <!-- meta description -->
            <textarea name='<?php echo AS_BOARD_DESCRIPTION_FIELD?>[<?php echo $i ?>]' id='<?php echo AS_BOARD_DESCRIPTION_FIELD?><?php echo $i ?>'class='tbl_input' placeholder='영문 320자, 한글 160자 이내로 입력'><?php echo $row[AS_BOARD_DESCRIPTION_FIELD]?></textarea>
            <input type='hidden' name='<?php echo AS_BOARD_DESCRIPTION_FIELD?>_subj[<?php echo $i ?>]' value='Meta Description'/>
        </td>
    </tr>
    <?php
    }
    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="btn_02 btn">
</div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>

<script>
function fboardlist_submit(f)
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
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>
