<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$faq_skin_url.'/style.css">', 0);

?>

<!-- 검색 시작 { -->
<div id="search_top_wrap">
<div class="search_input_back"><img src="<?php echo G5_IMG_URL ?>/search_input_back.png" alt=""></div>
<div class="search_input_wrap">
    <form name="frmdetailsearch" action="search.php" id="frmsearch">
    <input type="hidden" name="qsort" id="qsort" value="<?php echo $qsort ?>">
    <input type="hidden" name="qorder" id="qorder" value="<?php echo $qorder ?>">
    <input type="hidden" name="qcaid" id="qcaid" value="<?php echo $qcaid ?>">
    <input class="search-input" name="q" id="searchText" placeholder="어떤 상품을 찾으세요?" value='<?php echo $q?>' <?php if(!$q) echo "autofocus"; ?>><div class="search-submit"><img src="<?php echo G5_IMG_URL ?>/search_input_icon.png" alt="" onclick="document.getElementById('frmsearch').submit();"></div>
    </form>
</div>
</div>
<?php if($q) { ?>
<div id="search_result_wrap">
    <?php 
        $sql = " select count(*) as cnt $sql_common $sql_where {$order_by} limit $from_record, $items ";
        $search_cnt = sql_fetch($sql);
        $search_cnt = $search_cnt['cnt'];
    ?>
    <div class="search_result_msg">총 <?php echo $search_cnt; ?>개의 상품이 검색되었습니다.</div>

    <div id="pc_product">
        <div class="pc_product_wrap">
       
        <div class="pc_product_item_wrap">
            
            <?php
            $sql = " select * $sql_common $sql_where {$order_by} limit $from_record, $items ";
            
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
        <?php if($search_cnt == 0) { ?> 
        <div style="height:350px;display: block;"></div>
        <?php } ?>
    </div>
</div>
<?php } ?>
</div>
<!-- } 검색 끝 -->
</div>
<script>

var shopSearchBest = function shopSearchBest(text) {
    var url = "<?php echo G5_SHOP_URL ?>/search.php?q=" + text
    window.location.href=url;
}
</script>
<script>
function set_sort(qsort, qorder)
{
    var f = document.frmdetailsearch;
    f.qsort.value = qsort;
    f.qorder.value = qorder;
    f.submit();
}

</script>