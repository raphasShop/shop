<?php
if (!defined('_GNUBOARD_')) exit;
include_once('./_common.php');

#######################################################################################
/* 하단에 고정되는 스크린바 [크림장수소스] */
// 삽입함수 include_once(G5_ADMIN_PATH.'/admin.top_screen.php');
// 메인/주문리스트/상품리스트/회원리스트/그외페이지에 나타나는 스크린바
// 상단주메뉴 바로 아래표시되다가, 아래로 스크롤하면 맨아래 바닥에 붙어서 보임
#######################################################################################

?>

<!-- TOP 상단 날짜표시 등 :: 관리자메인에서만 노출됨 -->
<?php if($is_admindex) { //관리자메인에서만 보여짐 ?>
<div id="top_screen" style="background-color:#2C2A29; background-image:linear-gradient(90deg, rgba(255,255,255,.07) 50%, transparent 80%),linear-gradient(90deg, rgba(255,255,255,.13) 50%, transparent 50%),linear-gradient(90deg, transparent 50%, rgba(255,255,255,.17) 50%),linear-gradient(90deg, transparent 50%, rgba(255,255,255,.19) 50%);background-size: 15px, 5px, 15px, 5px;">
    
    <div id="left_date1">
	    <?php
	    $tweek = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
	    ?>
        <?php echo date('Y');?>
        <b class="font-16 white"><?php echo date('m월d일');?></b>
        <?php echo $tweek[date("w")];?> <span class="darkyellow"><?php echo date('H:i');?></span>
    </div>
    
    <div class="pull-right screenbasic">
       <!-- 현재 상태 표시 -->
       오늘의주문
       <a href="<?php echo $infotoday['href']; ?>"><?php echo ($infotoday['price'] > 0) ? '<span class="screensum_yellow">￦'.number_format($infotoday['price']).'</span>' : '<span class="screensum_yellow">\ 0</span>';?></a> <a href="<?php echo $infotoday['href']; ?>"><?php echo ($infotoday['count'] > 0) ? '<span class="screencnt">('.number_format($infotoday['count']).'건)</span>' : '';?></a>&nbsp;
       이달의주문
       <a href="<?php echo $infomonth['href']; ?>"><?php echo ($infomonth['price'] > 0) ? '<span class="screensum">￦'.number_format($infomonth['price']).'</span>' : '<span class="screensum">\ 0</span>';?></a> <a href="<?php echo $infomonth['href']; ?>"><?php echo ($infomonth['count'] > 0) ? '<span class="screencnt">('.number_format($infomonth['count']).'건)</span>' : '';?></a>&nbsp;
       이달의매출
       <a href="<?php echo $infomonth_sale['href']; ?>"><?php echo ($infomonth_sale['price'] > 0) ? '<span class="screensum">￦'.number_format($infomonth_sale['price']).'</span>' : '<span class="screensum">\ 0</span>';?></a> <a href="<?php echo $infomonth_sale['href']; ?>"></a>&nbsp;&nbsp;
       <!-- // -->
    </div>
       
</div>
<!-- // -->


<!-- TOP 상단 :: 기타 모든페이지에 노출됨 -->
<?php } else { //기타 모든페이지에 노출됨 ?>
<div id="top_screen">
    
    <div id="screen_left">
       <a href="javascript:history.back()" class="at-tip" data-original-title="<nobr>뒤로</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-arrow-left font-20 white p-lr10"></i></a>
       <a href="<?php echo G5_ADMIN_URL;?>/index.php" class="at-tip" data-original-title="<nobr>관리자메인</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-window-maximize font-16 lightgray p-lr5"></i></a>      
       <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/orderlist.php" class="at-tip" data-original-title="<nobr>주문내역</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-credit-card font-16 lightgray p-lr5"></i></a>
       <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/categorylist.php" class="at-tip" data-original-title="<nobr>분류관리</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-sitemap font-16 lightgray p-lr5"></i></a>
       <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/itemlist.php" class="at-tip" data-original-title="<nobr>상품관리</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-barcode font-16 lightgray p-lr5"></i></a>
       &nbsp;     
    </div>
     
    <div class="pull-right screenbasic">
       <!-- 현재 상태 표시 -->
       오늘의주문
       <a href="<?php echo $infotoday['href']; ?>"><?php echo ($infotoday['price'] > 0) ? '<span class="screensum_yellow">￦'.number_format($infotoday['price']).'</span>' : '<span class="screensum_yellow">\ 0</span>';?></a> <a href="<?php echo $infotoday['href']; ?>"><?php echo ($infotoday['count'] > 0) ? '<span class="screencnt">('.number_format($infotoday['count']).'건)</span>' : '';?></a>&nbsp;&nbsp;
       <!-- // -->
    </div>
       
</div>
<!-- // -->
<?php } // TOP상단 #top_screen 전체닫기?>



<!-- 스크롤시 top_screen 상단메뉴 상단고정 Sticky Navi 관련 스크립트 시작 { -->
<script>
$(document).ready(function () {
  var $nav = $('#top_screen'),
      posTop = $nav.position().top;
  $(window).scroll(function () {
    var y = $(this).scrollTop();
    if (y > posTop) { $nav.addClass('fixed'); }
    else { $nav.removeClass('fixed'); }
  });
});
</script>
<!-- } 스크롤시 top_screen 상단메뉴 상단고정 Sticky Navi 관련 스크립트 끝 //-->