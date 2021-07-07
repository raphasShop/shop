<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>
<header>
    <div class="mo_page_title_wrap"><a href="javascript:history.back();"><img src="<?php echo G5_IMG_URL; ?>/title_back.png" title=""></a> 리뷰 작성하기</div>
</header>
<!-- 사용후기 쓰기 시작 { -->
<div id="review_write_wrap">
    <div class="review_write_con_wrap">
        <div id="sit_use_write">
            <div class="use_write_item_wrap">
                <?php
                    $sql = " select *
                                from {$g5['g5_shop_item_table']}
                                where it_id = '$it_id'
                                limit 1 ";
                    $it = sql_fetch($sql);
                    $image = get_it_image($it['it_id'],80, 80);
                ?>
                <div class="use_write_item_image"><?php echo $image; ?></div>
                <div class="use_write_item_name"><?php echo stripslashes($it['it_name']); ?></div>
            </div>
            
            <form name="fitemuse" method="post" action="./itemuseformupdate.php" onsubmit="return fitemuse_submit(this);" autocomplete="off">
            <input type="hidden" name="w" value="<?php echo $w; ?>">
            <input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
            <input type="hidden" name="od_id" value="<?php echo $od_id; ?>">
            <input type="hidden" name="is_id" value="<?php echo $is_id; ?>">
            <input type="hidden" name="is_mobile_shop" value="1">
            <input type="hidden" name="ps" value="<?php echo $ps; ?>">
            <?php $use['is_subject'] = '모바일 리뷰'; ?>
            <div class="form_01">

                <ul>
                    <li>
                        <label for="is_subject" class="sound_only">제목</label>
                        <input type="hidden" name="is_subject" value="<?php echo get_text($use['is_subject']); ?>" id="is_subject" required class="required frm_input" minlength="2" maxlength="250" placeholder="제목">
                    </li>
                    <li class="use_write_star_wrap">
                        <input type="hidden" id="is_score" name="is_score" value="<?php echo $is_score; ?>">
                        <div class="use_write_star_title">별점을 매겨주세요.</div>
                        <div class="use_write_star_select_wrap">
                            <div class="use_write_star" id="star_1" onclick="use_star_select(1);"> <img src="<?php echo G5_IMG_URL; ?>/rv_star_10.png"></div>
                            <div class="use_write_star" id="star_2" onclick="use_star_select(2);"> <img src="<?php echo G5_IMG_URL; ?>/rv_star_10.png"></div>
                            <div class="use_write_star" id="star_3" onclick="use_star_select(3);"> <img src="<?php echo G5_IMG_URL; ?>/rv_star_10.png"></div>
                            <div class="use_write_star" id="star_4" onclick="use_star_select(4);"> <img src="<?php echo G5_IMG_URL; ?>/rv_star_10.png"></div>
                            <div class="use_write_star" id="star_5" onclick="use_star_select(5);"> <img src="<?php echo G5_IMG_URL; ?>/rv_star_10.png"></div>

                            <div class="use_write_star" id="star_1_w" onclick="use_star_select(2);"> <img src="<?php echo G5_IMG_URL; ?>/rv_star_0.png"></div>
                            <div class="use_write_star" id="star_2_w" onclick="use_star_select(3);"> <img src="<?php echo G5_IMG_URL; ?>/rv_star_0.png"></div>
                            <div class="use_write_star" id="star_3_w" onclick="use_star_select(4);"> <img src="<?php echo G5_IMG_URL; ?>/rv_star_0.png"></div>
                            <div class="use_write_star" id="star_4_w" onclick="use_star_select(5);"> <img src="<?php echo G5_IMG_URL; ?>/rv_star_0.png"></div>
                        </div>

                    </li>
                    <li>
                        <span class="sound_only">내용</span>
                        <?php echo $editor_html; ?>
                    </li>
                    
                </ul>
            </div>

            <div class="use_write_btn">
                <input type="submit" value="작성완료" class="btn_submit">
            </div>

            </form>
        </div>
    </div>  
</div>
<script type="text/javascript">
function fitemuse_submit(f)
{
    <?php echo $editor_js; ?>

    return true;
}

function use_star_select(score)
{
    
    if(score == 5) {
        $('#star_4_w').css('display', 'none');
        $('#star_3_w').css('display', 'none');
        $('#star_2_w').css('display', 'none');
        $('#star_1_w').css('display', 'none');
        $('#star_1').css('display', 'inline-block');
        $('#star_2').css('display', 'inline-block');
        $('#star_3').css('display', 'inline-block');
        $('#star_4').css('display', 'inline-block');
        $('#star_5').css('display', 'inline-block');
        $('#is_score').val('5');
    } else if(score == 4) {
        $('#star_4_w').css('display', 'inline-block');
        $('#star_3_w').css('display', 'none');
        $('#star_2_w').css('display', 'none');
        $('#star_1_w').css('display', 'none');
        $('#star_1').css('display', 'inline-block');
        $('#star_2').css('display', 'inline-block');
        $('#star_3').css('display', 'inline-block');
        $('#star_4').css('display', 'inline-block');
        $('#star_5').css('display', 'none');
        $('#is_score').val('4');
    } else if(score == 3) {
        $('#star_4_w').css('display', 'inline-block');
        $('#star_3_w').css('display', 'inline-block');
        $('#star_2_w').css('display', 'none');
        $('#star_1_w').css('display', 'none');
        $('#star_1').css('display', 'inline-block');
        $('#star_2').css('display', 'inline-block');
        $('#star_3').css('display', 'inline-block');
        $('#star_4').css('display', 'none');
        $('#star_5').css('display', 'none');
        $('#is_score').val('3');
    } else if(score == 2) {
        $('#star_4_w').css('display', 'inline-block');
        $('#star_3_w').css('display', 'inline-block');
        $('#star_2_w').css('display', 'inline-block');
        $('#star_1_w').css('display', 'none');
        $('#star_1').css('display', 'inline-block');
        $('#star_2').css('display', 'inline-block');
        $('#star_3').css('display', 'none');
        $('#star_4').css('display', 'none');
        $('#star_5').css('display', 'none');
        $('#is_score').val('2');
    } else if(score == 1) {
        $('#star_4_w').css('display', 'inline-block');
        $('#star_3_w').css('display', 'inline-block');
        $('#star_2_w').css('display', 'inline-block');
        $('#star_1_w').css('display', 'inline-block');
        $('#star_1').css('display', 'inline-block');
        $('#star_2').css('display', 'none');
        $('#star_3').css('display', 'none');
        $('#star_4').css('display', 'none');
        $('#star_5').css('display', 'none');
        $('#is_score').val('1');
    }

    return true;
}

</script>
<!-- } 사용후기 쓰기 끝 -->