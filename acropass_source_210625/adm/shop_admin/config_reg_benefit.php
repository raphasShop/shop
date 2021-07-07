<?php
$sub_menu = '200205'; /* (새로만듬) 회원가입혜택 */
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '회원가입혜택';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$pg_anchor = '<ul class="anchor">
<li><a href="#anc_scf_membership">회원가입혜택</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';

// 신규회원 쿠폰 설정 필드 추가
if(!isset($default['de_member_reg_coupon_use'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_member_reg_coupon_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `de_tax_flag_use`,
                    ADD `de_member_reg_coupon_term` int(11) NOT NULL DEFAULT '0' AFTER `de_member_reg_coupon_use`,
                    ADD `de_member_reg_coupon_price` int(11) NOT NULL DEFAULT '0' AFTER `de_member_reg_coupon_term` ", true);
}

// 신규회원 쿠폰 주문 최소금액 필드추가
if(!isset($default['de_member_reg_coupon_minimum'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_member_reg_coupon_minimum` int(11) NOT NULL DEFAULT '0' AFTER `de_member_reg_coupon_price` ", true);
}

?>

<form name="fconfig" action="./config_reg_benefitupdate.php" onsubmit="return fconfig_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="">

<!-- 회원가입시 이벤트 (쿠폰 및 적립금) { -->
<section id="anc_scf_membership">
    <?php// echo $pg_anchor; ?>
    <h2 class="h2_frm">회원가입시 혜택 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>회원가입시 혜택 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <!-- 회원가입쿠폰 혜택 -->
        <tr>
            <th scope="row" rowspan="5">회원가입<br>발급쿠폰</th>
            <td>
                 <?php echo help("회원가입시 할인쿠폰을 자동발급합니다. 배송비 할인쿠폰입니다. 아래에서 설정하시면 됩니다."); ?>
            </td>
        </tr>
        <tr>
          <td>
                <label class="switch-check">
                <input type="checkbox" name="de_member_reg_coupon_use" value="1" id="de_member_reg_coupon_use"<?php echo $default['de_member_reg_coupon_use']?' checked':''; ?>>
                <div class="check-slider round"></div>
                </label>
                
                <label for="de_member_reg_coupon_use"><b>쿠폰발행 사용 선택</b></label>
            </td>
        </tr>
        <tr>
          <td>
                <label for="de_member_reg_coupon_price">쿠폰 할인율</label>
                <input type="text" name="de_member_reg_coupon_price" value="<?php echo $default['de_member_reg_coupon_price']; ?>" id="de_member_reg_coupon_price" class="frm_input" size="7"> %
            </td>
        </tr>
        
        <tr>
          <td>
                <label for="de_member_reg_coupon_minimum">주문 최소금액</label>
                <input type="text" name="de_member_reg_coupon_minimum" value="<?php echo $default['de_member_reg_coupon_minimum']; ?>" id="de_member_reg_coupon_minimum" class="frm_input" size="7"> 원이상
            </td>
        </tr>
        
        <tr>
          <td>
                <label for="de_member_reg_coupon_term">쿠폰 유효기간</label>
                <input type="text" name="de_member_reg_coupon_term" value="<?php echo $default['de_member_reg_coupon_term']; ?>" id="de_member_reg_coupon_term" class="frm_input" size="3"> 일
            </td>
        </tr>
        <!-- // -->
        <!-- 회원가입적립금 혜택 -->
        <tr>
            <th scope="row" rowspan="2">회원가입<br>적립금 적립</th>
            <td>
                 <?php echo help("[적립금=포인트] 회원가입시 적립되는 포인트. [적립하지않으려면 0입력]"); ?>
            </td>
        </tr>
        <tr>
          <td>
                <input type="text" name="cf_register_point" value="<?php echo $config['cf_register_point'] ?>" id="cf_register_point" class="frm_input" size="7"> 원
            </td>
        </tr>
        <!-- // -->
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

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
