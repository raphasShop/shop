<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>

<?
    if ($it_id == '1622793578' || $it_id == '1622793637' || $it_id == '1622793630') {
        $promotion_item = true;
    } else {
        $promotion_item = false;
    } 
?>
<form name="fitem" method="post" action="<?php echo $action_url; ?>" onsubmit="return fitem_submit(this);">
<input type="hidden" name="it_id[]" value="<?php echo $it_id; ?>">
<input type="hidden" name="sw_direct">
<input type="hidden" name="url">

<div id="sit_ov_wrap">
    <!-- 상품이미지 미리보기 시작 { -->
    <div id="sit_pvi">
        <div id="sit_pvi_big">
        <?php
        $big_img_count = 0;
        $thumbnails = array();
        for($i=1; $i<=10; $i++) {
            if(!$it['it_img'.$i])
                continue;

            $img = get_it_thumbnail($it['it_img'.$i], $default['de_mimg_width'], $default['de_mimg_height']);

            if($img) {
                // 썸네일
                $thumb = get_it_thumbnail($it['it_img'.$i], 100, 100);
                $thumbnails[] = $thumb;
                $big_img_count++;

                echo '<a href="#" class="popup_item_image">'.$img.'</a>';
            }
        }

        if($big_img_count == 0) {
            echo '<img src="'.G5_SHOP_URL.'/img/no_image.gif" alt="">';
        }
        ?>
        </div>
        <?php
        // 썸네일
        $thumb1 = true;
        $thumb_count = 0;
        $total_count = count($thumbnails);
        if($total_count > 0) {
            echo '<ul id="sit_pvi_thumb">';
            foreach($thumbnails as $val) {
                $thumb_count++;
                $sit_pvi_last ='';
                if ($thumb_count % 5 == 0) $sit_pvi_last = 'class="li_last"';
                    echo '<li '.$sit_pvi_last.'>';
                    echo '<a href="#" class="popup_item_image img_thumb">'.$val.'<span class="sound_only"> '.$thumb_count.'번째 이미지 새창</span></a>';
                    echo '</li>';
            }
            echo '</ul>';
        }

        $sns_thumb = get_it_thumbnail($it['it_img1'], 150, 150);
        $share_thumb = get_it_imageurl($it['it_id']);
        $sns_share_url = G5_SHOP_URL."/item.php?it_id=".$it['it_id'];
        ?>
      
        <script>
        $(".btn_sns_share").click(function(){
            $(".sns_area").show();
        });
        $(document).mouseup(function (e){
            var container = $(".sns_area");
            if( container.has(e.target).length === 0)
            container.hide();
        });


        </script>
    </div>
    <!-- } 상품이미지 미리보기 끝 -->

    <!-- 상품 요약정보 및 구매 시작 { -->
    <section id="sit_ov" class="2017_renewal_itemform">
        <img src="<?php echo G5_IMG_URL; ?>/zzim_no_select.png" class="sit_zzim btn_zzim enp_mobon_wish" id="sit_zzim_hide">
        <img src="<?php echo G5_IMG_URL; ?>/zzim_select.png" class="sit_zzim" id="sit_zzim_show">
        <img src="<?php echo G5_IMG_URL; ?>/share_no_select.png" class="sit_sns_share" id="sit_sns_share_hide">
        <img src="<?php echo G5_IMG_URL; ?>/share_select.png" class="sit_sns_share" id="sit_sns_share_show">
        <div class="sit_sns_share_wrap">
            <img src="<?php echo G5_IMG_URL; ?>/share_popup_back.png" class="sit_sns_share_popup"> 
            <div class="sit_sns_share_photo"><?php echo $sns_thumb; ?></div>
            <a href="javascript:naver_share('<?php echo $sns_share_url; ?>','<?php echo stripslashes($it['it_name']); ?>');"><img src="<?php echo G5_IMG_URL; ?>/share_blog.png" class="sit_sns_share_blog"></a>
            <a href="javascript:kakao_share();"><img src="<?php echo G5_IMG_URL; ?>/share_kakaotalk.png" class="sit_sns_share_kakaotalk"></a>
            <img src="<?php echo G5_IMG_URL; ?>/share_instagram.png" class="sit_sns_share_insta"> 
            <a href="javascript:facebook_share();"><img src="<?php echo G5_IMG_URL; ?>/share_facebook.png" class="sit_sns_share_facebook"></a>
            <div class="sit_sns_share_url"><input type="text" id="sit_sns_text" class="sit_sns_text" value="<?php echo $sns_share_url; ?>"></div>
        </div>
        <h2 id="sit_title"><?php echo stripslashes($it['it_name']); ?> <span class="sound_only">요약정보 및 구매</span></h2>
        <p id="sit_desc"><?php echo $it['it_basic']; ?></p>
        <?php if($is_orderable) { ?>
        <p id="sit_opt_info">
            상품 선택옵션 <?php echo $option_count; ?> 개, 추가옵션 <?php echo $supply_count; ?> 개
        </p>
        <?php } ?>
        <?php 
            $sale_price = get_price($it);
            $sale_ratio = ($sale_price  / $it['it_cust_price']) * 100;
            $sale_ratio = 100 - $sale_ratio;
            $sale_ratio = round($sale_ratio);
        ?>
        <?php if (!$it['it_use']) { ?>
        <div id ="sit_price">
            <span class="sit_sale_ratio">판매중지</span>
        </div>
        <? } else { ?>
        <div id ="sit_price">
            <?php if($sale_ratio != 0 && $sale_ratio != 100) { ?><span class="sit_sale_ratio"><?php echo $sale_ratio; ?>%</span><?php } ?>
            <span class="sit_cust_price"><?php echo display_price($it['it_cust_price']); ?></span>
            <span class="sit_price"><?php echo display_price(get_price($it)); ?></span>
            <input type="hidden" id="it_price" value="<?php echo get_price($it); ?>">
        </div>
        <?php } ?>
        <div class="sit_info">
            <table class="sit_ov_tbl">
            <colgroup>
                <col class="grid_3">
                <col>
            </colgroup>
            <tbody>
            <?php if ($config['cf_use_point']) { // 포인트 사용한다면 ?>
            <tr>
                <th scope="row">포인트적립</th>
                <td>
                    <?php // 등급별 포인트 차등

                    $point_double_use = true;
                    $startdate_str = "2021-02-10 00:00:00";
                    $enddate_str = "2021-02-15 00:00:00";

                    $startdate = strtotime($startdate_str);
                    $enddate = strtotime($enddate_str);
                    $currentdate = strtotime(date('Y-m-d H:i:s'));

                    $startdiff = $currentdate - $startdate;
                    $enddiff = $currentdate - $enddate;

                    if($startdiff >= 0 && $enddiff < 0) {} else {
                        $point_double_use = false;
                    }

                    $member_point = 1;
                    if($member['mb_level'] == 3) {$member_point = 2;}
                    if($member['mb_level'] == 4) {$member_point = 3;}
                    if($member['mb_level'] == 5) {$member_point = 5;}

                    if($it['it_point_type'] == 2) {
                        if($member['mb_level'] >= 2) {
                            $new_point = number_format($it['it_point']) * $member_point;
                            //$new_point = number_format($it['it_point']); 
                        } else {
                            $new_point = number_format($it['it_point']);
                        }
                        if($point_double_use) {
                            $new_point = $new_point * 2;
                        }
                        echo '구매금액(추가옵션 제외)의 '.$new_point.'%';
                    } else {
                        if($member['mb_level'] >= 2) {
                            //$it['it_point'] = number_format($it['it_point']) + (($member['mb_level']-2)*2);     
                        }
                        
                        $it_point = get_item_point($it); 
                        //$new_point = number_format($it_point);
                        $new_point = number_format($it_point) * $member_point;
                        if($point_double_use) {
                            $new_point = $new_point * 2;
                        }
                        echo $new_point.'점';
                    }
                    ?>
                </td>
            </tr>
            <?php } ?>

           

            <?php
            /* 재고 표시하는 경우 주석 해제
            <tr>
                <th scope="row">재고수량</th>
                <td><?php echo number_format(get_it_stock_qty($it_id)); ?> 개</td>
            </tr>
            */
            ?>

           
            <?php
            $ct_send_cost_label = '배송비결제';

            if($it['it_sc_type'] == 1)
                $sc_method = '무료배송';
            else {
                if($it['it_sc_method'] == 1)
                    $sc_method = '수령후 지불';
                else if($it['it_sc_method'] == 2) {
                    $ct_send_cost_label = '<label for="ct_send_cost">배송비결제</label>';
                    $sc_method = '<select name="ct_send_cost" id="ct_send_cost">
                                      <option value="0">주문시 결제</option>
                                      <option value="1">수령후 지불</option>
                                  </select>';
                }
                else {
                    if($it['it_sc_minimum'] != 0) {
                        $sc_method = display_price($it['it_sc_price']);
                        $sc_method_desc = '(주문시 결제 / '.display_price($it['it_sc_minimum']).' 이상 무료)';
                    } else {
                        $sc_method = '무료배송';
                    }
                }
            }
            ?>
            <tr>
                <th><?php echo $ct_send_cost_label; ?></th>
                <td><?php echo $sc_method; ?> <span class="sit_sc_desc"><?php echo $sc_method_desc; ?></span></td>
            </tr>
            <?php if($it['it_buy_min_qty']) { ?>
            <tr>
                <th>최소구매수량</th>
                <td><?php echo number_format($it['it_buy_min_qty']); ?> 개</td>
            </tr>
            <?php } ?>
            <?php if($it['it_buy_max_qty']) { ?>
            <tr>
                <th>최대구매수량</th>
                <td><?php echo number_format($it['it_buy_max_qty']); ?> 개</td>
            </tr>
            <?php } ?>
            </tbody>
            </table>
        </div>
        <?php
        if($option_item) {
        ?>
        <!-- 선택옵션 시작 { -->
        <section class="sit_option">
            <h3>선택옵션</h3>
 
            <?php // 선택옵션
            echo $option_item;
            ?>
        </section>
        <!-- } 선택옵션 끝 -->
        <?php
        }
        ?>

        <?php
        if($supply_item) {
        ?>
        <!-- 추가옵션 시작 { -->
        <section  class="sit_option">
            <h3>추가옵션</h3>
            <?php // 추가옵션
            echo $supply_item;
            ?>
        </section>
        <!-- } 추가옵션 끝 -->
        <?php
        }
        ?>

        <?php if ($is_orderable) { ?>
        <!-- 선택된 옵션 시작 { -->
        <section id="sit_sel_option">
            <h3>선택된 옵션</h3>
            <?php
            if(!$option_item) {
                if(!$it['it_buy_min_qty'])
                    $it['it_buy_min_qty'] = 1;
            ?>
            <ul id="sit_opt_added">
                <li class="sit_opt_list">
                    
                    <input type="hidden" name="io_type[<?php echo $it_id; ?>][]" value="0">
                    <input type="hidden" name="io_id[<?php echo $it_id; ?>][]" value="">
                    <input type="hidden" name="io_value[<?php echo $it_id; ?>][]" value="<?php echo $it['it_name']; ?>">
                    <input type="hidden" class="io_price" value="0">
                    <input type="hidden" class="io_stock" value="<?php echo $it['it_stock_qty']; ?>">
                    <div class="opt_name">
                        <span class="sit_opt_subj"><?php echo $it['it_name']; ?></span>
                    </div>
                    <div class="opt_count" <?php if ($promotion_item) { echo "style='display:none'"; }?>>
                        <label for="ct_qty_<?php echo $i; ?>" class="sound_only">수량</label>
                       <button type="button" class="sit_qty_minus" <?php if ($promotion_item) { echo "disabled"; }?>><i class="fa fa-minus" aria-hidden="true"></i><span class="sound_only">감소</span></button>
                        <input type="text" name="ct_qty[<?php echo $it_id; ?>][]" value="<?php echo $it['it_buy_min_qty']; ?>" id="ct_qty_<?php echo $i; ?>" class="num_input" size="5" >
                        <button type="button" class="sit_qty_plus"<?php if ($promotion_item) { echo "disabled"; }?>><i class="fa fa-plus" aria-hidden="true"></i><span class="sound_only">증가</span></button>
                        <span class="sit_opt_prc">+0원</span>
                    </div>
                </li>
            </ul>
            <script>
            $(function() {
                price_calculate();
            });
            </script>
            <?php } ?>
        </section>
        <!-- } 선택된 옵션 끝 -->

        <!-- 총 구매액 -->
        <div id="sit_tot_price"></div>
        <?php } ?>

        <?php if($is_soldout) { ?>
        <p id="sit_ov_soldout">상품의 재고가 부족하여 구매할 수 없습니다.</p>
        <?php } ?>

        <div id="sit_ov_btn">
            <?php if ($is_orderable) { ?>
            <button type="submit" onclick="document.pressed=this.value;" value="장바구니" id="sit_btn_cart" class="btn_cart <?php if ($promotion_item) { echo "btn_cart_promotion"; }?>"><i class="xi-cart" aria-hidden="true"></i> 장바구니</button>
            <?php if (!$promotion_item) { ?>
            <button type="submit" onclick="document.pressed=this.value;" value="바로구매" id="sit_btn_buy" class="btn_buy"><i class="xi-credit-card" aria-hidden="true"></i> 구매하기</button>
            <?php } ?>
            <?php } ?>
            <?php if(!$is_orderable && $it['it_soldout'] && $it['it_stock_sms']) { ?>
            <a href="javascript:popup_stocksms('<?php echo $it['it_id']; ?>');" id="sit_btn_alm"><i class="fa fa-bell-o" aria-hidden="true"></i> 재입고알림</a>
            <?php } ?>
            <!--
            <a href="javascript:item_wish(document.fitem, '<?php echo $it['it_id']; ?>');" id="sit_btn_wish"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="sound_only">위시리스트</span></a>
            -->
            <?php if (!$promotion_item) { ?>
            <?php if ($naverpay_button_js) { ?>
            <div class="itemform-naverpay"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
            <?php } ?>
            <?php } ?>
        </div>

        <script>
        // 상품보관
        function item_wish(f, it_id)
        {
            f.url.value = "<?php echo G5_SHOP_URL; ?>/wishupdate.php?it_id="+it_id;
            f.action = "<?php echo G5_SHOP_URL; ?>/wishupdate.php";
            f.submit();
        }

        // 추천메일
        function popup_item_recommend(it_id)
        {
            if (!g5_is_member)
            {
                if (confirm("회원만 추천하실 수 있습니다."))
                    document.location.href = "<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo urlencode(G5_SHOP_URL."/item.php?it_id=$it_id"); ?>";
            }
            else
            {
                url = "./itemrecommend.php?it_id=" + it_id;
                opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
                popup_window(url, "itemrecommend", opt);
            }
        }

        // 재입고SMS 알림
        function popup_stocksms(it_id)
        {
            url = "<?php echo G5_SHOP_URL; ?>/itemstocksms.php?it_id=" + it_id;
            opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
            popup_window(url, "itemstocksms", opt);
        }
        </script>
    </section>
    <!-- } 상품 요약정보 및 구매 끝 -->

</div>

</form>


<script>


$('#sit_sns_text').click(function(){
    this.select();
    document.execCommand("Copy");
});

$('#sit_sns_share_show').click(function(){
    $("#sit_sns_share_show").hide();
    $(".sit_sns_share_wrap").hide();
    $("#sit_sns_share_hide").show();
});

$('#sit_sns_share_hide').click(function(){
    $("#sit_sns_share_hide").hide();
    $(".sit_sns_share_wrap").show();
    $("#sit_sns_share_show").show();
});

$('#sit_zzim_show').click(function(){
    $("#sit_zzim_show").hide();
    $("#sit_zzim_hide").show();
});

$('#sit_zzim_hide').click(function(){
    $("#sit_zzim_show").show();
    $("#sit_zzim_hide").hide();
    item_wish(document.fitem, '<?php echo $it['it_id']; ?>');
});

$(function(){
    // 상품이미지 첫번째 링크
    $("#sit_pvi_big a:first").addClass("visible");

    // 상품이미지 미리보기 (썸네일에 마우스 오버시)
    $("#sit_pvi .img_thumb").bind("mouseover focus", function(){
        var idx = $("#sit_pvi .img_thumb").index($(this));
        $("#sit_pvi_big a.visible").removeClass("visible");
        $("#sit_pvi_big a:eq("+idx+")").addClass("visible");
    });

    $("#sit_sns_share_show").hide();
    $(".sit_sns_share_wrap").hide();
    $("#sit_zzim_show").hide();
   
});

function kakao_share() {
    Kakao.Link.sendCustom({
      templateId: 34060,
      templateArgs: {
        'title': '<?php echo stripslashes($it['it_name']); ?>',
        'price': '<?php echo get_price($it); ?>',
        'cust_price': '<?php echo $it['it_cust_price']; ?>',
        'sale': '<?php echo round($sale_ratio); ?>',
        'thu': '<?php echo $share_thumb; ?>',
        'path': 'shop/item.php?it_id=<?php echo $it_id; ?>'
      }
    });
}

function naver_share(url, title) {
    var share_url = encodeURI(encodeURIComponent(url));
    var share_title = encodeURI(title);
    var shareURL = "https://share.naver.com/web/shareView.nhn?url=" + share_url + "&title=" + share_title;
    window.open(shareURL);
    //document.location = shareURL;
}

function facebook_share(){
    var linkUrl = window.location.href; 
    window.open( 'http://www.facebook.com/sharer.php?u=' + encodeURIComponent(linkUrl) );
}

function fsubmit_check(f)
{
    // 판매가격이 0 보다 작다면
    if (document.getElementById("it_price").value < 0) {
        alert("전화로 문의해 주시면 감사하겠습니다.");
        return false;
    }

    if($(".sit_opt_list").size() < 1) {
        alert("상품의 선택옵션을 선택해 주십시오.");
        return false;
    }

    var val, io_type, result = true;
    var sum_qty = 0;
    var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
    var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
    var $el_type = $("input[name^=io_type]");

    $("input[name^=ct_qty]").each(function(index) {
        val = $(this).val();

        if(val.length < 1) {
            alert("수량을 입력해 주십시오.");
            result = false;
            return false;
        }

        if(val.replace(/[0-9]/g, "").length > 0) {
            alert("수량은 숫자로 입력해 주십시오.");
            result = false;
            return false;
        }

        if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
            alert("수량은 1이상 입력해 주십시오.");
            result = false;
            return false;
        }

        io_type = $el_type.eq(index).val();
        if(io_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    if(min_qty > 0 && sum_qty < min_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주십시오.");
        return false;
    }

    if(max_qty > 0 && sum_qty > max_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주십시오.");
        return false;
    }

    return true;
}

// 바로구매, 장바구니 폼 전송
function fitem_submit(f)
{
    f.action = "<?php echo $action_url; ?>";
    f.target = "";

    if (document.pressed == "장바구니") {
        f.sw_direct.value = 0;
    } else { // 바로구매
        f.sw_direct.value = 1;
    }

    // 판매가격이 0 보다 작다면
    if (document.getElementById("it_price").value < 0) {
        alert("전화로 문의해 주시면 감사하겠습니다.");
        return false;
    }

    if($(".sit_opt_list").size() < 1) {
        alert("상품의 선택옵션을 선택해 주십시오.");
        return false;
    }

    var val, io_type, result = true;
    var sum_qty = 0;
    var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
    var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
    var $el_type = $("input[name^=io_type]");

    $("input[name^=ct_qty]").each(function(index) {
        val = $(this).val();

        if(val.length < 1) {
            alert("수량을 입력해 주십시오.");
            result = false;
            return false;
        }

        if(val.replace(/[0-9]/g, "").length > 0) {
            alert("수량은 숫자로 입력해 주십시오.");
            result = false;
            return false;
        }

        if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
            alert("수량은 1이상 입력해 주십시오.");
            result = false;
            return false;
        }

        io_type = $el_type.eq(index).val();
        if(io_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    if(min_qty > 0 && sum_qty < min_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주십시오.");
        return false;
    }

    if(max_qty > 0 && sum_qty > max_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주십시오.");
        return false;
    }

    return true;
}
</script>
<?php /* 2017 리뉴얼한 테마 적용 스크립트입니다. 기존 스크립트를 오버라이드 합니다. */ ?>
<script src="<?php echo G5_JS_URL; ?>/shop.override.js"></script>
<!-- Enliple Tracker Start -->
<?php
    $it_name = $it['it_name'];
    $it_price = get_price($it);
    $it_cust_price = $it['it_cust_price'];
    if($is_soldout) {$soldout = "Y";} else {$soldout = "N";}
    $it_image = G5_DATA_URL.'/item/'.$it['it_img1'];
    $ca = sql_fetch(" select ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$it['ca_id']}' ");
    $ca_name = $ca['ca_name'];
?>
<script type="text/javascript">
var ENP_VAR = {
collect: {},
conversion: { product: [] }
};
ENP_VAR.collect.productCode = '<?php echo $it_id; ?>';
ENP_VAR.collect.productName = '<?php echo $it_name; ?>';
ENP_VAR.collect.price = '<?php echo $it_cust_price; ?>';
ENP_VAR.collect.dcPrice = '<?php echo $it_price; ?>';
ENP_VAR.collect.soldOut = '<?php echo $soldout; ?>';
ENP_VAR.collect.imageUrl = '<?php echo $it_image; ?>';
ENP_VAR.collect.topCategory = '<?php echo $ca_name; ?>';
ENP_VAR.collect.firstSubCategory = '<?php echo $ca_name; ?>';
ENP_VAR.collect.secondSubCategory = '<?php echo $ca_name; ?>';
ENP_VAR.collect.thirdSubCategory = '<?php echo $ca_name; ?>';

(function(a,g,e,n,t){a.enp=a.enp||function(){(a.enp.q=a.enp.q||[]).push(arguments)};n=g.createElement(e);n.async=!0;n.defer=!0;n.src="https://cdn.megadata.co.kr/dist/prod/enp_tracker_self_hosted.min.js";t=g.getElementsByTagName(e)[0];t.parentNode.insertBefore(n,t)})(window,document,"script");
    /* 상품수집 */
enp('create', 'collect', 'jhyim', { device: '<?php echo $device_type; ?>' });
    /* 장바구니 버튼 타겟팅 (이용하지 않는 경우 삭제) */
enp('create', 'cart', 'jhyim', { device: '<?php echo $device_type; ?>', btnSelector: '.btn_cart' });
    /* 찜 버튼 타겟팅 (이용하지 않는 경우 삭제) */
enp('create', 'wish', 'jhyim', { device: '<?php echo $device_type; ?>', btnSelector: '.btn_zzim' });
    /* 네이버페이 전환. (이용하지 않는 경우 삭제) */
    enp('create', 'conversion', 'jhyim', { device: '<?php echo $device_type; ?>', paySys: 'naverPay' });
</script>
    <!-- Enliple Tracker End -->
