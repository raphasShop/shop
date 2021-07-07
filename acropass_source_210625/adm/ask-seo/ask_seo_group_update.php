<?php
/**
 * 게시판 그룹 SEO 설정 저장
 */
$sub_menu = "100981";
include_once './_common.php';

check_demo();

auth_check($auth[$sub_menu], 'w');
if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}
check_admin_token();

$count = count($_POST['chk']);

if (!$count) {
    alert($_POST['act_button'] . '할 게시판그룹을 1개이상 선택해 주세요.');
}

for ($i = 0; $i < $count; $i++) {
    $k     = $_POST['chk'][$i];
    $gr_id = $_POST['group_id'][$k];

    if ($_POST['act_button'] == '선택수정') {
        $sql = " update {$g5['group_table']}
                    set " . AS_GROUP_KEYWORDS_FIELD . "     = '" . $_POST[AS_GROUP_KEYWORDS_FIELD][$k] . "',
                    " . AS_GROUP_DESCRIPTION_FIELD . "      = '" . $_POST[AS_GROUP_DESCRIPTION_FIELD][$k] . "',
                        " . AS_GROUP_KEYWORDS_FIELD . "_subj       = '" . $_POST[AS_GROUP_KEYWORDS_FIELD . '_subj'][$k] . "',
                        " . AS_GROUP_DESCRIPTION_FIELD . "_subj       = '" . $_POST[AS_GROUP_DESCRIPTION_FIELD . '_subj'][$k] . "'
                  where gr_id           = '{$gr_id}' ";
        sql_query($sql);
    }
}

goto_url('./ask_seo_group.php?' . $qstr);