<?php
include_once('./_common.php');

if( !isset($it) && !get_session("ss_tv_idx") ){
    if( !headers_sent() ){  //헤더를 보내기 전이면 검색엔진에서 제외합니다.
        echo '<meta name="robots" content="noindex, nofollow">';
    }
    /*
    if( !G5_IS_MOBILE ){    //PC 에서는 검색엔진 화면에 노출하지 않도록 수정
        return;
    }
    */
}

// wetoz : naverpayorder 
if ($default['de_naverpayorder_AccessLicense'] && $default['de_naverpayorder_SecretKey']) {
    include_once(G5_PLUGIN_PATH.'/wznaverpay/config.php');
    $aor = new NHNAPIORDER();
    //$aor->PurchaseReviewClassType = 'GENERAL'; // 일반평가져오기
    //$aor->customersync_rotation('GetPurchaseReviewList-GENERAL');
    
    $aor = new NHNAPIORDER();
    //$aor->PurchaseReviewClassType = 'PREMIUM'; // 프리미엄평가져오기
    //$aor->customersync_rotation('GetPurchaseReviewList-PREMIUM');
}
// wetoz : naverpayorder

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/itemuse.php');
    return;
}

include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// 현재페이지, 총페이지수, 한페이지에 보여줄 행, URL
function itemuse_page($write_pages, $cur_page, $total_page, $url, $add="")
{
    //$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
    $url = preg_replace('#&amp;page=[0-9]*#', '', $url) . '&amp;page=';

    $str = '';
    if ($cur_page > 1) {
        $str .= '<a href="'.$url.'1'.$add.'" class="pg_page pg_start">처음</a>'.PHP_EOL;
    }

    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) $str .= '<a href="'.$url.($start_page-1).$add.'" class="pg_page pg_prev">이전</a>'.PHP_EOL;

    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k)
                $str .= '<a href="'.$url.$k.$add.'" class="pg_page">'.$k.'</a><span class="sound_only">페이지</span>'.PHP_EOL;
            else
                $str .= '<span class="sound_only">열린</span><strong class="pg_current">'.$k.'</strong><span class="sound_only">페이지</span>'.PHP_EOL;
        }
    }

    if ($total_page > $end_page) $str .= '<a href="'.$url.($end_page+1).$add.'" class="pg_page pg_next">다음</a>'.PHP_EOL;

    if ($cur_page < $total_page) {
        $str .= '<a href="'.$url.$total_page.$add.'" class="pg_page pg_end">맨끝</a>'.PHP_EOL;
    }

    if ($str)
        return "<nav class=\"pg_wrap\"><span class=\"pg\">{$str}</span></nav>";
    else
        return "";
}

$photo_review = $_GET['photo'];

if($photo_review == y) {
    $photo_sql = "and is_content like '%img%'";
}

$itemuse_list = "./itemuselist.php";
$itemuse_form = "./itemuseform.php?it_id=".$it_id;
$itemuse_formupdate = "./itemuseformupdate.php?it_id=".$it_id;

$sql_common = " from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' and is_confirm = '1' $photo_sql ";

// 테이블의 전체 레코드수만 얻음
$sql = " select COUNT(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 5;
$total_page  = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 레코드 구함

$sql = "select * $sql_common order by is_time desc limit $from_record, $rows ";
$result = sql_query($sql);

$sql_common1 = " from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' and is_confirm = '1' ";

// 테이블의 전체리뷰 레코드수만 얻음
$sql1 = " select COUNT(*) as cnt " . $sql_common1;
$row1 = sql_fetch($sql1);
$total_count1 = $row1['cnt'];

$sql_common2 = " from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' and is_confirm = '1' and is_content like '%img%'";

// 테이블의 포토리뷰 레코드수만 얻음
$sql2 = " select COUNT(*) as cnt " . $sql_common2;
$row2 = sql_fetch($sql2);
$total_count2 = $row2['cnt'];

// 상품의 리뷰 평점을 얻음
$sql_common3 = " from `{$g5['g5_shop_item_table']}` where it_id = '{$it_id}' ";

$sql = " select * " . $sql_common3;
$row3 = sql_fetch($sql);
$use_avg = $row3['it_use_avg'];

if($use_avg == 0) $use_avg = 5.0;


$itemuse_skin = G5_SHOP_SKIN_PATH.'/itemuse.skin.php';

if(!file_exists($itemuse_skin)) {
    echo str_replace(G5_PATH.'/', '', $itemuse_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($itemuse_skin);
}
?>