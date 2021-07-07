<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨

add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/swiper.css">', 0);
?>

<?
   if ($it_id == '1622793578' || $it_id == '1622793637' || $it_id == '1622793630') {
        $promotion_item = true;
    } else {
        $promotion_item = false;
    } 
?>

<?php if($config['cf_kakao_js_apikey']) { ?>
<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
<script src="<?php echo G5_JS_URL; ?>/kakaolink.js"></script>
<script>
    // 사용할 앱의 Javascript 키를 설정해 주세요.
    Kakao.init("<?php echo $config['cf_kakao_js_apikey']; ?>");
</script>
<?php } ?>


<div id="sit_purchase_popup_bg"></div>
<form name="fitem" action="<?php echo $action_url; ?>" method="post" onsubmit="return fitem_submit(this);">
<input type="hidden" name="it_id[]" value="<?php echo $it['it_id']; ?>">
<input type="hidden" name="sw_direct">
<input type="hidden" name="url">
<div id="purchase_popup" style="display:none;" class="wow slideInUp" data-wow-duration="1s" data-wow-delay=".1s" data-wow-offset="10">
    <div id="purchase_popup_con" class="purchase_popup_con_wrap">
        <?php
        if($option_item) {
        ?>
        <section class="sit_option">
            <h3>선택옵션</h3>
            <table class="sit_op_sl">
            <colgroup>
                <col class="grid_2">
                <col>
            </colgroup>
            <tbody>
            <?php // 선택옵션
            echo $option_item;
            ?>
            </tbody>
            </table>
        </section>
        <?php
        }
        ?>

        <?php
        if($supply_item) {
        ?>
        <section class="sit_option">
            <h3>추가옵션</h3>
            <table class="sit_op_sl">
            <colgroup>
                <col class="grid_2">
                <col>
            </colgroup>
            <tbody>
            <?php // 추가옵션
            echo $supply_item;
            ?>
            </tbody>
            </table>
        </section>
        <?php
        }
        ?>

        <?php if ($it['it_use'] && !$it['it_tel_inq'] && !$is_soldout) { ?>
        <div id="sit_sel_option">
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
                        <input type="text" name="ct_qty[<?php echo $it_id; ?>][]" value="<?php echo $it['it_buy_min_qty']; ?>" id="ct_qty_<?php echo $i; ?>" class="num_input" size="5">
                        <button type="button" class="sit_qty_plus" <?php if ($promotion_item) { echo "disabled"; }?>><i class="fa fa-plus" aria-hidden="true"></i><span class="sound_only">증가</span></button>
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
        </div>

        <div id="sit_tot_price"></div>
        <?php } ?>

        <?php if($is_soldout) { ?>
        <p id="sit_ov_soldout">상품의 재고가 부족하여 구매할 수 없습니다.</p>
        <?php } ?>

        <div id="sit_ov_btn">
            <?php if ($is_orderable) { ?>
            <input type="submit" onclick="document.pressed=this.value;" value="장바구니" id="sit_btn_cart" class="btn_cart enp_mobon_cart <?php if ($promotion_item) { echo "btn_cart_promotion"; }?>">
            <?php if (!$promotion_item) { ?>
            <input type="submit" onclick="document.pressed=this.value;" value="바로구매" id="sit_btn_buy" class="btn_buy">
            <?php } ?>
            <?php } ?>
            <?php if(!$is_orderable && $it['it_soldout'] && $it['it_stock_sms']) { ?>
            <a href="javascript:popup_stocksms('<?php echo $it['it_id']; ?>');" id="sit_btn_buy">재입고알림</a>
            <?php } ?>
            <?php if (!$promotion_item) { ?>
            <?php if ($naverpay_button_js) { ?>
            <div class="naverpay-item"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
            <?php } ?>
            <?php } ?>
        </div>
    </div>
    </div>
<div id="sit_ov_wrap">
    <div class="swiper-container banner-container">
    
    <?php
    // 이미지(중) 썸네일
    $thumb_img = '';
    $thumb_img_w = 430; // 넓이
    $thumb_img_h = 430; // 높이
    for ($i=1; $i<=10; $i++)
    {
        if(!$it['it_img'.$i])
            continue;

        $thumb = get_it_thumbnail($it['it_img'.$i], 430,430,$thumb_img_w, $thumb_img_h);

        if(!$thumb)
            continue;
        $thumb_img .= '<div class="swiper-slide" style="text-align:center;background:#fafafa">';
        $thumb_img .= '<li>';
        $thumb_img .= $thumb;
        $thumb_img .= '</li>';
        $thumb_img .= '</div>'.PHP_EOL;
    }
    if ($thumb_img)
    {
        echo '<div class="swiper-wrapper" style="text-align:center;background:#fafafa">'.PHP_EOL;
        echo $thumb_img;
        echo '</div>'.PHP_EOL;
       
    }

    $sns_thumb = get_it_thumbnail($it['it_img1'], 90, 90);
    $share_thumb = get_it_imageurl($it['it_id']);
    $sns_share_url = G5_SHOP_URL."/item.php?it_id=".$it['it_id'];

    ?>
    <div class="swiper-pagination main-banner-number"></div>
    </div>

    <!-- 다른 상품 보기 시작 { -->
    <div id="sit_siblings" style="display: none">
        <?php
        if ($prev_href || $next_href) {
            $prev_title = '<i class="fa fa-caret-left" aria-hidden="true"></i> '.$prev_title;
            $next_title = $next_title.' <i class="fa fa-caret-right" aria-hidden="true"></i>';

            echo $prev_href.$prev_title.$prev_href2;
            echo $next_href.$next_title.$next_href2;
        } else {
            echo '<span class="sound_only">이 분류에 등록된 다른 상품이 없습니다.</span>';
        }
        ?>
        <a href="<?php echo G5_SHOP_URL; ?>/largeimage.php?it_id=<?php echo $it['it_id']; ?>&amp;no=1" target="_blank" class="popup_item_image "><i class="fa fa-search-plus" aria-hidden="true"></i><span class="sound_only">확대보기</span></a>
    </div>
    <!-- } 다른 상품 보기 끝 -->

    <div id="sit_star_sns" style="display: none">
        <?php
        $sns_title = get_text($it['it_name']).' | '.get_text($config['cf_title']);
        $sns_url  = G5_SHOP_URL.'/item.php?it_id='.$it['it_id'];

        if ($score = get_star_image($it['it_id'])) { ?>
        <span class="sound_only">고객평점 <?php echo $score?>개</span>
        <img src="<?php echo G5_SHOP_URL; ?>/img/s_star<?php echo $score?>.png" alt="" class="sit_star" width="100"> <span class="st_bg"></span>
        <?php } ?>


         <i class="fa fa-commenting-o" aria-hidden="true"></i><span class="sound_only">리뷰</span> <?php echo $it['it_use_cnt']; ?>
        <span class="st_bg"></span> <i class="fa fa-heart-o" aria-hidden="true"></i><span class="sound_only">위시</span> <?php echo get_wishlist_count_by_item($it['it_id']); ?>
        <button type="button" class="btn_sns_share"><i class="fa fa-share-alt" aria-hidden="true"></i><span class="sound_only">sns 공유</span></button>
        <div class="sns_area">
            <?php echo get_sns_share_link('facebook', $sns_url, $sns_title, G5_MSHOP_SKIN_URL.'/img/facebook.png'); ?>
            <?php echo get_sns_share_link('twitter', $sns_url, $sns_title, G5_MSHOP_SKIN_URL.'/img/twitter.png'); ?>
            <?php echo get_sns_share_link('googleplus', $sns_url, $sns_title, G5_MSHOP_SKIN_URL.'/img/gplus.png'); ?>
            <?php echo get_sns_share_link('kakaotalk', $sns_url, $sns_title, G5_MSHOP_SKIN_URL.'/img/sns_kakao.png'); ?>
            <?php
            $href = G5_SHOP_URL.'/iteminfo.php?it_id='.$it_id;
            ?> 
            <a href="javascript:popup_item_recommend('<?php echo $it['it_id']; ?>');" id="sit_btn_rec"><i class="fa fa-envelope-o" aria-hidden="true"></i><span class="sound_only">추천하기</span></a></div>
        </div>
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
    <section id="sit_ov" class="2017_renewal_itemform">
        <img src="<?php echo G5_IMG_URL; ?>/zzim_no_select.png" class="sit_zzim btn_zzim" id="sit_zzim_hide">
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
            <div class="sit_sns_share_url"><input type="text" id="sit_sns_text" class="sit_sns_text" value="<?php echo $sns_share_url; ?>" readonly></div>
        </div>
        <div class="sit_ov_wr">
            <strong id="sit_title"><?php echo stripslashes($it['it_name']); ?></strong>
            <?php if($it['it_basic']) { ?><p id="sit_desc"><?php echo $it['it_basic']; ?></p><?php } ?>
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
            <div id ="sit_price">
                <?php if($sale_ratio != 0 && $sale_ratio != 100) { ?>
                <span class="sit_sale_ratio"><?php echo $sale_ratio; ?>%</span>
                <?php } ?>
                <span class="sit_cust_price"><?php echo display_price($it['it_cust_price']); ?></span>
                <span class="sit_price"><?php echo display_price(get_price($it)); ?></span>
                <input type="hidden" id="it_price" value="<?php echo get_price($it); ?>">
            </div>

            <div class="sit_ov_tbl">
                <table >
                <colgroup>
                    <col class="grid_2">
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
                                //$new_point = number_format($it['it_point']) + (($member['mb_level']-2)*2);
                                //$new_point = number_format($it['it_point']); 
                                $new_point = number_format($it['it_point']) * $member_point;
                            } else {
                                //$new_point = number_format($it['it_point']);
                                $new_point = number_format($it['it_point']) * $member_point;
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
        </div>
        
    </section>
</div>
<section id="mo_best_product">
    <div class="mo_best_product_wrap">
    <div class="mo_left_title">
        <div class="mo_left_title_text"><img src="<?php echo G5_IMG_URL ?>/best_title_icon.png" class="mo_left_title_icon"> 이 상품은 어때요?</div>
        <div class="mo_left_title_line"></div>
    </div>
    <div class="mo_best_product_item_wrap">
        <div class="swiper-container best-product-container mo_swiper_slide_end">
            <div class="swiper-wrapper">
                <?php 
                    $sql = " select * from {$g5['g5_shop_item_table']} where it_use = '1' AND it_type2 = '1' AND it_id != '$it_id' order by it_order, it_id desc LIMIT 10";
                    $result = sql_query($sql);
                    for($i=0; $row=sql_fetch_array($result); $i++)
                    {

                    if(!$row['it_img2']){
                        $row['it_img2'] = $row['it_img1'];
                    }
                    $row['it_img1'] = G5_DATA_URL.'/item/'.$row['it_img1'];
                    $row['it_img2'] = G5_DATA_URL.'/item/'.$row['it_img2'];

                    $sale_ratio = ($row['it_price'] / $row['it_cust_price']) * 100;
                    $sale_ratio = 100 - $sale_ratio;
                    $sale_ratio = round($sale_ratio);

                    $row['it_price'] = display_price($row['it_price']);
                    $row['it_cust_price'] = display_price($row['it_cust_price']);
                ?>
                <div class="swiper-slide mo_best_product_item">
                    <a href="<?php echo G5_SHOP_URL ?>/item.php?it_id=<?php echo $row['it_id']; ?>">
                    <img src="<?php echo $row['it_img1']; ?>" alt="" class="mo_best_product_item_image">
                    <div class="mo_best_product_item_badge"><?php if($row['it_type4'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/best.png"><? }?><?php if($row['it_type3'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/new.png"><? }?><?php if($row['it_type5'] == '1') { ?><img src="<?php echo G5_IMG_URL ?>/sale.png"><? }?></div>
                    <div class="mo_best_product_item_name"><?php echo $row['it_name']; ?></div>
                    <div class="mo_best_product_item_bprice"><?php echo $row['it_cust_price']; ?></div>
                    <?php if($sale_ratio != 0 && $sale_ratio != 100) { ?>
                    <div class="mo_best_product_item_sratio"><?php echo $sale_ratio; ?>% ↓</div>
                    <?php } ?>
                    <div class="mo_best_product_item_price"><?php echo $row['it_price']; ?></div>
                    </a>
                </div>
                <?php } ?> 
                         
            </div>
        </div>
    </div>
</section>

<div id="sit_tab">
    <ul class="tab_tit">
        <li><button type="button" rel="#sit_inf" class="selected">상품정보</button></li>
        <li><button type="button" rel="#sit_use">상품리뷰<span>(<?php echo $it['it_use_cnt']; ?>)</button></span></li>
        <li><button type="button" rel="#sit_qa">상품문의</button></li>
        <li><button type="button" rel="#sit_dvex">구매안내</button></li>
    </ul>
    <ul class="tab_con">

        <!-- 상품 정보 시작 { -->
        <li id="sit_inf">
            <h2 class="contents_tit"><span>상품 정보</span></h2>

            <?php if ($it['it_explan'] || $it['it_mobile_explan']) { // 상품 상세설명 ?>
            <h3>상품 상세설명</h3>
            <div id="sit_inf_explan">
                <?php
                $sql = " select * from {$g5['g5_shop_con_banner_table']} where bn_use = '1' AND bn_device = 'mobile' order by bn_order asc ";
                $result = sql_query($sql);
                for($i=0; $row=sql_fetch_array($result); $i++)
                {
                    if(!$row['bn_img_url']) {
                        $row['bn_img_url'] = G5_DATA_URL.'/con_banner/'.$row['bn_id'];
                    }

                    if($row['bn_new_win']) {
                        $bn_new = "_blank";
                    } else {
                        $bn_new = "_self";
                    }
                ?>
                <?php if($row['bn_url'] && $row['bn_url'] != 'http://') { ?><a href="<?php echo $row['bn_url']; ?>" target="<?php echo $bn_new; ?>"><?php } ?><img src="<?php echo $row['bn_img_url']; ?>" style="width:100%;">
                <?php if($row['bn_url'] && $row['bn_url'] != 'http://') { ?></a><?php } }?>
                
                <?php echo ($it['it_mobile_explan'] ? conv_content($it['it_mobile_explan'], 1) : conv_content($it['it_explan'], 1)); ?>
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
            <table id="sit_inf_open" style="display: none;">
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

        </li>
        <!-- 사용후기 시작 { -->
        <li id="sit_use">
            <h2>사용후기</h2>

            <div id="itemuse"><?php include_once(G5_SHOP_PATH.'/itemuse.php'); ?></div>
        </li>
        <!-- } 사용후기 끝 -->

        <!-- 상품문의 시작 { -->
        <li id="sit_qa">
            <h2>상품문의</h2>

            <div id="itemqa"><?php include_once(G5_SHOP_PATH.'/itemqa.php'); ?></div>
        </li>
        <!-- } 상품문의 끝 -->

        <?php if ($default['de_baesong_content']) { // 배송정보 내용이 있다면 ?>
        <!-- 배송정보 시작 { -->
        <li id="sit_dvex">
            <h2>배송/교환정보</h2>
            <div id="sit_dvr">
                <div class="sit_dvr_title">배송 안내</div>
                <div class="sit_dvr_con">핏콩은 우체국택배를 이용하며, 출고일 기준 1~2일 정도 소요됩니다.</div>
                <div class="sit_dvr_con">·&nbsp;  우체국택배 사정으로 변동될 수 있는 점 양해 부탁드립니다.</div>
                <br>
                <div class="sit_dvr_con">배송비는 3,000원이며, 50,000원 이상 구매시 무료배송입니다.</div>
                <div class="sit_dvr_con">·&nbsp;  제주/도서/산간지역 추가배송비는 없습니다.</div>
                <br>
                <div class="sit_dvr_con">오후 12시 이전 주문건에 한해 당일출고되며, 출고 이후 주문취소/변경은 불가능합니다.</div>
                <div class="sit_dvr_con">·&nbsp;  핏콩팀 내부일정으로 인해 시간이 변동될 수 있는 점 양해 부탁드립니다.</div>
                <div class="sit_dvr_con">·&nbsp;  카톡문의로 문의해주시면 보다 빠른 서비스 도와드리겠습니다.</div>
                
                <div class="sit_dvr_title">주문/결제 안내</div>
                <div class="sit_dvr_con">가상계좌 결제의 경우, 주문일 이후 (영업일 기준) 2일 이내 입금해주셔야 주문이 가능합니다.</div>
                <div class="sit_dvr_con">입금시 입금자명/은행/계좌번호가 동일한지 반드시 확인해주세요.</div>
                <br>
                <div class="sit_dvr_con">단, 이벤트 상품 및 한정판매 제품의 경우, (영업일 기준) 주문일 익일 자정까지 미입금시 자동 취소될 수 있습니다.</div>
                
                <div class="sit_dvr_title">반품 / 교환 안내</div>
                <div class="sit_dvr_con">상품 수령일로부터 7일 이내에 1:1문의/카톡문의/전화문의로 교환/환불 의사를 밝혀주세요.</div>
                <div class="sit_dvr_con">·&nbsp;  반드시 핏콩팀과 협의 후에 보내주셔야 하며, 협의 없이 반품 보내주시면 처리가 어렵습니다.</div>
                <br>
                <div class="sit_dvr_con2">반품배송비 3,000원</div>
                <div class="sit_dvr_con2">교환배송비 6,000원</div>
                <br>
                <div class="sit_dvr_con">상품에 문제가 있을 경우, 배송비는 핏콩에서 부담합니다.</div>
                <div class="sit_dvr_con">·&nbsp;  제품 하자 관련 확인을 위해 반드시 사진 촬영 및 제품 보관 해주세요.</div>
                <div class="sit_dvr_con">·&nbsp;  사진과 제품 실물 확인이 불가능 한 경우, 교환/반품 처리가 어렵습니다.</div>
                <div class="sit_dvr_con">단순변심에 의한 교환/반품은 불가능합니다.</div>
                <br>
                <div class="sit_dvr_con">교환/반품이 불가능한 경우</div>
                <div class="sit_dvr_con">·&nbsp;  반품가능기간이 지난 경우</div>
                <div class="sit_dvr_con">·&nbsp;  핏콩팀과 교환/반품에 대한 협의 없이 임의로 폐기처분 또는 반품배송한 경우</div>
                <div class="sit_dvr_con">·&nbsp;  잘못된 배송지 기재로 인한 반송 또는 고객의 부재로 인해 배송이 지연되어 제품이 변질된 경우</div>
                <div class="sit_dvr_con">·&nbsp;  수령 후 보관/취급 부주의로 인해 제품이 변질 또는 손상된 경우</div>
                <div class="sit_dvr_con">·&nbsp;  제품을 드신 경우</div>
                <div class="sit_dvr_con">·&nbsp;  단순변심 등 고객님의 귀책사유에 의한 경우</div>
                <br>
                <div class="sit_dvr_con">기타 보상은 당사 소비자 피해보상 규정에 의해 처리됩니다.</div>
                <br>
                <div class="sit_dvr_con">결제 방법에 따라 환불소요기간이 오래 걸릴 수 있습니다.</div>
                <div class="sit_dvr_con">·&nbsp;   카드결제의 경우, 카드사에 따라 상이하며, 일반적으로 카드사 영업일 기준 3~7일 정도 소요됩니다.</div>
                <br><br>

                <?php //echo conv_content($default['de_baesong_content'], 1); ?>
            </div>
            <!-- } 배송정보 끝 -->
            <?php } ?>


           
        </li>
    </ul>
</div>
<div class="sit_bottom_order" id="sit_purchase_popup">구매하기</div>
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
</form>

<?php if($default['de_mobile_rel_list_use']) { ?>
<!-- 관련상품 시작 { --
<section id="sit_rel">
    <h2>관련상품</h2>
    <div class="sct_wrap">
        <?php
        $rel_skin_file = $skin_dir.'/'.$default['de_mobile_rel_list_skin'];
        if(!is_file($rel_skin_file))
            $rel_skin_file = G5_MSHOP_SKIN_PATH.'/'.$default['de_mobile_rel_list_skin'];

        $sql = " select b.* from {$g5['g5_shop_item_relation_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id) where a.it_id = '{$it['it_id']}' and b.it_use='1' ";
        $list = new item_list($rel_skin_file, $default['de_mobile_rel_list_mod'], 0, $default['de_mobile_rel_img_width'], $default['de_mobile_rel_img_height']);
        $list->set_query($sql);
        //echo $list->run();
        ?>
    </div>
</section>
<!-- } 관련상품 끝 -->
<?php } ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js"></script>
<script type="text/javascript">

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

$('#sit_purchase_popup').click(function(){
   if (typeof wow !== 'undefined') {
    wow.scrolled = true;
    wow.scrollCallback();
  }
   $('#purchase_popup').delay(150).show();
   $('#sit_purchase_popup_bg').delay(150).show();
});

$('#sit_purchase_popup_bg').click(function(){
   $('#purchase_popup').delay(100).hide();
   $('#sit_purchase_popup_bg').delay(100).hide();
   var wow = new WOW();
   wow.init();
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
$(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        document.location.reload();
    }
});

$(function(){
    // 상품이미지 슬라이드
    var time = 500;
    var idx = idx2 = 0;
    var slide_width = $("#sit_pvi_slide").width();
    var slide_count = $("#sit_pvi_slide li").size();
    $("#sit_pvi_slide li:first").css("display", "block");
    if(slide_count > 1)
        $(".sit_pvi_btn").css("display", "inline");

    $("#sit_pvi_prev").click(function() {
        if(slide_count > 1) {
            idx2 = (idx - 1) % slide_count;
            if(idx2 < 0)
                idx2 = slide_count - 1;
            $("#sit_pvi_slide li:hidden").css("left", "-"+slide_width+"px");
            $("#sit_pvi_slide li:eq("+idx+")").filter(":not(:animated)").animate({ left: "+="+slide_width+"px" }, time, function() {
                $(this).css("display", "none").css("left", "-"+slide_width+"px");
            });
            $("#sit_pvi_slide li:eq("+idx2+")").css("display", "block").filter(":not(:animated)").animate({ left: "+="+slide_width+"px" }, time,
                function() {
                    idx = idx2;
                }
            );
        }
    });

    $("#sit_pvi_next").click(function() {
        if(slide_count > 1) {
            idx2 = (idx + 1) % slide_count;
            $("#sit_pvi_slide li:hidden").css("left", slide_width+"px");
            $("#sit_pvi_slide li:eq("+idx+")").filter(":not(:animated)").animate({ left: "-="+slide_width+"px" }, time, function() {
                $(this).css("display", "none").css("left", slide_width+"px");
            });
            $("#sit_pvi_slide li:eq("+idx2+")").css("display", "block").filter(":not(:animated)").animate({ left: "-="+slide_width+"px" }, time,
                function() {
                    idx = idx2;
                }
            );
        }
    });

    // 상품이미지 크게보기
    $(".popup_item_image").click(function() {
        var url = $(this).attr("href");
        var top = 10;
        var left = 10;
        var opt = 'scrollbars=yes,top='+top+',left='+left;
        popup_window(url, "largeimage", opt);

        return false;
    });

    var swiper1 = new Swiper('.banner-container', {
     pagination: {
        el: '.swiper-pagination',
        type: 'fraction',
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
     
    });
    var swiper2 = new Swiper('.best-product-container', {
      slidesPerView: 2.5,
      spaceBetween: 20,
      freeMode: true,
      pagination: {
        el: '.swiper-pagination2',
        clickable: true,
      },
    });

    $("#sit_sns_share_show").hide();
    $(".sit_sns_share_wrap").hide();
    $("#sit_zzim_show").hide();
});

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
        url = "<?php echo G5_SHOP_URL; ?>/itemrecommend.php?it_id=" + it_id;
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
        fbq('track', 'AddToCart');
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


$('#sit_sns_text').click(function(){
    this.select();
    document.execCommand("Copy");
    alert("주소가 복사되었습니다");
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
