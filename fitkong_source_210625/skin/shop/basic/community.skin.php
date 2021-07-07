<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div id="community_wrap">
    <div id="community_top">
        <div class="community_top_back"><img src="<?php echo G5_IMG_URL; ?>/pc_community_back_rich.png"></div>
        <div class="community_top_icon"><img src="<?php echo G5_IMG_URL; ?>/pc_community_icon.png"></div>
        <div class="community_top_slogan">핏콩언니가 전하는<br>다양한 레시피와 이야기를 만나보세요!</div>
    </div>
    <section id="community_recipe">
        <div class="community_recipe_more_btn"><a href="<?php echo G5_SHOP_URL; ?>/recipe.php"><img src="<?php echo G5_IMG_URL; ?>/pc_community_more_btn.png"></a></div>
        <div class="community_title"><img src="<?php echo G5_IMG_URL; ?>/pc_community_icon1.png"> &nbsp;핏콩 레시피</div>
        <div class="community_title_line"></div>
        <div class="community_recipe_wrap">
             <?php
                $sql = " select * from {$g5['g5_shop_recipe_table']} where co_use = '1' order by co_id desc LIMIT 3 ";
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
                ?><?php if($i==0) { ?><div class="community_recipe_item_line"><?php } ?><a href="<?php echo G5_SHOP_URL; ?>/recipe.php?cid=<?php echo $row['co_id']; ?>"><div class="community_recipe_item"><img src="<?php echo $row['co_img_url']; ?>" alt=""><p class="community_recipe_item_title"><?php echo $row['co_title']; ?></p><p class="community_recipe_item_time"><?php echo $row['co_cook_person']; ?> &nbsp;|&nbsp; <?php echo $row['co_cook_time']; ?></p></div></a><?php if($i==0 || $i==1) { ?><div class="community_recipe_blank"></div><?php } ?><?php if($i==2) { ?></div><?php } } ?>
           
        </div>
    </section>

    <section id="community_dainty">
        <div class="community_dainty_more_btn"><a href="<?php echo G5_SHOP_URL; ?>/dainty.php"><img src="<?php echo G5_IMG_URL; ?>/pc_community_more_btn.png"></a></div>
        <div class="community_title"><img src="<?php echo G5_IMG_URL; ?>/pc_community_icon2.png"> &nbsp;핏콩 미식회</div>
        <div class="community_title_line"></div>
        <div class="community_dainty_wrap">
             <?php
                $sql = " select * from {$g5['g5_shop_dainty_table']} where co_use = '1' order by co_id desc LIMIT 2 ";
                $result = sql_query($sql);
                for($i=0; $row=sql_fetch_array($result); $i++)
                {
                if(!$row['co_img_url']) {
                    $file_img_url = G5_DATA_URL.'/dainty/'.$row['co_id'];
                    if (file($file_img_url)) {
                        $row['co_img_url'] = $file_img_url;
                    } else {
                        $row['co_img_url'] = G5_IMG_URL."/fitkong_recipe_blank.png";
                    }
                }
                ?><?php if($i==0) { ?><div class="community_dainty_item_line"><?php } ?><a href="<?php echo $row['co_url']; ?>" target="_blank"><div class="community_dainty_item"><img src="<?php echo $row['co_img_url']; ?>" alt=""></div></a><?php if($i==0) { ?><div class="community_dainty_blank"></div><?php } ?><?php if($i==1) { ?></div><?php } } ?>
        </div>
        
    </section>
    
    <section id="pc_community">
        <div class="pc_community_wrap">
            <div class="pc_community_con_wrap">
                <section id="pc_dabang">
                    <div class="pc_dabang_wrap">
                        <div class="pc_dabang_title_wrap">
                            <span class="pc_dabang_title_text"><img src="<?php echo G5_IMG_URL ?>/youtube_icon.png" class="pc_dabang_title_icon"> 핏콩 다방</span>
                            <div class="pc_dabang_title_sub_text"><span>핏콩다방</span>은 건강한 식습관과<br>홈트를 지속적으로 소개하고 있습니다.</div>
                        </div>
                        <div class="pc_dabang_item_wrap">
                            <?php
                            $sql = " select * from {$g5['g5_shop_dabang_table']} where co_device = 'pc' AND co_use = '1' order by co_id desc LIMIT 2 ";
                            $result = sql_query($sql);
                            for($i=0; $row=sql_fetch_array($result); $i++)
                            {
                            if(!$row['co_img_url']) {
                                $row['co_img_url'] = G5_DATA_URL.'/dabang/'.$row['co_id'];
                            }
                            ?>
                            <a href="<?php echo $row['co_url']; ?>" target="_blank"><div class="pc_dabang_item">
                                <img src="<?php echo $row['co_img_url']; ?>" class="pc_dabang_item_image">
                                <div class="pc_dabang_item_category"><?php echo $row['co_category']; ?></div>
                                <div class="pc_dabang_item_title"><?php echo $row['co_title']; ?></div>
                            </div></a><?}?>
                        </div>
                        <div class="pc_dabang_contact">
                            <a href="https://www.youtube.com/channel/UCCjJP_4jPLGbhQyzif5bvbg" target="_blank"><img src="<?php echo G5_IMG_URL ?>/all_button.png"></a>
                        </div>
                    </div>
                </section>

                <section id="pc_instagram">
                    <div class="pc_instagram_wrap">
                        <div class="pc_instagram_title_wrap">
                            <span class="pc_instagram_title_text"><img src="<?php echo G5_IMG_URL ?>/instagram_icon.png" class="pc_instagram_title_icon"> #핏콩스타그램</span>
                            <div class="pc_instagram_title_sub_text">핏콩언니가 전하는 다이어트 정보, 기분좋은 이벤트까지~<br><span>#핏콩스타그램</span>과 친구가 되어주세요!</div>
                        </div>
                        <div class="pc_instagram_item_wrap">
                            <?php
                            $sql = " select * from {$g5['g5_shop_instagram_table']} where co_use = '1' order by co_id desc LIMIT 9 ";
                            $result = sql_query($sql);
                            for($i=0; $row=sql_fetch_array($result); $i++)
                            {
                            if(!$row['co_img_url']) {
                                $row['co_img_url'] = G5_DATA_URL.'/instagram/'.$row['co_id'];
                            }
                            ?><?php if($i==0 || $i==3 || $i==6) { ?><div class="pc_instagram_item_line"><?php } ?><a href="<?php echo $row['co_url']; ?>" target="_blank"><img src="<?php echo $row['co_img_url']; ?>" alt="" class="pc_instagram_item_image"></a><?php if($i==0 || $i==1 || $i==3 || $i==4 || $i==6 || $i==7) { ?><div class="pc_instagram_item_blank"></div><?php } ?><?php if($i==2 || $i==5 || $i==8) { ?></div><?php } } ?>
                        </div>
                        <div class="pc_instagram_contact">
                            <a href="https://www.instagram.com/fitkong_official/" target="_blank"><img src="<?php echo G5_IMG_URL ?>/all_button.png"></a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

   
</div>
