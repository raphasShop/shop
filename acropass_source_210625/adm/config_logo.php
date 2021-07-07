<?php
$sub_menu = '155201'; /* 사이트로고,파비콘관리 */
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '로고관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

if (defined('G5_USE_SHOP') || G5_USE_SHOP) { //영카트사용시
$pg_anchor = '<ul class="anchor">
<li><a href="#anc_favicon">파비콘 등록</a></li>
<li><a href="#anc_shop_logo">쇼핑몰 로고관리</a></li>
<li><a href="#anc_comm_logo">커뮤니티 로고관리</a></li>
</ul>';
} else { //그누보드사용시
$pg_anchor = '<ul class="anchor">
<li><a href="#anc_favicon">파비콘 등록</a></li>
<li><a href="#anc_comm_logo">커뮤니티 로고관리</a></li>
</ul>';
}

$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';

?>

<form name="fconfig" action="./config_logoupdate.php" onsubmit="return fconfig_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="">

<!-- 파비콘 등록 관리 { -->
<section id="anc_favicon">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm orangered">파비콘 등록/관리</h2>
    <div class="local_desc02 local_desc">
        <p>
            주소창에 표시되는 작은아이콘(주소창이나 즐겨찾기/북마크목록에 아이콘표시)<br>
            png 파일(16×16픽셀)로 만든후 ico 만들어주는 프로그램이나 사이트에서 반드시 ico파일로 만든후 업로드하시면 됩니다<br>
            ico파일 업로드 후 브라우저창을 닫은 후 새로 열어야 등록된 ico파일이 적용되어 보여집니다<br> 
            <strong>[ico만들어주는 사이트]</strong> <a href="https://www.favicon-generator.org" target="_blank">https://www.favicon-generator.org</a>
        </p>
    </div>
    
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>파비콘관리</caption>
        <colgroup>
            <col>
        </colgroup>
        <tbody>
        <tr>
            <td>
                <?php echo help("이미지사이즈 16×16픽셀, 파일형식은 ico로 등록"); ?>
                <input type="file" name="favicon_ico" id="favicon_ico">
                <?php
                $favicon_ico = G5_PATH."/favicon.ico";
                if (file_exists($favicon_ico))
                {
                    $size = getimagesize($favicon_ico);
                ?>
                <input type="checkbox" name="favicon_ico_del" value="1" id="favicon_ico_del">
                <label for="favicon_ico_del"><span class="sound_only">파비콘</span> 삭제</label>
                <?php } ?>
                <?php if (file_exists($favicon_ico)) { ?><img src="<?php echo G5_URL; ?>/favicon.ico"><?php } ?>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; //저장버튼?>
<!--//-->

<?php if(defined('G5_USE_SHOP')) { // 영카트일경우 표시?>
<!-- 쇼핑몰 로고 등록 관리 { -->
<section id="anc_shop_logo">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm orangered">쇼핑몰 로고 관리</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>쇼핑몰 로고 설정</caption>
        <colgroup>
            <col style="width:150px;">
            <col style="width:140px;">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row">PC 상단 로고</th>
            <?php if(!G5_IS_MOBILE) { ?><th scope="row" class="font-normal skyblue center">[파일명]<br><b>logo_img</b></th><?php } ?>
    <td>
                <?php echo help("쇼핑몰 상단로고를 직접 올리세요"); ?>
                <input type="file" name="logo_img" id="logo_img">
                <?php
                $logo_img = G5_DATA_PATH."/common/logo_img";
                if (file_exists($logo_img))
                {
                    $size = getimagesize($logo_img);
                ?>
                <input type="checkbox" name="logo_img_del" value="1" id="logo_img_del">
                <label for="logo_img_del"><span class="sound_only">상단로고이미지</span> 삭제</label>
                <span class="scf_img_logoimg"></span>
          <div id="logoimg" class="banner_or_img">
                    <img src="<?php echo G5_DATA_URL; ?>/common/logo_img" alt="">
                    <button type="button" class="sit_wimg_close">닫기</button>
                </div>
              <script>
                $('<button type="button" id="cf_logoimg_view" class="btn_frmline scf_img_view">원본 확인</button>').appendTo('.scf_img_logoimg');
                </script>
                <?php } ?>
            </td>
            <?php if(!G5_IS_MOBILE) { ?>
            <td>
                <?php if (file_exists($logo_img)) { ?><img src="<?php echo G5_DATA_URL; ?>/common/logo_img" class="logo-max"><?php } ?>
            </td>
			<?php } ?>
        </tr>
        <tr>
            <th scope="row">PC 하단 로고</th>
            <?php if(!G5_IS_MOBILE) { ?><th scope="row" class="font-normal skyblue center">[파일명]<br><b>logo_img2</b></th><?php } ?>
          <td>
                <?php echo help("쇼핑몰 하단로고를 직접 올리세요"); ?>
                <input type="file" name="logo_img2" id="logo_img2">
                <?php
                $logo_img2 = G5_DATA_PATH."/common/logo_img2";
                if (file_exists($logo_img2))
                {
                    $size = getimagesize($logo_img2);
                ?>
                <input type="checkbox" name="logo_img_del2" value="1" id="logo_img_del2">
                <label for="logo_img_del2"><span class="sound_only">하단로고이미지</span> 삭제</label>
                <span class="scf_img_logoimg2"></span>
                <div id="logoimg2" class="banner_or_img">
                    <img src="<?php echo G5_DATA_URL; ?>/common/logo_img2" alt="">
                    <button type="button" class="sit_wimg_close">닫기</button>
                </div>
              <script>
                $('<button type="button" id="cf_logoimg2_view" class="btn_frmline scf_img_view">원본 확인</button>').appendTo('.scf_img_logoimg2');
                </script>
                <?php } ?>
            </td>
            <?php if(!G5_IS_MOBILE) { ?>
            <td>
                <?php if (file_exists($logo_img2)) { ?><img src="<?php echo G5_DATA_URL; ?>/common/logo_img2" class="logo-max"><?php } ?>
            </td>
			<?php } ?>
        </tr>
        <tr>
            <th scope="row">
               <?php echo '<img src="'.G5_ADMIN_URL.'/img/icon_mobile.gif" title="모바일접속">';?> 모바일 상단 로고
            </th>
            <?php if(!G5_IS_MOBILE) { ?><th scope="row" class="font-normal skyblue center">[파일명]<br><b>mobile_logo_img</b></th><?php } ?>
          <td>
                <?php echo help("모바일 쇼핑몰 상단로고를 직접 올리세요"); ?>
                <input type="file" name="mobile_logo_img" id="mobile_logo_img">
                <?php
                $mobile_logo_img = G5_DATA_PATH."/common/mobile_logo_img";
                if (file_exists($mobile_logo_img))
                {
                    $size = getimagesize($mobile_logo_img);
                ?>
                <input type="checkbox" name="mobile_logo_img_del" value="1" id="mobile_logo_img_del">
                <label for="mobile_logo_img_del"><span class="sound_only">모바일 상단로고이미지</span> 삭제</label>
                <span class="scf_img_mobilelogoimg"></span>
                <div id="mobilelogoimg" class="banner_or_img">
                    <img src="<?php echo G5_DATA_URL; ?>/common/mobile_logo_img" alt="">
                    <button type="button" class="sit_wimg_close">닫기</button>
                </div>
              <script>
                $('<button type="button" id="cf_mobilelogoimg_view" class="btn_frmline scf_img_view">원본 확인</button>').appendTo('.scf_img_mobilelogoimg');
                </script>
                <?php } ?>
            </td>
            <?php if(!G5_IS_MOBILE) { ?>
            <td>
                <?php if (file_exists($mobile_logo_img)) { ?><img src="<?php echo G5_DATA_URL; ?>/common/mobile_logo_img" class="logo-max"><?php } ?>
            </td>
			<?php } ?>
        </tr>
        <tr>
            <th scope="row">
                <?php echo '<img src="'.G5_ADMIN_URL.'/img/icon_mobile.gif" title="모바일접속">';?> 모바일 하단 로고
            </th>
            <?php if(!G5_IS_MOBILE) { ?><th scope="row" class="font-normal skyblue center">[파일명]<br><b>mobile_logo_img2</b></th><?php } ?>
            <td>
                <?php echo help("모바일 쇼핑몰 하단로고를 직접 올리세요"); ?>
                <input type="file" name="mobile_logo_img2" id="mobile_logo_img2">
                <?php
                $mobile_logo_img2 = G5_DATA_PATH."/common/mobile_logo_img2";
                if (file_exists($mobile_logo_img2))
                {
                    $size = getimagesize($mobile_logo_img2);
                ?>
                <input type="checkbox" name="mobile_logo_img_del2" value="1" id="mobile_logo_img_del2">
                <label for="mobile_logo_img_del2"><span class="sound_only">모바일 하단로고이미지</span> 삭제</label>
                <span class="scf_img_mobilelogoimg2"></span>
                <div id="mobilelogoimg2" class="banner_or_img">
                    <img src="<?php echo G5_DATA_URL; ?>/common/mobile_logo_img2" alt="">
                    <button type="button" class="sit_wimg_close">닫기</button>
                </div>
              <script>
                $('<button type="button" id="cf_mobilelogoimg2_view" class="btn_frmline scf_img_view">원본 확인</button>').appendTo('.scf_img_mobilelogoimg2');
                </script>
                <?php } ?>
            </td>
            <?php if(!G5_IS_MOBILE) { ?>
            <td>
                <?php if (file_exists($mobile_logo_img2)) { ?><img src="<?php echo G5_DATA_URL; ?>/common/mobile_logo_img2" class="logo-max"><?php } ?>
            </td>
			<?php } ?>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; //저장버튼?>
    
<!-- 안내 -->   
<div class="local_desc01">
    <ul>
        <li class="title1">쇼핑몰 상단에 로고이미지 적용하기</li>
        <li class="content-list-txt1">
        PC상단로고 삽입 : &lt;img src=&quot;&lt;?php echo G5_DATA_URL; ?&gt;/common/logo_img&quot; alt=&quot;쇼핑몰이름&quot;&gt;<br />
        PC하단로고 삽입 : &lt;img src=&quot;&lt;?php echo G5_DATA_URL; ?&gt;/common/logo_img2&quot; alt=&quot;쇼핑몰이름&quot;&gt;<br />
        모바일상단로고 삽입 : &lt;img src=&quot;&lt;?php echo G5_DATA_URL; ?&gt;/common/mobile_logo_img&quot; alt=&quot;쇼핑몰이름&quot;&gt;<br />
        모바일상단로고 삽입 : &lt;img src=&quot;&lt;?php echo G5_DATA_URL; ?&gt;/common/mobile_logo_img2&quot; alt=&quot;쇼핑몰이름&quot;&gt;<br />
        </li>
        <li class="txt1">
        <b>(1) 영카트 기본 사용시</b><br>
        - PC 상단 파일위치 : <strong>shop/shop.head.php</strong> 에 이미 적용되어 있으며 확인만 하시면 됩니다<br>
        - PC 하단 파일위치 : <strong>shop/shop.tail.php</strong> 에 이미 적용되어 있으며 확인만 하시면 됩니다<br>
        - MOBILE 상단 파일위치 : <strong>mobile/shop/shop.head.php</strong> 에 이미 적용되어 있으며 확인만 하시면 됩니다<br>
        - MOBILE 하단 파일위치 : <strong>mobile/shop/shop.tail.php</strong> 에 이미 적용되어 있으며 확인만 하시면 됩니다
        </li>
        <li class="txt1">
        <b>(2) 영카트 테마 사용시 (theme폴더 확인)</b><br>
        - PC 상단 파일위치 : <strong>theme/사용하는쇼핑몰테마/shop/shop.head.php</strong> 에 이미 적용되어 있으며 확인만 하시면 됩니다<br>
        - PC 하단 파일위치 : <strong>theme/사용하는쇼핑몰테마/shop/shop.tail.php</strong> 에 이미 적용되어 있으며 확인만 하시면 됩니다<br>
        - MOBILE 상단 파일위치 : <strong>theme/사용하는쇼핑몰테마/mobile/shop/shop.head.php</strong> 에 이미 적용되어 있으며 확인만 하시면 됩니다<br>
        - MOBILE 하단 파일위치 : <strong>theme/사용하는쇼핑몰테마/mobile/shop/shop.tail.php</strong> 에 이미 적용되어 있으며 확인만 하시면 됩니다
        
        </li>
        <li class="txt1">
        <b>(3) 아미나빌더 사용시</b><br>
        - 상단 파일위치 : <strong>thema/사용하는테마/shop.head.php</strong> 에 이미 적용된 이미지경로와 파일명을 위의 PC상단로고삽입 소스로 변경(69줄부근)<br>
        - 하단 파일위치 : <strong>thema/사용하는테마/shop.tail.php</strong> 에 이미 적용된 이미지경로와 파일명을 위의 PC하단로고삽입 소스로 변경(47줄부근)
        </li>
    </ul>
</div>
<!-- // --> 

<?php if (file_exists($logo_img) || file_exists($logo_img2) || file_exists($mobile_logo_img) || file_exists($mobile_logo_img2)) { ?>
<script>
$(".banner_or_img").addClass("scf_img");
$(function() {
    $(".scf_img_view").bind("click", function() {
        var sit_wimg_id = $(this).attr("id").split("_");
        var $img_display = $("#"+sit_wimg_id[1]);

        $img_display.toggle();

        if($img_display.is(":visible")) {
            $(this).text($(this).text().replace("확인", "닫기"));
        } else {
            $(this).text($(this).text().replace("닫기", "확인"));
        }

        if(sit_wimg_id[1].search("mainimg") > -1) {
            var $img = $("#"+sit_wimg_id[1]).children("img");
            var width = $img.width();
            var height = $img.height();
            if(width > 700) {
                var img_width = 700;
                var img_height = Math.round((img_width * height) / width);

                $img.width(img_width).height(img_height);
            }
        }
    });
    $(".sit_wimg_close").bind("click", function() {
        var $img_display = $(this).parents(".banner_or_img");
        var id = $img_display.attr("id");
        $img_display.toggle();
        var $button = $("#cf_"+id+"_view");
        $button.text($button.text().replace("닫기", "확인"));
    });
});
</script>
<?php } ?>
<!-- } -->

<div class="h20"><!--//--></div>

<?php } //영카트일때 나타남 끝 ?>

<!-- 커뮤니티 로고 등록 관리 { -->
<section id="anc_comm_logo">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm orangered">커뮤니티 로고 관리</h2>
<div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>커뮤니티 로고 설정</caption>
        <colgroup>
            <col style="width:150px;">
            <col style="width:140px;">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row">PC 상단 로고</th>
            <?php if(!G5_IS_MOBILE) { ?><th scope="row" class="font-normal skyblue center">[파일명]<br><b>clogo_img</b></th><?php } ?>
            <td>
                <?php echo help("커뮤니티 상단로고를 직접 올리세요"); ?>
                <input type="file" name="clogo_img" id="clogo_img">
                <?php
                $clogo_img = G5_DATA_PATH."/common/clogo_img";
                if (file_exists($clogo_img))
                {
                    $size = getimagesize($clogo_img);
                ?>
                <input type="checkbox" name="clogo_img_del" value="1" id="clogo_img_del">
                <label for="clogo_img_del"><span class="sound_only">상단로고이미지</span> 삭제</label>
                <span class="scf_img_clogoimg"></span>
                <div id="clogoimg" class="banner_or_img">
                    <img src="<?php echo G5_DATA_URL; ?>/common/clogo_img" alt="">
                    <button type="button" class="sit_wimg_close">닫기</button>
                </div>
              <script>
                $('<button type="button" id="cf_clogoimg_view" class="btn_frmline scf_cimg_view">원본 확인</button>').appendTo('.scf_img_clogoimg');
                </script>
                <?php } ?>
            </td>
            <?php if(!G5_IS_MOBILE) { ?>
            <td>
                <?php if (file_exists($clogo_img)) { ?><img src="<?php echo G5_DATA_URL; ?>/common/clogo_img" class="logo-max"><?php } ?>
            </td>
			<?php } ?>
        </tr>
        <tr>
            <th scope="row">PC 하단 로고</th>
            <?php if(!G5_IS_MOBILE) { ?><th scope="row" class="font-normal skyblue center">[파일명]<br><b>clogo_img2</b></th><?php } ?>
    <td>
                <?php echo help("커뮤니티 하단로고를 직접 올리세요"); ?>
                <input type="file" name="clogo_img2" id="clogo_img2">
                <?php
                $clogo_img2 = G5_DATA_PATH."/common/clogo_img2";
                if (file_exists($clogo_img2))
                {
                    $size = getimagesize($clogo_img2);
                ?>
                <input type="checkbox" name="clogo_img_del2" value="1" id="clogo_img_del2">
                <label for="clogo_img_del2"><span class="sound_only">하단로고이미지</span> 삭제</label>
                <span class="scf_img_clogoimg2"></span>
                <div id="clogoimg2" class="banner_or_img">
                    <img src="<?php echo G5_DATA_URL; ?>/common/clogo_img2" alt="">
                    <button type="button" class="sit_wimg_close">닫기</button>
                </div>
              <script>
                $('<button type="button" id="cf_clogoimg2_view" class="btn_frmline scf_cimg_view">원본 확인</button>').appendTo('.scf_img_clogoimg2');
                </script>
                <?php } ?>
            </td>
            <?php if(!G5_IS_MOBILE) { ?>
            <td>
                <?php if (file_exists($clogo_img2)) { ?><img src="<?php echo G5_DATA_URL; ?>/common/clogo_img2" class="logo-max"><?php } ?>
            </td>
			<?php } ?>
        </tr>
        <tr>
            <th scope="row">
                <?php echo '<img src="'.G5_ADMIN_URL.'/img/icon_mobile.gif" title="모바일접속">';?> 모바일 상단 로고
            </th>
            <?php if(!G5_IS_MOBILE) { ?><th scope="row" class="font-normal skyblue center">[파일명]<br><b>mobile_clogo_img</b></th><?php } ?>
    <td>
                <?php echo help("모바일 커뮤니티 상단로고를 직접 올리세요"); ?>
                <input type="file" name="mobile_clogo_img" id="mobile_clogo_img">
                <?php
                $mobile_clogo_img = G5_DATA_PATH."/common/mobile_clogo_img";
                if (file_exists($mobile_clogo_img))
                {
                    $size = getimagesize($mobile_clogo_img);
                ?>
                <input type="checkbox" name="mobile_clogo_img_del" value="1" id="mobile_clogo_img_del">
                <label for="mobile_clogo_img_del"><span class="sound_only">모바일 상단로고이미지</span> 삭제</label>
                <span class="scf_img_mobileclogoimg"></span>
                <div id="mobileclogoimg" class="banner_or_img">
                    <img src="<?php echo G5_DATA_URL; ?>/common/mobile_clogo_img" alt="">
                    <button type="button" class="sit_wimg_close">닫기</button>
                </div>
              <script>
                $('<button type="button" id="cf_mobileclogoimg_view" class="btn_frmline scf_cimg_view">원본 확인</button>').appendTo('.scf_img_mobileclogoimg');
                </script>
                <?php } ?>
            </td>
            <?php if(!G5_IS_MOBILE) { ?>
            <td>
                <?php if (file_exists($mobile_clogo_img)) { ?><img src="<?php echo G5_DATA_URL; ?>/common/mobile_clogo_img" class="logo-max"><?php } ?>
            </td>
			<?php } ?>
        </tr>
        <tr>
            <th scope="row">
                <?php echo '<img src="'.G5_ADMIN_URL.'/img/icon_mobile.gif" title="모바일접속">';?> 모바일 하단 로고
            </th>
            <?php if(!G5_IS_MOBILE) { ?><th scope="row" class="font-normal skyblue center">[파일명]<br><b>mobile_clogo_img2</b></th><?php } ?>
            <td>
                <?php echo help("모바일 커뮤니티 하단로고를 직접 올리세요"); ?>
                <input type="file" name="mobile_clogo_img2" id="mobile_clogo_img2">
                <?php
                $mobile_clogo_img2 = G5_DATA_PATH."/common/mobile_clogo_img2";
                if (file_exists($mobile_clogo_img2))
                {
                    $size = getimagesize($mobile_clogo_img2);
                ?>
                <input type="checkbox" name="mobile_clogo_img_del2" value="1" id="mobile_clogo_img_del2">
                <label for="mobile_clogo_img_del2"><span class="sound_only">모바일 하단로고이미지</span> 삭제</label>
                <span class="scf_img_mobileclogoimg2"></span>
                <div id="mobileclogoimg2" class="banner_or_img">
                    <img src="<?php echo G5_DATA_URL; ?>/common/mobile_clogo_img2" alt="">
                    <button type="button" class="sit_wimg_close">닫기</button>
                </div>
              <script>
                $('<button type="button" id="cf_mobileclogoimg2_view" class="btn_frmline scf_cimg_view">원본 확인</button>').appendTo('.scf_img_mobileclogoimg2');
                </script>
                <?php } ?>
            </td>
            <?php if(!G5_IS_MOBILE) { ?>
            <td>
                <?php if (file_exists($mobile_clogo_img2)) { ?><img src="<?php echo G5_DATA_URL; ?>/common/mobile_clogo_img2" class="logo-max"><?php } ?>
            </td>
			<?php } ?>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; //저장버튼?>

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
    
<!-- 안내 -->   
<div class="local_desc01">
    <ul>
        <li class="title1">커뮤니티사이트 상단에 로고이미지 적용하기</li>
        <li class="content-list-txt1">
        PC상단로고 삽입 : &lt;img src=&quot;&lt;?php echo G5_DATA_URL; ?&gt;/common/clogo_img&quot; alt=&quot;사이트이름&quot;&gt;<br />
        PC하단로고 삽입 : &lt;img src=&quot;&lt;?php echo G5_DATA_URL; ?&gt;/common/clogo_img2&quot; alt=&quot;사이트이름&quot;&gt;<br />
        모바일상단로고 삽입 : &lt;img src=&quot;&lt;?php echo G5_DATA_URL; ?&gt;/common/mobile_clogo_img&quot; alt=&quot;사이트이름&quot;&gt;<br />
        모바일상단로고 삽입 : &lt;img src=&quot;&lt;?php echo G5_DATA_URL; ?&gt;/common/mobile_clogo_img2&quot; alt=&quot;사이트이름&quot;&gt;<br />
        </li>
        <li class="txt1">
        <b>(1) 영카트(그누보드) 기본 사용시</b><br>
        - PC 상단 파일위치 : <strong>head.php</strong> 에 이미 적용된 이미지경로와 파일명을 위의 PC상단로고삽입 소스로 변경<br>
        - PC 하단 파일위치 : <strong>tail.php</strong> 에 이미 적용된 이미지경로와 파일명을 위의 PC하단로고삽입 소스로 변경<br>
        - MOBILE 상단 파일위치 : <strong>mobile/head.php</strong> 에 위의 모바일 상단로고삽입 소스로 변경<br>
        - MOBILE 하단 파일위치 : <strong>mobile/tail.php</strong> 에 위의 모바일 상단로고삽입 소스로 변경
        </li>
        <li class="txt1">
        <b>(2) 영카트(그누보드) 테마 사용시 (theme폴더 확인)</b><br>
        - PC 상단 파일위치 : <strong>theme/사용하는쇼핑몰 또는 그누보드 테마/head.php</strong> 에 이미 적용된 이미지경로와 파일명을 위의 PC 상단로고삽입 소스로 변경<br>
        - PC 하단 파일위치 : <strong>theme/사용하는쇼핑몰 또는 그누보드 테마/tail.php</strong> 에 이미 적용된 이미지경로와 파일명을 위의 PC 하단로고삽입 소스로 변경<br>
        - MOBILE 상단 파일위치 : <strong>theme/사용하는쇼핑몰테마/mobile/head.php</strong> 에 이미 적용된 이미지경로와 파일명을 위의 모바일상단로고삽입 소스로 변경<br>
        - MOBILE 하단 파일위치 : <strong>theme/사용하는쇼핑몰테마/mobile/tail.php</strong> 에 이미 적용된 이미지경로와 파일명을 위의 모바일상단로고삽입 소스로 변경
        </li>
        <li class="txt1">
        <b>(3) 아미나빌더 사용시</b><br>
        - 상단 파일위치 : <strong>thema/사용하는테마/head.php</strong> 에 이미 적용된 이미지경로와 파일명을 위의 PC상단로고삽입 소스로 변경(69줄부근)<br>
        - 하단 파일위치 : <strong>thema/사용하는테마/tail.php</strong> 에 이미 적용된 이미지경로와 파일명을 위의 PC하단로고삽입 소스로 변경(47줄부근)
        </li>
    </ul>
</div>
<!-- // --> 

<?php if (file_exists($clogo_img) || file_exists($clogo_img2) || file_exists($mobile_clogo_img) || file_exists($mobile_clogo_img2)) { ?>
<script>
$(".banner_or_img").addClass("scf_img");
$(function() {
    $(".scf_cimg_view").bind("click", function() {
        var sit_wimg_id = $(this).attr("id").split("_");
        var $img_display = $("#"+sit_wimg_id[1]);

        $img_display.toggle();

        if($img_display.is(":visible")) {
            $(this).text($(this).text().replace("확인", "닫기"));
        } else {
            $(this).text($(this).text().replace("닫기", "확인"));
        }

        if(sit_wimg_id[1].search("mainimg") > -1) {
            var $img = $("#"+sit_wimg_id[1]).children("img");
            var width = $img.width();
            var height = $img.height();
            if(width > 700) {
                var img_width = 700;
                var img_height = Math.round((img_width * height) / width);

                $img.width(img_width).height(img_height);
            }
        }
    });
    $(".sit_wimg_close").bind("click", function() {
        var $img_display = $(this).parents(".banner_or_img");
        var id = $img_display.attr("id");
        $img_display.toggle();
        var $button = $("#cf_"+id+"_view");
        $button.text($button.text().replace("닫기", "확인"));
    });
});
</script>
<?php } ?>
<!-- } -->

</form>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
