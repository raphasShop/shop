<?php
$sub_menu = '455650'; /* 수정전 원본 메뉴코드 400650 */
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

$sql = " select *
           from {$g5['g5_shop_item_use_table']} a
           left join {$g5['member_table']} b on (a.mb_id = b.mb_id)
           left join {$g5['g5_shop_item_table']} c on (a.it_id = c.it_id)
          where is_id = '$is_id' ";
$is = sql_fetch($sql);

if (!$is['is_id'])
    alert('등록된 자료가 없습니다.');

// 사용후기 의 답변 필드 추가
if (!isset($is['is_reply_subject'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_use_table']}`
                ADD COLUMN `is_reply_subject` VARCHAR(255) NOT NULL DEFAULT '' AFTER `is_confirm`,
                ADD COLUMN `is_reply_content` TEXT NOT NULL AFTER `is_reply_subject`,
                ADD COLUMN `is_reply_name` VARCHAR(25) NOT NULL DEFAULT '' AFTER `is_reply_content`
                ", true);
}

$name = get_sideview($is['mb_id'], get_text($is['is_name']), $is['mb_email'], $is['mb_homepage']);

// 확인
$is_confirm_yes  =  $is['is_confirm'] ? 'checked="checked"' : '';
$is_confirm_no   = !$is['is_confirm'] ? 'checked="checked"' : '';

$g5['title'] = '사용후기';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$qstr .= ($qstr ? '&amp;' : '').'sca='.$sca;
?>

<form name="fitemuseform" method="post" action="./itemuseformupdate.php" onsubmit="return fitemuseform_submit(this);">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="is_id" value="<?php echo $is_id; ?>">
<input type="hidden" name="it_id" value="<?php echo $is['it_id']; ?>">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<!-- 후기상품 -->
<div class="tbl_head01 tbl_wrap">
    <?php
	$href = G5_SHOP_URL.'/item.php?it_id='.$is['it_id'];
	?>
    <table>
    <caption>후기상품</caption>
    <thead>
    <tr>
        <th scope="col">이미지</th>
        <th scope="col">상품명</th>
        <th scope="col">판매가</th>
        <th scope="col">바로가기</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="td_num"><a href="<?php echo $href; ?>" target="_blank"><?php echo get_it_image($is['it_id'], 100, 100); ?></a></td>
        <td><a href="<?php echo $href; ?>" target="_blank"><?php echo cut_str($is['it_name'],30); ?></a></td>
        <td class="td_numbig"><?php echo number_format($is['it_price']); ?></td>
        <td class="td_mng"><a href="<?php echo $href; ?>" target="_blank">상품보기</a></td>
    </tr>
    </tbody>
    </table>
</div>
<!-- // -->

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 수정</caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row">상품명</th>
        <td><a href="<?php echo G5_SHOP_URL; ?>/item.php?it_id=<?php echo $is['it_id']; ?>"><?php echo $is['it_name']; ?></a></td>
    </tr>
    <tr>
        <th scope="row">이름</th>
        <td><?php echo $name; ?></td>
    </tr>
    <tr>
        <?php
		//점수표시
		$is_score = $is['is_score'];
		if ($is_score == '1')
			$score_name = '<span class=score>매우불만</span>';
		else if ($is_score == '2')
			$score_name = '<span class=score>불만</span>';
		else if ($is_score == '3')
			$score_name = '<span class=score>보통</span>';
		else if ($is_score == '4')
			$score_name = '<span class=score>만족</span>';
		else if ($is_score == '5')
			$score_name = '<span class=score>매우만족</span>';
		?>
        <th scope="row">평점</th>
        <td><img src="<?php echo G5_ADMIN_URL; ?>/shop_admin/img/sp<?php echo $is['is_score']; ?>.png"> <?php echo $score_name; ?></td>
    </tr>
    <tr>
        <th scope="row"><label for="is_subject">제목</label></th>
        <td><input type="text" name="is_subject" required class="required frm_input" id="is_subject" size="100"
        value="<?php echo get_text($is['is_subject']); ?>"></td>
    </tr>
    <tr>
        <th scope="row">내용</th>
        <td><?php echo editor_html('is_content', get_text($is['is_content'], 0)); ?></td>
    </tr>
    <tr>
        <th scope="row"><label for="is_reply_subject">답변 제목</label></th>
        <td><input type="text" name="is_reply_subject" class="frm_input" id="is_reply_subject" size="100" value="<?php echo get_text($is['is_reply_subject']); ?>"></td>
    </tr>
    <tr>
        <th scope="row">답변 내용</th>
        <td><?php echo editor_html('is_reply_content', get_text($is['is_reply_content'], 0)); ?></td>
    </tr>
    <tr>
        <th scope="row">승인</th>
        <td height="50">
            <input type="radio" name="is_confirm" value="1" id="is_confirm_yes" <?php echo $is_confirm_yes; ?>>
            <label for="is_confirm_yes"><b>예.구매후기를 노출합니다</b></label>&nbsp;&nbsp;&nbsp;
            <input type="radio" name="is_confirm" value="0" id="is_confirm_no" <?php echo $is_confirm_no; ?>>
            <label for="is_confirm_no">아니오</label>
        </td>
    </tr>
    </tbody>
    </table>
</div>
<!--
<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="./itemuselist.php?<?php echo $qstr; ?>">목록</a>
</div>
-->
<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">   
    <div class="bq_basic">
    <a href="./itemuselist.php?<?php echo $qstr; ?>"><i class="fas fa-tasks"></i> 목록</a>
    </div>
    
    <div class="bq_basic_submit">
    <input type="submit" value="확인" accesskey="s">
    </div>
</div>
<!--//-->
</form>

<script>
function fitemuseform_submit(f)
{
    <?php echo get_editor_js('is_content'); ?>
    <?php echo get_editor_js('is_reply_content'); ?>
    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
