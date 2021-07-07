<?php
$sub_menu = '155701'; /* 수정전 원본 메뉴코드 500500 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$bn_id = preg_replace('/[^0-9]/', '', $bn_id);

$html_title = '배너';
$g5['title'] = $html_title.'관리';

if ($w=="u")
{
    $html_title .= ' 수정';
    $sql = " select * from {$g5['g5_shop_con_banner_table']} where bn_id = '$bn_id' ";
    $bn = sql_fetch($sql);
}
else
{
    $html_title .= ' 입력';
    $bn['bn_url']        = "http://";
    $bn['bn_begin_time'] = date("Y-m-d 00:00:00", time());
    $bn['bn_end_time']   = date("Y-m-d 00:00:00", time()+(60*60*24*730));
}

include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="fbanner" action="./con_bannerformupdate.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="bn_id" value="<?php echo $bn_id; ?>">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row">이미지</th>
        <td>
            <input type="file" name="bn_bimg">
            <?php
            $bimg_str = "";
            $bimg = G5_DATA_PATH."/con_banner/{$bn['bn_id']}";
            if (file_exists($bimg) && $bn['bn_id']) {
                $size = @getimagesize($bimg);
                if($size[0] && $size[0] > 750)
                    $width = 750;
                else
                    $width = $size[0];

                echo '<input type="checkbox" name="bn_bimg_del" value="1" id="bn_bimg_del"> <label for="bn_bimg_del">삭제</label>';
                $bimg_str = '<img src="'.G5_DATA_URL.'/con_banner/'.$bn['bn_id'].'" width="'.$width.'">';
            }
            if ($bimg_str) {
                echo '<div class="banner_or_img">';
                echo $bimg_str;
                echo '</div>';
            }
            ?>
        </td>
    </tr>
     <tr>
        <th scope="row"><label for="bn_img_url">이미지 주소</label></th>
        <td>
            <?php echo help("외부 서버에 업로드 된 이미지 링크 주소 입니다.\n외부 이미지 링크 주소가 존재하면, 업로드 된 이미지 보다 우선하여 배너로 출력합니다."); ?>
            <input type="text" name="bn_img_url" size="80" value="<?php echo $bn['bn_img_url']; ?>" id="bn_img_url" class="frm_input">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_alt">이미지 설명</label></th>
        <td>
            <?php echo help("img 태그의 alt, title 에 해당되는 내용입니다.\n배너에 마우스를 오버하면 이미지의 설명이 나옵니다."); ?>
            <input type="text" name="bn_alt" value="<?php echo get_text($bn['bn_alt']); ?>" id="bn_alt" class="frm_input" size="80">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_alt">메인 타이틀</label></th>
        <td>
            <?php echo help("메인 타이틀 설명입니다."); ?>
            <input type="text" name="bn_main_title" value="<?php echo get_text($bn['bn_main_title']); ?>" id="bn_main_title" class="frm_input" size="80">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_alt">서브 타이틀</label></th>
        <td>
            <?php echo help("서브 타이틀 설명입니다."); ?>
            <input type="text" name="bn_sub_title" value="<?php echo get_text($bn['bn_sub_title']); ?>" id="bn_sub_title" class="frm_input" size="80">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_url">링크</label></th>
        <td>
            <?php echo help("배너클릭시 이동하는 주소입니다."); ?>
            <input type="text" name="bn_url" size="80" value="<?php echo $bn['bn_url']; ?>" id="bn_url" class="frm_input">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_new_win">새창</label></th>
        <td>
            <?php echo help("배너클릭시 새창을 띄울지를 설정합니다.", 50); ?>
            <!--<select name="bn_new_win" id="bn_new_win">
                <option value="0" <?php echo get_selected($bn['bn_new_win'], 0); ?>>사용안함</option>
                <option value="1" <?php echo get_selected($bn['bn_new_win'], 1); ?>>사용</option>
            </select>-->
            <label class="switch-check">
            <input type="checkbox" name="bn_new_win" value="1" id="bn_new_win"<?php echo $bn['bn_new_win']?' checked':''; ?>> 사용
            <div class="check-slider round"></div>
            </label>
            <label for="bn_new_win">새창으로 열기설정</label>
        </td>
    </tr>
    <tr style="display: none">
        <th scope="row"><label for="bn_begin_time">시작일시</label></th>
        <td>
            <?php echo help("배너 게시 시작일시를 설정합니다."); ?>
            <input type="text" name="bn_begin_time" value="<?php echo $bn['bn_begin_time']; ?>" id="bn_begin_time" class="frm_input"  size="21" maxlength="19">
            <input type="checkbox" name="bn_begin_chk" value="<?php echo date("Y-m-d 00:00:00", time()); ?>" id="bn_begin_chk" onclick="if (this.checked == true) this.form.bn_begin_time.value=this.form.bn_begin_chk.value; else this.form.bn_begin_time.value = this.form.bn_begin_time.defaultValue;">
            <label for="bn_begin_chk">오늘</label>
        </td>
    </tr>
    <tr style="display: none">
        <th scope="row"><label for="bn_end_time">종료일시</label></th>
        <td>
            <?php echo help("배너 게시 종료일시를 설정합니다."); ?>
            <input type="text" name="bn_end_time" value="<?php echo $bn['bn_end_time']; ?>" id="bn_end_time" class="frm_input" size=21 maxlength=19>
            <input type="checkbox" name="bn_end_chk" value="<?php echo date("Y-m-d 23:59:59", time()+60*60*24*31); ?>" id="bn_end_chk" onclick="if (this.checked == true) this.form.bn_end_time.value=this.form.bn_end_chk.value; else this.form.bn_end_time.value = this.form.bn_end_time.defaultValue;">
            <label for="bn_end_chk">오늘+31일</label>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_device">접속기기</label></th>
        <td>
            <?php echo help('배너를 표시할 접속기기를 선택합니다.'); ?>
            <select name="bn_device" id="bn_device">
                <option value="pc"<?php echo get_selected($bn['bn_device'], 'pc'); ?>>PC</option>
                <option value="mobile"<?php echo get_selected($bn['bn_device'], 'mobile'); ?>>모바일</option>
        </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_order">출력 순서</label></th>
        <td>
           <?php echo help("배너를 출력할 때 순서를 정합니다. 숫자가 작을수록 먼저 출력됩니다."); ?>
           <?php echo order_select("bn_order", $bn['bn_order']); ?>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_use">배너 사용</label></th>
        <td>
            <?php echo help('배너 사용 여부를 선택합니다.'); ?>
            <select name="bn_use" id="bn_use">
                <option value="1"<?php echo get_selected($bn['bn_use'], 1); ?>>사용</option>
                <option value="0"<?php echo get_selected($bn['bn_use'], 0); ?>>사용안함</option>
        </select>
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
    <a href="./con_bannerlist.php"><i class="fas fa-tasks"></i> 목록</a>
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
