<?php
$sub_menu = '400336'; /* 새로만듦 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '상품옵션 Excel 일괄 등록';
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>


<div style="padding:15px 0px; line-height:16px;">
상품 옵션을 엑셀로 일괄 등록하는 공간입니다. <br> 
상품 옵션 일괄등록용 엑셀파일을 다운로드해서 옵션을 입력해서 일괄 등록할 수 있습니다.<br> 
<span class="pink font-bold">상품Excel일괄등록 후 상품옵션을 등록해 주세요. 그래야 옵션등록 후 등록한 상품에서 바로 확인 및 정성처리여부 확인이 가능합니다.</span>
</div>

<!-- 경고사항 -->
<div style="padding:15px 25px; line-height:18px; background:#818181; color:#fafafa;">
※ 반드시 전체DB 또는 g5_shop_item_option 테이블을 꼭 백업하시고 등록작업을 해 주세요.<br>
※ 처음 사용시에는 반드시 백업 후 등록을 해주시고, 여러번 업드로 작업후 문제없이 등록되는것을 확인한 후에는 생략하면 됩니다.<br>
※ 상품옵션 DB에 영향을 주는 작업이므로 혹시나 문제가 생기면, 백업파일을 업데이트해서 원래상태로 돌려주면 됩니다.
</div>
<!--//-->

<section><!-- 상품옵션 엑셀등록폼 다운로드 및 송장 엑셀등록 섹션 열기 { -->
<div class="dan-garo1" style="border:solid 5px #9EE5E2; background:#fff; padding:25px 25px 25px;"><!-- 전체박스 열기 { -->

    <!-- @@ (1) 상품옵션 엑셀등록폼 다운로드 @@ -->
    <div class="excel_down">
    <h5 style="color:#33CCCC;">STEP1</h5>
    <h5><i class="fa fa-download fa-lg"></i> 상품옵션 일괄등록용 Excel 기본(예제)폼 다운</h5>

      <div style=" margin:25px 0px;text-align:center; line-height:20px; border:0; cursor:pointer;" class="at-tip" onClick="location.href='<?php echo G5_URL; ?>/<?php echo G5_LIB_DIR; ?>/Excel/itemoptionexcel.xls'" data-original-title="<nobr>상품옵션 일괄등록용<br>Excel(예제)폼 다운로드</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
        <img src="<?php echo G5_ADMIN_URL;?>/img/Exel_down.png">
        <br>
        <br><b class="darkgreen font-14">itemoptionexcel.xls</b>
        </div>
        
<div style="color:#009999;">
            상품옵션 등록폼인 엑셀파일을 다운로드 합니다.<br>
            옵션정보를 옵션별로 각각 기재합니다.<br>
<b class="pink">Excel97-2003 통합문서(*.xls)</b>로 저장합니다.<br>
            상품이미지는 따로 업로드해야 합니다<br>
            
      </div>
        
    </div>
    <!-- @@ (1) // @@ -->

    <!-- @@ (2) 상품옵션 엑셀등록 @@ -->
    <div class="excel_up">
    <h5 style="color:#33CCCC;">STEP2</h5>
    <h5><i class="fa fa-upload fa-lg"></i> 상품옵션 Excel 일괄 등록 <b class="blue font-11">Excel97-2003 통합문서(*.xls)로 저장해서 업로드</b></h5>
    
    <form name="fitemexcel" method="post" action="./itemoption_EXCEL_update.php" target="sendWin" onsubmit="return submitWin(this);" enctype="MULTIPART/FORM-DATA" autocomplete="off">
    
    <div id="excelfile_upload">
        <label for="excelfile">파일선택</label>
        <input type="file" name="excelfile" id="excelfile">
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="상품옵션 엑셀파일 등록" class="btn_submit_big">
    </div>
    </form>
    
    <div style="margin-top:35px;color:#4c4c4c; border:solid 1px #d3d3d3; background:#FFF5D7; padding:15px;">
        <b class="violet">[엑셀파일에 옵션정보 기재시 유의사항]</b><br>
        ※ 상품코드, 옵션명, 옵션항목, 옵션형식은 필수입력<br>
        ▶ 상품코드 : 옵션을 적용할 상품코드를 기재<br>
        ▶ 옵션명 : 옵션제목으로 쉼표(,)로 구분<br>
        ▶ 옵션항목 : 옵션명에 맞추어서 옵션별로 1줄씩 추가<br>
        ▶ 옵션가격 : 옵션형식이 0인경우 판매가에 더해질 금액을<br>옵션형식이 1인경우 총판매금액을 옵션가격란에 기재<br>
        ※ 옵션 테이블에 등록한 상품코드,옵션항목,옵션형식이<br>동일한 데이터가 있으면 업데이트되고,없으면 신규등록됩니다<br>
        ※ 반드시 Excel97-2003 통합문서(*.xls)로 저장합니다
    </div>
    
    </div>
    <!-- @@ (2) // @@ -->
    
    <div style="padding:20px 0px 0px; border:0px; line-height:18px;">
    ※ 정상적인 상품등록을 위해서는 상품엑셀파일만 등록해서는 완료가 되지 않습니다.<br>
    ※ 상품옵션 등록 / 품목별 정보제공에 관한 고시 / 상품이미지를 업로드해주셔야 합니다.<br>
    ※ 상품등록시 연관되서 작업해주어야할것이 너무 많고 헷갈려서, 상품 엑셀 등록은 많이 사용하지는 않고 있습니다.<br>
    ※ 비슷한 품목의 상품을 여러개 등록하시는 것이라면, 1개의 상품등록후 복사방식으로 추가해서, 이미지 및 상세정보를 변경해주는 방식으로 하는것이 더 쉬울수도 있습니다.<br>
    </div>

</div><!-- } 전체박스 닫기 //-->
</section><!-- } 상품옵션 엑셀폼 및 상품 엑셀등록 섹션 닫기 //-->

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
    <i class="fa fa-lightbulb-o fa-lg blue font-12" aria-hidden="true"> 바로등록을 원하시면</i> 상품과 옵션을 각각 엑셀로 등록을 하지않고, 상품을 직접 등록하시려면 상품등록페이지로 이동하세요&nbsp;&nbsp;&nbsp;
    <button class="btn btn-darkgray btn-sm cursor" onClick="location.href='<?php echo G5_ADMIN_URL; ?>/shop_admin/itemform.php'">상품등록</button><!-- 바로가기버튼 -->
</div>
<!--//-->


<div class="h5" style=" border-bottom:dotted 1px #ccc; margin:0px 0px 25px;"></div>


<section><!-- 안내 섹션 열기 { -->
<h5>상품옵션 엑셀등록 안내</h5>
<div class="local_desc01" style="border:solid 1px #ccc; background:#f7f7f7; padding:25px 25px 25px;"><!-- 전체박스 열기 { -->
    
    <!-- 예제 안내 -->
    <div style="padding:10px 20px 20px; border:solid 4px #F6BDE3; line-height:24px; background:#fff;">
    <h5>[예제] 예제로 알아보는 상품옵션 등록 방법 안내</h5>
    ※ 상품을 먼저 엑셀이나 직접 등록하신후에 옵션을 등록해주면 됩니다.<br>
    <b>[색상]</b> 색상은 <span class="pink font-bold">흰색/검정색/줄무니색</span>의 3가지가 있고,
    <b>[사이즈]</b> 사이즈는 색상별로 <span class="pink font-bold">S, M, L, XL</span> 사이즈가 있다고 하면<br>
    ※ 색상을 기준으로 잡고, 색상별로 S, M, L, XL 을 각각 대입해서 옵션을 등록해 줍니다. 아래 화면 참고<br>
    </div>
    <!--//-->
    
    <div style="padding:15px 0px 15px; margin-top:20px; border:0px; line-height:18px;">
    <h5>(1) 엑셀파일에 옵션정보 입력하기</h5>
    <img src="<?php echo G5_ADMIN_URL;?>/img/tip/option01.png"><br><br><br>
    (1) 상품옵션 등록폼인 itemoptionexcel.xls 엑셀 파일을 다운받습니다.<br>
    (2) 엑셀파일을 열면 상단에 설명이 있는데, 필히 읽어주세요!!!<br>
    (3) 예제로 등록된 옵션내용은 삭제하고, 실제 상품옵션을 기재해 주시면 됩니다.<br>
    (4) 색상을 기준으로 잡고, 색상별로 S, M, L, XL 을 각각 대입해서 옵션을 기재해 줍니다. 위의 화면 참고<br>
    <span class="pink font-bold">※ 반드시 Excel97-2003 통합문서(*.xls)로 저장합니다</span>
    </div>
    
    <div style="padding:15px 0px 15px; margin-top:20px; border:0px; line-height:18px;">
    <h5>(2) 옵션파일 등록하기</h5>
    <img src="<?php echo G5_ADMIN_URL;?>/img/tip/option02.png"><br><br><br>
    <span class="pink font-bold">※ 먼저 상품을 등록하신 후에 옵션을 등록해 주셔야 합니다.</span><br>
    (1) 파일찾아보기 를 통해 엑셀파일을 선택하고, "상품옵션 엑셀파일 등록" 버튼을 클릭하면 등록이 완료되면서 등록건수 메세지창이 뜹니다<br>
    (2) 상품관리 페이지로 이동해서, 옵션등록이 제대로 되었는지 확인하실 수 있습니다<br>
    </div>
    
    <div style="padding:15px 0px 15px; margin-top:20px; border:0px; line-height:18px;">
    <h5>(3) 상품에 적용된 옵션 확인</h5>
    <img src="<?php echo G5_ADMIN_URL;?>/img/tip/option03.png"><br><br><br>
    (1) 관리자모드 > 상품관리(전체상품관리) 로 이동합니다.<br>
    (2) 등록한 옵션의 상품을 찾아서 <span class="pink font-bold">"수정"</span> 버튼을 클릭합니다.<br>
    (3) 상품수정페이지로 이동하는데, 메뉴탭에서 <span class="pink font-bold">"가격및재고"</span> 탭을 클릭하면 가격맻재고 관리 탭으로 이동합니다.<br>
    (4) 가격및재고 탭에서 조금만 아래로 더 내려가면 <span class="pink font-bold">"상품선택옵션"</span> 에 엑셀로 등록한 옵션정보를 확인하실 수 있습니다.<br>
    (5) 엑셀로 등록한 상품옵션이 제대로 등록되었는지 확인해보시면 됩니다. 추가로 수정할것이 있으면 그자리에서 수정후 "확인"하시면 됩니다.
    </div>

</div><!-- } 전체박스 닫기 //-->
</section><!-- } 안내 섹션 닫기 //-->


<script>
    /* 엑셀상품옵션 등록처리창 */
    //<![CDATA[ 상품옵션 엑셀 등록처리 (팝업창으로 이동)
    function submitWin(form){
      window.open('',form.target,'width=640,height=450,scrollbars=yes');
      return true;
    }
    //]]>
	

</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>