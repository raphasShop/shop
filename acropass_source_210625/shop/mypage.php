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

?>
<div class="my_title_wrap">
    <div class="my_main_title">마이페이지</div>
    <div class="my_sub_title"></div>
</div>
<div id="mypage_pc_wrap">

<div id="mypage_info">
   
</div>
<!-- 마이페이지 시작 { -->
<div id="smb_my">

    <!-- 회원정보 개요 시작 { -->
    <section id="smb_my_ov">
        <h2>회원정보 개요</h2>
        <strong class="my_ov_name"><?php echo $member['mb_name']; ?> (<?php echo $member['mb_id']; ?>) 님 <a href="<?php echo G5_SHOP_URL; ?>/membership.php"><span class="my_lv_type">
            <?php if ($member['mb_level'] == 2) { 
                echo '실버';
            } else if ($member['mb_level'] == 3) {
                echo '골드';
            } else if ($member['mb_level'] == 4) {
                echo 'VIP';
            } else if ($member['mb_level'] == 5) {
                echo '임직원';
            } else if ($member['mb_level'] >= 6) {
                echo '관리자';
            } else {
                echo '비회원';
            } ?>
        </span></a></strong>  
        <dl class="cou_pt">
            <dt>적립금</dt>
            <dd><a href="<?php echo G5_BBS_URL; ?>/point.php" ><?php echo number_format($member['mb_point']); ?></a> 점</dd>
            <dt>보유쿠폰</dt>
            <dd><a href="<?php echo G5_SHOP_URL; ?>/coupon.php" ><?php echo number_format($cp_count); ?></a></dd>
        </dl>
        <div id="smb_my_act">
            <ul>
                <?php if ($is_admin == 'super') { ?><li><a href="<?php echo G5_ADMIN_URL; ?>/" class="btn_admin">관리자</a></li><?php } ?>
                <li><a href="<?php echo G5_BBS_URL; ?>/logout.php" class="btn03">로그아웃</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php" class="btn01">회원정보수정</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php" onclick="return member_leave();" class="btn01">회원탈퇴</a></li>
            </ul>
        </div>

        <dl class="op_area">
            <dt>연락처</dt>
            <dd><?php echo ($member['mb_tel'] ? $member['mb_tel'] : '미등록'); ?></dd>
            <dt>E-Mail</dt>
            <dd><?php echo ($member['mb_email'] ? $member['mb_email'] : '미등록'); ?></dd>
            <dt>최종접속일시</dt>
            <dd><?php echo $member['mb_today_login']; ?></dd>
            <dt>회원가입일시</dt>
            <dd><?php echo $member['mb_datetime']; ?></dd>
            <dt id="smb_my_ovaddt">주소</dt>
            <dd id="smb_my_ovaddd"><?php echo sprintf("(%s%s)", $member['mb_zip1'], $member['mb_zip2']).' '.print_address($member['mb_addr1'], $member['mb_addr2'], $member['mb_addr3'], $member['mb_addr_jibeon']); ?></dd>
        </dl>
      

    </section>

    <div id="mypage_pc">
        <section id="mypage_user_info">
           
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
            
        </section>
    </div>
    <script>
    
        $(".btn_op_area").on("click", function() {
            $(".op_area").toggle();
            $(".fa-caret-up").toggleClass("fa-caret-down")
        });

    </script>
    <!-- } 회원정보 개요 끝 -->

    

</div>
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
<!-- } 마이페이지 끝 -->

<?php
include_once("./_tail.php");
?>