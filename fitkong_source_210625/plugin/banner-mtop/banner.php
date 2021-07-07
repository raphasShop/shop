<?php
include_once("_common.php");

	$sql = " select * from g5_shop_mtopbanner";
    $row = sql_fetch($sql);

	$imgnumber = '1';
	$imgnumber2 = '2';
	$display = $skin_path;
	$start_date = $row['bn_begin_time'];
	$end_date = $row['bn_end_time'];
	$bgcolor = $row['bn_bgcolor'];

	$bn_border  = ($row['bn_border']) ? ' class="sbn_border"' : '';;
    $bn_new_win = ($row['bn_new_win']) ? ' target="_blank"' : '';
    $bimg = G5_DATA_PATH.'/mtopbanner/'.$imgnumber;
	$bimg2 = G5_DATA_URL.'/mtopbanner/'.$imgnumber2;
	$imgdir .= '<img src="'.G5_DATA_URL.'/mtopbanner/'.$imgnumber.'" alt="'.$row['bn_alt'].'" width="'.$size[0].'" height="'.$size[1].'"'.$bn_border.'>';

    if (file_exists($bimg)) {
     $banner = '';
     $size = getimagesize($bimg);

        if ($row['bn_url'][0] == '#') $banner .= '<a href="'.$row['bn_url'].'">';
        else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
            $banner .= '<a href="'.G5_URL.'/plugin/banner-mtop/mtopbannerhit.php?&amp;url='.urlencode($row['bn_url']).'"'.$bn_new_win.'>';
        }
    }

$top_banner_path = G5_URL.'/plugin/banner-mtop';
if ($close) { set_session("ss_top_banner", 1); exit; }
if ($start_date <=  G5_TIME_YMDHIS and G5_TIME_YMDHIS <= $end_date) {
if (!get_session("ss_top_banner")) {
?>
        <style type="text/css">
        body { padding:0; margin:0; }
        #top_banner { position:relative; background: <?php echo $bgcolor;?>; height:<?php echo $row['bn_border'];?>px; text-align:center; }
        #top_banner div#box { display:inline-block; margin:0px auto 0 auto; width:<?php echo $row['bn_order'];?>px; }
        #top_banner div#box div.image { float:left; text-align:center; }
		#top_banner div#box div.today { float:right; font-family: 'Nanum Gothic', sans-serif; font-size:11px; color:#FFFFFF; padding-top:25px; text-align:right; }
        #top_banner div#box span.close { font-size:40px; margin:0 auto; }	
        </style>

<?php if (G5_IS_MOBILE) { ?>
    <?php if ($row['bn_device'] !== 'pc') { ?>
    <!-- 모바일버전 배너 -->
        <div id="top_banner">
            <div id="box">
                <div class="today"><span class="close"><i class="fa <?php echo $row['bn_position']; ?>"></i></span></div>
                <div class="image"><?php echo $banner; ?><?php echo $row['bn_alt'];?></a></div>
            </div>
        </div>
    <!-- 모바일버전 배너 -->
    <?php  } ?>
<?php } else {?>
    <?php if ($row['bn_device'] !== 'mobile') { ?>
    <!-- PC버전 배너 -->
        <div id="top_banner">
            <div id="box">
                <div class="today"><span class="close at-tip" data-original-title="<nobr>그만보기</nobr>" data-toggle="tooltip" data-placement="right" data-html="true"><i class="fa <?php echo $row['bn_position']; ?>"></i></span></div>
                <div class="image"><?php echo $banner; ?><?php echo $imgdir;?></a></div>
            </div>
        </div>
    <!-- PC버전 배너 -->
    <?php  } ?>
<?php  } ?>
        <script type="text/javascript">
        $("#top_banner .close").css("cursor", "pointer");
        $("#top_banner .close").click(function () {
            $(this).hide();
            $("#top_banner").slideUp();
            $.get("<?=$top_banner_path?>/banner.php?close=1");
        });
        </script>
<?php
	}
}
//echo $bimg2;
?>