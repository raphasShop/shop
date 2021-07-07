<?php
$sub_menu = '400720'; /* 원본코드 500720 */
include_once('./_common.php');
include_once(G5_LIB_PATH.'/shop_xml.lib.php');

check_demo();

auth_check($auth[$sub_menu], "r");

function yc5_get_item_image_url($it_id){
    return G5_DATA_URL.'/item/';
}

if( isset($_POST['action']) && 'export_data' === $_POST['action'] ){

    $items = array();

    $de_keys = array(
        'de_type1_list_use',
        'de_type1_list_skin',
        'de_type1_list_mod',
        'de_type1_list_row',
        'de_type1_img_width',
        'de_type1_img_height',
        'de_type2_list_use',
        'de_type2_list_skin',
        'de_type2_list_mod',
        'de_type2_list_row',
        'de_type2_img_width',
        'de_type2_img_height',
        'de_type3_list_use',
        'de_type3_list_skin',
        'de_type3_list_mod',
        'de_type3_list_row',
        'de_type3_img_width',
        'de_type3_img_height',
        'de_type4_list_use',
        'de_type4_list_skin',
        'de_type4_list_mod',
        'de_type4_list_row',
        'de_type4_img_width',
        'de_type4_img_height',
        'de_type5_list_use',
        'de_type5_list_skin',
        'de_type5_list_mod',
        'de_type5_list_row',
        'de_type5_img_width',
        'de_type5_img_height',
        'de_mobile_type1_list_use',
        'de_mobile_type1_list_skin',
        'de_mobile_type1_list_mod',
        'de_mobile_type1_list_row',
        'de_mobile_type1_img_width',
        'de_mobile_type1_img_height',
        'de_mobile_type2_list_use',
        'de_mobile_type2_list_skin',
        'de_mobile_type2_list_mod',
        'de_mobile_type2_list_row',
        'de_mobile_type2_img_width',
        'de_mobile_type2_img_height',
        'de_mobile_type3_list_use',
        'de_mobile_type3_list_skin',
        'de_mobile_type3_list_mod',
        'de_mobile_type3_list_row',
        'de_mobile_type3_img_width',
        'de_mobile_type3_img_height',
        'de_mobile_type4_list_use',
        'de_mobile_type4_list_skin',
        'de_mobile_type4_list_mod',
        'de_mobile_type4_list_row',
        'de_mobile_type4_img_width',
        'de_mobile_type4_img_height',
        'de_mobile_type5_list_use',
        'de_mobile_type5_list_skin',
        'de_mobile_type5_list_mod',
        'de_mobile_type5_list_row',
        'de_mobile_type5_img_width',
        'de_mobile_type5_img_height',
        'de_rel_list_skin',
        'de_rel_img_width',
        'de_rel_img_height',
        'de_rel_list_mod',
        'de_rel_list_use',
        'de_mobile_rel_list_skin',
        'de_mobile_rel_img_width',
        'de_mobile_rel_img_height',
        'de_mobile_rel_list_mod',
        'de_mobile_rel_list_use',
        'de_search_list_skin',
        'de_search_img_width',
        'de_search_img_height',
        'de_search_list_mod',
        'de_search_list_row',
        'de_mobile_search_list_skin',
        'de_mobile_search_img_width',
        'de_mobile_search_img_height',
        'de_mobile_search_list_mod',
        'de_mobile_search_list_row',
        'de_listtype_list_skin',
        'de_listtype_img_width',
        'de_listtype_img_height',
        'de_listtype_list_mod',
        'de_listtype_list_row',
        'de_mobile_listtype_list_skin',
        'de_mobile_listtype_img_width',
        'de_mobile_listtype_img_height',
        'de_mobile_listtype_list_mod',
        'de_mobile_listtype_list_row',
        'de_simg_width',
        'de_simg_height',
        'de_mimg_width',
        'de_mimg_height',
        );
    
    foreach( $de_keys as $key ){

        if( !empty( $default[$key] ) ){
            $items['default'][$key] = $default[$key];
        }

    }

    $sql = "select * from `{$g5['g5_shop_banner_table']}` ";
    
    $result = sql_query($sql);

    for($i=0; $banner=sql_fetch_array($result); $i++) {
        
        foreach($banner as $k=>$v){
            $items['banners']['banner'.$i][$k] = $v;
        }
    }

    if( isset($items['banners']) ){
        $items['banners']['url_path'] = G5_DATA_URL.'/banner/';
    }

    $sql = "select * from `{$g5['g5_shop_category_table']}` ";
    
    $result = sql_query($sql);

    for($i=0; $cate=sql_fetch_array($result); $i++) {
        
        foreach($cate as $k=>$v){
            $items['categories']['cate'.$i][$k] = $v;
        }
    }

    $sql = " select * from `{$g5['g5_shop_item_table']}` ";

    $item_result = sql_query($sql);

    for($i=0; $item=sql_fetch_array($item_result); $i++) {
        $it_id = $item['it_id'];
        
        $items['items']['item'.$i]['@attributes'] = array('it_id' => $it_id);
        foreach($item as $k=>$v){

            if( preg_match('/^it_img/i', $k) ){
                $v = $v ? yc5_get_item_image_url($it_id).$v : '';
            }

            $items['items']['item'.$i][$k] = $v;
        }

        $sql = "select * from `{$g5['g5_shop_item_option_table']}` where it_id = ".$it_id." order by io_no asc ";
        $op_result = sql_query($sql);
        
        for($j=0; $option=sql_fetch_array($op_result); $j++) {
            
            // https://www.oxygenxml.com/dita/styleguide/webhelp-feedback/Artefact/Syntax_and_Markup/c_Non_Breaking_Spaces.html
            //반드시 chr30문자를 &#x2011로 replace 해야 한다. chr(30) 문자를 xml 문서에서 표시하면 오류가 나기 때문에
            $option['io_id'] = str_replace(chr(30), '&#x2011', $option['io_id']);

            $items['items']['item'.$i]['options']['option'.$j] = $option;
        }
    }

    $sql = " select * from `{$g5['g5_shop_item_use_table']}` ";

    $result = sql_query($sql);

    for($i=0; $use_comment=sql_fetch_array($result); $i++) {
        
        foreach($use_comment as $k=>$v){

            if($k === 'is_password'){
                continue;
            }

            $items['use_comment']['use'.$i][$k] = $v;
        }
    }

    $filename = 'youngcart_data_'.G5_TIME_YMD.'.xml';

    /* Print header */
    header( 'Content-Description: File Transfer' );
    header( 'Content-Disposition: attachment; filename=' . $filename );
    header( 'Content-Type: text/xml; charset=UTF-8', true );

    $xml = new Array2xml();
    $xml->setFilterNumbersInTags(array('item'));
    echo $xml->convert($items);

    exit;

}

$g5['title'] = '상품 xml 내보내기';
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<!-- 경고사항 -->
<div style="padding:10px 25px; line-height:20px; letter-spacing:0.5px;">
※ 영카트를 새로 설치하고 나면, 상품정보와 후기등의 등록된 자료가 없기에 테스트를 위해 상품을 업로드하고 싶을때 다운받는 xml 파일입니다.<br>
※ 다른 테스트계정이나 데모사이트에 현재 사이트의 상품관련 데이타를 한번에 올리고자 할때 다운받는 xml 파일입니다.<br>
※ 다운받으셔서 테스트/데모/신규구축을 위해 설치한 영카트에 등록하실 수 있습니다.<br><br>
</div>
<!--//-->

<!-- 경고사항 -->
<div style="padding:20px 25px; line-height:20px; background:#696969; color:#fafafa; letter-spacing:0.5px;">
<b>[ 사용방법 ]</b><br>
1) "상품내보내기" 를 클릭해서 현재 사이트의 상품/사용후기 등 데이터를 xml 파일로 다운받습니다.<br>
2) 테스트계정, 데모사이트, 사이트구축을 위한 백지상태의 영카트에 샘플을 올려서 테스트하고자 할때 사용합니다.<br>
3) 업로드할 사이트에서 "상품가져오기"에서 다운받은 xml 파일을 업로드합니다.<br>
※ <b class="yellow font-13">절대로 실제 운영하고 있는 쇼핑몰에는 업로드하지 마세요!!.</b> 실행시 운영중인 데이터가 잘못될 수 있습니다.<br>
※ 상품정보와 후기 등 여러 데이타를 가져오면서 DB가 꼬일 확률이 높아 운영중인 사이트가 엉망이 될 수도 있습니다.<br>
※ 본인 책임입니다. 제발 하지말라는건 하지마세요^^
</div>
<!--//-->

<div class="dan-garo1" style="border:solid 5px #9EE5E2; background:#fff; padding:25px 25px 25px;"><!-- 전체박스 열기 { -->

    <form id="export-item-form" method="post">
    <p>
        <label>이미지 출력수 설정, 상품, 사용후기, 이미지, 카테고리와 배너 데이터 를 xml 파일로 내보냅니다.</label>
        <input type="hidden" name="action" value="export_data">
    </p>
    
    <div class="h30"><!--공백//--></div>
    
    <div class="btn_confirm01 btn_confirm">
        <input type="submit" name="submit" class="btn_submit_big" value="상품 xml로 내보내기">
    </div>
    </form>

</div><!-- } 전체박스 닫기 -->

<script>

jQuery(function($){
});

</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>