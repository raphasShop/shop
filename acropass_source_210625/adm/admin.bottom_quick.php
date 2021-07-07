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
<!-- 하단 #bottom_quick -->
<div id="bottom_quick">
    
    <div class="pull-left alimdiv">

                <!-- 쪽지알림 -->
				<?php if(memo_recv_count($member['mb_id']) == '0') { //않읽은 메모가 없을때?>
                <!--<span class="memo_alim_none">
                    <a href="<?//php echo G5_BBS_URL ?>/memo.php" target="_blank" class="win_memo"><i class="fa far-envelope-open"></i></a>
                </span> -->
                <?php } else { //않읽은 메모가 있을때?>
                <span class="memo_alim_yes">
                    <a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" class="win_memo at-tip" data-original-title="<nobr><b>읽지않은</b><br>쪽지가 있습니다</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
                    <?php echo (memo_recv_count($member['mb_id']) > 0) ? '<span class="alarm-btn-label en bg-orangered">'.number_format(memo_recv_count($member['mb_id'])).'</span>' : '';//미확인받은쪽지표시?>
                    <i class="fas fa-envelope-open"></i>
                    </a>
                </span>
                <?php } ?>
                <!--//-->
                
                <!-- 쇼핑알림 -->
                <?php if ($todayalim_all > 0) { //오늘 알림건수 있을때?>
                <span class="memo_alim_yes">
                    <a onclick="win_adm_del('win_adm_alim​​', '<?php echo G5_ADMIN_URL; ?>/alim_today.php');" class="at-tip cursor" data-original-title="<nobr>실시간<br>쇼핑몰관리 알림</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
                    <?php echo ($todayalim_all > 0) ? '<div class="alarm-btn-label bg-orangered">'.number_format($todayalim_all).'</div>' : '';//알림건수?> 
                    <i class="fas fa-calendar-check"></i>
                    </a>
                </span>
                <?php } else { //없을때?>
                <span class="memo_alim_none">
                    <a onclick="win_adm_del('win_adm_alim​​', '<?php echo G5_ADMIN_URL; ?>/alim_today.php');" class="at-tip cursor" data-original-title="<nobr>실시간<br>쇼핑몰관리 알림</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
                    <i class="far fa-calendar-check"></i>  
                    </a>
                </span>
                <?php } ?>
                <!--//-->
                
                
    </div><!--<div id="screen_left">-->
     


    
    <?php if($is_admindex) { //관리자메인에서만 보임 ?>
    <div class="pull-right bottom_quickbasic">
       <!-- 뒤로 -->
       <a href="javascript:history.back()" class="at-tip" data-original-title="<nobr>뒤로</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fas fa-arrow-left fa-lg bottom_quick_icon1 font-20"></i></a>
       <!-- // -->
       
       <!-- 관리자홈 -->
        <a href="<?php echo G5_ADMIN_URL; ?>/" class="at-tip" data-original-title="<nobr>관리자메인</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fas fa-home fa-lg bottom_quick_icon1 font-20"></i></a>
       <!-- // -->
       
       <!-- 사이트기록삭제(새창) - 아이스크림 2017-12-20 -->
       <span class="at-tip" onclick="win_adm_del('icecream_adm_del​​', '<?php echo G5_ADMIN_URL; ?>/icecream_del.php');" data-original-title="<nobr>사이트<br>사용기록삭제</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
        <i class="fas fa-trash-alt fa-lg bottom_quick_icon1 font-18"></i>
       </span>
       <!-- // -->
       
       <!-- 글자확대 
       <div class="toggle_text_up" onmouseout="$('.toggle_text_up').toggle()">
            <a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a>
            <a href="<?php echo G5_ADMIN_URL ?>/member_form.php?w=u&amp;mb_id=<?php echo $member['mb_id'] ?>">정보변경</a>
            <a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" class="win_memo at-tip">내쪽지함</a>
       </div> 

       <span class="at-tip" onclick="$('.toggle_text_up').toggle()"data-original-title="<nobr>확대/축소</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fas fa-plus fa-lg bottom_quick_icon1 font-18"></i></span>
        -->

        <!-- 새로고침 -->
        <a href="javascript:location.reload()" class="at-tip" data-original-title="<nobr>새로고침</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fas fa-redo-alt fa-lg bottom_quick_icon1 font-18"></i></a>
        <!-- // -->
        
        <!-- 더보기 -->
        <i class="fas fa-ellipsis-v bottom_quick_icon2 skyblue font-18"></i>
        <!-- // -->
    </div>
    <?php } else { //관리자메인외에는 숨김?>
    <div class="pull-right bottom_quickbasic_hidden">      
        <!-- 더보기 -->
        <i class="fas fa-ellipsis-v bottom_quick_icon2 skyblue font-18"></i>
        <!-- // -->
    </div>
    <?php } //닫기 ?>
       
</div>
<!-- // -->