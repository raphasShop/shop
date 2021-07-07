<?php
$sub_menu = '100103'; // SEO 검색엔진최적화 2018-01-31
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '검색엔진최적화(SEO)설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');
/*
$pg_anchor = '<ul class="anchor">
<li><a href="#anc_ch_basic">기본설정</a></li>
<li><a href="#anc_ch_market">추천쇼핑몰관리</a></li>
</ul>';
*/
$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';
?>

<form name="fconfigform" action="./config_seoupdate.php" onsubmit="return fconfigform_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="" id="token">

<!-- 아이스크림 SEO 최적화 사용설정 { -->
<section id="anc_cf_seouse">
    <?php echo $pg_anchor ?>
    
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
    <h2 class="h2_frm">SEO 최적화 사용설정 : 아이스크림 전용 테마</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>아이스크림 SEO 최적화 사용설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <!--기본 SEO 최적화 사용설정-->
        <tr>
            <th scope="row"><label for="cf_meta_use_basic"><span class="blue font-14">기본 SEO</span></label></th>
            <td>
                <?php echo help('관리자모드에서 등록한 기본 메타태그사용. 설정을 변경할 수 없습니다'); ?>
                <label class="switch-check">
                <input type="checkbox" name="cf_meta_use_basic" value="1" id="cf_meta_use_basic" disabled="disabled" <?php echo $config['cf_meta_use_basic']?'checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
            </td>
        </tr>
        <!--//-->
        
        <!--선택 SEO 최적화 사용설정-->
        <tr>
            <th scope="row"><label for="cf_meta_use_board"><span class="orangered font-14">게시판/내용/상품</span><br><span class="font-normal">SEO 최적화 사용설정</span></label></th>
            <td>
                <!--(1)게시판 SEO 최적화 사용설정-->
                <div style="display:inline-block">
                게시판
                <label class="switch-check-mini">
                <input type="checkbox" name="cf_meta_use_board" value="1" id="cf_meta_use_board" <?php echo $config['cf_meta_use_board']?'checked':''; ?>> 사용
                <div class="check-slider-mini round"></div>
                </label>
                </div>
                
                <!--(2)내용관리 SEO 최적화 사용설정-->
                <div style="display:inline-block">
                내용관리
                <label class="switch-check-mini">
                <input type="checkbox" name="cf_meta_use_content" value="1" id="cf_meta_use_content" <?php echo $config['cf_meta_use_content']?'checked':''; ?>> 사용
                <div class="check-slider-mini round"></div>
                </label>
                </div>
                
                <!--(3)쇼핑몰상품정보 SEO 최적화 사용설정-->
                <div style="display:inline-block">
                상품정보
                <label class="switch-check-mini">
                <input type="checkbox" name="cf_meta_use_item" value="1" id="cf_meta_use_item" <?php echo $config['cf_meta_use_item']?'checked':''; ?>> 사용
                <div class="check-slider-mini round"></div>
                </label>
                </div>
                <?php echo help('On으로 켜두시면, 게시물/내용관리/상품정보가 표시됩니다. Off로 두면 아래 관리자모드에서 등록한 사이트설명이 표시됩니다(On:권장)'); ?>
            </td>
        </tr>
        <!--//-->
        </tbody>
        </table>
    </div>
</section>
<!-- // -->

<!-- SEO태그설정 { -->
<section id="anc_cf_seo">
    <?php echo $pg_anchor ?>
    
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
    
    <h2 class="h2_frm">SEO 메타태그 설정 : 아이스크림 전용 테마</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>아이스크림 쇼핑몰테마 SEO 메타태그 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <!--메타태그 작성자-->
        <tr>
            <th scope="row"><label for="cf_meta_author">작성자 (Author)<br><span class="font-normal">: 메타태그</span></label></th>
            <td>
                <?php echo help('페이지/사이트의 제작자 또는 제작사명 기재 (예) 네이버미디어'); ?>
                <input type="text" name="cf_meta_author" value="<?php echo $config['cf_meta_author'] ?>" id="cf_meta_author" required class="frm_input darkgreen w100per">
            </td>
        </tr>
        <!--//-->
        <!--메타태그 설명-->
        <tr>
            <th scope="row"><label for="cf_meta_description">사이트 설명 (Description)<br><span class="font-normal">: 메타태그</span></label></th>
            <td>
                <?php echo help('사이트 소개 설명. 포탈에서 검색시 표시되는 사이트 설명'); ?>
                <input type="text" name="cf_meta_description" value="<?php echo $config['cf_meta_description'] ?>" id="cf_meta_description" required class="frm_input darkgreen w100per">
            </td>
        </tr>
        <!--//-->
        <!--메타태그 키워드-->
        <tr>
            <th scope="row"><label for="cf_meta_keyword">검색키워드 (Keyword)<br><span class="font-normal">: 메타태그</span></label></th>
            <td>
                <?php echo help('검색엔진에서 사이트 검색을 위한 키워드. 10개이내로 등록. 여러개 등록시 구분은 쉼표(,)로 구분합니다'); ?>
                <input type="text" name="cf_meta_keyword" value="<?php echo $config['cf_meta_keyword'] ?>" id="cf_meta_keyword" required class="frm_input darkgreen w100per">
            </td>
        </tr>
        <!--//-->
        </tbody>
        </table>
    </div>
</section>
<!-- // -->

<!-- SEO태그설정 { -->
<section id="anc_cf_seo">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">SEO 추가 메타태그 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>SEO 추가 메타태그 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_add_meta">추가 메타태그</label></th>
            <td>
                <?php echo help('아이스크림 쇼핑몰테마 사용시 : 추가로 사용하실 meta 태그를 입력합니다.'); ?>
                <?php echo help('일반테마사용시 : 작성자/설명/키워드 meta 태그도 여기에 직접 입력해야 합니다.'); ?>
                <textarea name="cf_add_meta" id="cf_add_meta"><?php echo $config['cf_add_meta']; ?></textarea>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>
<!-- // -->

<!-- SEO 기본이미지 등록 관리 { -->
<section id="anc_favicon">
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
    
    <h2 class="h2_frm orangered">SEO 기본이미지 등록 관리 : 아이스크림 전용 테마</h2>
    <div class="local_desc02 local_desc">
        <p>
        Og 권장 사이즈는 가로1200픽셀, 세로630픽셀입니다. 파일형식은 jpg 파일만 등록해 주세요.<br>
        게시글에 이미지가 있다면 이미지가 우선 노출됩니다.<br>
        상품의 경우 상품이미지가 우선 노출됩니다.
        </p>
    </div>
    
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>SEO 기본이미지 등록 관리</caption>
        <colgroup>
            <col>
        </colgroup>
        <tbody>
        <tr>
            <td>
                <?php echo help("이미지사이즈 1200×630픽셀, 파일형식은 jpg 로만 등록"); ?>
                <input type="file" name="seo_img" id="seo_img">
                <?php
                $seo_img = G5_DATA_PATH."/common/seo_img.jpg";
                if (file_exists($seo_img))
                {
                    $size = getimagesize($seo_img);
                ?>
                <input type="checkbox" name="seo_img_del" value="1" id="seo_img_del">
                <label for="seo_img_del"><span class="sound_only">이미지</span> 삭제</label>
                <?php } ?>
            </td>
            
            <?php if(!G5_IS_MOBILE) { ?>
            <td class="w100">
                <?php if (file_exists($seo_img)) { ?><img src="<?php echo G5_DATA_URL; ?>/common/seo_img.jpg" class="logo-max"><?php } ?>
            </td>
			<?php } ?>
            
        </tr>
        </tbody>
        </table>
    </div>
</section>
<!--//-->

<!-- 사이트맵.xml 업로드 (구글) { -->
<section id="anc_cf_sitemap">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">sitemap.xml 사이트맵 업로드</h2>
    <div class="local_desc02 local_desc">
        <p>
            sitemap.xml은 구글이나 네이버 웹마스터도구의 sitemap 을 제출하기위한 데이타자동추출파일입니다.<br>
            FTP로 수동으로 올릴 필요없이, 이곳에서 업로드하면 그누보드/영카트의 루트에 자동으로 업로드됩니다.<br> 
            <strong>[주의사항]</strong> sitemap.xml파일은 업로드와 동시에 검색로봇에 의해 수집될 수 있으므로,샘플로 올린파일은 테스트후 바로 삭제해주세요!<br>
            <strong>[파일작성방법]</strong> sitemap.xml파일 작성방법은 구글이나 네이버등에서 검색을 통해 작성방법을 확인하실 수 있습니다<br>
            ※업로드시 자동으로 sitemap.xml 로 파일명이 자동 변경저장되므로, 파일명은 sitemap이 아니어도 상관없습니다<br><br>
            <b>[sitemap.xml 자동생성하기]</b> 도메인주소를 입력한후 시작하시면 자동으로 생성됩니다<br>
            <a href="https://www.xml-sitemaps.com/index.php?errmsg=wr&amp;initurl=http%3A%2F%2Fkoeraenv.co.kr%2F" target="_blank">https://www.xml-sitemaps.com/index.php?errmsg=wr&amp;initurl=http%3A%2F%2Fkoeraenv.co.kr%2F</a>
      </p>
    </div>
    
    <?php 
	    $sitemap_xml = G5_PATH."/sitemap.xml";
	     if (file_exists($sitemap_xml)) { 
	?>
    <div class="local_desc_alim"><strong>[사용중]</strong> 현재 sitemap.xml 업로드하여 사용중입니다. 삭제/재업로드 할 수 있습니다.</div>
    <?php } ?>
    
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>sitemap.xml 업로드</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row">sitemap.xml 업로드</th>
            <td>
                <?php echo help("sitemap.xml 파일을 직접 올리세요"); ?>
                <input type="file" name="sitemap_xml" id="sitemap_xml">
                <?php
                $sitemap_xml = G5_PATH."/sitemap.xml";
                if (file_exists($sitemap_xml))
                {
                    $size = getimagesize($sitemap_xml);
                ?>
                <input type="checkbox" name="sitemap_xml_del" value="1" id="sitemap_xml_del">
                <label for="sitemap_xml_del"><span class="sound_only">sitemap.xml파일</span> <span class="red">업로드한 sitemap.xml 파일삭제</span></label>
                <?php } ?>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>
<!-- // -->

<!-- robots.txt 업로드 (검색로봇) { -->
<section id="anc_cf_robots">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">robots.txt 검색로봇설정 업로드</h2>
    <div class="local_desc02 local_desc">
        <p>
            robots.txt는 검색로봇의 접근을 막을수도 있고, 원하는 검색엔진만 허용할 수 있습니다<br>
            FTP로 수동으로 올릴 필요없이, 이곳에서 업로드하면 그누보드/영카트의 루트에 자동으로 업로드됩니다.<br> 
            <strong>[주의사항]</strong> robots.txt파일은 업로드와 동시에 검색로봇에 의해 수집될 수 있으므로,샘플로 올린파일은 테스트후 바로 삭제해주세요!<br>
            <strong>[파일작성방법]</strong> robots.txt파일 작성방법은 구글이나 네이버등에서 검색을 통해 작성방법을 확인하실 수 있습니다<br>
            ※업로드시 자동으로 robots.txt 로 파일명이 자동 변경저장되므로, 파일명은 robots가 아니어도 상관없습니다<br>
            <b>[robots.txt 작성예제]</b> 안내에 따라 검색엔진에 노출할 영역을 지정할 수 있습니다<br>
            <a href="http://help.naver.com/customer/etc/webDocument02.nhn" target="_blank">http://help.naver.com/customer/etc/webDocument02.nhn</a>   
        </p>
    </div>
    
    <?php 
	    $robots_txt = G5_PATH."/robots.txt";
	     if (file_exists($robots_txt)) { 
	?>
    <div class="local_desc_alim"><strong>[사용중]</strong> 현재 robots.txt 업로드하여 사용중입니다. 삭제/재업로드 할 수 있습니다.</div>
    <?php } ?>
    
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>robots.txt</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row">robots.txt 업로드</th>
            <td>
                <?php echo help("robots.txt 파일을 직접 올리세요"); ?>
                <input type="file" name="robots_txt" id="robots_txt">
                <?php
                $robots_txt = G5_PATH."/robots.txt";
                if (file_exists($robots_txt))
                {
                    $size = getimagesize($robots_txt);
                ?>
                <input type="checkbox" name="robots_txt_del" value="1" id="robots_txt_del">
                <label for="robots_txt_del"><span class="sound_only">robots.txt파일</span> <span class="red">업로드한 robots.txt 파일삭제</span></label>
                <?php } ?>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>
<!-- // -->

<!-- 방문자분석 스크립트 { -->
<section id="anc_cf_script">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">방문자분석 스크립트</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>방문자분석 스크립트</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_analytics">방문자분석 스크립트</label></th>
            <td>
                <?php echo help('방문자분석 스크립트 코드를 입력합니다. 예) 구글 애널리틱스'); ?>
                <textarea name="cf_analytics" id="cf_analytics"><?php echo $config['cf_analytics']; ?></textarea>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>
<!-- // -->

<?php// echo $frm_submit; //저장버튼?>

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">   
    <div class="bq_basic_icon">
    <a href="<?php echo G5_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/home_icon.png" border="0" title="홈"></a>
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
