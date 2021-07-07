<?php
$sub_menu = '400335'; /* 새로만듦 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '상품 Excel 일괄 등록';
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>


<div style="padding:15px 0px; line-height:16px;">
상품을 엑셀로 일괄 등록하는 공간입니다. <br> 
상품 일괄등록용 엑셀파일을 다운로드해서 상품정보를 입력해서 일괄 등록할 수 있습니다.<br>
<span class="pink font-bold">등록한 후 상품옵션이 있는 상품들을 확인해서 상품옵션Excel등록에서 등록해 주세요.</span>
</div>

<!-- 경고사항 -->
<div style="padding:15px 25px; line-height:18px; background:#818181; color:#fafafa;">
※ 반드시 전체DB 또는 g5_shop_item 테이블을 꼭 백업하시고 등록작업을 해 주세요.<br>
※ 상품DB에 영향을 주는 작업이므로 혹시나 문제가 생기면, 백업파일을 업데이트해서 원래상태로 돌려주면 됩니다.
</div>
<!--//-->

<section><!-- 상품엑셀등록폼 다운로드 및 송장 엑셀등록 섹션 열기 { -->
<div class="dan-garo1" style="border:solid 5px #9EE5E2; background:#fff; padding:25px 25px 25px;"><!-- 전체박스 열기 { -->

    <!-- @@ (1) 상품엑셀등록폼 다운로드 @@ -->
    <div class="excel_down">
    <h5 style="color:#33CCCC;">STEP1</h5>
    <h5><i class="fa fa-download fa-lg"></i> 상품 일괄등록용 Excel 기본폼 다운로드</h5>

        <div style=" margin:25px 0px;text-align:center; line-height:20px; border:0; cursor:pointer;" class="at-tip" onClick="location.href='<?php echo G5_URL; ?>/<?php echo G5_LIB_DIR; ?>/Excel/itemexcel.xls'" data-original-title="<nobr>상품 일괄등록용<br>Excel 폼 다운로드</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
        <img src="<?php echo G5_ADMIN_URL;?>/img/Exel_down.png">
        <br>
        <br><b class="darkgreen font-14">itemexcel.xls</b>
        </div>
        
<div style="color:#009999;">
            상품 등록폼인 엑셀파일을 다운로드 합니다.<br>
            상품정보를 기재합니다.<br>
<b class="pink">Excel97-2003 통합문서(*.xls)</b>로 저장합니다.<br>
            상품옵션 및 이미지는 따로 등록/업로드합니다.<br>
            
      </div>
        
    </div>
    <!-- @@ (1) // @@ -->

    <!-- @@ (2) 상품엑셀등록 @@ -->
    <div class="excel_up">
    <h5 style="color:#33CCCC;">STEP2</h5>
    <h5><i class="fa fa-upload fa-lg"></i> 상품 Excel 일괄 등록 <b class="blue font-11">Excel97-2003 통합문서(*.xls)로 저장해서 업로드</b></h5>
    
    <form name="fitemexcel" method="post" action="./itemexcelupdate.php" target="sendWin" onsubmit="return submitWin(this);" enctype="MULTIPART/FORM-DATA" autocomplete="off">
    
    <div id="excelfile_upload">
        <label for="excelfile">파일선택</label>
        <input type="file" name="excelfile" id="excelfile">
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="상품 엑셀파일 등록" class="btn_submit_big">
    </div>
    </form>
    
    <div style="margin-top:35px;color:#4c4c4c; border:solid 1px #d3d3d3; background:#FFF5D7; padding:15px;">
        <b class="violet">[엑셀파일에 상품정보 기재시 유의사항]</b><br>
        ※ 상품코드, 기본분류, 상품명은 필수입력<br>
        ※ 상품코드는 중복되지 않아야 함<br>
        ※ 기본분류에는 쇼핑몰에서 사용 중인 분류의 코드를 입력해야함<br>
        ※ 상품설명에는 html 코드 입력가능<br>
        ※ 상품이미지에는 data/item 아래의 경로입력<br>
        - 예를들어 data/item/abcd/item.jpg 일 경우 abcd/item.jpg 만 입력<br>
        ※ 이 설명과 아래 상품코드, 기본분류 등의 텍스트를 삭제해서는 안됨
    </div>
    
    </div>
    <!-- @@ (2) // @@ -->
    
    <div style="padding:20px 0px 0px; border:0px; line-height:18px;">
    ※ 정상적인 상품등록을 위해서는 상품엑셀파일만 등록해서는 완료가 되지 않습니다.<br>
    ※ 상품옵션 등록 / 품목별 정보제공에 관한 고시 / 상품이미지를 업로드해주셔야 합니다.<br>
    ※ 기존에는 헷갈려서, 영카트에서 상품엑셀등록은 많이 사용하지는 않고 있습니다. 하지만, <br>
    ※ 상품일괄등록은 상품엑셀등록 및 상품옵션엑셀등록, 상품이미지 FTP 업로드 를 순서대로 하면 그렇게 어렵지 않습니다.<br>
    </div>

</div><!-- } 전체박스 닫기 //-->
</section><!-- } 상품 엑셀폼 및 상품 엑셀등록 섹션 닫기 //-->

<!-- 상품이미지 FTP 업로드방법 -->
<div class="local_desc01 local_desc">
    <p>
    <b class="orangered"><상품이미지 FTP 업로드방법></b>
    ※ 상품엑셀등록은 상품이미지는 FTP로 따로 업로드 해 주어야합니다.<br>
    ※ 상품이미지에는 data/item 아래의 경로입력 예를들어 data/item/abcd/item.jpg 일 경우 abcd/item.jpg 만 입력<br>
    - 영카트는  data/item/상품코드/item.jpg 이런식으로 item폴더 하위에 상품코드별로 폴더로 구분하고 있습니다.<br>
    - 영카트의 기본 규칙을 지키려면 상품코드로 폴더를 만들어서 상품이미지를 넣어서 폴더째로 업로드하시면 됩니다.
    </p>
</div>
<!--//-->

<!-- [상품등록] 바로등록 -->
<div class="darkgray font-12" style="display:block; padding:15px 0px; text-align:center;">
    <i class="fa fa-lightbulb-o fa-lg blue font-12" aria-hidden="true"> 바로등록을 원하시면</i> 엑셀로 등록을 하지않고, 상품을 직접 등록하시려면 상품등록페이지로 이동하세요&nbsp;&nbsp;&nbsp;
    <button class="btn btn-darkgray btn-sm cursor" onClick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/itemform.php'">상품등록</button><!-- 바로가기버튼 -->
</div>
<!--//-->


<div class="h5" style=" border-bottom:dotted 1px #ccc; margin:0px 0px 25px;"></div>


<script>
    /* 엑셀상품등록처리창 */
    //<![CDATA[ 상품 엑셀 등록처리 (팝업창으로 이동)
    function submitWin(form){
      window.open('',form.target,'width=640,height=450,scrollbars=yes');
      return true;
    }
    //]]>
	

</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>