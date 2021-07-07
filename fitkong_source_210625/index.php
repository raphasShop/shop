<?php
include_once('./_common.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/index.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/index.php');
    return;
}

include_once(G5_PATH.'/head.php');
?>
<link rel="stylesheet" href="<?php echo G5_CSS_URL ?>/swiper_pc.css?ver=<?php echo G5_CSS_VER; ?>">

<section id="pc_main_banner">
    <div class="swiper-container main_banner-container">
        <div class="swiper-wrapper">
            <?php echo display_banner('메인', 'mainbanner.20.skin.php', '10'); ?>
            <div class="swiper-slide banner-slide" style="background: #4C3C2D;">
                <img src="https://fitkong2020.s3.ap-northeast-2.amazonaws.com/img/main_banner_video_back_210531.jpg" style="width:100%;height: 100%;object-fit: cover;">
                <iframe width="1120" height="630" src="https://www.youtube.com/embed/X3QylKR1q98?autoplay=0&amp;playlist=X3QylKR1q98&amp;loop=1&amp;showinfo=0&amp;rel=0" frameborder="0" allow="accelerometer; autoplay; loop; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="z-index: 10000;outline:10px solid #fff;position: absolute;top:calc(50% - 236.25px);left:calc(50% - 420px);width:840px;height:472.5px;"></iframe>

            </div>
        </div>
        <div class="swiper-pagination"></div>     
    </div>
</section>
<section id="pc_best_product">
    <div class="pc_best_product_wrap">
    <div class="pc_title_wrap">
        <img src="<?php echo G5_IMG_URL ?>/best_title_icon.png" class="pc_title_icon">
        <div class="pc_title_text">핏콩언니 <span>추천!</span></div>
        <div class="pc_title_line"></div>

    </div>
    <div class="pc_best_product_item_wrap">
        <?php 
            $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' AND it_type1 = '1' order by it_order, it_id desc LIMIT 3";
            $result = sql_query($sql);
            for($i=0; $row=sql_fetch_array($result); $i++)
            {

            if(!$row['it_img2']){
                $row['it_img2'] = $row['it_img1'];
            }
            $row['it_img1'] = G5_DATA_URL.'/item/'.$row['it_img1'];
            $row['it_img2'] = G5_DATA_URL.'/item/'.$row['it_img2'];

            $sale_ratio = ($row['it_price'] / $row['it_cust_price']) * 100;
            $sale_ratio = 100 - $sale_ratio;
            $sale_ratio = round($sale_ratio);

            $row['it_price'] = display_price($row['it_price']);
            $row['it_cust_price'] = display_price($row['it_cust_price']);
        ?>
        <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=<?php echo $row['it_id']; ?>"><div class="pc_best_product_item"><img src="<?php echo $row['it_img1']; ?>" alt="" class="pc_best_product_item_image" onmouseover="this.src='<?php echo $row['it_img2']; ?>'" onmouseout="this.src='<?php echo $row['it_img1']; ?>'">
            <div class="pc_best_product_item_badge">
                <?php if($row['it_type4'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/best.png"><? }?><?php if($row['it_type3'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/new.png"><? }?><?php if($row['it_type5'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/sale.png"><? }?>
            </div>
            <div class="pc_best_product_item_name"><?php echo $row['it_name']; ?></div>
            <?php if($sale_ratio != 0 && $sale_ratio != 100) { ?>
            <div class="pc_best_product_item_sratio"><?php echo $sale_ratio; ?>% ↓</div>
            <?php } ?>
            <div class="pc_best_product_item_bprice"><?php echo $row['it_cust_price']; ?></div>
            <div class="pc_best_product_item_price"><?php echo $row['it_price']; ?></div>
        </div></a><?php if($i < 2) { ?><div class="pc_best_product_item_blank"></div><?php } } ?>
    </div>
    <div class="pc_scroll_item_banner">
        <div class="pc_scroll_item_banner_con_wrap">
            <img src="<?php echo G5_IMG_URL ?>/scroll_bn.png">
            <div class="pc_scroll_item_banner_con">
               <?php include(G5_SHOP_SKIN_PATH.'/boxtodayview.skin.php'); // 오늘 본 상품 ?>
            </div>
        </div>
    </div>
</section>
<section id="pc_middle_banner">
    <div class="pc_middle_banner_wrap">
        <a href="<?php echo G5_SHOP_URL ?>/brand.php"><img src="<?php echo G5_IMG_URL ?>/mid-banner-01.png" alt="" class="pc_middle_banner_image1"></a>
        <a href="<?php echo G5_SHOP_URL ?>/recipe.php"><img src="<?php echo G5_IMG_URL ?>/mid-banner-02.png" alt="" class="pc_middle_banner_image2"></a>
        <a href="<?php echo G5_SHOP_URL ?>/dainty.php"><img src="<?php echo G5_IMG_URL ?>/mid-banner-03.png" alt="" class="pc_middle_banner_image3"></a>
        <img src="<?php echo G5_IMG_URL ?>/fitkong_girl.png" alt="" class="pc_middle_banner_tiger">
    </div>
</section>

<section id="pc_product">
    <div class="pc_product_wrap">
    <div class="pc_title_wrap">
        <img src="<?php echo G5_IMG_URL ?>/market_title_icon.png" class="pc_title_icon">
        <a href="<?php echo G5_SHOP_URL ?>"><img src="<?php echo G5_IMG_URL ?>/all_button.png" class="pc_title_more_btn"></a>
        <div class="pc_title_text">핏콩 마켓</div>
        <div class="pc_title_line"></div>
    </div>
    <div class="pc_product_item_wrap">
        
        <?php
        $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' order by it_order, it_id desc LIMIT 16";
        $result = sql_query($sql);
        for($i=0; $row=sql_fetch_array($result); $i++)
        {
        
        if(!$row['it_img2']){
            $row['it_img2'] = $row['it_img1'];
        }
        $row['it_img1'] = G5_DATA_URL.'/item/'.$row['it_img1'];
        $row['it_img2'] = G5_DATA_URL.'/item/'.$row['it_img2'];

        $row['it_price'] = display_price($row['it_price']);
        $row['it_cust_price'] = display_price($row['it_cust_price']);
       
        ?><?php if($i%4==0) { ?><div class="pc_product_item_line"><?php } ?><a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=<?php echo $row['it_id']; ?>"><div class="pc_product_item"><img src="<?php echo $row['it_img1']; ?>" alt="" class="pc_product_item_image" onmouseover="this.src='<?php echo $row['it_img2']; ?>'" onmouseout="this.src='<?php echo $row['it_img1']; ?>'"><div class="pc_product_item_badge"><?php if($row['it_type4'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/best.png"><? }?><?php if($row['it_type3'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/new.png"><? }?><?php if($row['it_type5'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/sale.png"><? }?></div>
                <div class="pc_product_item_name"><?php echo $row['it_name']; ?></div>
                <div class="pc_product_item_bprice"><?php echo $row['it_cust_price']; ?></div>
                <div class="pc_product_item_price"><?php echo $row['it_price']; ?></div>
            </div></a><?php if($i%4!=3) { ?><div class="pc_product_item_blank"></div><?php } ?><?php if($i%4==3) { ?></div><?php } } ?>
    
        
    </div>
</section>
<seciton id="pc_best_review">
    <div class="pc_best_review">
        <div class="pc_best_review_wrap">
            <div class="pc_title_wrap">
                <img src="<?php echo G5_IMG_URL ?>/review_title_icon.png" class="pc_title_icon">
                <a href="<?php echo G5_SHOP_URL ?>/review.php"><img src="<?php echo G5_IMG_URL ?>/all_button.png" class="pc_title_more_btn"></a>
                <div class="pc_title_text">핏콩쟁이들의 <span>솔직후기</span></div>
                <div class="pc_title_line"></div>
            </div>
            <div class="pc_best_review_item_wrap">
                <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1603134795"><div class="pc_best_review_item">
                   <img src="<?php echo G5_IMG_URL ?>/main_rv_01_210205.jpg" class="pc_review_item_image">
                   <div class="pc_review_item_sep_line"></div>
                   <div class="pc_review_item_title">[핏콩 큐브] 카카오닙스 60g X 1개입</div>
                   <div class="pc_review_item_star"><img src="<?php echo G5_IMG_URL ?>/main_review_star.png"><img src="<?php echo G5_IMG_URL ?>/main_review_star.png"><img src="<?php echo G5_IMG_URL ?>/main_review_star.png"><img src="<?php echo G5_IMG_URL ?>/main_review_star.png"><img src="<?php echo G5_IMG_URL ?>/main_review_star.png"></div>
                   <div class="pc_review_item_text">짱짱한 식이섬유만큼 이거 먹으면 바로 화장실 고민 직빵이에요! 생각보다 포만감도 좋아서 배고플때 간편하게 먹기 좋아요 ㅎㅎ 요새 요거트볼에 필수로 넣어주고 있슴돠..!</div>
                </div></a><a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1603133995"><div class="pc_review_item_blank"></div><div class="pc_best_review_item">
                   <img src="<?php echo G5_IMG_URL ?>/main_rv_02_210205.jpg" class="pc_review_item_image">
                   <div class="pc_review_item_sep_line"></div>
                   <div class="pc_review_item_title">[핏콩 그래놀라] 치즈 30g X 7개입</div>
                   <div class="pc_review_item_star"><img src="<?php echo G5_IMG_URL ?>/main_review_star.png"><img src="<?php echo G5_IMG_URL ?>/main_review_star.png"><img src="<?php echo G5_IMG_URL ?>/main_review_star.png"><img src="<?php echo G5_IMG_URL ?>/main_review_star.png"><img src="<?php echo G5_IMG_URL ?>/main_review_star.png"></div>
                   <div class="pc_review_item_text">치즈맛 그래놀라라니 궁금해서 구매해봤는데 완전 뽀*맛이에요! 실제 치즈 분말이라고 하던데 인위적인 느끼한 맛이 아닌 적당히 진하고 고소한 맛이에요.어디에든 좋지만 개인적으로는 아이스크림 토핑으로</div>
                </div></a><a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1606812973"><div class="pc_review_item_blank"></div><div class="pc_best_review_item">
                   <img src="<?php echo G5_IMG_URL ?>/main_rv_03_210205.jpg" class="pc_review_item_image">
                   <div class="pc_review_item_sep_line"></div>
                   <div class="pc_review_item_title">[핏콩바] 6종 기프트박스 28g X 6개입</div>
                   <div class="pc_review_item_star"><img src="<?php echo G5_IMG_URL ?>/main_review_star.png"><img src="<?php echo G5_IMG_URL ?>/main_review_star.png"><img src="<?php echo G5_IMG_URL ?>/main_review_star.png"><img src="<?php echo G5_IMG_URL ?>/main_review_star.png"><img src="<?php echo G5_IMG_URL ?>/main_review_star.png"></div>
                   <div class="pc_review_item_text">핏콩바 너무 좋아해서 모든 맛 다 있으면 좋겠다 싶었는데 핏콩팀이 제 마음을 읽어주셨는지,,,,>< 선물하기에도 좋지만 꼬숩달달 바작바작하니 그냥 제가 다 먹습니다 ㅎㅎ</div></div></a>
                </div>
            </div>
        </div>
    </div>
</seciton>

<section id="pc_community">
    <div class="pc_community_wrap">
        <div class="pc_title_wrap">
            <img src="<?php echo G5_IMG_URL ?>/sns_title_icon.png" class="pc_title_icon">
            <div class="pc_title_text">핏콩과 더 친해지세요 ♥</div>
            <div class="pc_title_line"></div>
        </div>
        <div class="pc_community_con_wrap">
            <section id="pc_dabang">
                <div class="pc_dabang_wrap">
                    <div class="pc_dabang_title_wrap">
                        <span class="pc_dabang_title_text"><img src="<?php echo G5_IMG_URL ?>/youtube_icon.png" class="pc_dabang_title_icon"> 핏콩 다방</span>
                        <div class="pc_dabang_title_sub_text"><span>핏콩다방</span>은 건강한 식습관과<br>홈트를 지속적으로 소개하고 있습니다.</div>
                    </div>
                    <div class="pc_dabang_item_wrap">
                        <?php
                        $sql = " select * from {$g5['g5_shop_dabang_table']} where co_device = 'pc' AND co_use = '1' order by co_id desc LIMIT 2 ";
                        $result = sql_query($sql);
                        for($i=0; $row=sql_fetch_array($result); $i++)
                        {
                            if(!$row['co_img_url']) {
                                $row['co_img_url'] = G5_DATA_URL.'/dabang/'.$row['co_id'];
                            }
                        ?>
                        <a href="<?php echo $row['co_url']; ?>" target="_blank"><div class="pc_dabang_item">
                            <img src="<?php echo $row['co_img_url']; ?>" class="pc_dabang_item_image">
                            <div class="pc_dabang_item_category"><?php echo $row['co_category']; ?></div>
                            <div class="pc_dabang_item_title"><?php echo $row['co_title']; ?></div>
                        </div></a><?}?>
                    </div>
                    <div class="pc_dabang_contact">
                        <a href="https://www.youtube.com/channel/UCCjJP_4jPLGbhQyzif5bvbg" target="_blank"><img src="<?php echo G5_IMG_URL ?>/all_button.png"></a>
                    </div>
                </div>
            </section>

            <section id="pc_instagram">
                <div class="pc_instagram_wrap">
                    <div class="pc_instagram_title_wrap">
                        <span class="pc_instagram_title_text"><img src="<?php echo G5_IMG_URL ?>/instagram_icon.png" class="pc_instagram_title_icon"> #핏콩스타그램</span>
                        <div class="pc_instagram_title_sub_text">핏콩언니가 전하는 다이어트 정보, 기분좋은 이벤트까지~<br><span>#핏콩스타그램</span>과 친구가 되어주세요!</div>
                    </div>
                    <div class="pc_instagram_item_wrap">
                        <?php
                        $sql = " select * from {$g5['g5_shop_instagram_table']} where co_use = '1' order by co_id desc LIMIT 9 ";
                        $result = sql_query($sql);
                        for($i=0; $row=sql_fetch_array($result); $i++)
                        {
                        if(!$row['co_img_url']) {
                            $row['co_img_url'] = G5_DATA_URL.'/instagram/'.$row['co_id'];
                        }
                        ?><?php if($i==0 || $i==3 || $i==6) { ?><div class="pc_instagram_item_line"><?php } ?><a href="<?php echo $row['co_url']; ?>" target="_blank"><img src="<?php echo $row['co_img_url']; ?>" alt="" class="pc_instagram_item_image"></a><?php if($i==0 || $i==1 || $i==3 || $i==4 || $i==6 || $i==7) { ?><div class="pc_instagram_item_blank"></div><?php } ?><?php if($i==2 || $i==5 || $i==8) { ?></div><?php } } ?>
                    </div>
                    <div class="pc_instagram_contact">
                        <a href="https://www.instagram.com/fitkong_official/" target="_blank"><img src="<?php echo G5_IMG_URL ?>/all_button.png"></a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js"></script>
<script>

var interleaveOffset = 0.5;

var swiperOptions = {
  loop: true,
  speed: 1000,
  grabCursor: true,
  watchSlidesProgress: true,
  keyboardControl: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev"
  },
  on: {
    progress: function() {
      var swiper = this;
      for (var i = 0; i < swiper.slides.length; i++) {
        var slideProgress = swiper.slides[i].progress;
        var innerOffset = swiper.width * interleaveOffset;
        var innerTranslate = slideProgress * innerOffset;
        swiper.slides[i].querySelector(".slide-inner").style.transform =
          "translate3d(" + innerTranslate + "px, 0, 0)";
      }      
    },
    touchStart: function() {
      var swiper = this;
      for (var i = 0; i < swiper.slides.length; i++) {
        swiper.slides[i].style.transition = "";
      }
    },
    setTransition: function(speed) {
      var swiper = this;
      for (var i = 0; i < swiper.slides.length; i++) {
        swiper.slides[i].style.transition = speed + "ms";
        swiper.slides[i].querySelector(".slide-inner").style.transition =
          speed + "ms";
      }
    }
  }
};

var swiper2 = new Swiper('.main-vcontainer', {
    direction: 'vertical',
    slidesPerView: 1,
    spaceBetween: 0,
    mousewheel: true,
    mousewheelSensitivity: 0,
    mousewheelReleaseOnEdges: true,
    pagination: {
      el: '.swiper-main-pagination',
      clickable: true,
    },
    slidesOffsetAfter: 550,
});

var swiper = new Swiper('.banner-container', {
  scrollbar: {
    el: '.swiper-banner-scrollbar',
    clickable: true,
  },
  
});

swiper.on('slideChange', function () {
  console.log('slide changed');
});
 
var swiper4 = new Swiper('.main_banner-container', {
  slidesPerView: 1,
  spaceBetween: 0,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  autoplay: {
    delay: 3000,
  },
});

</script>

<script>
$(window).scroll(function() {
  
    if($(this).scrollTop() > 844) {
        $(".pc_scroll_item_banner").css('position','fixed');
    }
    else {
        $(".pc_scroll_item_banner").css('position','absolute');
    }
});
</script>

<?php
include_once(G5_PATH.'/tail.php');
?>