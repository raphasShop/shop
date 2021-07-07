<?php
include_once('./_common.php');

// 테마에 mypage.php 있으면 include
if(defined('G5_THEME_SHOP_PATH')) {
    $theme_mypage_file = G5_THEME_MSHOP_PATH.'/mypage.php';
    if(is_file($theme_mypage_file)) {
        include_once($theme_mypage_file);
        return;
        unset($theme_mypage_file);
    }
}

$g5['title'] = '마이페이지';
include_once(G5_MSHOP_PATH.'/_head.php');

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
   
?>



<div id="top_sub_gnb">
    <div class="top_sub_wrap">마이페이지</div>
    <div class="top_back_btn"><a href="<?php echo G5_URL; ?>"><i class="xi-angle-left"></i></a></div>
</div>
<div id="mypage_m">
    <section id="mypage_user_info">
        <div class="user_lv_type">
            <?php if ($member['mb_level'] == 2) { 
                echo '실버';
            } else if ($member['mb_level'] == 3) {
                echo '골드';
            } else if ($member['mb_level'] == 4) {
                echo 'VIP';
            } else if ($member['mb_level'] == 5) {
                echo '임직원';
            } else if ($member['mb_level'] > 5) {
                echo '관리자';
            } else {
                echo '비회원';
            } ?>
        </div>
        <div class="user_name"><span><?php echo $member['mb_name']; ?> (<?php echo $member['mb_id']; ?>)</span> 님</div>
        <a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php"><div class="user_setting"><i class="xi-cog"></i></div></a>
        <div>
            <a href="<?php echo G5_BBS_URL; ?>/point.php"><div class="user_point">적립금<span><?php echo number_format($member['mb_point']); ?></span></div></a><a href="<?php echo G5_SHOP_URL; ?>/coupon.php"><div class="user_coupon">쿠폰<span><?php echo number_format($cp_count); ?></span></div></a>
        </div>
        <div class="mypage_list_wrap">
            <ul>
                <a href="<?php echo G5_SHOP_URL; ?>/wishlist.php"><li class="mypage_list_menu">관심상품<i class="xi-angle-right-min"></i></li></a>
                <a href="<?php echo G5_SHOP_URL; ?>/cart.php"><li class="mypage_list_menu">장바구니<i class="xi-angle-right-min"></i></li></a>
            </ul>
        </div>
        <div class="mypage_order_wrap">
            <div class="mypage_order_title">주문배송조회</div>
            <div class="mypage_order_process">
            <a href="<?php echo G5_SHOP_URL; ?>/orderlist.php?ps=ps1"><div class="order_process_phase"><?php echo $order_ps1_count; ?></div></a><div class="order_process_angle"><i class="xi-angle-right-min"></i></div><a href="<?php echo G5_SHOP_URL; ?>/orderlist.php?ps=ps2"><div class="order_process_phase"><?php echo $order_ps2_count; ?></div><div class="order_process_angle"><i class="xi-angle-right-min"></i></div><a href="<?php echo G5_SHOP_URL; ?>/orderlist.php?ps=ps3"><div class="order_process_phase"><?php echo $order_ps3_count; ?></div><div class="order_process_angle"><i class="xi-angle-right-min"></i></div><a href="<?php echo G5_SHOP_URL; ?>/orderlist.php?ps=ps4"><div class="order_process_phase"><?php echo $order_ps4_count; ?></div><div class="order_process_angle"><i class="xi-angle-right-min"></i></div><a href="<?php echo G5_SHOP_URL; ?>/orderlist.php?ps=ps5"><div class="order_process_phase"><?php echo $order_ps5_count; ?></div>
            </div>
            <div class="mypage_order_process_sub">
                <div class="order_process_title">입금대기중</div><div class="order_process_blank"></div><div class="order_process_title">결제완료</div><div class="order_process_blank"></div><div class="order_process_title">상품준비중</div><div class="order_process_blank"></div><div class="order_process_title">배송중</div><div class="order_process_blank"></div><div class="order_process_title">배송완료</div>
            </div>
        </div>
        <div class="mypage_list_wrap">
            <ul>
                <a href="<?php echo G5_SHOP_URL; ?>/orderlist.php?ps=ps6"><li class="mypage_list_menu">취소/교환/반품<i class="xi-angle-right-min"></i></li></a>
            </ul>
        </div>
        <div class="mypage_list_wrap">
            <ul>
                <a href="<?php echo G5_BBS_URL; ?>/qalist.php"><li class="mypage_list_menu">나의 문의 내역<i class="xi-angle-right-min"></i></li></a>
                <a href="<?php echo G5_SHOP_URL; ?>/myitemuselist.php"><li class="mypage_list_menu">나의 리뷰 내역 <i class="xi-angle-right-min"></i></li></a>
            </ul>
        </div>
        <div class="mypage_btn_wrap">
            <a href="<?php echo G5_BBS_URL; ?>/logout.php"><div class="mypage_btn_black">로그아웃</div></a><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php" onclick="return member_leave();"><div class="mypage_btn_grey">회원탈퇴</div></a>
        </div>
    </section>
</div>
<div id="smb_my" style="display: none">

    <section id="smb_my_ov">
        <h2>회원정보 개요</h2>
        <div class="my_name">
            <img src="<?php echo G5_THEME_IMG_URL ;?>/no_profile.gif" alt="프로필이미지" width="20"> <strong><?php echo $member['mb_id'] ? $member['mb_name'] : '비회원'; ?></strong>님
            <ul class="smb_my_act">
                <?php if ($is_admin == 'super') { ?><li><a href="<?php echo G5_ADMIN_URL; ?>/" class="btn_admin">관리자</a></li><?php } ?>
                <li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php" class="btn01">정보수정</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php" onclick="return member_leave();" class="btn01">회원탈퇴</a></li>
            </ul>
        </div>
        <ul class="my_pocou">
            <li  class="my_cou">보유쿠폰<a href="<?php echo G5_SHOP_URL; ?>/coupon.php" target="_blank" class="win_coupon"><?php echo number_format($cp_count); ?></a></li>
            <li class="my_point">보유포인트
            <a href="<?php echo G5_BBS_URL; ?>/point.php" target="_blank" class="win_point"><?php echo number_format($member['mb_point']); ?>점</a></li>

        </ul>
        <div class="my_info">
            <div class="my_info_wr">
                <strong>연락처</strong>
                <span><?php echo ($member['mb_tel'] ? $member['mb_tel'] : '미등록'); ?></span>
            </div>
            <div class="my_info_wr">
                <strong>E-Mail</strong>
                <span><?php echo ($member['mb_email'] ? $member['mb_email'] : '미등록'); ?></span>
            </div>
            <div class="my_info_wr">
                <strong>최종접속일시</strong>
                <span><?php echo $member['mb_today_login']; ?></span>
             </div>
            <div class="my_info_wr">
            <strong>회원가입일시</strong>
                <span><?php echo $member['mb_datetime']; ?></span>
            </div>
            <div class="my_info_wr ov_addr">
                <strong>주소</strong>
                <span><?php echo sprintf("(%s%s)", $member['mb_zip1'], $member['mb_zip2']).' '.print_address($member['mb_addr1'], $member['mb_addr2'], $member['mb_addr3'], $member['mb_addr_jibeon']); ?></span>
            </div>
        </div>
        <div class="my_ov_btn"><button type="button" class="btn_op_area"><i class="fa fa-caret-down" aria-hidden="true"></i><span class="sound_only">상세정보 보기</span></button></div>

    </section>

    <script>
    
        $(".btn_op_area").on("click", function() {
            $(".my_info").toggle();
            $(".fa-caret-down").toggleClass("fa-caret-up")
        });

    </script>

    <section id="smb_my_od">
        <h2><a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php">최근 주문내역</a></h2>
        <?php
        // 최근 주문내역
        define("_ORDERINQUIRY_", true);

        $limit = " limit 0, 5 ";
        include G5_MSHOP_PATH.'/orderinquiry.sub.php';
        ?>
        <a href="<?php echo G5_SHOP_URL; ?>/orderinquiry.php" class="btn_more">더보기</a>
    </section>

    <section id="smb_my_wish" class="wishlist">
        <h2><a href="<?php echo G5_SHOP_URL; ?>/wishlist.php">최근 위시리스트</a></h2>

        <ul>
            <?php
            $sql = " select *
                       from {$g5['g5_shop_wish_table']} a,
                            {$g5['g5_shop_item_table']} b
                      where a.mb_id = '{$member['mb_id']}'
                        and a.it_id  = b.it_id
                      order by a.wi_id desc
                      limit 0, 6 ";
            $result = sql_query($sql);
            for ($i=0; $row = sql_fetch_array($result); $i++)
            {
                $image_w = 250;
                $image_h = 250;
                $image = get_it_image($row['it_id'], $image_w, $image_h, true);
                $list_left_pad = $image_w + 10;
            ?>

            <li>
                <div class="wish_img"><?php echo $image; ?></div>
                <div class="wish_info">
                    <a href="./item.php?it_id=<?php echo $row['it_id']; ?>" class="info_link"><?php echo stripslashes($row['it_name']); ?></a>
                     <span class="info_date"><?php echo substr($row['wi_time'], 2, 8); ?></span>
                </div>
            </li>

            <?php
            }

            if ($i == 0)
                echo '<li class="empty_list">보관 내역이 없습니다.</li>';
            ?>
        </ul>
         <a href="<?php echo G5_SHOP_URL; ?>/wishlist.php" class="btn_more">더보기</a>
    </section>

</div>

<script>
$(function() {
    $(".win_coupon").click(function() {
        var new_win = window.open($(this).attr("href"), "win_coupon", "left=100,top=100,width=700, height=600, scrollbars=1");
        new_win.focus();
        return false;
    });
});

function member_leave()
{
    return confirm('정말 회원에서 탈퇴 하시겠습니까?')
}
</script>

<?php
include_once(G5_MSHOP_PATH.'/_tail.php');
?>