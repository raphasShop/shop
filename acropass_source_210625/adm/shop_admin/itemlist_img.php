<?php
$sub_menu = '400399'; /* 새로만든 메뉴코드 */
include_once('./_common.php');

$g5['title'] = '상품이미지 변경/추가 새창';

include_once(G5_EDITOR_LIB);
include_once(G5_LIB_PATH.'/iteminfo.lib.php');
include_once(G5_ADMIN_PATH.'/admin.head.sub.php');

auth_check($auth[$sub_menu], "r");

    $html_title .= "수정";

    //if ($is_admin != 'super') 부운영자도 제한없이 사용가능 - 나중에 변경할것
    //{
        $sql = " select it_id from {$g5['g5_shop_item_table']} a, {$g5['g5_shop_category_table']} b
                  where a.it_id = '$it_id'
                    and a.ca_id = b.ca_id
                    and b.ca_mb_id = '{$member['mb_id']}' ";
        $row = sql_fetch($sql);
        //if (!$row['it_id'])
        //    alert("\'{$member['mb_id']}\' 님께서 수정 할 권한이 없는 상품입니다.");
    //}

    $sql = " select * from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
    $it = sql_fetch($sql);

    if(!$it)
        alert('상품정보가 존재하지 않습니다.');

    if (!$ca_id)
        $ca_id = $it['ca_id'];

    $sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' ";
    $ca = sql_fetch($sql);


$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page;

$frm_submit = '<div class="btn_confirm01 btn_confirm" style="display:inline-block;"><input type="submit" value="상품이미지 저장하기" class="btn_submit_big" accesskey="s"></div>';
?>

<form name="fitemform" action="./itemlist_imgupdate.php" method="post" enctype="MULTIPART/FORM-DATA" autocomplete="off" onsubmit="return fitemformcheck(this)">

<input type="hidden" name="codedup" value="<?php echo $default['de_code_dup_use']; ?>">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="it_id" value="<?php echo $it['it_id']; ?>">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod"  value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx"  value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<section id="anc_sitfrm_img">
<?php echo $pg_anchor; ?>
<div class="imgplus_h2">
    상품이미지 변경/추가
    <div class="pull-right">
    <a href="#" onclick="window.close();parent.opener.location.reload();" style="position:absolute; top:0; right:0;  padding:5px 20px; font-family:돋움,dotum; font-size:28px;font-weight:lighter;color:#333;" title="창닫기">×</a>
    </div>
</div>

<div class="compare_wrap_nostyle">
    <!-- ### 좌측 상품이미지 등록 (1) ~ (5) 시작 { ### -->
    <section class="compare_nostyle_left">
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>이미지 업로드</caption>
        <colgroup>
            <col class="grid_2">
            <col class="grid_2">
            <col>
        </colgroup>
        <tbody>
        <?php for($i=1; $i<=5; $i++) { ?>
        <tr>
            <th scope="row" style="text-align:center;">
            <?php echo ($i == 1) ? '<span class="lightpink font-normal font-11">대표이미지</span><br>' : ''; //대표이미지?>
            <label for="it_img<?php echo $i; ?>">상품사진<?php echo $i; ?></label>
            </th>
            <th scope="row" style="height:119px; background:#fafafa; padding:0; margin:0;">
                <!-- 상품썸네일 -->
				<?php
                $it_img = G5_DATA_PATH.'/item/'.$it['it_img'.$i];
                if(is_file($it_img) && $it['it_img'.$i]) {
                    $size = @getimagesize($it_img);
                    $thumb = get_it_thumbnail($it['it_img'.$i], 100, 100);
                ?>
                <span class="sit_wimg_limg<?php echo $i; ?>" title="상품이미지<?php echo $i; ?>"><?php echo $thumb; ?></span>
                <!-- 이미지 삭제 -->
                <div style="display:inline-block; padding:2px 0px 2px 10px; font-size:11px; font-weight:normal; color:#666666;">
                <label for="it_img<?php echo $i; ?>_del"><span class="sound_only">이미지 <?php echo $i; ?> </span>삭제</label>
                <input type="checkbox" name="it_img<?php echo $i; ?>_del" id="it_img<?php echo $i; ?>_del" value="1">
                </div>
                <?php } ?>
                <!--//-->
            </th>
            <td>
                <!-- 이미지 첨부 -->
                <input type="file" name="it_img<?php echo $i; ?>" id="it_img<?php echo $i; ?>">
                <!--//-->
                <!-- 큰이미지보기/스크립트 -->
                <div id="limg<?php echo $i; ?>" class="banner_or_img_layer">
                    <img src="<?php echo G5_DATA_URL; ?>/item/<?php echo $it['it_img'.$i]; ?>" alt="" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>" class="sit_wimg_close">
                    <!--<br><button type="button" class="sit_wimg_close">닫기</button>-->
                </div>

                <script>
                $('<div class="pull-right" style="display:inline-block;padding:0;margin:0;margin-right:-1px;margin-bottom:-1px;"><button type="button" id="it_limg<?php echo $i; ?>_view" class="sit_wimg_view" style="min-width:20px; padding:0px 3px 0px; border:solid 1px #FF9900; background:#FFFFFF; font-family: Dotum,돋움, Arial, sans-serif; font-size:12px; line-height:18px !important; color:#FF3300; text-align:center; z-index:999;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;">＋</button></div>').appendTo('.sit_wimg_limg<?php echo $i; ?>');
                </script>
                <!--//-->
            </td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
    </section>
    <!-- ### } 좌측 상품이미지 등록 (1) ~ (5) 끝 ### -->

    <!-- ### 우측 상품이미지 등록 (6) ~ (10) 시작 { ### -->
    <section class="compare_nostyle_right">
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>이미지 업로드</caption>
        <colgroup>
            <col class="grid_2">
            <col class="grid_2">
            <col>
        </colgroup>
        <tbody>
        <?php for($i=6; $i<=10; $i++) { ?>
        <tr>
            <th scope="row" style="text-align:center;"><label for="it_img<?php echo $i; ?>">상품사진<?php echo $i; ?></label></th>
            <th scope="row" style="height:119px; background:#fafafa; padding:0; margin:0;">
                <!-- 상품썸네일 -->
				<?php
                $it_img = G5_DATA_PATH.'/item/'.$it['it_img'.$i];
                if(is_file($it_img) && $it['it_img'.$i]) {
                    $size = @getimagesize($it_img);
                    $thumb = get_it_thumbnail($it['it_img'.$i], 100, 100);
                ?>
                <span class="sit_wimg_limg<?php echo $i; ?>" title="상품이미지<?php echo $i; ?>"><?php echo $thumb; ?></span>
                <!-- 이미지 삭제 -->
                <div style="display:inline-block; padding:2px 0px 2px 10px; font-size:11px; font-weight:normal; color:#666666;">
                <label for="it_img<?php echo $i; ?>_del"><span class="sound_only">이미지 <?php echo $i; ?> </span>삭제</label>
                <input type="checkbox" name="it_img<?php echo $i; ?>_del" id="it_img<?php echo $i; ?>_del" value="1">
                </div>
                <?php } ?>
                <!--//-->
            </th>
            <td>
                <!-- 이미지 첨부 -->
                <input type="file" name="it_img<?php echo $i; ?>" id="it_img<?php echo $i; ?>">
                <!--//-->
                <!-- 큰이미지보기/스크립트 -->
                <div id="limg<?php echo $i; ?>" class="banner_or_img_layer" style="position:absolute; top:250px; left:10px;">
                    <img src="<?php echo G5_DATA_URL; ?>/item/<?php echo $it['it_img'.$i]; ?>" alt="" width="<?php echo $size[0]; ?>" height="<?php echo $size[1]; ?>" class="sit_wimg_close">
                    <!--<br><button type="button" class="sit_wimg_close">닫기</button>-->
                </div>

                <script>
                $('<div class="pull-right" style="display:inline-block;padding:0;margin:0;margin-right:-1px;margin-bottom:-1px;"><button type="button" id="it_limg<?php echo $i; ?>_view" class="sit_wimg_view" style="min-width:20px; padding:0px 3px 0px; border:solid 1px #FF9900; background:#FFFFFF; font-size:12px; line-height:18px !important; color:#FF3300; text-align:center; z-index:999;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;">＋</button></div>').appendTo('.sit_wimg_limg<?php echo $i; ?>');
                </script>
                <!--//-->
            </td>
        </tr>
        <?php } ?>
        </tbody>
        </table>
    </div>
    </section>
    <!-- ### } 우측 상품이미지 등록 (6) ~ (10) 끝 ### -->
</div>

<div style="height:50px; text-align:center;"><?php echo $frm_submit; ?></div>

</section>

</form>


<script>
var f = document.fitemform;

<?php if ($w == 'u') { ?>
$(".banner_or_img_layer").addClass("sit_wimg");
$(function() {
    $(".sit_wimg_view").bind("click", function() {
        var sit_wimg_id = $(this).attr("id").split("_");
        var $img_display = $("#"+sit_wimg_id[1]);

        $img_display.toggle();

        if($img_display.is(":visible")) {
            $(this).text($(this).text().replace("＋", "－"));
        } else {
            $(this).text($(this).text().replace("－", "＋"));
        }

        var $img = $("#"+sit_wimg_id[1]).children("img");
        var width = $img.width();
        var height = $img.height();
        if(width > 700) {
            var img_width = 700;
            var img_height = Math.round((img_width * height) / width);

            $img.width(img_width).height(img_height);
        }
    });
    $(".sit_wimg_close").bind("click", function() {
        var $img_display = $(this).parents(".banner_or_img_layer");
        var id = $img_display.attr("id");
        $img_display.toggle();
        var $button = $("#it_"+id+"_view");
        $button.text($button.text().replace("닫기", "확인"));
    });
});
<?php } ?>

function fitemformcheck(f)
{

    if (f.w.value == "") {
        var error = "";
        $.ajax({
            url: "./ajax/ajax.it_id.php",
            type: "POST",
            data: {
                "it_id": f.it_id.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                error = data.error;
            }
        });

        if (error) {
            alert(error);
            return false;
        }
    }



}
</script>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.sub.php');
?>