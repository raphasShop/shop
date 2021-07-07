<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<section id="dainty_wrap">
    <div id="dainty_top">
        <div class="dainty_top_back"><img src="<?php echo G5_IMG_URL; ?>/pc_dainty_back.png"></div>
        <div class="dainty_top_slogan"><img src="<?php echo G5_IMG_URL; ?>/pc_dainty_slogan.png"></div>
    </div>
    <div id="community_dainty_wrap">
        <div id="community_dainty">
            <div class="community_dainty_wrap">
                 <?php
                    $sql = " select * from {$g5['g5_shop_dainty_table']} where co_use = '1' order by co_id asc ";
                    $result = sql_query($sql);
                    for($i=0; $row=sql_fetch_array($result); $i++)
                    {
                    if(!$row['co_img_url']) {
                        $row['co_img_url'] = G5_DATA_URL.'/dainty/'.$row['co_id'];
                    }
                    ?><?php if($i%2==0) { ?><div class="community_dainty_item_line"><?php } ?><a href="<?php echo $row['co_url']; ?>" target="_blank"><div class="community_dainty_item"><img src="<?php echo $row['co_img_url']; ?>" alt=""></div></a><?php if($i%2==0) { ?><div class="community_dainty_blank"></div><?php } ?><?php if($i%2==1) { ?></div><?php } } ?>
            </div>
        </div>
    </div>
</section>

