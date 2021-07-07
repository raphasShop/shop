<?
/*
-- howCode SQL Dump 그누보드 전용
-- version 1.0 180208
-- 제작 : 로빈아빠 김성대 https://www.HowCode.co.kr
-- 제작자 출처표시는 절대로 수정하거나 삭제할 수 없습니다
*/



$sub_menu = "999610";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = 'HowCode SQL 덤프';


if (!$dump_filename) $dump_filename=date("Ymd.").trim(G5_MYSQL_DB).".sql";
$dump_filename=get_safe_filename($dump_filename);

if ($chk1 || $chk2 || $chk3) {
	$target_tables=array();
	if ($chk1 && $chk2 && $chk3) $target_tables=array();
	else {
		if ($chk1) $target_tables[]=$g5['member_table'];
		if ($chk2) $target_tables[]="board*";
		if ($chk3) $target_tables[]="etc*";
	}
	//$target_tables=array('ar_history_18');
	ar_dump_table(G5_MYSQL_HOST,G5_MYSQL_USER,G5_MYSQL_PASSWORD,trim(G5_MYSQL_DB),  $target_tables, $dump_filename);
}

include_once(G5_ADMIN_PATH.'/admin.head.php');

?>
<style>

.ar_how_code {
	margin:0 auto;
	width:100%;
	max-width:500px;
	text-align:center;
	line-height:30px;
	font-size:1.4em;
}


.ar_how_code .title {
	width:100%;
	background:#AAA;
	color:#FFF;
	font-size:1.4em;
	margin-bottom:20px;
	padding:20px;
	font-weight:700;
}

.ar_how_code .content {
	width:100%;
	border:solid 1px #AAA;
	padding:20px;
	text-align:left;
	padding-left:30px;
}

.ar_how_code .btn {
	margin:20px;
}
</style>

<div class='ar_how_code'>
	<div class='title'>
		<?=$g5['title']?>
	</div>

	<div class='content'>
		<form>
		<input type=checkbox name='chk1' value='chk1' id='chk1' checked> <label for='chk1'>회원정보 테이블 선택</label><BR>
		<input type=checkbox name='chk2' value='chk2' id='chk2' checked> <label for='chk2'>게시판들 테이블 선택</label><BR>
		<input type=checkbox name='chk3' value='chk3' id='chk3' checked> <label for='chk3'>기타자료 테이블 선택</label><BR>
		<input type=checkbox name='chk9' value='chk9' id='chk9' checked> <label for='chk9'>DROP TABLE  구문 추가</label><BR>
		다운파일명 <input type=text name='dump_filename' value='<?php echo $dump_filename?>'size=30> <BR>
		<center>
		<input type=submit value='선택한 테이블 다운로드' class='btn btn_submit'>
		</form>
	</div>

	<BR>
	※ 그누보드 DB 테이블을 DUMP 다운받는 기능입니다.<BR>
	동작시 시간이 많이 걸릴 수 있으니 주의 바랍니다.<BR>
	<a href='http://howcode.co.kr'>howcode.co.kr 로빈아빠</a>
    <BR><BR>
	<div class="font-12 lightviolet" style="line-height:18px;">
    ※ howcode.co.kr 로빈아빠님이 공개한 오픈코드를 탑재한것뿐이므로<BR>
	모든 저작권은 howcode.co.kr 로빈아빠님께 있습니다<BR>
    개발자 출처표시는 절대로 수정하거나 삭제할 수 없습니다.
    </div>
</div>

<?
include_once(G5_ADMIN_PATH.'/admin.tail.php');



function ar_dump_table($host,$user,$pass,$name,  $target_tables=array(), $dump_filename=false ){
	global $g5;

	if (!$dump_filename) $dump_filename=date("Ymd.").trim(G5_MYSQL_DB).".sql";


	//echo "<xmp>";
	if (!$target_tables) {
		$rst = sql_query('SHOW TABLES');
		while($row = sql_fetch_array($rst)) {
			$target_tables[] = array_values($row)[0];	// $row[0];  가 안될때
		}
	}
	if (in_array('board*',$target_tables)||in_array('etc*',$target_tables)) {
		$rst = sql_query('SHOW TABLES');
		while($row = sql_fetch_array($rst)) {
			$tablename=array_values($row)[0];	// $row[0];  가 안될때
			if (in_array('board*',$target_tables) && strstr($tablename,$g5['write_prefix'])) {
				$target_tables[] = $tablename;
			}
			if (in_array('etc*',$target_tables) && !strstr($tablename,$g5['write_prefix']) && $tablename!=$g5['member_table'] ) {
				$target_tables[] = $tablename;
			}
		}
	}
	$proc_table=array();
	foreach($target_tables as $tablename) {
		if (strstr($tablename,'*')) continue;
		if (in_array($tablename,$proc_table)) continue;
		$proc_table[]=$tablename;
	}
	asort($proc_table);

if(preg_match("/msie/i", $_SERVER['HTTP_USER_AGENT']) && preg_match("/5\.5/", $_SERVER['HTTP_USER_AGENT'])) {
    header("content-type: doesn/matter");
    //header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$dump_filename\"");
    header("content-transfer-encoding: binary");
} else {
    header("content-type: file/unknown");
    //header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$dump_filename\"");
    header("content-description: php generated data");
}

ob_start();
phpinfo(INFO_MODULES);
$info = ob_get_contents();
ob_end_clean();
$info = stristr($info, 'Client API version');
preg_match('/[1-9].[0-9].[1-9][0-9]/', $info, $match);
$mysql_version = $match[0];

echo "-- howCode SQL Dump 그누보드 전용\n";
echo "-- version 1.0 180208\n";
echo "-- 제작 : 로빈아빠 김성대\n";
echo "-- https://www.HowCode.co.kr\n";
echo "--\n";
echo "-- G5_URL: ".G5_URL."\n";
echo "-- G5_MYSQL_HOST: ".G5_MYSQL_HOST."\n";
echo "-- G5_MYSQL_USER: ".G5_MYSQL_USER."\n";
echo "-- G5_MYSQL_DB: ".G5_MYSQL_DB."\n";
echo "-- 서버 시간: ".G5_TIME_YMDHIS."\n";
echo "-- MYSQL 버전: {$mysql_version}\n";
echo "-- PHP 버전: ".phpversion()."\n";



	//var_dump($proc_table);exit;
	$cnt=0;
    foreach($proc_table as $table){
		$tmp=sql_fetch('SHOW CREATE TABLE '.$table);
		if (!$tmp) continue;
        $CreateTable=$tmp["Create Table"];
		$cnt++;

		$table_info = sql_fetch("SHOW TABLE STATUS LIKE '{$table}'");

		// 가끔 Rows가 안먹히는경우도 있다.
		$tmp = sql_fetch('SELECT count(*) as cnt FROM '.$table);
		$table_info['total_count']=$tmp['cnt'];

		//var_dump($table_info,true);exit;

        $rst = sql_query('SELECT * FROM '.$table);

		$record=0;
		while($row = sql_fetch_array($rst))  { //when started (and every after 100 command cycle):
			$record++;
			if ($record == 1)  {
				echo "\n\n";
				echo "--\n";
				echo "-- 테이블 : `{$table}`\n";
				echo "-- 자료수 : ".number_format($table_info['total_count'])."\n";
				echo "-- 생성일 : {$table_info['Create_time']}\n";
				echo "-- 최종일 : {$table_info['Update_time']}\n";
				if ($table_info['Comment'])
				echo "-- 설  명 : {$table_info['Comment']}\n";
				echo "--\n\n";

				if ($_REQUEST['chk9']) echo "DROP TABLE IF EXISTS `{$table}`;\n";

				echo "{$CreateTable};\n\n";
			}

			if ($record%50 == 1)  {
				//var_dump($row);exit;
				if ($record>1)
				echo  ";";
				echo "\nINSERT INTO `".$table."` VALUES\n";

			}
			else if ($record>0) {
				echo  ",\n";
			}

			foreach($row as $key=>$value) {
				//$row[$key] = str_replace("\n","\\n", addslashes($value));
				$row[$key] = addslashes($value);
			}

			echo "('";
			echo implode("', '",$row);
			echo "')";
		}
		echo  ";";
		echo "\n\n\n";
   }
	exit;
}