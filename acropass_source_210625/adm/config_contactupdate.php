<?php
$sub_menu = "100602";
include_once('./_common.php');

#######################################################################################

// 아이스크림 환경설정
// 사용자 접속 제한 환경설정 업데이트
/*
버전 : 아이스크림 S9 영카트NEW 관리자
개발 : 아이스크림 아이스크림플레이 icecreamplay.cafe24.com
라이센스 : 유료판매 프로그램으로 유료 라이센스를 가집니다
           - 1카피 1도메인
           - 무단배포불가/무단사용불가
           - 소스의 일부 또는 전체 배포/공유/수정배포 불가
 */

#######################################################################################

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

$sql = " update {$g5['config_table']}
            set cf_possible_ip = '".trim($_POST['cf_possible_ip'])."',
                cf_intercept_ip = '".trim($_POST['cf_intercept_ip'])."'
			 ";
sql_query($sql);


goto_url('./config_contact.php', false);
?>