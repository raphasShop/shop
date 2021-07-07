<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
    return;
}

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.

$server = ($_SERVER['SERVER_PORT'] != '80' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$base_filename = basename($server); //현재 페이지 파일명


if ($_SERVER['REQUEST_URI'] == '/' || $base_filename == 'index.php') {
    $footer_display = false;
} else {
    $footer_display = true;
}

if(strpos($server,'brand') !== false){
    //파일명에 test가 들어간 경로 접근시
    $footer_display = false;
}


?>

    </div>
    <!-- } 콘텐츠 끝 -->

<!-- 하단 시작 { -->
</div>
<a href="<?php echo G5_SHOP_URL ?>/csr_beauty.php">
<div class="csr_banner_wrap">
   <div class="csr_banner"><span>SAVE THE CHILDREN CAMPAIGN</span><br>GIVING VACCINE</div>
</div>
</a>
<?php if ($footer_display) { ?>
<div id="shop_ft"> 
    <div class="shop_footer_menu">
        <div class="shop_site_use"><a href="<?php echo G5_BBS_URL ?>/content.php?co_id=provision">이용약관</a><span class="footer_text_sep">|</span><a href="<?php echo G5_BBS_URL ?>/content.php?co_id=privacy">개인정보처리방침</a><span class="footer_text_sep">|</span><a href="http://www.ftc.go.kr/bizCommPop.do?wrkr_no=1058690704&apv_perm_no=" target="_blank">사업자정보확인</a></div>
        <div class="shop_footer_customer"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=notice">고객센터</a><span class="footer_text_sep">|</span><a href="<?php echo G5_BBS_URL ?>/faq.php">FAQ</a><span class="footer_text_sep">|</span><a href="http://pf.kakao.com/_CrTxgu" target="_blank">1:1 카카오톡 상담</a><span class="footer_text_sep">|</span><a href="<?php echo G5_BBS_URL ?>/qalist.php">1:1 문의</a><a href="https://www.instagram.com/acropass_official" target=_blank"><i class="xi-instagram"></i></a></div>
    </div>
    <div class="shop_footer_info">
        <img src="<?php echo G5_IMG_URL; ?>/ac-footer-raphas-logo.png">
        <div class="shop_info_detail">
            (주)라파스<span class="footer_info_sep">|</span>서울시 강서구 마곡중앙8로 1길 62 (마곡동, 라파스)<span class="footer_text_sep">|</span>대표자 : 정도현<br><br>사업자등록번호 : 105-86-90704<br>통신판매업신고번호: 제 2018-서울 강서-0354호
        </div>
        <div class="shop_footer_contact">
            <div class="shop_footer_call">고객문의 070-7712-2015</div>
            <div class="shop_contact_info">평일 10:00~18:00, 점심시간 12:00~13:00<br>sales@raphas.com</div>
        </div>
    </div>
</div>
<?php } ?>
<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];


?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>
<!-- } 하단 끝 -->

<?php
include_once(G5_THEME_PATH.'/tail.sub.php');
?>
