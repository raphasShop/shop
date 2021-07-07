<?php
if (!defined('_GNUBOARD_')) exit;

#######################################################################################
/* 방문자/접속자/접속관련 정보 [아이스크림소스]*/
// 삽입함수 include_once(G5_ADMIN_PATH.'/sum/admin.sum_connect.php');
// 접속자정보등을 상단에 표시합니다
// admin.head.php / admin.tail.php 등 에서 사용함
#######################################################################################

// 회원, 방문객 카운트
    $sql_connect = " select sum(IF(mb_id<>'',1,0)) as mb_cnt, count(*) as total_cnt from {$g5['login_table']}  where mb_id <> '{$config['cf_admin']}' ";
    $row_connect = sql_fetch($sql_connect);
	$connect_total_cnt = '<b class="darkgray" style="letter-spacing:2px;"><i class="far fa-user"></i>'.$row_connect['total_cnt'].'</b>'; //전체접속자수
	$connect_mb_cnt = '<b class="skyblue" style="letter-spacing:2px;"><i class="fas fa-user"></i>'.number_format($row_connect['mb_cnt']).'</b>'; //회원접속자수

#####################################################################################
?>