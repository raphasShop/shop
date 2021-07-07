<?php
$sub_menu = '155601'; /* 수정전 원본 메뉴코드 500500 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$rvp_id = preg_replace('/[^0-9]/', '', $rvp_id);

$html_title = '리뷰';
$g5['title'] = $html_title.'관리';

$sql = " select * from {$g5['g5_shop_item_table']} ";
$itemresult = sql_query($sql);

if ($w=="u")
{
    $html_title .= ' 수정';
    $sql = " select * from {$g5['g5_shop_review_popup_table']} where rvp_id = '$rvp_id' ";
    $rvp = sql_fetch($sql);
}
else
{
    $html_title .= ' 입력';
    $rvp['rvp_url']        = "http://";
    $rvp['rvp_begin_time'] = date("Y-m-d 00:00:00", time());
    $rvp['rvp_end_time']   = date("Y-m-d 00:00:00", time()+(60*60*24*730));
}

include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="fbanner" action="./review_popup_update.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="rvp_id" value="<?php echo $rvp_id; ?>">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="rvp_pid">상품선택</label></th>
        <td>
            <?php echo help('리뷰를 표시할 상품을 선택해주세요'); ?> 
            <select name="rvp_pid" id="rvp_pid">
                <?php for($i=0; $row=sql_fetch_array($itemresult); $i++) { ?>
                <option value="<?php echo $row['it_id']; ?>"<?php echo get_selected($rvp['it_id'], $row['it_id']); ?>><?php echo $row['it_name']; ?></option>
                <?php } ?>
            </select>
        </td>
    </tr>    
    <tr>
        <th scope="row"><label for="bn_img_url">이미지 주소</label></th>
        <td>
            <?php echo help("외부 서버에 업로드 된 이미지 링크 주소 입니다."); ?>
            <input type="text" name="rvp_img_url" size="80" value="<?php echo $rvp['rvp_img_url']; ?>" id="rvp_img_url" class="frm_input">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_alt">이미지 설명</label></th>
        <td>
            <?php echo help("img 태그의 alt, title 에 해당되는 내용입니다.\n이미지에 마우스를 오버하면 이미지의 설명이 나옵니다."); ?>
            <input type="text" name="rvp_alt" value="<?php echo get_text($rvp['rvp_alt']); ?>" id="rvp_alt" class="frm_input" size="80">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="rvp_title">제목</label></th>
        <td>
            <?php echo help("리뷰의 제목을 입력하는 곳입니다."); ?>
            <input type="text" name="rvp_title" value="<?php echo get_text($rvp['rvp_title']); ?>" id="rvp_title" class="frm_input" size="80">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="rvp_contents">내용</label></th>
        <td>
            <?php echo help("리뷰의 간략한 내용을 입력하는 곳입니다."); ?>
            <input type="text" name="rvp_contents" value="<?php echo get_text($rvp['rvp_contents']); ?>" id="rvp_contents" class="frm_input" size="80">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="rvp_url">링크</label></th>
        <td>
            <?php echo help("리뷰클릭시 이동하는 주소입니다."); ?>
            <input type="text" name="rvp_url" size="80" value="<?php echo $rvp['rvp_url']; ?>" id="rvp_url" class="frm_input">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="rvp_channel">채널</label></th>
        <td>
            <?php echo help("리뷰가 작성된 채널명을 입력해주세요.\nex)네이버블로그"); ?>
            <input type="text" name="rvp_channel" size="80" value="<?php echo $rvp['rvp_channel']; ?>" id="rvp_channel" class="frm_input">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="rvp_reviewer">작성자</label></th>
        <td>
            <?php echo help("리뷰를 작성한 작성자의 닉네임을 입력해주세요."); ?>
            <input type="text" name="rvp_reviewer" size="80" value="<?php echo $rvp['rvp_reviewer']; ?>" id="rvp_reviewer" class="frm_input">
        </td>
    </tr>
    <?php if ($w=="u") { ?>
    <tr>
        <th scope="row"><label for="rvp_use">노출여부</label></th>
        <td>
            <?php echo help('리뷰를 표시할 상품을 선택해주세요'); ?> 
            <select name="rvp_use" id="rvp_use">
                <option value=1 <?php echo get_selected($rvp['rvp_use'], 1); ?>>노출</option>
                <option value=0 <?php echo get_selected($rvp['rvp_use'], 0); ?>>노출중지</option>
            </select>
        </td>
    </tr>
    <? } ?>    
    <tr>
    <tr style="display: none">
        <th scope="row"><label for="rvp_begin_time">시작일시</label></th>
        <td>
            <?php echo help("배너 게시 시작일시를 설정합니다."); ?>
            <input type="text" name="bn_begin_time" value="<?php echo $bn['bn_begin_time']; ?>" id="bn_begin_time" class="frm_input"  size="21" maxlength="19">
            <input type="checkbox" name="bn_begin_chk" value="<?php echo date("Y-m-d 00:00:00", time()); ?>" id="bn_begin_chk" onclick="if (this.checked == true) this.form.bn_begin_time.value=this.form.bn_begin_chk.value; else this.form.bn_begin_time.value = this.form.bn_begin_time.defaultValue;">
            <label for="bn_begin_chk">오늘</label>
        </td>
    </tr>
    <tr style="display: none">
        <th scope="row"><label for="rvp_end_time">종료일시</label></th>
        <td>
            <?php echo help("배너 게시 종료일시를 설정합니다."); ?>
            <input type="text" name="bn_end_time" value="<?php echo $bn['bn_end_time']; ?>" id="bn_end_time" class="frm_input" size=21 maxlength=19>
            <input type="checkbox" name="bn_end_chk" value="<?php echo date("Y-m-d 23:59:59", time()+60*60*24*31); ?>" id="bn_end_chk" onclick="if (this.checked == true) this.form.bn_end_time.value=this.form.bn_end_chk.value; else this.form.bn_end_time.value = this.form.bn_end_time.defaultValue;">
            <label for="bn_end_chk">오늘+31일</label>
        </td>
    </tr>
    <tr style="display: none"> 
        <th scope="row"><label for="rvp_order">출력 순서</label></th>
        <td>
           <?php echo help("리뷰를 출력할 때 순서를 정합니다. 숫자가 작을수록 먼저 출력됩니다."); ?>
           <?php echo order_select("rvp_order", $rvp['rvp_order']); ?>
        </td>
    </tr>
    </tbody>
    </table>
</div>
<!--
<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="./bannerlist.php">목록</a>
</div>
-->
<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">   
    <div class="bq_basic">
    <a href="./review_popup_list.php"><i class="fas fa-tasks"></i> 목록</a>
    </div>
    
    <div class="bq_basic_submit">
    <input type="submit" value="확인" accesskey="s">
    </div>
</div>
<!--//-->

</form>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
