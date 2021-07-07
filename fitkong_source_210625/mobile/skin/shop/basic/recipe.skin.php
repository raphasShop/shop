<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<header>
    <div class="mo_page_title_wrap"><a href="javascript:history.back();"><img src="<?php echo G5_IMG_URL; ?>/title_back.png" title=""></a> 핏콩 레시피</div>
</header>
<?php
$cid = $_GET['cid']; 
if($cid) { 
    $sql = " select * from {$g5['g5_shop_recipe_table']} where co_id = '$cid' ";
    $co = sql_fetch($sql);

    $co_recipe = $co['co_cook_recipe'];
    $sub_recipe = explode(';' , $co_recipe);
    $co_cook_recipe1 = $sub_recipe[0];
    $co_cook_recipe2 = $sub_recipe[1];
    $co_cook_recipe3 = $sub_recipe[2];
    $co_cook_recipe4 = $sub_recipe[3];
    $co_cook_recipe5 = $sub_recipe[4];
    $co_cook_recipe6 = $sub_recipe[5];
    $co_cook_recipe7 = $sub_recipe[6];
    $co_cook_recipe8 = $sub_recipe[7];
    $co_cook_recipe9 = $sub_recipe[8];
    $co_cook_recipe10 = $sub_recipe[9];

    if(!$co['co_img_url']) {
        $file_img_url = G5_DATA_URL.'/recipe/'.$co['co_id'];
        if (file($file_img_url)) {
            $co['co_img_url'] = $file_img_url;
        } else {
            $co['co_img_url'] = G5_IMG_URL."/fitkong_recipe_blank_image.png";
        }
    }
?>
<section id="community_recipe_wrap">
    <div id="community_recipe_top">
        <div class="community_recipe_top_icon"><img src="<?php echo G5_IMG_URL; ?>/co_recipe_icon1.png"></div>
        <div class="community_recipe_top_title"><?php echo $co['co_title']; ?></div>
        <div class="community_recipe_top_time"><img src="<?php echo G5_IMG_URL; ?>/co_recipe_icon2.png"> <?php echo $co['co_cook_time']; ?>&nbsp;&nbsp;&nbsp;<img src="<?php echo G5_IMG_URL; ?>/co_recipe_icon3.png"> <?php echo $co['co_cook_person']; ?></div>
    </div>
    <div id="community_recipe_con">
        <img src="<?php echo $co['co_img_url']; ?>" class="community_recipe_con_img">
        <div class="community_recipe_con_submenu">재료 및 분량</div>
        <div class="community_recipe_con_material"><?php echo $co['co_cook_material']; ?></div>
        <div class="community_recipe_con_submenu">만들기</div>
        <div class="community_recipe_con_process_wrap">
            <?php 
                for($i=0;$i<10;$i++) {
                    if($sub_recipe[$i]) {
                        $k = $i+1;
                        echo "<div class=\"community_recipe_con_process_item\"><div class=\"community_recipe_con_no\">".$k."</div><div class=\"community_recipe_con_process\">".$sub_recipe[$i]."</div></div>";
                    }
                }
            ?>
        </div>
        <div class="community_recipe_con_youtube"><a href="<?php echo $co['co_url']; ?>" target="_blank"><img src="<?php echo G5_IMG_URL; ?>/co_recipe_youtube.png"></a></div>
    </div>
   
</section>
<?php } else { ?>
<section id="community_recipe_wrap">
    <div id="community_recipe_top">
        <div class="community_recipe_top_back"><img src="<?php echo G5_IMG_URL; ?>/co_recipe_top.png"></div>
    </div>
    <div id="community_recipe">
        <div class="community_recipe_wrap">
             <?php
                $sql = " select * from {$g5['g5_shop_recipe_table']} where co_use = '1' order by co_id desc";
                $result = sql_query($sql);
                for($i=0; $row=sql_fetch_array($result); $i++)
                {
                if(!$row['co_img_url']) {
                    $file_img_url = G5_DATA_URL.'/recipe/'.$row['co_id'];
                    if (file($file_img_url)) {
                        $row['co_img_url'] = $file_img_url;
                    } else {
                        $row['co_img_url'] = G5_IMG_URL."/fitkong_recipe_blank_image.png";
                    }
                }
                ?><?php if($i==0 || $i%2==0) { ?><div class="community_recipe_item_line"><?php } ?><a href="<?php echo G5_SHOP_URL; ?>/recipe.php?cid=<?php echo $row['co_id']; ?>"><div class="community_recipe_item"><img src="<?php echo $row['co_img_url']; ?>" alt=""><p class="community_recipe_item_title"><?php echo $row['co_title']; ?></p><p class="community_recipe_item_time"><?php echo $row['co_cook_person']; ?> &nbsp;|&nbsp; <?php echo $row['co_cook_time']; ?></p></div></a><?php if($i%2==0 || $i==0) { ?><div class="community_recipe_blank"></div><?php } ?><?php if($i%2==1) { ?></div><?php } } ?>
        </div>
    </div>
   
</section>
<?php } ?>

