<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<?php if($is_admin) { ?>
<div id="sit_use_wbtn">
    <a href="<?php echo $itemuse_form; ?>" class="qa_wr itemuse_form " onclick="return false;">사용후기 쓰기<span class="sound_only"> 새 창</span></a>
    <a href="<?php echo $itemuse_list; ?>" id="itemuse_list" class="btn01">더보기</a>
</div>
<?php } ?>
<div class="sit_use_notice">상품 리뷰 작성은 실구매고객만 작성이 가능합니다.<br>마이페이지의 <span>배송완료</span> 상품을 선택하세요.</div>
<div class="sit_use_reply_btn_wrap">
    <a href="./itemuse.php?it_id=<?php echo $it_id; ?>&photo=n" class="review_menu"><div class="sit_use_reply_btn <?php if($photo_review != y) echo 'current'; ?>">모든 리뷰 (<?php echo $total_count1; ?>)</div></a><a href="./itemuse.php?it_id=<?php echo $it_id; ?>&photo=y" class="review_menu"><div class="sit_use_reply_btn_last <?php if($photo_review == y) echo 'current'; ?>">포토 리뷰(<?php echo $total_count2; ?>)</a></div>
</div>
<!-- 상품 사용후기 시작 { -->
<div id="sit_use_list">

    <?php
    $thumbnail_width = 500;

    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $is_num     = $total_count - ($page - 1) * $rows - $i;
        $is_star    = get_star($row['is_score']);
        $is_name    = get_text($row['is_name']);
        $is_mb_id    = get_text($row['mb_id']);
        $is_subject = conv_subject($row['is_subject'],50,"…");
        //$is_content = ($row['wr_content']);
        $is_content = get_view_thumbnail(conv_content($row['is_content'], 1), $thumbnail_width);
        $is_reply_name = !empty($row['is_reply_name']) ? get_text($row['is_reply_name']) : '';
        $is_reply_subject = !empty($row['is_reply_subject']) ? conv_subject($row['is_reply_subject'],50,"…") : '';
        $is_reply_content = !empty($row['is_reply_content']) ? get_view_thumbnail(conv_content($row['is_reply_content'], 1), $thumbnail_width) : '';
        $is_time    = substr($row['is_time'], 2, 8);
        $is_href    = './itemuselist.php?bo_table=itemuse&amp;wr_id='.$row['wr_id'];

        $pattern = "/<img.*?src=[\"']?(?P<url>[^(http)].*?)[\"' >]/i";
        preg_match_all($pattern,stripslashes(str_replace('&','&',$is_content)), $matches);
        $img_count = count($matches['url']);
        $imgs = substr($matches['url'][0],1);

        $mod_content = strip_tags($is_content);

        $hash = md5($row['is_id'].$row['is_time'].$row['is_ip']);

        if ($i == 0) echo '<ol id="sit_use_ol">';

        $it_id = get_text($row['it_id']);
        $it_name = get_item_name($it_id); 

        $time = time();
        $code = $time.$i;

    ?>
        <?php if($imgs) { ?> 
        <div id="ex<?php echo $code ?>" class="modal" style="max-height: 70%; overflow-y:scroll !important; ">
            <?php for ($j=0; $j<$img_count; $j++) { 
                $full_imgs = substr($matches['url'][$j],1);
                $full_imgs = get_view_thumbnail($full_imgs, 640);
            ?>
            <img src="<?php echo $full_imgs;?>" style="width:640px;height:auto">
            <?php } ?>
            <div class="modal-content"><?php echo $mod_content; ?></div>
        </div>
         
        <?php } ?>
        <a href="#ex<?php echo $code ?>" rel="modal:open"> 
        <li class="sit_use_li">
            <button type="button" class="sit_use_li_title"><?php echo $it_name; ?></button>
            <span class="sit_use_img">
                <?php if($imgs) { ?>
                    <img src="<?php echo $imgs;?>">
                    <?php if($img_count >= 2) { ?><img src="<?php $im = substr($matches['url'][1],1); echo get_view_thumbnail($im, 320);?>"> <?php } ?>
                    <?php if($img_count >= 3) { ?><img src="<?php $im = substr($matches['url'][2],1); echo get_view_thumbnail($im, 320);?>"> <?php } ?>
                <?php } ?>
            </span>
            <dl class="sit_use_dl">
                <dt>별</dt>
                <dd><?php echo get_star_icon($is_star); ?></dd>
                
            </dl>
            <dl class="sit_use_dl">
                <dt>리뷰</dt>
                <dd class="sit_use_content"><?php echo $mod_content ?></dd>
            </dl>
            <dl class="sit_use_dl">
                <dt>작성자</dt>
                <dd class="sit_use_name"><?php if($is_mb_id == 'administrator' || $is_mb_id == '') echo $is_name; else echo $is_mb_id; ?></dd>
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
        </a>
    <?php }

    if ($i > 0) echo '</ol>';

    if (!$i) echo '<div class="sit_empty"><img src="'.G5_IMG_URL.'/shop-reviewempty.png" alt=""><p class="sit_empty_message">상품리뷰가 없습니다.</p></div>';    ?>
</div>

<?php
echo itemuse_page($config['cf_mobile_pages'], $page, $total_page, "./itemuse.php?it_id=$it_id&amp;photo=$photo_review&amp;page=", "");
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<script>


var freezeVp = function(e) {
    e.preventDefault();
};

function stopBodyScrolling (bool) {
    if (bool === true) {
        document.body.addEventListener("touchmove", freezeVp, false);
    } else {
        document.body.removeEventListener("touchmove", freezeVp, false);
    }
}
$(function(){

    $('.modal').on($.modal.OPEN, function(event, modal) {
        $('html').css("overflow","hidden");
        stopBodyScrolling(true);

    });

    $('.modal').on($.modal.CLOSE, function(event, modal) {
        $('html').css("overflow","");
        stopBodyScrolling(false);
    });

    $(".itemuse_form").click(function(){
        window.open(this.href, "itemuse_form", "width=810,height=680,scrollbars=1");
        return false;
    });

    $(".itemuse_delete").click(function(){
        if (confirm("정말 삭제 하시겠습니까?\n\n삭제후에는 되돌릴수 없습니다.")) {
            return true;
        } else {
            return false;
        }
    });

    $(".sit_use_li_title").click(function(){
        var $con = $(this).siblings(".sit_use_con");
        if($con.is(":visible")) {
            $con.slideUp();
        } else {
            $(".sit_use_con:visible").hide();
            $con.slideDown(
                function() {
                    // 이미지 리사이즈
                    $con.viewimageresize2();
                }
            );
        }
    });

    $(".pg_page").click(function(){
        $("#itemuse").load($(this).attr("href"));
        return false;
    });

    $("a#itemuse_list").on("click", function() {
        window.opener.location.href = this.href;
        self.close();
        return false;
    });

    $(".review_menu").click(function(){
        $("#itemuse").load($(this).attr("href"));
        return false;
    });
});
</script>
<!-- } 상품 사용후기 끝 -->