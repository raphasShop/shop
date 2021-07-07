<?php
$sub_menu = '111110'; /* 수정전 원본 메뉴코드 400100 */
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

/*
if (!$config['cf_icode_server_ip'])   $config['cf_icode_server_ip'] = '211.172.232.124'; //아이코드 서버IP
if (!$config['cf_icode_server_port']) $config['cf_icode_server_port'] = '7295'; //아이코드 서버포트

if ($config['cf_sms_use'] && $config['cf_icode_id'] && $config['cf_icode_pw']) {
    $userinfo = get_icode_userinfo($config['cf_icode_id'], $config['cf_icode_pw']);
}
*/

$g5['title'] = '쇼핑몰기본설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$pg_anchor = '<ul class="anchor2">
<li><a href="#anc_scf_info">사업자정보</a></li>
<li><a href="#anc_scf_open">고객센터운영안내</a></li>
<li><a href="#anc_scf_etc">권한/기타</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';

// 모바일 관련상품 설정 필드추가
if(!isset($default['de_mobile_rel_list_use'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_mobile_rel_list_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `de_rel_img_height`,
                    ADD `de_mobile_rel_list_skin` varchar(255) NOT NULL DEFAULT '' AFTER `de_mobile_rel_list_use`,
                    ADD `de_mobile_rel_img_width` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_rel_list_skin`,
                    ADD `de_mobile_rel_img_height` int(11) NOT NULL DEFAULT ' 0' AFTER `de_mobile_rel_img_width`", true);
}

// 모바일 초기화면 이미지 줄 수 필드 추가
if(!isset($default['de_mobile_type1_list_row'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_mobile_type1_list_row` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_type1_list_mod`,
                    ADD `de_mobile_type2_list_row` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_type2_list_mod`,
                    ADD `de_mobile_type3_list_row` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_type3_list_mod`,
                    ADD `de_mobile_type4_list_row` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_type4_list_mod`,
                    ADD `de_mobile_type5_list_row` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_type5_list_mod` ", true);
}

// 모바일 관련상품 이미지 줄 수 필드 추가
if(!isset($default['de_mobile_rel_list_mod'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_mobile_rel_list_mod` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_rel_list_skin` ", true);
}

// 모바일 검색상품 이미지 줄 수 필드 추가
if(!isset($default['de_mobile_search_list_row'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_mobile_search_list_row` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_search_list_mod` ", true);
}

// 유형별상품리스트 설정필드 추가
if(!isset($default['de_listtype_list_skin'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_listtype_list_skin` varchar(255) NOT NULL DEFAULT '' AFTER `de_mobile_search_img_height`,
                    ADD `de_listtype_list_mod` int(11) NOT NULL DEFAULT '0' AFTER `de_listtype_list_skin`,
                    ADD `de_listtype_list_row` int(11) NOT NULL DEFAULT '0' AFTER `de_listtype_list_mod`,
                    ADD `de_listtype_img_width` int(11) NOT NULL DEFAULT '0' AFTER `de_listtype_list_row`,
                    ADD `de_listtype_img_height` int(11) NOT NULL DEFAULT '0' AFTER `de_listtype_img_width`,
                    ADD `de_mobile_listtype_list_skin` varchar(255) NOT NULL DEFAULT '' AFTER `de_listtype_img_height`,
                    ADD `de_mobile_listtype_list_mod` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_listtype_list_skin`,
                    ADD `de_mobile_listtype_list_row` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_listtype_list_mod`,
                    ADD `de_mobile_listtype_img_width` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_listtype_list_row`,
                    ADD `de_mobile_listtype_img_height` int(11) NOT NULL DEFAULT '0' AFTER `de_mobile_listtype_img_width` ", true);
}
?>

<form name="fconfig" action="./configformupdate.php" onsubmit="return fconfig_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="">
<section id="anc_scf_info">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm">사업자정보</h2>
    <div class="local_desc02 local_desc">
        <p>
            사업자정보는 tail.php 와 content.php 에서 표시합니다.<br>
            대표전화번호는 SMS 발송번호로 사용되므로 사전등록된 발신번호와 일치해야 합니다.
        </p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>사업자정보 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="de_admin_company_name">회사명</label></th>
            <td>
                <input type="text" name="de_admin_company_name" value="<?php echo $default['de_admin_company_name']; ?>" id="de_admin_company_name" class="frm_input w100per">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_company_saupja_no">사업자등록번호</label></th>
            <td>
                <input type="text" name="de_admin_company_saupja_no"  value="<?php echo $default['de_admin_company_saupja_no']; ?>" id="de_admin_company_saupja_no" class="frm_input w100per">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_company_owner">대표자명</label></th>
            <td colspan="3">
                <input type="text" name="de_admin_company_owner" value="<?php echo $default['de_admin_company_owner']; ?>" id="de_admin_company_owner" class="frm_input" size="10">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_company_tel">대표전화번호</label></th>
            <td>
                <input type="text" name="de_admin_company_tel" value="<?php echo $default['de_admin_company_tel']; ?>" id="de_admin_company_tel" class="frm_input" size="15">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_company_fax">팩스번호</label></th>
            <td>
                <input type="text" name="de_admin_company_fax" value="<?php echo $default['de_admin_company_fax']; ?>" id="de_admin_company_fax" class="frm_input" size="15">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_tongsin_no">통신판매업 신고번호</label></th>
            <td>
                <input type="text" name="de_admin_tongsin_no" value="<?php echo $default['de_admin_tongsin_no']; ?>" id="de_admin_tongsin_no" class="frm_input" size="15">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_buga_no">부가통신 사업자번호</label></th>
            <td>
                <input type="text" name="de_admin_buga_no" value="<?php echo $default['de_admin_buga_no']; ?>" id="de_admin_buga_no" class="frm_input" size="15">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_info_name">정보관리책임자명</label></th>
            <td>
                <input type="text" name="de_admin_info_name" value="<?php echo $default['de_admin_info_name']; ?>" id="de_admin_info_name" class="frm_input" size="10">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_info_email">정보책임자 e-mail</label></th>
            <td>
                <input type="text" name="de_admin_info_email" value="<?php echo $default['de_admin_info_email']; ?>" id="de_admin_info_email" class="frm_input" size="15">
            </td>
        </tr>
        <!--사업장주소-->
        <tr>
            <th scope="row" colspan="2" style="height:45px; background:#fff;"><i class="far fa-building"></i> 사업장</th>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_company_zip">사업장 우편번호</label></th>
            <td>
                <input type="text" name="de_admin_company_zip" value="<?php echo $default['de_admin_company_zip']; ?>" id="de_admin_company_zip" class="frm_input" size="10">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_company_addr">사업장 주소</label></th>
            <td>
                <input type="text" name="de_admin_company_addr" value="<?php echo $default['de_admin_company_addr']; ?>" id="de_admin_company_addr" class="frm_input w100per">
            </td>
        </tr>
        <!--반품주소-->
        <tr>
            <th scope="row" colspan="2" style="height:45px;background:#fff;"><i class="fas fa-truck"></i> 반품주소 <span class="help1">※고객이 반품시 상품을 받을 수 있는 반품주소를 기재할 수 있습니다</span></th>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_return_zip">반품주소 우편번호</label></th>
            <td>
                <input type="text" name="de_admin_return_zip" value="<?php echo $default['de_admin_return_zip']; ?>" id="de_admin_return_zip" class="frm_input" size="10">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_return_addr">반품주소</label></th>
            <td>
                <input type="text" name="de_admin_return_addr" value="<?php echo $default['de_admin_return_addr']; ?>" id="de_admin_return_addr" class="frm_input w100per">
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>


<section id="anc_scf_open">
    <?php echo $pg_anchor; ?>
    
    <!-- [안내] 아이스크림전용테마에서만 사용가능 안내 { -->
    <div class="local_limit_theme local_desc">
        <div class="toggleclick" onclick="$('.togglebox').toggle()">
            <img src="<?php echo G5_ADMIN_URL ?>/img/s9.png"> 아이스크림 전용 쇼핑몰테마에서만 사용할 수 있는 기능
            <span class="more">+더보기</span>
        </div>
            
        <div class="togglebox">
            <span class="orangered">아이스크림에서 제공하는 전용 쇼핑몰테마를 사용하지 않는경우,설정이 적용되지 않습니다.</span><br>
            쇼핑몰테마에 일일이 적용해야하는 기능으로 다른 테마에 일일이 적용방법을 안내할 수가 없습니다.<br> 
            아이스크림 관리자모드에 최적화하여 만든 아이스크림 전용 쇼핑몰테마에는 모든 기능을 적용하였습니다.<br>
            아이스크림 쇼핑몰테마가 아닌경우에는, 사용중이신 쇼핑몰테마에 직접 적용해 주셔야 합니다.
        </div>
    </div>
    <!-- } -->
    
    <h2 class="h2_frm">고객센터운영안내</h2>
    <div class="local_desc02 local_desc">
        <p>
            사이트 맨하단과 고객센터 페이지에 고객센터운영시간이 표시됩니다.<br>
        </p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>고객센터운영안내 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <!--고객센터운영안내-->
        <tr>
            <th scope="row"><label for="de_admin_open_day">평일업무시간</label></th>
            <td>
                <input type="text" name="de_admin_open_day" value="<?php echo $default['de_admin_open_day']; ?>" id="de_admin_open_day" class="frm_input w90per">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_open_lunch">점심시간</label></th>
            <td>
                <input type="text" name="de_admin_open_lunch" value="<?php echo $default['de_admin_open_lunch']; ?>" id="de_admin_open_lunch" class="frm_input w90per">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_open_weekend">주말업무시간</label></th>
            <td>
                <input type="text" name="de_admin_open_weekend" value="<?php echo $default['de_admin_open_weekend']; ?>" id="de_admin_open_weekend" class="frm_input w90per">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_admin_open_info">고객센터운영안내글</label></th>
            <td>
                <input type="text" name="de_admin_open_info" value="<?php echo $default['de_admin_open_info']; ?>" id="de_admin_open_info" class="frm_input w100per">
            </td>
        </tr>
        <!--//-->
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>


<section id="anc_scf_etc">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm">권한/기타</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>기타 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="de_item_use_write">사용후기 작성</label></th>
            <td>
                 <?php echo help("주문상태에 따른 사용후기 작성여부를 설정합니다.", 50); ?>
                <select name="de_item_use_write" id="de_item_use_write">
                    <option value="0" <?php echo get_selected($default['de_item_use_write'], 0); ?>>주문상태와 무관하게 작성가능</option>
                    <option value="1" <?php echo get_selected($default['de_item_use_write'], 1); ?>>주문상태가 완료인 경우에만 작성가능</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_item_use_use">사용후기</label></th>
            <td>
                 <?php echo help("사용후기가 올라오면, 즉시 출력 혹은 관리자 승인 후 출력 여부를 설정합니다.", 50); ?>
                <select name="de_item_use_use" id="de_item_use_use">
                    <option value="0" <?php echo get_selected($default['de_item_use_use'], 0); ?>>즉시 출력</option>
                    <option value="1" <?php echo get_selected($default['de_item_use_use'], 1); ?>>관리자 승인 후 출력</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_level_sell">상품구입 권한</label></th>
            <td>
                <?php echo help("권한을 1로 설정하면 누구나 구입할 수 있습니다. 특정회원만 구입할 수 있도록 하려면 해당 권한으로 설정하십시오."); ?>
                <?php echo get_member_level_select('de_level_sell', 1, 10, $default['de_level_sell']); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_code_dup_use">코드 중복검사</label></th>
            <td>
                <?php echo help("분류, 상품 등을 추가할 때 자동으로 코드 중복검사를 하려면 체크하십시오."); ?>
                <label class="switch-check">
                <input type="checkbox" name="de_code_dup_use" value="1" id="de_code_dup_use"<?php echo $default['de_code_dup_use']?' checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_cart_keep_term">장바구니 보관기간</label></th>
            <td>
                 <?php echo help("장바구니 상품의 보관 기간을 설정하십시오."); ?>
                <input type="text" name="de_cart_keep_term" value="<?php echo $default['de_cart_keep_term']; ?>" id="de_cart_keep_term" class="frm_input" size="5"> 일
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_guest_cart_use">비회원 장바구니</label></th>
            <td>
                <?php echo help("비회원 장바구니 기능을 사용하려면 체크하십시오."); ?>
                <label class="switch-check">
                <input type="checkbox" name="de_guest_cart_use" value="1" id="de_guest_cart_use"<?php echo $default['de_guest_cart_use']?' checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row">비회원에 대한<br/>개인정보수집 내용</th>
            <td><?php echo editor_html('de_guest_privacy', get_text($default['de_guest_privacy'], 0)); ?></td>
        </tr>
        <tr>
            <th scope="row">MYSQL USER</th>
            <td><?php echo G5_MYSQL_USER; ?></td>
        </tr>
        <tr>
            <th scope="row">MYSQL DB</th>
            <td><?php echo G5_MYSQL_DB; ?></td>
        </tr>
        <tr>
            <th scope="row">서버 IP</th>
            <td>
			<?php if ($is_admin = 'super') { //최고관리자만 볼수있음?>
			    <?php echo ($_SERVER['SERVER_ADDR']?$_SERVER['SERVER_ADDR']:$_SERVER['LOCAL_ADDR']); ?>
            <?php } //최고관리자만 볼수있음?>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>


<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">   
    <div class="bq_basic_icon">
    <a href="<?php echo G5_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/home_icon.png" border="0" title="홈"></a>
    <a href="<?php echo G5_SHOP_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/shop_icon.png" border="0" title="쇼핑몰">&nbsp;&nbsp;</a>
    </div>
    
	<?php if ($is_admin == 'super') { ?>
    <div class="bq_basic_submit">
    <input type="submit" value="확인" accesskey="s">
    </div>
    <?php } ?>
</div>
<!--//-->

</form>

<script>
function fconfig_check(f)
{
    <?php echo get_editor_js('de_guest_privacy'); ?>

    return true;
}

$(function() {
    //$(".pg_info_fld").hide();
    $(".pg_vbank_url").hide();
    <?php if($default['de_pg_service']) { ?>
    //$(".<?php echo $default['de_pg_service']; ?>_info_fld").show();
    $("#<?php echo $default['de_pg_service']; ?>_vbank_url").show();
    <?php } else { ?>
    $(".kcp_info_fld").show();
    $("#kcp_vbank_url").show();
    <?php } ?>
    $(".de_pg_tab").on("click", "a", function(e){

        var pg = $(this).attr("data-value"),
            class_name = "tab-current";
        
        $("#de_pg_service").val(pg);
        $(this).parent("li").addClass(class_name).siblings().removeClass(class_name);

        //$(".pg_info_fld:visible").hide();
        $(".pg_vbank_url:visible").hide();
        //$("."+pg+"_info_fld").show();
        $("#"+pg+"_vbank_url").show();
        $(".scf_cardtest").addClass("scf_cardtest_hide");
        $("."+pg+"_cardtest").removeClass("scf_cardtest_hide");
        $(".scf_cardtest_tip_adm").addClass("scf_cardtest_tip_adm_hide");
        $("#"+pg+"_cardtest_tip").removeClass("scf_cardtest_tip_adm_hide");
    });

    $("#de_pg_service").on("change", function() {
        var pg = $(this).val();
        $(".pg_info_fld:visible").hide();
        $(".pg_vbank_url:visible").hide();
        $("."+pg+"_info_fld").show();
        $("#"+pg+"_vbank_url").show();
        $(".scf_cardtest").addClass("scf_cardtest_hide");
        $("."+pg+"_cardtest").removeClass("scf_cardtest_hide");
        $(".scf_cardtest_tip_adm").addClass("scf_cardtest_tip_adm_hide");
        $("#"+pg+"_cardtest_tip").removeClass("scf_cardtest_tip_adm_hide");
    });

    $(".scf_cardtest_btn").bind("click", function() {
        var $cf_cardtest_tip = $("#scf_cardtest_tip");
        var $cf_cardtest_btn = $(".scf_cardtest_btn");

        $cf_cardtest_tip.toggle();

        if($cf_cardtest_tip.is(":visible")) {
            $cf_cardtest_btn.text("테스트결제 팁 닫기");
        } else {
            $cf_cardtest_btn.text("테스트결제 팁 더보기");
        }
    });

    $(".get_shop_skin").on("click", function() {
        if(!confirm("현재 테마의 쇼핑몰 스킨 설정을 적용하시겠습니까?"))
            return false;

        $.ajax({
            type: "POST",
            url: "../theme_config_load.php",
            cache: false,
            async: false,
            data: { type: "shop_skin" },
            dataType: "json",
            success: function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                var field = Array('de_shop_skin', 'de_shop_mobile_skin');
                var count = field.length;
                var key;

                for(i=0; i<count; i++) {
                    key = field[i];

                    if(data[key] != undefined && data[key] != "")
                        $("select[name="+key+"]").val(data[key]);
                }
            }
        });
    });

    $(".shop_pc_index, .shop_mobile_index, .shop_etc").on("click", function() {
        if(!confirm("현재 테마의 스킨, 이미지 사이즈 등의 설정을 적용하시겠습니까?"))
            return false;

        var type = $(this).attr("class");
        var $el;

        $.ajax({
            type: "POST",
            url: "../theme_config_load.php",
            cache: false,
            async: false,
            data: { type: type },
            dataType: "json",
            success: function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                $.each(data, function(key, val) {
                    if(key == "error")
                        return true;

                    $el = $("#"+key);

                    if($el[0].type == "checkbox") {
                        $el.attr("checked", parseInt(val) ? true : false);
                        return true;
                    }
                    $el.val(val);
                });
            }
        });
    });
});
</script>

<?php
// 결제모듈 실행권한 체크
if($default['de_iche_use'] || $default['de_vbank_use'] || $default['de_hp_use'] || $default['de_card_use']) {
    // kcp의 경우 pp_cli 체크
    if($default['de_pg_service'] == 'kcp') {
        if(!extension_loaded('openssl')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("PHP openssl 확장모듈이 설치되어 있지 않습니다.\n모바일 쇼핑몰 결제 때 사용되오니 openssl 확장 모듈을 설치하여 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        if(!extension_loaded('soap') || !class_exists('SOAPClient')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("PHP SOAP 확장모듈이 설치되어 있지 않습니다.\n모바일 쇼핑몰 결제 때 사용되오니 SOAP 확장 모듈을 설치하여 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        $is_linux = true;
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            $is_linux = false;

        $exe = '/kcp/bin/';
        if($is_linux) {
            if(PHP_INT_MAX == 2147483647) // 32-bit
                $exe .= 'pp_cli';
            else
                $exe .= 'pp_cli_x64';
        } else {
            $exe .= 'pp_cli_exe.exe';
        }

        echo module_exec_check(G5_SHOP_PATH.$exe, 'pp_cli');

        // shop/kcp/log 디렉토리 체크 후 있으면 경고
        if(is_dir(G5_SHOP_PATH.'/kcp/log') && is_writable(G5_SHOP_PATH.'/kcp/log')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("웹접근 가능 경로에 log 디렉토리가 있습니다.\nlog 디렉토리를 웹에서 접근 불가능한 경로로 변경해 주십시오.\n\nlog 디렉토리 경로 변경은 SIR FAQ를 참고해 주세요.")'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }
    }

    // LG의 경우 log 디렉토리 체크
    if($default['de_pg_service'] == 'lg') {
        $log_path = G5_LGXPAY_PATH.'/lgdacom/log';

        if(!is_dir($log_path)) {
            echo '<script>'.PHP_EOL;
            echo 'alert("'.str_replace(G5_PATH.'/', '', G5_LGXPAY_PATH).'/lgdacom 폴더 안에 log 폴더를 생성하신 후 쓰기권한을 부여해 주십시오.\n> mkdir log\n> chmod 707 log");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        } else {
            if(!is_writable($log_path)) {
                echo '<script>'.PHP_EOL;
                echo 'alert("'.str_replace(G5_PATH.'/', '',$log_path).' 폴더에 쓰기권한을 부여해 주십시오.\n> chmod 707 log");'.PHP_EOL;
                echo '</script>'.PHP_EOL;
            }
        }
    }

    // 이니시스의 경우 log 디렉토리 체크
    if($default['de_pg_service'] == 'inicis') {
        if (!function_exists('xml_set_element_handler')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("XML 관련 함수를 사용할 수 없습니다.\n서버 관리자에게 문의해 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        if (!function_exists('openssl_get_publickey')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("OPENSSL 관련 함수를 사용할 수 없습니다.\n서버 관리자에게 문의해 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        if (!function_exists('socket_create')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("SOCKET 관련 함수를 사용할 수 없습니다.\n서버 관리자에게 문의해 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        if (!function_exists('mcrypt_module_open')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("MCRYPT 관련 함수를 사용할 수 없습니다.\n서버 관리자에게 문의해 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        $log_path = G5_SHOP_PATH.'/inicis/log';

        if(!is_dir($log_path)) {
            echo '<script>'.PHP_EOL;
            echo 'alert("'.str_replace(G5_PATH.'/', '', G5_SHOP_PATH).'/inicis 폴더 안에 log 폴더를 생성하신 후 쓰기권한을 부여해 주십시오.\n> mkdir log\n> chmod 707 log");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        } else {
            if(!is_writable($log_path)) {
                echo '<script>'.PHP_EOL;
                echo 'alert("'.str_replace(G5_PATH.'/', '',$log_path).' 폴더에 쓰기권한을 부여해 주십시오.\n> chmod 707 log");'.PHP_EOL;
                echo '</script>'.PHP_EOL;
            }
        }
    }

    // 카카오페이의 경우 log 디렉토리 체크
    if($default['de_kakaopay_mid'] && $default['de_kakaopay_key'] && $default['de_kakaopay_enckey'] && $default['de_kakaopay_hashkey'] && $default['de_kakaopay_cancelpwd']) {
        $log_path = G5_SHOP_PATH.'/kakaopay/log';

        if(!is_dir($log_path)) {
            echo '<script>'.PHP_EOL;
            echo 'alert("'.str_replace(G5_PATH.'/', '', G5_SHOP_PATH).'/kakaopay 폴더 안에 log 폴더를 생성하신 후 쓰기권한을 부여해 주십시오.\n> mkdir log\n> chmod 707 log");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        } else {
            if(!is_writable($log_path)) {
                echo '<script>'.PHP_EOL;
                echo 'alert("'.str_replace(G5_PATH.'/', '',$log_path).' 폴더에 쓰기권한을 부여해 주십시오.\n> chmod 707 log");'.PHP_EOL;
                echo '</script>'.PHP_EOL;
            }
        }
    }
}
?>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>