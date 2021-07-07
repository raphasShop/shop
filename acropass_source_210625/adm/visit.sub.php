<?php
if (!defined('_GNUBOARD_')) exit;

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');
	
include_once(G5_LIB_PATH.'/visit.lib.php');

// 설정기간을 계속 적용해주는 함수로 메뉴보다 하위에 있어서 위로 옮김
if (empty($fr_date)) $fr_date = G5_TIME_YMD;
if (empty($to_date)) $to_date = G5_TIME_YMD;

$qstr = "fr_date=".$fr_date."&amp;to_date=".$to_date;
$query_string = $qstr ? '?'.$qstr : '';

include_once('./admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

// 접속자 국가 표시를 위한 파일 - 아이스크림
include(G5_PATH.'/icecream/geoip.inc'); 
$gi = geoip_open(G5_PATH.'/icecream/GeoIP.dat',GEOIP_STANDARD); 

?>
<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">
    <div class="bq_basic">
    <button type="button" onclick="location.href='<?php echo G5_ADMIN_URL;?>/browscap_convert.php';"><i class="fas fa-magic"></i> 로그변환</button>
    </div>
</div>
<!--//-->

<!-- 검색창 시작 { -->
<div class="dan-datebox_mobile" style="margin-bottom:20px;"><!-- 분류별검색창 -->
    <div class="row"><!-- row 시작 { -->
<form name="fvisit" id="fvisit" class="big_sch02 big_sch" method="get">
    <b>기간별검색</b>&nbsp;&nbsp;
    <input type="text" name="fr_date" value="<?php echo $fr_date ?>" id="fr_date" class="frm_input" size="10" maxlength="10">
    <label for="fr_date" class="sound_only">시작일</label>
    ~
    <input type="text" name="to_date" value="<?php echo $to_date ?>" id="to_date" class="frm_input" size="10" maxlength="10">
    <label for="to_date" class="sound_only">종료일</label>
    <input type="submit" value="검색" class="btn_submit">&nbsp;&nbsp;
    
    <button type="submit" onclick="javascript:set_date('오늘');">오늘</button>
    <button type="submit" onclick="javascript:set_date('어제');">어제</button>
    <button type="submit" onclick="javascript:set_date('이번주');">이번주</button>
    <button type="submit" onclick="javascript:set_date('이번달');">이번달</button>
    <button type="submit" onclick="javascript:set_date('지난주');">지난주</button>
    <button type="submit" onclick="javascript:set_date('지난달');">지난달</button>
    <button type="submit" onclick="javascript:set_date('1주일');">1주일</button>
    <button type="submit" onclick="javascript:set_date('1개월');">1개월</button>
    <button type="submit" onclick="javascript:set_date('3개월');">3개월</button>
    <button type="submit" onclick="javascript:set_date('6개월');">6개월</button>
    <button type="submit" onclick="javascript:set_date('1년');">1 년</button>
    <button type="submit" onclick="javascript:set_date('3년');">3 년</button>
    <button type="submit" onclick="javascript:set_date('전체');"><i class="fas fa-refresh" aria-hidden="true"></i> 초기화</button>

    &nbsp;<button type="button" onclick="location.href='<?php echo G5_ADMIN_URL;?>/browscap_convert.php';">로그변환</button>
</form>
    </div><!-- } row 끝 -->
</div><!-- 검색창 -->
<!-- } 검색창 끝 -->

<?php
   /*
   $ice_hostname=$_SERVER["HTTP_HOST"]; //도메인명(호스트)명을 구합니다.
   $ice_uri= $_SERVER['REQUEST_URI']; //uri를 구합니다.
   $ice_query_string=getenv("QUERY_STRING"); // Get값으로 넘어온 값들을 구합니다.
   $ice_phpself=$_SERVER["PHP_SELF"]; //현재 실행되고 있는 페이지의 url을 구합니다. 
   */
   $ice_basename = basename($_SERVER["PHP_SELF"]); //현재 실행되고 있는 페이지명만 구합니다.
   $anchor_style = 'style="color:#333949;border:1px solid #5A6171;border-bottom:0px solid #fff;background:#FFF;"';
?>

<ul class="anchor">
    <li><a href="<?php echo G5_ADMIN_URL;?>/visit_list.php<?php echo $query_string ?>" <?php if($ice_basename == 'visit_list.php') echo $anchor_style;?>>&nbsp;접속자&nbsp;</a></li>
    <li><a href="<?php echo G5_ADMIN_URL;?>/visit_domain.php<?php echo $query_string ?>" <?php if($ice_basename == 'visit_domain.php') echo $anchor_style;?>>&nbsp;도메인&nbsp;</a></li>
    <li><a href="<?php echo G5_ADMIN_URL;?>/visit_browser.php<?php echo $query_string ?>" <?php if($ice_basename == 'visit_browser.php') echo $anchor_style;?>>&nbsp;브라우저&nbsp;</a></li>
    <li><a href="<?php echo G5_ADMIN_URL;?>/visit_os.php<?php echo $query_string ?>" <?php if($ice_basename == 'visit_os.php') echo $anchor_style;?>>&nbsp;운영체제&nbsp;</a></li>
    <?php if(version_compare(phpversion(), '5.3.0', '>=') && defined('G5_BROWSCAP_USE') && G5_BROWSCAP_USE) { ?>
    <li><a href="<?php echo G5_ADMIN_URL;?>/visit_device.php<?php echo $query_string ?>" <?php if($ice_basename == 'visit_device.php') echo $anchor_style;?>>&nbsp;접속기기&nbsp;</a></li>
    <?php } ?>
    <li><a href="<?php echo G5_ADMIN_URL;?>/visit_hour.php<?php echo $query_string ?>" <?php if($ice_basename == 'visit_hour.php') echo $anchor_style;?>>&nbsp;시간&nbsp;</a></li>
    <li><a href="<?php echo G5_ADMIN_URL;?>/visit_week.php<?php echo $query_string ?>" <?php if($ice_basename == 'visit_week.php') echo $anchor_style;?>>&nbsp;요일&nbsp;</a></li>
    <li><a href="<?php echo G5_ADMIN_URL;?>/visit_date.php<?php echo $query_string ?>" <?php if($ice_basename == 'visit_date.php') echo $anchor_style;?>>&nbsp;일&nbsp;</a></li>
    <li><a href="<?php echo G5_ADMIN_URL;?>/visit_month.php<?php echo $query_string ?>" <?php if($ice_basename == 'visit_month.php') echo $anchor_style;?>>&nbsp;월&nbsp;</a></li>
    <li><a href="<?php echo G5_ADMIN_URL;?>/visit_year.php<?php echo $query_string ?>" <?php if($ice_basename == 'visit_year.php') echo $anchor_style;?>>&nbsp;년&nbsp;</a></li>
</ul>

<script>
$(function(){
    $("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});

function fvisit_submit(act)
{
    var f = document.fvisit;
    f.action = act;
    f.submit();
}

function set_date(today)
{
    <?php
    $date_term = date('w', G5_SERVER_TIME); // 일단위
    $week_term = $date_term + 7; //일주일단위
    $last_term = strtotime(date('Y-m-01', G5_SERVER_TIME)); // 매월1일기준
	$month_term = strtotime(date('Y-m-d', G5_SERVER_TIME)); // 매월 오늘날짜 기준
    ?>
    if (today == "오늘") {
        document.getElementById("fr_date").value = "<?php echo G5_TIME_YMD; ?>";
        document.getElementById("to_date").value = "<?php echo G5_TIME_YMD; ?>";
    } else if (today == "어제") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
    } else if (today == "이번주") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-'.$date_term.' days', G5_SERVER_TIME)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
    } else if (today == "이번달") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-01', G5_SERVER_TIME); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
    } else if (today == "지난주") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-'.$week_term.' days', G5_SERVER_TIME)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', strtotime('-'.($week_term - 6).' days', G5_SERVER_TIME)); ?>";
    } else if (today == "지난달") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-01', strtotime('-1 Month', $last_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-t', strtotime('-1 Month', $last_term)); ?>";    
	} else if (today == "1주일") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-7 days', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "1개월") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-1 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	
	} else if (today == "3개월") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-3 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "6개월") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-6 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "1년") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-12 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "3년") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-36 Month', $month_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";	
	} else if (today == "전체") {
        document.getElementById("fr_date").value = "<?php echo G5_TIME_YMD; ?>";
        document.getElementById("to_date").value = "<?php echo G5_TIME_YMD; ?>";
    }
}
</script>
