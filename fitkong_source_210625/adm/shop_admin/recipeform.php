<?php
$sub_menu = '155704'; /* 수정전 원본 메뉴코드 500500 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$co_id = preg_replace('/[^0-9]/', '', $co_id);

$html_title = '핏콩레시피 컨텐츠';
$g5['title'] = $html_title.'관리';

if ($w=="u")
{
    $html_title .= ' 수정';
    $sql = " select * from {$g5['g5_shop_recipe_table']} where co_id = '$co_id' ";
    $co = sql_fetch($sql);

    $co_recipe = $co['co_cook_recipe'];
    $sub_recipe = explode(';' , $co_recipe);
    $co_cook_recipe1 = $sub_recipe[0];
    $co_cook_recipe2 = $sub_recipe[1];
    $co_cook_recipe3 = $sub_recipe[2];
    $co_cook_recipe4 = $sub_recipe[3];
    $co_cook_recipe5 = $sub_recipe[4];
    $co_cook_recipe6 = $sub_recipe[5];
    $co_cook_recipe7 = $sub_recipe[6];
    $co_cook_recipe8 = $sub_recipe[7];
    $co_cook_recipe9 = $sub_recipe[8];
    $co_cook_recipe10 = $sub_recipe[9];
}
else
{
    $html_title .= ' 입력';
    $co['co_url']        = "http://";
    //$co['co_begin_time'] = date("Y-m-d 00:00:00", time());
    //$co['co_end_time']   = date("Y-m-d 00:00:00", time()+(60*60*24*730));
}

include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="fbanner" action="./recipeformupdate.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="co_id" value="<?php echo $co_id; ?>">

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
            <input type="file" name="co_bimg">
            <?php
            $bimg_str = "";
            $bimg = G5_DATA_PATH."/recipe/{$co['co_id']}";
            if (file_exists($bimg) && $co['co_id']) {
                $size = @getimagesize($bimg);
                if($size[0] && $size[0] > 750)
                    $width = 750;
                else
                    $width = $size[0];

                echo '<input type="checkbox" name="co_bimg_del" value="1" id="co_bimg_del"> <label for="co_bimg_del">삭제</label>';
                $bimg_str = '<img src="'.G5_DATA_URL.'/recipe/'.$co['co_id'].'" width="'.$width.'">';
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
        <th scope="row"><label for="co_img_url">이미지 주소</label></th>
        <td>
            <?php echo help("외부 서버에 업로드 된 이미지 링크 주소 입니다.\n외부 이미지 링크 주소가 존재하면, 업로드 된 이미지 보다 우선하여 컨텐츠로 출력합니다."); ?>
            <input type="text" name="co_img_url" size="80" value="<?php echo $co['co_img_url']; ?>" id="co_img_url" class="frm_input">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="co_alt">이미지 설명</label></th>
        <td>
            <?php echo help("img 태그의 alt, title 에 해당되는 내용입니다.\n이미지에 마우스를 오버하면 이미지의 설명이 나옵니다."); ?>
            <input type="text" name="co_alt" value="<?php echo get_text($co['co_alt']); ?>" id="co_alt" class="frm_input" size="80">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="co_title">컨텐츠 제목</label></th>
        <td>
            <?php echo help("컨텐츠제목을 입력해주세요."); ?>
            <input type="text" name="co_title" value="<?php echo get_text($co['co_title']); ?>" id="co_title" class="frm_input" size="80">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="co_cook_time">조리시간</label></th>
        <td>
            <?php echo help("조리시간을 입력해주세요. ex) 20~30분"); ?>
            <input type="text" name="co_cook_time" value="<?php echo get_text($co['co_cook_time']); ?>" id="co_cook_time" class="frm_input" size="80">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="co_cook_person">조리량</label></th>
        <td>
            <?php echo help("조리량을 입력해주세요. ex) 1인분"); ?>
            <input type="text" name="co_cook_person" value="<?php echo get_text($co['co_cook_person']); ?>" id="co_cook_person" class="frm_input" size="80">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="co_cook_material">재료및분량</label></th>
        <td>
            <?php echo help("재료및분량을 입력해주세요."); ?>
            <input type="text" name="co_cook_material" value="<?php echo get_text($co['co_cook_material']); ?>" id="co_cook_material" class="frm_input" size="80">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="co_cook_recipe">레시피</label></th>
        <td>
            <p><?php echo help("레시피를 순서대로 입력해주세요."); ?>
            <input type="text" name="co_cook_recipe1" value="<?php echo get_text($co_cook_recipe1); ?>" id="co_cook_recipe1" class="frm_input" size="80" placeholder="1."></p>
            <p><input type="text" name="co_cook_recipe2" value="<?php echo get_text($co_cook_recipe2); ?>" id="co_cook_recipe2" class="frm_input" size="80" placeholder="2."></p>
            <p><input type="text" name="co_cook_recipe3" value="<?php echo get_text($co_cook_recipe3); ?>" id="co_cook_recipe3" class="frm_input" size="80" placeholder="3."></p>
            <p><input type="text" name="co_cook_recipe4" value="<?php echo get_text($co_cook_recipe4); ?>" id="co_cook_recipe4" class="frm_input" size="80" placeholder="4."></p>
            <p><input type="text" name="co_cook_recipe5" value="<?php echo get_text($co_cook_recipe5); ?>" id="co_cook_recipe5" class="frm_input" size="80" placeholder="5."></p>
            <p><input type="text" name="co_cook_recipe6" value="<?php echo get_text($co_cook_recipe6); ?>" id="co_cook_recipe6" class="frm_input" size="80" placeholder="6."></p>
            <p><input type="text" name="co_cook_recipe7" value="<?php echo get_text($co_cook_recipe7); ?>" id="co_cook_recipe7" class="frm_input" size="80" placeholder="7."></p>
            <p><input type="text" name="co_cook_recipe8" value="<?php echo get_text($co_cook_recipe8); ?>" id="co_cook_recipe8" class="frm_input" size="80" placeholder="8."></p>
            <p><input type="text" name="co_cook_recipe9" value="<?php echo get_text($co_cook_recipe9); ?>" id="co_cook_recipe9" class="frm_input" size="80" placeholder="9."></p>
            <p><input type="text" name="co_cook_recipe10" value="<?php echo get_text($co_cook_recipe10); ?>" id="co_cook_recipe10" class="frm_input" size="80" placeholder="10."></p>
        </td>
    </tr>
    <!--
    <tr>
        <th scope="row"><label for="co_sub_title">서브 타이틀</label></th>
        <td>
            <?php echo help("서브 타이틀 설명입니다."); ?>
            <input type="text" name="co_sub_title" value="<?php echo get_text($co['co_sub_title']); ?>" id="co_sub_title" class="frm_input" size="80">
        </td>
    </tr>
    -->
    <tr>
        <th scope="row"><label for="co_url">링크</label></th>
        <td>
            <?php echo help("컨텐츠 내의 유튜브 링크 클릭시 이동하는 주소입니다."); ?>
            <input type="text" name="co_url" size="80" value="<?php echo $co['co_url']; ?>" id="co_url" class="frm_input">
        </td>
    </tr>
    <!--
    <tr>
        <th scope="row"><label for="co_device">접속기기</label></th>
        <td>
            <?php echo help('컨텐츠를 표시할 접속기기를 선택합니다.'); ?>
            <select name="co_device" id="co_device">
                <option value="pc"<?php echo get_selected($co['co_device'], 'pc'); ?>>PC</option>
                <option value="mobile"<?php echo get_selected($co['co_device'], 'mobile'); ?>>모바일</option>
        </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="co_position">출력위치</label></th>
        <td>
            <?php echo help("샵 : 쇼핑몰 화면에 출력합니다.\n메인 : 메인화면에만 출력합니다."); ?>
            <select name="co_position" id="co_position">
                <option value="샵" <?php echo get_selected($co['co_position'], '샵'); ?>>샵</option>
                <option value="메인" <?php echo get_selected($co['co_position'], '메인'); ?>>메인</option>
        </select>
        </td>
    </tr>
    <tr>
        <th scope="row">배경색상</th>
        <td>
		<?php echo help('배경색상을 RGB칼라로 등록하세요 [예] #CCCCCC'); ?>
        <input id="co_bgcolor" class="frm_input iColorPicker" type="text" name="co_bgcolor" value="<?php echo $co['co_bgcolor']; ?>">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="co_new_win">새창</label></th>
        <td>
            <?php echo help("이미지클릭시 새창을 띄울지를 설정합니다.", 50); ?>
            <select name="co_new_win" id="co_new_win">
                <option value="0" <?php echo get_selected($co['co_new_win'], 0); ?>>사용안함</option>
                <option value="1" <?php echo get_selected($co['co_new_win'], 1); ?>>사용</option>
            </select>
            <label class="switch-check">
            <input type="checkbox" name="co_new_win" value="1" id="co_new_win"<?php echo $co['co_new_win']?' checked':''; ?>> 사용
            <div class="check-slider round"></div>
            </label>
            <label for="co_new_win">새창으로 열기설정</label>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="co_begin_time">시작일시</label></th>
        <td>
            <?php echo help("컨텐츠 게시 시작일시를 설정합니다."); ?>
            <input type="text" name="co_begin_time" value="<?php echo $co['co_begin_time']; ?>" id="co_begin_time" class="frm_input"  size="21" maxlength="19">
            <input type="checkbox" name="co_begin_chk" value="<?php echo date("Y-m-d 00:00:00", time()); ?>" id="co_begin_chk" onclick="if (this.checked == true) this.form.co_begin_time.value=this.form.co_begin_chk.value; else this.form.co_begin_time.value = this.form.co_begin_time.defaultValue;">
            <label for="co_begin_chk">오늘</label>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="co_end_time">종료일시</label></th>
        <td>
            <?php echo help("컨텐츠 게시 종료일시를 설정합니다."); ?>
            <input type="text" name="co_end_time" value="<?php echo $co['co_end_time']; ?>" id="co_end_time" class="frm_input" size=21 maxlength=19>
            <input type="checkbox" name="co_end_chk" value="<?php echo date("Y-m-d 23:59:59", time()+60*60*24*31); ?>" id="co_end_chk" onclick="if (this.checked == true) this.form.co_end_time.value=this.form.co_end_chk.value; else this.form.co_end_time.value = this.form.co_end_time.defaultValue;">
            <label for="co_end_chk">오늘+31일</label>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="co_order">출력 순서</label></th>
        <td>
           <?php echo help("컨텐츠를 출력할 때 순서를 정합니다. 숫자가 작을수록 먼저 출력됩니다. "); ?>
           <?php echo order_select("co_order", $co['co_order']); ?>
        </td>
    </tr>
    -->
    <tr>
        <th scope="row"><label for="co_use">컨텐츠 사용</label></th>
        <td>
            <?php echo help('컨텐츠 노출 여부를 선택합니다.'); ?>
            <select name="co_use" id="co_use">
                <option value="1"<?php echo get_selected($co['co_use'], 1); ?>>사용</option>
                <option value="0"<?php echo get_selected($co['co_use'], 0); ?>>사용안함</option>
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
    <a href="./recipelist.php"><i class="fas fa-tasks"></i> 목록</a>
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
