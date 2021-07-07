<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$content_skin_url.'/style.css">', 0);
?>
<div class="contents_title_wrap" >
    <div class="contents_main_title"><?php echo $g5['title']; ?></div>
    <div class="contetns_sub_title"></div>
</div>
<div id="con_wrap">
	<div class="con_default">

	<article id="ctt" class="ctt_<?php echo $co_id; ?>">
	    <div id="ctt_con">
	        <?php echo $str; ?>
	    </div>

	</article>
	</div>
</div>