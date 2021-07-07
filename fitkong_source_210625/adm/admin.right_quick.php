<?php
if (!defined('_GNUBOARD_')) exit;
include_once('./_common.php');

#######################################################################################
/* 하단에 고정되는 스크린바 [아이스크림 소스] */
// 삽입함수 include_once(G5_ADMIN_PATH.'/admin.bottom_quick.php');
// 관리자하단에 고정되어 나타남
// 퀵메뉴 - 쪽지함,알림창,최적화,새로고침,주문관리,바로가기 등
#######################################################################################

?>
<!-- 우측퀵메뉴 #right_quick -->
<div id="right_quick">   
    <div class="rq_basic_icon">
        <!-- 뒤로 -->
        <a href="javascript:history.back()" class="at-tip" data-original-title="<nobr>뒤로</nobr>" data-toggle="tooltip" data-placement="left" data-html="true"><i class="fas fa-arrow-left font-13"></i></a>
        <!-- 관리자홈 -->
        <a href="<?php echo G5_ADMIN_URL; ?>/" class="at-tip" data-original-title="<nobr>관리자홈</nobr>" data-toggle="tooltip" data-placement="left" data-html="true"><i class="fas fa-home font-11"></i></a>
       <!-- // -->
       <!-- 사이트기록삭제(새창) - 아이스크림 2017-12-20 -->
       <span class="at-tip" onclick="win_adm_del('icecream_adm_del​​', '<?php echo G5_ADMIN_URL; ?>/icecream_del.php');" data-original-title="<nobr>사이트<br>사용기록삭제</nobr>" data-toggle="tooltip" data-placement="left" data-html="true">
        <i class="fas fa-trash-alt font-13"></i>
       </span>
       <!-- // -->
       <!-- 새로고침 -->
        <a href="javascript:location.reload()" class="at-tip" data-original-title="<nobr>새로고침</nobr>" data-toggle="tooltip" data-placement="left" data-html="true"><i class="fas fa-redo-alt font-12"></i></a>
        <!-- // -->
    </div>
</div>
<!-- // -->