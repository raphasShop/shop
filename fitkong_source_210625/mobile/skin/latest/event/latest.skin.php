<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
?>
 <div id="eventlist_wrap">
    <?php
    for ($i=0; $i<count($list); $i++) { if($list[$i]['is_notice']) { ?><?php if ($list[$i]['wr_3'] == '') { ?><a href="<?php echo $list[$i]['href'] ?>"><?php } else { ?><a href="<?php echo $list[$i]['wr_3'] ?>"><?php } ?><div class="eventlist_item">
        <img src="<?php echo $list[$i]['wr_2']; ?>">
        
    </div></a><?php } } ?>
</div>


