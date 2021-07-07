<?php
#################################################################

/* @@@@ 아이스크림 관리자 사용을 위한 필수 공통파일 @@@@ */

#################################################################

/*
최초작성일 : 2018-03-27
최종수정일 : 2018-11-11

버전 : 아이스크림 S9 영카트NEW 관리자
개발 : 아이스크림 아이스크림플레이 icecreamplay.cafe24.com
라이센스 : 유료판매 프로그램으로 유료 라이센스를 가집니다
           - 1카피 1도메인
           - 무단배포불가/무단사용불가
           - 소스의 일부 또는 전체 배포/공유/수정배포 불가
*/

#################################################################

if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

#################################################################

// 끝

#################################################################
?>

<?php if ($is_admin == 'super') {  ?><!-- <div style='float:left; text-align:center;'>RUN TIME : <?php echo get_microtime()-$begin_time; ?><br></div> --><?php }  ?>

<script src="<?php echo G5_ADMIN_URL ?>/js/admin.js?ver=<?php echo G5_JS_VER; ?>"></script>

<!-- JavaScript 부트스트랩 추가 -->
<script type="text/javascript" src="<?php echo G5_ADMIN_URL;?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo G5_ADMIN_URL;?>/js/custom.sub.js"></script>

<!-- JavaScript -->
<script>
var imageUrl = '<?php echo G5_ADMIN_URL;?>/img/color.png';
</script>
<script src="<?php echo G5_ADMIN_URL;?>/js/iColorPicker.js"></script>
<script src="<?php echo G5_ADMIN_URL;?>/js/ui.totop.min.js"></script>


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

</body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다. ?>