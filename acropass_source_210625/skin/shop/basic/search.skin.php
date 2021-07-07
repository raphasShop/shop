<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$faq_skin_url.'/style.css">', 0);

?>

<!-- 검색 시작 { -->
<div class="shop_title_wrap" >
    <div class="shop_main_title">검색</div>
    <div class="shop_sub_title"></div>
</div>
<div id="search_pc_wrap">

<div class="search_input_wrap">
    <form name="frmdetailsearch" action="search.php" id="frmsearch">
    <input type="hidden" name="qsort" id="qsort" value="<?php echo $qsort ?>">
    <input type="hidden" name="qorder" id="qorder" value="<?php echo $qorder ?>">
    <input type="hidden" name="qcaid" id="qcaid" value="<?php echo $qcaid ?>">
    <input class="search-input" name="q" id="searchText" placeholder="어떤 상품을 찾으세요?" value='<?php echo $q?>' <?php if(!$q) echo "autofocus"; ?>><div class="search-submit"><i class="xi-search" onclick="document.getElementById('frmsearch').submit();"></i></div>
    </form>
</div>
<?php if($q) { ?>
<div id="customer_top_menu">
    <ul class="tabs"><li class="top_menu_search_button tab-link current" data-tab="tab-1">상품</li><li class="top_menu_search_button tab-link" data-tab="tab-2">리뷰</li><li class="top_menu_search_button tab-link" data-tab="tab-3">FAQ</li></ul>
</div>
<div id="ssch">
  
    <div id="tab-1" class="tab-content current">
    <!-- 검색결과 시작 { -->
        <div class="search-result-msg"><span><?php echo $q; ?></span> 에 대한 상품 검색 결과</div>
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
    <!-- } 검색결과 끝 -->
    <div id="tab-2" class="tab-content">
        <div class="search-result-msg"><span><?php echo $q; ?></span> 에 대한 리뷰 검색 결과</div>
        <div id="sit_use_list">

            <!-- <p><?php echo $config['cf_title']; ?> 전체 사용후기 목록입니다.</p> -->

            <?php
            $sql_common = " from `{$g5['g5_shop_item_use_table']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id) ";
            $sql_search = " where a.is_confirm = '1' and (b.it_name like '$q%' OR a.is_content like '$q%') order by a.is_time desc limit 100";
            $sql = " select *
                      $sql_common
                      $sql_search
                      ";
            $result = sql_query($sql);
            $thumbnail_width = 500;

             for ($i=0; $row=sql_fetch_array($result); $i++)
            {
                $is_num     = $total_count - ($page - 1) * $rows - $i;
                $is_star    = get_star($row['is_score']);
                $is_name    = get_text($row['is_name']);
                $is_subject = conv_subject($row['is_subject'],50,"…");
                //$is_content = ($row['wr_content']);
                $is_content = get_view_thumbnail(conv_content($row['is_content'], 1), $thumbnail_width);
                $is_reply_name = !empty($row['is_reply_name']) ? get_text($row['is_reply_name']) : '';
                $is_reply_subject = !empty($row['is_reply_subject']) ? conv_subject($row['is_reply_subject'],50,"…") : '';
                $is_reply_content = !empty($row['is_reply_content']) ? get_view_thumbnail(conv_content($row['is_reply_content'], 1), $thumbnail_width) : '';
                $is_time    = substr($row['is_time'], 2, 8);
                $is_href    = './itemuselist.php?bo_table=itemuse&amp;wr_id='.$row['wr_id'];

                $pattern = "/<img.*?src=[\"']?(?P<url>[^(http)].*?)[\"' >]/i";
                preg_match($pattern,stripslashes(str_replace('&','&',$is_content)), $matches);
                $imgs = substr($matches['url'],1);

                $mod_content = strip_tags($is_content);

                $hash = md5($row['is_id'].$row['is_time'].$row['is_ip']);

                if ($i == 0) echo '<ol id="sit_use_ol">';

                $it_id = get_text($row['it_id']);
                $it_name = get_item_name($it_id); 

            ?>
                <li class="sit_use_li">
                    <button type="button" class="sit_use_li_title"><?php echo $it_name; ?></button>
                    <span class="sit_use_img"><?php if($imgs) { ?><img src="<?php echo $imgs;?>"><?php } ?></span>
                    <dl class="sit_use_dl sit_use_star">
                        <dt>별</dt>
                        <dd><?php echo get_star_icon($is_star); ?></dd>
                        
                    </dl>
                    <dl class="sit_use_dl">
                        <dt>리뷰</dt>
                        <dd class="sit_use_content"><?php echo $mod_content ?></dd>
                    </dl>
                    <dl class="sit_use_dl">
                        <dt>작성자</dt>
                        <dd class="sit_use_name"><?php echo $is_name; ?></dd>
                        <dt>작성일</dt>
                        <dd class="sit_use_date"><?php echo $is_time; ?></dd>
                    </dl>

                    <div id="sit_use_con_<?php echo $i; ?>" class="sit_use_con">
                       

                        <?php if ($is_admin || $row['mb_id'] == $member['mb_id']) { ?>
                        <div class="sit_use_cmd">
                            <a href="<?php echo $itemuse_form."&amp;is_id={$row['is_id']}&amp;w=u"; ?>" class="itemuse_form btn01" onclick="return false;">수정</a>
                            <a href="<?php echo $itemuse_formupdate."&amp;is_id={$row['is_id']}&amp;w=d&amp;hash={$hash}"; ?>" class="itemuse_delete btn01">삭제</a>
                        </div>
                        <?php } ?>

                        <?php if( $is_reply_subject ){  //  사용후기 답변 내용이 있다면 ?>
                        <div class="sit_use_reply">
                            <div class="use_reply_icon">답변</div>
                            <div class="use_reply_tit">
                                <?php echo $is_reply_subject; // 답변 제목 ?>
                            </div>
                            <div class="use_reply_name">
                                <?php echo $is_reply_name; // 답변자 이름 ?>
                            </div>
                            <div class="use_reply_p">
                                <?php echo $is_reply_content; // 답변 내용 ?>
                            </div>
                        </div>
                        <?php } //end if ?>
                    </div>
                </li>

            <?php }

            if ($i > 0) echo '</ol>';

            if (!$i) echo '<div class="sit_empty"><img src="'.G5_IMG_URL.'/shop-reviewempty.png" alt=""><p class="sit_empty_message">상품리뷰가 없습니다.</p></div>';    ?>
        </div>

        <?php echo get_paging($config['cf_mobile_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

    </div>
    <div id="tab-3" class="tab-content">
        <?php 
            $stx = trim($q);
            $sql_search = "fm_id = '$fm_id'";
            $fm_id = 1;

            if($stx) {
               $sql_search = " ( INSTR(fa_subject, '$stx') > 0 or INSTR(fa_content, '$stx') > 0 ) ";
            }


            if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)

            $page_rows = G5_IS_MOBILE ? $config['cf_mobile_page_rows'] : $config['cf_page_rows'];

            $sql = " select count(*) as cnt
                        from {$g5['faq_table']}
                        where $sql_search ";
            $total = sql_fetch($sql);
            $total_count = $total['cnt'];


            
            $sql = " select *
                        from {$g5['faq_table']}
                        where $sql_search
                        order by fa_order , fa_id ";
            $result = sql_query($sql);
            for ($i=0;$row=sql_fetch_array($result);$i++){
                $faq_list[] = $row;
                if($stx) {
                    $faq_list[$i]['fa_subject'] = search_font($stx, conv_content($faq_list[$i]['fa_subject'], 1));
                    $faq_list[$i]['fa_content'] = search_font($stx, conv_content($faq_list[$i]['fa_content'], 1));
                }
            }           
        ?>
        <div class="search-result-msg"><span><?php echo $q; ?></span> 에 대한 FAQ 검색 결과</div>
        <div id="ssch_faq_list">
        <div id="faq_wrap" class="faq_<?php echo $fm_id; ?>">
            <?php // FAQ 내용
            if( count($faq_list) ){
            ?>
            <section id="faq_con">
                <h2><?php echo $g5['title']; ?> 목록</h2>
                <ol>
                    <?php
                    foreach($faq_list as $key=>$v){
                        if(empty($v))
                            continue;
                    ?>
                    <li>
                        <h3><a href="#none" onclick="return faq_open(this);"><?php echo conv_content($v['fa_subject'], 1); ?></a></h3>
                        <div class="faq_icon-down"><i class="xi-angle-down"></i></div>
                        <div class="faq_icon-up"><i class="xi-angle-up"></i></div>
                        <div class="con_inner">
                            <?php echo conv_content($v['fa_content'], 1); ?>
                            
                        </div>
                    </li>
                    <?php
                    }
                    ?>
                </ol>
            </section>
            <?php

            } else {
                if($stx){
                    echo '<p class="search-empty-list">검색된 FAQ가 없습니다.</p>';
                } else {
                    echo '<div class="empty_table">등록된 FAQ가 없습니다.';
                    if($is_admin)
                        echo '<br><a href="'.G5_ADMIN_URL.'/faqmasterlist.php">FAQ를 새로 등록하시려면 FAQ관리</a> 메뉴를 이용하십시오.';
                    echo '</div>';
                }
            }
            ?>
        </div>
        </div>

        <?php echo get_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>
    </div>

    <?php } else { ?>
    <div class="best-keyword-wrap">
        <div class="best-keyword-title">추천검색어</div>
        <?php
            $sql = " select * from {$g5['search_tag_table']}";
            $tag = sql_fetch($sql);
        ?>
        <?php 
            for ($i=1; $i<=10; $i++) { 
                if($tag["search_tag_".$i]) {
                echo "<span class=\"best-keyword wow fadeInUp\" data-wow-duration=\"1s\" data-wow-delay=\".".$i."s\" data-wow-offset=\"1\" onclick=\"shopSearchBest('".$tag["search_tag_".$i]."')\">".$tag["search_tag_".$i]."</span>";
                }
            } 
        ?>
    </div>
     


    <?php } ?>

</div>
<!-- } 검색 끝 -->
</div>
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


var shopSearchBest = function shopSearchBest(text) {
    var url = "<?php echo G5_SHOP_URL ?>/search.php?q=" + text
    window.location.href=url;
}
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
</script>