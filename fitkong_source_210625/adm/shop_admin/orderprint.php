<?php
$sub_menu = '411120'; /* 수정전 원본 메뉴코드 500120 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '주문서 일괄 출력';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
?>

<section><!-- 배송용 주문내역출력 섹션 열기 { -->
<h5><i class="fa fa-download"></i> 택배발송용 주문내역 출력</h5>
<div class="local_sch02 local_sch" style="border:solid 5px #9EE5E2; background:#fff; padding:25px 25px 25px;"><!-- 추가 주문내역출력 선택창 열기 { -->

    <div>
        <form name="forderprint" action="./orderprintresult2.php" onsubmit="return forderprintcheck(this);" autocomplete="off">
        <input type="hidden" name="case" value="3">

        <strong class="sch_long">기간별 출력</strong>
        <input type="radio" name="csv" value="xls" id="xls3">
        <label for="xls3">MS엑셀 XLS 파일</label>
        <input type="radio" name="csv" value="csv" id="csv3">
        <label for="csv3">MS엑셀 CSV 파일</label>
        <input type="radio" name="csv" value="" id="print3">
        <label for="print3"><i class="fa fa-print fa-lg"></i> 주문서 요약인쇄</label>
        <label for="ct_status_pp" class="sound_only">출력대상</label>
        <select name="ct_status" id="ct_status_pp">
            <option value="주문">주문</option>
            <option value="입금">입금</option>
            <option value="준비">준비</option>
            <option value="배송">배송</option>
            <option value="완료">완료</option>
            <option value="취소">취소</option>
            <option value="반품">반품</option>
            <option value="품절">품절</option>
            <option value="">전체</option>
        </select>
        <label for="fr_date2" class="sound_only">기간 시작일</label>
        <input type="text" name="fr_date2" value="<?php echo date("Ymd"); ?>" id="fr_date2" required class="required frm_input" size="8" maxlength="8">
        ~
        <label for="to_date2" class="sound_only">기간 종료일</label>
        <input type="text" name="to_date2" value="<?php echo date("Ymd"); ?>" id="to_dat2" required class="required frm_input" size="8" maxlength="8">
        <input type="submit" value="출력 (새창)" class="btn_submit">

        </form>
    </div>

    <div class="sch_last">

        <form name="forderprint" action="./orderprintresult2.php" onsubmit="return forderprintcheck(this);" autocomplete="off" >
        <input type="hidden" name="case" value="4">
        <strong class="sch_long">주문번호구간별 출력</strong>

        <input type="radio" name="csv" value="xls" id="xls4">
        <label for="xls4">MS엑셀 XLS 파일</label>
        <input type="radio" name="csv" value="csv" id="csv4">
        <label for="csv4">MS엑셀 CSV 파일</label>
        <input type="radio" name="csv" value="" id="print4">
        <label for="print4"><i class="fa fa-print fa-lg"></i> 주문서 요약인쇄</label>
        <label for="ct_status_nn" class="sound_only">출력대상</label>
        <select name="ct_status" id="ct_status_nn">
            <option value="주문">주문</option>
            <option value="입금">입금</option>
            <option value="준비">준비</option>
            <option value="배송">배송</option>
            <option value="완료">완료</option>
            <option value="취소">취소</option>
            <option value="반품">반품</option>
            <option value="품절">품절</option>
            <option value="">전체</option>
        </select>
        <label for="fr_od_id2" class="sound_only">주문번호 구간 시작</label>
        <input type="text" name="fr_od_id2" id="fr_od_id2" required class="required frm_input" size="15" maxlength="20" onKeyup="this.value=this.value.replace(/[^0-9]/g,'')">
        ~
        <label for="fr_od_id2" class="sound_only">주문번호 구간 종료</label>
        <input type="text" name="to_od_id2" id="to_od_id2" required class="required frm_input" size="15" maxlength="20" onKeyup="this.value=this.value.replace(/[^0-9]/g,'')">
        <input type="submit" value="출력 (새창)" class="btn_submit">

        </form>
    </div>
    
    <div style="padding:15px 0px 0px; border:0px; line-height:18px;">
    ※ 기본 주문엑셀과 달리 택배용 자료 이용을 위해서 <span class="pink">택배회사 정보 등</span> 배송용기준으로 작성됩니다.
    </div>

</div><!-- } 택배발송용 주문내역출력 선택창 닫기 //-->
</section><!-- } 택배발송용 주문내역출력 섹션 닫기 //-->


<section><!-- 주문 성세내역출력 섹션 열기 { -->
<h5><i class="fa fa-download"></i> 주문 상세내역 출력</h5>
<div class="local_sch02 local_sch" style="border:solid 5px #aaa; background:#fff; padding:25px 25px 25px;"><!-- 주문 상세내역 출력 선택창 열기 { -->

    <div>
        <form name="forderprint" action="./orderprintresult3.php" onsubmit="return forderprintcheck(this);" autocomplete="off">
        <input type="hidden" name="case" value="5">

        <strong class="sch_long">기간별 출력</strong>
        <input type="radio" name="csv" value="xls" id="xls5">
        <label for="xls5">MS엑셀 XLS 파일</label>
        <input type="radio" name="csv" value="csv" id="csv5">
        <label for="csv1">MS엑셀 CSV 파일</label>
        <label for="ct_status_p" class="sound_only">출력대상</label>
        <select name="ct_status" id="ct_status_p">
            <option value="주문">주문</option>
            <option value="입금">입금</option>
            <option value="준비">준비</option>
            <option value="배송">배송</option>
            <option value="완료">완료</option>
            <option value="취소">취소</option>
            <option value="반품">반품</option>
            <option value="품절">품절</option>
            <option value="">전체</option>
        </select>
        <label for="fr_date3" class="sound_only">기간 시작일</label>
        <input type="text" name="fr_date3" value="<?php echo date("Ymd"); ?>" id="fr_date3" required class="required frm_input" size="8" maxlength="8">
        ~
        <label for="to_date3" class="sound_only">기간 종료일</label>
        <input type="text" name="to_date3" value="<?php echo date("Ymd"); ?>" id="to_date3" required class="required frm_input" size="8" maxlength="8">
        <input type="submit" value="출력 (새창)" class="btn_submit">

        </form>
    </div>

   

</div><!-- } 주문상세내역출력 선택창 닫기 //-->
</section><!-- } 주문상세내역출력 섹션 닫기 //-->


<section><!-- 기본 주문내역출력 섹션 열기 { -->
<h5><i class="fa fa-download"></i> 기본 주문내역 출력</h5>
<div class="local_sch02 local_sch" style="border:solid 5px #aaa; background:#fff; padding:25px 25px 25px;"><!-- 기본 주문내역출력 선택창 열기 { -->

    <div>
        <form name="forderprint" action="./orderprintresult.php" onsubmit="return forderprintcheck(this);" autocomplete="off">
        <input type="hidden" name="case" value="1">

        <strong class="sch_long">기간별 출력</strong>
        <input type="radio" name="csv" value="xls" id="xls1">
        <label for="xls1">MS엑셀 XLS 파일</label>
        <input type="radio" name="csv" value="csv" id="csv1">
        <label for="csv1">MS엑셀 CSV 파일</label>
        <input type="radio" name="csv" value="" id="print1">
        <label for="print1"><i class="fa fa-print fa-lg"></i> 주문서 요약인쇄</label>
        <label for="ct_status_p" class="sound_only">출력대상</label>
        <select name="ct_status" id="ct_status_p">
            <option value="주문">주문</option>
            <option value="입금">입금</option>
            <option value="준비">준비</option>
            <option value="배송">배송</option>
            <option value="완료">완료</option>
            <option value="취소">취소</option>
            <option value="반품">반품</option>
            <option value="품절">품절</option>
            <option value="">전체</option>
        </select>
        <label for="fr_date" class="sound_only">기간 시작일</label>
        <input type="text" name="fr_date" value="<?php echo date("Ymd"); ?>" id="fr_date" required class="required frm_input" size="8" maxlength="8">
        ~
        <label for="to_date" class="sound_only">기간 종료일</label>
        <input type="text" name="to_date" value="<?php echo date("Ymd"); ?>" id="to_date" required class="required frm_input" size="8" maxlength="8">
        <input type="submit" value="출력 (새창)" class="btn_submit">

        </form>
    </div>

    <div class="sch_last">

        <form name="forderprint" action="./orderprintresult.php" onsubmit="return forderprintcheck(this);" autocomplete="off" >
        <input type="hidden" name="case" value="2">
        <strong class="sch_long">주문번호구간별 출력</strong>

        <input type="radio" name="csv" value="xls" id="xls2">
        <label for="xls2">MS엑셀 XLS 파일</label>
        <input type="radio" name="csv" value="csv" id="csv2">
        <label for="csv2">MS엑셀 CSV 파일</label>
        <input type="radio" name="csv" value="" id="print2">
        <label for="print2"><i class="fa fa-print fa-lg"></i> 주문서 요약인쇄</label>
        <label for="ct_status_n" class="sound_only">출력대상</label>
        <select name="ct_status" id="ct_status_n">
            <option value="주문">주문</option>
            <option value="입금">입금</option>
            <option value="준비">준비</option>
            <option value="배송">배송</option>
            <option value="완료">완료</option>
            <option value="취소">취소</option>
            <option value="반품">반품</option>
            <option value="품절">품절</option>
            <option value="">전체</option>
        </select>
        <label for="fr_od_id" class="sound_only">주문번호 구간 시작</label>
        <input type="text" name="fr_od_id" id="fr_od_id" required class="required frm_input" size="15" maxlength="20" onKeyup="this.value=this.value.replace(/[^0-9]/g,'')">
        ~
        <label for="fr_od_id" class="sound_only">주문번호 구간 종료</label>
        <input type="text" name="to_od_id" id="to_od_id" required class="required frm_input" size="15" maxlength="20" onKeyup="this.value=this.value.replace(/[^0-9]/g,'')">
        <input type="submit" value="출력 (새창)" class="btn_submit">

        </form>
    </div>

</div><!-- } 기본 주문내역출력 선택창 닫기 //-->
</section><!-- } 기본 주문내역출력 섹션 닫기 //-->

<!-- 안내창 -->
<div class="local_desc01 local_desc">
    기간별 혹은 주문번호구간별 주문내역을 새창으로 출력할 수 있습니다.<br>
    주문번호구간의 <strong>주문번호는 "-" 없이 숫자만 입력</strong>해주세요!<br>
    MS엑셀XLS파일 다운로드시 송장번호가 6.988E+11 등으로 변경되는것을 숫자로 나오도록 기존버그를 수정하였습니다.
</div>
<!--//-->

<div class="btn_go01 btn_add">
    <a href="./orderlist.php" class="btn_go01 btn_add_optional"><i class="fa fa-share"></i> 주문내역</a>
</div>


<script>
$(function(){
    $("#fr_date, #to_date, #fr_date2, #to_date2, #fr_date3, #to_date3").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yymmdd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});

function forderprintcheck(f)
{
    if (f.csv[0].checked || f.csv[1].checked)
    {
        f.target = "_top";
    }
    else
    {
        var win = window.open("", "winprint", "left=10,top=10,width=750,height=800,menubar=yes,toolbar=yes,scrollbars=yes");
        f.target = "winprint";
    }

    f.submit();
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
