<?php
$sub_menu = '400710'; /* 원본코드 500710 */
include_once('./_common.php');

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

include_once(G5_LIB_PATH.'/shop_xml.lib.php');

check_demo();

auth_check($auth[$sub_menu], "r");

$action_msg = '';

if( isset($_POST['action']) && 'import_data' === $_POST['action'] ){
    
    if(! function_exists('yc5_get_import_file')){
        function yc5_get_import_file($img_url, $store_path){
            $ch = curl_init($img_url);
            $fp = fopen($store_path, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
        }
    }

    $default_numbers = (isset($_POST['default_numbers']) && $_POST['default_numbers']) ? 1 : 0;
    $shop_category = (isset($_POST['shop_category']) && $_POST['shop_category']) ? 1 : 0;
    $shop_items = (isset($_POST['shop_items']) && $_POST['shop_items']) ? 1 : 0;
    $shop_use_comments = (isset($_POST['shop_use_comments']) && $_POST['shop_use_comments']) ? 1 : 0;
    $shop_banner = (isset($_POST['shop_banner']) && $_POST['shop_banner']) ? 1 : 0;

    $fail_it_id = array();
    $dup_it_id = array();
    $dup_count = 0;
    $fail_count = 0;

    $file_name = isset( $_FILES['import']['name'] )? $_FILES['import']['name'] : '';
    $file = isset( $_FILES['import']['tmp_name'] ) ? $_FILES['import']['tmp_name'] : '';

    if( ! ( $file_name && strtolower(end(explode('.', $file_name))) === 'xml' ) ){
        alert('xml 파일을 업로드 해 주세요.');
    }
    
    if ( ! extension_loaded( 'simplexml' ) ) {
        alert('simplexml not extension_loaded !');
    }

    $content = file_get_contents( $file );
    
    if ( ! $content ){
        alert(' 가져올 자료가 없습니다. ');
    }

    @mkdir(G5_DATA_PATH."/item", G5_DIR_PERMISSION);
    @chmod(G5_DATA_PATH."/item", G5_DIR_PERMISSION);

    // input vars 체크
    check_input_vars();

    $results = xmlstr_to_array($content);

    $action_msg = '성공적으로 데이터를 가져왔습니다.';

    if( $default_numbers && isset($results['default']) ){

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
        
        $data = array();

        $config_default = $results['default'];

        foreach( $de_keys as $key ){

            if( isset($config_default[$key]) && !empty( $config_default[$key] ) ){
                $data[$key] = addslashes($config_default[$key]);
            }

        }

        $sql = " update {$g5['g5_shop_default_table']} set ";
        
        $data_count = count($data) - 1;
        
        $i = 0;

        foreach($data as $key=>$v){
            $sql .= $key." = '".$v."'";

            if( $i !== $data_count ){
                $sql .= ", ";
            }
            $i++;
        }

        sql_query($sql, false);
    }

    if( $shop_banner && isset($results['banners']) ){

        $banner_url_path = $results['banners']['url_path'];
        
        foreach( (array) $results['banners'] as $banner ){
            
            $bn_id = isset( $banner['bn_id'] ) ? (int) $banner['bn_id'] : 0;
            
            if( empty($banner) || empty($bn_id) ) continue;

            $keys = array(
                'bn_alt',
                'bn_url',
                'bn_device',
                'bn_position',
                'bn_border',
                'bn_new_win',
                'bn_begin_time',
                'bn_end_time',
                'bn_time',
                'bn_hit',
                'bn_order',
                );

            $data = array();

            foreach( $keys as $key ){

                $data[$key] = !empty($banner[$key]) ? addslashes($banner[$key]) : '';
            }

            $sql = " select bn_id from `{$g5['g5_shop_banner_table']}` where bn_alt = '{$data['bn_alt']}' and bn_url = '{$data['bn_url']}' and bn_device  = '{$data['bn_device']}' and bn_new_win  = '{$data['bn_new_win']}' and bn_begin_time = '{$data['bn_begin_time']}' and bn_end_time = '{$data['bn_end_time']}' and bn_order = '{$data['bn_order']}' ";

            $exist = sql_fetch($sql);

            if( $exist['bn_id'] ){
                continue;
            }

            $sql = " insert into `{$g5['g5_shop_banner_table']}`
                        set bn_alt        = '{$data['bn_alt']}',
                            bn_url        = '{$data['bn_url']}',
                            bn_device     = '{$data['bn_device']}',
                            bn_position   = '{$data['bn_position']}',
                            bn_border     = '{$data['bn_border']}',
                            bn_new_win    = '{$data['bn_new_win']}',
                            bn_begin_time = '{$data['bn_begin_time']}',
                            bn_end_time   = '{$data['bn_end_time']}',
                            bn_time       = '{$data['bn_time']}',
                            bn_hit        = '{$data['bn_hit']}',
                            bn_order      = '{$data['bn_order']}' ";

            $query_result = sql_query($sql, false);

            $insert_bn_id = sql_insert_id();

            if( $query_result && $banner_url_path && $insert_bn_id ){
                
                $img_url = $banner_url_path.$bn_id;

                $banner_path = G5_DATA_PATH.'/banner/'.$insert_bn_id;

                if( ! file_exists($banner_path.'/'.$bn_id) ){
                    yc5_get_import_file($img_url, $banner_path);
                }
            }
        }

    }

    if( $shop_use_comments && isset($results['use_comment']) ){
        
        foreach( (array) $results['use_comment'] as $comment ){
            
            $is_id = isset( $comment['is_id'] ) ? (int) $comment['is_id'] : 0;
            
            if( empty($comment) || empty($is_id) ) continue;

            $keys = array(
                'it_id',
                'mb_id',
                'is_name',
                'is_score',
                'is_subject',
                'is_content',
                'is_time',
                'is_ip',
                'is_confirm',
                );

            $data = array();

            foreach( $keys as $key ){

                $data[$key] = !empty($comment[$key]) ? addslashes($comment[$key]) : '';
            }

            $sql = " select is_id from `{$g5['g5_shop_item_use_table']}` where it_id = '{$data['it_id']}' and mb_id = '{$data['mb_id']}' and is_name = '{$data['is_name']}' and is_score  = '{$data['is_score']}' and is_subject = '{$data['is_subject']}' and is_content = '{$data['is_content']}' and is_time = '{$data['is_time']}' ";

            $exist = sql_fetch($sql);

            if( $exist['is_id'] ){
                continue;
            }

            $sql = " insert into `{$g5['g5_shop_item_use_table']}`
                        set it_id        = '{$data['it_id']}',
                            mb_id        = '{$data['mb_id']}',
                            is_name     = '{$data['is_name']}',
                            is_score   = '{$data['is_score']}',
                            is_password = '',
                            is_subject     = '{$data['is_subject']}',
                            is_content    = '{$data['is_content']}',
                            is_time = '{$data['is_time']}',
                            is_ip   = '{$data['is_ip']}',
                            is_confirm       = '{$data['is_confirm']}'
                            ";

            $query_result = sql_query($sql, false);

            $insert_bn_id = sql_insert_id();
        }

    }

    if( $shop_category && isset($results['categories']) ){
        
        foreach( (array) $results['categories'] as $cate ){
            if( empty($cate) ) continue;
            
            $ca_id = $item['ca_id'];
            
            $sql = " select ca_name from {$g5['g5_shop_category_table']} where ca_id = '{$ca_id}' ";
            $row = sql_fetch($sql);

            if ($row['ca_name']) {
                continue;
            }

            $keys = array(
                'ca_id',
                'ca_name',
                'ca_order',
                'ca_skin',
                'ca_mobile_skin',
                'ca_img_width',
                'ca_img_height',
                'ca_mobile_img_width',
                'ca_mobile_img_height',
                'ca_sell_email',
                'ca_use',
                'ca_stock_qty',
                'ca_explan_html',
                'ca_head_html',
                'ca_tail_html',
                'ca_mobile_head_html',
                'ca_mobile_tail_html',
                'ca_list_mod',
                'ca_list_row',
                'ca_mobile_list_mod',
                'ca_mobile_list_row',
                'ca_include_head',
                'ca_include_tail',
                'ca_mb_id',
                'ca_cert_use',
                'ca_adult_use',
                'ca_nocoupon',
                'ca_1_subj',
                'ca_2_subj',
                'ca_3_subj',
                'ca_4_subj',
                'ca_5_subj',
                'ca_6_subj',
                'ca_7_subj',
                'ca_8_subj',
                'ca_9_subj',
                'ca_10_subj',
                'ca_1',
                'ca_2',
                'ca_3',
                'ca_4',
                'ca_5',
                'ca_6',
                'ca_7',
                'ca_8',
                'ca_9',
                'ca_10',
                'ca_skin_dir',
                'ca_mobile_skin_dir',
                );

            $data = array();

            foreach( $keys as $key ){

                $data[$key] = !empty($cate[$key]) ? addslashes($cate[$key]) : '';
            }

            // 소문자로 변환
            $data['ca_id'] = strtolower($data['ca_id']);

            $sql = " insert {$g5['g5_shop_category_table']}
                        set ca_id   = '{$data['ca_id']}',
                            ca_name = '{$data['ca_name']}',
                            ca_order                = '{$data['ca_order']}',
                            ca_skin_dir             = '{$data['ca_skin_dir']}',
                            ca_mobile_skin_dir      = '{$data['ca_mobile_skin_dir']}',
                            ca_skin                 = '{$data['ca_skin']}',
                            ca_mobile_skin          = '{$data['ca_mobile_skin']}',
                            ca_img_width            = '{$data['ca_img_width']}',
                            ca_img_height           = '{$data['ca_img_height']}',
                            ca_list_mod             = '{$data['ca_list_mod']}',
                            ca_list_row             = '{$data['ca_list_row']}',
                            ca_mobile_img_width     = '{$data['ca_mobile_img_width']}',
                            ca_mobile_img_height    = '{$data['ca_mobile_img_height']}',
                            ca_mobile_list_mod      = '{$data['ca_mobile_list_mod']}',
                            ca_mobile_list_row      = '{$data['ca_mobile_list_row']}',
                            ca_sell_email           = '{$data['ca_sell_email']}',
                            ca_use                  = '{$data['ca_use']}',
                            ca_stock_qty            = '{$data['ca_stock_qty']}',
                            ca_explan_html          = '{$data['ca_explan_html']}',
                            ca_head_html            = '{$data['ca_head_html']}',
                            ca_tail_html            = '{$data['ca_tail_html']}',
                            ca_mobile_head_html     = '{$data['ca_mobile_head_html']}',
                            ca_mobile_tail_html     = '{$data['ca_mobile_tail_html']}',
                            ca_include_head         = '{$data['ca_include_head']}',
                            ca_include_tail         = '{$data['ca_include_tail']}',
                            ca_mb_id                = '{$data['ca_mb_id']}',
                            ca_cert_use             = '{$data['ca_cert_use']}',
                            ca_adult_use            = '{$data['ca_adult_use']}',
                            ca_nocoupon             = '{$data['ca_nocoupon']}',
                            ca_1_subj               = '{$data['ca_1_subj']}',
                            ca_2_subj               = '{$data['ca_2_subj']}',
                            ca_3_subj               = '{$data['ca_3_subj']}',
                            ca_4_subj               = '{$data['ca_4_subj']}',
                            ca_5_subj               = '{$data['ca_5_subj']}',
                            ca_6_subj               = '{$data['ca_6_subj']}',
                            ca_7_subj               = '{$data['ca_7_subj']}',
                            ca_8_subj               = '{$data['ca_8_subj']}',
                            ca_9_subj               = '{$data['ca_9_subj']}',
                            ca_10_subj              = '{$data['ca_10_subj']}',
                            ca_1                    = '{$data['ca_1']}',
                            ca_2                    = '{$data['ca_2']}',
                            ca_3                    = '{$data['ca_3']}',
                            ca_4                    = '{$data['ca_4']}',
                            ca_5                    = '{$data['ca_5']}',
                            ca_6                    = '{$data['ca_6']}',
                            ca_7                    = '{$data['ca_7']}',
                            ca_8                    = '{$data['ca_8']}',
                            ca_9                    = '{$data['ca_9']}',
                            ca_10                   = '{$data['ca_10']}'
                            ";
            
            sql_query($sql, false);

        }
    }

    if( $shop_items && isset($results['items']['item']) ){

        foreach( (array) $results['items']['item'] as $item ){
            
            if( empty($item) ) continue;

            $it_id = $item['it_id'];

            // it_id 중복체크
            $sql2 = " select count(*) as cnt from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
            $row2 = sql_fetch($sql2);
            if($row2['cnt']) {
                $fail_it_id[] = $it_id;
                $dup_it_id[] = $it_id;
                $dup_count++;
                $fail_count++;
                continue;
            }

            $keys = array(
                'it_id',
                'ca_id',
                'ca_id2',
                'ca_id3',
                'it_skin',
                'it_mobile_skin',
                'it_name',
                'it_mobile_name',
                'it_maker',
                'it_origin',
                'it_brand',
                'it_model',
                'it_option_subject',
                'it_supply_subject',
                'it_type1',
                'it_type2',
                'it_type3',
                'it_type4',
                'it_type5',
                'it_basic',
                'it_explan',
                'it_explan2',
                'it_mobile_explan',
                'it_cust_price',
                'it_price',
                'it_point',
                'it_point_type',
                'it_supply_point',
                'it_notax',
                'it_sell_email',
                'it_use',
                'it_nocoupon',
                'it_soldout',
                'it_stock_qty',
                'it_stock_sms',
                'it_noti_qty',
                'it_sc_type',
                'it_sc_method',
                'it_sc_price',
                'it_sc_minimum',
                'it_sc_qty',
                'it_buy_min_qty',
                'it_buy_max_qty',
                'it_head_html',
                'it_tail_html',
                'it_mobile_head_html',
                'it_mobile_tail_html',
                'it_hit',
                'it_time',
                'it_update_time',
                'it_ip',
                'it_order',
                'it_tel_inq',
                'it_info_gubun',
                'it_info_value',
                'it_sum_qty',
                'it_use_cnt',
                'it_use_avg',
                'it_shop_memo',
                'ec_mall_pid',
                'it_img1',
                'it_img2',
                'it_img3',
                'it_img4',
                'it_img5',
                'it_img6',
                'it_img7',
                'it_img8',
                'it_img9',
                'it_img10',
                'it_1_subj',
                'it_2_subj',
                'it_3_subj',
                'it_4_subj',
                'it_5_subj',
                'it_6_subj',
                'it_7_subj',
                'it_8_subj',
                'it_9_subj',
                'it_10_subj',
                'it_1',
                'it_2',
                'it_3',
                'it_4',
                'it_5',
                'it_6',
                'it_7',
                'it_8',
                'it_9',
                'it_10',
                );

            $data = array();

            foreach( $keys as $key ){
                
                //이미지 경로는 다르게 저장해야한다.
                if( preg_match('/^it_img/i', $key) ){
                    $data[$key] = !empty($item[$key]) ? $it_id.'/'.basename($item[$key]) : '';
                } else {
                    $data[$key] = !empty($item[$key]) ? addslashes($item[$key]) : '';
                }
            }

            $sql = " INSERT INTO {$g5['g5_shop_item_table']}
                         SET it_id = '{$data['it_id']}',
                             ca_id = '{$data['ca_id']}',
                             ca_id2 = '{$data['ca_id2']}',
                             ca_id3 = '{$data['ca_id3']}',
                             it_name = '{$data['it_name']}',
                             it_maker = '{$data['it_maker']}',
                             it_origin = '{$data['it_origin']}',
                             it_brand = '{$data['it_brand']}',
                             it_model = '{$data['it_model']}',
                             it_type1 = '{$data['it_type1']}',
                             it_type2 = '{$data['it_type2']}',
                             it_type3 = '{$data['it_type3']}',
                             it_type4 = '{$data['it_type4']}',
                             it_type5 = '{$data['it_type5']}',
                             it_basic = '{$data['it_basic']}',
                             it_explan = '{$data['it_explan']}',
                             it_explan2 = '{$data['it_explan2']}',
                             it_mobile_explan = '{$data['it_mobile_explan']}',
                             it_cust_price = '{$data['it_cust_price']}',
                             it_option_subject = '{$data['it_option_subject']}',
                             it_supply_subject = '{$data['it_supply_subject']}',
                             it_price = '{$data['it_price']}',
                             it_point = '{$data['it_point']}',
                             it_point_type = '{$data['it_point_type']}',
                             it_stock_qty = '{$data['it_stock_qty']}',
                             it_noti_qty = '{$data['it_noti_qty']}',
                             it_buy_min_qty = '{$data['it_buy_min_qty']}',
                             it_buy_max_qty = '{$data['it_buy_max_qty']}',
                             it_notax = '{$data['it_notax']}',
                             it_use = '{$data['it_use']}',
                             it_time = '".G5_TIME_YMDHIS."',
                             it_ip = '{$_SERVER['REMOTE_ADDR']}',
                             it_order = '{$data['it_order']}',
                             it_tel_inq = '{$data['it_tel_inq']}',
                             it_img1 = '{$data['it_img1']}',
                             it_img2 = '{$data['it_img2']}',
                             it_img3 = '{$data['it_img3']}',
                             it_img4 = '{$data['it_img4']}',
                             it_img5 = '{$data['it_img5']}',
                             it_img6 = '{$data['it_img6']}',
                             it_img7 = '{$data['it_img7']}',
                             it_img8 = '{$data['it_img8']}',
                             it_img9 = '{$data['it_img9']}',
                             it_img10 = '{$data['it_img10']}',
                            it_1_subj = '{$data['it_1_subj']}',
                            it_2_subj = '{$data['it_2_subj']}',
                            it_3_subj = '{$data['it_3_subj']}',
                            it_4_subj = '{$data['it_4_subj']}',
                            it_5_subj = '{$data['it_5_subj']}',
                            it_6_subj = '{$data['it_6_subj']}',
                            it_7_subj = '{$data['it_7_subj']}',
                            it_8_subj = '{$data['it_8_subj']}',
                            it_9_subj = '{$data['it_9_subj']}',
                            it_10_subj = '{$data['it_10_subj']}',
                            it_1        =   '{$data['it_1']}',
                            it_2        =   '{$data['it_2']}',
                            it_3        =   '{$data['it_3']}',
                            it_4        =   '{$data['it_4']}',
                            it_5        =   '{$data['it_5']}',
                            it_6        =   '{$data['it_6']}',
                            it_7        =   '{$data['it_7']}',
                            it_8        =   '{$data['it_8']}',
                            it_9        =   '{$data['it_9']}',
                            it_10       =   '{$data['it_10']}'
                             ";
            $query_result = sql_query($sql, false);

            if($query_result){
                $dir = G5_DATA_PATH."/item/".$item['it_id'];

                if(!is_dir($dir)) {
                    @mkdir($dir, G5_DIR_PERMISSION);
                    @chmod($dir, G5_DIR_PERMISSION);
                }
                
                for( $c=1; $c <= 10; $c++){
                    if( !empty( $item['it_img'.$c] ) ){
                        $img_url = (string)$item['it_img'.$c];
                        $file_name = basename($img_url);
                        
                        if( file_exists($dir.'/'.$file_name) ){
                            continue;
                        }

                        if( preg_match('/(gif|jpe?g|png)$/i', strtolower(end(explode('.', $file_name))) ) ){
                            
                            yc5_get_import_file($img_url, $dir.'/'.$file_name);

                        }

                    }
                }

                if( !empty($item['options']) ){
                    foreach( (array) $item['options'] as $option ){
                        
                        $option['io_id'] = str_replace('&#x2011', chr(30), $option['io_id']);

                        $sql = "insert into {$g5['g5_shop_item_option_table']} SET
                                io_id = '".addslashes($option['io_id'])."', 
                                io_type = ".(int) $option['io_type'].", 
                                it_id = '".addslashes($option['it_id'])."',
                                io_price = ".(int) $option['io_price'].",
                                io_stock_qty = ".(int) $option['io_stock_qty'].",
                                io_noti_qty = ".(int) $option['io_noti_qty'].",
                                io_use = ".(int) $option['io_use']."
                        ";
                        
                        sql_query($sql, false);
                    }
                }
            }
        }
    }

    if( $shop_use_comments ){

    }

    //print_r( $results );

}

$g5['title'] = '상품 가져오기';
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<div style="margin-bottom:0;">

    <?php if( $action_msg ){ ?>
        <h2><?php echo $action_msg; ?></h2>
    <?php } else { ?>
        <h2 style="background:red; color:#FFF;padding:1em; padding:40px 30px;margin-bottom:0;"><?php echo '<span class="font-20">실제 운영중인 쇼핑몰이면, 절대로 상품 가져오기를 실행하지 마세요.</span><br><span class="lightyellow">실행시 운영중인 데이터가 잘못될 수 있습니다. 본인 책임입니다. 제발 하지말라는건 하지마세요^^<br>상품정보와 후기 등 여러 데이타를 가져오면서 DB가 꼬일 확률이 높아 운영중인 사이트가 엉망이 될 수도 있습니다.</span><br>새로 사이트를 구축하기위해 영카트 설치후, 백지상태에서 샘플데이타를 등록하기 위한 용도일때만 사용하세요!!'; ?></h2>
    <?php } ?>
</div>

    
<div class="dan-garo1" style="border:solid 5px #9EE5E2; background:#fff; padding:25px 25px 25px;"><!-- 전체박스 열기 { -->
 
    <!-- @@ (1) 상품xml가져오기 @@ -->
    <div class="excel_down">
    <h5><i class="fas fa-save font-22"></i> 상품XML가져오기 <b class="red font-13">실제로 운영중인 쇼핑몰이라면,절대로 상품가져오기를 하지 마세요!!. 모든 DB가 엉망이 될 수 있습니다!!</b></h5>
    
    <form id="export-item-form" method="post" enctype="multipart/form-data" onsubmit="return export_submit(this);">
        <input type="hidden" name="action" value="import_data">
        <p>
        <label class="all_import_chk">이미지 출력수 설정, 쇼핑몰 카테고리, 쇼핑몰상품, 사용후기, 배너 데이터를 xml 파일로 가져옵니다.</label>
        <p>
    
    <div style="padding:15px 20px 15px; border:0; font-size:1.2em; line-height:200%;">
        <ul style="list-style:none">
            <li><input type="checkbox" name="default_numbers" id="default_numbers" > <label for="default_numbers">이미지 출력수 설정</label></li>
            <li><input type="checkbox" name="shop_category" id="shop_category" > <label for="shop_category">쇼핑몰 카테고리</label></li>
            <li><input type="checkbox" name="shop_items" id="shop_items" > <label for="shop_items">쇼핑몰 상품</label></li>
            <li><input type="checkbox" name="shop_use_comments" id="shop_use_comments" > <label for="shop_use_comments">사용후기</label></li>
            <li><input type="checkbox" name="shop_banner" id="shop_banner" > <label for="shop_banner">배너 데이터</label></li>
        </ul>
    </div>
    
    <div id="excelfile_upload">
        <label for="excelfile">파일선택(xml파일만 등록 가능합니다)</label>&nbsp;&nbsp;
        <input type="file" name="import" id="import_file">
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" name="submit" class="btn_submit_big" value="상품 xml로 가져오기">
    </div>
    </form>
    
    <div style="margin-top:35px;color:#4c4c4c; font-size:1.2em; line-height:180%; border:solid 1px #d3d3d3; background:#FFF5D7; padding:15px;">
        <b class="violet">상품 xml 가져오기를 사용할 수 있는 경우</b><br>
        ※ 사이트 구축을 위해서 영카트를 최초로 설치한 경우, 테스트를 위한 상품이 없을때 샘플로 등록하고자 하는 경우<br>
        ※ 실제로는 운영하지 않는 테스트 계정으로 DB를 초기화해도 상관없을 경우<br>
        ※ 백지상태 또는 테스트계정이라고 해도 DB는 전체 백업을 받아놓은 후 가져오기를 실행하세요.<br>
    </div>
    
    </div>
    <!-- @@ (2) // @@ -->
    
    
</div><!-- } 전체박스 닫기 -->    
    

<script>

function export_submit(f){

    var import_file = document.getElementById("import_file").value;
    var $checkds = jQuery("#export-item-form").find("input[type='checkbox']:checked");

    if( ! import_file ){
        alert("업로드할 xml 파일을 첨부해 주세요.");
        return false;
    }

	if (!$checkds.length) {
        alert("가져올 내용의 체크박스를 선택해 주세요.");
        return false;
    }

    return true;
}

jQuery(function($){
    $(".all_import_chk").on("click", function(e){

        var checked = false;

        if (!$(this).data('toggle_enable')) {
            $(this).data('toggle_enable', true);

            checked = true;
        } else {
            $(this).data('toggle_enable', false);
        }

        $("#export-item-form input:checkbox").prop('checked', checked);

    });
});

</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
