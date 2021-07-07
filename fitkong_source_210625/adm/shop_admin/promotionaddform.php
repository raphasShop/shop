<?php
$sub_menu = '422500'; /* 수정전 원본 메뉴코드 400810 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$g5['title'] = '프로모션개별URL관리';

if ($w == 'u') {
    $html_title = '프로모션URL 수정';

    $sql = " select * from {$g5['promotion_address_table']} where pa_id = '$pa_id' ";
    $pa = sql_fetch($sql);
    if (!$pa['pa_id']) alert('등록된 자료가 없습니다.');
    //$pa_purl = G5_URL.'/l/?c='.$pa['code'];
    $pa_purl = 'http://fitkong.co.kr/l/?c='.$pa['pa_code'];
}
else
{
    $html_title = '프로모션URL 등록';
    $pa['pa_start'] = G5_TIME_YMD;
    $pa['pa_end'] = date('Y-m-d', (G5_SERVER_TIME + 86400 * 15));
    $pa['pa_period'] = 15;

    $j = 0;
    do {
        $pa_tcode = get_promotion_code();

        $sql2 = " select count(*) as cnt from {$g5['promotion_address_table']} where pa_code= '$pa_tcode' ";
        $row2 = sql_fetch($sql2);

        if(!$row2['cnt'])
            break;
        else {
            if($j > 20)
                die('Get Promotion Code Error');
        }
    } while(1);
}



include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
?>

<form name="paddressform" action="./promotionaddformupdate.php" method="post" enctype="multipart/form-data" onsubmit="return form_check(this);">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="pa_id" value="<?php echo $pa_id; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page;?>">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="pa_name">프로모션이름</label></th>
        <td>
            <input type="text" name="pa_name" value="<?php echo get_text($pa['pa_name']); ?>" id="pa_name" required class="required frm_input" size="50">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="pa_code">프로모션개별URL코드</label></th>
        <td>
            <?php echo help('사용할 개별URL코드를 직접입력 하시거나 아무것도 입력하지 않으시고 등록하시면 개별URL을 자동생성 하실 수 있습니다.'); ?>
            <?php echo help('ex) 12월핏콩데이'); ?>
            <input type="text" name="pa_code" value="<?php echo get_text($pa['pa_code']); ?>" id="pa_code" <?php if($w=='u') echo "readonly"; ?> class="frm_input" size="50">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="pa_purl">프로모션개별URL</label></th>
        <td>
            <input type="text" name="pa_purl" value="<?php echo $pa_purl; ?>" id="pa_purl" readonly required class="required frm_input" size="50">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="pa_url">연결할 페이지 URL</label></th>
        <td>
            <?php echo help('입력 예: http://fitkong.co.kr'); ?>
            <input type="text" name="pa_url" value="<?php echo get_text($pa['pa_url']); ?>" id="pa_url" required class="required frm_input" size="50">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="pa_url">프로모션채널</label></th>
        <td>
            <?php echo help('입력 예: 페이스북'); ?>
            <input type="text" name="pa_channel" value="<?php echo get_text($pa['pa_channel']); ?>" id="pa_channel" class="frm_input" size="50">
        </td>
    </tr>
    <?php if($member['mb_id'] == 'acropass') { ?>
    <tr>
        <th scope="row"><label for="pa_title">오픈그래프 제목</label></th>
        <td>
            <?php echo help('카카오톡/페이스북/블로그 등에서 표시될 제목을 지정합니다.'); ?>
            <input type="text" name="pa_title" value="<?php echo get_text($pa['pa_title']); ?>" id="pa_title" class="frm_input" size="50">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="pa_desc">오픈그래프 내용</label></th>
        <td>
            <?php echo help('카카오톡/페이스북/블로그 등에서 표시될 내용을 지정합니다.'); ?>
            <input type="text" name="pa_desc" value="<?php echo get_text($pa['pa_desc']); ?>" id="pa_desc" class="frm_input" size="50">
        </td>
    </tr>
    
    <tr>
        <th scope="row"><label for="pa_start">시작일</label></th>
        <td>
            <?php echo help('입력 예: '.date('Y-m-d')); ?>
            <input type="text" name="pa_start" value="<?php echo stripslashes($pa['pa_start']); ?>" id="pa_start"  class="frm_input">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="pa_end">종료일</label></th>
        <td>
            <?php echo help('입력 예: '.date('Y-m-d')); ?>
            <input type="text" name="pa_end" value="<?php echo stripslashes($pa['pa_end']); ?>" id="pa_end" class="frm_input">
        </td>
    </tr>
    <? }?>
    </tbody>
    </table>
</div>

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">   
    <div class="bq_basic">
    <a href="./promotionaddlist.php?<?php echo $qstr; ?>"><i class="fas fa-tasks"></i> 목록</a>
    </div>
    
    <div class="bq_basic_submit">
    <input type="submit" value="확인" accesskey="s">
    </div>
</div>
<!--//-->

</form>

<script>
$(function() {
    <?php if(!$pa['pa_code']) { ?>
    var pa_code = "<?php echo $pa_tcode; ?>";
    $('#pa_code').val(pa_code);
    var purl = 'http://fitkong.co.kr/l/?c=' + pa_code;
    $('#pa_purl').val(purl);
    <?php } ?>
    
    $("#pa_code").change(function() {
        var pa_code = $(this).val();
        if(pa_code == '') {
            var pa_code = "<?php echo $pa_tcode; ?>";
        }
        var purl = 'http://fitkong.co.kr/l/?c=' + pa_code;
        $('#pa_purl').val(purl);
    });

    $("#url_generator_btn").click(function() {
        var cp_method = $("#pa_code").val();
        var opt = "left=50,top=50,width=520,height=600,scrollbars=1";
        var url = "./coupontarget.php?sch_target=";

        if(cp_method == "0") {
            window.open(url+"0", "win_target", opt);
        } else if(cp_method == "1") {
            window.open(url+"1", "win_target", opt);
        } else {
            return false;
        }
    });

    $("#pa_start, #pa_end, #pa_code_start, #pa_code_end").datepicker(
        { changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99" }
    );
});



function form_check(f)
{
    
    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>