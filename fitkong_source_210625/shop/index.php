<?php
include_once('./_common.php');

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/index.php');
    return;
}

define("_INDEX_", TRUE);

include_once(G5_SHOP_PATH.'/shop.head.php');
?>

<section id="pc_shop_banner">
    <div class="pc_shop_cate_wrap">
        <a href="<?php echo G5_SHOP_URL ?>"><span class="pc_shop_category <?php if(!$ca_id) echo 'pc_shop_cate_select'; ?>">전체</span></a>
        <?php
        $sql = " select * from {$g5['g5_shop_category_table']} order by ca_id asc";
        $result = sql_query($sql);
        for($i=0; $row=sql_fetch_array($result); $i++)
        {
        ?>
        <a href="<?php echo G5_SHOP_URL.'/?ca_id='.$row['ca_id']; ?>"><span class="pc_shop_category <?php if($ca_id == $row['ca_id']) echo 'pc_shop_cate_select'; ?>"><?php echo $row['ca_name']; ?></span></a>
        <?php } ?>
</section>

<section id="pc_shop_banner">
    <div class="pc_shop_banner_wrap">
        <img src="<?php echo G5_IMG_URL ?>/market_banner<?php echo $ca_id; ?>.jpg" alt="" class="pc_shop_banner_image">
    </div>
</section>

<section id="pc_product">
    <div class="pc_product_wrap">
   
    <div class="pc_product_item_wrap">
        
        <?php
        $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' order by it_order, it_id desc ";
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
        
        ?><?php if($i%4==0) { ?><div class="pc_product_item_line"><?php } ?><a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=<?php echo $row['it_id']; ?>"><div class="pc_product_item"><img src="<?php echo $row['it_img1']; ?>" alt="" class="pc_product_item_image" onmouseover="this.src='<?php echo $row['it_img2']; ?>'" onmouseout="this.src='<?php echo $row['it_img1']; ?>'"><div class="pc_product_item_badge"><?php if($row['it_type4'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/best.png"><? }?><?php if($row['it_type3'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/new.png"><? }?><?php if($row['it_type5'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/sale.png"><? }?></div>
                <div class="pc_product_item_name"><?php echo $row['it_name']; ?></div>
                <div class="pc_product_item_bprice"><?php echo $row['it_cust_price']; ?></div>
                <div class="pc_product_item_price"><?php echo $row['it_price']; ?></div>
            </div></a><?php if($i%4!=3) { ?><div class="pc_product_item_blank"></div><?php } ?><?php if($i%4==3) { ?></div><?php } } ?>
    
        
    </div>
</section>

<?php
include_once(G5_SHOP_PATH.'/shop.tail.php');
?>