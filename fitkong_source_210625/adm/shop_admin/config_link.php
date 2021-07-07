<?php
$sub_menu = '111502';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '추천쇼핑몰설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$pg_anchor = '<ul class="anchor">
<li><a href="#anc_ch_basic">기본설정</a></li>
<li><a href="#anc_ch_market">추천쇼핑몰관리</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';
?>
<style>

.div-basic { width:180px; margin:0px; padding:0px;}
.div-basic > ul { list-style:none; padding:0px; margin:0px;}
.div-basic > ul > li { margin:0px; padding:5px 2px; font-size:12px;}
.div-basic > li > a { }
</style>

<form name="fconfig" action="./config_linkupdate.php" onsubmit="return fconfig_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="">

<!-- 추천쇼핑몰설정 2016-09 { -->
<section id="anc_ch_basic">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm orangered">바로구매(추천쇼핑몰표시),전화,카카오링크 설정</h2>
    
    <div class="local_desc01 local_desc">
		<p>(1) 현재 쇼핑몰에서 실제구매를 하지않고, 다른사이트로 연결하여 구매페이지로 이동 - 모바일 이용시 바로 전화링크 및 카카오톡 상담 링크로 이동</p>
        <p>(2) 상품페이지 구매창 아래에 오픈마켓구매가능하게 링크 이용 - 모바일 이용시 바로 전화링크 및 카카오톡 상담 링크로 이동</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>
        추천쇼핑몰 기능사용여부 및 모바일상담기능추가
        </caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="ch_link_baro_use">추천쇼핑몰링크</label></th>
            <td colspan="3">
                <label class="switch-check">
                <input type="checkbox" name="ch_link_baro_use" value="1" id="ch_link_baro_use" <?php echo $default['ch_link_baro_use']?"checked":""; ?>> 사용함
                <div class="check-slider round"></div>
                </label>
			</td>
        </tr>
        <tr>
            <th scope="row"><label for="ch_link_tel_number">전화상담</label></th>
            <td colspan="3">
                <input type="text" name="ch_link_tel_number" value="<?php echo $default['ch_link_tel_number']; ?>" id="ch_link_tel_number" class="frm_input" size="15">
                전화번호형식으로기재 (예:010-0000-0000)
			</td>
        </tr>
        <tr>
            <th scope="row"><label for="ch_link_kakaoplus_url">카카오상담(URL기재)</label></th>
            <td colspan="3">
                <input type="text" name="ch_link_kakaoplus_url" value="<?php echo $default['ch_link_kakaoplus_url']; ?>" id="ch_link_kakaoplus_url" class="frm_input w90per">
                http://포함
			</td>
        </tr>
        </tbody>
        </table>
    </div>  
</section>

<?php echo $frm_submit; ?>
<!-- } -->

<!-- 안내 -->   
<div class="h30"><!--//--></div>
<div class="local_desc01">
    <ul>
        <li class="title1">
        카카오톡상담문의를 위한 카카오톡 옐로아이디 만들기
        </li>
        <li class="content-list-txt1">
        회사/브랜드/홈페이지에서 상담을 위한 공간을 무료로 제공하는 것이 카카오톡의 옐로페이지입니다.<br />
        기본은 무료로 제공되는 서비스이며, 옵션사용시에만 유료를 선택할수 있습니다.
        </li>
        <li class="txt1">
        <b>(1) 카카오톡 옐로아이디 발급받기</b> : <a href="https://yellowid.kakao.com/login" target="_blank">https://yellowid.kakao.com/login</a><br />
        - 카카오톡아이디가 있으면 로그인후 발급 받으면되고, 없으면 카카오톡부터 가입하고 로그인해서 발급 받으면 됩니다
        </li>
        <li class="txt1">
        <b>(2) 옐로아이디 발급받는 방법 안내(블로그)</b> : <a href="http://blog.naver.com/pumi7676/220817426550" target="_blank">http://blog.naver.com/pumi7676/220817426550</a><br />
        - 카카오톡아이디가 있으면 로그인후 발급 받으면되고, 없으면 카카오톡부터 가입하고 로그인해서 발급 받으면 됩니다
        </li>
    </ul>
</div>
<!-- // --> 

<!-- 추천쇼핑몰 로고 등록 2016-09 { -->
<section id="anc_ch_market">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm orangered">추천쇼핑몰로고 등록관리</h2>
    
    <div class="local_desc01 local_desc">
		<p>상품등록시 추천쇼핑몰명 및 로고 등록관리
           <br />동일한사이즈로 작업한 로고와 추천쇼핑몰명을 등록해주세요
           <br />※권장사이즈는 165 * 55 이며, 배경이 투명한 png파일을 권장합니다
           <br /><span class="orangered">※쇼핑몰로고는 순서를 지정한후 상품등록시 쇼핑몰을 등록해주세요. 순서를 마음대로 바꾸면 기존에 등록된 상품에도 모두 변경해주셔야합니다.</span>
           </p>
    </div>
    
    <!-- 추천쇼핑몰로고등록관리(가로형) -->
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <tbody>
        <tr valign="top">
            <td>          
                <div class="div-basic">
                   <ul>
                      <li><label for="ch_link_market_name1"><b>추천쇼핑몰1</b></label></li>
                      
                      <li>
                         <input type="file" name="market_logo1" id="market_logo1">
                         <?php
                           $market_logo1 = G5_DATA_PATH."/common/market_logo1";
                           if (file_exists($market_logo1))
                           {
                              $size = getimagesize($market_logo1);
                         ?>
                         <div style="width:165px;height:55px;border:solid 1px #ccc;background:#fafafa;text-align:center;margin-top:10px;margin-bottom:5px;">
                            <img src="<?php echo G5_DATA_URL; ?>/common/market_logo1" alt="">
                         </div>
                         <input type="checkbox" name="market_logo_del1" value="1" id="market_logo_del1">
                         <label for="market_logo_del1"><span class="sound_only">추천쇼핑몰1</span> 삭제</label> 
                         <?php } ?>
                      </li>
                      <li><input type="text" name="ch_link_market_name1" value="<?php echo $default['ch_link_market_name1']; ?>" id="ch_link_market_name1" class="frm_input white bg-green" size="20"></li>
                      <li class="blue font-11">추천쇼핑몰명 반드시 기재</li>
                   </ul>
                </div>          
			</td>
            <td>          
                <div class="div-basic">
                   <ul>
                      <li><label for="ch_link_market_name2"><b>추천쇼핑몰2</b></label></li>
                      
                      <li>
                         <input type="file" name="market_logo2" id="market_logo2">
                         <?php
                           $market_logo2 = G5_DATA_PATH."/common/market_logo2";
                           if (file_exists($market_logo2))
                           {
                              $size = getimagesize($market_logo2);
                         ?>
                         <div style="width:165px;height:55px;border:solid 1px #ccc;background:#fafafa;text-align:center;margin-top:10px;margin-bottom:5px;">
                            <img src="<?php echo G5_DATA_URL; ?>/common/market_logo2" alt="">
                         </div>
                         <input type="checkbox" name="market_logo_del2" value="1" id="market_logo_del2">
                         <label for="market_logo_del2"><span class="sound_only">추천쇼핑몰2</span> 삭제</label> 
                         <?php } ?>
                      </li>
                      <li><input type="text" name="ch_link_market_name2" value="<?php echo $default['ch_link_market_name2']; ?>" id="ch_link_market_name2" class="frm_input white bg-green" size="20"></li>
                      <li class="blue font-11">추천쇼핑몰명 반드시 기재</li>
                   </ul>
                </div>          
			</td>
            <td>          
                <div class="div-basic">
                   <ul>
                      <li><label for="ch_link_market_name3"><b>추천쇼핑몰3</b></label></li>
                      
                      <li>
                         <input type="file" name="market_logo3" id="market_logo3">
                         <?php
                           $market_logo3 = G5_DATA_PATH."/common/market_logo3";
                           if (file_exists($market_logo3))
                           {
                              $size = getimagesize($market_logo3);
                         ?>
                         <div style="width:165px;height:55px;border:solid 1px #ccc;background:#fafafa;text-align:center;margin-top:10px;margin-bottom:5px;">
                            <img src="<?php echo G5_DATA_URL; ?>/common/market_logo3" alt="">
                         </div>
                         <input type="checkbox" name="market_logo_del3" value="1" id="market_logo_del3">
                         <label for="market_logo_del3"><span class="sound_only">추천쇼핑몰3</span> 삭제</label> 
                         <?php } ?>
                      </li>
                      <li><input type="text" name="ch_link_market_name3" value="<?php echo $default['ch_link_market_name3']; ?>" id="ch_link_market_name3" class="frm_input white bg-green" size="20"></li>
                      <li class="blue font-11">추천쇼핑몰명 반드시 기재</li>
                   </ul>
                </div>          
			</td>
            <td>          
                <div class="div-basic">
                   <ul>
                      <li><label for="ch_link_market_name4"><b>추천쇼핑몰4</b></label></li>
                      
                      <li>
                         <input type="file" name="market_logo4" id="market_logo4">
                         <?php
                           $market_logo4 = G5_DATA_PATH."/common/market_logo4";
                           if (file_exists($market_logo4))
                           {
                              $size = getimagesize($market_logo4);
                         ?>
                         <div style="width:165px;height:55px;border:solid 1px #ccc;background:#fafafa;text-align:center;margin-top:10px;margin-bottom:5px;">
                            <img src="<?php echo G5_DATA_URL; ?>/common/market_logo4" alt="">
                         </div>
                         <input type="checkbox" name="market_logo_del4" value="1" id="market_logo_del4">
                         <label for="market_logo_del4"><span class="sound_only">추천쇼핑몰4</span> 삭제</label> 
                         <?php } ?>
                      </li>
                      <li><input type="text" name="ch_link_market_name4" value="<?php echo $default['ch_link_market_name4']; ?>" id="ch_link_market_name4" class="frm_input white bg-green" size="20"></li>
                      <li class="blue font-11">추천쇼핑몰명 반드시 기재</li>
                   </ul>
                </div>          
			</td>
            </tr>
            <tr valign="top">
            <td>          
                <div class="div-basic">
                   <ul>
                      <li><label for="ch_link_market_name5"><b>추천쇼핑몰5</b></label></li>
                      
                      <li>
                         <input type="file" name="market_logo5" id="market_logo5">
                         <?php
                           $market_logo5 = G5_DATA_PATH."/common/market_logo5";
                           if (file_exists($market_logo5))
                           {
                              $size = getimagesize($market_logo5);
                         ?>
                         <div style="width:165px;height:55px;border:solid 1px #ccc;background:#fafafa;text-align:center;margin-top:10px;margin-bottom:5px;">
                            <img src="<?php echo G5_DATA_URL; ?>/common/market_logo5" alt="">
                         </div>
                         <input type="checkbox" name="market_logo_del5" value="1" id="market_logo_del5">
                         <label for="market_logo_del5"><span class="sound_only">추천쇼핑몰5</span> 삭제</label> 
                         <?php } ?>
                      </li>
                      <li><input type="text" name="ch_link_market_name5" value="<?php echo $default['ch_link_market_name5']; ?>" id="ch_link_market_name5" class="frm_input white bg-green" size="20"></li>
                      <li class="blue font-11">추천쇼핑몰명 반드시 기재</li>
                   </ul>
                </div>          
			</td>
            <td>          
                <div class="div-basic">
                   <ul>
                      <li><label for="ch_link_market_name6"><b>추천쇼핑몰6</b></label></li>
                      
                      <li>
                         <input type="file" name="market_logo6" id="market_logo6">
                         <?php
                           $market_logo6 = G5_DATA_PATH."/common/market_logo6";
                           if (file_exists($market_logo6))
                           {
                              $size = getimagesize($market_logo6);
                         ?>
                         <div style="width:165px;height:55px;border:solid 1px #ccc;background:#fafafa;text-align:center;margin-top:10px;margin-bottom:5px;">
                            <img src="<?php echo G5_DATA_URL; ?>/common/market_logo6" alt="">
                         </div>
                         <input type="checkbox" name="market_logo_del6" value="1" id="market_logo_del6">
                         <label for="market_logo_del6"><span class="sound_only">추천쇼핑몰6</span> 삭제</label> 
                         <?php } ?>
                      </li>
                      <li><input type="text" name="ch_link_market_name6" value="<?php echo $default['ch_link_market_name6']; ?>" id="ch_link_market_name6" class="frm_input white bg-green" size="20"></li>
                      <li class="blue font-11">추천쇼핑몰명 반드시 기재</li>
                   </ul>
                </div>          
			</td>
            <td>          
                <div class="div-basic">
                   <ul>
                      <li><label for="ch_link_market_name7"><b>추천쇼핑몰7</b></label></li>
                      
                      <li>
                         <input type="file" name="market_logo7" id="market_logo7">
                         <?php
                           $market_logo7 = G5_DATA_PATH."/common/market_logo7";
                           if (file_exists($market_logo7))
                           {
                              $size = getimagesize($market_logo7);
                         ?>
                         <div style="width:165px;height:55px;border:solid 1px #ccc;background:#fafafa;text-align:center;margin-top:10px;margin-bottom:5px;">
                            <img src="<?php echo G5_DATA_URL; ?>/common/market_logo7" alt="">
                         </div>
                         <input type="checkbox" name="market_logo_del7" value="1" id="market_logo_del7">
                         <label for="market_logo_del7"><span class="sound_only">추천쇼핑몰7</span> 삭제</label> 
                         <?php } ?>
                      </li>
                      <li><input type="text" name="ch_link_market_name7" value="<?php echo $default['ch_link_market_name7']; ?>" id="ch_link_market_name7" class="frm_input white bg-green" size="20"></li>
                      <li class="blue font-11">추천쇼핑몰명 반드시 기재</li>
                   </ul>
                </div>          
			</td>
            <td>          
                <div class="div-basic">
                   <ul>
                      <li><label for="ch_link_market_name8"><b>추천쇼핑몰8</b></label></li>
                      
                      <li>
                         <input type="file" name="market_logo8" id="market_logo8">
                         <?php
                           $market_logo8 = G5_DATA_PATH."/common/market_logo8";
                           if (file_exists($market_logo8))
                           {
                              $size = getimagesize($market_logo8);
                         ?>
                         <div style="width:165px;height:55px;border:solid 1px #ccc;background:#fafafa;text-align:center;margin-top:10px;margin-bottom:5px;">
                            <img src="<?php echo G5_DATA_URL; ?>/common/market_logo8" alt="">
                         </div>
                         <input type="checkbox" name="market_logo_del8" value="1" id="market_logo_del8">
                         <label for="market_logo_del8"><span class="sound_only">추천쇼핑몰8</span> 삭제</label> 
                         <?php } ?>
                      </li>
                      <li><input type="text" name="ch_link_market_name8" value="<?php echo $default['ch_link_market_name8']; ?>" id="ch_link_market_name8" class="frm_input white bg-green" size="20"></li>
                      <li class="blue font-11">추천쇼핑몰명 반드시 기재</li>
                   </ul>
                </div>          
			</td>
            </tr>
            <tr valign="top">
            <td>          
                <div class="div-basic">
                   <ul>
                      <li><label for="ch_link_market_name9"><b>추천쇼핑몰9</b></label></li>
                      
                      <li>
                         <input type="file" name="market_logo9" id="market_logo9">
                         <?php
                           $market_logo9 = G5_DATA_PATH."/common/market_logo9";
                           if (file_exists($market_logo9))
                           {
                              $size = getimagesize($market_logo9);
                         ?>
                         <div style="width:165px;height:55px;border:solid 1px #ccc;background:#fafafa;text-align:center;margin-top:10px;margin-bottom:5px;">
                            <img src="<?php echo G5_DATA_URL; ?>/common/market_logo9" alt="">
                         </div>
                         <input type="checkbox" name="market_logo_del9" value="1" id="market_logo_del9">
                         <label for="market_logo_del9"><span class="sound_only">추천쇼핑몰9</span> 삭제</label> 
                         <?php } ?>
                      </li>
                      <li><input type="text" name="ch_link_market_name9" value="<?php echo $default['ch_link_market_name9']; ?>" id="ch_link_market_name9" class="frm_input white bg-green" size="20"></li>
                      <li class="blue font-11">추천쇼핑몰명 반드시 기재</li>
                   </ul>
                </div>          
			</td>
            <td>          
                <div class="div-basic">
                   <ul>
                      <li><label for="ch_link_market_name10"><b>추천쇼핑몰10</b></label></li>
                      
                      <li>
                         <input type="file" name="market_logo10" id="market_logo10">
                         <?php
                           $market_logo10 = G5_DATA_PATH."/common/market_logo10";
                           if (file_exists($market_logo10))
                           {
                              $size = getimagesize($market_logo10);
                         ?>
                         <div style="width:165px;height:55px;border:solid 1px #ccc;background:#fafafa;text-align:center;margin-top:10px;margin-bottom:5px;">
                            <img src="<?php echo G5_DATA_URL; ?>/common/market_logo10" alt="">
                         </div>
                         <input type="checkbox" name="market_logo_del10" value="1" id="market_logo_del10">
                         <label for="market_logo_del10"><span class="sound_only">추천쇼핑몰10</span> 삭제</label> 
                         <?php } ?>
                      </li>
                      <li><input type="text" name="ch_link_market_name10" value="<?php echo $default['ch_link_market_name10']; ?>" id="ch_link_market_name10" class="frm_input white bg-green" size="20"></li>
                      <li class="blue font-11">추천쇼핑몰명 반드시 기재</li>
                   </ul>
                </div>          
			</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>       
        </tr>
        </tbody>
        </table>
    </div>
    <!-- 가로형끝 // -->

</section>

<?php echo $frm_submit; ?>
<!-- } -->

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">   
    <div class="bq_basic_icon">
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
    <?php echo get_editor_js('de_baesong_content'); ?>
    <?php echo get_editor_js('de_change_content'); ?>
    <?php echo get_editor_js('de_guest_privacy'); ?>

    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
