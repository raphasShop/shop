<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>
<div id="eventlist_wrap">
    <?php
    for ($i=0; $i<count($list); $i++) { if($list[$i]['is_notice']) { ?><?php if ($list[$i]['wr_3'] == '') { ?><a href="<?php echo $list[$i]['href'] ?>"><?php } else { ?><a href="<?php echo $list[$i]['wr_3'] ?>"><?php } ?><div class="eventlist_item eventlist_left wow fadeInUp" data-wow-duration="1s" data-wow-delay=".<?php echo $i + 1; ?>s" data-wow-offset="1">
        <img src="<?php echo $list[$i]['wr_2']; ?>">
        <p class="eventlist_title"><?php  echo $list[$i]['subject']; ?></p>
        <p class="eventlist_date"><?php echo $list[$i]['wr_1']; ?></p>
        <?php if($is_admin) { echo $list[$i]['wr_hit'];  } ?> 
	      
    </div></a><?php } } ?>
</div>
