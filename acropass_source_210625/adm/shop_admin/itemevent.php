<?php
$sub_menu = '422300'; /* 수정전 원본 메뉴코드 500300 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '이벤트(기획전)관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$sql_common = " from {$g5['g5_shop_event_table']} ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = "select * $sql_common order by ev_id desc ";
$result = sql_query($sql);
?>

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">
    <div class="bq_basic_add">
    <a href="./itemeventform.php"><i class="fas fa-plus"></i> 이벤트추가</a>
    </div>
</div>
<!--//-->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <strong><?php echo number_format($total_count) ?></strong> 개의 이벤트(기획전)이 검색되었습니다.
</div>
<!-- // -->

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">이벤트번호</th>
        <th scope="col">제목</th>
        <th scope="col">연결상품</th>
        <th scope="col">사용</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {

        $href = "";
        $sql = " select count(ev_id) as cnt from {$g5['g5_shop_event_item_table']} where ev_id = '{$row['ev_id']}' ";
        $ev = sql_fetch($sql);
        if ($ev['cnt']) {
            $href = '<a href="javascript:;" onclick="itemeventwin('.$row['ev_id'].');">';
            $href_close = '</a>';
        }
        if ($row['ev_subject_strong']) $subject = '<strong>'.$row['ev_subject'].'</strong>';
        else $subject = $row['ev_subject'];
		
		$bg = 'bg'.($i%2);
		
		// 완료,진행중 테이블색상 class 지정 - 아이스크림
		$td_color = 0;
        if($row['ev_use']) { // 사용할경우
            $bg .= '';
            $td_color = 1;
		} else { // 사용않할경우
		    $bg .= 'end';
            $td_color = 1;
		}
    ?>

    <tr class="<?php echo ' '.$bg; ?>">
        <td class="center"><?php echo $row['ev_id']; ?></td>
        <td><?php echo $subject; ?></td>
        <td class="td_num"><?php echo $href; ?><?php echo $ev['cnt']; ?><?php echo $href_close; ?></td>
        <td class="td_boolean"><?php echo $row['ev_use'] ? '<span class="date_round">YES</span>' : '<span class="gray">아니오</span>'; ?></td>
        <td class="td_mng">
            <a href="./itemeventform.php?w=u&amp;ev_id=<?php echo $row['ev_id']; ?>">수정</a>
            <a href="<?php echo G5_SHOP_URL; ?>/event.php?ev_id=<?php echo $row['ev_id']; ?>">보기</a>
            <a href="./itemeventformupdate.php?w=d&amp;ev_id=<?php echo $row['ev_id']; ?>" onclick="return delete_confirm(this);">삭제</a>
        </td>
    </tr>

    <?php
    }

    if ($i == 0) {
        echo '<tr><td colspan="5" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>

<script>
function itemeventwin(ev_id)
{
    window.open("./itemeventwin.php?ev_id="+ev_id, "itemeventwin", "left=10,top=10,width=500,height=600,scrollbars=1");
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
