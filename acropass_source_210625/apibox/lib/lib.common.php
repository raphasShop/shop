<?php

### 배열/클래스 출력 함수
if (!function_exists('debug')){
	function debug($data){
		print "<div style='background:#000000;color:#00ff00;padding:10px;text-align:left'><xmp style=\"font:8pt 'Courier New'\">";
		print_r($data);
		print "</xmp></div>";
	}
}

### 쿼리 출력문 확인
if (!function_exists('drawQuery')){
	function drawQuery($query,$mode=0){
		global $db;
		if ($mode) $query = "explain ".$query;
		$res = $db->query($query);
		while ($data=$db->fetch($res)) $loop[] = $data;
		drawTable($loop);
	}
}
if (!function_exists('drawTable')){
	function drawTable($data){
		if (!$data){
			echo "-- No Data --";
			return;
		}
		$keys = array_keys($data[0]);
		$ret  = "<table border=1 bordercolor=#cccccc style='border-collapse:collapse' style='font:8pt tahoma'>";
		$ret .= "<tr bgcolor=#f7f7f7><th>".implode("</th><th>",$keys)."</th></tr>";
		foreach ($data as $v) $ret .= "<tr><td>".implode("</td><td>",$v)."</td></tr>";
		$ret .= "</table>";
		echo $ret;
	}
}

?>