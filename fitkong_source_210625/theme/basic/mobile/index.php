<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_MSHOP_PATH.'/index.php');
    return;
}

add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/main.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 5);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/swiper.css">', 0);
add_stylesheet('<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">', 0);



include_once(G5_THEME_MOBILE_PATH.'/head.php');
?>

<?php
// 쿠폰
$cp_count = 0;
$sql = " select cp_id
            from {$g5['g5_shop_coupon_table']}
            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."' ";
$res = sql_query($sql);

for($k=0; $cp=sql_fetch_array($res); $k++) {
    if(!is_used_coupon($member['mb_id'], $cp['cp_id']))
        $cp_count++;
}

?>
<?php if($member['mb_id'] && $cp_count > 0) { ?>
<a href="<?php echo G5_SHOP_URL ?>/coupon.php"><div id="float_mohd_banner">사용가능한 쿠폰이 <strong><?php echo $cp_count; ?>개</strong> 있습니다</div></a>   
<?php } else if(!$member['mb_id']){ ?>
<a href="<?php echo G5_BBS_URL ?>/register.php"><div id="float_mohd_banner"><img src="<?php echo G5_IMG_URL ?>/acpc_home_top_bn.jpg"></div></a>
<?php } else { ?>

<?php } ?>

<?php if($member['mb_id'] && $cp_count > 0) { ?>
<section class="mainBanner_withhd">
<?php } else if(!$member['mb_id']) { ?>
<section class="mainBanner_withhd">
<?php } else { ?>
<section class="mainBanner">    
<?php } ?>
    <div class="swiper-container banner-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide banner-slide" style="background: #166323;height:auto;">
               <div class="video-container">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/D26pNy6qIIU" showinfo="0" rel="0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> 
                </div>               
            </div>
            <?php echo display_banner('메인', 'mainbanner.10.skin.php', '10'); ?>
            <!-- 고정배너소스 
            <div class="swiper-slide banner-slide">
                 <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1551499616"><img src="<?php echo G5_IMG_URL ?>/acmo_home_banner4.jpg" alt="">
                <div class="mainTitle">#주름고민 싹#선물고민 싹#가격부담 싹<br>가정의 달 세가지 고민 싹!</div>
                <div class="subTitle">라인케어 스페셜에디션<br>초특가 2배 구성</div></a>
            </div>
             <div class="swiper-slide banner-slide">
                <img src="<?php echo G5_IMG_URL ?>/acmo_home_banner10.jpg" alt="">
                <a href="<?php echo G5_SHOP_URL ?>/eventdetail.php?ev_no=1"><div class="banner-full-area"></div></a>
            </div>
            <div class="swiper-slide banner-slide">
                <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1551578034"><img src="<?php echo G5_IMG_URL ?>/acmo_home_banner2.jpg" alt="">
                 <div class="mainTitle">트러블 SOS #동전패치<br>트러블 큐어 </div>
                <div class="subTitle">손 안대고 끝내는<br>트러블 원스탑 토탈케어</div></a>
            </div>
            <div class="swiper-slide banner-slide">
                <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1551498754"><img src="<?php echo G5_IMG_URL ?>/acmo_home_banner3.jpg" alt="">
                <div class="mainTitle">다크서클탈출템 #팬더탈출<br>언더아이케어</div>
                <div class="subTitle">피부 속 탄력부터 튼튼하게 채워<br>중력을 거스르는 피부탄력을 회복하세요</div></a>
            </div>
            
            -->
            
        </div>
        <div class="swiper-scrollbar"></div>
        <!-- Add Arrows -->
       
    </div>
</section>

<section class="bestProduct">
    <div class="swiper-container best-product-container">
        <h3>베스트셀러 TOP 5</h3>
        <div class="swiper-wrapper">
            <?php
                $sql = " select * from {$g5['g5_shop_item_table']} where it_type4 = '1' AND it_use = '1' order by it_1, it_order, it_id desc ";
                $list = new item_list();
                $list->set_query($sql);
                $list->run();
                $result = $list->result;

                for ($i=0; $row=sql_fetch_array($result); $i++) {
            ?>
            <div class="swiper-slide online-product-slide">
            <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=<?php echo $row['it_id'] ?>">
                <?php echo get_it_image($row['it_id'],400, 400, '', '', stripslashes($row['it_name'])) ?>
                <?php if($row['it_10']) { ?>
                <div class="event_badge_msg_mo" style="background: <?php echo $row['it_9'] ?>;color: <?php echo $row['it_8']; ?>"><?php echo $row['it_10'] ?></div>
                <?php } ?>
                <div class="product-title"><?php echo $row['it_name'] ?></div>
                <div class="product-price"><?php if($row['it_cust_price'] != $row['it_price'] ) { ?><span><?php echo number_format($row['it_cust_price']) ?>원</span> <?php } ?> <?php echo number_format($row['it_price']) ?>원</div>
            </a>
            </div>
            <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"><i class="xi-angle-right swiper-button-style"></i></div>
        <div class="swiper-button-prev"><i class="xi-angle-left swiper-button-style"></i></div>
    </div>
    
</section>

<section class="onlineProduct">
    <div class="swiper-container online-product-container">
        <h3>온라인 혜택 제품</h3>
        <div class="swiper-wrapper">
            <?php
                $sql = " select * from {$g5['g5_shop_item_table']} where it_type1 = '1' AND it_use = '1' order by it_2, it_order, it_id asc ";
                $list = new item_list();
                $list->set_query($sql);
                $list->run();
                $result = $list->result;

                for ($i=0; $row=sql_fetch_array($result); $i++) {
            ?>
            <div class="swiper-slide online-product-slide">
            <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=<?php echo $row['it_id'] ?>">
                
                <?php echo get_it_image($row['it_id'],400, 400, '', '', stripslashes($row['it_name'])) ?>
                
                <?php if($row['it_10']) { ?>
                <div class="event_badge_msg_mo" style="background: <?php echo $row['it_9'] ?>;color: <?php echo $row['it_8']; ?>"><?php echo $row['it_10'] ?></div>
                <?php } ?>
                <div class="product-title"><?php echo $row['it_name'] ?></div>
                <div class="product-price"><?php if($row['it_cust_price'] != $row['it_price'] ) { ?><span><?php echo number_format($row['it_cust_price']) ?>원</span><?php } ?> <?php echo number_format($row['it_price']) ?>원</div>
                
            </a>
            </div>
            <?php } ?>
        </div>
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"><i class="xi-angle-right swiper-button-style"></i></div>
        <div class="swiper-button-prev"><i class="xi-angle-left swiper-button-style"></i></div>
    </div>
</section>

<div class="sep-line"></div>

<section class="bestReview">
    <div class="swiper-container best-review-container">
       <h4><span>#홈더마필러</span><span> #Filling&Feeling</span></h4>
        <h3>베스트 리뷰</h3>
        <div class="swiper-wrapper">
            <div class="swiper-slide best-review-slide">
                <a href="https://cookey11.blog.me/221717320683" target="_blank">
                <img src="<?php echo G5_IMG_URL ?>/ac_bestreview_tn_7.jpg" alt="">
                <div class="review-title">올리브영 여드름패치! 트러블큐어 대용량팩 리뷰</div>
                <div class="review-contents">안 그래도 피부가 좋지 않은데 트러블까지 생기니까 거울볼 때 마다 어찌나 신경쓰이던지... 여드름을 빨리 없애기 위해 친구의...</div>
                <div class="review-write">링구 <span>|</span> 2019.11.24 <span>|</span> 네이버블로그</div>
                </a>
            </div>
            <div class="swiper-slide best-review-slide">
                <a href="https://blog.naver.com/yona_73/221540012434" target="_blank">
                <img src="<?php echo G5_IMG_URL ?>/ac_bestreview_tn_8.jpg" alt="">
                <div class="review-title">팔자주름, 라인케어패치로 얼굴주름리프팅하자</div>
                <div class="review-contents">나이가 들어가면서 어쩔 수 없이 생기는 것이 주름이지요. 머..요즘에는 피부과에서도 관리를 받고 피부 관리실을 다니기도 하고요...</div>
                <div class="review-write">요나<span>|</span> 2019.05.17 <span>|</span> 네이버블로그</div>
                </a>
            </div>
            <div class="swiper-slide best-review-slide">
                <a href="https://blog.naver.com/seo670722/221546153618" target="_blank">
                <img src="<?php echo G5_IMG_URL ?>/ac_bestreview_tn_2.jpg" alt="">
                <div class="review-title">언더아이패치 : 다크서클 없애는 법 아크로패스</div>
                <div class="review-contents">요즘 왜이리 피곤한지 잠을 자도 자도 피곤해서 힘드네요ㅠ.ㅠ 기력보충도 필요하지만 눈가가 칙칙한게 몇일은 잠 못잔 사람마냥...</div>
                <div class="review-write">시녀나<span>|</span> 2019.05.25 <span>|</span> 네이버블로그</div>
                </a>
            </div>
            <div class="swiper-slide best-review-slide">
                <a href="https://blog.naver.com/sakdlem1004/221314122299" target="_blank">
                <img src="<?php echo G5_IMG_URL ?>/ac_bestreview_tn_9.jpg" alt="">
                <div class="review-title">벌레물림 걱정끝!!! 아크로패스 수딩큐 하나면...</div>
                <div class="review-contents">오늘은 꼬미를 위한 제품을 만나보았는데여 아래 두 아이도 물론 모기에 민감하지만 요즘 알러지 체질이 되어서 모기에도 확 반응하는...</div>
                <div class="review-write">온뤼마루<span>|</span> 2018.07.07 <span>|</span> 네이버블로그</i></div>
                </a>
            </div>
            <div class="swiper-slide best-review-slide">
                <a href="https://blog.naver.com/hanr7/221499124627" target="_blank">
                <img src="<?php echo G5_IMG_URL ?>/ac_bestreview_tn_1.jpg" alt="">
                <div class="review-title">여드름패치 물건이네~ 아크로패스 트러블큐어</div>
                <div class="review-contents">이게 안개인지 미세먼지인지 분간이 안될정도로 공기질이 안좋은 날들이 반복되고 있어요. 더군다나 저희 도에는 지하철역 공사까지 하고 있어...</div>
                <div class="review-write">보니비<span>|</span> 2017.03.27 <span>|</span> 네이버블로그</div>
                </a>
            </div>
        </div>
        <div class="swiper-pagination" style="display: none"></div>
        
    </div>
</section>

<div class="sep-line"></div>

<section class="bestCommunity">
    <div class="swiper-container best-community-container">
        <h4><span>#트러블큐어</span><span>#홈케어고수</span><span>#시술한줄알아</span></h4>
        <h3>아크로패스로<br>흔적 프리패스</h3>
        <div class="swiper-wrapper">
            
            <div class="swiper-slide best-community-slide"><a href="<?php echo G5_SHOP_URL ?>/communitydetail.php?cm_no=1">
                <img src="<?php echo G5_IMG_URL ?>/community01.jpg" alt="">
                <div class="community-title">상황별 피부 진정 꿀팁!</div>
                <div class="community-writer">#피부건조 #여드름 #홍조</div></a>
            </div>
            <div class="swiper-slide best-review-slide"><a href="<?php echo G5_SHOP_URL ?>/communitydetail.php?cm_no=3">
                <img src="<?php echo G5_IMG_URL ?>/community03.jpg" alt="">
                <div class="community-title">소개팅 응급처치 방법!</div>
                <div class="community-writer">#소개팅 #응급처리 #시술한줄알아</div></a>
            </div>
            
            <div class="swiper-slide best-review-slide"><a href="<?php echo G5_SHOP_URL ?>/communitydetail.php?cm_no=4">
                <img src="<?php echo G5_IMG_URL ?>/community04.jpg" alt="">
                <div class="community-title">면접 프리패스 뷰티템!</div>
                <div class="community-writer">#면접프리패스 #얼굴도 #스펙이다</div></a>
            </div>
            
            <div class="swiper-slide best-review-slide"><a href="<?php echo G5_SHOP_URL ?>/communitydetail.php?cm_no=5">
                <img src="<?php echo G5_IMG_URL ?>/community05.jpg" alt="">
                <div class="community-title">요즘 핫한 뷰티템!</div>
                <div class="community-writer">#명절증후군 #지친피부 #원상회복</div></a>
            </div>
            
        </div>
        <div class="swiper-pagination" style="display: none"></div>
        
    </div>
</section>
<!--
<section class="mainInstagram">
    <?php include_once(G5_PATH.'/Instagram/src/index.php'); ?>

</section>
-->
<?php 
    if($member['mb_id'] == 'acropass') {
        $get_pa_code = get_cookie('ck_pa_code');
        $get_pa_user_code = get_cookie('ck_pa_user_code');
        $get_user_personal_code = get_cookie('user_personal_code');

        echo "pacode : ";
        echo $get_pa_code;
        echo "<br>";
        echo "pausercode : ";
        echo $get_pa_user_code;
        echo "<br>";
        echo "userpersonalcode : ";
        echo $get_user_personal_code;
        
    }
?>

<script src="<?php echo G5_THEME_URL ?>/plugin/bxslider/jquery.bxslider.min.js"></script>
<script src="<?php echo G5_THEME_URL ?>/js/WEBsiting.main.js"></script>
<script src="<?php echo G5_THEME_URL ?>/js/swiper.min.js"></script>
<script>
var swiper = new Swiper('.banner-container', {
  scrollbar: {
    el: '.swiper-scrollbar',
    clickable: true,
  },
 
});

var swiper2 = new Swiper('.best-product-container', {
  pagination: {
    el: '.swiper-pagination',
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});

var swiper3 = new Swiper('.online-product-container', {
  pagination: {
    el: '.swiper-pagination',
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});

var swiper4 = new Swiper('.best-review-container', {
  slidesPerView: 'auto',
  spaceBetween: 15,
  centeredSlides: true,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
});

var swiper5 = new Swiper('.best-community-container', {
  slidesPerView: 'auto',
  spaceBetween: 15,
  centeredSlides: true,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
});
</script>
<?php
include_once(G5_THEME_MOBILE_PATH.'/tail.php');
?>