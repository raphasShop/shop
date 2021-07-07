<?php
include_once('./_common.php');

if (!$is_member) {
    alert_close("사용후기는 회원만 작성이 가능합니다.");
}

$it_id       = trim($_REQUEST['it_id']);
$od_id       = trim($_REQUEST['od_id']);
$ps  = trim($_POST['ps']);
$is_subject  = trim($_POST['is_subject']);
$is_content  = trim($_POST['is_content']);
$is_content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $is_content);
$is_name     = trim($_POST['is_name']);
$is_password = trim($_POST['is_password']);
$is_score    = (int)$_POST['is_score'] > 5 ? 0 : (int)$_POST['is_score'];
$get_editor_img_mode = $config['cf_editor'] ? false : true;
$is_id       = (int) trim($_REQUEST['is_id']);

// 사용후기 작성 설정에 따른 체크
check_itemuse_write($it_id, $member['mb_id']);


if ($w == "" || $w == "u") {
    $is_name     = addslashes(strip_tags($member['mb_name']));
    $is_password = $member['mb_password'];

    if (!$is_subject) alert("제목을 입력하여 주십시오.");
    if (!$is_content) alert("내용을 입력하여 주십시오.");
}

if($is_mobile_shop)
    $url = './orderlist.php?ps='.$ps;
else
    $url = "./orderlist.php?ps=".$ps;

if ($w == "")
{
    /*
    $sql = " select max(is_id) as max_is_id from {$g5['g5_shop_item_use_table']} ";
    $row = sql_fetch($sql);
    $max_is_id = $row['max_is_id'];

    $sql = " select max(is_id) as max_is_id from {$g5['g5_shop_item_use_table']} where it_id = '$it_id' and mb_id = '{$member['mb_id']}' ";
    $row = sql_fetch($sql);
    if ($row['max_is_id'] && $row['max_is_id'] == $max_is_id)
        alert("같은 상품에 대하여 계속해서 평가하실 수 없습니다.");
    */

    // 사용후기 주소 변조 체크
    check_itemuse_modulation($od_id, $member['mb_id']);

    $sql = "insert {$g5['g5_shop_item_use_table']}
               set it_id = '$it_id',
                   mb_id = '{$member['mb_id']}',
                   is_score = '$is_score',
                   is_name = '$is_name',
                   is_password = '$is_password',
                   is_subject = '$is_subject',
                   is_content = '$is_content',
                   is_time = '".G5_TIME_YMDHIS."',
                   is_ip = '{$_SERVER['REMOTE_ADDR']}' ";
    if (!$default['de_item_use_use'])
        $sql .= ", is_confirm = '1' ";
    sql_query($sql);

    if ($default['de_item_use_use']) {
        $alert_msg = "평가하신 글은 관리자가 확인한 후에 출력됩니다.";
    }  else {
        $alert_msg = "사용후기가 등록 되었습니다.";

        $sql = " select * from {$g5['g5_shop_item_use_relation_table']} where it_id = '$it_id' ";
        $res = sql_query($sql);
        for($i=0; $row=sql_fetch_array($res); $i++) {
           $re_it_id = $row['it_id2'];
           $sql2 = "insert {$g5['g5_shop_item_use_table']}
                       set it_id = '$re_it_id',
                           mb_id = '{$member['mb_id']}',
                           is_score = '$is_score',
                           is_name = '$is_name',
                           is_password = '$is_password',
                           is_subject = '$is_subject',
                           is_content = '$is_content',
                           is_time = '".G5_TIME_YMDHIS."',
                           is_ip = '{$_SERVER['REMOTE_ADDR']}' ";
            if (!$default['de_item_use_use'])
                $sql2 .= ", is_confirm = '1' ";
            sql_query($sql2);

            update_use_cnt($re_it_id);
            update_use_avg($re_it_id);
        }

        $mb_id = $member['mb_id'];
        $re = sql_fetch(" select * from {$g5['g5_shop_review_event_table']} where it_id = '$it_id' "); // 리뷰 이벤트 조회
        $rel = sql_fetch(" select * from {$g5['g5_shop_review_event_log_table']} where od_id = '$od_id' and mb_id = '$mb_id' "); // 리뷰 이벤트 조회
        $itit = sql_fetch(" select it_name from {$g5['g5_shop_item_table']} where it_id = '$it_id' "); // 상품조회
        $point = 100;               // 일반리뷰 포인트
        $point_img = 500;       // 포토리뷰 포인트
        $re_id = $re['re_id'];

        if(!$rel && $re && $re['re_start'] <= G5_TIME_YMD && $re['re_end'] >= G5_TIME_YMD ) {
            if($re['re_type'] == 0){
                $j = 0;
                $create_coupon = false;

                do {
                    $cp_id = get_coupon_id();

                    $sql3 = " select count(*) as cnt from {$g5['g5_shop_coupon_table']} where cp_id = '$cp_id' ";
                    $row3 = sql_fetch($sql3);

                    if(!$row3['cnt']) {
                        $create_coupon = true;
                        break;
                    } else {
                        if($j > 20)
                            break;
                    }
                } while(1);

                if($create_coupon) {
                    if(@preg_match("/img/", $is_content)){      // 포토리뷰 작성시
                        $cp_subject = $re['pr_cp_subject'];
                        $cp_method = $re['pr_cp_method'];
                        $cp_target = $re['pr_cp_target'];
                        $cp_start = $re['pr_cp_start'];
                        $cp_end =  $re['pr_cp_end'];
                        $cp_type =  $re['pr_cp_type'];
                        $cp_price =  $re['pr_cp_price'];
                        $cp_trunc =  $re['pr_cp_trunc'];
                        $cp_minimum = $re['pr_cp_minimum'];
                        $cp_maximum =  $re['pr_cp_maximum'];
                    } else {
                        $cp_subject = $re['br_cp_subject'];
                        $cp_method = $re['br_cp_method'];
                        $cp_target = $re['br_cp_target'];
                        $cp_start = $re['br_cp_start'];
                        $cp_end =  $re['br_cp_end'];
                        $cp_type =  $re['br_cp_type'];
                        $cp_price =  $re['br_cp_price'];
                        $cp_trunc =  $re['br_cp_trunc'];
                        $cp_minimum = $re['br_cp_minimum'];
                        $cp_maximum =  $re['br_cp_maximum'];
                    }

                    $mb_id = $member['mb_id'];

                    $sql4 = " INSERT INTO {$g5['g5_shop_coupon_table']}
                                ( cp_id, cp_subject, cp_method, cp_target, mb_id, cp_start, cp_end, cp_type, cp_price, cp_trunc, cp_minimum, cp_maximum, cp_datetime )
                            VALUES
                                ( '$cp_id', '$cp_subject', '$cp_method', '$cp_target', '$mb_id', '$cp_start', '$cp_end', '$cp_type', '$cp_price', '$cp_trunc', '$cp_minimum', '$cp_maximum', '".G5_TIME_YMDHIS."' ) ";

                    $res = sql_query($sql4, false);

                    if($res) {
                        set_session('ss_member_reg_coupon', 1);

                    }
                }
            } else {
                $point = $re['br_point'];               // 일반리뷰 포인트
                $point_img = $re['pr_point'];           // 포토리뷰 포인트
                if(@preg_match("/img/", $is_content)){      // 포토리뷰 작성시
                    insert_point($member[mb_id], $point_img, $itit[it_name].' 상품 포토리뷰 작성', '@review', $mb_id."/".$it_id, '리뷰작성');
                }else{                                                                                  // 일반리뷰 작성시
                    insert_point($member[mb_id], $point, $itit[it_name].' 상품 일반리뷰 작성', '@review', $mb_id."/".$it_id, '리뷰작성');
                }
            }

            $sql5 = " INSERT INTO {$g5['g5_shop_review_event_log_table']}
                        ( re_id, od_id, mb_id, rel_time )
                    VALUES
                        ( '$re_id', '$od_id', '$mb_id', '".G5_TIME_YMDHIS."' ) ";

            $res = sql_query($sql5, false);
        } else {
            if(@preg_match("/img/", $is_content)){      // 포토리뷰 작성시
                insert_point($member[mb_id], $point_img, $itit[it_name].' 상품 포토리뷰 작성', '@review', $mb_id."/".$it_id, '리뷰작성');
            }else{                                                                                  // 일반리뷰 작성시
                insert_point($member[mb_id], $point, $itit[it_name].' 상품 일반리뷰 작성', '@review', $mb_id."/".$it_id, '리뷰작성');
            }
        }
       
        // 사용자 후기작성시 포인트 쌓기 끝
        // 즉시 출력일때만 쌓기 끝
    }
}
else if ($w == "u")
{
    $sql = " select is_password from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' ";

    $row = sql_fetch($sql);
    if ($row['is_password'] != $is_password)
        alert("비밀번호가 틀리므로 수정하실 수 없습니다.");

    $sql = " update {$g5['g5_shop_item_use_table']}
                set is_subject = '$is_subject',
                    is_content = '$is_content',
                    is_score = '$is_score'
              where is_id = '$is_id' ";
    sql_query($sql);

    $alert_msg = "사용후기가 수정 되었습니다.";
}
else if ($w == "d")
{
    if (!$is_admin)
    {
        $sql = " select count(*) as cnt from {$g5['g5_shop_item_use_table']} where mb_id = '{$member['mb_id']}' and is_id = '$is_id' ";
        $row = sql_fetch($sql);
        if (!$row['cnt'])
            alert("자신의 사용후기만 삭제하실 수 있습니다.");
    }

    // 에디터로 첨부된 이미지 삭제
    $sql = " select is_content from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' and md5(concat(is_id,is_time,is_ip)) = '{$hash}' ";
    $row = sql_fetch($sql);

    $imgs = get_editor_image($row['is_content'], $get_editor_img_mode);

    for($i=0;$i<count($imgs[1]);$i++) {
        $p = parse_url($imgs[1][$i]);
        if(strpos($p['path'], "/data/") != 0)
            $data_path = preg_replace("/^\/.*\/data/", "/data", $p['path']);
        else
            $data_path = $p['path'];


        if( preg_match('/(gif|jpe?g|bmp|png)$/i', strtolower(end(explode('.', $data_path))) ) ){

            $destfile = ( ! preg_match('/\w+\/\.\.\//', $data_path) ) ? G5_PATH.$data_path : '';

            if($destfile && preg_match('/\/data\/editor\/[A-Za-z0-9_]{1,20}\//', $destfile) && is_file($destfile))
                @unlink($destfile);
        }
    }

    $sql = " delete from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' and md5(concat(is_id,is_time,is_ip)) = '{$hash}' ";
    sql_query($sql);

    $alert_msg = "사용후기를 삭제 하였습니다.";
}

//쇼핑몰 설정에서 사용후기가 즉시 출력일 경우
if( ! $default['de_item_use_use'] ){
    update_use_cnt($it_id);
    update_use_avg($it_id);
}

if($w == 'd')
    alert($alert_msg, $url);
else
    alert($alert_msg, $url);
?>