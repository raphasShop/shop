<?php
$sub_menu = '100103'; // SEO 검색엔진최적화 2018-01-31
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], "w");

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

#####################################################################

// SEO기본이미지 seo_img 업로드

#####################################################################
// seo_img 파일 삭제
if ($_POST['seo_img_del'])  @unlink(G5_DATA_PATH."/common/seo_img.jpg");
// seo_img 파일 등록
if ($_FILES['seo_img']['name']) upload_file($_FILES['seo_img']['tmp_name'], "seo_img.jpg", G5_DATA_PATH."/common");

#####################################################################

// 사이트맵 xml 업로드

#####################################################################

// sitemap.xml파일 삭제
if ($_POST['sitemap_xml_del'])  @unlink(G5_PATH."/sitemap.xml");
// sitemap.xml파일 등록
if ($_FILES['sitemap_xml']['name']) upload_file($_FILES['sitemap_xml']['tmp_name'], "sitemap.xml", G5_PATH."/");

#####################################################################

// 로봇 txt 업로드

#####################################################################

// robots.txt파일 삭제
if ($_POST['robots_txt_del'])  @unlink(G5_PATH."/robots.txt");
// robots.txt파일 등록
if ($_FILES['robots_txt']['name']) upload_file($_FILES['robots_txt']['tmp_name'], "robots.txt", G5_PATH."/");

#####################################################################

// SEO 사용 설정 업데이트 (아이스크림)

#####################################################################

$sql = " update {$g5['config_table']}
            set cf_add_meta = '{$_POST['cf_add_meta']}',
			    cf_meta_author = '{$_POST['cf_meta_author']}',
				cf_meta_description = '{$_POST['cf_meta_description']}',
				cf_meta_keyword = '{$_POST['cf_meta_keyword']}',
                cf_analytics = '{$_POST['cf_analytics']}'
                ";
sql_query($sql);

goto_url("./config_seo.php");
?>
