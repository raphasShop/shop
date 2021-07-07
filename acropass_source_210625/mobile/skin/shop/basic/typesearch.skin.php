<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가



?>


<?php if($qtype=="type") { ?>
<div class="search-filter">
    <div id="top_menu_wrap">
        <ul class="tabs"><a href="<?php echo G5_SHOP_URL; ?>/typesearch.php?qtype=<?php echo $qtype; ?>&q=needle"><li class="top_menu2_button tab-link <?php if($q=='needle') { echo 'current'; } ?>">마이크로니들</li></a><a href="<?php echo G5_SHOP_URL; ?>/typesearch.php?qtype=<?php echo $qtype; ?>&q=skincare"><li class="top_menu2_button tab-link <?php if($q=='skincare') { echo 'current'; } ?>">스킨케어</li></ul>
    </div>
</div>
<?php } else if($qtype=="purpose") { ?>
<div class="search-filter">
    <div id="top_menu_wrap">
        <ul class="tabs"><a href="<?php echo G5_SHOP_URL; ?>/typesearch.php?qtype=<?php echo $qtype; ?>&q=trouble"><li class="top_menu3_button tab-link <?php if($q=='trouble') { echo 'current'; } ?>">트러블/진정</li></a><a href="<?php echo G5_SHOP_URL; ?>/typesearch.php?qtype=<?php echo $qtype; ?>&q=whitening"><li class="top_menu3_button tab-link <?php if($q=='whitening') { echo 'current'; } ?>">색소침착/미백</li></a><a href="<?php echo G5_SHOP_URL; ?>/typesearch.php?qtype=<?php echo $qtype; ?>&q=antiaging"><li class="top_menu3_button tab-link <?php if($q=='antiaging') { echo 'current'; } ?>">안티에이징</li></a></ul>
    </div>
</div>
<?php } ?>
<div id="ssch">

    <!-- 상세검색 항목 시작 { -->
    

    
   
   
    <!-- 검색결과 시작 { -->
    
    <div id="tab-1" class="tab-content current">
        <div id="ssch_frm_list">
        <?php
        // 리스트 유형별로 출력
        define('G5_SHOP_CSS_URL', G5_MSHOP_SKIN_URL);
        $list_file = G5_MSHOP_SKIN_PATH.'/'.$default['de_mobile_search_list_skin'];
        $skin = G5_MSHOP_SKIN_PATH.'/main.10.skin.php';
        if (file_exists($list_file)) {
            $list = new item_list($skin, $default['de_mobile_search_list_mod'], $default['de_mobile_search_list_row'], $default['de_mobile_search_img_width'], $default['de_mobile_search_img_height']);
            $list->set_query(" select * $sql_common $sql_where {$order_by} limit $from_record, $items ");
            $list->set_is_page(true);
            $list->set_mobile(true);
            $list->set_list_mod(2);
            $list->set_type(1);
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
        echo '</div>';

        $query_string = 'qname='.$qname.'&amp;qexplan='.$qexplan.'&amp;qid='.$qid.'&amp;qbasic='.$qbasic;
        if($qfrom && $qto) $query_string .= '&amp;qfrom='.$qfrom.'&amp;qto='.$qto;
        $query_string .= '&amp;qcaid='.$qcaid.'&amp;q='.urlencode($q);
        $query_string .='&amp;qsort='.$qsort.'&amp;qorder='.$qorder;
        echo get_paging($config['cf_mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$query_string.'&amp;page=');
        ?>
    </div>
 

</div>


<!-- } 검색 끝 -->
<script>
    $(document).ready(function(){
   
      $('.tabs li').click(function(){
        var tab_id = $(this).attr('data-tab');
     
        $('.tabs li').removeClass('current');
        $('.tab-content').removeClass('current');
     
        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
      })
     
    })
</script>
<script>
function set_sort(qsort, qorder)
{
    var f = document.frmdetailsearch;
    f.qsort.value = qsort;
    f.qorder.value = qorder;
    f.submit();
}

function faq_open(el)
{
    var $con = $(el).closest("li").find(".con_inner");

    if($con.is(":visible")) {
        $("#faq_con .faq_icon-up:visible").css("display", "none");
        $("#faq_con .faq_icon-down").css("display", "block");
        $(el).closest("li").find(".faq_icon-up").css("display", "none");
        $(el).closest("li").find(".faq_icon-down").css("display", "block");
        $con.slideUp();
    } else {
        $("#faq_con .con_inner:visible").css("display", "none");
        $("#faq_con .faq_icon-up:visible").css("display", "none");
        $("#faq_con .faq_icon-down").css("display", "block");
        $(el).closest("li").find(".faq_icon-up").css("display", "block");
        $(el).closest("li").find(".faq_icon-down").css("display", "none");
        $con.slideDown();
    }

    return false;
}

function set_ca_id(qcaid)
{
    var f = document.frmdetailsearch;
    f.qcaid.value = qcaid;
    f.submit();
}

jQuery(function($){
    $(".btn_sort").click(function(){
        $("#ssch_sort ul").show();
    });
    $(document).mouseup(function (e){
        var container = $("#ssch_sort ul");
        if( container.has(e.target).length === 0)
        container.hide();
    });
});
</script>