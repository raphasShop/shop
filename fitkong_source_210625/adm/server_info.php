<?php
$sub_menu = "999110";
include_once("./_common.php");

check_demo();

auth_check($auth[$sub_menu], "r");

$g5[title] = "내서버계정정보";
include_once("./admin.head.php");

// http://sir.co.kr/bbs/board.php?bo_table=g5_tiptech&wr_id=656
//
// db용량에 대해서 : http://appleis.tistory.com/507

function size($size) {
	if(!$size) return "0 Byte";
	if($size < 1024) {
		return "$size Byte";
	} elseif($size >= 1024 && $size < 1024 * 1024) {
		return sprintf("%0.1f",$size / 1024)." KB";
	} elseif($size >= 1024 * 1024 && $size < 1024 * 1024 * 1024) {
		return sprintf("%0.1f",$size / 1024 / 1024)." MB";
	} else {
		return sprintf("%0.1f",$size / 1024 / 1024 / 1024)." GB";
	}
}

// 현재의 계정
$user_id = get_current_user(); 

// os 정보
$os_version = php_uname('r');

// 서버의 ip
$ip_addr = gethostbyname(trim(`hostname`));

// 계정의 사용량을 구함 
$account_space = `du -sb $g5[path]`; 
$account_space = substr($account_space,0,strlen($account_space)-3); 

// DATA 폴더의 용량을 구함 
$data_space = `du -sb $g5[path]/data`; 
$data_space = substr($data_space,0,strlen($data_space)-8); 

// Apache 웹서버 버젼
if (function_exists("apache_get_version")) {
    $apache_version = apache_get_version();

    // Apache 모듈 내역
    $apache_m = @apache_get_modules();
    $apache_modules = "";
    $i = 1;
    foreach ($apache_m as $row) {
        $apache_modules .= $row . " ";
        if ($i == 5) {
            $apache_modules .= "<br>";
            $i = 1;
        } else
            $i++;
    }
}

// PHP 버젼
$php_version = phpversion();

// Zend 버젼
$zend_version = zend_version();

// GD 버젼
$gd_support = extension_loaded('gd');
if ($gd_support) {
    $gd_info = gd_info();
    $gd_version = $gd_info['GD Version'];
} else {
    $gd_support = "GD가 설치되지 않음";
}

// 업로드 가능한 최대 파일사이즈
$max_filesize = get_cfg_var('upload_max_filesize');

// MySQL 버젼
$m_version = sql_fetch(" select version() as ver");

// MySQL Stat - http://kr2.php.net/manual/kr/function.mysql-stat.php
$mysql_stat = explode('  ', mysql_stat());

// MYSQL DB의 사용량을 구함 
$result = sql_query("SHOW TABLE STATUS"); 
$db_using = 0;
$db_count = 0;
$db_rows = 0;
while($dbData=mysql_fetch_array($result)) { 
    $db_using += $dbData[Data_length]+$dbData[Index_length];
    $db_count++;
    $db_rows += $dbData[Rows];
} 

// 전체 게시판 갯수
$count_board = sql_fetch(" select count(*) as cnt from $g5[board_table] ");

// 전체 게시글 수
$result = sql_query(" select bo_table from $g5[board_table] ");
$count_board_article = 0;
$count_board_comment = 0;
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $tmp_write_table = $g5['write_prefix'] . $row[bo_table]; // 게시판 테이블 전체이름
    $t_sum = sql_fetch(" select count(*) as cnt from $tmp_write_table ");
    $count_board_article += $t_sum[cnt];
    $t_sum = sql_fetch(" select count(*) as cnt from $tmp_write_table where wr_is_comment = 1 ");
    $count_board_comment += $t_sum[cnt];
}

// 오늘 새로 누적된 포인트와 총 누적된 포인트를 구함 
$all_point = sql_fetch(" select sum(po_point) as sum from $g5[point_table] ");
$new_point = sql_fetch(" select sum(po_point) as sum from $g5[point_table] WHERE date_format( po_datetime, '%Y-%m-%d' ) = '$g5[time_ymd]'");

// 모든 게시판에 첨부된 파일의 갯수를 구함 
$count_data = sql_fetch("select count(*) as cnt from $g5[board_file_table]"); 

// 새 회원 수와 총 회원 수를 구함 
$count_member = sql_fetch(" select count(*) as cnt from $g5[member_table] where mb_leave_date = '' "); 
$new_member = sql_fetch(" select count(*) as cnt from $g5[member_table] where mb_open_date = '$g5[time_ymd]' "); 
?>
<div class="tbl_frm01 tbl_wrap">
	<table>
		<colgroup>
		<col class="grid_6" />
		<col />
		</colgroup>
		<tbody>
			<tr> 
				 <th>사용자 id</th>
				<td>
				<?php if ($is_admin = 'super') { //최고관리자만 볼수있음?><?php echo $user_id?><?php } else { ?><span class="skyblue">※ 최고관리자가 아닙니다</span><?php } //닫기?>
                </td>
			</tr>
			<tr>
				 <th>서버 운영시스템</th>
				<td><?php echo PHP_OS?></td>
			</tr>
			<tr>
				 <th>서버 운영시스템 버젼</th>
				<td><?php echo $os_version?></td>
			</tr>
			<tr> 
				 <th>서버 시간</th>
				<td><?php echo G5_TIME_YMDHIS ?></td>
			</tr>
			<? if (function_exists("date_default_timezone_get")) { ?>
			<tr>
				 <th>Default Time Zone</th>
				<td><?php echo date_default_timezone_get()?></td>
			</tr>
			<? } ?>


			<tr> 
				 <th>hostname</th>
				<td><?php if ($is_admin = 'super') { //최고관리자만 볼수있음?><?php echo trim(`hostname`);?><?php } else { ?><span class="skyblue">※ 최고관리자가 아닙니다</span><?php } //닫기?></td>
			</tr>
			<tr> 
				 <th>ip 주소</th>
				<td><?php if ($is_admin = 'super') { //최고관리자만 볼수있음?><?php echo $ip_addr?><?php } else { ?><span class="skyblue">※ 최고관리자가 아닙니다</span><?php } //닫기?></td>
			</tr>
			<tr><td colspan='2'></td></tr>
			<tr> 
				 <th>계정 DISK 사용량(A)</th>
				<td><?php echo size($account_space)?></td>
			</tr>
			<tr>
				 <th>데이터 디렉토리 사용량(D)</th>
				<td><?php echo size($data_space)?></td>
			</tr>
			<tr>
				 <th>프로그램 사용량(A-D)</th>
				<td><?php echo size($account_space - $data_space)?></td>
			</tr>


			<? if ($apache_version) { ?>
			<tr><td colspan='2'></td></tr>
			<tr>
				 <th>Apache 버젼</th>
				<td><?php echo $apache_version;?></td>
			</tr>
			<tr><td colspan='2'></td></tr>
			<tr>
				 <th>Apache 모듈</th>
				<td><?php echo $apache_modules;?></td>
			</tr>
			<? } ?>

			<tr><td colspan='2'></td></tr>
			<tr>
				 <th>PHP 버젼</th>
				<td><?php echo $php_version;?></td>
			</tr>
			<tr>
				 <th>Zend 버젼</th>
				<td><?php echo $zend_version;?></td>
			</tr>
			<tr>
				 <th>GD 버젼</th>
				<td><?php echo $gd_version;?></td>
			</tr>
			<tr>
				 <th>최대 Upload 파일사이즈</th>
				<td><?php echo $max_filesize;?></td>
			</tr>
			<tr><td colspan='2'></td></tr>
			<tr>
				 <th>MYSQL 버젼</th>
				<td><?php echo $m_version[ver]?></td> 
			</tr>
			<tr>
				 <th>MYSQL DB Name</th>
				<td><?php echo $mysql_db ?></td> 
			</tr>
			<tr>
				 <th>MYSQL DB info</th>
				<td><? $a = explode(":", $mysql_stat[0]); echo $a[0] . ": ";?>
					<?
					$days = floor($a[1]/86400);
					if ($days) echo $days . "일 ";
					$hours = (floor($a[1]/3600)%24);
					if ($hours) echo $hours . "시간 ";
					$min = (floor($a[1]/60)%60);
					if ($min) echo $min . "분";
					?>
					<br>
					<?php echo $mysql_stat[1]?><BR>
					<? $t=explode(":", $mysql_stat[2]); echo $t[0] . ": "; echo number_format($t[1])?><BR>
					<?php echo $mysql_stat[3]?><BR>
					<?php echo $mysql_stat[4]?><BR>
					<?php echo $mysql_stat[5]?><BR>
					<?php echo $mysql_stat[6]?><BR>
					<?php echo $mysql_stat[7]?><BR>
				</td> 
			</tr> 
			<tr>
				 <th>DB 사용량</th>
				<td><?php echo size($db_using)?></td> 
			</tr> 
			<tr>
				 <th>전체 DB 테이블 갯수</th>
				<td><?php echo number_format($db_count)?></td> 
			</tr> 
			<tr>
				 <th>전체 DB ROW 갯수</th>
				<td><?php echo number_format($db_rows)?></td> 
			</tr> 
			<tr><td colspan='2'></td></tr>

			<tr> 
				<th colspan='2'>
				<b>그누보드5 정보</b>
				</th> 
			</tr>
			<tr><td colspan='2'></td></tr>
			<tr>
				 <th>전체 게시판 갯수</th>
				<td><?php echo number_format($count_board[cnt])?></td> 
			</tr>
			<tr>
				 <th>전체 글 갯수(게시글+코멘트)</th>
				<td><?php echo number_format($count_board_article)?></td> 
			</tr>
			<tr>
				 <th>전체 게시글 갯수</th>
				<td><?php echo number_format($count_board_article - $count_board_comment)?></td> 
			</tr>
			<tr>
				 <th>전체 코멘트 갯수</th>
				<td><?php echo number_format($count_board_comment)?></td> 
			</tr>
			<tr>
				 <th>전체 게시판의 첨부파일수</th>
				<td><?php echo number_format($count_data[cnt])?></td> 
			</tr> 
			<tr>
				 <th>전체 포인트 합계</th>
				<td><?php echo number_format($all_point[sum])?></td> 
			</tr>
			<tr>
				 <th>오늘 발생한 포인트</th>
				<td><?php echo number_format($new_point[sum])?></td> 
			</tr>
			<tr>
				 <th>전체 회원수</th>
				<td><?php echo number_format($count_member[cnt])?></td> 
			</tr> 
			<tr>
				 <th>오늘 가입한 회원수</th>
				<td><?php echo number_format($new_member[cnt])?></td> 
			</tr> 
		<tbody>
	</table> 
</div>
<?php
include_once("./admin.tail.php");
?>