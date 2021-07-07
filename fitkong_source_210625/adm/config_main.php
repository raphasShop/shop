<?php
$sub_menu = "100601";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '접속화면설정';
include_once ('./admin.head.php');

$pg_anchor = '<ul class="anchor">
    <li><a href="#anc_cf_main">접속 메인 설정</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';
?>

<form name="fconfigform" action="./config_mainupdate.php" onsubmit="return fconfigform_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="" id="token">


<!-- 접속시 메인페이지 설정 -->
<section id="anc_cf_main">
    <?php echo $pg_anchor ?>
    
    <!-- [안내] 아이스크림전용테마에서만 사용가능 안내 { -->
    <div class="local_limit_theme local_desc">
        <div class="toggleclick" onclick="$('.togglebox').toggle()">
            <img src="<?php echo G5_ADMIN_URL ?>/img/s9.png"> 아이스크림 전용 쇼핑몰테마에서만 사용할 수 있는 기능
            <span class="more">+더보기</span>
        </div>
            
        <div class="togglebox">
            <span class="orangered">아이스크림에서 제공하는 전용 쇼핑몰테마를 사용하지 않는경우,설정이 적용되지 않습니다.</span><br>
            쇼핑몰테마에 일일이 적용해야하는 기능으로 다른 테마에 일일이 적용방법을 안내할 수가 없습니다.<br> 
            아이스크림 관리자모드에 최적화하여 만든 아이스크림 전용 쇼핑몰테마에는 모든 기능을 적용하였습니다.<br>
            아이스크림 쇼핑몰테마가 아닌경우에는, 사용중이신 쇼핑몰테마에 직접 적용해 주셔야 합니다.
        </div>
    </div>
    <!-- } -->
    
    <h2 class="h2_frm">접속시 메인페이지 설정</h2>
    
    
    
    <div class="local_desc02 local_desc">
        <p>
        ※ 영카트 설치 사용시에는 "커뮤니티"와 "쇼핑몰"이 구분해서 보여집니다. 설치 후 도메인으로 접속하면, 접속되는 페이지는 "커뮤니티"메인입니다.<br>
        ※ <strong>"쇼핑몰메인"</strong>은 도메인주소 뒤에 <strong>/shop</strong> 을 붙여만 쇼핑몰메인으로 바로 접속됩니다. 수동으로 테마 파일을 직접 수정해서 쇼핑몰메인으로 변경할 수는 있습니다.<br>
        ※ 하지만, 이곳에서 설정만하면 자동으로 접속하는 페이지를 지정할 수 있습니다.<br>
        (아이스크림 전용 쇼핑몰테마에서만 적용되며, 다른 테마를 사용하는 경우에는 테마에 직접 적용하는 작업을 해야 사용하실 수 있습니다)
        </p>
    </div>
    <div class="local_desc_alim local_desc">
        <p>현재 사이트접속시 <?php echo $config['cf_main_choice'] == 'shop' ? '<strong>"쇼핑몰메인"</strong>' : '<strong>"커뮤니티메인"</strong>'; ?> 으로 접속이 되고 있습니다. 도메인 접속시 사이트메인페이지는 지정하여 변경할 수 있습니다.</p>
    </div>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>접속시 메인페이지 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_main_choice">접속시 메인페이지<strong class="sound_only">필수</strong></label></th>
            <td style="padding:25px;">
			    <?php echo help("영카트를 사용하는 경우 도메인으로 접속시 메인페이지를 커뮤니티, 쇼핑몰 중 선택해서 보여줄 수 있습니다\n쇼핑몰메인 선택시 커뮤니티메인은 표시되지 않습니다. 게시판의 상단/하단은 쇼핑몰 shop.head.php/shop.tail.php가 적용됩니다"); ?>
                <input type="radio" name="cf_main_choice" value="shop" <?php echo $config['cf_main_choice'] == 'shop' ? 'checked' : ''; ?> id="cf_main_choice1">
                <label for="cf_main_choice1"> 쇼핑몰메인(커뮤니티사용안함)</label>
                &nbsp;&nbsp;&nbsp;
                <input type="radio" name="cf_main_choice" value="community" <?php echo $config['cf_main_choice'] == 'community' ? 'checked' : ''; ?> id="cf_main_choice2">
                <label for="cf_main_choice2"> 커뮤니티메인</label>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
    
</section>

<?php echo $frm_submit; ?>
<!--//-->


<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">   
    <div class="bq_basic_icon">
    <a href="<?php echo G5_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/home_icon.png" border="0" title="홈"></a>
    <a href="<?php echo G5_SHOP_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/shop_icon.png" border="0" title="쇼핑몰">&nbsp;&nbsp;</a>
    </div>

    <div class="bq_basic_submit">
    <input type="submit" value="확인" accesskey="s">
    </div>

</div>
<!--//-->

</form>

<?php
include_once ('./admin.tail.php');
?>
