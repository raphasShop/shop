<?php
include_once('./_common.php');

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL."/mypage.php"));

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/mypage.php');
    return;
}

// 테마에 mypage.php 있으면 include
if(defined('G5_THEME_SHOP_PATH')) {
    $theme_mypage_file = G5_THEME_SHOP_PATH.'/mypage.php';
    if(is_file($theme_mypage_file)) {
        include_once($theme_mypage_file);
        return;
        unset($theme_mypage_file);
    }
}

$g5['title'] = '마이페이지';
include_once('./_head.php');


// 쿠폰
$cp_count = 0;
$sql = " select cp_id
            from {$g5['g5_shop_coupon_table']}
            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."' ";
$res = sql_query($sql);

for($k=0; $cp=sql_fetch_array($res); $k++) {
    if(!is_used_coupon($member['mb_id'], $cp['cp_id']))
        $cp_count++;
}

$order_ps1_count = 0;
$order_ps2_count = 0;
$order_ps3_count = 0;
$order_ps4_count = 0;
$order_ps5_count = 0;
$order_ps6_count = 0;


$sql = " select *,
            (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
           from {$g5['g5_shop_order_table']}
          where mb_id = '{$member['mb_id']}'
          order by od_id desc";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++)
{
    switch($row['od_status']) {
        case '주문':
            $order_ps1_count++;
            break;
        case '입금':
            $order_ps2_count++;
            break;
        case '준비':
            $order_ps3_count++;
            break;
        case '배송':
            $order_ps4_count++;
            break;
        case '완료':
            $order_ps5_count++;
            break;
        default:
            $order_ps6_count++;
            break;
    }
}

if ($member['mb_level'] == 2) { 
    $mb_grade = '핏콩웰컴';
} else if ($member['mb_level'] == 3) {
    $mb_grade = '핏콩프렌즈';
} else if ($member['mb_level'] == 4) {
   $mb_grade = '핏콩서포터';
} else if ($member['mb_level'] == 5) {
   $mb_grade = '핏콩패밀리';
} else if ($member['mb_level'] >= 6) {
   $mb_grade = '관리자';
} else {
   $mb_grade = '비회원';
}

?>

<div id="mypage_wrap">
    <div class="mypage_top_wrap">
        <div class="mypage_top_profile_wrap">
            <img src="<?php echo G5_IMG_URL ?>/register_icon.png" class="mypage_top_profile">
        </div>
        <div class="mypage_top_info_wrap">
            <div class="mypage_top_member_level"><?php echo $mb_grade; ?></div>
            <div class="mypage_top_info_name"><?php echo $member['mb_name']; ?> (<?php echo $member['mb_id']; ?>) 님</div>
            <a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php"><div class="mypage_top_info_modify"><img src="<?php echo G5_IMG_URL ?>/register_setting_icon.png"> 정보변경</div></a>
            <a href="<?php echo G5_SHOP_URL; ?>/coupon.php" ><div class="mypage_top_info_coupon">쿠폰<span><?php echo number_format($cp_count); ?> 개</span></div></a>
            <a href="<?php echo G5_BBS_URL; ?>/point.php" ><div class="mypage_top_info_point">적립금<span><?php echo number_format($member['mb_point']); ?> 원</span></div></a>
        </div>
    </div>
    
    <div class="mypage_menu_wrap">
        <a href="<?php echo G5_SHOP_URL; ?>/wishlist.php">
        <div class="mypage_menu">관심상품</div>
        <div class="mypage_menu_arrow"><img src="<?php echo G5_IMG_URL ?>/register_arrow.png"></div>
        </a>
    </div>
    <div class="mypage_menu_wrap">
        <a href="<?php echo G5_SHOP_URL; ?>/cart.php">
        <div class="mypage_menu">장바구니</div>
        <div class="mypage_menu_arrow"><img src="<?php echo G5_IMG_URL ?>/register_arrow.png"></div>
        </a>
    </div>
    <div class="mypage_menu_wrap">
        <a href="<?php echo G5_SHOP_URL; ?>/orderlist.php">
        <div class="mypage_menu">주문내역조회</div>
        <div class="mypage_menu_arrow"><img src="<?php echo G5_IMG_URL ?>/register_arrow.png"></div>
        </a>
    </div>
    <div class="mypage_menu_wrap">
        <a href="<?php echo G5_BBS_URL; ?>/qalist.php">
        <div class="mypage_menu">나의 문의내역</div>
        <div class="mypage_menu_arrow"><img src="<?php echo G5_IMG_URL ?>/register_arrow.png"></div>
        </a>
    </div>
    <div class="mypage_menu_wrap">
        <a href="<?php echo G5_SHOP_URL; ?>/myitemuselist.php">
        <div class="mypage_menu">나의 리뷰내역</div>
        <div class="mypage_menu_arrow"><img src="<?php echo G5_IMG_URL ?>/register_arrow.png"></div>
        </a>
    </div>
    <div class="mypage_logout_btn_wrap">
        <a href="<?php echo G5_BBS_URL; ?>/logout.php"><div class="mypage_logout_btn">로그아웃</div></a>
    </div>
</div>

<script>
function member_leave()
{
    return confirm('정말 회원에서 탈퇴 하시겠습니까?')
}
</script>
<!-- } 마이페이지 끝 -->

<?php
include_once("./_tail.php");
?>