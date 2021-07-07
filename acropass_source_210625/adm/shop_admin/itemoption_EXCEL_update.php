<?php
$sub_menu = '400336'; /* 새로만듦 - 상품옵션엑셀등록 */
include_once('./_common.php');

// 상품이 많을 경우 대비 설정변경
set_time_limit ( 0 );
ini_set('memory_limit', '50M');

auth_check($auth[$sub_menu], "w");

function only_number($n)
{
    return preg_replace('/[^0-9]/', '', $n);
}

if($_FILES['excelfile']['tmp_name']) {
    $file = $_FILES['excelfile']['tmp_name'];

    include_once(G5_LIB_PATH.'/Excel/reader.php');

    $data = new Spreadsheet_Excel_Reader();

    // Set output Encoding.
    $data->setOutputEncoding('UTF-8');

    /***
    * if you want you can change 'iconv' to mb_convert_encoding:
    * $data->setUTFEncoder('mb');
    *
    **/

    /***
    * By default rows & cols indeces start with 1
    * For change initial index use:
    * $data->setRowColOffset(0);
    *
    **/



    /***
    *  Some function for formatting output.
    * $data->setDefaultFormat('%.2f');
    * setDefaultFormat - set format for columns with unknown formatting
    *
    * $data->setColumnFormat(4, '%.3f');
    * setColumnFormat - set format for column (apply only to number fields)
    *
    **/

    $data->read($file);

    /*


     $data->sheets[0]['numRows'] - count rows
     $data->sheets[0]['numCols'] - count columns
     $data->sheets[0]['cells'][$i][$j] - data from $i-row $j-column

     $data->sheets[0]['cellsInfo'][$i][$j] - extended info about cell

        $data->sheets[0]['cellsInfo'][$i][$j]['type'] = "date" | "number" | "unknown"
            if 'type' == "unknown" - use 'raw' value, because  cell contain value with format '0.00';
        $data->sheets[0]['cellsInfo'][$i][$j]['raw'] = value if cell without format
        $data->sheets[0]['cellsInfo'][$i][$j]['colspan']
        $data->sheets[0]['cellsInfo'][$i][$j]['rowspan']
    */

    error_reporting(E_ALL ^ E_NOTICE);

    $fail_it_id = array();
    $updaete_it_id = array();
    $total_count = 0;
    $fail_count = 0;
    $succ_count = 0;

	$opt_arr = array();

	$io_id_chr = '';
    for ($i = 3; $i <= $data->sheets[0]['numRows']; $i++) {
        $total_count++;

        $j = 1;

        $it_id              = addslashes($data->sheets[0]['cells'][$i][$j++]);
        $it_opt_subject              = addslashes($data->sheets[0]['cells'][$i][$j++]);								// 옵션명
        $io_id             = addslashes($data->sheets[0]['cells'][$i][$j++]);													// 옵션항목
        $io_price      = addslashes(only_number($data->sheets[0]['cells'][$i][$j++]));						// 옵션가격
        $io_stock_qty           = addslashes(only_number($data->sheets[0]['cells'][$i][$j++]));			 // 재고수량
        $io_noti_qty      = addslashes(only_number($data->sheets[0]['cells'][$i][$j++]));					// 통보수량
        $io_use       = addslashes(only_number($data->sheets[0]['cells'][$i][$j++]));						// 사용여부
        $io_type             = addslashes(only_number($data->sheets[0]['cells'][$i][$j++]));					// 옵션형식

		// 상품코드 체크
	    $ori_data = sql_fetch(" select it_option_subject, it_supply_subject, count(*) as cnt from {$g5['g5_shop_item_table']} where it_id = '$it_id' ");

		if(!$ori_data['cnt'] || !$it_id || !$it_opt_subject || !$io_id || ($io_type != 0 && $io_type != 1)) { 
            $fail_it_id[] = $it_id;
			$fail_count++;
            continue;
        }

		// 상품 테이블  it_option_subject 업데이트
		if($io_type == 0 && $ori_data['it_option_subject'] != $it_opt_subject) {
			sql_query("UPDATE {$g5['g5_shop_item_table']} SET it_option_subject = '$it_opt_subject' where it_id = '$it_id'");
		}
	
		// 상품 테이블   	it_supply_subject 업데이트
		if($io_type == 1 && $ori_data['it_supply_subject'] != $it_opt_subject) {
			sql_query("UPDATE {$g5['g5_shop_item_table']} SET it_supply_subject = '$it_opt_subject' where it_id = '$it_id'");
		}

		// io_id
		$opt = array();
	    $opt_arr = explode(',', $io_id);
	     for($k=0; $k<count($opt_arr); $k++) {
            $opt[] = $opt_arr[$k];
		 }
          $io_id_chr = implode(chr(30), $opt); 

        // it_id, io_id, io_type 중복 - 업데이트
        $sql2 = " select io_no, count(*) as cnt from {$g5['g5_shop_item_option_table']} where it_id = '$it_id' and io_id = '$io_id_chr' and io_type = '$io_type'";
        $row2 = sql_fetch($sql2);
        if($row2['cnt']) {
            $updaete_it_id[] = $it_id;
            $update_count++;
	        $sql = " UPDATE {$g5['g5_shop_item_option_table']}
                     SET io_id = '$io_id_chr',
                         io_type = '$io_type',
                         it_id = '$it_id',
                         io_price = '$io_price',
                         io_stock_qty = '$io_stock_qty',
                         io_noti_qty = '$io_noti_qty',
                         io_use = '$io_use'
						 where io_no = '$row2[io_no]'
					";
			  sql_query($sql);
		}  else { 	// 옵션 테이블 insert
			$sql = " INSERT INTO {$g5['g5_shop_item_option_table']}
                     SET io_id = '$io_id_chr',
                         io_type = '$io_type',
                         it_id = '$it_id',
                         io_price = '$io_price',
                         io_stock_qty = '$io_stock_qty',
                         io_noti_qty = '$io_noti_qty',
                         io_use = '$io_use'
					";
	        sql_query($sql);

		    $succ_count++;
		}
	}
}

$g5['title'] = '상품옵션 엑셀일괄등록 결과';
include_once(G5_ADMIN_PATH.'/admin.head.sub.php');
?>

<div class="new_win">
    <h1><?php echo $g5['title']; ?></h1>

    <div class="local_desc01 local_desc">
        <p>상품옵션 등록을 완료했습니다.</p>
    </div>

    <dl id="excelfile_result">
        <dt>총 옵션수</dt>
        <dd><?php echo number_format($total_count); ?></dd>
        <dt>완료건수</dt>
        <dd><?php echo number_format($succ_count); ?></dd>
        <dt>업데이트건수</dt>
        <dd><?php echo number_format($update_count); ?></dd>
        <?php if($update_count > 0) { ?>
        <dt>업데이트상품코드</dt>
        <dd><?php echo implode(', ', array_unique($updaete_it_id)); ?></dd>
        <?php } ?>
        <dt>실패건수</dt>
        <dd><?php echo number_format($fail_count); ?></dd>
        <?php if($fail_count > 0) { ?>
        <dt>실패상품코드</dt>
        <dd><?php echo implode(', ', array_unique($fail_it_id)); ?></dd>
        <?php } ?>
    </dl>

    <div class="btn_win01 btn_win">
        <button type="button" onclick="window.close();">창닫기</button>
    </div>

</div>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.sub.php');
?>