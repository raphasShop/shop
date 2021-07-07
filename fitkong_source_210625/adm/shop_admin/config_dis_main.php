<?php
$sub_menu = '400911'; /* (새로만듬) 메인상품 진열 */
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '메인 상품진열';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$pg_anchor = '<ul class="anchor">
<li><a href="#anc_scf_index">PC 메인상품 설정</a></li>
<li><a href="#anc_mscf_index">모바일 메인상품 설정</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';
?>

<form name="fconfig" action="./config_dis_mainupdate.php" onsubmit="return fconfig_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="">

<!-- PC 메인상품 설정 { -->
<section id="anc_scf_index">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm">PC 메인상품 설정</h2>
    <div class="local_desc02 local_desc">
        <p>
            상품관리에서 선택한 상품의 타입대로 PC 쇼핑몰 초기화면에 출력합니다. (상품 타입 히트/추천/최신/인기/할인)<br>
            각 타입별로 선택된 상품이 없으면 쇼핑몰 초기화면에 출력하지 않습니다.
            <br />
        타이틀은 입력한 내용대로 노출됩니다!!!(히트/추천/최신/인기/할인 타입을 원하는 제목으로 마음대로 지정가능)</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>PC 메인상품 항목 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row">
            <input type="text" name="de_type1_title" value="<?php echo $default['de_type1_title']; ?>" id="de_type1_title" class="frm_input w100per">
            </th>
            <td>
                <!-- type1 출력설정 및 스킨설정 -->
                <div>
                <label class="switch-check-mini">
                <input type="checkbox" name="de_type1_list_use" value="1" id="de_type1_list_use" <?php echo $default['de_type1_list_use']?"checked":""; ?>>
                <div class="check-slider-mini round"></div>
                </label>
                <!--<label for="de_type1_list_use">출력</label>-->

                <!--<label for="de_type1_list_skin">스킨</label>-->
                <select name="de_type1_list_skin" id="de_type1_list_skin">
                    <?php echo get_list_skin_options("^main.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $default['de_type1_list_skin']); ?>
                </select>
                </div>
                <!--//-->
                
                <label for="de_type1_list_mod">※1줄 이미지수</label>
                <input type="text" name="de_type1_list_mod" value="<?php echo $default['de_type1_list_mod']; ?>" id="de_type1_list_mod" class="frm_input" size="2">
                <label for="de_type1_list_row">× </label>
                <input type="text" name="de_type1_list_row" value="<?php echo $default['de_type1_list_row']; ?>" id="de_type1_list_row" class="frm_input" size="1"> <label for="de_type1_list_row">줄</label>
                <label for="de_type1_img_width">&nbsp;&nbsp;※이미지 가로</label>
                <input type="text" name="de_type1_img_width" value="<?php echo $default['de_type1_img_width']; ?>" id="de_type1_img_width" class="frm_input" size="3">
                <label for="de_type1_img_height">× 세로</label>
                <input type="text" name="de_type1_img_height" value="<?php echo $default['de_type1_img_height']; ?>" id="de_type1_img_height" class="frm_input" size="3">            
                <br>[기본제목] 히트상품(type1)</td>
        </tr>
        <tr>
            <th scope="row"><input type="text" name="de_type2_title" value="<?php echo $default['de_type2_title']; ?>" id="de_type2_title" class="frm_input w100per"></th>
            <td>
                <!-- type2 출력설정 및 스킨설정 -->
                <div>
                <label class="switch-check-mini">
                <input type="checkbox" name="de_type2_list_use" value="1" id="de_type2_list_use" <?php echo $default['de_type2_list_use']?"checked":""; ?>>
                <div class="check-slider-mini round"></div>
                </label>

                <select name="de_type2_list_skin" id="de_type2_list_skin">
                    <?php echo get_list_skin_options("^main.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $default['de_type2_list_skin']); ?>
                </select>
                </div>
                <!--//-->

                <label for="de_type2_list_mod">※1줄 이미지수</label>
                <input type="text" name="de_type2_list_mod" value="<?php echo $default['de_type2_list_mod']; ?>" id="de_type2_list_mod" class="frm_input" size="2">
                <label for="de_type2_list_row">× </label>
                <input type="text" name="de_type2_list_row" value="<?php echo $default['de_type2_list_row']; ?>" id="de_type2_list_row" class="frm_input" size="1"> <label for="de_type2_list_row">줄</label>
                <label for="de_type2_img_width">&nbsp;&nbsp;※이미지 가로</label>
                <input type="text" name="de_type2_img_width" value="<?php echo $default['de_type2_img_width']; ?>" id="de_type2_img_width" class="frm_input" size="3">
                <label for="de_type2_img_height">× 세로</label>
                <input type="text" name="de_type2_img_height" value="<?php echo $default['de_type2_img_height']; ?>" id="de_type2_img_height" class="frm_input" size="3">
                <br>[기본제목] 추천상품(type2) </td>
        </tr>
        <tr>
            <th scope="row"><input type="text" name="de_type3_title" value="<?php echo $default['de_type3_title']; ?>" id="de_type3_title" class="frm_input w100per" /></th>
            <td>
                <!-- type3 출력설정 및 스킨설정 -->
                <div>
                <label class="switch-check-mini">
                <input type="checkbox" name="de_type3_list_use" value="1" id="de_type3_list_use" <?php echo $default['de_type3_list_use']?"checked":""; ?>>
                <div class="check-slider-mini round"></div>
                </label>

                <select name="de_type3_list_skin" id="de_type3_list_skin">
                    <?php echo get_list_skin_options("^main.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $default['de_type3_list_skin']); ?>
                </select>
                </div>
                <!--//-->
                
                <label for="de_type3_list_mod">※1줄 이미지수</label>
                <input type="text" name="de_type3_list_mod" value="<?php echo $default['de_type3_list_mod']; ?>" id="de_type3_list_mod" class="frm_input" size="2">
                <label for="de_type3_list_row">× </label>
                <input type="text" name="de_type3_list_row" value="<?php echo $default['de_type3_list_row']; ?>" id="de_type3_list_row" class="frm_input" size="1"> <label for="de_type3_list_row">줄</label>
                <label for="de_type3_img_width">&nbsp;&nbsp;※이미지 가로</label>
                <input type="text" name="de_type3_img_width" value="<?php echo $default['de_type3_img_width']; ?>" id="de_type3_img_width" class="frm_input" size="3">
                <label for="de_type3_img_height">× 세로</label>
                <input type="text" name="de_type3_img_height" value="<?php echo $default['de_type3_img_height']; ?>" id="de_type3_img_height" class="frm_input" size="3">
                <br>[기본제목] 최신상품(type3) </td>
        </tr>
        <tr>
            <th scope="row"><input type="text" name="de_type4_title" value="<?php echo $default['de_type4_title']; ?>" id="de_type4_title" class="frm_input w100per"></th>
            <td>
                <!-- type4 출력설정 및 스킨설정 -->
                <div>
                <label class="switch-check-mini">
                <input type="checkbox" name="de_type4_list_use" value="1" id="de_type4_list_use" <?php echo $default['de_type4_list_use']?"checked":""; ?>>
                <div class="check-slider-mini round"></div>
                </label>

                <select name="de_type4_list_skin" id="de_type4_list_skin">
                    <?php echo get_list_skin_options("^main.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $default['de_type4_list_skin']); ?>
                </select>
                </div>
                <!--//-->
                
                <label for="de_type4_list_mod">※1줄 이미지수</label>
                <input type="text" name="de_type4_list_mod" value="<?php echo $default['de_type4_list_mod']; ?>" id="de_type4_list_mod" class="frm_input" size="2">
                <label for="de_type4_list_row">× </label>
                <input type="text" name="de_type4_list_row" value="<?php echo $default['de_type4_list_row']; ?>" id="de_type4_list_row" class="frm_input" size="1"> <label for="de_type4_list_row">줄</label>
                <label for="de_type4_img_width">&nbsp;&nbsp;※이미지 가로</label>
                <input type="text" name="de_type4_img_width" value="<?php echo $default['de_type4_img_width']; ?>" id="de_type4_img_width" class="frm_input" size="3">
                <label for="de_type4_img_height">× 세로</label>
                <input type="text" name="de_type4_img_height" value="<?php echo $default['de_type4_img_height']; ?>" id="de_type4_img_height" class="frm_input" size="3">
                <br>[기본제목] 인기상품(type4) </td>
        </tr>
        <tr>
            <th scope="row"><input type="text" name="de_type5_title" value="<?php echo $default['de_type5_title']; ?>" id="de_type5_title" class="frm_input w100per"></th>
            <td>
                <!-- type5 출력설정 및 스킨설정 -->
                <div>
                <label class="switch-check-mini">
                <input type="checkbox" name="de_type5_list_use" value="1" id="de_type5_list_use" <?php echo $default['de_type5_list_use']?"checked":""; ?>>
                <div class="check-slider-mini round"></div>
                </label>

                <select name="de_type5_list_skin" id="de_type5_list_skin">
                    <?php echo get_list_skin_options("^main.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $default['de_type5_list_skin']); ?>
                </select>
                </div>
                <!--//-->

                <label for="de_type5_list_mod">※1줄 이미지수</label>
                <input type="text" name="de_type5_list_mod" value="<?php echo $default['de_type5_list_mod']; ?>" id="de_type5_list_mod" class="frm_input" size="2">
                <label for="de_type5_list_row">× </label>
                <input type="text" name="de_type5_list_row" value="<?php echo $default['de_type5_list_row']; ?>" id="de_type5_list_row" class="frm_input" size="1"> <label for="de_type5_list_row">줄</label>
                <label for="de_type5_img_width">&nbsp;&nbsp;※이미지 가로</label>
                <input type="text" name="de_type5_img_width" value="<?php echo $default['de_type5_img_width']; ?>" id="de_type5_img_width" class="frm_input" size="3">
                <label for="de_type5_img_height">× 세로</label>
                <input type="text" name="de_type5_img_height" value="<?php echo $default['de_type5_img_height']; ?>" id="de_type5_img_height" class="frm_input" size="3">
                <br>[기본제목] 할인상품(type5) </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo (USE_G5_THEME) ? preg_replace('#</div>$#i', '<button type="button" class="shop_pc_index">테마설정 가져오기</button></div>', $frm_submit) : $frm_submit; ?>
<!--//-->

<!-- 모바일 메인상품 설정 { -->
<section id="anc_mscf_index">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm">
        모바일 메인상품 설정&nbsp;&nbsp;&nbsp;
        <span class="same_info"><input type="checkbox" name="ad_type_title" value="same" id="ad_type_title_same"> PC메인상품항목과 동일한 메뉴명 사용</span>
    </h2>
    <div class="local_desc02 local_desc">
        <p>
            상품관리에서 선택한 상품의 타입대로 모바일 쇼핑몰 초기화면에 출력합니다. (상품 타입 히트/추천/최신/인기/할인)<br>
            각 타입별로 선택된 상품이 없으면 모바일 쇼핑몰 초기화면에 출력하지 않습니다.
            <br />
        타이틀은 입력한 내용대로 노출됩니다!!!(히트/추천/최신/인기/할인 타입을 원하는 제목으로 마음대로 지정가능)</p>
    </div>

  <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>모바일 메인상품 항목 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><input type="text" name="de_mobile_type1_title" value="<?php echo $default['de_mobile_type1_title']; ?>" id="de_mobile_type1_title" class="frm_input w100per"></th>
            <td>
                <!-- _mobile_type1 출력설정 및 스킨설정 -->
                <div>
                <label class="switch-check-mini">
                <input type="checkbox" name="de_mobile_type1_list_use" value="1" id="de_mobile_type1_list_use" <?php echo $default['de_mobile_type1_list_use']?"checked":""; ?>>
                <div class="check-slider-mini round"></div>
                </label>

                <select name="de_mobile_type1_list_skin" id="de_mobile_type1_list_skin">
                    <?php echo get_list_skin_options("^main.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $default['de_mobile_type1_list_skin']); ?>
                </select>
                </div>
                <!--//-->
                
                <label for="de_mobile_type1_list_mod">※1줄 이미지수</label>
                <input type="text" name="de_mobile_type1_list_mod" value="<?php echo $default['de_mobile_type1_list_mod']; ?>" id="de_mobile_type1_list_mod" class="frm_input" size="2">
                 <label for="de_mobile_type1_list_row">× </label>
                <input type="text" name="de_mobile_type1_list_row" value="<?php echo $default['de_mobile_type1_list_row']; ?>" id="de_mobile_type1_list_row" class="frm_input" size="1"> <label for="de_mobile_type1_list_row">줄</label>
                <label for="de_mobile_type1_img_width">&nbsp;&nbsp;※이미지 가로</label>
                <input type="text" name="de_mobile_type1_img_width" value="<?php echo $default['de_mobile_type1_img_width']; ?>" id="de_mobile_type1_img_width" class="frm_input" size="3">
                <label for="de_mobile_type1_img_height">× 세로</label>
                <input type="text" name="de_mobile_type1_img_height" value="<?php echo $default['de_mobile_type1_img_height']; ?>" id="de_mobile_type1_img_height" class="frm_input" size="3"> 
                <br>[기본제목] 히트상품(type1)
            </td>
        </tr>
        <tr>
            <th scope="row"><input type="text" name="de_mobile_type2_title" value="<?php echo $default['de_mobile_type2_title']; ?>" id="de_mobile_type2_title" class="frm_input w100per"></th>
            <td>
                <!-- _mobile_type2 출력설정 및 스킨설정 -->
                <div>
                <label class="switch-check-mini">
                <input type="checkbox" name="de_mobile_type2_list_use" value="1" id="de_mobile_type2_list_use" <?php echo $default['de_mobile_type2_list_use']?"checked":""; ?>>
                <div class="check-slider-mini round"></div>
                </label>

                <select name="de_mobile_type2_list_skin" id="de_mobile_type2_list_skin">
                    <?php echo get_list_skin_options("^main.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $default['de_mobile_type2_list_skin']); ?>
                </select>
                </div>
                <!--//-->
                
                <label for="de_mobile_type2_list_mod">※1줄 이미지수</label>
                <input type="text" name="de_mobile_type2_list_mod" value="<?php echo $default['de_mobile_type2_list_mod']; ?>" id="de_mobile_type2_list_mod" class="frm_input" size="2">
                 <label for="de_mobile_type2_list_row">× </label>
                <input type="text" name="de_mobile_type2_list_row" value="<?php echo $default['de_mobile_type2_list_row']; ?>" id="de_mobile_type2_list_row" class="frm_input" size="1"> <label for="de_mobile_type2_list_row">줄</label>
                <label for="de_mobile_type2_img_width">&nbsp;&nbsp;※이미지 가로</label>
                <input type="text" name="de_mobile_type2_img_width" value="<?php echo $default['de_mobile_type2_img_width']; ?>" id="de_mobile_type2_img_width" class="frm_input" size="3">
                <label for="de_mobile_type2_img_height">× 세로</label>
                <input type="text" name="de_mobile_type2_img_height" value="<?php echo $default['de_mobile_type2_img_height']; ?>" id="de_mobile_type2_img_height" class="frm_input" size="3">
                <br>[기본제목] 추천상품(type2)
            </td>
        </tr>
        <tr>
            <th scope="row"><input type="text" name="de_mobile_type3_title" value="<?php echo $default['de_mobile_type3_title']; ?>" id="de_mobile_type3_title" class="frm_input w100per"></th>
            <td>
                <!-- _mobile_type3 출력설정 및 스킨설정 -->
                <div>
                <label class="switch-check-mini">
                <input type="checkbox" name="de_mobile_type3_list_use" value="1" id="de_mobile_type3_list_use" <?php echo $default['de_mobile_type3_list_use']?"checked":""; ?>>
                <div class="check-slider-mini round"></div>
                </label>

                <select name="de_mobile_type3_list_skin" id="de_mobile_type3_list_skin">
                    <?php echo get_list_skin_options("^main.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $default['de_mobile_type3_list_skin']); ?>
                </select>
                </div>
                <!--//-->
                
                <label for="de_mobile_type3_list_mod">※1줄 이미지수</label>
                <input type="text" name="de_mobile_type3_list_mod" value="<?php echo $default['de_mobile_type3_list_mod']; ?>" id="de_mobile_type3_list_mod" class="frm_input" size="2">
                 <label for="de_mobile_type3_list_row">× </label>
                <input type="text" name="de_mobile_type3_list_row" value="<?php echo $default['de_mobile_type3_list_row']; ?>" id="de_mobile_type3_list_row" class="frm_input" size="1"> <label for="de_mobile_type3_list_row">줄</label>
                <label for="de_mobile_type3_img_width">&nbsp;&nbsp;※이미지 가로</label>
                <input type="text" name="de_mobile_type3_img_width" value="<?php echo $default['de_mobile_type3_img_width']; ?>" id="de_mobile_type3_img_width" class="frm_input" size="3">
                <label for="de_mobile_type3_img_height">× 세로</label>
                <input type="text" name="de_mobile_type3_img_height" value="<?php echo $default['de_mobile_type3_img_height']; ?>" id="de_mobile_type3_img_height" class="frm_input" size="3">
                <br>[기본제목] 최신상품(type3)
            </td>
        </tr>
        <tr>
            <th scope="row"><input type="text" name="de_mobile_type4_title" value="<?php echo $default['de_mobile_type4_title']; ?>" id="de_mobile_type4_title" class="frm_input w100per"></th>
            <td>
                <!-- _mobile_type4 출력설정 및 스킨설정 -->
                <div>
                <label class="switch-check-mini">
                <input type="checkbox" name="de_mobile_type4_list_use" value="1" id="de_mobile_type4_list_use" <?php echo $default['de_mobile_type4_list_use']?"checked":""; ?>>
                <div class="check-slider-mini round"></div>
                </label>

                <select name="de_mobile_type4_list_skin" id="de_mobile_type4_list_skin">
                    <?php echo get_list_skin_options("^main.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $default['de_mobile_type4_list_skin']); ?>
                </select>
                </div>
                <!--//-->
                
                <label for="de_mobile_type4_list_mod">※1줄 이미지수</label>
                <input type="text" name="de_mobile_type4_list_mod" value="<?php echo $default['de_mobile_type4_list_mod']; ?>" id="de_mobile_type4_list_mod" class="frm_input" size="2">
                 <label for="de_mobile_type4_list_row">× </label>
                <input type="text" name="de_mobile_type4_list_row" value="<?php echo $default['de_mobile_type4_list_row']; ?>" id="de_mobile_type4_list_row" class="frm_input" size="1"> <label for="de_mobile_type4_list_row">줄</label>
                <label for="de_mobile_type4_img_width">&nbsp;&nbsp;※이미지 가로</label>
                <input type="text" name="de_mobile_type4_img_width" value="<?php echo $default['de_mobile_type4_img_width']; ?>" id="de_mobile_type4_img_width" class="frm_input" size="3">
                <label for="de_mobile_type4_img_height">× 세로</label>
                <input type="text" name="de_mobile_type4_img_height" value="<?php echo $default['de_mobile_type4_img_height']; ?>" id="de_mobile_type4_img_height" class="frm_input" size="3">
                <br>[기본제목] 인기상품(type4)
            </td>
        </tr>
        <tr>
            <th scope="row"><input type="text" name="de_mobile_type5_title" value="<?php echo $default['de_mobile_type5_title']; ?>" id="de_mobile_type5_title" class="frm_input w100per"></th>
            <td>
                <!-- _mobile_type5 출력설정 및 스킨설정 -->
                <div>
                <label class="switch-check-mini">
                <input type="checkbox" name="de_mobile_type5_list_use" value="1" id="de_mobile_type5_list_use" <?php echo $default['de_mobile_type5_list_use']?"checked":""; ?>>
                <div class="check-slider-mini round"></div>
                </label>

                <select name="de_mobile_type5_list_skin" id="de_mobile_type5_list_skin">
                    <?php echo get_list_skin_options("^main.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $default['de_mobile_type5_list_skin']); ?>
                </select>
                </div>
                <!--//-->

                <label for="de_mobile_type5_list_mod">※1줄 이미지수</label>
                <input type="text" name="de_mobile_type5_list_mod" value="<?php echo $default['de_mobile_type5_list_mod']; ?>" id="de_mobile_type5_list_mod" class="frm_input" size="2">
                 <label for="de_mobile_type5_list_row">× </label>
                <input type="text" name="de_mobile_type5_list_row" value="<?php echo $default['de_mobile_type5_list_row']; ?>" id="de_mobile_type5_list_row" class="frm_input" size="1"> <label for="de_mobile_type5_list_row">줄</label>
                <label for="de_mobile_type5_img_width">&nbsp;&nbsp;※이미지 가로</label>
                <input type="text" name="de_mobile_type5_img_width" value="<?php echo $default['de_mobile_type5_img_width']; ?>" id="de_mobile_type5_img_width" class="frm_input" size="3">
                <label for="de_mobile_type5_img_height">× 세로</label>
                <input type="text" name="de_mobile_type5_img_height" value="<?php echo $default['de_mobile_type5_img_height']; ?>" id="de_mobile_type5_img_height" class="frm_input" size="3">
                <br>[기본제목] 할인상품(type5)
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo preg_replace('#</div>$#i', '<button type="button" class="shop_mobile_index">테마설정 가져오기</button></div>', $frm_submit); ?>
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
    // 쇼핑몰 초기화면 메뉴 가져오기 선택
    $("input[name=ad_type_title]").on("click", function() {
        var addr = $(this).val().split(String.fromCharCode(30));

        if (addr[0] == "same") {
            mobiletypetitle();
        } else {

            var f = document.fconfig;
            f.de_type1_title.value = typetitle[0];
            f.de_type2_title.value = typetitle[1];
            f.de_type3_title.value = typetitle[2];
            f.de_type4_title.value = typetitle[3];
            f.de_type5_title.value = typetitle[4];

            /*
			var zip1 = addr[3].replace(/[^0-9]/g, "");
            var zip2 = addr[4].replace(/[^0-9]/g, "");

            var code = String(zip1) + String(zip2);

            if(zipcode != code) {
                calculate_sendcost(code);
            }
			*/
        }
    });
	
// 쇼핑몰 초기화면 정보와 동일합니다.
function mobiletypetitle() {
    var f = document.fconfig;

    f.de_mobile_type1_title.value = f.de_type1_title.value;
    f.de_mobile_type2_title.value = f.de_type2_title.value;
    f.de_mobile_type3_title.value = f.de_type3_title.value;
    f.de_mobile_type4_title.value = f.de_type4_title.value;
    f.de_mobile_type5_title.value = f.de_type5_title.value;

    //calculate_sendcost(String(f.od_b_zip.value));
}
</script>

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
