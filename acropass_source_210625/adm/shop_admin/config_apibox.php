<?php
$sub_menu = '100501'; // 무통장입금 자동확인 서비스관련(유료/사용설정은 서비스업체 홈페이지에서 가능) 2017-12-07
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '알뱅킹서비스 사용 설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$pg_anchor = '<ul class="anchor">
<li><a href="#anc_ch_basic">기본설정</a></li>
<li><a href="#anc_ch_market">추천쇼핑몰관리</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';

?>
<style>
.div-basic { width:180px; margin:0px; padding:0px;}
.div-basic > ul { list-style:none; padding:0px; margin:0px;}
.div-basic > ul > li { margin:0px; padding:5px 2px; font-size:12px;}
.div-basic > li > a { }
</style>

<form name="fconfig" action="./config_apiboxupdate.php" onsubmit="return fconfig_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="">

<!-- 추천쇼핑몰설정 2016-09 { -->
<section id="anc_ch_basic">
    <div class="local_desc01 local_desc">
		<p>
        (1) APIBOX 에서 제공하는 무통장 자동입금확인 <b>유료서비스</b>입니다<br>
        - 무통장자동입금확인서비스란? 무통장입금으로 주문한후 입금하면, 입금자명과 주문내역을 확인해서 입금완료로 자동처리하는 서비스를 말합니다<br>
        (2) 매월 월정액으로 진행되며, 알뱅킹이 저렴하다고 합니다
        </p>
      <p>(2) APIBOX 에서 제공하는 서비스로 연결모듈만 제공하며, 서비스를 이용하려면 APIBOX에서 회원가입 및 <b>유료서비스</b>를<b> 신청</b>하시면 됩니다</p>
        
        <p>
        <strong>※ 아이스크림은 알뱅킹서비스 연결모듈만 제공하며, APIBOX와는 아무 관계가 없음을 알려드립니다</strong><br>
        - 자동입금확인서비스를 원하는 쇼핑몰운영자분들이 많아서, 개발업체에서 따로 연결해야하는 부담이 있었습니다<br>
        - 자동입금확인서비스 업체중에서 알뱅킹에서 영카트 모듈을 제공하기에, 아이스크림에 탑재하여 제공됩니다<br>
        - 개발업체에서 따로 할일없이, 쇼핑몰운영자가 APIBOX에서 신청만 하면 사용가능합니다<br>
        </p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>
        추천쇼핑몰 기능사용여부 및 모바일상담기능추가
        </caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="apibox_use">알뱅킹서비스</label></th>
            <td colspan="3">
                <label class="switch-check">
                <input type="checkbox" name="apibox_use" value="1" id="apibox_use" <?php echo $default['apibox_use']?"checked":""; ?>> 사용함
                <div class="check-slider round"></div>
                </label>
                <label for="apibox_use">알뱅킹서비스 사용설정</label>
			</td>
        </tr>
        <tr>
            <th scope="row"><label for="ch_link_tel_number">APIBOX 회원 아이디</label></th>
            <td colspan="3">
                <input type="text" name="apibox_id" value="<?php echo $default['apibox_id']; ?>" id="apibox_id" class="frm_input" size="15">
                알뱅킹서비스사이트인 APIBOX 에서 가입한 회원아이디( <a href="http://www.apibox.kr" target="_blank">http://www.apibox.kr</a> )			</td>
        </tr>
        <!--사용함체크시나타남-->
        <?php if( $default['apibox_use'] == '1') { //알뱅킹 사용체크시 나타남?>
        <tr>
            <th scope="row">&nbsp;</th>
            <td colspan="3">
                <p class="red">apibox 사이트에서 회원가입 및 서비스신청을 하셔야 알뱅킹서비스를 사용하실 수 있습니다</p>
                <p class="red">※ 아래에 기재된 신청방법에 따라 [단계별]로 따라 해주세요!</p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">&nbsp;</th>
            <td colspan="3">
                <a href="http://www.apibox.kr/bank/bank.return.php" target="_blank"><span class="screen_tack1">입금통보리스트 바로가기</span></a>
                <a href="http://www.apibox.kr/bank/bank.account.php" target="_blank"><span class="screen_tack1">계좌번호관리 바로가기</span></a>
            </td>
        </tr>
        <?php } ?>
        <!--//-->
        </tbody>
        </table>
    </div>  
</section>

<?php echo $frm_submit; ?>

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">   
    <div class="bq_basic_icon">
    <a href="<?php echo G5_SHOP_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/shop_icon.png" border="0" title="쇼핑몰">&nbsp;&nbsp;</a>
    </div>
    
	<?php if ($is_admin == 'super') { ?>
    <div class="bq_basic_submit">
    <input type="submit" value="확인" accesskey="s">
    </div>
    <?php } ?>
</div>
<!--//-->
<!-- } -->

<!-- 안내 -->   
<div class="h30"><!--//--></div>

<h2 class="h2_frm orangered">가입 가능업종 안내</h2>
<div class="local_desc01">
    <ul>
        <li class="content-list-txt1">
        아래와 같이 가입가능한 업종과, 불가능한 업종에 대한 가이드라인을 안내해 드리고 있사오니 필히 확인하시고 이용 부탁드리겠습니다.
        </li>
        <li class="txt1">
        <strong>가입가능업종</strong><br>
        ① 실물의 상품을 판매하여, 고객에게 배송하는 온라인 쇼핑몰 (단 고가의 상품이나 현금,유가증권을 취급하는 쇼핑몰은 제외)<br>
        ② 현재 운영중인 사이트가 아닌경우(ex 개발중인 사이트, 오픈예정), 업종확인이 불가능하므로 사업자등록증과, 통신판매신고증을 보내주셔야 합니다
        </li>
        <li class="txt1">
        <strong>가입제한업종</strong><br>
        ① 컨텐츠 업종 (ex 가상머니충전, p2p투자/예치금, 상품권코드발송, 게임머니충전, 소프트웨어 판매(게임cd-key, 시리얼넘버 등)<br>
        ② 고가의 물품 취급 쇼핑몰 (고가 전자제품, 귀금속 등)<br>
        ③ 현금성 유가증권, 상품권등 취급 쇼핑몰<br>
        ※ 컨텐츠 업종은, 무형의 상품을 취급하는 업종 특성상, 월매출에 해당하는 금액만큼 보증보험 가입이 필요하며, 보험가입이 불가능하거나 거절된 경우 서비스를 이용하실 수 없습니다
        </li>
        <li class="txt1">
        <strong>서비스 가입불가업종</strong> (아래 업종은 서비스이용이 불가능하며, 모니터링 적발 즉시 통보없이 즉시 차단)<br>
        ① 불법 성인사이트(만남 등)<br>
        ② 도박 관련 사이트 (스포츠경기결과제공, 불법게임, 가상머니포인트 환전업 등)<br>
        ③ 불법 피라미드
        </li>
    </ul>
</div>
<!-- // --> 

<!-- 설치전준비사항 -->   
<div class="h30"><!--//--></div>

<h2 class="h2_frm blue">[1단계] 내서버에서 할일</h2>
<div class="local_desc01">
    <ul>
        <li class="title1">
        ① 이온큐브 설치여부 확인하기
        </li>
        <li class="content-list-txt1">
        ※ APIBOX는 프로그램의 컴파일을 통해 실행 속도를 증가시키고, 소스코드를 보호하기 위해 이온큐브(ionCube) 인코더를 사용하고 있습니다<br>
        ※ 이온큐브는 대부분의 웹호스팅사에서 지원하고 있으며, 별도로 이온큐브를 설치하실 필요가 없습니다<br>
        <span class="blue">카페24 / 미리내호스팅 / 아사달호스팅 / 닷홈호스팅</span>은 이온큐브가 기본 제공됩니다
        </li>
        <li class="txt1">
        ※ 이온큐브 미지원 웹호스팅이나 서버를 운영하시는 경우에는 설치설명서의 <a href="http://blog.naver.com/whenji486/220129643438" target="_blank">(1)설치전준비사항</a> 을 확인하세요
        </li>
        <li class="txt1">
        ※ 이온큐브 설치에 어려움이 있으면, APIBOX로 문의주세요 <a href="http://www.apibox.kr" target="_blank">http://www.apibox.kr</a> 
        </li>
        
        <li class="content-list-txt1"><!--공란--></li>
        
        <li class="title1">
        ② FTP를 이용해 업로드된 apibox 폴더 권한설정 하기
        </li>
        <li class="content-list-txt1">
        a) 아이스크림을 설치하면 루트에 apibox 폴더가 같이 업로드됩니다. 따로 업로드할 필요가 없습니다<br>
        b) <strong>/apibox/conf 폴더의 권한을 707로 설정</strong>해주세요 (conf 폴더에 마우스를 대고 우측키를 눌러서 권한설정 선택)<br><br>
        <img src="<?php echo G5_ADMIN_URL;?>/img/tip/apibox_707.gif">
        </li>
        
        <li class="content-list-txt1"><!--공란--></li>
        
        <li class="title1">
        ③ 관리자모드 쇼핑몰설정에서 무통장입금 사용으로 설정해놓기
        </li>
        <li class="content-list-txt1">
        a) 관리자모드 &gt; 환경설정 &gt; 쇼핑몰기본설정 으로 들어갑니다<br>
        b) 탭에서 <strong>결제설정</strong>을 클릭해주세요<br>
        c) 무통장입금사용 설정에서 <strong>사용</strong>으로 설정 후 확인키를 눌러 저장합니다<br><br>
        <img src="<?php echo G5_ADMIN_URL;?>/img/tip/apibox_use.png">
        </li>
        
    </ul>
</div>
<!-- // --> 

<!-- APIBOX 회원가입 및 무통장입금자동통보 서비스신청 -->   
<div class="h30"><!--//--></div>

<h2 class="h2_frm blue">[2단계] APIBOX 회원가입 및 서비스 신청</h2>
<div class="local_desc01">
    <ul>
        <li class="title1">
        ① APIBOX 회원가입 하기
        </li>
        <li class="content-list-txt1">
        ※ APIBOX사이트 (<a href="http://www.apibox.kr" target="_blank">http://www.apibox.kr</a>) 에서 먼저 회원가입을 합니다 <a href="http://www.apibox.kr/member/register.php?grpno=12" target="_blank"><span class="screen_tack1">회원가입 바로가기</span></a>
        </li>
        
      <li class="content-list-txt1"><!--공란--></li>
        
        <li class="title1">
        ② APIBOX 무통장입금자동통보 서비스 신청
        </li>
        <li class="content-list-txt1">
        a) APIBOX > 로그인 > 알뱅킹(무통장입금자동통보) > 서비스신청 <a href="http://www.apibox.kr/bank/bank.join.php" target="_blank"><span class="screen_tack1">무통장입금자동통보서비스신청 바로가기</span></a><br>
        b) APIBOX에 접속하여 로그인 후 무통장입금자동통보서비스를 신청페이지에서 안내대로 신청해 주시면 됩니다<br>
        </li>
        
        <li class="content-list-txt1"><!--공란--></li>
        
        <li class="title1">
        ③ APIBOX 무통장입금자동통보를 받을 계좌번호 등록하기
        </li>
        <li class="content-list-txt1">
        a) APIBOX 홈페이지에, 영카트5에서 사용할 계좌번호를 등록해 주셔야합니다<br>
        b) <b>APIBOX > 알뱅킹(무통장입금자동통보) > 계좌번호관리 > 새로추가하기</b> <a href="http://www.apibox.kr/bank/bank.account.php" target="_blank"><span class="screen_tack1">계좌번호관리 바로가기</span></a><br>
        c) <strong>새로추가하기</strong>버튼을 클릭해서 계좌번호를 등록해 줍니다<br><br>
        <img src="<?php echo G5_ADMIN_URL;?>/img/tip/apibox_account.jpg"><br><br>
        ※ 콜백 URL 주소는 <span class="red font-bold">http://영카트설치(도메인)경로/apibox/callback/bank.youngcart.php</span> 를 입력하시면 됩니다
        </li>
        
    </ul>
</div>
<!-- // --> 

<!-- 인터넷뱅킹에서 SMS문자통보 서비스 신청 -->   
<div class="h30"><!--//--></div>

<h2 class="h2_frm blue">[3단계] 은행계좌별로 SMS 입금통지 서비스 신청</h2>
<div class="local_desc01">
    <ul>        
        <li class="content-list-txt1">
        ※ APIBOX 의 무통장입금 자동확인서비스는 은행에서 제공하는 SMS 입금통지서비스를 기준으로 제공되기에<br>
        ※ 입금계좌의 은행 인터넷뱅킹을 통해 SMS 입금통지서비스를 반드시 신청해서 사용하셔야 합니다<br>
        </li>
        
        <li class="title1">
        ① 은행별로 SMS 입금통지서비스 신청
        </li>
        <li class="content-list-txt1">
        a) 계좌가 속한 은행의 인터넷뱅킹사이트에 접속합니다 <a href="http://www.apibox.kr/bank/bank.manual.php" target="_blank"><span class="screen_tack1">신청메뉴얼보기</span></a><br>
        b) 로그인하여 APIBOX에 등록한 계좌의 SMS 입금통지서비스를 신청합니다<br>
        c) 입금받을 무통장입금 계좌가 여러개일 경우 계좌가 속한 은행의 인터넷뱅킹에 접속하여 동일한 작업을 반복해 줍니다<br>
        </li>        
    </ul>
</div>
<!-- // --> 

<!-- 완료확인 -->   
<div class="h30"><!--//--></div>

<h2 class="h2_frm blue">[신청완료] 확인하기</h2>
<div class="local_desc01">
    <ul>        
        <li class="content-list-txt1">
        ※ 입금통보리스트 확인은, APIBOX > 알뱅킹(무통장입금자동통보) > 입금통보리스트에서 열람 가능하며, 엑셀로 저장 가능
        <a href="http://www.apibox.kr/bank/bank.return.php" target="_blank"><span class="screen_tack1">입금통보리스트 바로가기</span></a>
        </li>
        
        <li class="title1">
        ① 아래의 경우는 프로그램적으로 확인이 불가능한 상황으로, 관리자가 수동으로 입금확인을 해주셔야합니다.
        </li>
        <li class="content-list-txt1">
        1) 동일시간대 동일금액으로 동명2인이 주문한 경우<br>
        2) 주문자와 실제입금자가 틀린 경우<br>
        3) 입금금액이 틀린 경우<br>
        </li>   
        
        <li class="content-list-txt1">
        ※ 입금통보리스트에서 실패/무응답 상태로 조회가 가능합니다. 해당리스트만 수동으로 확인해주시면 간편하게 처리하실 수 있습니다<br>
        </li>     
    </ul>
</div>
<!-- // --> 

</form>



<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
