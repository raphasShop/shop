<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 2;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<div id="customer_wrap">
    <div class="customer_top_tab_wrap">
        <a href="<?php echo G5_BBS_URL ?>/faq.php"><div class="customer_top_tab top_tab_left eng_font">FAQ</div></a>
        <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=notice"><div class="customer_top_tab top_tab_select top_tab_center">공지사항</div></a>
        <a href="<?php echo G5_BBS_URL ?>/qawrite.php"><div class="customer_top_tab top_tab_right">1:1 문의</div></a>
    </div>
    <div class="customer_back_wrap">
        <div class="notice_list_con_wrap">

            <?php if ($rss_href || $write_href) { ?>
            <ul class="<?php echo isset($view) ? 'view_is_list btn_top' : 'btn_top top';?>" style="display: none">
                <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01"><i class="fa fa-rss" aria-hidden="true"></i><span class="sound_only">RSS</span></a></li><?php } ?>
                <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin"><i class="fa fa-user-circle" aria-hidden="true"></i><span class="sound_only">관리자</span></a></li><?php } ?>
                <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02"><i class="fa fa-pencil" aria-hidden="true"></i> 글쓰기</a></li><?php } ?>
            </ul>
            <?php } ?>
            <!-- 게시판 목록 시작 -->
            <div id="bo_list">

                <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
                <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
                <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                <input type="hidden" name="stx" value="<?php echo $stx ?>">
                <input type="hidden" name="spt" value="<?php echo $spt ?>">
                <input type="hidden" name="sst" value="<?php echo $sst ?>">
                <input type="hidden" name="sod" value="<?php echo $sod ?>">
                <input type="hidden" name="page" value="<?php echo $page ?>">
                <input type="hidden" name="sw" value="">

                <div class="list_01">
                    <ul>
                        <?php
                        for ($i=0; $i<count($list); $i++) {
                        ?>
                        <li class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
                            <?php if ($is_checkbox) { ?>
                            <div class="bo_chk">
                                <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
                            </div><?php } ?>

                            <div class="bo_subject">

                                <?php
                                if ($is_category && $list[$i]['ca_name']) {
                                ?>
                                <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
                                <?php } ?>

                                <a href="<?php echo $list[$i]['href'] ?>" class="bo_subject">
                                    <?php echo $list[$i]['icon_reply']; ?>
                                    <?php if ($list[$i]['is_notice']) { ?><div class="icon_wrap"><i class="xi-volume-down" aria-hidden="true"></i></div><?php } ?> 
                                    <?php echo $list[$i]['subject'] ?>
                                    <?php
                                    // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }
                                    ?>
                                </a>

                            </div>
                            <div class="bo_info">
                                <span class="write_date"><?php echo $list[$i]['datetime'] ?></span>                            
                            </div>
                            
                        </li><?php } ?>
                        <?php if (count($list) == 0) { echo '<li class="empty_table">게시물이 없습니다.</li>'; } ?>
                    </ul>
                </div>

                <?php if ($list_href || $is_checkbox || $write_href) { ?>
                <div class="bo_fx" style="display: none;">
                    <ul class="btn_bo_adm">
                        <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a></li><?php } ?>
                    </ul>
                </div>
                <?php } ?>
                </form>
                <?php echo $write_pages; ?>
            </div>
        </div>
    </div>
</div>


<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->


<fieldset id="bo_sch" style="display: none">
    <legend>게시물 검색</legend>

    <form name="fsearch" method="get">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sop" value="and">
    <label for="sfl" class="sound_only">검색대상</label>
    <select name="sfl" id="sfl">
        <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
        <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
        <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
        <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
        <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
        <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
        <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
    </select>
    <input name="stx" value="<?php echo stripslashes($stx) ?>" placeholder="검색어(필수)" required id="stx" class="sch_input" size="15" maxlength="20">
    <button type="submit" value="검색" class="sch_btn"><i class="fa fa-search" aria-hidden="true"></i> <span class="sound_only">검색</span></button>
    </form>
</fieldset>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == 'copy')
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- 게시판 목록 끝 -->
