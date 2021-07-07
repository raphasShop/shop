<?php
$sub_menu = '155703'; 

include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$title = '핏콩미식회관리';
$g5['title'] = $title;

include_once (G5_ADMIN_PATH.'/admin.head.php');

//$position = $_GET['position'];
//$device =  $_GET['device'];

$sql_common = " from {$g5['g5_shop_dainty_table']} ";

//$sql_common .= " where bn_position = '$position'";    


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
    <a href="./daintyform.php"><i class="fa fa-plus"></i> 핏콩미식회컨텐츠추가</a>
    </div>
</div>
<!--//-->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <div class="totallist"><strong><?php echo number_format($total_count) ?></strong> 개의 컨텐츠가 검색되었습니다</div>
</div>
<!-- // -->

<div class="tbl_head02 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" id="th_id">ID</th>
        <th scope="col" id="th_id">썸네일</th>
        <th scope="col" id="th_tit">컨텐츠제목</th>
        <th scope="col" id="th_dvc">접속기기</th>
        <th scope="col" id="th_use">사용여부</th>
        <th scope="col" id="th_mng">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sql = " select * from {$g5['g5_shop_dainty_table']}
          order by co_order, co_id desc
          limit $from_record, $rows  ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        // 테두리 있는지
        $co_border  = $row['co_border'];
        // 새창 띄우기인지
        $co_url = $row['co_url'];
        $bimg = G5_DATA_PATH.'/dainty/'.$row['co_id'];
        if(file_exists($bimg)) {
            $size = @getimagesize($bimg);
            if($size[0] && $size[0] > 800)
                $width = 800;
            else
                $width = $size[0];

            $co_img = "";
            if ($row['co_url'] && $row['co_img_url'] != "http://")
                $co_img .= '<a href="'.$row['co_url'].'" target="_blank">';
            $co_img .= '<img src="'.G5_DATA_URL.'/dainty/'.$row['co_id'].'" width="'.$width.'" alt="'.get_text($row['co_alt']).'"></a>';
            $co_thum = '<img src="'.G5_DATA_URL.'/dainty/'.$row['co_id'].'" width="80%" alt="'.get_text($row['co_alt']).'"></a>';
        } else {
            $co_img = "";
            if ($row['co_url'] != "http://")
                $co_img .= '<a href="'.$row['co_url'].'" target="_blank">';
            $co_img .= '<img src="'.$row['co_img_url'].'" width="'.$width.'" alt="'.get_text($row['co_alt']).'"></a>';
            $co_thum = '<img src="'.$row['co_img_url'].'" width="80%" alt="'.get_text($row['co_alt']).'"></a>';
        }

        switch($row['co_device']) {
            case 'pc':
                $co_device = 'PC';
                break;
            case 'mobile':
                $co_device = '모바일';
                break;
            default:
                $co_device = 'PC와 모바일';
                break;
        }

        if($row['co_use'] == 1) 
            $co_use = '사용중';
        else 
            $co_use = '사용안함';

        //$co_begin_time = substr($row['bn_begin_time'], 2, 14);
        //$co_end_time   = substr($row['bn_end_time'], 2, 14);

        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td headers="th_id" class="td_num"><?php echo $i+1; ?></td>
        <td headers="th_img" class="td_num"><div><?php echo $co_thum; ?></div></td>
        <td headers="th_title"><?php echo $row['co_title']; ?></td>
        <td headers="th_device" class="td_num"><?php echo $row['co_device']; ?></td>
        <td headers="th_use" class="td_num"><?php echo $co_use; ?></td>
        <td headers="th_mng" class="td_mngsmall">
            <a href="./daintyform.php?w=u&amp;co_id=<?php echo $row['co_id']; ?>">수정</a></li>
            <a href="./daintyformupdate.php?w=d&amp;co_id=<?php echo $row['co_id']; ?>" onclick="return delete_confirm(this);">삭제</a>
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
