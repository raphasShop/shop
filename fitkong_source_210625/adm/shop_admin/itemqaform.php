<?php
$sub_menu = '455660'; /* 수정전 원본 메뉴코드 400660 */
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "w");

$sql = " select *
           from {$g5['g5_shop_item_qa_table']} a
           left join {$g5['g5_shop_item_table']} b on (a.it_id = b.it_id)
		   left join {$g5['member_table']} c on (a.mb_id = c.mb_id)
          where iq_id = '$iq_id' ";
$iq = sql_fetch($sql);

if (!$iq['iq_id']) alert('등록된 자료가 없습니다.');

$name = get_sideview($iq['mb_id'], get_text($iq['iq_name']), $iq['mb_email'], $iq['mb_homepage']);

$g5['title'] = '상품문의&amp;답변';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$qstr .= ($qstr ? '&amp;' : '').'sca='.$sca;
?>

<form name="fitemqaform" method="post" action="./itemqaformupdate.php" onsubmit="return fitemqaform_submit(this);">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="iq_id" value="<?php echo $iq_id; ?>">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="local_desc01 local_desc">
    <p>상품에 대한 문의에 답변하실 수 있습니다. 상품 문의 내용의 수정도 가능합니다.</p>
</div>

<!-- 문의상품 -->
<div class="tbl_head01 tbl_wrap">
    <?php
	$href = G5_SHOP_URL.'/item.php?it_id='.$iq['it_id'];
	?>
    <table>
    <caption>문의상품</caption>
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
        <td class="td_num"><a href="<?php echo $href; ?>" target="_blank"><?php echo get_it_image($iq['it_id'], 100, 100); ?></a></td>
        <td><a href="<?php echo $href; ?>" target="_blank"><?php echo cut_str($iq['it_name'],30); ?></a></td>
        <td class="td_numbig"><?php echo number_format($iq['it_price']); ?></td>
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
        <th scope="row">질문등록일</th>
        <td class="violet"><?php echo $iq['iq_time']; ?></td>
    </tr>
    <tr>
        <th scope="row">이름</th>
        <td><?php echo $name; ?></td>
    </tr>
    <?php if($iq['iq_email']) { ?>
    <tr>
        <th scope="row">이메일</th>
        <td><?php echo get_text($iq['iq_email']); ?></td>
    </tr>
    <?php } ?>
    <?php if($iq['iq_hp']) { ?>
    <tr>
        <th scope="row">휴대폰</th>
        <td><?php echo hyphen_hp_number($iq['iq_hp']); ?></td>
    </tr>
    <?php } ?>
    <tr>
        <th scope="row"><label for="iq_subject">제목</label></th>
        <td><input type="text" name="iq_subject" value="<?php echo conv_subject($iq['iq_subject'],120); ?>" id="iq_subject" required class="frm_input required" size="95"></td>
    </tr>
    <tr>
        <th scope="row"><label for="iq_question">질문</label></th>
        <td><?php echo editor_html('iq_question', get_text($iq['iq_question'], 0)); ?></td>
    </tr>
    <?php if($iq['iq_answer']) { ?>
    <tr>
        <th scope="row">답변일</th>
        <td class="orangered"><?php echo $iq['iq_timeanswer']; ?></td>
    </tr>
    <?php } ?>
    <tr>
        <th scope="row"><label for="iq_answer">답변</label></th>
        <td>
		<?php echo editor_html('iq_answer', get_text($iq['iq_answer'], 0)); ?>
        <?php if($iq['iq_answer']) { //답변이 있을경우?><div style="padding:8px 0px;" class="orangered"><b>※경고</b> : 답변을 했던 질문도 답변내용을 지우고 저장하시면, 답변일자는 초기화되고 '답변대기' 로 돌아갑니다</div><?php } //닫기?>
        </td>
        <!-- <td><textarea name="iq_answer" id="iq_answer" rows="7"><?php// echo get_text($iq['iq_answer']); ?></textarea></td> -->
    </tr>
    </tbody>
    </table>
</div>
<!--
<div class="btn_confirm01 btn_confirm">
    <?php if($iq['iq_answer']) { //답변이 있을경우?>
        <input type="submit" accesskey='s' value="저장" class="btn_submit">
    <?php } else { //답변이 없을경우?>
        <input type="submit" accesskey='s' value="답변하기" class="btn_submit">
    <?php } //닫기?>
    <a href="./itemqalist.php?<?php echo $qstr; ?>">취소</a>
    <a href="./itemqalist.php?<?php echo $qstr; ?>">목록</a>
</div>
-->
<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">   
    <div class="bq_basic">
    <a href="./itemqalist.php?<?php echo $qstr; ?>"><i class="fas fa-reply"></i> 취소</a>
    <a href="./itemqalist.php?<?php echo $qstr; ?>"><i class="fas fa-tasks"></i> 목록</a>
    </div>
    
    <div class="bq_basic_submit">
    <?php if($iq['iq_answer']) { //답변이 있을경우?>
        <input type="submit" accesskey='s' value="저장">
    <?php } else { //답변이 없을경우?>
        <input type="submit" accesskey='s' value="답변하기">
    <?php } //닫기?>
    </div>
</div>
<!--//-->

</form>

<script>
function fitemqaform_submit(f)
{
    <?php echo get_editor_js('iq_question'); ?>
    <?php echo get_editor_js('iq_answer'); ?>

    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>