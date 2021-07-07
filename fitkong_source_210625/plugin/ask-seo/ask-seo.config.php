<?php

if (!defined('_GNUBOARD_')) {
    exit;
}
/**
 * ASK SEO
 * 환경설정
 * 게시판 설정 여분필드 사용 설정 및 그룹 여분필드 사용설정
 * META Keywords 및 Description 입력을 게시판설정 여분필드(bo_1 ~ bo_10) 및 그룹설정 여분필드(gr_1 ~ gr_10) 중에서 선택 할 수 있습니다.
 * 기본으로 bo_7 및 bo_8번, gr_7번 및 gr_8번 사용.
 * 게시물 작성시 여분필드는 (wr_1 ~ wr_10) 중에서 선택 할 수 있습니다.
 * 이미 사용중인 필드라면 변경해서 사용하세요.
 */

//파일저장위치
define('AS_SAVE_DIR', G5_DATA_PATH . '/aslogo');
define('AS_SAVE_URL', G5_DATA_URL . '/aslogo');

//게시판설정 여분필드 검색차단 설정
define('AS_BOARD_NOINDEX_FIELD', 'bo_6');
//게시판설정 여분필드 키워드용 설정
define('AS_BOARD_KEYWORDS_FIELD', 'bo_7');
//게시판설정 여분필드 설명용 설정
define('AS_BOARD_DESCRIPTION_FIELD', 'bo_8');

//그룹설정 여분필드 키워드용 설정
define('AS_GROUP_KEYWORDS_FIELD', 'gr_7');
//그룹설정 여분필드 설명용 설정
define('AS_GROUP_DESCRIPTION_FIELD', 'gr_8');

//글쓰기 여분필드 TITLE용
define('AS_WRITE_TITLE_FIELD', 'wr_6');
//글쓰기 여분필드 키워드용 설정
define('AS_WRITE_KEYWORDS_FIELD', 'wr_7');
//글쓰기 여분필드 설명용 설정
define('AS_WRITE_DESCRIPTION_FIELD', 'wr_8');
