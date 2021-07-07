<?php
$tv_idx = get_session("ss_tv_idx");

$tv_div['top'] = 0;
$tv_div['img_width'] = 400;
$tv_div['img_height'] = 400;
$tv_div['img_length'] = 6; // 한번에 보여줄 이미지 수

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/swiper.css">', 0);
?>

<!-- 오늘 본 상품 시작 { -->
<div id="stv" class="op_area">
        <h2>
            오늘 본 상품
        </h2>

        <?php if ($tv_idx) { // 오늘 본 상품이 1개라도 있을 때 ?>

        
        <?php
            $tv_tot_count = 0;
            $k = 0;
            for ($i=1;$i<=$tv_idx;$i++)
            {
                $tv_it_idx = $tv_idx - ($i - 1);
                $tv_it_id = get_session("ss_tv[$tv_it_idx]");

                $rowx = sql_fetch(" select * from {$g5['g5_shop_item_table']} where it_id = '$tv_it_id' ");
                if(!$rowx['it_id'])
                    continue;

                if ($tv_tot_count % $tv_div['img_length'] == 0) $k++;

                $it_name = get_text($rowx['it_name']);
                $img = get_it_image($tv_it_id, $tv_div['img_width'], $tv_div['img_height'], $tv_it_id, '', $it_name);

                if ($tv_tot_count == 0) echo '<div class="swiper-container todayview-container"><div class="swiper-wrapper">'.PHP_EOL;
                echo '<div class="swiper-slide">';
                echo '<div class="prd_img">';
                echo $img;
                echo '</div>'.PHP_EOL;
                echo '</div>'.PHP_EOL;

                $tv_tot_count++;
            }
            echo '</div>'.PHP_EOL;
            echo '<div class="swiper-pagination" style="display: none"></div>';
            echo '</div>'.PHP_EOL;
            
        ?>
        <?php } else { // 오늘 본 상품이 없을 때 ?>

        <p class="li_empty">최근 본 상품이 없습니다</p>

        <?php } ?>

</div>

<script src="<?php echo G5_JS_URL ?>/scroll_oldie.js"></script>
<script src="<?php echo G5_THEME_URL ?>/js/swiper.min.js"></script>
<script>
    var swiper10 = new Swiper('.todayview-container', {
      slidesPerView: 3,
      spaceBetween: 10,
      freeMode: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });
</script>
<!-- } 오늘 본 상품 끝 -->