<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div id="review_list_wrap">
<div class="review_top_banner_wrap">
	<div class="review_top_banner"><img src="<?php echo G5_IMG_URL ?>/mo_review_top_banner.png"></div>
</div>
<div class="review_list_con_wrap">
	<div class="review_write_btn_wrap">
		<a href="<?php echo G5_SHOP_URL ?>/orderlist.php"><div class="review_write_btn">리뷰작성하기</div></a>
	</div>
	<a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=notice&wr_id=27"><div class="review_list_con_notice"><span>[이벤트]</span>리뷰 작성 시 적립금 증정!</div></a>
	<?php
    $thumbnail_width = 500;

     for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $is_num     = $total_count - ($page - 1) * $rows - $i;
        $is_star    = get_star($row['is_score']);
        $is_name    = get_text($row['is_name']);
        $is_subject = conv_subject($row['is_subject'],50,"…");
        //$is_content = ($row['wr_content']);
        $is_content = get_view_thumbnail(conv_content($row['is_content'], 1), $thumbnail_width);
        $is_reply_name = !empty($row['is_reply_name']) ? get_text($row['is_reply_name']) : '';
        $is_reply_subject = !empty($row['is_reply_subject']) ? conv_subject($row['is_reply_subject'],50,"…") : '';
        $is_reply_content = !empty($row['is_reply_content']) ? get_view_thumbnail(conv_content($row['is_reply_content'], 1), $thumbnail_width) : '';
        $is_time    = substr($row['is_time'], 2, 8);
        $is_href    = './itemuselist.php?bo_table=itemuse&amp;wr_id='.$row['wr_id'];

        $pattern = "/<img.*?src=[\"']?(?P<url>[^(http)].*?)[\"' >]/i";
        preg_match($pattern,stripslashes(str_replace('&','&',$is_content)), $matches);
        $imgs = substr($matches['url'],1);
        if($imgs) {
            if(strpos($imgs, '?type=') == false) {
                $imgs = $imgs."?type=w640";
            }
        }

        $mod_content = strip_tags($is_content);

        $hash = md5($row['is_id'].$row['is_time'].$row['is_ip']);

        if ($i == 0) echo '<ol id="sit_use_ol">';

        $it_id = get_text($row['it_id']);
        $it_name = get_item_name($it_id); 

        if($row['mb_id']) $is_name = $row['mb_id'];

    ?>
	<div class="review_list_item_wrap">
		<?php if($imgs) { ?><div class="review_list_item_image"><img src="<?php echo $imgs;?>"></div><?php } ?>
		<div class="review_list_item">
			<div class="review_list_item_subject"><span><?php echo $it_name; ?></span></div>
			<div class="review_list_item_writer"><span class="review_writer"><?php echo $is_name; ?></span><span class="review_date"><?php echo $is_time; ?></span></div>
			<div class="review_list_item_star">
				<?php echo get_star_icon($is_star); ?>
			</div>
		</div>
		<div class="review_list_item_text"><?php echo $mod_content ?></div>
	</div>
	<?php } ?>
	
	<?php echo get_paging($config['cf_mobile_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>
</div>
</div>

