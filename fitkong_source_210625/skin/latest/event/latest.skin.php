<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
$thumb_width = 560;
$thumb_height = 260;
?>
<div id="eventlist_wrap">
    <?php
    $pos = 0;
    for ($i=0; $i<count($list); $i++) { if($list[$i]['is_notice']) { ?><?php if ($list[$i]['wr_3'] == '') { ?><a href="<?php echo $list[$i]['href'] ?>"><?php } else { ?><a href="<?php echo $list[$i]['wr_3'] ?>"><?php } ?><div class="eventlist_item <?php if($pos % 2 == 0) echo "eventlist_left"; else echo "eventlist_right"; ?> wow fadeInUp" data-wow-duration="1s" data-wow-delay=".<?php echo $pos + 1; ?>s" data-wow-offset="1">
    	<?php if ($list[$i]['wr_2'] == '') { 
    		$thumb = get_list_thumbnail('event', $list[$i]['wr_id'], 560, 260, false, true);
            if($thumb['src']) {
                $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" >';
            }
            echo $img_content;
    	} else { ?>
        <img src="<?php echo $list[$i]['wr_2']; ?>">
	    <?php } ?>
        <p class="eventlist_title"></p>
        <p class="eventlist_date"></p>
        <?php if($is_admin) { echo $list[$i]['wr_hit'];  } ?> 
	    <?php $pos++; ?>  
    </div></a><?php } } ?>
</div>
