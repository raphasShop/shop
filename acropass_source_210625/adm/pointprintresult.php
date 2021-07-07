<?php
$sub_menu = '411120'; /* 수정전 원본 메뉴코드 500120 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

//print_r2($_GET); exit;

/*
function multibyte_digit($source)
{
    $search  = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
    $replace = array("０","１","２","３","４","５","６","７","８","９");
    return str_replace($search, $replace, (string)$source);
}
*/



// 1.04.01
// MS엑셀 CSV 데이터로 다운로드 받음
if ($csv == 'csv')
{
    $fr_date = date_conv($fr_date);
    $to_date = date_conv($to_date);


    $sql = " SELECT *
               FROM {$g5['point_table']}
              where (1) ";
    if ($case == 1) // 출력기간
        $sql .= " and po_datetime between '$fr_date 00:00:00' and '$to_date 23:59:59' ";
   
    $sql .="  order by po_datetime asc";
    $result = sql_query($sql);
    $cnt = @sql_num_rows($result);
    if (!$cnt)
        alert("출력할 내역이 없습니다.");

    //header('Content-Type: text/x-csv');
    header("Content-charset=utf-8");
    header('Content-Type: doesn/matter');
    header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Content-Disposition: attachment; filename="pointlist-' . date("ymd", time()) . '.csv"');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    echo iconv('utf-8', 'euc-kr', "회원아이디,포인트내용,포인트,일시,만료일,포인트합\n");


    
    $save_it_id = '';
    //$b_od_id = '';
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        $row = array_map('iconv_euckr', $row);

        

        echo '"'.$row['mb_id'].'"'.',';//회원아이디
        echo '"'.$row['po_content'].'"'.',';//포인트내용
        echo '"'.$row['po_point'].'"'.',';//포인트
        echo '"'.$row['po_datetime'].'"'.',';//일시
        echo '"'.$row['po_expire_date'].'"'.',';//만료일
        echo '"'.$row['po_mb_point'].'"'.',';//포인트합
        echo "\n";

    }
    if ($i == 0)
        echo '자료가 없습니다.'.PHP_EOL;

    exit;
}

// MS엑셀 XLS 데이터로 다운로드 받음
if ($csv == 'xls')
{
    $fr_date = date_conv($fr_date);
    $to_date = date_conv($to_date);


    $sql = " SELECT *
               FROM {$g5['point_table']}
              where (1) ";
    if ($case == 1) // 출력기간
        $sql .= " and po_datetime between '$fr_date 00:00:00' and '$to_date 23:59:59' ";
    
    $sql .="  order by po_datetime asc ";
    $result = sql_query($sql);
    $cnt = @sql_num_rows($result);
    if (!$cnt)
        alert("출력할 내역이 없습니다.");

    /*================================================================================
    php_writeexcel http://www.bettina-attack.de/jonny/view.php/projects/php_writeexcel/
    =================================================================================*/

    include_once(G5_LIB_PATH.'/Excel/php_writeexcel/class.writeexcel_workbook.inc.php');
    include_once(G5_LIB_PATH.'/Excel/php_writeexcel/class.writeexcel_worksheet.inc.php');

    $fname = tempnam(G5_DATA_PATH, "tmp-orderlist.xls");
    $workbook = new writeexcel_workbook($fname);
    $worksheet = $workbook->addworksheet();

    // Put Excel data
    //$data = array('송장번호', '받는사람', '휴대폰', '일반전화', '우편번호', '주소', '전하는말씀', '상품번호', '상품명', '선택옵션', '수량', '주문번호', '배송비');
    //$data = array('수취인명','우편번호','주소','전화번호','이동통신','상풍명','수량','배송메시지','상품코드');
    $data = array('회원아이디','포인트내용','포인트','일시','만료일','포인트합');
    
    $data = array_map('iconv_euckr', $data);

    $col = 0;
    foreach($data as $cell) {
        $worksheet->write(0, $col++, $cell);
    }

    for($i=1; $row=sql_fetch_array($result); $i++)
    {
       
        
        $row = array_map('iconv_euckr', $row);

        $worksheet->write($i, 0, $row['mb_id']);// 회원아이디
        $worksheet->write($i, 1, $row['po_content']);//포인트내용
        $worksheet->write($i, 2, $row['po_point']);//포인트
        $worksheet->write($i, 3, $row['po_datetime']);//일시
        $worksheet->write($i, 4, $row['po_expire_date']);//만료일
        $worksheet->write($i, 5, $row['po_mb_point']);//포인트합
        
    }

    $workbook->close();

    header("Content-Type: application/x-msexcel; name=\"pointlist-".date("ymd", time()).".xls\"");
    header("Content-Disposition: inline; filename=\"pointlist-".date("ymd", time()).".xls\"");
    $fh=fopen($fname, "rb");
    fpassthru($fh);
    unlink($fname);

    exit;
}


$g5['title'] = "포인트리스트";
include_once(G5_ADMIN_PATH.'/admin.head.sub.php');

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.5.1/jQuery.print.min.js"></script>


</body>
</html>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.sub.php');
?>