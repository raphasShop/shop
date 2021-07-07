<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가



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

    <div id="mo_product">
        <div class="mo_product_wrap current_view" id="mo_product_item_list2">
            <div class="mo_product_item_wrap">
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
                ?><?php if($i%3==0) { ?><div class="mo_product_item_line"><?php } ?><a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=<?php echo $row['it_id']; ?>"><div class="mo_product_item"><img src="<?php echo $row['it_img1']; ?>" alt="" class="mo_product_item_image"><div class="mo_product_item_badge"><img src="<?php echo G5_IMG_URL ?>/best.png"></div>
                    <div class="mo_product_item_name"><?php echo $row['it_name']; ?></div>
                    <div class="mo_product_item_bprice"><?php echo $row['it_cust_price']; ?></div>
                    <div class="mo_product_item_price"><?php echo $row['it_price']; ?></div>
                </div></a><?php if($i%3!=2) { ?><div class="mo_product_item_blank"></div><?php } ?><?php if($i%3==2) { ?></div><?php } } ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>

</div>


<!-- } 검색 끝 -->
<script>
    $(document).ready(function(){
   
      $('.tabs li').click(function(){
        var tab_id = $(this).attr('data-tab');
     
        $('.tabs li').removeClass('current');
        $('.tab-content').removeClass('current');
     
        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
      })
     
    })
</script>
<script>
function set_sort(qsort, qorder)
{
    var f = document.frmdetailsearch;
    f.qsort.value = qsort;
    f.qorder.value = qorder;
    f.submit();
}

function faq_open(el)
{
    var $con = $(el).closest("li").find(".con_inner");

    if($con.is(":visible")) {
        $("#faq_con .faq_icon-up:visible").css("display", "none");
        $("#faq_con .faq_icon-down").css("display", "block");
        $(el).closest("li").find(".faq_icon-up").css("display", "none");
        $(el).closest("li").find(".faq_icon-down").css("display", "block");
        $con.slideUp();
    } else {
        $("#faq_con .con_inner:visible").css("display", "none");
        $("#faq_con .faq_icon-up:visible").css("display", "none");
        $("#faq_con .faq_icon-down").css("display", "block");
        $(el).closest("li").find(".faq_icon-up").css("display", "block");
        $(el).closest("li").find(".faq_icon-down").css("display", "none");
        $con.slideDown();
    }

    return false;
}

function set_ca_id(qcaid)
{
    var f = document.frmdetailsearch;
    f.qcaid.value = qcaid;
    f.submit();
}

jQuery(function($){
    $(".btn_sort").click(function(){
        $("#ssch_sort ul").show();
    });
    $(document).mouseup(function (e){
        var container = $("#ssch_sort ul");
        if( container.has(e.target).length === 0)
        container.hide();
    });
});
</script>