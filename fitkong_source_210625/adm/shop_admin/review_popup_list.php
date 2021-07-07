<?php
$sub_menu = '155601'; /* 수정전 원본 메뉴코드 500500 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '리뷰팝업관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$sql_common = " from {$g5['g5_shop_review_popup_table']} ";
if($it_id) {
    $sql_common .= " where it_id = '$it_id' ";
}

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
?>
<!--
<div class="btn_add01 btn_add">
    <a href="./bannerform.php"><i class="fa fa-plus"></i> 메인배너+날개배너추가</a>
</div>
-->

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">
    <div class="bq_basic_add">
    <a href="./review_popup_form.php"><i class="fa fa-plus"></i> 리뷰추가</a>
    </div>
</div>
<!--//-->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <div class="totallist"><strong><?php echo number_format($total_count) ?></strong> 개의 리뷰가 검색되었습니다</div>
</div>
<!-- // -->

<div class="tbl_head02 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" id="th_id">ID</th>
        <th scope="col" id="th_name">상품명</th>
        <th scope="col" id="th_img">이미지</th>
        <th scope="col" id="th_dvc">제목</th>
        <th scope="col" id="th_loc">내용</th>
        <th scope="col" id="th_st">채널</th>
        <th scope="col" id="th_end">작성자</th>
        <th scope="col" id="th_odr">노출여부</th>
        <th scope="col" id="th_mng">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sql = " select * from {$g5['g5_shop_review_popup_table']}
          order by rvp_id desc
          limit $from_record, $rows  ";

    if($it_id) {
       $sql = " select * from {$g5['g5_shop_review_popup_table']}
          where it_id = '$it_id' 
          order by rvp_id desc
          limit $from_record, $rows  ";
    }
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        // 테두리 있는지
        //$bn_border  = $row['bn_border'];
        // 새창 띄우기인지
        //$bn_new_win = ($row['bn_new_win']) ? 'target="_blank"' : '';
        $width = 100;
        $rvp_img = '<img src="'.get_text($row['rvp_img_url']).'" width="'.$width.'" alt="'.get_text($row['rvp_alt']).'">';
        
        switch($row['rvp_use']) {
            case '1':
                $rvp_use = '노출중';
                break;
            case '0':
                $rvp_use = '노출중지';
                break;
            default:
                $rvp_use = '노출중';
                break;
        }

        $rvp_begin_time = substr($row['rvp_begin_time'], 2, 14);
        $rvp_end_time   = substr($row['rvp_end_time'], 2, 14);
        $rvp_pid = $row['it_id'];

        $sql = " select * from {$g5['g5_shop_item_table']}
          where it_id = '$rvp_pid' ";
        $shopitem = sql_fetch($sql);

        $bg = 'bg'.($i%2);

        $itemlink = '<a href="'.G5_ADMIN_URL.'/shop_admin/review_popup_list.php?it_id='.$row['it_id'].'">'.$shopitem['it_name'].'</a>';

    ?>

    <tr class="<?php echo $bg; ?>">
        <td headers="th_id"><?php echo $row['rvp_id']; ?></td>
        <td headers="th_name"><?php echo $itemlink; ?></td>
        <td headers="th_img"><?php echo $rvp_img; ?></td>
        <td headers="th_loc"><?php echo $row['rvp_title']; ?></td>
        <td headers="th_loc"><?php echo $row['rvp_contents']; ?></td>
        <td headers="th_loc"><?php echo $row['rvp_channel']; ?></td>
        <td headers="th_loc"><?php echo $row['rvp_reviewer']; ?></td>
        <td headers="th_mng"><?php echo $rvp_use; ?></td>
        <td headers="th_mng" class="td_mngsmall">
            <a href="./review_popup_form.php?w=u&amp;rvp_id=<?php echo $row['rvp_id']; ?>">수정</a></li>
            <a href="./review_popup_update.php?w=d&amp;rvp_id=<?php echo $row['rvp_id']; ?>" onclick="return delete_confirm(this);">삭제</a>
        </td>
    </tr>
  
    <?php
    }
    if ($i == 0) {
    echo '<tr><td colspan="8" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>

</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
$(function() {
    $(".sbn_img_view").on("click", function() {
        $(this).closest(".td_img_view").find(".sbn_image").slideToggle();
    });
});
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
