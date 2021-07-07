<?php
/**
 * 게시판 SEO 설정 저장
 */

$sub_menu = "100982";
include_once './_common.php';

check_demo();

if (!count($_POST['chk'])) {
    alert($_POST['act_button'] . " 하실 항목을 하나 이상 체크하세요.");
}
if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}
check_admin_token();

if ($_POST['act_button'] == "선택수정") {

    auth_check($auth[$sub_menu], 'w');

    for ($i = 0; $i < count($_POST['chk']); $i++) {

        // 실제 번호를 넘김
        $k   = $_POST['chk'][$i];
        $sql = " update {$g5['board_table']}
                    set
                        " . AS_BOARD_NOINDEX_FIELD . "             = '" . sql_real_escape_string($_POST[AS_BOARD_NOINDEX_FIELD][$k]) . "',
                        " . AS_BOARD_NOINDEX_FIELD . "_subj        = '" . sql_real_escape_string($_POST[AS_BOARD_NOINDEX_FIELD . '_subj'][$k]) . "',
                        " . AS_BOARD_KEYWORDS_FIELD . "             = '" . sql_real_escape_string($_POST[AS_BOARD_KEYWORDS_FIELD][$k]) . "',
                        " . AS_BOARD_KEYWORDS_FIELD . "_subj        = '" . sql_real_escape_string($_POST[AS_BOARD_KEYWORDS_FIELD . '_subj'][$k]) . "',
                        " . AS_BOARD_DESCRIPTION_FIELD . "          = '" . sql_real_escape_string($_POST[AS_BOARD_DESCRIPTION_FIELD][$k]) . "',
                        " . AS_BOARD_DESCRIPTION_FIELD . "_subj     = '" . sql_real_escape_string($_POST[AS_BOARD_DESCRIPTION_FIELD . '_subj'][$k]) . "'
                  where bo_table            = '" . sql_real_escape_string($_POST['board_table'][$k]) . "' ";
        sql_query($sql, true);
    }

}
goto_url('./ask_seo_board.php?' . $qstr);
