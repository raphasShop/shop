<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 관리자 admin.head.sub.php 파일 - 아이스크림
if (defined('G5_IS_ADMIN')) {
    require_once(G5_ADMIN_PATH.'/admin.head.sub.php');
    return;
}


$begin_time = get_microtime();

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    $g5_head_title = $g5['title']; // 상태바에 표시될 제목
    $g5_head_title .= " | ".$config['cf_title'];
}

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/
?>
<!doctype html>
<html lang="ko">
<head>
<?php
/**
 * ASK SEO 출력 부분
 */
include_once G5_PLUGIN_PATH . "/ask-seo/ask-seo.php";
?>
<!--파비콘-->
<?php
    $favicon_ico = G5_PATH."/favicon.ico";
    if (file_exists($favicon_ico)) {
?>
<link rel="shortcut icon" href="<?php echo G5_URL ?>/favicon.ico" type="image/x-ico" />
<? } ?>
<!--//-->
<meta charset="utf-8">
<meta name="google-site-verification" content="GxkNgfW91l1pyxANDdikjzdfwhWdE6fX-9Wc8D2q4_M" />
<?php

$it_id = $_GET['it_id'];
if($it_id) {
  $sql = " select it_name, it_img1 from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
  $its = sql_fetch($sql);
  $og_image = G5_DATA_URL."/item/".$its['it_img1'];
}

?>

<?php
if (G5_IS_MOBILE) {
    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes">'.PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
} else {
    echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">'.PHP_EOL;
}

if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;
?>
<title><?php echo $g5_head_title; ?></title>
<link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL; ?>/default.css?ver=<?php echo date("Hi");?>">
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">
<link rel="stylesheet" href="<?php echo G5_CSS_URL; ?>/animation.css">
<link rel="stylesheet" href="<?php echo G5_THEME_CSS_URL; ?>/animate.css">
<?php
$shop_css = '';
if (defined('_SHOP_')) $shop_css = '_shop';
echo '<link rel="stylesheet" href="'.G5_THEME_CSS_URL.'/'.(G5_IS_MOBILE?'mobile':'default').$shop_css.'.css?ver='.G5_CSS_VER.'">'.PHP_EOL;
echo '<link rel="stylesheet" href="'.G5_CSS_URL.'/anything.css">'.PHP_EOL; // @아이스크림플레이
echo '<link rel="stylesheet" href="'.G5_JS_URL.'/tingle-master/dist/tingle.min.css">'.PHP_EOL; // @아이스크림플레이-modal
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
</script>
<script src="<?php echo G5_JS_URL ?>/jquery-1.8.3.min.js"></script>
<script src="<?php echo G5_JS_URL ?>/jquery.modal.min.js"></script>

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
<script src="<?php echo G5_JS_URL ?>/wrest.js?ver=<?php echo G5_JS_VER; ?>"></script>
<script src="<?php echo G5_JS_URL ?>/placeholders.min.js"></script>
<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>

<script src="<?php echo G5_THEME_JS_URL ?>/WEBsiting.js?ver=22<?php echo G5_CSS_VER; ?>2"></script>
<script src="<?php echo G5_THEME_JS_URL ?>/wow.min.js?ver=11<?php echo G5_CSS_VER; ?>2"></script>
<script src="https://cdn.jsdelivr.net/npm/countup@1.8.2/dist/countUp.min.js"></script>
<link rel="stylesheet" href="<?php echo G5_JS_URL ?>/font-awesome/css/font-awesome.min.css">
<!-- 폰트어썸5를 설치하였으나, 구버전사용시 호환문제가 있어 나중에 활성화함/테마에서 폰트어썸 구코드를 새코드로 변경해야함
<link rel="stylesheet" href="<?php echo G5_JS_URL ?>/font-awesome5/css/fontawesome-all.min.css">
-->
<script>
new WOW().init();
</script>
<script type='text/javascript'>
  //<![CDATA[
    // 사용할 앱의 JavaScript 키를 설정해 주세요.
    Kakao.init('83f52a73b22d1c21c859733280318507');
    function addPlusFriend() {
      Kakao.PlusFriend.addFriend({
        plusFriendId: '_CrTxgu' // 플러스친구 홈 URL에 명시된 id로 설정합니다.
      });
    }
    function plusFriendChat() {
      Kakao.PlusFriend.chat({
        plusFriendId: '_CrTxgu' // 플러스친구 홈 URL에 명시된 id로 설정합니다.
      });
    }
  //]]>
</script>

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '153973279353331');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=153973279353331&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<?php 
if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>
<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<?php
}

?>

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