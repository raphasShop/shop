<?php
$sub_menu = '155401'; /* 수정전 원본 메뉴코드 100310 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

if( !isset($g5['new_win_table']) ){
    die('<meta charset="utf-8">/data/dbconfig.php 파일에 <strong>$g5[\'new_win_table\'] = G5_TABLE_PREFIX.\'new_win\';</strong> 를 추가해 주세요.');
}
//내용(컨텐츠)정보 테이블이 있는지 검사한다.
if(!sql_query(" DESCRIBE {$g5['new_win_table']} ", false)) {
    if(sql_query(" DESCRIBE {$g5['g5_shop_new_win_table']} ", false)) {
        sql_query(" ALTER TABLE {$g5['g5_shop_new_win_table']} RENAME TO `{$g5['new_win_table']}` ;", false);
    } else {
       $query_cp = sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['new_win_table']}` (
                      `nw_id` int(11) NOT NULL AUTO_INCREMENT,
                      `nw_division` varchar(10) NOT NULL DEFAULT 'both',
                      `nw_device` varchar(10) NOT NULL DEFAULT 'both',
                      `nw_begin_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                      `nw_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                      `nw_disable_hours` int(11) NOT NULL DEFAULT '0',
                      `nw_left` int(11) NOT NULL DEFAULT '0',
                      `nw_top` int(11) NOT NULL DEFAULT '0',
                      `nw_height` int(11) NOT NULL DEFAULT '0',
                      `nw_width` int(11) NOT NULL DEFAULT '0',
					  `nw_padding` int(11) NOT NULL DEFAULT '0',
                      `nw_subject` text NOT NULL,
                      `nw_content` text NOT NULL,
                      `nw_content_html` tinyint(4) NOT NULL DEFAULT '0',
                      PRIMARY KEY (`nw_id`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
    }
}

$g5['title'] = '팝업창(레이어)관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$sql_common = " from {$g5['new_win_table']} ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = "select * $sql_common order by nw_id desc ";
$result = sql_query($sql);
?>
<!--
<div class="btn_add01 btn_add">
    <a href="./newwinform.php"><i class="fa fa-plus fa-lg"></i> 팝업창추가</a>
</div>
-->

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">
    <div class="bq_basic_add">
    <a href="./newwinform.php"><i class="fa fa-plus"></i> 팝업창추가</a>
    </div>
</div>
<!--//-->

<!-- 검색결과표시 -->
<div class="local_desc03 local_desc">
    <div class="totallist"><strong><?php echo number_format($total_count) ?></strong> 개의 팝업창이 검색되었습니다</div>
</div>
<!-- // -->

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">번호</th>
        <th scope="col">제목</th>
        <th scope="col">출력위치</th>
        <th scope="col">접속기기</th>
        <th scope="col">시작일시</th>
        <th scope="col">종료일시</th>
        <th scope="col">시간</th>
        <th scope="col">Left</th>
        <th scope="col">Top</th>
        <th scope="col">Padding</th>
        <th scope="col">Width</th>
        <th scope="col">Height</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $bg = 'bg'.($i%2);
		
		// 팝업진행중/기간종료 테이블색상 class 지정 - 아이스크림
		$td_color = 0;
        if($row['nw_end_time'] >= G5_TIME_YMD) { // 팝업기간이 남은경우
            $bg .= '';
            $td_color = 1;
		} else { // 경과한경우
		    $bg .= 'end';
            $td_color = 1;
		}
        
		//PC 모바일 구분
        switch($row['nw_device']) {
            case 'pc':
                $nw_device = 'PC';
                break;
            case 'mobile':
                $nw_device = '모바일';
                break;
            default:
                $nw_device = '모두';
                break;
        }
		//출력위치 구분
		switch($row['nw_division']) {
            case 'comm':
                $nw_division = '커뮤니티';
                break;
            case 'shop':
                $nw_division = '쇼핑몰';
                break;
            case 'adm':
                $nw_division = '관리자';
                break;
			default:
                $nw_division = '커뮤니티/쇼핑몰';
                break;
        }
    ?>
    <tr class="<?php echo ' '.$bg; ?>">
    <!--<tr class="<?php// echo $bg; ?>">-->
        <td class="td_num"><?php echo $row['nw_id']; ?></td>
        <td><?php echo $row['nw_subject']; ?></td>
        <td class="td_division"><?php echo $nw_division; ?></td>
        <td class="td_device"><?php echo $nw_device; ?></td>
        <td class="td_datetime"><?php echo substr($row['nw_begin_time'],0,16); ?></td>
        <!-- 종료일표시 -->
        <td class="<?php echo ($row['nw_end_time'] >= G5_TIME_YMD) ? 'td_datetime_end' : 'td_datetime';//기간여부?>" title="<?php echo $row['nw_end_time']; ?>">
        <?php if($row['nw_end_time'] >= G5_TIME_YMD) { //기한이남았을때?>
		   <b><?php echo substr($row['nw_end_time'], 5, 6); ?></b> <?php echo substr($row['nw_end_time'], 10, 14); ?> 까지
		<?php } else { //종료되었을때?>
		    <span class="violet"><?php echo $row['nw_end_time']; ?></span>
		<?php } //닫기?>
        </td>
        <!--//-->
        <td class="td_num"><?php echo $row['nw_disable_hours']; ?>시간</td>
        <td class="td_size"><?php echo $row['nw_left']; ?></td>
        <td class="td_size"><?php echo $row['nw_top']; ?></td>
        <td class="td_size"><?php echo $row['nw_padding']; ?></td>
        <td class="td_size2"><?php echo $row['nw_width']; ?></td>
        <td class="td_size2"><?php echo $row['nw_height']; ?></td>
        <td class="td_mngsmall">
            <a href="./newwinform.php?w=u&amp;nw_id=<?php echo $row['nw_id']; ?>"><span class="sound_only"><?php echo $row['nw_subject']; ?> </span>수정</a>
            <a href="./newwinformupdate.php?w=d&amp;nw_id=<?php echo $row['nw_id']; ?>" onclick="return delete_confirm(this);"><span class="sound_only"><?php echo $row['nw_subject']; ?> </span>삭제</a>
        </td>
    </tr>
    <?php
    }

    if ($i == 0) {
        echo '<tr><td colspan="13" class="empty_table">자료가 한건도 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>


<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
