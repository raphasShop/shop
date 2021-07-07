<?php
include_once('./_common.php');


$cmno = $_GET['cm_no'];

if($cmno == 1) {
	$community_subject = "상활별 피부 진정 꿀팁!";
	$community_date = "2019. 1. 10";
	$community_tag = "#피부건조 #여드름 #홍조";
} else if ($cmno == 2) {
	$community_subject = "러블리즈 꽃케이님 예쁨 ㅠㅠ";
	$community_date = "2019. 4. 15 ~";
	$community_tag = "#트러블큐어 #꽃케이 #꿀피부";
} else if ($cmno == 3) {
	$community_subject = "소개팅 응급처치 방법!";
	$community_date = "2019. 4. 15 ~ 2019. 4. 26";
	$community_tag = "#소개팅 #응급처치";
} else if ($cmno == 4) {
	$community_subject = "면접 프리패스 뷰티템!";
	$community_date = "2019. 4. 15 ~";
	$community_tag = "#면접프리패스 #얼굴도 #스펙이다";
} else if ($cmno == 5) {
	$community_subject = "요즘 핫한 뷰티템!";
	$community_date = "2019. 4. 15 ~ ";
	$community_tag = "#명절증후군 #지친피부 #원상회복";
}

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/communitydetail.php');
    return;
}

include_once(G5_SHOP_PATH.'/_head.php');
$communitydetail_skin = G5_SHOP_SKIN_PATH.'/communitydetail.skin.php';

if(!file_exists($communitydetail_skin)) {
    echo str_replace(G5_PATH.'/', '', $communitydetail_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($communitydetail_skin);
}

include_once(G5_SHOP_PATH.'/_tail.php');


?>