<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$faq_skin_url.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<!-- FAQ 시작 { -->
<?php
// 상단 HTML
echo '<div id="faq_hhtml">'.conv_content($fm['fm_mobile_head_html'], 1).'</div>';
?>


<div id="customer_wrap">
    <div class="customer_top_tab_wrap">
        <a href="<?php echo G5_BBS_URL ?>/faq.php"><div class="customer_top_tab top_tab_select top_tab_left eng_font">FAQ</div></a>
        <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=notice"><div class="customer_top_tab top_tab_center">공지사항</div></a>
        <a href="<?php echo G5_BBS_URL ?>/qawrite.php"><div class="customer_top_tab top_tab_right">1:1 문의</div></a>
    </div>
    <div class="customer_back_wrap">
        <div class="faq_list_cate_wrap">
            <a href="<?php echo G5_BBS_URL ?>/faq.php?fm_id=1"><div class="faq_list_cate"><img src="<?php echo G5_IMG_URL ?>/faq_membership<?php if($fm_id == '1') echo '_on'; ?>.png"></div></a><a href="<?php echo G5_BBS_URL ?>/faq.php?fm_id=2"><div class="faq_list_cate_end"><img src="<?php echo G5_IMG_URL ?>/faq_order<?php if($fm_id == '2') echo '_on'; ?>.png"></div></a>
        </div>
        <div class="faq_list_cate_wrap">
            <a href="<?php echo G5_BBS_URL ?>/faq.php?fm_id=3"><div class="faq_list_cate"><img src="<?php echo G5_IMG_URL ?>/faq_delivery<?php if($fm_id == '3') echo '_on'; ?>.png"></div></a><a href="<?php echo G5_BBS_URL ?>/faq.php?fm_id=4"><div class="faq_list_cate_end"><img src="<?php echo G5_IMG_URL ?>/faq_refund<?php if($fm_id == '4') echo '_on'; ?>.png"></div></a>
        </div>
        <div class="faq_list_con_wrap">

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
                            <h3><a href="#none" onclick="return faq_open(this);"><img src="<?php echo G5_IMG_URL ?>/faq_q.png" class="faq_list_icon_q"><?php echo conv_content($v['fa_subject'], 1); ?></a></h3>
                            <div class="faq_icon-down"><img src="<?php echo G5_IMG_URL ?>/faq_down.png"></div>
                            <div class="faq_icon-up"><img src="<?php echo G5_IMG_URL ?>/faq_up.png"></div>
                            <div class="con_inner">
                                <img src="<?php echo G5_IMG_URL ?>/faq_a.png" class="faq_list_icon_a"><?php echo conv_content($v['fa_content'], 1); ?>
                                
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
                        echo '<p class="empty_list">검색된 게시물이 없습니다.</p>';
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
    </div>
</div>

<?php echo get_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>

<?php
// 하단 HTML
echo '<div id="faq_thtml">'.conv_content($fm['fm_mobile_tail_html'], 1).'</div>';
?>


<!-- } FAQ 끝 -->

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<script>
$(function() {
    $(".closer_btn").on("click", function() {
        $(this).closest(".con_inner").slideToggle();
    });
});

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
        $con.slideDown(
            function() {
                // 이미지 리사이즈
                $con.viewimageresize2();
            }
        );
    }

    return false;
}
</script>