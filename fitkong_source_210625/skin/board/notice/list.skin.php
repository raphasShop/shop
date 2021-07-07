<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>
<div id="customer_wrap">
    <div class="customer_top_tab_wrap">
        <a href="<?php echo G5_BBS_URL ?>/faq.php"><div class="customer_top_tab eng_font">FAQ</div></a>
        <div class="customer_top_tab_space"></div>
        <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=notice"><div class="customer_top_tab top_tab_select">공지사항</div></a>
        <div class="customer_top_tab_space"></div>
        <a href="<?php echo G5_BBS_URL ?>/qawrite.php"><div class="customer_top_tab">1:1 문의</div></a>
    </div>
    <div class="customer_back_wrap">
        <div class="notice_list_con_wrap">
            <div calss="notice_list_con_icon"><img src="<?php echo G5_IMG_URL ?>/notice_top_icon.png"></div>
            <div class="notice_list_top_msg">핏콩이 전하는 새로운 소식을 만나보세요!</div>
            <!-- 게시판 목록 시작 { -->
            <div id="bo_list" style="width:<?php echo $width; ?>">


                <!-- 게시판 페이지 정보 및 버튼 시작 { -->
                <div id="bo_btn_top">
                  
                    <?php if ($rss_href || $write_href && $is_admin) { ?>
                    <ul class="btn_bo_user">
                        <?php if ($rss_href) { ?><li><a href="<?php echo $rss_href ?>" class="btn_b01 btn"><i class="fa fa-rss" aria-hidden="true"></i> RSS</a></li><?php } ?>
                        <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02 btn">글쓰기</a></li><?php } ?>
                    </ul>
                    <?php } ?>
                </div>
                <!-- } 게시판 페이지 정보 및 버튼 끝 -->

                <!-- 게시판 카테고리 시작 { -->
                <?php if ($is_category) { ?>
                <nav id="bo_cate">
                    <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
                    <ul id="bo_cate_ul">
                        <?php echo $category_option ?>
                    </ul>
                </nav>
                <?php } ?>
                <!-- } 게시판 카테고리 끝 -->

                <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
                <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
                <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                <input type="hidden" name="stx" value="<?php echo $stx ?>">
                <input type="hidden" name="spt" value="<?php echo $spt ?>">
                <input type="hidden" name="sca" value="<?php echo $sca ?>">
                <input type="hidden" name="sst" value="<?php echo $sst ?>">
                <input type="hidden" name="sod" value="<?php echo $sod ?>">
                <input type="hidden" name="page" value="<?php echo $page ?>">
                <input type="hidden" name="sw" value="">

                <div class="tbl_head01 tbl_wrap">
                    <table>
                    <caption><?php echo $board['bo_subject'] ?> 목록</caption>
                    <thead>
                    <tr>
                        <th scope="col">제목</th>
                        <th scope="col"><?php echo subject_sort_link('wr_datetime', $qstr2, 1) ?>작성일</a></th>
                        <th scope="col"><?php echo subject_sort_link('wr_hit', $qstr2, 1) ?>조회</a></th>
                        <?php if ($is_good) { ?><th scope="col"><?php echo subject_sort_link('wr_good', $qstr2, 1) ?>추천 <i class="fa fa-sort" aria-hidden="true"></i></a></th><?php } ?>
                        <?php if ($is_nogood) { ?><th scope="col"><?php echo subject_sort_link('wr_nogood', $qstr2, 1) ?>비추천 <i class="fa fa-sort" aria-hidden="true"></i></a></th><?php } ?>
                        
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    for ($i=0; $i<count($list); $i++) {
                     ?>
                    <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
                       
                       
                        <td class="td_subject" style="padding-left:<?php echo $list[$i]['reply'] ? (strlen($list[$i]['wr_reply'])*10) : '0'; ?>px">
                            <?php
                            if ($is_category && $list[$i]['ca_name']) {
                             ?>
                            <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
                            <?php } ?>
                             <a href="<?php echo $list[$i]['href'] ?>">
                            <div class="bo_tit">
                                
                               
                                    <?php echo $list[$i]['icon_reply'] ?>
                                    <?php 
                                        if (isset($list[$i]['icon_secret'])) echo rtrim($list[$i]['icon_secret']);
                                     ?>
                                     <?php  if ($list[$i]['is_notice']) echo '<strong class="notice_icon"><i class="xi-volume-down" aria-hidden="true"></i><span class="sound_only">공지</span></strong>';
                                     ?>
                                    <?php echo $list[$i]['subject'] ?>
                                   
                                
                               
                                <?php if ($list[$i]['comment_cnt']) { ?><span class="sound_only">댓글</span><span class="cnt_cmt">+ <?php echo $list[$i]['wr_comment']; ?></span><span class="sound_only">개</span><?php } ?>
                            </div>
                            </a>

                        </td>
                        <td class="td_datetime"><?php echo $list[$i]['datetime'] ?></td>
                        <td class="td_hit"><?php echo $list[$i]['wr_hit'] ?></td>
                        <?php if ($is_good) { ?><td class="td_num"><?php echo $list[$i]['wr_good'] ?></td><?php } ?>
                        <?php if ($is_nogood) { ?><td class="td_num"><?php echo $list[$i]['wr_nogood'] ?></td><?php } ?>
                        

                    </tr>
                    <?php } ?>
                    <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
                    </tbody>
                    </table>
                </div>

                

                </form>
                <!-- 페이지 -->
                <?php echo $write_pages;  ?>
              
            </div>
        </div>
    </div>
</div>

</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>






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

    if (sw == "copy")
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
<!-- } 게시판 목록 끝 -->
