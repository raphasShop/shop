<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/tail.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/tail.php');
    return;
}
?>

 </div>
    <!-- } 콘텐츠 끝 -->

<!-- 하단 시작 { -->
</div>

<div id="main_ft"> 
    <div class="footer_banner">
        <div class="footer_banner_wrap">
            <img src="<?php echo G5_IMG_URL ?>/slogan.png" class="pc_footer_banner_logo">
        </div>
    </div>
    <div class="footer_info">
        <div class="footer_info_wrap">
            <div class="footer_contact_wrap">
                <div class="footer_contact_title">CUSTOMER CENTER</div>
                <a href="tel:07044839732"><div class="footer_contact_phone">070-4483-9732</div></a>
                <div class="footer_contact_time">평일 10:00 ~ 18:00, 점심시간 12:00 ~ 13:00</div>
                <a href="mailto:food@raphas.com"><div class="footer_contact_mail">food@raphas.com</div></a>
            </div>
            <div class="footer_info_area_wrap">
                <div class="footer_info_link"><a href="<?php echo G5_BBS_URL ?>/content.php?co_id=provision">이용약관</a><span>|</span><a href="<?php echo G5_BBS_URL ?>/content.php?co_id=privacy">개인정보처리방침</a><span>|</span><a href="https://www.ftc.go.kr/bizCommPop.do?wrkr_no=1058690704&apv_perm_no=" target="_blank">사업자 정보확인</a></div>
                <div class="footer_info_address">(주)라파스 &nbsp;&nbsp;|&nbsp;&nbsp; 서울시 강서구 마곡중앙8로1길62 (마곡동,라파스) &nbsp;&nbsp;|&nbsp;&nbsp; 대표자:정도현
                <div class="footer_info_company">사업자등록번호:105-86-90704<br>통신판매업신고번호:제2018-서울 강서-0354호</div>
            </div>
            <div class="footer_sns_wrap">
                <a href="https://www.youtube.com/channel/UCCjJP_4jPLGbhQyzif5bvbg" target="_blank"><img src="<?php echo G5_IMG_URL ?>/sns_youtube.png" class="footer_sns_icon"></a><a href="https://www.instagram.com/fitkong_official/" target="_blank"><img src="<?php echo G5_IMG_URL ?>/sns_insta.png" class="footer_sns_icon"></a><a href="https://blog.naver.com/tiger_nut" target="_blank"><img src="<?php echo G5_IMG_URL ?>/sns_blog.png" class="footer_sns_icon"></a><a href="https://www.facebook.com/fitkong2016" target="_blank"><img src="<?php echo G5_IMG_URL ?>/sns_facebook.png" class="footer_sns_icon"></a>
            </div>
        </div>
    </div>
    
</div>
<a href="javascript:void plusFriendChat()">
<div class="kakao_contact"><img src="<?php echo G5_IMG_URL ?>/kakao_contact.png"></div>
</a>
<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<?php
}

if ($config['cf_analytics']) {
    //echo $config['cf_analytics'];
}
?>


<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_PATH."/tail.sub.php");
?>