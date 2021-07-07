<?php
#################################################################

/* @@@@ 아이스크림 관리자 사용을 위한 필수 공통파일 @@@@ */

#################################################################

/*
최초작성일 : 2018-03-27
최종수정일 : 2018-05-04

버전 : 아이스크림 S9 영카트NEW 관리자
개발 : 아이스크림 아이스크림플레이 icecreamplay.cafe24.com
라이센스 : 유료판매 프로그램으로 유료 라이센스를 가집니다
           - 1카피 1도메인
           - 무단배포불가/무단사용불가
           - 소스의 일부 또는 전체 배포/공유/수정배포 불가
*/

#################################################################


if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$begin_time = get_microtime();


#################################################################

// cf_active_key 필드생성
/*아이스크림S9 라이선스 및 사용확인을 위해 키값을 사이트에 저장하기 위해추가된 DB 업데이트*/
// ■ admin/admin.head.php파일에서 cf_active_key값 넣는 함수 확인
// ■ admin/admin.head.sub.php파일에서 cf_active_key 필드 새로 생성하는 함수 확인

#################################################################
// ▧ admin/admin.head.sub.php , admin/admin.head.php에서 확인 실행되는 함수를 위해 필요한 필드 추가
// ▧ [사이트주소 필드추가] 사이트주소 등록 필드 추가
// ▧ 사이트 주소창의 도메인주소와 cf_active_key 에 저장된 도메인주소가 동일할때 아이스크림 사용가능
/* 아이스크림 사용을 위한 필드추가 */
if(!sql_query(" select cf_active_key from {$g5['config_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                 ADD `cf_active_key` varchar(255) NOT NULL AFTER `cf_admin_email_name`
	", true);
	
	$is_check = true;
}

#################################################################

// cf_active_key 키값 등록

#################################################################
$cf_active_key_reg = $_SERVER["SERVER_NAME"]; // http://www. 을 제외한 도메인이름만 조회 (예) naver.com 
if(!$config['cf_active_key'] || $config['cf_active_key'] != $_SERVER["SERVER_NAME"]) { 
// 키값이없는경우||키값이사이트주소와 다른경우 cf_active_key에 키값등록
    sql_query(" update {$g5['config_table']} set cf_active_key = '$cf_active_key_reg' ");
}

#################################################################

// cf_active_key 키값과 현재 사이트주소 확인

#################################################################

// 끝

#################################################################

$files = glob(G5_ADMIN_PATH.'/css/admin_extend_*');
if (is_array($files)) {
    foreach ((array) $files as $k=>$css_file) {
        
        $fileinfo = pathinfo($css_file);
        $ext = $fileinfo['extension'];
        
        if( $ext !== 'css' ) continue;
        
        $css_file = str_replace(G5_ADMIN_PATH, G5_ADMIN_URL, $css_file);
        add_stylesheet('<link rel="stylesheet" href="'.$css_file.'">', $k);
    }
}

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    $g5_head_title = $g5['title']; // 상태바에 표시될 제목
    $g5_head_title .= " | ".$config['cf_title'];
}

// 관리자 로그
$strLogger = '';
$logDir = '/var/www/acropass/log';
if(!is_dir($logDir)) mkdir($logDir, 0755);

$logFile = $logDir.'/admin_access.log';
$dlogFile = $logDir.'/admin_access_detail.log';
$admin_id = $member['mb_id'];
$log_date = date('Y-m-d H:i:d',time());

$strLogger = '['.$log_date.'] ['.$_SERVER['REMOTE_ADDR'].'] ['.$admin_id.'], ['.addslashes($g5['title']).'] http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'';
error_log($strLogger.PHP_EOL, 3, $logFile);
error_log($strLogger.PHP_EOL, 3, $dlogFile);
error_log(print_r($_POST, true).PHP_EOL, 3, $dlogFile);
error_log(print_r($_GET, true).PHP_EOL, 3, $dlogFile);

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

//쪽지함 카운트 출력
function memo_recv_count($mb_id)
{
    global $g5;

    if(!$mb_id)
        return 0;

    $sql = " select count(*) as cnt from {$g5['memo_table']} where me_recv_mb_id = '$mb_id' and me_read_datetime = '0000-00-00 00:00:00' ";
    $row = sql_fetch($sql);
    return $row['cnt'];
}

function admin_access_log() {

}

/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/

##########################################################
/* 
// 아이스크림 만의 관리자메인 데이터 인크루드
// 모든페이지 노출되는것은 admin.head.sub.php 파일에 적용
*/
##########################################################
// 일자별 주문 합계 표시 [아이스크림 소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_orderdate.php');
// 주문 상태별 합계 표시 [아이스크림 소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_order.php');
// 오늘 처리 할일 / 승인 및 답변, 재고등 처리해야 할 알림
include_once(G5_ADMIN_PATH.'/sum/admin.sum_alim.php');
// 상품 관련 합계 표시 [아이스크림 소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_item.php');
// 회원 관련 합계 표시 [아이스크림 소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_member.php');
// 잠재 구매 행동 [아이스크림 소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_bigdata.php');
// 오늘 발생한것 알림메세지 [아이스크림 소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_todayalim.php');
// 현재접속자정보 [아이스크림 소스]
include_once(G5_ADMIN_PATH.'/sum/admin.sum_connect.php');
###########################################################
// NEW 영카트 버전표시 - 아이스크림 
include_once(G5_ADMIN_PATH.'/icecream/admin.version.php');
###########################################################

// 부트스트랩 col-sm- 정의를 내릴수 있는 css 파일 임포트
add_stylesheet('<link rel="stylesheet" href="'.G5_ADMIN_URL.'/css/bootstrap.col.css" type="text/css">',0);

?>
<!doctype html>
<html lang="ko">
<head>
<!--파비콘-->
<?php 
    $favicon_ico = G5_PATH."/favicon.ico";
    if (file_exists($favicon_ico)) { 
?>
<link rel="shortcut icon" href="<?php echo G5_URL ?>/favicon.ico" type="image/x-ico" />
<? } ?>
<!--//-->
<meta charset="utf-8">
<?php
if (G5_IS_MOBILE) {
    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10">'.PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
} else {
    echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
    echo '<meta http-equiv="X-UA-Compatible" content="IE=Edge">'.PHP_EOL;
}

if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;
?>
<title><?php echo $g5_head_title; ?></title>
<?php
echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/css/icecream_admin.css">'.PHP_EOL; // @아이스크림전용 관리자 CSS
echo '<link rel="stylesheet" href="'.G5_CSS_URL.'/anything.css">'.PHP_EOL; // @아이스크림플레이
echo '<link rel="stylesheet" href="'.G5_JS_URL.'/tingle-master/dist/tingle.min.css">'.PHP_EOL; // @아이스크림플레이-modal
echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/css/input.css">'.PHP_EOL; // @아이스크림전용 input타입 CSS
?>

<!--[if lte IE 8]>
<script src="<?php echo G5_JS_URL ?>/html5.js"></script>
<![endif]-->
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
<?php if(defined('G5_IS_ADMIN')) { ?>
var g5_admin_url = "<?php echo G5_ADMIN_URL; ?>";
<?php } ?>
</script>
<script src="<?php echo G5_JS_URL ?>/jquery-1.8.3.min.js"></script>
<?php
if (defined('_SHOP_')) {
    if(!G5_IS_MOBILE) {
?>
<script src="<?php echo G5_JS_URL ?>/jquery.shop.menu.js?ver=<?php echo G5_JS_VER; ?>"></script>
<?php
    }
} else {
?>
<script src="<?php echo G5_JS_URL ?>/jquery.menu.js?ver=<?php echo G5_JS_VER; ?>"></script>
<?php } ?>
<script src="<?php echo G5_JS_URL ?>/common.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script src="<?php echo G5_JS_URL ?>/icecream.js<?php //@아이스크림플레이 ?>"></script>
<script src="<?php echo G5_JS_URL ?>/jquery.fade-in.js<?php //@아이스크림플레이-FADE-IN ?>"></script>
<script src="<?php echo G5_JS_URL ?>/tingle-master/dist/tingle.min.js<?php //@아이스크림플레이-modal ?>"></script>
<script src="<?php echo G5_JS_URL ?>/wrest.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script src="<?php echo G5_JS_URL ?>/placeholders.min.js"></script>
<!-- 아이스크림 관리자전용 js/css 삽입 -->
<script type="text/javascript" src="<?php echo G5_ADMIN_URL;?>/js/icecream.js"></script>
<link rel="stylesheet" href="<?php echo G5_JS_URL ?>/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo G5_JS_URL //@아이스크림플레이-font-awesome5?>/font-awesome5/css/fontawesome-all.min.css">

<?php
if(G5_IS_MOBILE) {
    echo '<script src="'.G5_JS_URL.'/modernizr.custom.70111.js"></script>'.PHP_EOL; // overflow scroll 감지
}
if(!defined('G5_IS_ADMIN'))
    echo $config['cf_add_script'];
?>
</head>
<body<?php echo isset($g5['body_script']) ? $g5['body_script'] : ''; ?>>
<?php
if ($is_member) { // 회원이라면 로그인 중이라는 메세지를 출력해준다.
    $sr_admin_msg = '';
    if ($is_admin == 'super') $sr_admin_msg = "최고관리자 ";
    else if ($is_admin == 'group') $sr_admin_msg = "그룹관리자 ";
    else if ($is_admin == 'board') $sr_admin_msg = "게시판관리자 ";

    echo '<div id="hd_login_msg">'.$sr_admin_msg.get_text($member['mb_nick']).'님 로그인 중 ';
    echo '<a href="'.G5_BBS_URL.'/logout.php">로그아웃</a></div>';
}
?>