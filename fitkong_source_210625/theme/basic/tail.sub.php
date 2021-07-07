<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 관리자 admin.head.sub.php 파일 - 아이스크림
if (defined('G5_IS_ADMIN')) {
    require_once(G5_ADMIN_PATH.'/admin.tail.sub.php');
    return;
}
?>

<?php if ($is_admin == 'super') {  ?><!-- <div style='float:left; text-align:center;'>RUN TIME : <?php echo get_microtime()-$begin_time; ?><br></div> --><?php }  ?>

<!-- ie6,7에서 사이드뷰가 게시판 목록에서 아래 사이드뷰에 가려지는 현상 수정 -->
<!--[if lte IE 7]>
<script>
$(function() {
    var $sv_use = $(".sv_use");
    var count = $sv_use.length;

    $sv_use.each(function() {
        $(this).css("z-index", count);
        $(this).css("position", "relative");
        count = count - 1;
    });
});
</script>
<![endif]-->
<?php
    /**
     * ASK SEO Tail 출력 부분
     */
    include_once G5_PLUGIN_PATH . "/ask-seo/ask-seo-tail.php";
?>

<!-- LOGGER(TM) TRACKING SCRIPT V.40 FOR logger.co.kr / 103802 : COMBINE TYPE / DO NOT ALTER THIS SCRIPTS. -->
<script type="text/javascript">var _TRK_LID = "103802";var _L_TD = "ssl.logger.co.kr";var _TRK_CDMN = ".acropass.com";</script>
<script type="text/javascript">var _CDN_DOMAIN = location.protocol == "https:" ? "https://fs.bizspring.net" : "http://fs.bizspring.net"; 
(function (b, s) { var f = b.getElementsByTagName(s)[0], j = b.createElement(s); j.async = true; j.src = "//fs.bizspring.net/fsn/bstrk.1.js"; f.parentNode.insertBefore(j, f); })(document, "script");
</script>
<noscript><img alt="Logger Script" width="1" height="1" src="http://ssl.logger.co.kr/tracker.1.tsp?u=103802&amp;js=N"/></noscript>
<!-- END OF LOGGER TRACKING SCRIPT -->

<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
<script type="text/javascript">
if(!wcs_add) var wcs_add = {};
wcs_add["wa"] = "1117ec2b8b1822";
wcs_do();
</script>

<!-- 공통 적용 스크립트 , 모든 페이지에 노출되도록 설치. 단 전환페이지 설정값보다 항상 하단에 위치해야함 --> 
<script type="text/javascript">
if(!wcs_add) var wcs_add = {};
wcs_add["wa"] = "s_396f449064f2";
wcs.inflow("acropass.com");
wcs_do();
</script>


</body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다. ?>