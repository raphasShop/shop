<?php
//if (!defined('_GNUBOARD_')) exit;
include_once('./_common.php');

#######################################################################################
/* 하단에 고정되는 스크린바 [크림장수소스] */
// 삽입함수 include_once(G5_ADMIN_PATH.'/admin.top_screen.php');
// 메인/주문리스트/상품리스트/회원리스트/그외페이지에 나타나는 스크린바
// 상단주메뉴 바로 아래표시되다가, 아래로 스크롤하면 맨아래 바닥에 붙어서 보임
#######################################################################################

?>

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