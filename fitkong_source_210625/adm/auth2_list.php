<?php
$sub_menu = "100200";
include_once('./_common.php');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$sql_common = " from {$g5['auth_table']} a left join {$g5['member_table']} b on (a.mb_id=b.mb_id) ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        default :
            $sql_search .= " ({$sfl} like '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "a.mb_id, au_menu";
    $sod = "";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search}
            {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            {$sql_order}
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);

//전체보기 echo $listall; - 아이스크림
$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'"><button type="button"><i class="fa fa-bars"></i>&nbsp;전체</button></a>';

$g5['title'] = "관리권한설정-한번에등록";
include_once('./admin.head.php');

// 한번에 여러개를 선택하여 권한을 주는 방식으로 변경 - 아이스크림 2018-02-26
$_tmp_auth = array();
foreach($amenu as $key=>$value)
{
	foreach($menu['menu'.$key] as $_key=>$_val) 
	{
		if (!($_val[0] == '-' || !$_val[0])) 
		{
			$_tmp_auth[$key]['key'][] = $_val[0];
			$_tmp_auth[$key]['val'][] = $_val[1];
		}
	}
}
//

$colspan = 5;
?>

<!-- 검색창 -->
<div class="dan-schbox-none" style="text-align:center;margin-bottom:10px;"><!-- 검색창 -->
    <div class="row"><!-- row 시작 { -->
<form name="fsearch" id="fsearch" class="big_sch01 big_sch" method="get">
<input type="hidden" name="sfl" value="a.mb_id" id="sfl">
<div class="sch_last">
<label for="stx" class="sound_only">회원아이디<strong class="sound_only"> 필수</strong></label>
<?php if($stx) { //검색어가 있을경우?>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input_big">
<?php } else { //검색어가 없을경우?>
<input type="text" name="stx" onFocus="this.value='';" value="회원아이디로 검색" id="stx" required class="required frm_input_big">
<?php } ?>

<input type="submit" value="검색" id="fsearch_submit" class="btn_submit_big">
<?php echo $listall; //전체보기?>
</div>
</form>
    </div><!-- } row 끝 -->
 </div><!-- 검색창 -->
<!-- 검색창 끝 -->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <strong><?php echo number_format($total_count) ?></strong> 개의 설정된 관리권한이 검색되었습니다
</div>
<!-- // -->

<form name="fauthlist" id="fauthlist" method="post" action="./auth2_list_delete.php" onSubmit="return fauthlist_submit(this);">
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
            <label for="chkall" class="sound_only">현재 페이지 회원 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onClick="check_all(this.form)">
        </th>
        <th scope="col"><?php echo subject_sort_link('a.mb_id') ?>회원아이디</a></th>
        <th scope="col"><?php echo subject_sort_link('mb_nick') ?>닉네임</a></th>
        <th scope="col">메뉴</th>
        <th scope="col">권한</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $count = 0;
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $is_continue = false;
        // 회원아이디가 없는 메뉴는 삭제함
        if($row['mb_id'] == '' && $row['mb_nick'] == '') {
            sql_query(" delete from {$g5['auth_table']} where au_menu = '{$row['au_menu']}' ");
            $is_continue = true;
        }

        // 메뉴번호가 바뀌는 경우에 현재 없는 저장된 메뉴는 삭제함
        if (!isset($auth_menu[$row['au_menu']]))
        {
            sql_query(" delete from {$g5['auth_table']} where au_menu = '{$row['au_menu']}' ");
            $is_continue = true;
        }

        if($is_continue)
            continue;

        $mb_nick = get_sideview($row['mb_id'], $row['mb_nick'], $row['mb_email'], $row['mb_homepage']);

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_chk">
            <input type="hidden" name="au_menu[<?php echo $i ?>]" value="<?php echo $row['au_menu'] ?>">
            <input type="hidden" name="mb_id[<?php echo $i ?>]" value="<?php echo $row['mb_id'] ?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo $row['mb_nick'] ?>님 권한</label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
        <td class="td_mbid"><a href=""><?php echo $row['mb_id'] ?></a></td>
        <td class="td_auth_mbnick"><?php echo $mb_nick ?></td>
        <td class="td_menu">
            <?php echo $row['au_menu'] ?>
            <?php echo $auth_menu[$row['au_menu']] ?>
        </td>
        <td class="td_auth"><?php echo $row['au_auth'] ?></td>
    </tr>
    <?php
        $count++;
    }

    if ($count == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_list01 btn_list">
    <input type="submit" name="act_button" value="선택삭제" onClick="document.pressed=this.value">
</div>

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">
    <div class="bq_basic">
	<?php if ($is_admin == 'super') { ?>
    <input type="submit" name="act_button" value="선택삭제" onClick="document.pressed=this.value">
	<?php } ?>
    </div>
</div>
<!--//-->

<?php
//if (isset($stx))
//    echo '<script>document.fsearch.sfl.value = "'.$sfl.'";</script>'."\n";

if (strstr($sfl, 'mb_id'))
    $mb_id = $stx;
else
    $mb_id = '';
?>
</form>

<?php
$pagelist = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page=');
echo $pagelist;
?>

<form name="fauthlist2" id="fauthlist2" action="./auth2_update.php" method="post" autocomplete="off" onSubmit="return fauthlist_submit2(this);">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<section id="add_admin">
    <h2 class="h2_frm">관리권한 추가</h2>

    <div class="local_desc01 local_desc">
        <p>
            다음 양식에서 회원에게 관리권한을 부여하실 수 있습니다.<br>
            권한 <strong>r</strong>은 읽기권한, <strong>w</strong>는 쓰기권한, <strong>d</strong>는 삭제권한입니다.
        </p>
    </div>
    
<!-- 탭메뉴 -->
<?php
   $ice_basename = basename($_SERVER["PHP_SELF"]); //현재 실행되고 있는 페이지명만 구합니다.
   $pagetab_style = 'style="color:#333949;border:1px solid #5A6171;border-bottom:0px solid #fff;background:#FFF;"';
?>
<div><!-- 링크 탭 시작 -->
<ul class="pagetab">
    <li><a href="<?php echo G5_ADMIN_URL;?>/auth_list.php#add_admin" <?php if($ice_basename == 'auth_list.php') echo $pagetab_style;?>>한개씩 등록</a></li>
    <li><a href="<?php echo G5_ADMIN_URL;?>/auth2_list.php#add_admin" <?php if($ice_basename == 'auth2_list.php') echo $pagetab_style;?>>한번에 등록</a></li>
</ul>
</div><!-- 링크 탭 끝// -->
<!--//-->

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="mb_id">회원아이디<strong class="sound_only">필수</strong></label></th>
            <td>
                <strong id="msg_mb_id" class="msg_sound_only"></strong>
                <input type="text" name="mb_id" value="<?php echo $mb_id ?>" id="mb_id" required class="required frm_input">
            </td>
        </tr>
        <tr>
            <th scope="row">권한지정</th>
            <td>
                <input type="checkbox" name="r" value="r" id="r" checked>
                <label for="r">r (읽기)</label>
                <input type="checkbox" name="w" value="w" id="w">
                <label for="w">w (쓰기)</label>
                <input type="checkbox" name="d" value="d" id="d">
                <label for="d">d (삭제)</label>
            </td>
        </tr>
        <tr>
            <td colspan="2"><label for="au_menu">접근가능메뉴<strong class="sound_only">필수</strong></label></td>
        </tr>
        <tr>
            <td colspan="2">
            
           
<?php // 표 1열 생성 시작
$idx = 0;
foreach($amenu as $key=>$value)
{
?>

<div class="div_td1">
    <ul>
	<div class="div_td1_title"><?php echo $_tmp_auth[$key]['val'][0]; ?>[<?php echo $key; ?>]</div>
	<?php //선택항목 출력 시작
    for($i=0; $i<count($_tmp_auth[$key]['key']); $i++) {
    if($i == 0) continue;
    ?>
    <li>
    <input type="hidden" name="au_menu[]" id="au_menu<?php echo $idx ?>" value="<?php echo $_tmp_auth[$key]['key'][$i]; ?>" />
    <input type="checkbox" name="auth_chk[]" id="auth_chk_<?php echo $idx ?>" class="<?php echo $key; ?>" value="<?php echo $idx ?>">
    <label for="auth_chk_<?php echo $idx ?>"><?php echo $_tmp_auth[$key]['key'][$i]; ?> : <?php echo $_tmp_auth[$key]['val'][$i]; ?></label>
    </li>
    <?php
    $idx++;
    }
    //선택항목 출력 끝 ?>
    </ul>
</div>

<? } // 표 1열 생성 끝?>
                  
                    
            </td>
        </tr>
        
        </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="추가" class="btn_submit">
    </div>
</section>

</form>

<script>
function fauthlist_submit(f)
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

function fauthlist_submit2(f)
{
    if (!is_checked("auth_chk[]")) {
        alert("메뉴를 하나 이상 선택하세요");
        return false;
    }

	if(!confirm("선택한 메뉴를 추가 하시겠습니까?")) {
		return false;
	}

    return true;
}
</script>

<?php
include_once ('./admin.tail.php');
?>
