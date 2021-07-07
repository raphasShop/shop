<?php
include_once('./_common.php');

define("_INDEX_", TRUE);

include_once(G5_MSHOP_PATH.'/_head.php');

add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/swiper.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/swipe.js"></script>
<script src="<?php echo G5_JS_URL; ?>/shop.mobile.main.js"></script>

<section id="mo_shop_category">
    <div class="mo_shop_category_wrap">
        <div class="swiper-container shop-category-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide mo_shop_category_item">
                    <a href="<?php echo G5_SHOP_URL ?>"><img src="<?php echo G5_IMG_URL ?>/mo_market_cate<?php if(!$ca_id) echo '_1'; ?>.png" alt="" class="mo_shop_cate_item_image"></a>
                </div>
                <?php
                $sql = " select * from {$g5['g5_shop_category_table']} order by ca_id asc";
                $result = sql_query($sql);
                for($i=0; $row=sql_fetch_array($result); $i++)
                {
                    if($ca_id == $row['ca_id'])
                        $cate_img = G5_IMG_URL."/mo_market_cate".$row['ca_id']."_1.png";
                    else {
                        $cate_img = G5_IMG_URL."/mo_market_cate".$row['ca_id'].".png";
                    }
                ?>
                <div class="swiper-slide mo_shop_category_item">
                    <a href="<?php echo G5_SHOP_URL ?>/?ca_id=<?php echo $row['ca_id']; ?>"><img src="<?php echo $cate_img; ?>" alt="" class="mo_shop_cate_item_image"></a>
                </div>
                <? } ?>
            </div>
        </div>
    </div>
</section>
<section id="mo_shop_banner">
    <div class="mo_shop_banner_wrap">
        <?php $banner_url = G5_IMG_URL."/mo_market_banner".$ca_id.".jpg"; ?>
        <img src="<?php echo $banner_url ?>" class="mo_shop_banner_image">
    </div>
</section>
<section id="mo_product">
    <div class="mo_product_wrap" id="mo_product_item_list1">
        <div class="mo_title_wrap">
            <?php 
                if($ca_id) {
                    $sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' ";
                    $cate = sql_fetch($sql);
                } else {
                    $cate['ca_name'] = "모든상품";
                }
            ?>

            <div class="mo_title_text"><?php echo $cate['ca_name']; ?></div>
            <div class="mo_title_line"></div>
            <div class="mo_title_view_wrap">
                <a href="javascript:list_view1()"><img src="<?php echo G5_IMG_URL ?>/2block_select_icon.png" id="list_view1" class="mo_title_view_icon"></a>
                <a href="javascript:list_view2()"><img src="<?php echo G5_IMG_URL ?>/3block_icon.png"  id="list_view2" class="mo_title_view_icon"></a>
                <a href="javascript:list_view3()"><img src="<?php echo G5_IMG_URL ?>/list_icon.png"  id="list_view3" class="mo_title_view_icon"></a>
            </div>
        </div>
        <div class="mo_product_item2_wrap">
            <?php
            $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' order by it_order, it_id desc";
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
            </div>
        </div>
    </div>

    <div class="mo_product_wrap current_view" id="mo_product_item_list2">
        <div class="mo_title_wrap">
            <div class="mo_title_text"><?php echo $cate['ca_name']; ?></div>
            <div class="mo_title_line"></div>
            <div class="mo_title_view_wrap">
                <a href="javascript:list_view1()"><img src="<?php echo G5_IMG_URL ?>/2block_icon.png" id="list_view1" class="mo_title_view_icon"></a>
                <a href="javascript:list_view2()"><img src="<?php echo G5_IMG_URL ?>/3block_select_icon.png" id="list_view2" class="mo_title_view_icon"></a>
                <a href="javascript:list_view3()"><img src="<?php echo G5_IMG_URL ?>/list_icon.png" id="list_view3" class="mo_title_view_icon"></a>
            </div>
        </div>
        <div class="mo_product_item_wrap">
            <?php
            $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' order by it_order, it_id desc";
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
            </div>
        </div>
    </div>

    <div class="mo_product_wrap" id="mo_product_item_list3">
        <div class="mo_title_wrap">
            <div class="mo_title_text"><?php echo $cate['ca_name']; ?></div>
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
                $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' order by it_order, it_id desc";
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
        </div>      
    </div>
</section>
<script src="<?php echo G5_JS_URL ?>/swiper.min.js"></script>
<script>
var swiper2 = new Swiper('.shop-category-container', {
  slidesPerView: 5.5,
  spaceBetween: 0,
  freeMode: true,
  pagination: {
    el: '.swiper-pagination2',
    clickable: true,
  },
});
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

<?php
include_once(G5_MSHOP_PATH.'/_tail.php');
?>