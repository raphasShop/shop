<?php
include_once("./_common.php");


?>
<meta property="og:type" content="website" />
<meta property="og:title" content="ACROPASS" />
<meta property="og:description" content="혁신적으로 피부침투율 높인 용해성 마이크로니들" />
<meta property="og:image" content="https://d1wwy9ao3iinzu.cloudfront.net/img/meta_guide.png" />

<?

$code = $_GET['c'];

$sql = " select * from {$g5['promotion_address_table']} where pa_code = '$code' ";
$row = sql_fetch($sql);

if( !$row['pa_id'] ){
    alert('해당 URL이 존재하지 않습니다.', G5_SHOP_URL);
}

if(!$row['pa_start'] || $row['pa_start'] == '0000-00-00') {
} else {
	if($row['pa_start'] > G5_TIME_YMD && $row['pa_end'] < G5_TIME_YMD ) {
		alert('만료된 프로모션 URL입니다.', G5_SHOP_URL);
	}
}

$pa_id = $row['pa_id'];
$get_pa_code = get_cookie('ck_pa_code');
$get_pa_user_code = get_cookie('ck_pa_user_code');
$get_user_personal_code = get_cookie('user_personal_code');
$get_scrap = getScrapInfo();


if ($get_pa_code != $code && $get_scrap == 'user')
{
    // 하루 동안
    set_cookie("ck_pa_code", $code, 60*60*24);

    $user_code = get_user_access_code();
    set_cookie("ck_pa_user_code", $user_code, 60*60*24);
    if(!$get_user_personal_code) {
    	set_cookie("user_personal_code", $user_code, 60*60*24*3650);
    	$get_user_personal_code = $user_code;
    }
    $before_pa_code = '';

    if($get_pa_code) {
    	set_cookie("ck_before_pa_code", $get_pa_code, 60*60*24);
    	$before_pa_code = $get_pa_code;
    }

    $get_pa_code = $code;
    $get_pa_user_code = $user_code;

    $apa_ip = $_SERVER['REMOTE_ADDR'];
    $apa_referer = $_SERVER["HTTP_REFERER"];
    $apa_agent = $_SERVER['HTTP_USER_AGENT'];
    $apa_browser = getBrowserInfo();
    $apa_os = getOsInfo();
    $apa_device = getDeviceInfo();
    set_cookie("ck_personal_device", $apa_device, 60*60*24*3650);
    
    $sql = " insert {$g5['promotion_access_table']} ( pa_code, pa_before_code, apa_code, apa_user_code, apa_date, apa_time, apa_ip, apa_referer, apa_agent, apa_os, apa_device, apa_browser ) values ( '{$get_pa_code}', '{$before_pa_code}','{$get_pa_user_code}', '{$get_user_personal_code}', '".G5_TIME_YMD."', '".G5_TIME_HIS."', '{$apa_ip}', '{$apa_referer}', '{$apa_agent}', '{$apa_os}', '{$apa_device}', '{$apa_browser}' ) ";

    $result = sql_query($sql, FALSE);
   
    if($result) {
    	$sql = " update {$g5['promotion_address_table']} set pa_hit = pa_hit + 1 where pa_id = '$pa_id' ";
    	sql_query($sql);
    }


}

$url = clean_xss_tags($row['pa_url']);


if($get_scrap == 'user') {
	if($member['mb_id'] == 'acropass') {
		echo "pa_code : ";
	    echo $get_pa_code;
	    echo "<br>";
	    echo "pa_user_code : ";
	    echo $get_pa_user_code;
	    echo "<br>";
	    echo "user_personal_code : ";
	    echo $get_user_personal_code;
	    echo "<br>"; 
	    echo "before_pa_code : ";
	    echo $get_before_pa_code;
	    echo "<br>";
	    echo "referer : ";
	    echo $apa_referer;
	    echo "<br>";  
      goto_url($url);
	} else {
		goto_url($url);
	}	
}

function printCookie() 
{
	echo "pa_code : ";
    echo $get_pa_code;
    echo "<br>";
    echo "pa_user_code : ";
    echo $get_pa_user_code;
    echo "<br>";
    echo "user_personal_code : ";
    echo $get_user_personal_code;
    echo "<br>"; 
    echo "before_pa_code : ";
    echo $get_before_pa_code;
    echo "<br>";
    echo "referer : ";
    echo $apa_referer;
    echo "<br>";  
}

function getBrowserInfo() 
{
  $userAgent = $_SERVER["HTTP_USER_AGENT"]; 
  if(preg_match('/MSIE/i',$userAgent) && !preg_match('/Opera/i',$u_agent)){
    $browser = 'Internet Explorer';
  }
  else if(preg_match('/Firefox/i',$userAgent)){
    $browser = 'Mozilla Firefox';
  }
  else if (preg_match('/Chrome/i',$userAgent)){
    $browser = 'Google Chrome';
  }
  else if(preg_match('/Safari/i',$userAgent)){
    $browser = 'Apple Safari';
  }
  elseif(preg_match('/Opera/i',$userAgent)){
    $browser = 'Opera';
  }
  elseif(preg_match('/Netscape/i',$userAgent)){
    $browser = 'Netscape';
  }
  else{
    $browser = "Other";
  }

  return $browser;
}

function getScrapInfo()
{
  $userAgent = $_SERVER["HTTP_USER_AGENT"]; 

  if (preg_match('/acebookexternalhit/i', $userAgent)){ 
    $scrap = 'opengraph';
  } else {
    $scrap = 'user';

  }

  return $scrap;
}

function getOsInfo()
{
  $userAgent = $_SERVER["HTTP_USER_AGENT"]; 

  if (preg_match('/linux/i', $userAgent)){ 
    $os = 'linux';}
  elseif(preg_match('/macintosh|mac os x/i', $userAgent)){
    $os = 'mac';}
  elseif (preg_match('/windows|win32/i', $userAgent)){
    $os = 'windows';}
  else {
    $os = 'Other';

  }

  return $os;
}

function getDeviceInfo() 
{
    $mobileArray = array(
          "iphone"
        , "lgtelecom"
        , "skt"
        , "mobile"
        , "samsung"
        , "nokia"
        , "blackberry"
        , "android"
        , "sony"
        , "phone"
    );

	$checkCount = 0;

	for($num = 0; $num < sizeof($mobileArray); $num++) {
		if(preg_match("/$mobileArray[$num]/", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $checkCount++;
            break;
    	}
	}
	return ($checkCount >= 1) ? "mobile" : "pc";
}


?>
