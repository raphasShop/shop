<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/tail.php');
    return;
}
?>
    </div>
</div>
<aside id="sideBar">
        <h2 class="sound_only">사이트 전체메뉴</h2>
        <ul id="snbSearch">
            <li class="snb">
                <div id="search_top_wrap">
                <div class="search_input_back"><img src="<?php echo G5_IMG_URL ?>/search_input_back.png" alt=""></div>
                <div class="search_input_wrap">
                    <form name="frmdetailsearch" action="shop/search.php" id="frmsearch">
                    <input type="hidden" name="qsort" id="qsort" value="<?php echo $qsort ?>">
                    <input type="hidden" name="qorder" id="qorder" value="<?php echo $qorder ?>">
                    <input type="hidden" name="qcaid" id="qcaid" value="<?php echo $qcaid ?>">
                    <input class="search-input" name="q" id="searchText" placeholder="찾는 제품을 입력해주세요." <?php if(!$q) echo "autofocus"; ?>><div class="search-submit"><img src="<?php echo G5_IMG_URL ?>/search_input_icon.png" alt="" onclick="document.getElementById('frmsearch').submit();"></div>
                    </form>
                </div>
                </div>
            </li>
        </ul>

        <!-- SNB // -->
        <ul id="snb">
            <li class="snb">
                <h2>
                    <a href="<?php echo G5_SHOP_URL ?>/brand.php"><img src="<?php echo G5_IMG_URL ?>/menu_icon1.png" alt=""><b>핏콩 소개</b></a>
                </h2>
            </li>
            <li class="snb">
                <h2>
                    <a href="<?php echo G5_SHOP_URL ?>"><img src="<?php echo G5_IMG_URL ?>/menu_icon2.png" alt=""><b>핏콩 마켓</b></a>
                </h2>
            </li>
            <li class="snb">
                <h2>
                    <a href="<?php echo G5_SHOP_URL ?>/community.php"><img src="<?php echo G5_IMG_URL ?>/menu_icon3.png" alt=""><b>핏콩 커뮤니티</b></a>
                </h2>
            </li>
            <li class="snb">
                <h2>
                    <a href="<?php echo G5_SHOP_URL ?>/eventlist.php"><img src="<?php echo G5_IMG_URL ?>/menu_icon4.png" alt=""><b>핏콩 이벤트</b></a>
                </h2>
            </li>
            <li class="snb">
                <h2>
                    <a href="<?php echo G5_SHOP_URL ?>/review.php"><img src="<?php echo G5_IMG_URL ?>/menu_icon5.png" alt=""><b>핏콩쟁이 리뷰</b></a>
                </h2>
            </li>
            <li class="snb">
                <h2>
                    <a href="<?php echo G5_BBS_URL ?>/faq.php"><img src="<?php echo G5_IMG_URL ?>/menu_icon6.png" alt=""><b>고객센터</b></a>
                </h2>
            </li>
        </ul>
        <!-- // SNB -->

        <ul id="snbRview">
            <li class="snb">
                <img src="<?php echo G5_IMG_URL ?>/menu_recent_view.png" alt="">
            </li>
        </ul>
        <div class="snbRview">
            <?php include(G5_MSHOP_SKIN_PATH.'/boxtodayview.skin.php'); // 오늘 본 상품 ?>
        </div>

        <div id="snbMvAr">
            <a id="snbClose"><img src="<?php echo G5_IMG_URL ?>/menu_close.png" class="snbCloseImg"><i class="sound_only">사이드메뉴 닫기</i></a>
        </div>
       
 </aside>
<div class="ft_slogan"><img src="<?php echo G5_IMG_URL ?>/mo_slogan.png"></div>
<div id="ft">
    <div class="ft_cs_title">CUSTOMER CENTER</div>
    <div class="ft_cs_phone"><a href="tel:07044839732">070-4483-9732</a></div>
    <div class="ft_cs_contact">평일 10:00 ~ 18:00&nbsp;&nbsp;&nbsp;&nbsp;점심 시간 12:00 ~ 13:00<br><a href="mailto:food@raphas.com">food@raphas.com</a></div>
    <div class="ft_dotted_line">.....................................................................................................................................</div>
    <div class="ft_company_info_wrap">
        <div class="ft_company_info"><a href="<?php echo G5_BBS_URL ?>/content.php?co_id=provision">이용약관</a><span class="ft_company_info_sep">|</span><a href="<?php echo G5_BBS_URL ?>/content.php?co_id=privacy">개인정보처리방침</a><span class="ft_company_info_sep">|</span><a href="https://www.ftc.go.kr/bizCommPop.do?wrkr_no=1058690704&apv_perm_no=" target="_blank">사업자 정보확인</a></div>
    </div>
    <div class="ft_company">(주)라파스&nbsp;&nbsp;&nbsp;&nbsp;대표자 : 정도현<br>서울시 강서구 마곡중앙8로 1길 62(마곡동, 라파스)<br>사업자 등록번호  : 105-86-90704<br>통신판매업신고번호 : 제2018 - 서울 강서 -0354호</div>
    <div class="ft_sns_wrap">
        <a href="https://www.instagram.com/fitkong_official/" target="_blank"><img src="<?php echo G5_IMG_URL ?>/sns_insta.png"></a>
        <a href="https://www.youtube.com/channel/UCCjJP_4jPLGbhQyzif5bvbg" target="_blank"><img src="<?php echo G5_IMG_URL ?>/sns_youtube.png"></a>
        <a href="https://blog.naver.com/tiger_nut" target="_blank"><img src="<?php echo G5_IMG_URL ?>/sns_blog.png"></a>
        <a href="https://www.facebook.com/fitkong2016" target="_blank"><img src="<?php echo G5_IMG_URL ?>/sns_facebook.png"></a>
    </div>
</div>
<a href="javascript:void plusFriendChat()">
<div class="kakao_contact"><img src="<?php echo G5_IMG_URL ?>/kakao_contact.png"></div>
</a>
<?php

if ($config['cf_analytics']) {
    //echo $config['cf_analytics'];
}
?>

<script>
    $(function() { /* 모바일용 메뉴바 */ var articleMgnb = $("#snb li.snb"); articleMgnb.addClass("hide"); $("#snb li.active").removeClass("hide").addClass("show"); $("#snb li.active .snb2dul").show(); $(".snb2dDown").click(function(){ var myArticle = $(this).parents("#snb li.snb"); if(myArticle.hasClass("hide")){ articleMgnb.addClass("hide").removeClass("show"); articleMgnb.find(".snb2dul").slideUp("fast"); myArticle.removeClass("hide").addClass("show"); myArticle.find(".snb2dul").slideDown("fast"); } else { myArticle.removeClass("show").addClass("hide");myArticle.find(".snb2dul").slideUp("fast"); } }); });</script>
<script>
function openNav() {
  document.getElementById("myNav").style.height = "100%";
}

function closeNav() {
  document.getElementById("myNav").style.height = "0%";
}
</script>

<?php
include_once(G5_PATH."/tail.sub.php");
?>