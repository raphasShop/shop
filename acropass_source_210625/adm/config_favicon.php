<?php
$sub_menu = '100104'; // 도메인/파비콘등록관리 2018-01-31
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '도메인/파비콘 등록관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';
?>

<form name="fconfigform" action="./config_seoupdate.php" onsubmit="return fconfigform_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="" id="token">

<!-- SEO태그설정 { -->
<section id="anc_cf_seo">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">SEO 태그 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>SEO 태그 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_add_meta">추가 메타태그</label></th>
            <td>
                <?php echo help('추가로 사용하실 meta 태그를 입력합니다.'); ?>
                <textarea name="cf_add_meta" id="cf_add_meta"><?php echo $config['cf_add_meta']; ?></textarea>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>
<!-- // -->

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
            ※업로드시 자동으로 sitemap.xml 로 파일명이 자동 변경저장되므로, 파일명은 sitemap이 아니어도 상관없습니다
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
            ※업로드시 자동으로 robots.txt 로 파일명이 자동 변경저장되므로, 파일명은 robots가 아니어도 상관없습니다
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

<!-- 네이버신디케이션 { -->
<section id="anc_cf_syndi">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">네이버 신디케이션</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>네이버신디케이션</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_syndi_token">네이버 신디케이션 연동키</label></th>
            <td>
                <?php if (!function_exists('curl_init')) echo help('<b>경고) curl이 지원되지 않아 네이버 신디케이션을 사용할수 없습니다.</b>'); ?>
                <?php echo help('네이버 신디케이션 연동키(token)을 입력하면 네이버 신디케이션을 사용할 수 있습니다.<br>연동키는 <a href="http://webmastertool.naver.com/" target="_blank"><u>네이버 웹마스터도구</u></a> -> 네이버 신디케이션에서 발급할 수 있습니다.') ?>
                <input type="text" name="cf_syndi_token" value="<?php echo $config['cf_syndi_token'] ?>" id="cf_syndi_token" class="frm_input w100per">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_syndi_except">네이버 신디케이션 제외게시판</label></th>
            <td>
                <?php echo help('네이버 신디케이션 수집에서 제외할 게시판 아이디를 | 로 구분하여 입력하십시오. 예) notice|adult<br>참고로 그룹접근사용 게시판, 글읽기 권한 2 이상 게시판, 비밀글은 신디케이션 수집에서 제외됩니다.') ?>
                <input type="text" name="cf_syndi_except" value="<?php echo $config['cf_syndi_except'] ?>" id="cf_syndi_except" class="frm_input w100per">
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
