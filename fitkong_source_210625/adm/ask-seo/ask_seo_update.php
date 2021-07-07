<?php
$sub_menu = "100980";
include_once './_common.php';

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}


check_admin_token();

//로고 업로드
//삭제
if ($delete_logo) {
    @unlink(AS_SAVE_DIR . '/' . $delete_logo);
    $file_add_sql = " `as_logo` = '', ";
}

$image_regex = "/(\.(gif|jpe?g|png))$/i";
$file_name   = '';
$file_add_sql = '';
// 아이콘 업로드
if (isset($_FILES['as_logo']) && is_uploaded_file($_FILES['as_logo']['tmp_name'])) {
    if (!preg_match($image_regex, $_FILES['as_logo']['name'])) {
        alert($_FILES['as_logo']['name'] . '은(는) 이미지 파일이 아닙니다.');
    }

    if (preg_match($image_regex, $_FILES['as_logo']['name'])) {
        $as_logo_dir = AS_SAVE_DIR;
        @mkdir($as_logo_dir, G5_DIR_PERMISSION);
        @chmod($as_logo_dir, G5_DIR_PERMISSION);
        $ext       = array_pop(explode('.', $_FILES['as_logo']['name']));
        $file_name = "logo" . time() . "." . $ext;
        $dest_path = $as_logo_dir . '/' . $file_name;

        move_uploaded_file($_FILES['as_logo']['tmp_name'], $dest_path);
        chmod($dest_path, G5_FILE_PERMISSION);
        $file_add_sql = " `as_logo` = '{$file_name}', ";
    }
}
//배열 직렬화
if(count($as_sitemap_boardlist) > 0){
    $as_sitemap_boardlist = serialize($as_sitemap_boardlist);
}
//배열 직렬화
if(count($as_sitemap_contentslist) > 0){
    $as_sitemap_contentslist = serialize($as_sitemap_contentslist);
}
$sql = " update {$g5['config_table']}
            set  `as_use` = '{$as_use}',
            `as_google_verification` = '" . trim($as_google_verification) . "',
            `as_naver_verification` = '" . trim($as_naver_verification) . "',
            `as_bing_verification` = '" . trim($as_bing_verification) . "',
            {$file_add_sql}
            `as_url` = '{$as_url}',
            `as_telephone`= '{$as_telephone}',
            `as_title`= '{$as_title}',
            `as_keywords`= '{$as_keywords}',
            `as_description`= '{$as_description}',
            `as_sns_facebook`= '{$as_sns_facebook}',
            `as_sns_twitter`= '{$as_sns_twitter}',
            `as_sns_instagram`= '{$as_sns_instagram}',
            `as_sns_youtube`= '{$as_sns_youtube}',
            `as_sns_googleplus`= '{$as_sns_googleplus}',
            `as_sns_linkedin`= '{$as_sns_linkedin}',
            `as_sns_pinterest`= '{$as_sns_pinterest}',
            `as_sns_soundcloud`= '{$as_sns_soundcloud}',
            `as_sns_tumblr`= '{$as_sns_tumblr}',
            `as_sns_navercafe`= '{$as_sns_navercafe}',
            `as_sns_naversmartstore`= '{$as_sns_naversmartstore}',
            `as_sns_naverpost`= '{$as_sns_naverpost}',
            `as_sns_naverpholar`= '{$as_sns_naverpholar}',
            `as_sns_itunes`= '{$as_sns_itunes}',
            `as_sns_googleplaystore`= '{$as_sns_googleplaystore}',
            `as_sns_navertv`= '{$as_sns_navertv}',
            `as_sns_kakaostory`= '{$as_sns_kakaostory}',
            `as_feed_type`= '{$as_feed_type}',
            `as_feed_target`= '{$as_feed_target}',
            `as_feed_rows`= '{$as_feed_rows}',
            `as_sitemap_google` = '{$as_sitemap_google}',
            `as_sitemap_bing` = '{$as_sitemap_bing}',
            `as_sitemap_addurl` = '{$as_sitemap_addurl}', 
            `as_sitemap_boardcount` = '{$as_sitemap_boardcount}', 
            `as_sitemap_boardlist` = '{$as_sitemap_boardlist}',
            `as_sitemap_contentslist` = '{$as_sitemap_contentslist}',
            `as_sitemap_faq` = '{$as_sitemap_faq}'
            ";
sql_query($sql, false);

sql_query(" OPTIMIZE TABLE `$g5[config_table]` ");
//sitemap 자동 제출
//http://www.google.com/ping?sitemap=url
//http://www.bing.com/ping?sitemap=url

/**
 * Curl 사이트맵 제출용
 */
function curl_sitemap($url){
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $output = curl_exec($ch); 
    curl_close($ch);    
}

if($as_sitemap_bing){
    curl_sitemap('http://www.bing.com/ping?sitemap='. G5_URL . '/sitemap.php');
}
if($as_sitemap_google){
    curl_sitemap('//http://www.google.com/ping?sitemap='. G5_URL . '/sitemap.php');
}

goto_url('./ask_seo_form.php', false);