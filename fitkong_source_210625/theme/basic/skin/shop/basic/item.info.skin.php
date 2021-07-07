<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<section id="item_info_loc" style="margin-bottom:100px;"></section>

<div id="item_info">
    
    <div class="item_menu_wrap">
        <div class="item_menu">
            <a href="#item_info_loc"><div class="item_menu_btn_select">상품정보</div></a><a href="#item_use_loc"><div class="item_menu_btn">리뷰 <?php echo $it['it_use_cnt']; ?></div></a>
        </div>
    </div>
    <div class="item_con">
        <div id="sit_inf">
            <h2 class="contents_tit"><span>상품 정보</span></h2>

            <?php if ($it['it_explan'] || $it['it_mobile_explan']) { // 상품 상세설명 ?>
            <h3>상품 상세설명</h3>
            <div id="sit_inf_explan">
                <?php echo conv_content($it['it_explan'], 1); ?>
            </div>
            <?php } ?>

            


            <?php
            if ($it['it_info_value']) { // 상품 정보 고시
                $info_data = unserialize(stripslashes($it['it_info_value']));
                if(is_array($info_data)) {
                    $gubun = $it['it_info_gubun'];
                    $info_array = $item_info[$gubun]['article'];
            ?>
            <h3>상품 정보 고시</h3>
            <table id="sit_inf_open">
            <tbody>
            <?php
            foreach($info_data as $key=>$val) {
                $ii_title = $info_array[$key][0];
                $ii_value = $val;
            ?>
            <tr>
                <th scope="row"><?php echo $ii_title; ?></th>
                <td><?php echo $ii_value; ?></td>
            </tr>
            <?php } //foreach?>
            </tbody>
            </table>
            <!-- 상품정보고시 end -->
            <?php
                } else {
                    if($is_admin) {
                        echo '<p>상품 정보 고시 정보가 올바르게 저장되지 않았습니다.<br>config.php 파일의 G5_ESCAPE_FUNCTION 설정을 addslashes 로<br>변경하신 후 관리자 &gt; 상품정보 수정에서 상품 정보를 다시 저장해주세요. </p>';
                    }
                }
            } //if
            ?>

        </div>
    </div>
    <section id="item_use_loc"></section>
    <div class="item_menu_wrap">
        <div class="item_menu">
            <a href="#item_info_loc"><div class="item_menu_btn">상품정보</div></a><a href="#item_use_loc"><div class="item_menu_btn_select">리뷰 <?php echo $it['it_use_cnt']; ?></div></a>
        </div>
    </div>
    <div class="item_con">
        <!-- 사용후기 시작 { -->
        <div id="sit_use">
            <h2>사용후기</h2>

            <div id="itemuse"><?php include_once(G5_SHOP_PATH.'/itemuse.php'); ?></div>
        </div>
        <!-- } 사용후기 끝 -->
    </div>
        
</div>
<div id="review_popup" style="display:none" class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="3s" data-wow-offset="0">
    <div class="review_popup_top_wrap">
        <a href="#item_info_loc"><div class="review_popup_top_btn">상품정보</div></a>
        <a href="#item_use_loc"><div class="review_popup_top_btn">리뷰 <?php echo $it['it_use_cnt']; ?></div></a>
        <div style="display: inline-block;">
        <a href="javascript:doReviewPopup();">    
        <div id="review_popup_top" class="review_popup_top_btn_color" style="display: none">사용자 리뷰 보기</div>
        </a>
        </div>
        <a href="javascript:doReviewPopup();">
        <div id="rp_arrow_down" class="review_popup_top_arrow"><i class="xi-angle-down-thin"></i></div>
        <div id="rp_arrow_up" class="review_popup_top_arrow" style="display: none"><i class="xi-angle-up-thin"></i></div>
        </a>
    </div>
    <div id="review_popup_con" class="review_popup_con_wrap">
        <div class="review_popup_con_title">
            <div class="rpc_title">사용자리뷰</div>
            <div class="rpc_desc">고객님들이 직접 사용하고 남기신 리뷰를 추천해드립니다</div>
        </div>
        <?php 
        $sql = " select * from {$g5['g5_shop_review_popup_table']} where it_id = '$it_id' and rvp_use = '1'
                  order by rand() 
                  limit 6 "; // 최대 6개출력
        $result = sql_query($sql);
        $rv_count = sql_num_rows($result);

        for ($i=0; $row=sql_fetch_array($result); $i++)
        {
            $sql1 = " update {$g5['g5_shop_review_popup_table']} set rvp_hit = rvp_hit + 1 where rvp_id = '{$row['rvp_id']}' ";
            sql_query($sql1);
            $rvp_url = G5_SHOP_URL.'/reviewpopuphit.php?it_id='.$it_id.'&rvp_id='.$row['rvp_id'].'&bod='.$i.'';
        ?>
        <a href="<?php echo $rvp_url; ?>" target="_blank">
        <div class="review_popup_con">
            <div class="rpc_con_title"><?php echo $row['rvp_title']; ?></div>
            <div class="rpc_con_img"><img src="<?php echo $row['rvp_img_url']; ?>"></div>
            <div class="rpc_con_desc_wrap">
                <div class="rpc_con_desc"><?php echo $row['rvp_contents']; ?></div>
                <div class="rpc_con_channel"><?php echo $row['rvp_channel']; ?>&nbsp;&nbsp;|&nbsp;&nbsp;</div>
                <div class="rpc_con_nick"><?php echo $row['rvp_reviewer']; ?></div>
            </div>
        </div>
        </a>
        <?php
        if($i==1) {
            echo "<div id='hide_review' style='display:none'>";
        } 
        if ($i==5 || $i == $rv_count - 1) {
            echo "</div>";
        }
       
        }
        ?>
        <?php if($rv_count > 2) { ?>
        <a href="javascript:showDisplay();">
            <div id="review_more" class="rpc_more">더보기 <span><i class="xi-angle-down-thin"></i></span></div>
        </a>
        <?php } ?>
    </div>
</div>
<?php if ($default['de_rel_list_use']) { ?>
<!-- 관련상품 시작 { -->
<section id="sit_rel">
    <h2>이 제품을 구매한 고객의 다른 제품</h2>
    <?php
    
    $rel_skin_file = G5_SHOP_SKIN_PATH.'/main.10.skin.php';

    $sql = " select b.* from {$g5['g5_shop_item_relation_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id) where a.it_id = '{$it['it_id']}' and b.it_use='1' ";
    $list = new item_list($rel_skin_file, $default['de_rel_list_mod'], 0, $default['de_rel_img_width'], $default['de_rel_img_height']);
    $list->set_query($sql);
    echo $list->run();
    ?>
</section>
<!-- } 관련상품 끝 -->
<?php } ?>

<script type="text/javascript">

$(document).ready( function() {
   var rvcnt = <?php echo $rv_count; ?>;
   if(rvcnt != '0') {
        $('#review_popup').delay(2000).show();
   }   
});
var bDisplay = true;
function showDisplay(){
    var con = document.getElementById("hide_review");
    var rvm = document.getElementById("review_more");
    if(con.style.display=='none'){
        con.style.display = 'block';
        rvm.style.display = 'none';
    }else{
        con.style.display = 'none';
        rvm.style.display = 'block';
    }
}

function doReviewPopup(){
    var rvc = document.getElementById("review_popup_con");
    var rvad = document.getElementById("rp_arrow_down");
    var rvau = document.getElementById("rp_arrow_up");
    var rvpt = document.getElementById("review_popup_top");
    if(rvc.style.display=='none'){
        rvc.style.display = 'block';
        rvad.style.display = 'block';
        rvau.style.display = 'none';
        rvpt.style.display = 'none';
    } else {
        rvc.style.display = 'none';
        rvad.style.display = 'none';
        rvau.style.display = 'block';
        rvpt.style.display = 'block';
    }
}
</script>

<script>
$(window).on("load", function() {
    $("#sit_inf_explan").viewimageresize2();
});
</script>

<script>
  $('.item_menu a').click(function () {
    $('html, body').animate({
      scrollTop: $($.attr(this, 'href')).offset().top
    }, 500);
    return false;
  });

  $('#review_popup a').click(function () {
    $('html, body').animate({
      scrollTop: $($.attr(this, 'href')).offset().top
    }, 500);
    return false;
  });
</script>

<script>
$(function (){
    $(".tab_con>li").hide();
    $(".tab_con>li:first").show();   
    $(".tab_tit li button").click(function(){
        $(".tab_tit li button").removeClass("selected");
        $(this).addClass("selected");
        $(".tab_con>li").hide();
        $($(this).attr("rel")).show();
    });
});
</script>
