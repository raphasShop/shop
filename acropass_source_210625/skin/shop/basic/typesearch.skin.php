<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$faq_skin_url.'/style.css">', 0);

?>



<!-- 검색 시작 { -->
<div class="shop_title_wrap" >
    <div class="shop_main_title"><?php if($qtype=="type") { echo "유형별"; } else if($qtype=="purpose") { echo "목적별"; } ?> 상품 검색</div>
    <div class="shop_sub_title"></div>
</div>
<div id="search_pc_wrap">


<?php if($qtype=="type") { ?>
<div id="customer_top_menu">
    <ul class="tabs"><a href="<?php echo G5_SHOP_URL; ?>/typesearch.php?qtype=<?php echo $qtype; ?>&q=needle"><li class="top_menu_search_button tab-link <?php if($q=='needle') { echo 'current'; } ?>">마이크로니들</li></a><a href="<?php echo G5_SHOP_URL; ?>/typesearch.php?qtype=<?php echo $qtype; ?>&q=skincare"><li class="top_menu_search_button tab-link <?php if($q=='skincare') { echo 'current'; } ?>">스킨케어</li></a></ul>
</div>
<?php } else if($qtype=="purpose") { ?>
<div id="customer_top_menu">
    <ul class="tabs"><a href="<?php echo G5_SHOP_URL; ?>/typesearch.php?qtype=<?php echo $qtype; ?>&q=trouble"><li class="top_menu_search_button tab-link <?php if($q=='trouble') { echo 'current'; } ?>">트러블/진정</li></a><a href="<?php echo G5_SHOP_URL; ?>/typesearch.php?qtype=<?php echo $qtype; ?>&q=whitening"><li class="top_menu_search_button tab-link <?php if($q=='whitening') { echo 'current'; } ?>">색소침착/미백</li></a><a href="<?php echo G5_SHOP_URL; ?>/typesearch.php?qtype=<?php echo $qtype; ?>&q=antiaging"><li class="top_menu_search_button tab-link <?php if($q=='antiaging') { echo 'current'; } ?>">안티에이징</li></a></ul>
</div>
<?php } ?>
<?php if($qtype=="type" || $qtype=="purpose") { ?>
<div id="ssch">
  
    <div id="tab-1" class="tab-content current">
    <!-- 검색결과 시작 { -->
        <?php
        // 리스트 유형별로 출력
        $list_file = G5_SHOP_SKIN_PATH.'/main.10.skin.php';
        if (file_exists($list_file)) {
            define('G5_SHOP_CSS_URL', G5_SHOP_SKIN_URL);
            $list = new item_list($list_file, $default['de_search_list_mod'], $default['de_search_list_row'], $default['de_search_img_width'], $default['de_search_img_height']);
            $list->set_query(" select * $sql_common $sql_where {$order_by} limit $from_record, $items ");
            $list->set_is_page(true);
            $list->set_view('it_img', true);
            $list->set_view('it_id', false);
            $list->set_view('it_name', true);
            $list->set_view('it_basic', true);
            $list->set_view('it_cust_price', false);
            $list->set_view('it_price', true);
            $list->set_view('it_icon', false);
            $list->set_view('sns', false);
            echo $list->run();
        }
        else
        {
            $i = 0;
            $error = '<p class="sct_nofile">'.$list_file.' 파일을 찾을 수 없습니다.<br>관리자에게 알려주시면 감사하겠습니다.</p>';
        }

        if ($i==0)
        {
            echo '<div>'.$error.'</div>';
        }

        $query_string = 'qname='.$qname.'&amp;qexplan='.$qexplan.'&amp;qid='.$qid;
        if($qfrom && $qto) $query_string .= '&amp;qfrom='.$qfrom.'&amp;qto='.$qto;
        $query_string .= '&amp;qcaid='.$qcaid.'&amp;q='.urlencode($q);
        $query_string .='&amp;qsort='.$qsort.'&amp;qorder='.$qorder;
        echo get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$query_string.'&amp;page=');
        ?>
    </div>


</div>
<?php } ?>

</div>

<script>

function set_ca_id(qcaid)
{
    var f = document.frmdetailsearch;
    f.qcaid.value = qcaid;
    f.submit();
}
</script>