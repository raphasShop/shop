<?php
$sub_menu = '100104'; // 도메인/파비콘등록관리 2018-01-31
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

// 로그인을 바로 이 주소로 하는 경우 쇼핑몰설정값이 사라지는 현상을 방지
//if (!$_POST['cf_add_meta']) goto_url("./config_seo.php");

#####################################################################

// 파비콘.ico 업로드

#####################################################################

// 파비콘.ico 파일 삭제
if ($_POST['favicon_ico_del'])  @unlink(G5_PATH."/favicon.ico");
// 파비콘.ico 파일 등록
if ($_FILES['favicon_ico']['name']) upload_file($_FILES['favicon_ico']['tmp_name'], "favicon.ico", G5_PATH."/");


#####################################################################

// SEO 사용 설정 업데이트 (아이스크림)

#####################################################################

$sql = " update {$g5['config_table']}
            set cf_add_meta = '{$_POST['cf_add_meta']}',
                cf_analytics = '{$_POST['cf_analytics']}',
				cf_syndi_token = '{$_POST['cf_syndi_token']}',
                cf_syndi_except = '{$_POST['cf_syndi_except']}'
                ";
sql_query($sql);

goto_url("./config_seo.php");
?>
