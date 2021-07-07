<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
add_javascript('<script src="'.G5_JS_URL.'/jquery.bxslider.js"></script>', 10);
?>

<?php
$max_width = $max_height = 0;
$bn_first_class = ' class="bn_first"';
$bn_slide_btn = '';
$bn_sl = ' class="bn_sl"';

$main_banners = array();

for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $main_banners[] = $row;

    //if ($i==0) echo '<div id="main_bn">'.PHP_EOL.'<ul class="slide-wrap">'.PHP_EOL;
    //print_r2($row);
    // 테두리 있는지
    $bn_border  = ($row['bn_border']) ? ' class="sbn_border"' : '';;
    // 새창 띄우기인지
    $bn_new_win = ($row['bn_new_win']) ? ' target="_blank"' : '';

    $bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];
    $bimgurl = $row['bn_img_url'];
    if ((file_exists($bimg) || $bimgurl) && $row['bn_use'] == 1)
    {
        $banner = '';
        $size = getimagesize($bimg);

        if($size[2] < 1 || $size[2] > 16)
            continue;

        if($max_width < $size[0])
            $max_width = $size[0];

        if($max_height < $size[1])
            $max_height = $size[1];

        echo '<div class="swiper-slide banner-slide" style="background: '.$row['bn_bgcolor'].'">'.PHP_EOL;
        if ($row['bn_url'][0] == '#')
            $banner .= '<a href="'.$row['bn_url'].'" style="width:100%;height:100%;">';
        else if ($row['bn_url']) {
            $banner .= '<a href="'.G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'].'"'.$bn_new_win.' style="width:100%;height:100%;">';
        }
        echo $banner;
        if($bimgurl)
            echo '<img src="'.$bimgurl.'" alt="'.get_text($row['bn_alt']).'" class="slide-inner">';
        else
            echo '<img src="'.G5_DATA_URL.'/banner/'.$row['bn_id'].'" width="'.$size[0].'" alt="'.get_text($row['bn_alt']).'" class="slide-inner">';
        if($banner)
            echo '</a>'.PHP_EOL;
        echo '<div class="mainTitle">'.$row['bn_main_title']."</div>";
        echo '<div class="subTitle">'.$row['bn_sub_title']."</div>";
        
        
        
        echo '</div>'.PHP_EOL;

       
    }
}


?>