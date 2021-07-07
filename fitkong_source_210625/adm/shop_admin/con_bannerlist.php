<?php
$sub_menu = '155801'; /* 수정전 원본 메뉴코드 500500 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '컨텐츠 배너관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$sql_common = " from {$g5['g5_shop_con_banner_table']} ";

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
    <a href="./con_bannerform.php"><i class="fa fa-plus"></i> 컨텐츠배너추가</a>
    </div>
</div>
<!--//-->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <div class="totallist"><strong><?php echo number_format($total_count) ?></strong> 개의 컨텐츠배너가 검색되었습니다</div>
</div>
<!-- // -->

<div class="tbl_head02 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" rowspan="2" id="th_id">ID</th>
        <th scope="col" rowspan="2" id="th_id">썸네일</th>
        <th scope="col" id="th_dvc">접속기기</th>
        <th scope="col" id="th_loc">위치</th>
        <th scope="col" id="th_st">시작일시</th>
        <th scope="col" id="th_end">종료일시</th>
        <th scope="col" id="th_odr">출력순서</th>
        <th scope="col" id="th_hit">조회</th>
        <th scope="col" id="th_use">사용여부</th>
        <th scope="col" id="th_mng">관리</th>
    </tr>
    <tr>
        <th scope="col" colspan="8" id="th_img">이미지</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sql = " select * from {$g5['g5_shop_con_banner_table']}
          order by bn_order, bn_id desc
          limit $from_record, $rows  ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        // 테두리 있는지
        $bn_border  = $row['bn_border'];
        // 새창 띄우기인지
        $bn_new_win = ($row['bn_new_win']) ? 'target="_blank"' : '';

        $bimg = G5_DATA_PATH.'/con_banner/'.$row['bn_id'];
        if(file_exists($bimg)) {
            $size = @getimagesize($bimg);
            if($size[0] && $size[0] > 800)
                $width = 800;
            else
                $width = $size[0];

            $bn_img = "";
            if ($row['bn_url'] && $row['bn_url'] != "http://")
                $bn_img .= '<a href="'.$row['bn_url'].'" '.$bn_new_win.'>';
            $bn_img .= '<img src="'.G5_DATA_URL.'/con_banner/'.$row['bn_id'].'" width="'.$width.'" alt="'.get_text($row['bn_alt']).'"></a>';
            $bn_thum = '<img src="'.G5_DATA_URL.'/con_banner/'.$row['bn_id'].'" width="80%" alt="'.get_text($row['bn_alt']).'"></a>';
        }

        switch($row['bn_device']) {
            case 'pc':
                $bn_device = 'PC';
                break;
            case 'mobile':
                $bn_device = '모바일';
                break;
            default:
                $bn_device = 'PC와 모바일';
                break;
        }

        if($row['bn_use'] == 1) 
            $bn_use = '사용중';
        else 
            $bn_use = '사용안함';

        $bn_begin_time = substr($row['bn_begin_time'], 2, 14);
        $bn_end_time   = substr($row['bn_end_time'], 2, 14);

        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td headers="th_id" rowspan="2" class="td_num"><?php echo $row['bn_id']; ?></td>
        <td headers="th_img" rowspan="2" class="td_num"><div><?php echo $bn_thum; ?></div></td>
        <td headers="th_dvc"><?php echo $bn_device; ?></td>
        <td headers="th_loc"><?php echo $row['bn_position']; ?></td>
        <td headers="th_st" class="td_datetime"><?php echo $bn_begin_time; ?></td>
        
        <td headers="th_end" class="<?php echo ($bn_end_time >= G5_TIME_YMD) ? 'td_datetime_end' : 'td_datetime';//기간여부?>"><?php echo $bn_end_time; ?></td>
        
        <td headers="th_odr" class="td_num"><?php echo $row['bn_order']; ?></td>
        <td headers="th_hit" class="td_num"><?php echo $row['bn_hit']; ?></td>
        <td headers="th_use" class="td_num"><?php echo $bn_use; ?></td>
        <td headers="th_mng" class="td_mngsmall">
            <a href="./con_bannerform.php?w=u&amp;bn_id=<?php echo $row['bn_id']; ?>">수정</a></li>
            <a href="./con_bannerformupdate.php?w=d&amp;bn_id=<?php echo $row['bn_id']; ?>" onclick="return delete_confirm(this);">삭제</a>
        </td>
    </tr>
    <tr class="<?php echo $bg; ?>">
        <td headers="th_img" colspan="8" class="td_img_view sbn_img">
            <div class="sbn_image"><?php echo $bn_img; ?></div>
            <button type="button" class="sbn_img_view btn_frmline">이미지확인</button>
        </td>
    </tr>

    <?php
    }
    if ($i == 0) {
    echo '<tr><td colspan="9" class="empty_table">자료가 없습니다.</td></tr>';
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
