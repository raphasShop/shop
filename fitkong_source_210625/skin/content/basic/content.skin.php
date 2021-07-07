<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$content_skin_url.'/style.css">', 0);
?>


<div class="contents_wrap">
	<div class="contents_title_wrap" >
		<div class="contents_title"><?php echo $g5['title']; ?></div>
	</div>
	<div class="contents_con_wrap">
		<?php echo $str; ?>
	</div>
</div>

