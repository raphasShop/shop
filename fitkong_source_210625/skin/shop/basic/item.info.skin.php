<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<?php if ($default['de_rel_list_use']) { ?>
<!-- 관련상품 시작 { -->
<section id="sit_rel">
    <div class="shop_rel_title"><img src="<?php echo G5_IMG_URL; ?>/shop_related_icon.png"> 이 상품은 어때요?</div>
    <div class="shop_rel_line"></div>
    <?php
    $rel_skin_file = $skin_dir.'/'.$default['de_rel_list_skin'];
    if(!is_file($rel_skin_file))
        $rel_skin_file = G5_SHOP_SKIN_PATH.'/'.$default['de_rel_list_skin'];

    $sql = " select b.* from {$g5['g5_shop_item_relation_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id) where a.it_id = '{$it['it_id']}' and b.it_use='1' ";
    $list = new item_list($rel_skin_file, $default['de_rel_list_mod'], 0, $default['de_rel_img_width'], $default['de_rel_img_height']);
    $list->set_query($sql);
    //echo $list->run();
    ?>

    <div class="pc_product_item_wrap">
        <div class="pc_product_item_line">
            <?php 
                
                $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' AND it_type2 = '1' AND it_id != '$it_id' order by it_order, it_id desc LIMIT 4";
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
            ?><a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=<?php echo $row['it_id']; ?>"><div class="pc_product_item"><img src="<?php echo $row['it_img1']; ?>" alt="" class="pc_product_item_image" onmouseover="this.src='<?php echo $row['it_img2']; ?>'" onmouseout="this.src='<?php echo $row['it_img1']; ?>'">
                <div class="pc_product_item_badge">
                    <?php if($row['it_type4'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/best.png"><? }?><?php if($row['it_type3'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/new.png"><? }?><?php if($row['it_type5'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/sale.png"><? }?>
                </div>
                <div class="pc_product_item_name"><?php echo $row['it_name']; ?></div>
                <?php if($sale_ratio != 0 && $sale_ratio != 100) { ?>
                <div class="pc_product_item_sratio"><?php echo $sale_ratio; ?>% ↓</div>
                <?php } ?>
                <div class="pc_product_item_bprice"><?php echo $row['it_cust_price']; ?></div>
                <div class="pc_product_item_price"><?php echo $row['it_price']; ?></div>
            </div></a><?php if($i < 3) { ?><div class="pc_product_item_blank"></div><?php } } ?>
        </div>
    </div>
</section>
<!-- } 관련상품 끝 -->
<?php } ?>

<!-- 상품 정보 시작 { -->
<section id="sit_inf">
    <h2>상품 정보</h2>
    <?php echo pg_anchor('inf'); ?>

    <?php if ($it['it_basic']) { // 상품 기본설명 ?>
    <h3>상품 기본설명</h3>
    <div id="sit_inf_basic">
        
    </div>
    <?php } ?>

    <?php if ($it['it_explan']) { // 상품 상세설명 ?>
    <h3>상품 상세설명</h3>
    <div id="sit_inf_explan">
        <?php
        $sql = " select * from {$g5['g5_shop_con_banner_table']} where bn_use = '1' AND bn_device = 'pc' order by bn_order asc ";
        $result = sql_query($sql);
        for($i=0; $row=sql_fetch_array($result); $i++)
        {
            if(!$row['bn_img_url']) {
                $row['bn_img_url'] = G5_DATA_URL.'/con_banner/'.$row['bn_id'];
            }

            if($row['bn_new_win']) {
                $bn_new = "_blank";
            } else {
                $bn_new = "_self";
            }
        ?>
        <?php if($row['bn_url'] && $row['bn_url'] != 'http://') { ?><a href="<?php echo $row['bn_url']; ?>" target="<?php echo $bn_new; ?>"><?php } ?><img src="<?php echo $row['bn_img_url']; ?>" style="width:100%;">
        <?php if($row['bn_url'] && $row['bn_url'] != 'http://') { ?></a><?php } }?>
        
        <?php echo conv_content($it['it_explan'], 1); ?>
    </div>
    <?php } ?>

    <!--

    <?php
    if ($it['it_info_value']) { // 상품 정보 고시
        $info_data = unserialize(stripslashes($it['it_info_value']));
        if(is_array($info_data)) {
            $gubun = $it['it_info_gubun'];
            $info_array = $item_info[$gubun]['article'];
    ?>
    <h3>상품 정보 고시</h3>
    <table id="sit_inf_open">
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <?php
    foreach($info_data as $key=>$val) {
        $ii_title = $info_array[$key][0];
        $ii_value = $val;
    ?>
    <tr>
        <th scope="row"><?php echo $ii_title; ?></th>
        <td><?php echo $ii_value; ?></td>
    </tr>
    <?php } //foreach?>
    </tbody>
    </table>
    <!-- 상품정보고시 end --
    <?php
        } else {
            if($is_admin) {
                echo '<p>상품 정보 고시 정보가 올바르게 저장되지 않았습니다.<br>config.php 파일의 G5_ESCAPE_FUNCTION 설정을 addslashes 로<br>변경하신 후 관리자 &gt; 상품정보 수정에서 상품 정보를 다시 저장해주세요. </p>';
            }
        }
    } //if
    ?>
    
    -->
</section>
<!-- } 상품 정보 끝 -->

<!-- 사용후기 시작 { -->
<section id="sit_use">
    <h2>사용후기</h2>
    <?php echo pg_anchor('use'); ?>

    <div id="itemuse"><?php include_once(G5_SHOP_PATH.'/itemuse.php'); ?></div>
</section>
<!-- } 사용후기 끝 -->

<!-- 상품문의 시작 { -->
<section id="sit_qa">
    <h2>상품문의</h2>
    <?php echo pg_anchor('qa'); ?>

    <div id="itemqa"><?php include_once(G5_SHOP_PATH.'/itemqa.php'); ?></div>
</section>
<!-- } 상품문의 끝 -->

<?php if ($default['de_baesong_content']) { // 배송정보 내용이 있다면 ?>
<!-- 배송정보 시작 { -->
<section id="sit_dvr">
    <h2>배송정보</h2>
    <?php echo pg_anchor('dvr'); ?>

    <?php echo conv_content($default['de_baesong_content'], 1); ?>
</section>
<!-- } 배송정보 끝 -->
<?php } ?>

<div class="pc_scroll_item_banner">
    <div class="pc_scroll_item_banner_con_wrap">
        <img src="<?php echo G5_IMG_URL ?>/scroll_bn.png">
        <div class="pc_scroll_item_banner_con">
           <?php include(G5_SHOP_SKIN_PATH.'/boxtodayview.skin.php'); // 오늘 본 상품 ?>
        </div>
    </div>
</div>


<?php if ($default['de_change_content']) { // 교환/반품 내용이 있다면 ?>
<!-- 교환/반품 시작 { --
<section id="sit_ex">
    <h2>교환/반품</h2>
    <?php echo pg_anchor('ex'); ?>

    <?php echo conv_content($default['de_change_content'], 1); ?>
</section>
<!-- } 교환/반품 끝 --
<?php } ?>
-->

<script>
$(window).on("load", function() {
    $("#sit_inf_explan").viewimageresize2();
});
</script>
<script>
$(window).scroll(function() {
  
    if($(this).scrollTop() > 300) {
        $(".pc_scroll_item_banner").css('position','fixed');
        $(".pc_scroll_item_banner").css('top','50px');
    }
    else {
        $(".pc_scroll_item_banner").css('position','absolute');
        $(".pc_scroll_item_banner").css('top','300px');
    }
});
</script>