<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


/************************************************************************

■ 아이스크림 전용 검색엔진최적화 SEO 메타태그 출력 시작 { --

************************************************************************/
// 기본정보
$seo_thumb_width = 1200;
$seo_thumb_height = 630;
$g5_head_title = str_replace("&gt;","＞",$g5_head_title); //타이틀

// [데이터추출] 게시판 데이터 추출
if ($bo_table) {
    $sql_seo_board = " select * from {$g5['write_prefix']}{$bo_table}  ";
        if ($wr_id) {
            $sql_seo_board .= " where wr_id='{$wr_id}' ";
        }
    $result_seo_board = sql_query($sql_seo_board);
    $row_seo_board = sql_fetch_array($result_seo_board);

    $desc_board1 = str_replace("&nbsp;"," ",$row_seo_board['wr_content']);
    $desc_board1 = strip_tags($desc_board1); // 긴문장
    $desc_board2 = cut_str($desc_board1,150); // 150자
	
	include_once(G5_LIB_PATH.'/thumbnail.lib.php');
	$thumb = get_list_thumbnail($bo_table, $wr_id, $seo_thumb_width, $seo_thumb_height);
	if($thumb['src']) {
        $seo_thumb_url = $thumb['src'];
    } else {
        $seo_thumb_url = G5_DATA_URL.'/common/seo_img.jpg">';
    }
}

// [데이터추출] 내용 데이터 추출
if ($co_id) {
    $sql_seo_content = " select * from {$g5['content_table']} ";
        if ($co_id) {
            $sql_seo_content .= " where co_id = '{$co_id}' ";
        }
    $result_seo_content = sql_query($sql_seo_content);
    $row_seo_content = sql_fetch_array($result_seo_content);

    $desc_content1 = str_replace("&nbsp;"," ",$row_seo_content['co_content']);
    $desc_content1 = strip_tags($desc_content1); // 긴문장
    $desc_content2 = cut_str($desc_content1,150); // 150자
	// 내용,콘텐츠관리는 썸네일이 없습니다
}

// [데이터추출] 쇼핑몰 상품 데이터 추출
if ($it_id) {
    $sql_seo_item = " select * from {$g5['g5_shop_item_table']} ";
        if ($it_id) {
            $sql_seo_item .= " where it_id='{$it_id}' ";
        }
    $result_seo_item = sql_query($sql_seo_item);
    $row_seo_item = sql_fetch_array($result_seo_item);
	
	$desc_item_maker = $row_seo_item['it_maker']; //제조사
	$desc_item_brand = $row_seo_item['it_brand']; //브랜드
	$desc_item_price = number_format($row_seo_item['it_price']); //판매가격

    if($row_seo_item['it_basic']) {
	$desc_item1 = str_replace("&nbsp;"," ",$row_seo_item['it_basic']); //상품요약정보
	} else {
	$desc_item1 = str_replace("&nbsp;"," ",$row_seo_item['it_explan']); //상품정보
	}
    $desc_item1 = strip_tags($desc_item1); // 상품정보 긴문장
    $desc_item2 = cut_str($desc_item1,150); // 상품정보 150자
	$desc_item3 = '('.$desc_item_maker.') ￦'.$desc_item_price.', '.$desc_item2; // 제조사,판매가격,상품정보150자
	
	if($row_seo_item['it_img1']) {
	    $seo_itemimg = G5_DATA_URL.'/item/'.$row_seo_item['it_img1'];
	} else {
        $seo_itemimg = G5_DATA_URL.'/common/seo_img.jpg">';
    }
}


// 아이스크림 전용 메타태그

    /****** 기본 메타태그 ******/
	echo '<meta name="Subject" content="'.$g5_head_title.'">'.PHP_EOL; //홈페이지주제
    echo '<meta name="Title" content="'.$g5_head_title.'">'.PHP_EOL; //페이지제목
    echo '<meta name="Author" content="'.$config['cf_meta_author'].'">'.PHP_EOL; //작성자(기본)
    
	if ($bo_table) {// ◆게시물
	echo '<meta name="Description" content="'.$desc_board2.','.$config['cf_meta_keyword'].'">'.PHP_EOL; //설명150자이내(게시물내용)
	} else if ($co_id) {// ◆내용페이지
	echo '<meta name="Description" content="'.$desc_content2.','.$config['cf_meta_keyword'].'">'.PHP_EOL; //설명150자이내(게시물내용)
	} else if ($it_id) {// ◆상품페이지
	echo '<meta name="Description" content="'.$desc_item3.','.$config['cf_meta_keyword'].'">'.PHP_EOL; //설명150자이내(게시물내용)
    } else {// ◆기본
	echo '<meta name="Description" content="'.$config['cf_meta_description'].','.$config['cf_meta_keyword'].'">'.PHP_EOL; //설명(기본)
	}
	
    echo '<meta name="Keywords" content="'.$config['cf_meta_keyword'].'">'.PHP_EOL; //키워드
	
	/****** 오픈그래프 ******/
	echo '<meta property="og:type" content="website">'.PHP_EOL; //사이트종류:website로 고정 ex) website, article, place, product, event, 등으로 표시가능
	echo '<meta property="og:title" content="'.$g5_head_title.'">'.PHP_EOL; //Og:페이지타이틀
	echo '<meta property="og:description" content="'.$config['cf_meta_description'].'">'.PHP_EOL; //Og:설명
	echo '<meta property="og:url" content="'.G5_URL.$_SERVER['REQUEST_URI'].'">'.PHP_EOL; //Og:접속주소
	echo '<meta property="og:site_name" content="'.$config['cf_title'].'">'.PHP_EOL; //Og:사이트제목
	
	if ($bo_table) {// ◆게시물
	echo '<meta property="og:description" content="'.$desc_board2.'">'.PHP_EOL; //Og:설명(게시판)
	echo '<meta property="og:image" content="'.$seo_thumb_url.'">'.PHP_EOL; //Og:SEO이미지(게시판)
	} else if ($co_id) {// ◆내용페이지
	echo '<meta property="og:description" content="'.$desc_content2.'">'.PHP_EOL; //Og:설명(내용페이지)
	echo '<meta property="og:image" content="'.G5_DATA_URL.'/common/seo_img.jpg">'.PHP_EOL; //Og:SEO이미지(내용페이지)
	} else if ($it_id) {// ◆상품페이지
	echo '<meta property="og:description" content="'.$desc_item3.'">'.PHP_EOL; //Og:설명(상품페이지)
	echo '<meta property="og:image" content="'.$seo_itemimg.'">'.PHP_EOL; //Og:SEO이미지(상품페이지)
	} else {// ◆기본
	echo '<meta property="og:description" content="'.$config['cf_meta_description'].'">'.PHP_EOL; //Og:설명(기본)
	echo '<meta property="og:image" content="'.G5_DATA_URL.'/common/seo_img.jpg">'.PHP_EOL; //Og:SEO이미지(기본)
	}
	
	/****** 소셜미디어 ******/
	echo '<meta name="twitter:card" content="summary">'.PHP_EOL; //twitter:summary
	echo '<meta name="twitter:title" content="'.$g5_head_title.'">'.PHP_EOL; //twitter:타이틀
	
	if ($bo_table) {// ◆게시물
	echo '<meta name="twitter:description" content="'.$desc_board2.','.$config['cf_meta_keyword'].'">'.PHP_EOL; //twitter:설명(게시물)
	echo '<meta name="twitter:image" content="'.$seo_thumb_url.'">'.PHP_EOL; //twitter:SEO이미지(게시물)
	} else if ($co_id) {// ◆내용페이지
	echo '<meta name="twitter:description" content="'.$desc_content2.','.$config['cf_meta_keyword'].'">'.PHP_EOL; //twitter:설명(내용페이지)
	} else if ($it_id) {// ◆상품페이지
	echo '<meta name="twitter:description" content="'.$desc_item3.','.$config['cf_meta_keyword'].'">'.PHP_EOL; //twitter:설명(상품페이지)
	echo '<meta name="twitter:image" content="'.$seo_itemimg.'">'.PHP_EOL; //twitter:SEO이미지(상품페이지)
	} else {// ◆기본
	echo '<meta name="twitter:description" content="'.$config['cf_meta_description'].','.$config['cf_meta_keyword'].'">'.PHP_EOL; //twitter:설명(기본)
	echo '<meta name="twitter:image" content="'.G5_DATA_URL.'/common/seo_img.jpg">'.PHP_EOL; //twitter:SEO이미지(기본)
	}
	
	echo '<meta name="twitter:domain" content="'.G5_URL.$_SERVER['REQUEST_URI'].'">'.PHP_EOL; //twitter:사이트주소

/************************************************************************

■ 아이스크림 전용 검색엔진최적화 SEO 메타태그 출력 끝 -- }

************************************************************************/
?>

<?php
// 추가 메타태그 (추가 또는 일반테마일 경우)
if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;
?>