<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$admin = get_admin("super");

// 사용자 화면 우측과 하단을 담당하는 페이지입니다.
// 우측, 하단 화면을 꾸미려면 이 파일을 수정합니다.

?>

<?php if (!defined("_INDEX_")) {  //인덱스에서 사용하지 않음?>
    </div><!-- // #container 닫음 -->
<?php }  //인덱스에서 사용하지 않음?>

    <aside id="sideBar">
        <h2 class="sound_only">사이트 전체메뉴</h2>

        <?php if($member['mb_id']) { ?>
        <ul id="snbBLoginAfter">
            <li class="snb ">
                <h3>
                    <a href="<?php echo G5_SHOP_URL ?>/mypage.php"><i class="userIcon xi-user"></i><span class="baseSpace"> <?php echo $member['mb_nick']; ?>님<span></a>
                </h3>
            </li>
            <li class="snb pointBox">
                <a href="<?php echo G5_BBS_URL ?>/point.php"><div class="point">적립금 <span><?php echo $member['mb_point']; ?></span></div></a><a href="<?php echo G5_SHOP_URL ?>/coupon.php"><div class="coupon">쿠폰 <span><?php get_coupon_count($member['mb_id']); ?></span></div></a>
            </li>
        </ul>

        <?php } else { ?>
        <ul id="snbBLogin">
            <li class="snb">
                <h3>
                    <a href="<?php echo G5_BBS_URL ?>/login.php"><i class="userIcon xi-user"></i><span class="baseSpace"> 로그인 하세요.<span></a>
                </h3>
            </li>
        </ul>
        <? } ?>

        <!-- SNB // -->
        <ul id="snb">
            <li class="snb">
                <h2>
                    <a href="/shop"><b>Product</b></a>
                </h2>
            </li>
            <li class="snb snb_sm_top">
                <h3>
                    <a href="<?php echo G5_SHOP_URL ?>/typesearch.php?qtype=type&q=needle"><b>유형별</b></a>
                </h3>
            </li>
            <li class="snb snb_sm">
                <h3>
                    <a href="<?php echo G5_SHOP_URL ?>/typesearch.php?qtype=type&q=needle">마이크로니들</a>
                </h3>
            </li>
            <li class="snb snb_sm">
                <h3>
                    <a href="<?php echo G5_SHOP_URL ?>/typesearch.php?qtype=type&q=skincare">스킨케어</a>
                </h3>
            </li>
            <li class="snb snb_sm_title">
                <h3>
                    <a href="<?php echo G5_SHOP_URL ?>/typesearch.php?qtype=purpose&q=trouble"><b>목적별</b></a>
                </h3>
            </li>
            <li class="snb snb_sm">
                <h3>
                    <a href="<?php echo G5_SHOP_URL ?>/typesearch.php?qtype=purpose&q=trouble">트러블/진정</a>
                </h3>
            </li>
            <li class="snb snb_sm">
                <h3>
                    <a href="<?php echo G5_SHOP_URL ?>/typesearch.php?qtype=purpose&q=whitening">색소침착/미백</a>
                </h3>
            </li>
            <li class="snb snb_sm">
                <h3>
                    <a href="<?php echo G5_SHOP_URL ?>/typesearch.php?qtype=purpose&q=antiaging">안티에이징</a>
                </h3>
            </li>
            <li class="snb">
                <h2>
                    <a href="<?php echo G5_SHOP_URL ?>/eventlist.php"><b>Event</b></a>
                </h2>
            </li>
            <li class="snb">
                <h2>
                    <a href="<?php echo G5_SHOP_URL ?>/brandstory.php"><b>Brand</b></a>
                </h2>
            </li>
            <li class="snb">
                <h2>
                    <a href="<?php echo G5_SHOP_URL ?>/community.php"><b>Community</b></a>
                </h2>
            </li>
        </ul>
        <!-- // SNB -->

        <ul id="snbCS">
            <li class="snb">
                <h2>
                    <a href="<?php echo G5_SHOP_URL ?>/orderlist.php?ps=ps0">주문배송조회</a>
                </h2>
            </li>
            <li class="snb">
                <h2>
                    <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=notice">고객센터</a>
                </h2>
            </li>
        </ul>

        <ul id="snbRview">
            <li class="snb">
                <h2>최근 본 상품</h2>
            </li>
        </ul>
        <div class="snbRview">
            <?php include(G5_MSHOP_SKIN_PATH.'/boxtodayview.skin.php'); // 오늘 본 상품 ?>
        </div>

        <div id="snbBottom">
            <div class="snbBTnotice">CHANGE LANGUAGE</div>
            <div class="snbBTlang"><a href="http://en.acropass.com">ENG</a> &middot; <a href="http://cn.acropass.com">中文</a> &middot; <a href="http://jp.acropass.com">日本語</a></div>
        </div>

        <!-- 서브메뉴바 하단 정보// --
        <dl class="snbCS">
            <dt>CS CENTER</dt>
            <dd>
                <strong><i class="fa fa-phone-square"></i> <?php if($admin['mb_tel']){ echo '<span> Tel. '.$admin['mb_tel'].'</span>';} else echo '<span>관리자 전화번호</span>';?> </strong>
                <b><?php if($admin['mb_email']){ echo  '<span> E-mail. '; ?><a href='mailto:<?php echo $admin['mb_email']?>'><?php echo $admin['mb_email']?></a></span><?php } else echo '<span>관리자이메일</span>';?> </b>
                <b><?php if($admin['mb_1']){ echo  '<span> Fax. '; ?><?php echo $admin['mb_1']?></span><?php } else echo '<span>관리자정보여분필드1</span>';?> </b>
                
                <br>
                <?php if($admin['mb_2']){ echo  '<span>'; ?><?php echo $admin['mb_2']?></span><?php } else echo '<span>관리자정보여분필드2</span>';?>
            </dd>
        </dl>
        -->
        <div id="snbMvAr">
            <a id="snbClose"><i class="xi-close"></i><i class="sound_only">사이드메뉴 닫기</i></a>
            <a id="btnCart" href="<?php echo G5_SHOP_URL ?>/cart.php"><i class="xi-cart"></i><i class="sound_only">사이드메뉴 닫기</i></a>

            <div class="snbMvArBtn" style="display:none;">
                <?php if ($is_member) {  ?>
                <a href="<?php echo G5_BBS_URL ?>/logout.php">LOGOUT</a>
                <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">정보수정</a>
                <?php } else {  ?>
                <a href="<?php echo G5_BBS_URL ?>/login.php"><b>LOGIN</b></a>
                <a href="<?php echo G5_BBS_URL ?>/register.php">JOIN</a>
                <?php }  ?>
            </div>
        </div>
       
    </aside>

    <aside class="clb"></aside>

    
    
    

</div><!-- // #ctWrap 닫음 -->
<!-- } 콘텐츠 끝 -->
<div id="myNav" class="overlay">
  <div class="title">검 색<a class="closebutton" onclick="closeNav()">&times;</a></div>
  
  <div class="overlay-search">
    <form name="frmdetailsearch" action="<?php echo G5_SHOP_URL ?>/search.php" id="frmsearch">
    <input type="hidden" name="qsort" id="qsort" value="<?php echo $qsort ?>">
    <input type="hidden" name="qorder" id="qorder" value="<?php echo $qorder ?>">
    <input type="hidden" name="qcaid" id="qcaid" value="<?php echo $qcaid ?>">
    <input class="search-input" name="q" id="searchText" placeholder="어떤 상품을 찾으세요?"><div class="search-submit"><i class="xi-search" onclick="shopSearch()"></i></div>
    </form>
  </div>
  <div class="overlay-best-keyword">
    <div class="best-keyword-title">추천검색어</div>
    <?php
        $sql = " select * from {$g5['search_tag_table']}";
        $tag = sql_fetch($sql);
    ?>
    <?php 
        for ($i=1; $i<=10; $i++) { 
            if($tag["search_tag_".$i]) {
            echo "<span class=\"best-keyword\" onclick=\"shopSearchBest('".$tag["search_tag_".$i]."')\">".$tag["search_tag_".$i]."</span>";
            }
        } 
    ?>
  </div>
    
  
</div>
<hr>

<div class="kakao-friend">
<a href="javascript:void addPlusFriend()">
  <img src="<?php echo G5_IMG_URL ?>/kakao/kakao_friend.png" alt="" style="width:50px;height:50px;"/>
</a>
</div>
<div class="kakao-chat">
<a href="javascript:void plusFriendChat()">
  <img src="<?php echo G5_IMG_URL ?>/kakao/kakao_chat.png" alt="" style="width:50px;height:50px;"/>
</a>
</div>
<a href="<?php echo G5_SHOP_URL ?>/csr_beauty.php">
<div class="csr_banner_wrap">
    <div class="csr_banner"><span>SAVE THE CHILDREN CAMPAIGN</span><br>GIVING VACCINE</div>
</div>
</a>
<!-- 하단 시작 { -->
<footer id="footer">

    <div class="footer-main"><a href="<?php echo G5_BBS_URL ?>/faq.php">FAQ</a></div>
    <div class="footer-main"><a href="<?php echo G5_BBS_URL ?>/qalist.php">1:1문의</a></div>
    <div class="footer-main"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=notice">고객센터</a></div>
    <div class="footer-main">고객 상담번호&nbsp;&nbsp; 070-7712-2015</div>
    <div class="footer-sub-grey">평일 10:00~18:00, 점심시간 12:00~13:00</div>

    <div class="footer-sep-line"></div>
    <div class="footer-sub-white"><a href="http://www.ftc.go.kr/bizCommPop.do?wrkr_no=1058690704&apv_perm_no=" target="_blank">사업자정보확인</a> &middot;  <a href="<?php echo G5_BBS_URL ?>/content.php?co_id=provision">이용약관</a> &middot;  <a href="<?php echo G5_BBS_URL ?>/content.php?co_id=privacy">개인정보처리방침</a></div>
    <div class="footer-sub-grey">통신판매업신고번호&nbsp;&nbsp; 2018-서울강서-0354호</div>
    <div class="footer-sub-grey">Copyright&copy; 2019 Raphas Co.Ltd All Right reserverd</div>

   
</footer>

<!--
<button type="button" id="top_btn" class="fa fa-arrow-up" aria-hidden="true"><span class="sound_only">페이지 상단으로 이동</span></button>
-->

<?php if (!defined("_INDEX_")) {  /*인덱스에서 사용하지 않음*/ ?>
<!-- 현재위치 및 서브메뉴 활성화 설정// -->
<?php /* 주의사항 아래 코드를 수정하시면 페이지 현재위치 및 서브메뉴,모바일메뉴가 정상작동되지 않을 수 있습니다. */ ?>
<script>
<?php if ($co_id){ ?>$(function(){$('.snb.co_id<?php echo $co_id;?>, .snb .snb2d_co_id<?php echo $co_id;?>').addClass('active');});/*  컨텐츠관리 : co_id<?php echo $co_id;?>  */<?php } else { if ($bo_table){ ?>$(function(){$('.snb.bo_table<?php echo $bo_table;?>, .snb .snb2d_bo_table<?php echo $bo_table;?>').addClass('active');});/*  보테이블 : bo_table<?php echo $bo_table;?>  */<?php } else { ?>$(function(){$('.snb.gr_id<?php echo $gr_id;?>, .snb .snb2d_gr_id<?php echo $gr_id;?>').addClass('active');});/*  그룹아이디 : gr_id<?php echo $gr_id;?>  */<?php } } ?>

<?php if ($co_id || $bo_table || $gr_id){ ?>$(document).ready(function(){ if ( $("#snb > li").is(".snb.active") ) { $('.loc1D').text( $('<?php if ($co_id){ ?>#snb .co_id<?php echo $co_id;?> h2 a b<?php } else { if ($bo_table){ ?>#snb .bo_table<?php echo $bo_table;?> h2 a b<?php } else if ($gr_id) { ?>#snb .gr_id<?php echo $gr_id;?> h2 a b<?php } } ?>').text());$('.loc2D').html( $('<?php if ($co_id){ ?>.snb2d_co_id<?php echo $co_id;?> a b<?php } else { if ($bo_table){ ?>.snb2d_bo_table<?php echo $bo_table;?> a b<?php } else { ?>.snb2d_gr_id<?php echo $gr_id;?> a b<?php } } ?>').html());$('.faArr').html('<i class="fa fa-angle-right"></i>');var index = $("#snb > li").index("#snb > li.active");$('.bNBar').html( $('<?php if ($co_id){ ?>.snb.co_id<?php echo $co_id;?><?php } else { if ($bo_table){ ?>.snb.bo_table<?php echo $bo_table;?><?php } else { ?>.snb.gr_id<?php echo $gr_id;?><?php } } ?>').html());$('.bNBarMw').html( $('#snb').html());<?php if ($menuNum){ ?>$( "#page_title" ).addClass("subTopBg_0<?php echo $menuNum ?>");<?php } else { ?>$( "#page_title" ).addClass("subTopBg_0"+($("<?php if ($co_id){ ?>#snb > li.co_id<?php echo $co_id ?><?php } else { if ($bo_table){ ?>#snb > li.bo_table<?php echo $bo_table ?><?php } else { ?>#snb > li.gr_id<?php echo $gr_id ?><?php } } ?>").index() + 1) );<?php } ?> } else { $('.loc1D').text('<?php echo get_head_title($g5[title]); ?>'); $('.noInfoPageTit').html('<h2><a><b><?php echo get_head_title($g5[title]); ?></b><sub><?php echo $_SERVER["HTTP_HOST"]; ?></sub></a></h2>'); $('.noInfoPageTit').addClass('active');$('#page_title').addClass('subTopBg_00'); } });  <?php } else { ?> $(document).ready(function(){ $('.loc1D').text('<?php echo get_head_title($g5[title]); ?>'); $('.noInfoPageTit').html('<h2><a><b><?php echo get_head_title($g5[title]); ?></b><sub><?php echo $_SERVER["HTTP_HOST"]; ?></sub></a></h2>'); $('.noInfoPageTit').addClass('active');$('#page_title').addClass('subTopBg_00'); });<?php } ?>
</script>
<!-- //현재위치 및 서브메뉴 활성화 설정 -->
<?php } ?>
<script>$(function() { /* 모바일용 메뉴바 */ var articleMgnb = $("#snb li.snb"); articleMgnb.addClass("hide"); $("#snb li.active").removeClass("hide").addClass("show"); $("#snb li.active .snb2dul").show(); $(".snb2dDown").click(function(){ var myArticle = $(this).parents("#snb li.snb"); if(myArticle.hasClass("hide")){ articleMgnb.addClass("hide").removeClass("show"); articleMgnb.find(".snb2dul").slideUp("fast"); myArticle.removeClass("hide").addClass("show"); myArticle.find(".snb2dul").slideDown("fast"); } else { myArticle.removeClass("show").addClass("hide");myArticle.find(".snb2dul").slideUp("fast"); } }); });</script>




<script>
function openNav() {
  document.getElementById("myNav").style.height = "100%";
}

function closeNav() {
  document.getElementById("myNav").style.height = "0%";
}

function shopSearch() {
    var search = document.getElementById("searchText").value;
    var url = "<?php echo G5_SHOP_URL; ?>" + "/search.php?q=" + search
    window.location.href=url;
}

function shopSearchBest(text) {
    var url = "<?php echo G5_SHOP_URL; ?>" + "/search.php?q=" + text
    window.location.href=url;
}
</script>

<script>
jQuery(function($) {

    $( document ).ready( function() {

        // 폰트 리사이즈 쿠키있으면 실행
        font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
        
        //상단고정
        if( $(".top").length ){
            var jbOffset = $(".top").offset();
            $( window ).scroll( function() {
                if ( $( document ).scrollTop() > jbOffset.top ) {
                    $( '.top' ).addClass( 'fixed' );
                }
                else {
                    $( '.top' ).removeClass( 'fixed' );
                }
            });
        }

        //상단으로
        $("#top_btn").on("click", function() {
            $("html, body").animate({scrollTop:0}, '500');
            return false;
        });

    });
});

//상단고정
$(window).scroll(function(){
  var sticky = $('.top'),
      scroll = $(window).scrollTop();

  if (scroll >= 50) sticky.addClass('fixed');
  else sticky.removeClass('fixed');
});

//상단으로
$(function() {
    $("#top_btn").on("click", function() {
        $("html, body").animate({scrollTop:0}, '500');
        return false;
    });
});
</script>
<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>

<?php
include_once(G5_THEME_PATH.'/tail.sub.php');
?>
