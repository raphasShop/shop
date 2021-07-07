<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
?>
<div id="top_sub_gnb">
    <div class="top_sub_wrap">나의문의내역</div>
    <div class="top_back_btn"><a href="javascript:history.back();"><i class="xi-angle-left"></i></a></div>
</div>
<div id="bo_list">
    <?php if ($category_option) { ?>
    <!-- 카테고리 시작 { --
    <nav id="bo_cate">
        <h2><?php echo $qaconfig['qa_title'] ?> 카테고리</h2>
        <ul id="bo_cate_ul">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <!-- } 카테고리 끝 -->
    <?php } ?>

    <div class="qa_board_wrap">
        <div class="qa_board_title">최근 1년 내 목록만 조회 가능합니다.<br>문의하신 내용에 판매자가 확인 후 답변을 드립니다.</div>
        <?php if ($write_href) { ?>
        <a href="<?php echo $write_href ?>">
            <div class="qa_board_btn">문의하기</div>
        </a>
        <?php } ?>
    </div>

    <?php if ($admin_href || $write_href) { ?>
    <ul class="btn_top top">
        <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn_admin"><i class="fa fa-user-circle" aria-hidden="true"></i><span class="sound_only">관리자</span></a></li><?php } ?>
    </ul>
    <?php } ?>

     <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div class="bo_fx">
        <div id="bo_list_total">
            <span>총 <b><?php echo number_format($total_count) ?></b> 개</span>
        </div>


    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->

    <form name="fqalist" id="fqalist" action="./qadelete.php" onsubmit="return fqalist_submit(this);" method="post">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="sca" value="<?php echo $sca; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">

    <div class="qa_list">
        <ul>
            <?php
            for ($i=0; $i<count($list); $i++) {
            ?>
            <a href="<?php echo $list[$i]['view_href']; ?>" class="li_sbj">
            <li class="bo_li<?php if ($is_checkbox) echo ' bo_adm'; ?>">
                
                <div class="li_title">   
                       [ <?php echo $list[$i]['category']; ?> ] <?php echo $list[$i]['subject']; ?>
                </div>
                <div class="li_info">
                    <?php echo ($list[$i]['qa_status'] ? '<span class="a_ans">답변완료</span>' : '<span class="b_ans">답변대기중</span>'); ?>
                    <span class="sep_line"> | </span>
                    <span><?php echo $list[$i]['date']; ?></span>
                    <span class="sep_line"> | </span>
                    <span><?php echo $list[$i]['name']; ?></span>
                </div>
            </li>
            </a>
            <?php
            }
            ?>

            <?php if ($i == 0) { echo '<li class="empty_list">문의내역이 없습니다.</li>'; } ?>
        </ul>
    </div>

    </form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<?php echo $list_pages;  ?>

<!-- 게시판 검색 시작 { -->
 <?php if ($admin_href) { ?>
<fieldset id="bo_sch">
    <legend>게시물 검색</legend>

    <form name="fsearch" method="get">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
    <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="frm_input required" size="15" maxlength="15">
    <input type="submit" value="검색" class="btn_submit">
    </form>
</fieldset>
<!-- } 게시판 검색 끝 -->
<?php } ?>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fqalist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]")
            f.elements[i].checked = sw;
    }
}

function fqalist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다"))
            return false;
    }

    return true;
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->