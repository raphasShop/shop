<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<header>
    <div class="mo_page_title_wrap"><a href="javascript:history.back();"><img src="<?php echo G5_IMG_URL; ?>/title_back.png" title=""></a> 나의 리뷰 내역</div>
</header>

<div id="my_review_list_wrap">
    <a href="<?php echo G5_SHOP_URL ?>/orderlist.php"><div class="my_review_list_write_btn">리뷰작성하기</div></a>
    <div class="my_review_list_cnt">총 <?php echo $total_count; ?>개</div>
</div>
<div class="my_review_list_con_wrap">

<!-- 전체 상품 사용후기 목록 시작 { -->
<form method="get" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" style="display: none">
<div id="sps_sch">
    <div class="sch_wr">
        <label for="sfl" class="sound_only">검색항목</label>
        <select name="sfl" id="sfl" required>
            <option value="">선택</option>
            <option value="b.it_name"   <?php echo get_selected($sfl, "b.it_name"); ?>>상품명</option>
            <option value="a.it_id"     <?php echo get_selected($sfl, "a.it_id"); ?>>상품코드</option>
            <option value="a.is_subject"<?php echo get_selected($sfl, "a.is_subject"); ?>>후기제목</option>
            <option value="a.is_content"<?php echo get_selected($sfl, "a.is_content"); ?>>후기내용</option>
            <option value="a.is_name"   <?php echo get_selected($sfl, "a.is_name"); ?>>작성자명</option>
            <option value="a.mb_id"     <?php echo get_selected($sfl, "a.mb_id"); ?>>작성자아이디</option>
        </select>
        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" required class="sch_input" size="10">
        <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">검색</span></button>
    </div>
    <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>">전체보기</a>

</div>
</form>

<div id="sit_use_list">

    <!-- <p><?php echo $config['cf_title']; ?> 전체 사용후기 목록입니다.</p> -->

    <?php
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

        if($row['mb_id']) $is_name = $row['mb_id'];

    ?>
       
        <li class="sit_use_li content-area">
            <button type="button" class="sit_use_li_title"><?php echo $it_name; ?></button>
            <span class="sit_use_img"><?php if($imgs) { ?><img src="<?php echo $imgs;?>"><? }?></span>
            <dl class="sit_use_dl">
                <dt>작성자</dt>
                <dd class="sit_use_name"><?php echo $is_name; ?></dd>
                <dt>작성일</dt>
                <dd class="sit_use_date"><?php echo $is_time; ?></dd>
            </dl>
            <dl class="sit_use_dl">
                <dt>별</dt>
                <dd style="margin:20px 0"><?php echo get_star_icon($is_star); ?></dd>
                
            </dl>
            <dl class="sit_use_dl">
                <dt>리뷰</dt>
                <dd class="sit_use_content"><?php echo $mod_content ?></dd>
            </dl>
            

            <div id="sit_use_con_<?php echo $i; ?>" class="sit_use_con">
                <div class="sit_use_p">
                    <?php echo $is_content; // 사용후기 내용 ?>
                </div>

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

    if (!$i) { ?>
        <div class="my_review_list_none">
            <img src="<?php echo G5_IMG_URL; ?>/empty_icon.png">
            <div class="empty_table">작성하신 리뷰가 없습니다.<br>첫 리뷰를 작성해주세요.</div>
        </div>
    <?php } ?>
</div>

<?php echo get_paging($config['cf_mobile_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>
<div class="blank-bottom"></div>
<script>
$(function(){
    // 사용후기 더보기
    $(".sps_con_btn button").click(function(){
        var $con = $(this).parent().prev();
        if($con.is(":visible")) {
            $con.slideUp();
            $(this).html("내용보기 <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i>");
        } else {
            $(".sps_con_btn button").html("내용보기 <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i>");
            $("div[id^=sps_con]:visible").hide();
            $con.slideDown(
                function() {
                    // 이미지 리사이즈
                    $con.viewimageresize2();
                }
            );
            $(this).html("내용닫기 <i class=\"fa fa-caret-up\" aria-hidden=\"true\"></i>");
        }
    });
});
</script>
<!-- } 전체 상품 사용후기 목록 끝 -->