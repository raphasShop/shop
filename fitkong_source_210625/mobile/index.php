<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/index.php');
    return;
}

include_once(G5_MOBILE_PATH.'/head.php');

add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/swiper.css">', 0);
?>

<section class="mainBanner">    
    <div class="swiper-container banner-container">

        <div class="swiper-wrapper">
            <?php echo display_banner('메인', 'mainbanner.10.skin.php', '10'); ?>
            <div class="swiper-slide banner-slide" style="background-image: url('https://fitkong2020.s3.ap-northeast-2.amazonaws.com/img/main_banner_video_back_210531.jpg');height:100vw;object-fit: cover">
               <div class="video-container">
                <iframe width="1080" height="1080" src="https://www.youtube-nocookie.com/embed/X3QylKR1q98?autoplay=0&amp;playlist=X3QylKR1q98&amp;loop=1&amp;showinfo=0&amp;rel=0" showinfo="0" rel="0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="z-index: 100;"></iframe> 
                </div>               
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<section id="mo_best_product">
    <div class="mo_best_product_wrap">
    <div class="mo_title_wrap">
        <img src="<?php echo G5_IMG_URL ?>/best_title_icon.png" class="mo_title_icon">
        <div class="mo_title_text"><span>핏콩언니 추천!</span></div>
        <div class="mo_title_line"></div>
    </div>
    <div class="mo_best_product_item_wrap">
        <div class="swiper-container best-product-container mo_swiper_slide_end">
            <div class="swiper-wrapper">
                <?php 
                    $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' AND it_type1 = '1' order by it_order, it_id desc LIMIT 10";
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
                <div class="swiper-slide mo_best_product_item">
                    <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=<?php echo $row['it_id']; ?>">
                    <img src="<?php echo $row['it_img1']; ?>" alt="" class="mo_best_product_item_image">
                    <div class="mo_best_product_item_badge"><?php if($row['it_type4'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/best.png"><? }?><?php if($row['it_type3'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/new.png"><? }?><?php if($row['it_type5'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/sale.png"><? }?></div>
                    <div class="mo_best_product_item_name"><?php echo $row['it_name']; ?></div>
                    <div class="mo_best_product_item_bprice"><?php echo $row['it_cust_price']; ?></div>
                    <?php if($sale_ratio != 0 && $sale_ratio != 100) { ?>
                    <div class="mo_best_product_item_sratio"><?php echo $sale_ratio; ?>% ↓</div>
                    <?php } ?>
                    <div class="mo_best_product_item_price"><?php echo $row['it_price']; ?></div>
                    </a>
                </div>
                <?php } ?>       
            </div>
        </div>
    </div>
</section>
<section id="mo_middle_banner">
    <div class="mo_middle_banner_wrap mo_middle_banner_left">
        <a href="<?php echo G5_SHOP_URL ?>/brand.php"><img src="<?php echo G5_IMG_URL ?>/mo_main_bn01.png" alt="" class="mo_middle_banner_image1"></a>
    </div><div class="mo_middle_banner_wrap mo_middle_banner_right">
        <a href="<?php echo G5_SHOP_URL ?>/recipe.php"><img src="<?php echo G5_IMG_URL ?>/mo_main_bn02.png" alt="" class="mo_middle_banner_image2"></a>
        <a href="<?php echo G5_SHOP_URL ?>/dainty.php"><img src="<?php echo G5_IMG_URL ?>/mo_main_bn03.png" alt="" class="mo_middle_banner_image3"></a>
    </div>
</section>

<section id="mo_product">
    <div class="mo_product_wrap" id="mo_product_item_list1">
        <div class="mo_title_wrap">
            <img src="<?php echo G5_IMG_URL ?>/market_title_icon.png" class="mo_title_icon">
            <div class="mo_title_text">핏콩&nbsp; 마켓</div>
            <div class="mo_title_line"></div>
            <div class="mo_title_view_wrap">
                <a href="javascript:list_view1()"><img src="<?php echo G5_IMG_URL ?>/2block_select_icon.png" id="list_view1" class="mo_title_view_icon"></a>
                <a href="javascript:list_view2()"><img src="<?php echo G5_IMG_URL ?>/3block_icon.png"  id="list_view2" class="mo_title_view_icon"></a>
                <a href="javascript:list_view3()"><img src="<?php echo G5_IMG_URL ?>/list_icon.png"  id="list_view3" class="mo_title_view_icon"></a>
            </div>
        </div>
        <div class="mo_product_item2_wrap">
            <?php
            $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' order by it_order, it_id desc LIMIT 8";
            if($ca_id) {
                $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' and ca_id = '$ca_id' order by it_order, it_id desc ";
            }
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
            ?><?php if($i%2==0) { ?><div class="mo_product_item2_line"><?php } ?><a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=<?php echo $row['it_id']; ?>"><div class="mo_product_item2"><img src="<?php echo $row['it_img1']; ?>" alt="" class="mo_product_item2_image"><div class="mo_product_item2_badge"><?php if($row['it_type4'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/best.png"><? }?><?php if($row['it_type3'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/new.png"><? }?><?php if($row['it_type5'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/sale.png"><? }?></div>
                <div class="mo_product_item2_name"><?php echo $row['it_name']; ?></div>
                <div class="mo_product_item2_bprice"><?php echo $row['it_cust_price']; ?></div>
                <div class="mo_product_item_price"><?php echo $row['it_price']; ?></div>
            </div></a><?php if($i%2!=1) { ?><div class="mo_product_item2_blank"></div><?php } ?><?php if($i%2==1) { ?></div><?php } } ?>

            <div class="mo_product_item_more"><a href="<?php echo G5_SHOP_URL ?>"><img src="<?php echo G5_IMG_URL ?>/mo_all_button.png" alt=""></a></div>
        </div>
    </div>

    <div class="mo_product_wrap current_view" id="mo_product_item_list2">
        <div class="mo_title_wrap">
            <img src="<?php echo G5_IMG_URL ?>/market_title_icon.png" class="mo_title_icon">
            <div class="mo_title_text">핏콩&nbsp; 마켓</div>
            <div class="mo_title_line"></div>
            <div class="mo_title_view_wrap">
                <a href="javascript:list_view1()"><img src="<?php echo G5_IMG_URL ?>/2block_icon.png" id="list_view1" class="mo_title_view_icon"></a>
                <a href="javascript:list_view2()"><img src="<?php echo G5_IMG_URL ?>/3block_select_icon.png" id="list_view2" class="mo_title_view_icon"></a>
                <a href="javascript:list_view3()"><img src="<?php echo G5_IMG_URL ?>/list_icon.png" id="list_view3" class="mo_title_view_icon"></a>
            </div>
        </div>
        <div class="mo_product_item_wrap">
            <?php
            $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' order by it_order, it_id desc LIMIT 9";
            if($ca_id) {
                $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' and ca_id = '$ca_id' order by it_order, it_id desc ";
            }
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
            ?><?php if($i%3==0) { ?><div class="mo_product_item_line"><?php } ?><a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=<?php echo $row['it_id']; ?>"><div class="mo_product_item"><img src="<?php echo $row['it_img1']; ?>" alt="" class="mo_product_item_image"><div class="mo_product_item_badge"><?php if($row['it_type4'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/best.png"><? }?><?php if($row['it_type3'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/new.png"><? }?><?php if($row['it_type5'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/sale.png"><? }?></div>
                <div class="mo_product_item_name"><?php echo $row['it_name']; ?></div>
                <div class="mo_product_item_bprice"><?php echo $row['it_cust_price']; ?></div>
                <div class="mo_product_item_price"><?php echo $row['it_price']; ?></div>
            </div></a><?php if($i%3!=2) { ?><div class="mo_product_item_blank"></div><?php } ?><?php if($i%3==2) { ?></div><?php } } ?>

            <div class="mo_product_item_more"><a href="<?php echo G5_SHOP_URL ?>"><img src="<?php echo G5_IMG_URL ?>/mo_all_button.png" alt=""></a></div>
        </div>
    </div>

    <div class="mo_product_wrap" id="mo_product_item_list3">
        <div class="mo_title_wrap">
            <img src="<?php echo G5_IMG_URL ?>/market_title_icon.png" class="mo_title_icon">
            <div class="mo_title_text">핏콩&nbsp; 마켓</div>
            <div class="mo_title_line"></div>
            <div class="mo_title_view_wrap">
                <a href="javascript:list_view1()"><img src="<?php echo G5_IMG_URL ?>/2block_icon.png" id="list_view1" class="mo_title_view_icon"></a>
                <a href="javascript:list_view2()"><img src="<?php echo G5_IMG_URL ?>/3block_icon.png" id="list_view2" class="mo_title_view_icon"></a>
                <a href="javascript:list_view1()"><img src="<?php echo G5_IMG_URL ?>/list_select_icon.png" id="list_view3" class="mo_title_view_icon"></a>
            </div>
        </div>
        <div class="mo_product_item_wrap">
            <div class="mo_product_item_line">
                 <?php
                $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' order by it_order, it_id desc LIMIT 6";
                if($ca_id) {
                    $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' and ca_id = '$ca_id' order by it_order, it_id desc ";
                }
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
                ?><a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=<?php echo $row['it_id']; ?>"><div class="mo_product_item1"><div class="mo_product_item1_image_wrap"><img src="<?php echo $row['it_img1']; ?>" alt="" class="mo_product_item1_image"><div class="mo_product_item1_badge"><?php if($row['it_type4'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/best.png"><? }?><?php if($row['it_type3'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/new.png"><? }?><?php if($row['it_type5'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/sale.png"><? }?></div></div>
                <div class="mo_product_item1_info_wrap">
                <div class="mo_product_item1_star"><img src="<?php echo G5_IMG_URL ?>/5_star.png"></div>
                <div class="mo_product_item1_name"><?php echo $row['it_name']; ?></div>
                <div class="mo_product_item1_bprice"><?php echo $row['it_cust_price']; ?></div>
                <div class="mo_product_item1_price"><?php echo $row['it_price']; ?></div>
                </div></a><?php } ?>

               
            </div>
            <div class="mo_product_item_more"><a href="<?php echo G5_SHOP_URL ?>"><img src="<?php echo G5_IMG_URL ?>/mo_all_button.png" alt=""></a></div>
        </div>      
    </div>
</section>

<section id="mo_best_review">
    <div class="mo_best_review_wrap">
        <div class="mo_title_wrap">
            <img src="<?php echo G5_IMG_URL ?>/review_title_icon.png" class="mo_title_icon">
            <div class="mo_title_text"><span>핏콩쟁이들의 솔직 후기</span></div>
            <div class="mo_title_line"></div>
        </div>
        <div class="mo_best_review_item_wrap">
            <div class="swiper-container best-review-container mo_swiper_slide_end">
                <div class="swiper-wrapper">
                    <div class="swiper-slide mo_review_item">
                        <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1603134795">
                        <img src="<?php echo G5_IMG_URL ?>/main_rv_01_210205.jpg" alt="" class="mo_review_item_image">
                        <div class="mo_review_item_name">[핏콩 큐브] 카카오닙스 60g X 1개입</div>
                        <div class="mo_review_item_star"><img src="<?php echo G5_IMG_URL ?>/5_star.png"></div>
                        <div class="mo_review_item_con ellipsis3">짱짱한 식이섬유만큼 이거 먹으면 바로 화장실 고민 직빵이에요! 생각보다 포만감도 좋아서 배고플때 간편하게 먹기 좋아요 ㅎㅎ</div>
                        </a>
                    </div>
                    <div class="swiper-slide mo_review_item">
                        <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1603133995">
                        <img src="<?php echo G5_IMG_URL ?>/main_rv_02_210205.jpg" alt="" class="mo_review_item_image">
                        <div class="mo_review_item_name">[핏콩 그래놀라] 치즈 30g X 7개입</div>
                        <div class="mo_review_item_star"><img src="<?php echo G5_IMG_URL ?>/5_star.png"></div>
                        <div class="mo_review_item_con ellipsis3">치즈맛 그래놀라라니 궁금해서 구매해봤는데 완전 뽀*맛이에요! 실제 치즈 분말이라고 하던데 인위적인 느끼한 맛이 아닌 적당히 진하고 고소한 맛이에요.</div>
                        </a>
                    </div>
                    <div class="swiper-slide mo_review_item">
                        <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1606812973">
                        <img src="<?php echo G5_IMG_URL ?>/main_rv_03_210205.jpg" alt="" class="mo_review_item_image">
                        <div class="mo_review_item_name">[핏콩바] 6종 기프트박스 28g X 6개입</div>
                        <div class="mo_review_item_star"><img src="<?php echo G5_IMG_URL ?>/5_star.png"></div>
                        <div class="mo_review_item_con ellipsis3">핏콩바 너무 좋아해서 모든 맛 다 있으면 좋겠다 싶었는데 핏콩팀이 제 마음을 읽어주셨는지,,,,><</div>
                        </a>
                    </div>
                    <div class="swiper-slide mo_review_item">
                        <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1603135306">
                        <img src="<?php echo G5_IMG_URL ?>/main_rv_04_210205.jpg" alt="" class="mo_review_item_image">
                        <div class="mo_review_item_name">유기농 타이거넛츠 분말 120g</div>
                        <div class="mo_review_item_star"><img src="<?php echo G5_IMG_URL ?>/5_star.png"></div>
                        <div class="mo_review_item_con ellipsis3">여기저기 넣어서 식이섬유 채워주기 딱이에요! 우유랑 섞어먹기도 좋은데 저는 스무디 주스에 갈아먹을때 1~2스푼씩 넣어줍니다!</div>
                        </a>
                    </div>
                    <div class="swiper-slide mo_review_item">
                        <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=1603133454">
                        <img src="<?php echo G5_IMG_URL ?>/main_rv_05_210205.jpg" alt="" class="mo_review_item_image">
                        <div class="mo_review_item_name">[핏콩바] 깨강정 28g X 10개입</div>
                        <div class="mo_review_item_star"><img src="<?php echo G5_IMG_URL ?>/5_star.png"></div>
                        <div class="mo_review_item_con ellipsis3">세상 꼬소한 맛 여기 다 들어갔나여,,, 깨가 눈에도 보여서 귀여운데 씹을수록 꼬소움 장난아니에요ㅜㅜ 할미입맛인 제게 취향저격♡</div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="mo_review_item_more"><a href="<?php echo G5_SHOP_URL ?>/review.php"><img src="<?php echo G5_IMG_URL ?>/mo_all_button.png" alt=""></a></div>
        </div>
    </div>
</section>

<section id="mo_community_dabang">
    <div class="mo_community_dabang_wrap">
        <div class="mo_title_wrap">
            <div class="mo_title_icon"></div>
            <div class="mo_title_text"><img src="<?php echo G5_IMG_URL ?>/youtube_icon.png">핏콩&nbsp; 다방</div>
            <div class="mo_title_line"></div>
        </div>
        <div class="mo_community_dabang_item_wrap">
            <?php 
            $sql = " select * from {$g5['g5_shop_dabang_table']} where co_device = 'mobile' AND co_use = '1' order by co_id desc LIMIT 1 ";
            $result = sql_query($sql);
            for($i=0; $row=sql_fetch_array($result); $i++)
            {
                if(!$row['co_img_url']) {
                    $row['co_img_url'] = G5_DATA_URL.'/dabang/'.$row['co_id'];
                }
            ?>
            <div class="mo_dabang_item"><a href="<?php echo $row['co_url']; ?>" target="_blank"><img src="<?php echo $row['co_img_url']; ?>"></a></div>
            <div class="mo_community_text"><span>핏콩다방</span>은 건강한 식습관과 홈트를 지속적으로 소개하고 있습니다</div>
            <div class="mo_community_more"><a href="https://www.youtube.com/channel/UCCjJP_4jPLGbhQyzif5bvbg" target="_blank"><img src="<?php echo G5_IMG_URL ?>/mo_go_button.png"></a></div>
            <?php } ?>
        </div>    
    </div>
</section>

<section id="mo_community_instagram">
    <div class="mo_community_instagram_wrap">
        <div class="mo_title_wrap">
            <div class="mo_title_icon"></div>
            <div class="mo_title_text"><img src="<?php echo G5_IMG_URL ?>/instagram_icon.png">핏콩&nbsp; 인스타그램</div>
            <div class="mo_title_line"></div>
        </div>
        <div class="mo_community_instagram_item_wrap">
            <?php
            $sql = " select * from {$g5['g5_shop_instagram_table']} where co_use = '1' order by co_id desc LIMIT 6 ";
            $result = sql_query($sql);
            for($i=0; $row=sql_fetch_array($result); $i++)
            { 
            if(!$row['co_img_url']) {
                $row['co_img_url'] = G5_DATA_URL.'/instagram/'.$row['co_id'];
            }
            ?><?php if($i==0 || $i==3) { ?><div class="mo_instagram_item_line"><?php } ?><div class="mo_instagram_item"><a href="<?php echo $row['co_url']; ?>" target="_blank"><img src="<?php echo $row['co_img_url']; ?>"></a></div><?php if($i==0 || $i==1 || $i==3 || $i==4) { ?><div class="mo_instagram_item_blank"></div><?php } ?><?php if($i==2 || $i==5) { ?></div><?php } } ?>
            <div class="mo_community_text">핏콩이 전하는 소식과 다이어트 정보, 기분좋은 이벤트까지~ <br><span>#핏콩스타그램</span>과 친구가 되어주세요!</div>
            <div class="mo_community_more"><a href="https://www.instagram.com/fitkong_official/" target="_blank"><img src="<?php echo G5_IMG_URL ?>/mo_go_button.png"></a></div>
        </div>
    </div>    
</section>

<script src="<?php echo G5_JS_URL ?>/swiper.min.js"></script>
<script>
var swiper = new Swiper('.banner-container', {
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

var swiper2 = new Swiper('.best-product-container', {
  slidesPerView: 2.5,
  spaceBetween: 20,
  freeMode: true,
  pagination: {
    el: '.swiper-pagination2',
    clickable: true,
  },
});
var swiper3 = new Swiper('.best-review-container', {
  slidesPerView: 2.5,
  spaceBetween: 15,
  freeMode: true,
  pagination: {
    clickable: true,
  },
})

</script>
<script>
    function list_view1() {
        $('#mo_product_item_list2').removeClass('current_view');
        $('#mo_product_item_list3').removeClass('current_view');
        $('#mo_product_item_list1').addClass('current_view');
    }

    function list_view2() {
        $('#mo_product_item_list1').removeClass('current_view');
        $('#mo_product_item_list3').removeClass('current_view');
        $('#mo_product_item_list2').addClass('current_view');
    }

    function list_view3() {
        $('#mo_product_item_list1').removeClass('current_view');
        $('#mo_product_item_list2').removeClass('current_view');
        $('#mo_product_item_list3').addClass('current_view');
    }
</script>
<script type="text/javascript">
      $(window).resize(function(){resizeYoutube();});
      $(function(){resizeYoutube();});
      function resizeYoutube(){ $("iframe").each(function(){ if( /^https?:\/\/www.youtube.com\/embed\//g.test($(this).attr("src")) ){ $(this).css("width","100%"); $(this).css("height",Math.ceil( parseInt($(this).css("width")) * 100 / 100 ) + "px");} }); }
</script>
<?php
include_once(G5_MOBILE_PATH.'/tail.php');
?>