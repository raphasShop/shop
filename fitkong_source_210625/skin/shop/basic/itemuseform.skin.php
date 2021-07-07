<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<div id="shop_order_wrap">
    <div class="shop_con_wrap"> 
        <!-- 사용후기 쓰기 시작 { -->
        <div id="sit_use_write">
            <div class="use_write_title">리뷰 작성하기</div>
            <div class="use_write_item_wrap">
                <?php
                    $sql = " select *
                                from {$g5['g5_shop_item_table']}
                                where it_id = '$it_id'
                                limit 1 ";
                    $it = sql_fetch($sql);
                    $image = get_it_image($it['it_id'],100, 100);
                ?>
                <div class="use_write_item_image"><?php echo $image; ?></div>
                <div class="use_write_item_name"><?php echo stripslashes($it['it_name']); ?></div>
            </div>
            
            <form name="fitemuse" method="post" action="./itemuseformupdate.php" onsubmit="return fitemuse_submit(this);" autocomplete="off">
            <input type="hidden" name="w" value="<?php echo $w; ?>">
            <input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
            <input type="hidden" name="od_id" value="<?php echo $od_id; ?>">
            <input type="hidden" name="is_id" value="<?php echo $is_id; ?>">
            <input type="hidden" name="ps" value="<?php echo $ps; ?>">

            <?php $use['is_subject'] = 'PC 리뷰'; ?>
            <div class="form_01">

                <ul>
                    <li>
                        <label for="is_subject" class="sound_only">제목<strong> 필수</strong></label>
                        <input type="hidden" name="is_subject" value="<?php echo get_text($use['is_subject']); ?>" id="is_subject" required class="required frm_input full_input"  maxlength="250" placeholder="제목" >
                    </li>
                    <li class="use_write_star_wrap">
                        <input type="hidden" id="is_score" name="is_score" value="<?php echo $is_score; ?>">
                        <div class="use_write_star_title">별점을 매겨주세요.</div>
                        <div class="use_write_star_select_wrap">
                            <div class="use_write_star" id="star_1" onclick="use_star_select(1);"> <img src="<?php echo G5_IMG_URL; ?>/review_all_star.png"></div>
                            <div class="use_write_star" id="star_2" onclick="use_star_select(2);"> <img src="<?php echo G5_IMG_URL; ?>/review_all_star.png"></div>
                            <div class="use_write_star" id="star_3" onclick="use_star_select(3);"> <img src="<?php echo G5_IMG_URL; ?>/review_all_star.png"></div>
                            <div class="use_write_star" id="star_4" onclick="use_star_select(4);"> <img src="<?php echo G5_IMG_URL; ?>/review_all_star.png"></div>
                            <div class="use_write_star" id="star_5" onclick="use_star_select(5);"> <img src="<?php echo G5_IMG_URL; ?>/review_all_star.png"></div>

                            <div class="use_write_star" id="star_1_w" onclick="use_star_select(2);"> <img src="<?php echo G5_IMG_URL; ?>/review_all_star_blank.png"></div>
                            <div class="use_write_star" id="star_2_w" onclick="use_star_select(3);"> <img src="<?php echo G5_IMG_URL; ?>/review_all_star_blank.png"></div>
                            <div class="use_write_star" id="star_3_w" onclick="use_star_select(4);"> <img src="<?php echo G5_IMG_URL; ?>/review_all_star_blank.png"></div>
                            <div class="use_write_star" id="star_4_w" onclick="use_star_select(5);"> <img src="<?php echo G5_IMG_URL; ?>/review_all_star_blank.png"></div>
                        </div>

                    </li>
                    <li class="use_write_contents_wrap">
                        <strong  class="sound_only">내용</strong>
                        
                        <?php echo $editor_html; ?>
                        <!--<div class="use_contents_title">내용</div>
                        <textarea id="is_content" name="is_content" maxlength="65536" class="use_write_contents"></textarea>-->
                    </li>
                    <?php if($fileuse) { ?> ?>
                    <li>
                        <div class="use_contents_title">사진첨부</div>
                        <div class="file_wr">
                        <label for="bf_file_1" class="lb_icon"><i class="fa fa-download" aria-hidden="true"></i><span class="sound_only"> 파일 #1</span></label>
                        <input type="file" name="bf_file[1]" id="bf_file_1" title="파일첨부 1 :  용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능" class="frm_file">
                        <?php if($w == 'u' && $write['qa_file1']) { ?>
                        <input type="checkbox" id="bf_file_del1" name="bf_file_del[1]" value="1"> <label for="bf_file_del1"><?php echo $write['qa_source1']; ?> 파일 삭제</label>
                        <?php } ?>
                        </div>
                    </li>
                    <li>
                        <div class="file_wr">
                        <label for="bf_file_2" class="lb_icon"><i class="fa fa-download" aria-hidden="true"></i><span class="sound_only"> 파일 #1</span></label>
                        <input type="file" name="bf_file[2]" id="bf_file_2" title="파일첨부 2 :  용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능" class="frm_file">
                        <?php if($w == 'u' && $write['qa_file2']) { ?>
                        <input type="checkbox" id="bf_file_del2" name="bf_file_del[2]" value="1"> <label for="bf_file_del2"><?php echo $write['qa_source2']; ?> 파일 삭제</label>
                        <?php } ?>
                        </div>
                    </li>
                    <?php } ?>
                </ul>

                <div class="use_write_btn">
                    <a href="<?php echo G5_SHOP_URL ?>/orderlist.php" class="btn_cancel">목록</a>
                    <input type="submit" value="작성완료" class="btn_submit">
                </div>
            </div>

            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
function fitemuse_submit(f)
{
    /*
    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": f.is_subject.value,
            "content": f.is_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (subject) {
        alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
        f.qa_subject.focus();
        return false;
    }

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        if (typeof(ed_qa_content) != "undefined")
            ed_qa_content.returnFalse();
        else
            f.qa_content.focus();
        return false;
    }
    */

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