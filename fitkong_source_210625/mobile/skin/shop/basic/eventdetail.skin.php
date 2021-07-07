<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css?ver='.G5_CSS_VER.''.date("H:i:s").'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<div id="top_sub_gnb">
    <div class="top_sub_wrap">이벤트</div>
    <div class="top_back_btn"><a href="javascript:history.back();"><i class="xi-angle-left"></i></a></div>
</div>

<div id="eventdetail_list">
    <div class="eventdetail_subject"><?php echo $event_subject; ?></div>
    <div class="eventdetail_date"><?php echo $event_date; ?></div>
    <div class="eventdetail_con">
        <?php if($evno == 1) echo "<a href=".G5_SHOP_URL."/item.php?it_id=1551498754>"; ?>
        <img src="<?php echo G5_IMG_URL; ?>/dmo_event0<?php echo $evno; ?>.jpg" >
        <?php if($evno == 1) echo "</a>"; ?>
    </div>
    <?php if($evno == 4) { ?> 
    <div class="eventdetail_bg">
    	<!--<img id="btn1" src="<?php echo G5_IMG_URL; ?>/dmo_event0<?php echo $evno; ?>_btn1.jpg">-->
    	<a href="<?php echo G5_BBS_URL; ?>/register.php"><img src="<?php echo G5_IMG_URL; ?>/dmo_event0<?php echo $evno; ?>_btn2.jpg"></a>
    </div>
	<?php } ?>
    
</div>


<script>
function copyToClipboard(val) {
  var t = document.createElement("textarea");
  document.body.appendChild(t);
  t.value = val;
  t.select();
  document.execCommand('copy');
  document.body.removeChild(t);
}
$('#btn1').click(function() {
	<?php if ($member['mb_id']) { ?>
	  copyToClipboard("<?php echo G5_BBS_URL; ?>/register.php?recommended=<?php echo $member['mb_id']; ?>");
	  alert('추천인 링크가 복사되었습니다. 친구들에게 공유해보세요!');
	<?php } else { ?>
	  alert('로그인을 먼저해주세요!');
	<?php } ?>
});
</script>

