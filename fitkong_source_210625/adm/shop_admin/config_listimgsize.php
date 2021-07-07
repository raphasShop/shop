<?php
$sub_menu = '400913'; /* (새로만듬) 상품이미지 기본사이즈 */
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '상품이미지사이즈';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$pg_anchor = '<ul class="anchor">
<li><a href="#anc_scf_skin">상품이미지사이즈</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';


?>

<form name="fconfig" action="./config_listimgsizeupdate.php" onsubmit="return fconfig_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="">

<!-- 상품 이미지 기본사이즈 설정 -->   
<section id="anc_scf_list">
    <?php// echo $pg_anchor; ?>
    <h2 class="h2_frm">상품 이미지 기본사이즈 설정</h2>
    <div class="local_desc02 local_desc">
        <p>[상품이미지기본사이즈] 상품목록,검색목록,상품상세정보페이지 등 상품 노출되는곳의 상품이미지 기본 사이즈를 설정합니다.</p>
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
            <th scope="row">이미지(소)</th>
            <td>
                <?php echo help("분류리스트에서 보여지는 사이즈를 설정하시면 됩니다. 분류관리의 출력 이미지폭, 높이의 기본값으로 사용됩니다. 높이를 0 으로 설정하시면 폭에 비례하여 높이를 썸네일로 생성합니다."); ?>
                <label for="de_simg_width"><span class="sound_only">이미지(소) </span>폭</label>
                <input type="text" name="de_simg_width" value="<?php echo $default['de_simg_width']; ?>" id="de_simg_width" class="frm_input" size="4"> 픽셀
                /
                <label for="de_simg_height"><span class="sound_only">이미지(소) </span>높이</label>
                <input type="text" name="de_simg_height" value="<?php echo $default['de_simg_height']; ?>" id="de_simg_height" class="frm_input" size="4"> 픽셀            </td>
        </tr>
        <tr>
            <th scope="row">이미지(중)</th>
            <td>
                <?php echo help("상품상세보기에서 보여지는 상품이미지의 사이즈를 픽셀로 설정합니다. 높이를 0 으로 설정하시면 폭에 비례하여 높이를 썸네일로 생성합니다."); ?>
                <label for="de_mimg_width"><span class="sound_only">이미지(중) </span>폭</label>
                <input type="text" name="de_mimg_width" value="<?php echo $default['de_mimg_width']; ?>" id="de_mimg_width" class="frm_input" size="4"> 픽셀
                /
                <label for="de_mimg_height"><span class="sound_only">이미지(중) </span>높이</label>
                <input type="text" name="de_mimg_height" value="<?php echo $default['de_mimg_height']; ?>" id="de_mimg_height" class="frm_input" size="4"> 픽셀            </td>
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
