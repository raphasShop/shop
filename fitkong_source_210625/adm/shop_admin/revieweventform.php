<?php
$sub_menu = '422400'; /* 수정전 원본 메뉴코드 400810 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$g5['title'] = '리뷰혜택관리';

if ($w == 'u') {
    $html_title = '리뷰혜택 수정';

    $sql = " select * from {$g5['g5_shop_review_event_table']} where re_id = '$re_id' ";
    $re = sql_fetch($sql);
    if (!$re['re_id']) alert('등록된 자료가 없습니다.');
}
else
{
    $html_title = '쿠폰 입력';
    $re['re_start'] = G5_TIME_YMD;
    $re['re_end'] = date('Y-m-d', (G5_SERVER_TIME + 86400 * 15));
    $re['re_period'] = 15;
}

if($re['br_cp_method'] == 1) {
    $br_cp_target_label = '적용분류';
    $br_cp_target_btn = '분류검색';
} else {
    $br_cp_target_label = '적용상품';
    $br_cp_target_btn = '상품검색';
}

if($re['pr_cp_method'] == 1) {
    $pr_cp_target_label = '적용분류';
    $pr_cp_target_btn = '분류검색';
} else {
    $pr_cp_target_label = '적용상품';
    $pr_cp_target_btn = '상품검색';
}

$sql = " select * from {$g5['g5_shop_item_table']} ";
$itemresult = sql_query($sql);

include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
?>

<form name="fcouponform" action="./revieweventformupdate.php" method="post" enctype="multipart/form-data" onsubmit="return form_check(this);">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="re_id" value="<?php echo $re_id; ?>">
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
        <th scope="row"><label for="rep_id">상품선택</label></th>
        <td>
            <?php echo help('리뷰를 표시할 상품을 선택해주세요'); ?> 
            <select name="rep_id" id="rep_id">
                <?php for($i=0; $row=sql_fetch_array($itemresult); $i++) { ?>
                <option value="<?php echo $row['it_id']; ?>"<?php echo get_selected($re['it_id'], $row['it_id']); ?>><?php echo $row['it_name']; ?></option>
                <?php } ?>
            </select>
        </td>
    </tr>      
    <tr>
        <th scope="row"><label for="re_type">리뷰혜택타입</label></th>
        <td>
           <?php echo help("리뷰혜택의 타입을 설정합니다.<br>포인트혜택은 리뷰 작성 회원에게 포인트를 쿠폰혜택은 리뷰 작성 회원에게 할인쿠폰을 제공합니다."); ?>
           <select name="re_type" id="re_type">
                <option value="0" <?php echo get_selected("0", $re['re_type']); ?>>쿠폰혜택</option>
                <option value="1" <?php echo get_selected("1", $re['re_type']); ?>>포인트혜택</option>
           </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="re_subject">리뷰혜택이름</label></th>
        <td>
            <input type="text" name="re_subject" value="<?php echo get_text($re['re_subject']); ?>" id="re_subject" required class="required frm_input" size="50">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="re_start">리뷰혜택시작일</label></th>
        <td>
            <?php echo help('입력 예: '.date('Y-m-d')); ?>
            <input type="text" name="re_start" value="<?php echo stripslashes($re['re_start']); ?>" id="re_start" required class="frm_input required">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="re_end">리뷰혜택종료일</label></th>
        <td>
            <?php echo help('입력 예: '.date('Y-m-d')); ?>
            <input type="text" name="re_end" value="<?php echo stripslashes($re['re_end']); ?>" id="re_end" required class="frm_input required">
        </td>
    </tr>
    <tr>
        <td></td>
    </tr>
    </tbody>
    <tbody id="tr_point_area">
    <tr id="tr_br_point">
        <th scope="row"><label for="br_point">포인트혜택(일반리뷰)</label></th>
        <td>
            <?php echo help("리뷰 작성 회원의 일반리뷰 포인트 혜택을 지정합니다."); ?>
            <input type="text" name="br_point" value="<?php echo get_text($re['br_point']); ?>" id="br_point" class="frm_input">
        </td>
    </tr>
    <tr id="tr_pr_point">
        <th scope="row"><label for="pr_point">포인트혜택(포토리뷰)</label></th>
        <td>
            <?php echo help("리뷰 작성 회원의 포토리뷰 포인트 혜택을 지정합니다."); ?>
            <input type="text" name="pr_point" value="<?php echo get_text($re['pr_point']); ?>" id="pr_point" class="frm_input">
        </td>
    </tr>
    </tbody>
    <tbody id="tr_coupon_area">
    <tr id="tr_br_cp_subject">
        <th scope="row"><label for="br_cp_subject">쿠폰이름(일반리뷰)</label></th>
        <td>
            <input type="text" name="br_cp_subject" value="<?php echo get_text($re['br_cp_subject']); ?>" id="br_cp_subject" required class="required frm_input" size="50">
        </td>
    </tr>
    <tr id="tr_br_cp_method">
        <th scope="row"><label for="br_cp_method">발급쿠폰종류(일반리뷰)</label></th>
        <td>
           <select name="br_cp_method" id="br_cp_method">
                <option value="0"<?php echo get_selected('0', $re['br_cp_method']); ?>>개별상품할인</option>
                <option value="1"<?php echo get_selected('1', $re['br_cp_method']); ?>>카테고리할인</option>
                <option value="2"<?php echo get_selected('2', $re['br_cp_method']); ?>>주문금액할인</option>
                <option value="3"<?php echo get_selected('3', $re['br_cp_method']); ?>>배송비할인</option>
           </select>
           
           <!-- 쿠폰대상 상품보기 링크 -->
           <?php if($re['br_cp_method'] == '0') { //개별상품일때?>
               <button type="button" class="btn btn-skyblue btn-sm" onclick="window.open('<?php echo G5_SHOP_URL; ?>/item.php?it_id=<?php echo $re['br_cp_target'];//개별상품?>')">쿠폰이 적용된 상품보기</button><br>
           <?php } else if($re['br_cp_method'] == '1') { //개별상품일때?>
               <button type="button" class="btn btn-skyblue btn-sm" onclick="window.open('<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $re['br_cp_target'];//카테고리?>')">쿠폰이 적용된 상품보기</button><br>
           <?php } //닫기?>
           <!--//-->
           
        </td>
    </tr>
    <tr id="tr_br_cp_target">
        <th scope="row"><label for="br_cp_target"><?php echo $br_cp_target_label; ?>(일반리뷰)</label></th>
        <td>
           <input type="text" name="br_cp_target" value="<?php echo stripslashes($re['br_cp_target']); ?>" id="br_cp_target" required class="required frm_input">
           <button type="button" id="br_sch_target" class="btn_frmline"><?php echo $br_cp_target_btn; ?></button>
        </td>
    </tr>
    <tr id="tr_br_cp_start">
        <th scope="row"><label for="br_cp_start">쿠폰시작일(일반리뷰)</label></th>
        <td>
            <?php echo help('입력 예: '.date('Y-m-d')); ?>
            <input type="text" name="br_cp_start" value="<?php echo stripslashes($re['br_cp_start']); ?>" id="br_cp_start" required class="frm_input required">
        </td>
    </tr>
    <tr id="tr_br_cp_end">
        <th scope="row"><label for="re_end">쿠폰종료일(일반리뷰)</label></th>
        <td>
            <?php echo help('입력 예: '.date('Y-m-d')); ?>
            <input type="text" name="br_cp_end" value="<?php echo stripslashes($re['br_cp_end']); ?>" id="br_cp_end" required class="frm_input required">
        </td>
    </tr>
    <tr id="tr_br_cp_type">
        <th scope="row"><label for="br_cp_type">할인금액타입(일반리뷰)</label></th>
        <td>
           <select name="br_cp_type" id="br_cp_type">
                <option value="0"<?php echo get_selected('0', $re['br_cp_type']); ?>>정액할인(원)</option>
                <option value="1"<?php echo get_selected('1', $re['br_cp_type']); ?>>정률할인(%)</option>
           </select>
        </td>
    </tr>
    <tr id="tr_br_cp_price">
        <th scope="row"><label for="br_cp_price"><?php echo $re['br_cp_type'] ? '할인비율' : '할인금액'; ?></label></th>
        <td>
            <input type="text" name="br_cp_price" value="<?php echo stripslashes($re['br_cp_price']); ?>" id="br_cp_price" required class="frm_input required"> <span id="br_cp_price_unit"><?php echo $re['br_cp_type'] ? '%' : '원'; ?></span>
        </td>
    </tr>
    <tr id="tr_br_cp_trunc">
        <th scope="row"><label for="br_cp_trunc">절사금액(일반리뷰)</label></th>
        <td>
            <select name="br_cp_trunc" id="br_cp_trunc">
            <option value="1"<?php echo get_selected('1', $re['br_cp_trunc']); ?>>1원단위</option>
            <option value="10"<?php echo get_selected('10', $re['br_cp_trunc']); ?>>10원단위</option>
            <option value="100"<?php echo get_selected('100', $re['br_cp_trunc']); ?>>100원단위</option>
            <option value="1000"<?php echo get_selected('1000', $re['br_cp_trunc']); ?>>1,000원단위</option>
           </select>
        </td>
    </tr>
    <tr id="tr_br_cp_minimum">
        <th scope="row"><label for="br_cp_minimum">최소주문금액(일반리뷰)</label></th>
        <td>
            <input type="text" name="br_cp_minimum" value="<?php echo stripslashes($re['br_cp_minimum']); ?>" id="br_cp_minimum" class="frm_input"> 원
        </td>
    </tr>
    <tr id="tr_br_cp_maximum">
        <th scope="row"><label for="br_cp_maximum">최대할인금액(일반리뷰)</label></th>
        <td>
            <input type="text" name="br_cp_maximum" value="<?php echo stripslashes($re['br_cp_maximum']); ?>" id="br_cp_maximum" class="frm_input"> 원
        </td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr id="tr_pr_cp_subject">
        <th scope="row"><label for="pr_cp_subject">쿠폰이름(포토리뷰)</label></th>
        <td>
            <input type="text" name="pr_cp_subject" value="<?php echo get_text($re['pr_cp_subject']); ?>" id="pr_cp_subject" required class="required frm_input" size="50">
        </td>
    </tr>
    <tr id="tr_pr_cp_method">
        <th scope="row"><label for="pr_cp_method">발급쿠폰종류(포토리뷰)</label></th>
        <td>
           <select name="pr_cp_method" id="pr_cp_method">
                <option value="0"<?php echo get_selected('0', $re['pr_cp_method']); ?>>개별상품할인</option>
                <option value="1"<?php echo get_selected('1', $re['pr_cp_method']); ?>>카테고리할인</option>
                <option value="2"<?php echo get_selected('2', $re['pr_cp_method']); ?>>주문금액할인</option>
                <option value="3"<?php echo get_selected('3', $re['pr_cp_method']); ?>>배송비할인</option>
           </select>
           
           <!-- 쿠폰대상 상품보기 링크 -->
           <?php if($re['pr_cp_method'] == '0') { //개별상품일때?>
               <button type="button" class="btn btn-skyblue btn-sm" onclick="window.open('<?php echo G5_SHOP_URL; ?>/item.php?it_id=<?php echo $re['pr_cp_target'];//개별상품?>')">쿠폰이 적용된 상품보기</button><br>
           <?php } else if($re['pr_cp_method'] == '1') { //개별상품일때?>
               <button type="button" class="btn btn-skyblue btn-sm" onclick="window.open('<?php echo G5_SHOP_URL; ?>/list.php?ca_id=<?php echo $re['pr_cp_target'];//카테고리?>')">쿠폰이 적용된 상품보기</button><br>
           <?php } //닫기?>
           <!--//-->
           
        </td>
    </tr>
    <tr id="tr_pr_cp_target">
        <th scope="row"><label for="pr_cp_target"><?php echo $pr_cp_target_label; ?>(포토리뷰)</label></th>
        <td>
           <input type="text" name="pr_cp_target" value="<?php echo stripslashes($re['pr_cp_target']); ?>" id="pr_cp_target" required class="required frm_input">
           <button type="button" id="pr_sch_target" class="btn_frmline"><?php echo $pr_cp_target_btn; ?></button>
        </td>
    </tr>
    <tr id="tr_pr_cp_start">
        <th scope="row"><label for="pr_cp_start">쿠폰시작일(포토리뷰)</label></th>
        <td>
            <?php echo help('입력 예: '.date('Y-m-d')); ?>
            <input type="text" name="pr_cp_start" value="<?php echo stripslashes($re['pr_cp_start']); ?>" id="pr_cp_start" required class="frm_input required">
        </td>
    </tr>
    <tr id="tr_pr_cp_end">
        <th scope="row"><label for="re_end">쿠폰종료일(포토리뷰)</label></th>
        <td>
            <?php echo help('입력 예: '.date('Y-m-d')); ?>
            <input type="text" name="pr_cp_end" value="<?php echo stripslashes($re['pr_cp_end']); ?>" id="pr_cp_end" required class="frm_input required">
        </td>
    </tr>
    <tr id="tr_pr_cp_type">
        <th scope="row"><label for="pr_cp_type">할인금액타입(포토리뷰)</label></th>
        <td>
           <select name="pr_cp_type" id="pr_cp_type">
                <option value="0"<?php echo get_selected('0', $re['pr_cp_type']); ?>>정액할인(원)</option>
                <option value="1"<?php echo get_selected('1', $re['pr_cp_type']); ?>>정률할인(%)</option>
           </select>
        </td>
    </tr>
    <tr id="tr_pr_cp_price">
        <th scope="row"><label for="pr_cp_price"><?php echo $re['pr_cp_type'] ? '할인비율' : '할인금액'; ?></label></th>
        <td>
            <input type="text" name="pr_cp_price" value="<?php echo stripslashes($re['pr_cp_price']); ?>" id="pr_cp_price" required class="frm_input required"> <span id="pr_cp_price_unit"><?php echo $re['pr_cp_type'] ? '%' : '원'; ?></span>
        </td>
    </tr>
    <tr id="tr_pr_cp_trunc">
        <th scope="row"><label for="pr_cp_trunc">절사금액(포토리뷰)</label></th>
        <td>
            <select name="pr_cp_trunc" id="pr_cp_trunc">
            <option value="1"<?php echo get_selected('1', $re['pr_cp_trunc']); ?>>1원단위</option>
            <option value="10"<?php echo get_selected('10', $re['pr_cp_trunc']); ?>>10원단위</option>
            <option value="100"<?php echo get_selected('100', $re['pr_cp_trunc']); ?>>100원단위</option>
            <option value="1000"<?php echo get_selected('1000', $re['pr_cp_trunc']); ?>>1,000원단위</option>
           </select>
        </td>
    </tr>
    <tr id="tr_pr_cp_minimum">
        <th scope="row"><label for="pr_cp_minimum">최소주문금액(포토리뷰)</label></th>
        <td>
            <input type="text" name="pr_cp_minimum" value="<?php echo stripslashes($re['pr_cp_minimum']); ?>" id="pr_cp_minimum" class="frm_input"> 원
        </td>
    </tr>
    <tr id="tr_pr_cp_maximum">
        <th scope="row"><label for="pr_cp_maximum">최대할인금액(포토리뷰)</label></th>
        <td>
            <input type="text" name="pr_cp_maximum" value="<?php echo stripslashes($re['pr_cp_maximum']); ?>" id="pr_cp_maximum" class="frm_input"> 원
        </td>
    </tr>
    </tbody>
    </table>
</div>

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">   
    <div class="bq_basic">
    <a href="./reviewevemtlist.php?<?php echo $qstr; ?>"><i class="fas fa-tasks"></i> 목록</a>
    </div>
    
    <div class="bq_basic_submit">
    <input type="submit" value="확인" accesskey="s">
    </div>
</div>
<!--//-->

</form>

<script>
$(function() {
    <?php if($re['re_type'] == '0') { ?>
    $("#tr_point_area").hide();
    $("#tr_point_area").find("input").attr("required", false).removeClass("required");
    <?php } else if ($re['re_type'] == '1') { ?>
    $("#tr_coupon_area").hide();
    $("#tr_coupon_area").find("input").attr("required", false).removeClass("required");
    <?php } else { ?>
    $("#tr_point_area").hide();
    $("#tr_point_area").find("input").attr("required", false).removeClass("required");
    <?php } ?>
    <?php if($re['br_cp_method'] == 2 || $re['br_cp_method'] == 3) { ?>
    $("#tr_br_cp_target").hide();
    $("#tr_br_cp_target").find("input").attr("required", false).removeClass("required");
    <?php } ?>
    <?php if($re['br_cp_type'] != 1) { ?>
    $("#tr_br_cp_maximum").hide();
    $("#tr_br_cp_trunc").hide();
    <?php } ?>

    <?php if($re['pr_cp_method'] == 2 || $re['pr_cp_method'] == 3) { ?>
    $("#tr_pr_cp_target").hide();
    $("#tr_pr_cp_target").find("input").attr("required", false).removeClass("required");
    <?php } ?>
    <?php if($re['pr_cp_type'] != 1) { ?>
    $("#tr_pr_cp_maximum").hide();
    $("#tr_pr_cp_trunc").hide();
    <?php } ?>

    $("#re_type").change(function() {
        if($(this).val() == "1") {
            $("#tr_point_area").find("input").attr("required", true).addClass("required");
            $("#tr_coupon_area").find("input").attr("required", false).removeClass("required");
            $("#tr_point_area").show();
            $("#tr_coupon_area").hide();
        } else {
            $("#tr_coupon_area").find("input").attr("required", true).addClass("required");
            $("#tr_point_area").find("input").attr("required", false).removeClass("required");
            $("#tr_point_area").hide();
            $("#tr_coupon_area").show();
        }
    });
    $("#br_cp_method").change(function() {
        var br_cp_method = $(this).val();
        change_method(br_cp_method,"br");
    });

    $("#br_cp_type").change(function() {
        var br_cp_type = $(this).val();
        change_type(br_cp_type,"br");
    });

    $("#pr_cp_method").change(function() {
        var pr_cp_method = $(this).val();
        change_method(pr_cp_method,"pr");
    });

    $("#pr_cp_type").change(function() {
        var pr_cp_type = $(this).val();
        change_type(pr_cp_type,"pr");
    });

    $("#br_sch_target").click(function() {
        var br_cp_method = $("#br_cp_method").val();
        var br_opt = "left=50,top=50,width=520,height=600,scrollbars=1";
        var br_url = "./brcoupontarget.php?sch_target=";

        if(br_cp_method == "0") {
            window.open(br_url+"0", "win_target", br_opt);
        } else if(br_cp_method == "1") {
            window.open(br_url+"1", "win_target", br_opt);
        } else {
            return false;
        }
    });

    $("#pr_sch_target").click(function() {
        var pr_cp_method = $("#pr_cp_method").val();
        var pr_opt = "left=50,top=50,width=520,height=600,scrollbars=1";
        var pr_url = "./prcoupontarget.php?sch_target=";

        if(pr_cp_method == "0") {
            window.open(pr_url+"0", "win_target", pr_opt);
        } else if(pr_cp_method == "1") {
            window.open(pr_url+"1", "win_target", pr_opt);
        } else {
            return false;
        }
    });

    $("#re_start, #re_end, #br_cp_start, #br_cp_end, #pr_cp_start, #pr_cp_end").datepicker(
        { changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99" }
    );
});

function change_method(cp_method, rvtype)
{
    if(rvtype == "br") {
        if(cp_method == "0") {
            $("#br_sch_target").text("상품검색");
            $("#tr_br_cp_target").find("label").text("적용상품");
            $("#tr_br_cp_target").find("input").attr("required", true).addClass("required");
            $("#tr_br_cp_target").show();
        } else if(cp_method == "1") {
            $("#br_sch_target").text("분류검색");
            $("#tr_br_cp_target").find("label").text("적용분류");
            $("#tr_br_cp_target").find("input").attr("required", true).addClass("required");
            $("#tr_br_cp_target").show();
        } else {
            $("#tr_br_cp_target").hide();
            $("#tr_br_cp_target").find("input").attr("required", false).removeClass("required");
        }
    } else {
        if(cp_method == "0") {
            $("#pr_sch_target").text("상품검색");
            $("#tr_pr_cp_target").find("label").text("적용상품");
            $("#tr_pr_cp_target").find("input").attr("required", true).addClass("required");
            $("#tr_pr_cp_target").show();
        } else if(cp_method == "1") {
            $("#pr_sch_target").text("분류검색");
            $("#tr_pr_cp_target").find("label").text("적용분류");
            $("#tr_pr_cp_target").find("input").attr("required", true).addClass("required");
            $("#tr_pr_cp_target").show();
        } else {
            $("#tr_pr_cp_target").hide();
            $("#tr_pr_cp_target").find("input").attr("required", false).removeClass("required");
        }
    }
}

function change_type(cp_type, rvtype)
{
    if(rvtype == "br") {
        if(cp_type == "0") {
            $("#br_cp_price_unit").text("원");
            $("#br_cp_price_unit").closest("tr").find("label").text("할인금액");
            $("#tr_br_cp_maximum").hide();
            $("#tr_br_cp_trunc").hide();
        } else {
            $("#br_cp_price_unit").text("%");
            $("#br_cp_price_unit").closest("tr").find("label").text("할인비율");
            $("#tr_br_cp_maximum").show();
            $("#tr_br_cp_trunc").show();
        }
    } else {
        if(cp_type == "0") {
            $("#pr_cp_price_unit").text("원");
            $("#pr_cp_price_unit").closest("tr").find("label").text("할인금액");
            $("#tr_pr_cp_maximum").hide();
            $("#tr_pr_cp_trunc").hide();
        } else {
            $("#pr_cp_price_unit").text("%");
            $("#pr_cp_price_unit").closest("tr").find("label").text("할인비율");
            $("#tr_pr_cp_maximum").show();
            $("#tr_pr_cp_trunc").show();
        }
    }
}

function form_check(f)
{
    var pr_sel_type = f.pr_cp_type;
    var pr_cp_type = pr_sel_type.options[pr_sel_type.selectedIndex].value;
    var pr_cp_price = f.pr_cp_price.value;

    var br_sel_type = f.br_cp_type;
    var br_cp_type = br_sel_type.options[br_sel_type.selectedIndex].value;
    var br_cp_price = f.br_cp_price.value;

    <?php if(!$cpimg_str) { ?>
    if(f.cp_img.value == "") {
        alert("쿠폰이미지를 업로드해 주십시오.");
        return false;
    }
    <?php } ?>

    if(isNaN(br_cp_price)) {
        if(br_cp_type == "1")
            alert("할인비율을 숫자로 입력해 주십시오.");
        else
            alert("할인금액을 숫자로 입력해 주십시오.");

        return false;
    }

    if(isNaN(pr_cp_price)) {
        if(pr_cp_type == "1")
            alert("할인비율을 숫자로 입력해 주십시오.");
        else
            alert("할인금액을 숫자로 입력해 주십시오.");

        return false;
    }

    br_cp_price = parseInt(br_cp_price);
    pr_cp_price = parseInt(pr_cp_price);

    if(br_cp_type == "1" && (br_cp_price < 1 || br_cp_price > 100)) {
        alert("할인비율을 1과 100 사이의 숫자로 입력해 주십시오.");
        return false;
    }

    if(pr_cp_type == "1" && (pr_cp_price < 1 || pr_cp_price > 100)) {
        alert("할인비율을 1과 100 사이의 숫자로 입력해 주십시오.");
        return false;
    }

    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>