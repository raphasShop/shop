<?php
if (!defined('_GNUBOARD_')) exit;

/*
아이스크림 NEW관리자모드에만 추가된 LIB 추가항목입니다
since 2018
*/


/* [관리자모드BBS] 관리자모드 게시판 연결추가 - 아이스크림 추가*/
define('G5_ADMIN_BBS_DIR',        G5_ADMIN_DIR.'/'.G5_BBS_DIR);
define('G5_ADMIN_BBS_URL',        G5_URL.'/'.G5_ADMIN_BBS_DIR); // 정상작동하지않음
define('G5_ADMIN_BBS_PATH',       G5_PATH.'/'.G5_ADMIN_BBS_DIR); // 절대경로인 G5_ADMIN_BBS_PATH 사용
define('G5_ADMIN_HTTP_BBS_URL',  https_url(G5_ADMIN_BBS_DIR, false));
define('G5_ADMIN_HTTPS_BBS_URL', https_url(G5_ADMIN_BBS_DIR, true));
/* */


// 회원권한과 권한명(그룹)을 SELECT 형식으로 얻음 - 아이스크림 추가
function get_member_level_select2($name, $start_id=0, $end_id=10, $selected="", $event="")
{
    global $g5,$config;

    $str = "\n<select id=\"{$name}\" name=\"{$name}\"";
    if ($event) $str .= " $event";
    $str .= ">\n";
    for ($i=$start_id; $i<=$end_id; $i++) {
        $str .= '<option value="'.$i.'"';
        if ($i == $selected)
            $str .= ' selected="selected"';
        $str .= ">{$i} ".$config['lev_cf_'.$i]."</option>\n";
    }
    $str .= "</select>\n";
    return $str;
}

?>