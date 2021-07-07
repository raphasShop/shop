<?php
$sub_menu = '111111'; /* (새로만듬)배송설정 */
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '배송설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$pg_anchor = '<ul class="anchor">
<li><a href="#anc_deliv_company">배송업체</a></li>
<li><a href="#anc_deliv_pay">배송비설정</a></li>
<li><a href="#anc_deliv_date">희망배송일</a></li>
<li><a href="#anc_deliv_info">배송안내</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';

?>

<form name="fconfig" action="./config_deliveryupdate.php" onsubmit="return fconfig_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="">

<!-- 배송업체설정 { -->
<section id="anc_deliv_company">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm">배송업체설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>배송업체설정 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="de_delivery_company">배송업체</label></th>
            <td>
                <?php echo help("이용 중이거나 이용하실 배송업체를 선택하세요.여러 배송업체를 이용하는 경우 주로 이용하는 배송업체를 선택하세요."); ?>
                <select name="de_delivery_company" id="de_delivery_company">
                    <?php echo get_delivery_company($default['de_delivery_company']); ?>
                </select>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!-- // -->

<!-- 기본 배송비 설정 { -->
<section id="anc_deliv_pay">
    <?php echo $pg_anchor; ?>
    <h2 >기본 배송비 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>기본배송비설정 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="de_send_cost_case">배송비유형</label></th>
            <td>
                <?php echo help("<strong>금액별차등</strong>으로 설정한 경우, 주문총액이 배송비상한가 미만일 경우 배송비를 받습니다.\n<strong>무료배송</strong>으로 설정한 경우, 배송비상한가 및 배송비를 무시하며 착불의 경우도 무료배송으로 설정합니다.\n<strong>상품별로 배송비 설정을 한 경우 상품별 배송비 설정이 우선</strong> 적용됩니다.\n예를 들어 무료배송으로 설정했을 때 특정 상품에 배송비가 설정되어 있으면 주문시 배송비가 부과됩니다."); ?>
                <select name="de_send_cost_case" id="de_send_cost_case">
                    <option value="차등" <?php echo get_selected($default['de_send_cost_case'], "차등"); ?>>금액별차등</option>
                    <option value="무료" <?php echo get_selected($default['de_send_cost_case'], "무료"); ?>>무료배송</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_send_cost_limit">배송비상한가</label></th>
            <td>
                <?php echo help("배송비유형이 '금액별차등'일 경우에만 해당되며 배송비상한가를 여러개 두고자 하는 경우는 <b>;</b> 로 구분합니다.\n\n예를 들어 20000원 미만일 경우 4000원, 30000원 미만일 경우 3000원 으로 사용할 경우에는 배송비상한가를 20000;30000 으로 입력하고 배송비를 4000;3000 으로 입력합니다."); ?>
                <input type="text" name="de_send_cost_limit" value="<?php echo $default['de_send_cost_limit']; ?>" class="frm_input w90per" id="de_send_cost_limit"> 원
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_send_cost_list">배송비</label></th>
            <td>
                <input type="text" name="de_send_cost_list" value="<?php echo $default['de_send_cost_list']; ?>" class="frm_input w90per" id="de_send_cost_list"> 원
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!-- // -->

<!-- 희망배송일 설정 { -->
<section id="anc_deliv_date">
    <?php echo $pg_anchor; ?>
    <h2 >희망배송일</h2>
    <div class="local_desc02 local_desc">
        <p>
            희망배송일은 모든상품주문시 일괄적용되므로, 특정상품만 설정 불가능합니다.<br>
            희망배송일에 상품을 배달할 수 있는 업종에서만 사용하세요. 거의 모든 업종은 희망배송일이 필요치 않습니다.<br> 
            <strong>[예제]</strong> 희망배송일지정에 3 을 입력하는경우 오늘부터 3일이후부터 일주일중에 희망배송일을 지정할수있습니다.<br>
            <strong>[관련업종]</strong> 대형전자제품, 계절가전, 보일러, 가구 등 설치가 필요한 제품 및 기타<br>
            희망배송일은 사이트 전체에 적용되는 것으로, 특정상품만 배송일자를 받고 싶다면 상품등록폼에서 추가옵션에서 응용해서 설정할수도 있습니다.
        </p>
    </div>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>희망배송일설정 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="de_hope_date_use">희망배송일사용</label></th>
            <td>
                <?php echo help("'예'로 설정한 경우 주문서에서 희망배송일을 입력 받습니다."); ?>
                <!--<select name="de_hope_date_use" id="de_hope_date_use">
                    <option value="0" <?php echo get_selected($default['de_hope_date_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_hope_date_use'], 1); ?>>사용</option>
                </select>-->
                <label class="switch-check">
                <input type="checkbox" name="de_hope_date_use" value="1" id="de_hope_date_use"<?php echo $default['de_hope_date_use']?' checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
                <label for="de_hope_date_use">희망배송일사용</label>
            </td>
        </tr>
        <tr>
             <th scope="row"><label for="de_hope_date_after">희망배송일지정</label></th>
            <td>
                <?php echo help("오늘을 포함하여 설정한 날 이후부터 일주일 동안을 달력 형식으로 노출하여 선택할수 있도록 합니다."); ?>
                <input type="text" name="de_hope_date_after" value="<?php echo $default['de_hope_date_after']; ?>" id="de_hope_date_after" class="frm_input" size="5"> 일
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!-- // -->

<!-- 배송안내 설정 { -->
<section id="anc_deliv_info">
    <?php echo $pg_anchor; ?>
    <h2 >배송안내</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>배송안내 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row">배송정보</th>
            <td><?php echo editor_html('de_baesong_content', get_text($default['de_baesong_content'], 0)); ?></td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!-- // -->

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">   
    <div class="bq_basic_icon">
    <a href="<?php echo G5_SHOP_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/shop_icon.png" border="0" title="쇼핑몰">&nbsp;&nbsp;</a>
    </div>
    
    <div class="bq_basic_submit">
    <input type="submit" value="확인" accesskey="s">
    </div>
    
</div>
<!--//-->

</form>

<script>
function fconfig_check(f)
{
    <?php echo get_editor_js('de_baesong_content'); ?>

    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
