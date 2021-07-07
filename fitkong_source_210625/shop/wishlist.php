<?php
include_once('./_common.php');

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL.'/wishlist.php'));

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/wishlist.php');
    return;
}

// 테마에 wishlist.php 있으면 include
if(defined('G5_THEME_SHOP_PATH')) {
    $theme_wishlist_file = G5_THEME_SHOP_PATH.'/wishlist.php';
    if(is_file($theme_wishlist_file)) {
        include_once($theme_wishlist_file);
        return;
        unset($theme_wishlist_file);
    }
}

$ws_referer = $_SERVER["HTTP_REFERER"];
if(preg_match('/item/i',$ws_referer)){
    $referer = 'item';
} else {
    $referer = '';  
}

$g5['title'] = "관심상품";
include_once('./_head.php');
?>

<div id="shop_cart_wrap">
    <div class="shop_main_title">관심상품</div>
    <div class="shop_con_wrap">
<!-- 위시리스트 시작 { -->
        <div id="sod_ws" class="od_prd_list">

            <form name="fwishlist" method="post" action="./cartupdate.php">
            <input type="hidden" name="act"       value="multi">
            <input type="hidden" name="sw_direct" value="">
            <input type="hidden" name="prog"      value="wish">

            <div class="tbl_head03 tbl_wrap">
                <table>
                <thead>
                <tr>
                    <th scope="col">
                        <label for="chk_all" class="sound_only"><span></span>상품 전체</label>
                        <input type="checkbox" name="chk_all" value="1" id="chk_all" checked="checked">
                        <label for="chk_all"><span></span></label>
                    </th>
                    <th scope="col"><span class="shop_wish_top_all">전체선택</span></th>
                </tr>
                </thead>
                <tbody>

                <?php
                $sql  = " select a.wi_id, a.wi_time, b.* from {$g5['g5_shop_wish_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id ) ";
                $sql .= " where a.mb_id = '{$member['mb_id']}' order by a.wi_id desc ";
                $result = sql_query($sql);
                for ($i=0; $row = sql_fetch_array($result); $i++) {

                    $out_cd = '';
                    $sql = " select count(*) as cnt from {$g5['g5_shop_item_option_table']} where it_id = '{$row['it_id']}' and io_type = '0' ";
                    $tmp = sql_fetch($sql);
                    if($tmp['cnt'])
                        $out_cd = 'no';

                    $it_price = get_price($row);

                    if ($row['it_tel_inq']) $out_cd = 'tel_inq';

                    $image = get_it_image($row['it_id'],150, 150);
                ?>

                <tr>
                    <td class="td_chk">
                        
                        <?php
                        // 품절검사
                        if(is_soldout($row['it_id']))
                        {
                        ?>
                        품절
                        <?php } else { //품절이 아니면 체크할수 있도록한다 ?>
                        
                        <input type="checkbox" name="chk_it_id[<?php echo $i; ?>]" value="1" id="chk_it_id_<?php echo $i; ?>" onclick="out_cd_check(this, '<?php echo $out_cd; ?>');" checked="checked">
                        <label for="chk_it_id_<?php echo $i; ?>"><span></span></label>
                        <?php } ?>
                        <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
                        <input type="hidden" name="io_type[<?php echo $row['it_id']; ?>][0]" value="0">
                        <input type="hidden" name="io_id[<?php echo $row['it_id']; ?>][0]" value="">
                        <input type="hidden" name="io_value[<?php echo $row['it_id']; ?>][0]" value="<?php echo $row['it_name']; ?>">
                        <input type="hidden" name="ct_qty[<?php echo $row['it_id']; ?>][0]" value="1">
                    </td> 
                    
                    <td  class="td_prd">
                        <div class="sod_img"><a href="./item.php?it_id=<?php echo $row['it_id']; ?>"><?php echo $image; ?></a></div>
                        <div class="sod_name">
                            <a href="./item.php?it_id=<?php echo $row['it_id']; ?>" class="prd_name"><b><?php echo stripslashes($row['it_name']); ?></b></a>
                            <div class="shop_wish_item_cust_price"><?php echo number_format($row['it_cust_price']); ?>원</div>
                            <div class="shop_wish_item_price"><?php echo  number_format($row['it_price']); ?>원</div>
                        </div>
                        <div class="sod_delete"><a href="./wishupdate.php?w=d&amp;wi_id=<?php echo $row['wi_id']; ?>" class="wish_del"><img src="<?php echo G5_IMG_URL ?>/x.png" class="shop_wish_item_delete"></a></div>
                    </td>
                </tr>
                <?php 
                } // for 끝

                if ($i == 0) {
                    echo '<tr><td colspan="8" class="shop_cart_empty_icon"><img src="'.G5_IMG_URL.'/empty_icon.png"></td></tr>';
                    echo '<tr><td colspan="8" class="empty_table">관심상품에 등록된 상품이 없습니다.</td></tr>';
                } 
                ?>
                </tbody>
                </table>
            </div>
            <div id="sod_bsk_act">
                <?php if ($i == 0) { ?>
                    <?php if($referer == 'item') { ?>
                    <button type="button" class="btn01" onclick="window.history.go(-1); return false;">쇼핑 계속하기</button>
                    <?php } else { ?>
                    <a href="<?php echo G5_SHOP_URL ?>"><button type="button" class="btn01">쇼핑 계속하기</button></a>
                    <?php } ?>
                <?php } else { ?>
                    <?php if($referer == 'item') { ?>
                    <button type="button" class="btn01" onclick="window.history.go(-1); return false;">쇼핑 계속하기</button>
                    <?php } else { ?>
                    <a href="<?php echo G5_SHOP_URL ?>"><button type="button" class="btn01">쇼핑 계속하기</button></a>
                    <?php } ?>
                    <button type="submit" onclick="return fwishlist_check(document.fwishlist,'');" class="btn_submit">장바구니 담기</button>
                <?php } ?>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
<!--
    function out_cd_check(fld, out_cd)
    {
        if (out_cd == 'no'){
            alert("옵션이 있는 상품입니다.\n\n상품을 클릭하여 상품페이지에서 옵션을 선택한 후 주문하십시오.");
            fld.checked = false;
            return;
        }

        if (out_cd == 'tel_inq'){
            alert("이 상품은 전화로 문의해 주십시오.\n\n장바구니에 담아 구입하실 수 없습니다.");
            fld.checked = false;
            return;
        }
    }

    // 모두선택
    $("input[name=chk_all]").click(function() {
        if($(this).is(":checked"))
            $("input[name^=chk_it_id]").attr("checked", true);
        else
            $("input[name^=chk_it_id]").attr("checked", false);
    });


    function fwishlist_check(f, act)
    {
        var k = 0;
        var length = f.elements.length;

        for(i=0; i<length; i++) {
            if (f.elements[i].checked) {
                k++;
            }
        }

        if(k == 0)
        {
            alert("상품을 하나 이상 체크 하십시오");
            return false;
        }

        if (act == "direct_buy")
        {
            f.sw_direct.value = 1;
        }
        else
        {
            f.sw_direct.value = 0;
        }

        return true;
    }
//-->
</script>
<!-- } 위시리스트 끝 -->

<?php
include_once('./_tail.php');
?>