<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div id="community_wrap">
    <div id="community_top">
        <div class="community_top_back"><img src="<?php echo G5_IMG_URL; ?>/co_top.png"></div>
    </div>
    <div id="community_recipe">
        <div class="community_title">핏콩레시피</div>
        <div class="community_title_line"></div>
        <div class="community_recipe_wrap">
             <?php
                $sql = " select * from {$g5['g5_shop_recipe_table']} where co_use = '1' order by co_id desc LIMIT 2 ";
                $result = sql_query($sql);
                for($i=0; $row=sql_fetch_array($result); $i++)
                {
                if(!$row['co_img_url']) {
                    $row['co_img_url'] = G5_DATA_URL.'/recipe/'.$row['co_id'];
                }
                ?><?php if($i==0 || $i==2 || $i==4) { ?><div class="community_recipe_item_line"><?php } ?><a href="<?php echo $row['co_url']; ?>" target="_blank"><img src="<?php echo $row['co_img_url']; ?>" alt="" class="community_recipe_item"></a><?php if($i==0 || $i==2 || $i==4) { ?><div class="community_recipe_blank"></div><?php } ?><?php if($i==1 || $i==3 || $i==4) { ?></div><?php } } ?>
        </div>
    </div>
   
</div>
