<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<header>
    <div class="mo_page_title_wrap"><a href="javascript:history.back();"><img src="<?php echo G5_IMG_URL; ?>/title_back.png" title=""></a> 핏콩 미식회</div>
</header>
<section id="community_dainty_wrap">
    <div id="community_dainty_top">
        <div class="community_dainty_top_img"><img src="<?php echo G5_IMG_URL; ?>/co_dainty_top.png"></div>
    </div>
    <div id="community_dainty_con">
        <div class="community_dainty_con_wrap">
             <?php
                $sql = " select * from {$g5['g5_shop_dainty_table']} where co_use = '1' order by co_id asc";
                $result = sql_query($sql);
                for($i=0; $row=sql_fetch_array($result); $i++)
                {
                if(!$row['co_img_url']) {
                    $row['co_img_url'] = G5_DATA_URL.'/dainty/'.$row['co_id'];
                }
                ?><div class="community_dainty_con_item"><a href="<?php echo $row['co_url']; ?>"><img src="<?php echo $row['co_img_url']; ?>" alt=""></a></div><?php } ?>
        </div>
    </div>
   
</section>



