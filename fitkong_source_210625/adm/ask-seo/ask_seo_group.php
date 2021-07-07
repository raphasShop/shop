<?php
/**
 * 게시판 그룹 SEO 설정
 */
$sub_menu = "100981";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');
if ($is_admin != 'super'){
    alert('최고관리자만 접근 가능합니다.');
}
$sql_common = " from {$g5['group_table']} ";

$sql_search = " where (1) ";
if ($is_admin != 'super')
    $sql_search .= " and (gr_admin = '{$member['mb_id']}') ";

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "gr_id" :
        case "gr_admin" :
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if ($sst)
    $sql_order = " order by {$sst} {$sod} ";
else
    $sql_order = " order by gr_id asc ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">처음</a>';

$g5['title'] = '게시판그룹 SEO 설정';
include_once(G5_ADMIN_PATH . '/admin.head.php');
add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/ask-seo/style.css">');

$colspan = 5;
?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">전체그룹</span><span class="ov_num">  <?php echo number_format($total_count) ?>개</span></span>
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="gr_subject"<?php echo get_selected($_GET['sfl'], "gr_subject"); ?>>제목</option>
    <option value="gr_id"<?php echo get_selected($_GET['sfl'], "gr_id"); ?>>ID</option>
    <option value="gr_admin"<?php echo get_selected($_GET['sfl'], "gr_admin"); ?>>그룹관리자</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" id="stx" value="<?php echo $stx ?>" required class="required frm_input">
<input type="submit" value="검색" class="btn_submit">
</form>

<div class="alert-info">
    /bbs/group.php?gr_id=group_id 그룹 페이지를 이용할 경우 그룹마다 keywords, description을 설정 할 수 있습니다.
</div>
<div class="alert-info">
    그룹설정 여분필드를 이용합니다. Keywords 는 <?php echo AS_GROUP_KEYWORDS_FIELD?>, Description은 <?php echo AS_GROUP_DESCRIPTION_FIELD?> 를 이용합니다.
    /plugin/ask-seo/ask-seo.config.php 파일을 수정하여 변경 할 수 있습니다.
</div>
<div class='alert-info'>
    <strong>SEO 설정을 하여도 검색 결과 출력은 보장하지 않습니다. 검색엔진이 분석하여 검색 노출 여부를 판단하게 됩니다. 따라서 노출을 보장하지는 않습니다.</strong>
</div>
<form name="fboardgrouplist" id="fboardgrouplist" action="./ask_seo_group_update.php" onsubmit="return fboardgrouplist_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">그룹 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col"><?php echo subject_sort_link('gr_id') ?>그룹아이디</a></th>
        <th scope="col"><?php echo subject_sort_link('gr_subject') ?>제목</a></th>        
        <th scope="col">Keywords</th>
        <th scope="col">Description</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        // 접근회원수
        $sql1 = " select count(*) as cnt from {$g5['group_member_table']} where gr_id = '{$row['gr_id']}' ";
        $row1 = sql_fetch($sql1);

        // 게시판수
        $sql2 = " select count(*) as cnt from {$g5['board_table']} where gr_id = '{$row['gr_id']}' ";
        $row2 = sql_fetch($sql2);

        $s_upd = '<a href="./boardgroup_form.php?'.$qstr.'&amp;w=u&amp;gr_id='.$row['gr_id'].'" class="btn_03 btn">수정</a>';

        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_chk">
            <input type="hidden" name="group_id[<?php echo $i ?>]" value="<?php echo $row['gr_id'] ?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo $row['gr_subject'] ?> 그룹</label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
        <td class="td_left"><a href="<?php echo G5_BBS_URL ?>/group.php?gr_id=<?php echo $row['gr_id'] ?>"><?php echo $row['gr_id'] ?></a></td>
        <td class="td_input">
            <?php echo get_text($row['gr_subject']) ?>
        </td>       
        <td>
            <!--meta keywords -->
            <input type='text' name='<?php echo AS_GROUP_KEYWORDS_FIELD;?>[<?php echo $i ?>]' id='<?php echo AS_GROUP_KEYWORDS_FIELD;?><?php echo $i ?>' value='<?php echo $row[AS_GROUP_KEYWORDS_FIELD];?>' class='tbl_input full_input' placeholder=',표 구분해서 입력'>
            <input type='hidden' name='<?php echo AS_GROUP_KEYWORDS_FIELD;?>_subj[<?php echo $i ?>]' value='Meta Keywords'/>
        </td>
        <td>
            <!-- meta description -->
            <textarea name='<?php echo AS_GROUP_DESCRIPTION_FIELD;?>[<?php echo $i ?>]' id='<?php echo AS_GROUP_DESCRIPTION_FIELD;?><?php echo $i ?>'class='tbl_input' placeholder='영문 320자, 한글 160자 이내로 입력'><?php echo $row[AS_GROUP_DESCRIPTION_FIELD]?></textarea>
            <input type='hidden' name='<?php echo AS_GROUP_DESCRIPTION_FIELD;?>_subj[<?php echo $i ?>]' value='Meta Description'/>
        </td>
    </tr>

    <?php
        }
    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </table>
</div>

<div class="btn_fixed_top">
    <input type="submit" name="act_button" onclick="document.pressed=this.value" value="선택수정" class="btn btn_02">
</div>
</form>

<?php
$pagelist = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page=');
echo $pagelist;
?>

<script>
function fboardgrouplist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    return true;
}
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>