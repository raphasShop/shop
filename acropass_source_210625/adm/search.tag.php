<?php
//<- 오류 모두 표시 
error_reporting(E_ALL); 
ini_set('display_errors','On');

$sub_menu = "155501";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super')
	alert('추천검색어설정은 최고관리자만 가능합니다.');

// 관리자 > 최적화 > 아이스크림DB업데이트를 실행하셔야 DB설치가 완료됩니다.

$sql = " select * from {$g5['search_tag_table']}";
$tag = sql_fetch($sql);
$w = $_POST['w'];
$search_tag_1 = $_POST['search_tag_1'];
$search_tag_2 = $_POST['search_tag_2'];
$search_tag_3 = $_POST['search_tag_3'];
$search_tag_4 = $_POST['search_tag_4'];
$search_tag_5 = $_POST['search_tag_5'];
$search_tag_6 = $_POST['search_tag_6'];
$search_tag_7 = $_POST['search_tag_7'];
$search_tag_8 = $_POST['search_tag_8'];
$search_tag_9 = $_POST['search_tag_9'];
$search_tag_10 = $_POST['search_tag_10'];




if ($w == '')
{
    //$mb['mb_open'] = 1;
    //$mb['mb_level'] = $config['cf_register_level'];
}
else if ($w == 'u')
{
	check_admin_token();
	echo $_POST['search_tag_2'];
	$sql = " update {$g5['search_tag_table']}
            set search_tag_1 = '$search_tag_1',
				search_tag_2 = '$search_tag_2',
                search_tag_3 = '$search_tag_3',
                search_tag_4 = '$search_tag_4',
                search_tag_5 = '$search_tag_5',
                search_tag_6 = '$search_tag_6',
                search_tag_7 = '$search_tag_7',
                search_tag_8 = '$search_tag_8',
				search_tag_9 = '$search_tag_9',
                search_tag_10 = '$search_tag_10'
            where tag_id = 1 ";
	sql_query($sql);
	goto_url($PHP_SELF, false);
}

$g5['title'] .= '추천검색어설정 ';
include_once('./admin.head.php');

$frm_submit = '<div class="btn_confirm01 btn_confirm" style="width:100%;">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

$colspan = 2;
?>

<div class="local_desc01 local_desc">
    <p>
        추천검색어를 관리 할수있는 페이지입니다.
		<br><strong>검색 페이지</strong> 에 표기됩니다.<?php echo $_POST['search_tag_2']; ?>
    </p>
</div>

<form name="search_tag" id="search_tag"  action="./search.tag.php" method="post" onsubmit="return search_tag_submit(this);"  enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="w" value="u">
<input type="hidden" name="token" value="" id="token">

<div class="tbl_head01 tbl_wrap">
    <table style="width:100%;">
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
		<tr>
			<th scope="col" style="width:250px;">순서</th>
			<th scope="col">키워드</th>
		</tr>
    </thead>
    <tbody>
		<?php for ($i=1; $i<=10; $i++) { ?>
		<tr>
			<td class="center"><?=$i?></td>
			<td>
			<?php
				//if($i==11 || $i==1)	echo $config["lev_cf_".$i]; // 1,10은 수정불가
				//} else {
					echo "<input type='text' name='search_tag_{$i}' value='".$tag["search_tag_".$i]."' class='frm_input'>";
				//}
			?>
			</td>
		</tr>
		<?php } ?>
	
    </tbody>
    </table>
</div>

<?php //echo $frm_submit;?>

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">
    <div class="bq_basic_submit">
    <input type="submit" value="확인" accesskey="s">
    </div>
</div>
<!--//-->

</form>
<script>
function search_tag_submit(){
	return true;	
}
</script>
<?php
include_once('./admin.tail.php');
?>