<?php
$sub_menu = '400912'; /* (새로만듬) 메인상품 진열 */
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '상품목록 상품진열';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$pg_anchor = '<ul class="anchor">
<li><a href="#anc_scf_skin">상품스킨설정</a></li>
<li><a href="#anc_scf_list">상품목록별 상품출력</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';
?>

<form name="fconfig" action="./config_dis_listupdate.php" onsubmit="return fconfig_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="">

<!-- 상품스킨 설정 { -->
<section id="anc_scf_skin">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm">상품스킨설정</h2>
    <div class="local_desc02 local_desc">
        <p>[상품목록/상세페이지 스킨설정] 상품 분류리스트, 상품상세보기 등 에서 사용할 스킨을 설정합니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>스킨설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="de_shop_skin">PC용 스킨</label></th>
            <td colspan="3">
                <?php echo get_skin_select('shop', 'de_shop_skin', 'de_shop_skin', $default['de_shop_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_shop_mobile_skin"><?php echo '<img src="'.G5_ADMIN_URL.'/img/icon_mobile.gif" title="모바일접속">';?> 모바일용 스킨</label></th>
            <td colspan="3">
                <?php echo get_mobile_skin_select('shop', 'de_shop_mobile_skin', 'de_shop_mobile_skin', $default['de_shop_mobile_skin'], 'required'); ?>
            </td>
        </tr>
        </tbody>
        </table>
    </div>        
</section>    

<?php echo $frm_submit; ?>
 <!--//-->

<!-- 상품목록 출력 설정 -->   
<section id="anc_scf_list">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm">상품출력설정</h2>
    <div class="local_desc02 local_desc">
        <p>[상품출력설정] 상품목록,검색목록 등 상품 노출되는곳의 스킨 및 이미지사이즈,출력수 등 설정하는 곳입니다.</p>
    </div>
    
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>기타 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row">PC 관련상품 출력</th>
            <td>
                <?php echo help("관련상품의 경우 등록된 상품은 모두 출력하므로 '출력할 줄 수'는 설정하지 않습니다. 이미지높이를 0으로 설정하면 상품이미지를 이미지폭에 비례하여 생성합니다."); ?>
                <!-- 출력설정 및 스킨설정 -->
                <div>
                <label class="switch-check-mini">
                    <input type="checkbox" name="de_rel_list_use" value="1" id="de_rel_list_use" <?php echo $default['de_rel_list_use']?"checked":""; ?>> 출력
                    <div class="check-slider-mini round"></div>
                </label>
                
                <select name="de_rel_list_skin" id="de_rel_list_skin">
                    <?php echo get_list_skin_options("^relation.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $default['de_rel_list_skin']); ?>
                </select>
                </div>
                <!--//-->

                <label for="de_rel_img_width">이미지폭</label>
                <input type="text" name="de_rel_img_width" value="<?php echo $default['de_rel_img_width']; ?>" id="de_rel_img_width" class="frm_input" size="3">
                <label for="de_rel_img_height">이미지높이</label>
                <input type="text" name="de_rel_img_height" value="<?php echo $default['de_rel_img_height']; ?>" id="de_rel_img_height" class="frm_input" size="3">
                <label for="de_rel_list_mod">1줄당 이미지 수</label>
                <input type="text" name="de_rel_list_mod" value="<?php echo $default['de_rel_list_mod']; ?>" id="de_rel_list_mod" class="frm_input" size="1">
                </td>
        </tr>
        <tr>
            <th scope="row">PC 검색상품 출력</th>
            <td>
                <label for="de_search_list_skin">스킨</label>
                <select name="de_search_list_skin" id="de_search_list_skin">
                    <?php echo get_list_skin_options("^list.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $default['de_search_list_skin']); ?>
                </select>
                <label for="de_search_img_width">이미지폭</label>
                <input type="text" name="de_search_img_width" value="<?php echo $default['de_search_img_width']; ?>" id="de_search_img_width" class="frm_input" size="3">
                <label for="de_search_img_height">이미지높이</label>
                <input type="text" name="de_search_img_height" value="<?php echo $default['de_search_img_height']; ?>" id="de_search_img_height" class="frm_input" size="3">
                <label for="de_search_list_mod">1줄당 이미지 수</label>
                <input type="text" name="de_search_list_mod" value="<?php echo $default['de_search_list_mod']; ?>" id="de_search_list_mod" class="frm_input" size="1">
                <label for="de_search_list_row">출력할 줄 수</label>
                <input type="text" name="de_search_list_row" value="<?php echo $default['de_search_list_row']; ?>" id="de_search_list_row" class="frm_input" size="1">            </td>
        </tr>
        <tr>
            <th scope="row">PC 유형별상품 목록</th>
            <td>
                <label for="de_listtype_list_skin">스킨</label>
                <select name="de_listtype_list_skin" id="de_listtype_list_skin">
                    <?php echo get_list_skin_options("^list.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $default['de_listtype_list_skin']); ?>
                </select>
                <label for="de_listtype_img_width">이미지폭</label>
                <input type="text" name="de_listtype_img_width" value="<?php echo $default['de_listtype_img_width']; ?>" id="de_listtype_img_width" class="frm_input" size="3">
                <label for="de_listtype_img_height">이미지높이</label>
                <input type="text" name="de_listtype_img_height" value="<?php echo $default['de_listtype_img_height']; ?>" id="de_listtype_img_height" class="frm_input" size="3">
                <label for="de_listtype_list_mod">1줄당 이미지 수</label>
                <input type="text" name="de_listtype_list_mod" value="<?php echo $default['de_listtype_list_mod']; ?>" id="de_listtype_list_mod" class="frm_input" size="1">
                <label for="de_listtype_list_row">출력할 줄 수</label>
                <input type="text" name="de_listtype_list_row" value="<?php echo $default['de_listtype_list_row']; ?>" id="de_listtype_list_row" class="frm_input" size="1">            </td>
        </tr>
        <tr>
            <th scope="row"><?php echo '<img src="'.G5_ADMIN_URL.'/img/icon_mobile.gif" title="모바일접속">';?> 모바일 관련상품 출력</th>
            <td>
                <?php echo help("관련상품의 경우 등록된 상품은 모두 출력하므로 '출력할 줄 수'는 설정하지 않습니다. 이미지높이를 0으로 설정하면 상품이미지를 이미지폭에 비례하여 생성합니다."); ?>
                <!-- 모바일 출력설정 및 스킨설정 -->
                <div>
                <label class="switch-check-mini">
                    <input type="checkbox" name="de_mobile_rel_list_use" value="1" id="de_mobile_rel_list_use" <?php echo $default['de_mobile_rel_list_use']?"checked":""; ?>> 출력
                    <div class="check-slider-mini round"></div>
                </label>
                
                <select name="de_mobile_rel_list_skin" id="de_mobile_rel_list_skin">
                    <?php echo get_list_skin_options("^relation.[0-9]+\.skin\.php", G5_MSHOP_SKIN_PATH, $default['de_mobile_rel_list_skin']); ?>
                </select>
                </div>
                <!--//-->
                
                <label for="de_mobile_rel_img_width">이미지폭</label>
                <input type="text" name="de_mobile_rel_img_width" value="<?php echo $default['de_mobile_rel_img_width']; ?>" id="de_mobile_rel_img_width" class="frm_input" size="3">
                <label for="de_mobile_rel_img_height">이미지높이</label>
                <input type="text" name="de_mobile_rel_img_height" value="<?php echo $default['de_mobile_rel_img_height']; ?>" id="de_mobile_rel_img_height" class="frm_input" size="3">
                <label for="de_mobile_rel_list_mod">1줄당 이미지 수</label>
                <input type="text" name="de_mobile_rel_list_mod" value="<?php echo $default['de_mobile_rel_list_mod']; ?>" id="de_mobile_rel_list_mod" class="frm_input" size="1">
                </td>
        </tr>
        <tr>
            <th scope="row"><?php echo '<img src="'.G5_ADMIN_URL.'/img/icon_mobile.gif" title="모바일접속">';?> 모바일 검색상품 출력</th>
            <td>
                <label for="de_mobile_search_list_skin">스킨</label>
                <select name="de_mobile_search_list_skin" id="de_mobile_search_list_skin">
                    <?php echo get_list_skin_options("^list.[0-9]+\.skin\.php", G5_MSHOP_SKIN_PATH, $default['de_mobile_search_list_skin']); ?>
                </select>
                <label for="de_mobile_search_img_width">이미지폭</label>
                <input type="text" name="de_mobile_search_img_width" value="<?php echo $default['de_mobile_search_img_width']; ?>" id="de_mobile_search_img_width" class="frm_input" size="3">
                <label for="de_mobile_search_img_height">이미지높이</label>
                <input type="text" name="de_mobile_search_img_height" value="<?php echo $default['de_mobile_search_img_height']; ?>" id="de_mobile_search_img_height" class="frm_input" size="3">
                <label for="de_mobile_search_list_mod">1줄당 이미지 수</label>
                <input type="text" name="de_mobile_search_list_mod" value="<?php echo $default['de_mobile_search_list_mod']; ?>" id="de_mobile_search_list_mod" class="frm_input" size="1">
                <label for="de_mobile_search_list_row">출력할 줄 수</label>
                <input type="text" name="de_mobile_search_list_row" value="<?php echo $default['de_mobile_search_list_row']; ?>" id="de_mobile_search_list_row" class="frm_input" size="1">            </td>
        </tr>
        <tr>
            <th scope="row"><?php echo '<img src="'.G5_ADMIN_URL.'/img/icon_mobile.gif" title="모바일접속">';?> 모바일 유형별상품 목록</th>
            <td>
                <label for="de_mobile_listtype_list_skin">스킨</label>
                <select name="de_mobile_listtype_list_skin" id="de_mobile_listtype_list_skin">
                    <?php echo get_list_skin_options("^list.[0-9]+\.skin\.php", G5_MSHOP_SKIN_PATH, $default['de_mobile_listtype_list_skin']); ?>
                </select>
                <label for="de_mobile_listtype_img_width">이미지폭</label>
                <input type="text" name="de_mobile_listtype_img_width" value="<?php echo $default['de_mobile_listtype_img_width']; ?>" id="de_mobile_listtype_img_width" class="frm_input" size="3">
                <label for="de_mobile_listtype_img_height">이미지높이</label>
                <input type="text" name="de_mobile_listtype_img_height" value="<?php echo $default['de_mobile_listtype_img_height']; ?>" id="de_mobile_listtype_img_height" class="frm_input" size="3">
                <label for="de_mobile_listtype_list_mod">1줄당 이미지 수</label>
                <input type="text" name="de_mobile_listtype_list_mod" value="<?php echo $default['de_mobile_listtype_list_mod']; ?>" id="de_mobile_listtype_list_mod" class="frm_input" size="1">
                <label for="de_mobile_listtype_list_row">출력할 줄 수</label>
                <input type="text" name="de_mobile_listtype_list_row" value="<?php echo $default['de_mobile_listtype_list_row']; ?>" id="de_mobile_listtype_list_row" class="frm_input" size="1">            </td>
        </tr>
        </tbody>
        </table>
    </div>
        
</section>

<?php echo preg_replace('#</div>$#i', '<button type="button" class="shop_etc btn btn-orangered"><i class="fas fa-magic"></i> 테마설정 가져오기</button></div>', $frm_submit); ?>
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
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
