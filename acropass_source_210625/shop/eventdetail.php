<?php
include_once('./_common.php');


$evno = $_GET['ev_no'];

if($evno == 1) {
	$event_subject = "아크로패스 공식몰 GRAND OPEN 10/10 EVENT";
	$event_date = "2018. 4. 29 ~ 2019. 5. 31";
} else if ($evno == 2) {
	$event_subject = "365일 받을 수 있는 혜택, 여기 다 모였다!";
	$event_date = "2019. 4. 15 ~";
} else if ($evno == 3) {
	$event_subject = "선착순 이벤트, 아크로패스의 Pink한 그녀는 누구?";
	$event_date = "2019. 4. 15 ~ 2019. 4. 26";
} else if ($evno == 4) {
	$event_subject = "아크로패스 친구추천 이벤트, 15% 할인 쿠폰 증정!";
	$event_date = "2019. 4. 15 ~";
} else if ($evno == 5) {
	$event_subject = "플러스친구 이벤트, 2000원 할인 쿠폰 증정!";
	$event_date = "2019. 4. 15 ~ ";
}

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/eventdetail.php');
    return;
}

include_once(G5_SHOP_PATH.'/_head.php');
$eventdetail_skin = G5_SHOP_SKIN_PATH.'/eventdetail.skin.php';

if(!file_exists($eventdetail_skin)) {
    echo str_replace(G5_PATH.'/', '', $eventdetail_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($eventdetail_skin);
}

include_once(G5_SHOP_PATH.'/_tail.php');


?>