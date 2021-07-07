<?php
$sub_menu = '111115'; /* (새로만듬) PG/간편페이 설정 */
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = 'PG/간편페이 설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$pg_anchor = '<ul class="anchor">
<li><a href="#anc_scf_pg">PG설정</a></li>
<li><a href="#anc_scf_kgpay">SAMSUNG페이</a></li>
<li><a href="#anc_scf_kgpay">L.페이</a></li>
<li><a href="#anc_scf_kakao">KAKAO페이</a></li>
<li><a href="#anc_scf_npay">NAVER페이</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';

// 무이자 할부 사용설정 필드 추가
if(!isset($default['de_card_noint_use'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_card_noint_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `de_card_use` ", true);
}

// PG 간펼결제 사용여부 필드 추가
if(!isset($default['de_easy_pay_use'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_easy_pay_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `de_iche_use` ", true);
}

// 이니시스 inicis 필드 추가
if(!isset($default['de_inicis_mid'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_inicis_mid` varchar(255) NOT NULL DEFAULT '' AFTER `de_kcp_site_key`,
                    ADD `de_inicis_admin_key` varchar(255) NOT NULL DEFAULT '' AFTER `de_inicis_mid` ", true);
}

// 이니시스 삼성페이 사용여부 필드 추가
if(!isset($default['de_samsung_pay_use'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_samsung_pay_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `de_easy_pay_use` ", true);
}

// 이니시스
if(!isset($default['de_inicis_cartpoint_use'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_inicis_cartpoint_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `de_samsung_pay_use` ", true);
}

// 이니시스 lpay 사용여부 필드 추가
if(!isset($default['de_inicis_lpay_use'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_inicis_lpay_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `de_samsung_pay_use` ", true);
}

// 카카오페이 필드 추가
if(!isset($default['de_kakaopay_mid'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_kakaopay_mid` varchar(255) NOT NULL DEFAULT '' AFTER `de_tax_flag_use`,
                    ADD `de_kakaopay_key` varchar(255) NOT NULL DEFAULT '' AFTER `de_kakaopay_mid`,
                    ADD `de_kakaopay_enckey` varchar(255) NOT NULL DEFAULT '' AFTER `de_kakaopay_key`,
                    ADD `de_kakaopay_hashkey` varchar(255) NOT NULL DEFAULT '' AFTER `de_kakaopay_enckey`,
                    ADD `de_kakaopay_cancelpwd` varchar(255) NOT NULL DEFAULT '' AFTER `de_kakaopay_hashkey` ", true);
}

// 이니시스 웹결제 사인키 필드 추가
if(!isset($default['de_inicis_sign_key'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_inicis_sign_key` varchar(255) NOT NULL DEFAULT '' AFTER `de_inicis_admin_key` ", true);
}

// lg 결제관련 필드 추가
if(!isset($default['de_pg_service'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_pg_service` varchar(255) NOT NULL DEFAULT '' AFTER `de_sms_hp` ", true);
}

// 네이버페이 필드추가
if(!isset($default['de_naverpay_mid'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_naverpay_mid` varchar(255) NOT NULL DEFAULT '' AFTER `de_kakaopay_cancelpwd`,
                    ADD `de_naverpay_cert_key` varchar(255) NOT NULL DEFAULT '' AFTER `de_naverpay_mid`,
                    ADD `de_naverpay_button_key` varchar(255) NOT NULL DEFAULT '' AFTER `de_naverpay_cert_key`,
                    ADD `de_naverpay_test` tinyint(4) NOT NULL DEFAULT '0' AFTER `de_naverpay_button_key`,
                    ADD `de_naverpay_mb_id` varchar(255) NOT NULL DEFAULT '' AFTER `de_naverpay_test`,
                    ADD `de_naverpay_sendcost` varchar(255) NOT NULL DEFAULT '' AFTER `de_naverpay_mb_id`", true);
}

?>

<form name="fconfig" action="./config_pgpayupdate.php" onsubmit="return fconfig_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="">

<!-- PG사 설정 { -->
<section id ="anc_scf_pg">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm">PG사 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>PG사 설정 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row">결제 테스트</th>
            <td>
                <?php echo help("PG사의 결제 테스트를 하실 경우에 체크하세요. 결제단위 최소 1,000원"); ?>
                <input type="radio" name="de_card_test" value="0" <?php echo $default['de_card_test']==0?"checked":""; ?> id="de_card_test1">
                <label for="de_card_test1">실결제 </label>
                <input type="radio" name="de_card_test" value="1" <?php echo $default['de_card_test']==1?"checked":""; ?> id="de_card_test2">
                <label for="de_card_test2">테스트결제</label>
                <div class="scf_cardtest kcp_cardtest">
                    <a href="http://admin.kcp.co.kr/" target="_blank" class="btn_frmline">실결제 관리자</a>
                    <a href="http://testadmin8.kcp.co.kr/" target="_blank" class="btn_frmline">테스트 관리자</a>
                </div>
                <div class="scf_cardtest lg_cardtest">
                    <a href="https://pgweb.uplus.co.kr/" target="_blank" class="btn_frmline">실결제 관리자</a>
                    <a href="https://pgweb.uplus.co.kr/tmert" target="_blank" class="btn_frmline">테스트 관리자</a>
                </div>
                <div class="scf_cardtest inicis_cardtest">
                    <a href="https://iniweb.inicis.com/" target="_blank" class="btn_frmline">상점 관리자</a>
                </div>
                <div id="scf_cardtest_tip">
                    <strong>일반결제 사용시 테스트 결제</strong>
                    <dl>
                        <dt>신용카드</dt><dd>1000원 이상, 모든 카드가 테스트 되는 것은 아니므로 여러가지 카드로 결제해 보셔야 합니다.<br>(BC, 현대, 롯데, 삼성카드)</dd>
                        <dt>계좌이체</dt><dd>150원 이상, 계좌번호, 비밀번호는 가짜로 입력해도 되며, 주민등록번호는 공인인증서의 것과 일치해야 합니다.</dd>
                        <dt>가상계좌</dt><dd>1원 이상, 모든 은행이 테스트 되는 것은 아니며 "해당 은행 계좌 없음" 자주 발생함.<br>(광주은행, 하나은행)</dd>
                        <dt>휴대폰</dt><dd>1004원, 실결제가 되며 다음날 새벽에 일괄 취소됨</dd>
                    </dl>
                    <strong>에스크로 사용시 테스트 결제</strong><br>
                    <dl>
                        <dt>신용카드</dt><dd>1000원 이상, 모든 카드가 테스트 되는 것은 아니므로 여러가지 카드로 결제해 보셔야 합니다.<br>(BC, 현대, 롯데, 삼성카드)</dd>
                        <dt>계좌이체</dt><dd>150원 이상, 계좌번호, 비밀번호는 가짜로 입력해도 되며, 주민등록번호는 공인인증서의 것과 일치해야 합니다.</dd>
                        <dt>가상계좌</dt><dd>1원 이상, 입금통보는 제대로 되지 않음.</dd>
                        <dt>휴대폰</dt><dd>테스트 지원되지 않음.</dd>
                    </dl>
                    <ul id="kcp_cardtest_tip" class="scf_cardtest_tip_adm scf_cardtest_tip_adm_hide">
                        <li>테스트결제의 <a href="http://testadmin8.kcp.co.kr/assist/login.LoginAction.do" target="_blank">상점관리자</a> 로그인 정보는 NHN KCP로 문의하시기 바랍니다. (기술지원 1544-8661)</li>
                        <li><b>일반결제</b>의 테스트 사이트코드는 <b>T0000</b> 이며, <b>에스크로 결제</b>의 테스트 사이트코드는 <b>T0007</b> 입니다.</li>
                    </ul>
                    <ul id="lg_cardtest_tip" class="scf_cardtest_tip_adm scf_cardtest_tip_adm_hide">
                        <li>테스트결제의 <a href="http://pgweb.dacom.net:7085/" target="_blank">상점관리자</a> 로그인 정보는 LG유플러스 상점아이디 첫 글자에 t를 추가해서 로그인하시기 바랍니다. 예) tsi_lguplus</li>
                    </ul>
                    <ul id="inicis_cardtest_tip" class="scf_cardtest_tip_adm scf_cardtest_tip_adm_hide">
                        <li><b>일반결제</b>의 테스트 사이트 mid는 <b>INIpayTest</b> 이며, <b>에스크로 결제</b>의 테스트 사이트 mid는 <b>iniescrow0</b> 입니다.</li>
                    </ul>
                </div>
            </td>
        </tr>
        <tr>
        <th scope="row">에스크로 사용</th>
            <td>
                <?php echo help("에스크로 결제를 사용하시려면, 반드시 결제대행사 상점 관리자 페이지에서 에스크로 서비스를 신청하신 후 사용하셔야 합니다.\n에스크로 사용시 배송과의 연동은 되지 않으며 에스크로 결제만 지원됩니다."); ?>
                    <input type="radio" name="de_escrow_use" value="0" <?php echo $default['de_escrow_use']==0?"checked":""; ?> id="de_escrow_use1">
                    <label for="de_escrow_use1">일반결제 사용</label>
                    <input type="radio" name="de_escrow_use" value="1"<?php echo $default['de_escrow_use']==1?"checked":""; ?> id="de_escrow_use2">
                    <label for="de_escrow_use2"> 에스크로결제 사용</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_tax_flag_use">복합과세 결제</label></th>
            <td>
                 <?php echo help("복합과세(과세, 비과세) 결제를 사용하려면 체크하십시오.\n복합과세 결제를 사용하기 전 PG사에 별도로 결제 신청을 해주셔야 합니다. 사용시 PG사로 문의하여 주시기 바랍니다."); ?>
                <label class="switch-check">
                <input type="checkbox" name="de_tax_flag_use" value="1" id="de_tax_flag_use"<?php echo $default['de_tax_flag_use']?' checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_pg_service">결제대행사</label></th>
            <td>
                <input type="hidden" name="de_pg_service" id="de_pg_service" value="<?php echo $default['de_pg_service']; ?>" >
                <?php echo help('쇼핑몰에서 사용할 결제대행사를 선택합니다.'); ?>
                <ul class="de_pg_tab">
                    <li class="<?php if($default['de_pg_service'] == 'kcp') echo 'tab-current'; ?>"><a href="#kcp_info_anchor" data-value="kcp" title="NHN KCP 선택하기" >NHN KCP</a></li>
                    <li class="<?php if($default['de_pg_service'] == 'lg') echo 'tab-current'; ?>"><a href="#lg_info_anchor" data-value="lg" title="LG유플러스 선택하기">LG유플러스</a></li>
                    <li class="<?php if($default['de_pg_service'] == 'inicis') echo 'tab-current'; ?>"><a href="#inicis_info_anchor" data-value="inicis" title="KG이니시스 선택하기">KG이니시스</a></li>
                </ul>
            </td>
        </tr>
        <tr>
            <th colspan="2" class="titletag">NHN KCP <a href="http://sir.kr/main/service/p_pg.php" target="_blank" id="scf_kcpreg" class="kcp_btn pull-right">NHN KCP서비스신청하기</a></th>
        </tr>
        <tr class="pg_info_fld kcp_info_fld" id="kcp_info_anchor">
            <th scope="row">
                <label for="de_kcp_mid">KCP SITE CODE</label>
            </th>
            <td>
                <?php echo help("NHN KCP 에서 받은 SR 로 시작하는 영대문자, 숫자 혼용 총 5자리 중 SR 을 제외한 나머지 3자리 SITE CODE 를 입력하세요.\n만약, 사이트코드가 SR로 시작하지 않는다면 NHN KCP에 사이트코드 변경 요청을 하십시오. 예) SR9A3"); ?>
                <span class="sitecode">SR</span> <input type="text" name="de_kcp_mid" value="<?php echo $default['de_kcp_mid']; ?>" id="de_kcp_mid" class="frm_input pg_input" size="2" maxlength="3"> 영대문자, 숫자 혼용 3자리
            </td>
        </tr>
        <tr class="pg_info_fld kcp_info_fld">
            <th scope="row"><label for="de_kcp_site_key">NHN KCP SITE KEY</label></th>
            <td>
                <?php echo help("25자리 영대소문자와 숫자 - 그리고 _ 로 이루어 집니다. SITE KEY 발급 NHN KCP 전화: 1544-8660\n예) 1Q9YRV83gz6TukH8PjH0xFf__"); ?>
                <input type="text" name="de_kcp_site_key" value="<?php echo $default['de_kcp_site_key']; ?>" id="de_kcp_site_key" class="frm_input w100per" maxlength="25">
            </td>
        </tr>
        <tr>
            <th colspan="2" class="titletag">LG U+ <a href="http://sir.kr/main/service/lg_pg.php" target="_blank" id="scf_lgreg" class="lg_btn pull-right">LG유플러스 서비스신청하기</a></th>
        </tr>
        <tr class="pg_info_fld lg_info_fld" id="lg_info_anchor">
            <th scope="row">
                <label for="cf_lg_mid">LG유플러스 상점아이디</label>
            </th>
            <td>
                <?php echo help("LG유플러스에서 받은 si_ 로 시작하는 상점 ID를 입력하세요.\n만약, 상점 ID가 si_로 시작하지 않는다면 LG유플러스에 사이트코드 변경 요청을 하십시오. 예) si_lguplus\n<a href=\"".G5_ADMIN_URL."/config_form.php#anc_cf_cert\">기본환경설정 &gt; 본인확인</a> 설정의 LG유플러스 상점아이디와 동일합니다."); ?>
                <span class="sitecode">si_</span> <input type="text" name="cf_lg_mid" value="<?php echo $config['cf_lg_mid']; ?>" id="cf_lg_mid" class="frm_input pg_input" size="10" maxlength="20"> 영문자, 숫자 혼용
            </td>
        </tr>
        <tr class="pg_info_fld lg_info_fld">
            <th scope="row"><label for="cf_lg_mert_key">LG유플러스 MERT KEY</label></th>
            <td>
                <?php echo help("LG유플러스 상점MertKey는 상점관리자 -> 계약정보 -> 상점정보관리에서 확인하실 수 있습니다.\n예) 95160cce09854ef44d2edb2bfb05f9f3\n<a href=\"".G5_ADMIN_URL."/config_form.php#anc_cf_cert\">기본환경설정 &gt; 본인확인</a> 설정의 LG유플러스 MERT KEY와 동일합니다."); ?>
                <input type="text" name="cf_lg_mert_key" value="<?php echo $config['cf_lg_mert_key']; ?>" id="cf_lg_mert_key" class="frm_input w100per" maxlength="50">
            </td>
        </tr>
        <tr>
            <th colspan="2" class="titletag">KG 이니시스 <a href="http://sir.kr/main/service/inicis_pg.php" target="_blank" id="scf_lgreg" class="kg_btn pull-right">KG이니시스 서비스신청하기</a></th>
        </tr>
        <tr class="pg_info_fld inicis_info_fld" id="inicis_info_anchor">
            <th scope="row">
                <label for="de_inicis_mid">KG이니시스 상점아이디</label>
            </th>
            <td>
                <?php echo help("KG이니시스로 부터 발급 받으신 상점아이디(MID) 10자리 중 SIR 을 제외한 나머지 7자리를 입력 합니다.\n만약, 상점아이디가 SIR로 시작하지 않는다면 계약담당자에게 변경 요청을 해주시기 바랍니다. (Tel. 02-3430-5858) 예) SIRpaytest"); ?>
                <span class="sitecode">SIR</span> <input type="text" name="de_inicis_mid" value="<?php echo $default['de_inicis_mid']; ?>" id="de_inicis_mid" class="frm_input pg_input" size="10" maxlength="10"> 영문소문자(숫자포함 가능)
            </td>
        </tr>
        <tr class="pg_info_fld inicis_info_fld">
            <th scope="row"><label for="de_inicis_admin_key">KG이니시스 키패스워드</label></th>
            <td>
                <?php echo help("KG이니시스에서 발급받은 4자리 상점 키패스워드를 입력합니다.\nKG이니시스 상점관리자 패스워드와 관련이 없습니다.\n키패스워드 값을 확인하시려면 상점측에 발급된 키파일 안의 readme.txt 파일을 참조해 주십시오"); ?>
                <input type="text" name="de_inicis_admin_key" value="<?php echo $default['de_inicis_admin_key']; ?>" id="de_inicis_admin_key" class="frm_input" size="5" maxlength="4">
            </td>
        </tr>
        <tr class="pg_info_fld inicis_info_fld">
            <th scope="row"><label for="de_inicis_sign_key">KG이니시스 웹결제 사인키</label></th>
            <td>
                <?php echo help("KG이니시스에서 발급받은 웹결제 사인키를 입력합니다.\n관리자 페이지의 상점정보 > 계약정보 > 부가정보의 웹결제 signkey생성 조회 버튼 클릭, 팝업창에서 생성 버튼 클릭 후 해당 값을 입력합니다."); ?>
                <input type="text" name="de_inicis_sign_key" value="<?php echo $default['de_inicis_sign_key']; ?>" id="de_inicis_sign_key" class="frm_input w100per" maxlength="50">
            </td>
        </tr>
        <tr class="pg_info_fld inicis_info_fld">
            <th scope="row">
                <label for="de_inicis_cartpoint_use">KG이니시스 신용카드 포인트 결제</label>
            </th>
            <td>
                <?php echo help("신용카드 포인트 결제에 대해 이니시스와 계약을 맺은 상점에서만 적용하는 옵션입니다.<br>체크시 pc 결제에서는 신용카드 포인트 사용 여부에 대한 팝업창에 사용 버튼과 사용안함 버튼이 표기되어 결제하는 고객의 선택여부에 따라 신용카드 포인트 결제가 가능합니다.<br >모바일에서는 신용카드 포인트 사용이 가능합니다.", 50); ?>
                <label class="switch-check">
                <input type="checkbox" name="de_inicis_cartpoint_use" value="1" id="de_inicis_cartpoint_use"<?php echo $default['de_inicis_cartpoint_use']?' checked':''; ?>>
                <div class="check-slider round"></div>
                </label>
                <label for="de_inicis_cartpoint_use">신용카드 포인트결제 사용</label>
            </td>
        </tr>
        </tbody>
        </table>
        <script>
        $('#scf_cardtest_tip').addClass('scf_cardtest_tip');
        $('<button type="button" class="scf_cardtest_btn btn_frmline">테스트결제 팁 더보기</button>').appendTo('.scf_cardtest');

        $(".scf_cardtest").addClass("scf_cardtest_hide");
        $(".<?php echo $default['de_pg_service']; ?>_cardtest").removeClass("scf_cardtest_hide");
        $("#<?php echo $default['de_pg_service']; ?>_cardtest_tip").removeClass("scf_cardtest_tip_adm_hide");
        </script>
    </div>
</section>

<?php echo $frm_submit; ?>
<!--//-->

<!-- KG이니시스 간편페이 (삼성페이/엘페이) 설정 -->
<section id ="anc_scf_kgpay">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm">KG이니시스 간편페이 설정</h2>
    <div class="local_desc02 local_desc">
		<p>삼성페이(SAMSUNG PAY)와 엘페이(L.PAY)는 <strong>PG사를 KG이니시스로 사용시 추가로 신청할 수 있는 간편페이</strong> 입니다.</p>
        <p>PG사 정보에 KG이니시스 상점아이디,키페스워드,웹결제사인키가 등록되었는지 확인하세요.</p>
    </div>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>KG이니시스 간편페이 설정 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <!-- 삼성페이 -->
        <tr>
            <th colspan="2" class="titletag">SAMSUNG PAY <a href="http://sir.kr/main/service/samsungpay.php" target="_blank" class="kg_btn pull-right">삼성페이 서비스신청하기</a></th>
        </tr>
        <tr class="pg_info_fld inicis_info_fld">
            <th scope="row">
                <label for="de_samsung_pay_use">KG이니시스 삼성페이 사용</label>
            </th>
            <td>
                <?php echo help("체크시 KG이니시스 삼성페이를 사용합니다. <br >실결제시 반드시 결제대행사 KG이니시스 항목에 상점 아이디와 키패스워드를 입력해 주세요.", 50); ?>
                <label class="switch-check">
                <input type="checkbox" name="de_samsung_pay_use" value="1" id="de_samsung_pay_use"<?php echo $default['de_samsung_pay_use']?' checked':''; ?>>
                <div class="check-slider round"></div>
                </label>
                <label for="de_samsung_pay_use">삼성페이 사용</label>
            </td>
        </tr>
        <!-- L.PAY -->
        <tr>
            <th colspan="2" class="titletag">L.PAY</th>
        </tr>
        <tr class="pg_info_fld inicis_info_fld">
            <th scope="row">
                <label for="de_inicis_lpay_use">KG이니시스 L.pay</label>
            </th>
            <td>
                <?php echo help("체크시 KG이니시스 L.pay를 사용합니다. <br >실결제시 반드시 결제대행사 KG이니시스 항목의 상점 정보( 아이디, 키패스워드, 웹결제 사인키 )를 입력해 주세요.", 50); ?>
                <label class="switch-check">
                <input type="checkbox" name="de_inicis_lpay_use" value="1" id="de_inicis_lpay_use"<?php echo $default['de_inicis_lpay_use']?' checked':''; ?>>
                <div class="check-slider round"></div>
                </label>
                <label for="de_inicis_lpay_use">L.pay사용</label>
            </td>
        </tr>
        <!--//-->
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!--//-->

<!-- 카카오페이 설정 -->
<section id ="anc_scf_kakao">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm">카카오페이 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>카카오페이 설정 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th colspan="2" class="titletag">KAKAO PAY <a href="http://sir.kr/main/service/kakaopay.php" target="_blank" class="kakao_btn pull-right">카카오페이 서비스신청하기</a></th>
        </tr>
        <tr class="kakao_info_fld">
            <th scope="row">
                <label for="de_kakaopay_mid">카카오페이 상점MID</label>
            </th>
            <td>
                <?php echo help("카카오페이로 부터 발급 받으신 상점아이디(MID) 10자리 중 첫 KHSIR과 끝 m 을 제외한 영문4자리를 입력 합니다. 예) KHSIRtestm"); ?>
                <span class="sitecode">KHSIR</span> <input type="text" name="de_kakaopay_mid" value="<?php echo $default['de_kakaopay_mid']; ?>" id="de_kakaopay_mid" class="frm_input" size="5" maxlength="4"> <span class="sitecode">m</span>
            </td>
        </tr>
        <tr class="kakao_info_fld">
            <th scope="row"><label for="de_kakaopay_key">카카오페이 상점키</label></th>
            <td>
                <?php echo help("카카오페이로 부터 발급 받으신 상점 서명키를 입력합니다."); ?>
                <input type="text" name="de_kakaopay_key" value="<?php echo $default['de_kakaopay_key']; ?>" id="de_kakaopay_key" class="frm_input w100per">
            </td>
        </tr>
        <tr class="kakao_info_fld">
            <th scope="row"><label for="de_kakaopay_enckey">카카오페이 상점 EncKey</label></th>
            <td>
                <?php echo help("카카오페이로 부터 발급 받으신 상점 인증 전용 EncKey를 입력합니다."); ?>
                <input type="text" name="de_kakaopay_enckey" value="<?php echo $default['de_kakaopay_enckey']; ?>" id="de_kakaopay_enckey" class="frm_input w100per">
            </td>
        </tr>
        <tr class="kakao_info_fld">
            <th scope="row"><label for="de_kakaopay_hashkey">카카오페이 상점 HashKey</label></th>
            <td>
                <?php echo help("카카오페이로 부터 발급 받으신 상점 인증 전용 HashKey를 입력합니다."); ?>
                <input type="text" name="de_kakaopay_hashkey" value="<?php echo $default['de_kakaopay_hashkey']; ?>" id="de_kakaopay_hashkey" class="frm_input w100per">
            </td>
        </tr>
        <tr class="kakao_info_fld">
            <th scope="row"><label for="de_kakaopay_cancelpwd">카카오페이 결제취소 비밀번호</label></th>
            <td>
                <?php echo help("카카오페이 상점관리자에서 설정하신 취소 비밀번호를 입력합니다.<br>입력하신 비밀번호와 상점관리자에서 설정하신 비밀번호가 일치하지 않으면 취소가 되지 않습니다."); ?>
                <input type="text" name="de_kakaopay_cancelpwd" value="<?php echo $default['de_kakaopay_cancelpwd']; ?>" id="de_kakaopay_cancelpwd" class="frm_input w100per">
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!--//-->


<!-- 네이버페이 설정 -->
<section id ="anc_scf_npay">
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm">네이버페이 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>네이버페이 설정 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th colspan="2" class="titletag">NAVER PAY <a href="http://sir.kr/main/service/naverpay.php" target="_blank" class="naver_btn pull-right">네이버페이 서비스신청하기</a></th>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row">
                <label for="de_naverpay_mid">네이버페이 가맹점 아이디</label>
            </th>
            <td>
                <?php echo help("네이버페이 가맹점 아이디를 입력합니다."); ?>
                <input type="text" name="de_naverpay_mid" value="<?php echo $default['de_naverpay_mid']; ?>" id="de_naverpay_mid" class="frm_input w100per" maxlength="50">
             </td>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row">
                <label for="de_naverpay_cert_key">네이버페이 가맹점 인증키</label>
            </th>
            <td>
                <?php echo help("네이버페이 가맹점 인증키를 입력합니다."); ?>
                <input type="text" name="de_naverpay_cert_key" value="<?php echo $default['de_naverpay_cert_key']; ?>" id="de_naverpay_cert_key" class="frm_input w100per" maxlength="100">
             </td>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row">
                <label for="de_naverpay_button_key">네이버페이 버튼 인증키</label>
            </th>
            <td>
                <?php echo help("네이버페이 버튼 인증키를 입력합니다."); ?>
                <input type="text" name="de_naverpay_button_key" value="<?php echo $default['de_naverpay_button_key']; ?>" id="de_naverpay_button_key" class="frm_input w100per" maxlength="100">
             </td>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row"><label for="de_naverpay_test">네이버페이 결제테스트</label></th>
            <td>
                <?php echo help("네이버페이 결제테스트 여부를 설정합니다. 검수 과정 중에는 <strong>예</strong>로 설정해야 하며 최종 승인 후 <strong>아니오</strong>로 설정합니다."); ?>
                <select id="de_naverpay_test" name="de_naverpay_test">
                    <option value="1" <?php echo get_selected($default['de_naverpay_test'], 1); ?>>예</option>
                    <option value="0" <?php echo get_selected($default['de_naverpay_test'], 0); ?>>아니오</option>
                </select>
            </td>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row">
                <label for="de_naverpay_mb_id">네이버페이 결제테스트 아이디</label>
            </th>
            <td>
                <?php echo help("네이버페이 결제테스트를 위한 테스트 회원 아이디를 입력합니다. 네이버페이 검수 과정에서 필요합니다."); ?>
                <input type="text" name="de_naverpay_mb_id" value="<?php echo $default['de_naverpay_mb_id']; ?>" id="de_naverpay_mb_id" class="frm_input" size="10" maxlength="20">
             </td>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row">네이버페이 상품정보 XML URL</th>
            <td>
                <?php echo help("네이버페이에 상품정보를 XML 데이터로 제공하는 페이지입니다. 검수과정에서 아래의 URL 정보를 제공해야 합니다."); ?>
                <?php echo G5_SHOP_URL; ?>/naverpay/naverpay_item.php
             </td>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row">
                <label for="de_naverpay_sendcost">네이버페이 추가배송비 안내</label>
            </th>
            <td>
                <?php echo help("네이버페이를 통한 결제 때 구매자에게 보여질 추가배송비 내용을 입력합니다.<br>예) 제주도 3,000원 추가, 제주도 외 도서·산간 지역 5,000원 추가"); ?>
                <input type="text" name="de_naverpay_sendcost" value="<?php echo $default['de_naverpay_sendcost']; ?>" id="de_naverpay_sendcost" class="frm_input w100per">
             </td>
        </tr>

        <?php
        // wetoz : naverpayorder
        include_once(G5_PLUGIN_PATH.'/wznaverpay/config.php');

        // 네이버페이 주문 임시 정보
        if(!sql_query(" DESCRIBE {$g5['g5_shop_cart_naverpay_table']} ", false)) {
        sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['g5_shop_cart_naverpay_table']}` (
                    `ct_id` INT(11) NOT NULL AUTO_INCREMENT,
                    `MallManageCode` VARCHAR(20) NOT NULL DEFAULT '',
                    `mb_id` VARCHAR(255) NOT NULL DEFAULT '',
                    `it_id` VARCHAR(20) NOT NULL DEFAULT '',
                    `it_name` VARCHAR(255) NOT NULL DEFAULT '',
                    `it_sc_type` TINYINT(4) NOT NULL DEFAULT '0',
                    `it_sc_method` TINYINT(4) NOT NULL DEFAULT '0',
                    `it_sc_price` INT(11) NOT NULL DEFAULT '0',
                    `it_sc_minimum` INT(11) NOT NULL DEFAULT '0',
                    `it_sc_qty` INT(11) NOT NULL DEFAULT '0',
                    `ct_price` INT(11) NOT NULL DEFAULT '0',
                    `ct_point` INT(11) NOT NULL DEFAULT '0',
                    `ct_point_use` TINYINT(4) NOT NULL DEFAULT '0',
                    `ct_stock_use` TINYINT(4) NOT NULL DEFAULT '0',
                    `ct_option` VARCHAR(255) NOT NULL DEFAULT '',
                    `ct_qty` INT(11) NOT NULL DEFAULT '0',
                    `ct_notax` TINYINT(4) NOT NULL DEFAULT '0',
                    `io_id` VARCHAR(255) NOT NULL DEFAULT '',
                    `io_type` TINYINT(4) NOT NULL DEFAULT '0',
                    `io_price` INT(11) NOT NULL DEFAULT '0',
                    `ct_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
                    `ct_ip` VARCHAR(25) NOT NULL DEFAULT '',
                    `ct_send_cost` TINYINT(4) NOT NULL DEFAULT '0',
                    `ct_select` TINYINT(4) NOT NULL DEFAULT '0',
                    `ct_select_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
                    `s_cart_id` BIGINT(20) NOT NULL DEFAULT '0',
                    PRIMARY KEY (`ct_id`),
                    INDEX `od_id` (`MallManageCode`)
                )
                COMMENT='네이버페이주문장바구니'
                ENGINE=MyISAM  DEFAULT CHARSET=utf8;", true);
        }

        // 장바구니 테이블에 네이버페이 상품 주문 번호 필드 추가
        $query = "show columns from `{$g5['g5_shop_order_table']}` like 'od_naver_orderid' ";
        $res = sql_fetch($query);
        if (empty($res)) {
            sql_query(" ALTER TABLE `{$g5['g5_shop_order_table']}`
                            ADD `od_naver_orderid` varchar(20) NOT NULL default ''
                            ; ", true);
        }

        // 사용후기 테이블에 네이버페이 관련 필드 추가
        $query = "show columns from `{$g5['g5_shop_item_use_table']}` like 'is_purchasereviewid' ";
        $res = sql_fetch($query);
        if (empty($res)) {
            sql_query(" ALTER TABLE `{$g5['g5_shop_item_use_table']}`
                            ADD `is_purchasereviewid` varchar(20) NOT NULL default '',
                            ADD `is_productorderid` varchar(20) NOT NULL default ''
                            ; ", true);
        }

        // 상품문의 테이블에 네이버페이 관련 필드 추가
        $query = "show columns from `{$g5['g5_shop_item_qa_table']}` like 'iq_inquiryid' ";
        $res = sql_fetch($query);
        if (empty($res)) {
            sql_query(" ALTER TABLE `{$g5['g5_shop_item_qa_table']}`
                            ADD `iq_inquiryid` varchar(20) NOT NULL default '',
                            ADD `iq_answercontentid` varchar(20) NOT NULL default '',
                            ADD `iq_productorderid` varchar(20) NOT NULL default '',
                            ADD `iq_orderid` varchar(20) NOT NULL default ''
                            ; ", true);
        }

        // 장바구니 테이블에 네이버페이 상품 주문 번호 필드 추가
        $query = "show columns from `{$g5['g5_shop_cart_table']}` like 'ProductOrderID' ";
        $res = sql_fetch($query);
        if (empty($res)) {
            sql_query(" ALTER TABLE `{$g5['g5_shop_cart_table']}`
                            ADD `ProductOrderID` varchar(20) NOT NULL default '',
                            ADD `ClaimType` varchar(30) NOT NULL default '',
                            ADD `ClaimStatus` varchar(30) NOT NULL default '',
                            ADD `PlaceOrderStatus` varchar(30) NOT NULL default '',
                            ADD `DelayedDispatchReason` varchar(30) NOT NULL default '',
                            ADD INDEX `ProductOrderID` (`ProductOrderID`)
                            ; ", true);
        }

        // 라이센스키 필드추가
        if(!isset($default['de_naverpayorder_AccessLicense'])) {
            sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                            ADD `de_naverpayorder_AccessLicense` varchar(100) NOT NULL DEFAULT '',
                            ADD `de_naverpayorder_SecretKey` varchar(100) NOT NULL DEFAULT '',
                            ADD `de_naverpayorder_test` TINYINT(4) NOT NULL DEFAULT '0'
                            ", true);
        }

        // wetoz : 2019-02-26 : 구버전 적용
        $query = "show columns from `{$g5['g5_shop_order_table']}` like 'od_test' ";
        $res = sql_fetch($query);
        if (empty($res)) {
            sql_query(" ALTER TABLE `{$g5['g5_shop_order_table']}`
                            ADD `od_test` tinyint(4) NOT NULL default '0'
                            ; ", true);
        }
        $query = "show columns from `{$g5['g5_shop_cart_table']}` like 'ct_select_time' ";
        $res = sql_fetch($query);
        if (empty($res)) {
            sql_query(" ALTER TABLE `{$g5['g5_shop_cart_table']}`
                            ADD `ct_select_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
                            ; ", true);
        }
        if(!isset($default['de_naverpayorder_test_mb_id'])) {
            sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                            ADD `de_naverpayorder_test_mb_id` varchar(20) NOT NULL DEFAULT ''
                            ", true);
        }
        $query = "show columns from `{$g5['g5_shop_order_table']}` like 'od_naver_sync_time' ";
        $res = sql_fetch($query);
        if (empty($res)) {
            sql_query(" ALTER TABLE `{$g5['g5_shop_order_table']}`
                            ADD `od_naver_sync_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'
                            ; ", true);
        }
        ?>
        <tr class="naver_info_fld">
            <th scope="row"><label for="de_naverpayorder_AccessLicense">네이버페이 주문연동 AccessLicense</label></th>
            <td>
                <?php echo help("액세스 라이센스문서 를 통해서 확인된 AccessLicense 키를 입력해주세요."); ?>
                <input type="text" name="de_naverpayorder_AccessLicense" value="<?php echo $default['de_naverpayorder_AccessLicense']; ?>" id="de_naverpayorder_AccessLicense" class="frm_input" size="40" maxlength="100">
            </td>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row"><label for="de_naverpayorder_SecretKey">네이버페이 주문연동 SecretKey</label></th>
            <td>
                <?php echo help("액세스 라이센스문서 를 통해서 확인된 SecretKey 키를 입력해주세요."); ?>
                <input type="password" name="de_naverpayorder_SecretKey" value="<?php echo $default['de_naverpayorder_SecretKey']; ?>" id="de_naverpayorder_SecretKey" class="frm_input" size="20" maxlength="100">
            </td>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row"><label for="de_naverpayorder_test">네이버페이 주문연동 API테스트</label></th>
            <td>
                <?php echo help("네이버페이 주문 API 테스트 여부를 설정합니다. 검수 과정 중에는 <strong>예</strong>로 설정해야 하며 최종 승인 후 <strong>아니오</strong>로 설정합니다."); ?>
                <select id="de_naverpayorder_test" name="de_naverpayorder_test">
                    <option value="1" <?php echo get_selected($default['de_naverpayorder_test'], 1); ?>>예</option>
                    <option value="0" <?php echo get_selected($default['de_naverpayorder_test'], 0); ?>>아니오</option>
                </select>
            </td>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row"><label for="de_naverpayorder_test_mb_id">네이버페이 주문 테스트용 아이디</label></th>
            <td>
                <?php echo help("네이버페이 주문 테스트용 아이디는 네이버페이 주문시 실결제가 아닌 테스트용 주문으로 들어가며 최초 API 주문연동 검수처리진행시 유용합니다."); ?>
                <input type="text" name="de_naverpayorder_test_mb_id" value="<?php echo $default['de_naverpayorder_test_mb_id']; ?>" id="de_naverpayorder_test_mb_id" class="frm_input" size="20" maxlength="20">
            </td>
        </tr>
        <!-- // wetoz : naverpayorder  -->

        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!-- // -->

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">
    <div class="bq_basic_icon">
    <a href="<?php echo G5_SHOP_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/shop_icon.png" border="0" title="쇼핑몰">&nbsp;&nbsp;</a>
    </div>

    <div class="bq_basic_submit">
    <input type="submit" value="확인" accesskey="s">
    </div>

</div>
<!--//-->
</form>

<script>
$(function() {
    //$(".pg_info_fld").hide();
    $(".pg_vbank_url").hide();
    <?php if($default['de_pg_service']) { ?>
    //$(".<?php echo $default['de_pg_service']; ?>_info_fld").show();
    $("#<?php echo $default['de_pg_service']; ?>_vbank_url").show();
    <?php } else { ?>
    $(".kcp_info_fld").show();
    $("#kcp_vbank_url").show();
    <?php } ?>
    $(".de_pg_tab").on("click", "a", function(e){

        var pg = $(this).attr("data-value"),
            class_name = "tab-current";

        $("#de_pg_service").val(pg);
        $(this).parent("li").addClass(class_name).siblings().removeClass(class_name);

        //$(".pg_info_fld:visible").hide();
        $(".pg_vbank_url:visible").hide();
        //$("."+pg+"_info_fld").show();
        $("#"+pg+"_vbank_url").show();
        $(".scf_cardtest").addClass("scf_cardtest_hide");
        $("."+pg+"_cardtest").removeClass("scf_cardtest_hide");
        $(".scf_cardtest_tip_adm").addClass("scf_cardtest_tip_adm_hide");
        $("#"+pg+"_cardtest_tip").removeClass("scf_cardtest_tip_adm_hide");
    });

    $("#de_pg_service").on("change", function() {
        var pg = $(this).val();
        $(".pg_info_fld:visible").hide();
        $(".pg_vbank_url:visible").hide();
        $("."+pg+"_info_fld").show();
        $("#"+pg+"_vbank_url").show();
        $(".scf_cardtest").addClass("scf_cardtest_hide");
        $("."+pg+"_cardtest").removeClass("scf_cardtest_hide");
        $(".scf_cardtest_tip_adm").addClass("scf_cardtest_tip_adm_hide");
        $("#"+pg+"_cardtest_tip").removeClass("scf_cardtest_tip_adm_hide");
    });

    $(".scf_cardtest_btn").bind("click", function() {
        var $cf_cardtest_tip = $("#scf_cardtest_tip");
        var $cf_cardtest_btn = $(".scf_cardtest_btn");

        $cf_cardtest_tip.toggle();

        if($cf_cardtest_tip.is(":visible")) {
            $cf_cardtest_btn.text("테스트결제 팁 닫기");
        } else {
            $cf_cardtest_btn.text("테스트결제 팁 더보기");
        }
    });

    $(".get_shop_skin").on("click", function() {
        if(!confirm("현재 테마의 쇼핑몰 스킨 설정을 적용하시겠습니까?"))
            return false;

        $.ajax({
            type: "POST",
            url: "../theme_config_load.php",
            cache: false,
            async: false,
            data: { type: "shop_skin" },
            dataType: "json",
            success: function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                var field = Array('de_shop_skin', 'de_shop_mobile_skin');
                var count = field.length;
                var key;

                for(i=0; i<count; i++) {
                    key = field[i];

                    if(data[key] != undefined && data[key] != "")
                        $("select[name="+key+"]").val(data[key]);
                }
            }
        });
    });

    $(".shop_pc_index, .shop_mobile_index, .shop_etc").on("click", function() {
        if(!confirm("현재 테마의 스킨, 이미지 사이즈 등의 설정을 적용하시겠습니까?"))
            return false;

        var type = $(this).attr("class");
        var $el;

        $.ajax({
            type: "POST",
            url: "../theme_config_load.php",
            cache: false,
            async: false,
            data: { type: type },
            dataType: "json",
            success: function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                $.each(data, function(key, val) {
                    if(key == "error")
                        return true;

                    $el = $("#"+key);

                    if($el[0].type == "checkbox") {
                        $el.attr("checked", parseInt(val) ? true : false);
                        return true;
                    }
                    $el.val(val);
                });
            }
        });
    });
});
</script>

<?php
// 결제모듈 실행권한 체크
if($default['de_iche_use'] || $default['de_vbank_use'] || $default['de_hp_use'] || $default['de_card_use']) {
    // kcp의 경우 pp_cli 체크
    if($default['de_pg_service'] == 'kcp') {
        if(!extension_loaded('openssl')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("PHP openssl 확장모듈이 설치되어 있지 않습니다.\n모바일 쇼핑몰 결제 때 사용되오니 openssl 확장 모듈을 설치하여 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        if(!extension_loaded('soap') || !class_exists('SOAPClient')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("PHP SOAP 확장모듈이 설치되어 있지 않습니다.\n모바일 쇼핑몰 결제 때 사용되오니 SOAP 확장 모듈을 설치하여 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        $is_linux = true;
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            $is_linux = false;

        $exe = '/kcp/bin/';
        if($is_linux) {
            if(PHP_INT_MAX == 2147483647) // 32-bit
                $exe .= 'pp_cli';
            else
                $exe .= 'pp_cli_x64';
        } else {
            $exe .= 'pp_cli_exe.exe';
        }

        echo module_exec_check(G5_SHOP_PATH.$exe, 'pp_cli');

        // shop/kcp/log 디렉토리 체크 후 있으면 경고
        if(is_dir(G5_SHOP_PATH.'/kcp/log') && is_writable(G5_SHOP_PATH.'/kcp/log')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("웹접근 가능 경로에 log 디렉토리가 있습니다.\nlog 디렉토리를 웹에서 접근 불가능한 경로로 변경해 주십시오.\n\nlog 디렉토리 경로 변경은 SIR FAQ를 참고해 주세요.")'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }
    }

    // LG의 경우 log 디렉토리 체크
    if($default['de_pg_service'] == 'lg') {
        $log_path = G5_LGXPAY_PATH.'/lgdacom/log';

        if(!is_dir($log_path)) {
            echo '<script>'.PHP_EOL;
            echo 'alert("'.str_replace(G5_PATH.'/', '', G5_LGXPAY_PATH).'/lgdacom 폴더 안에 log 폴더를 생성하신 후 쓰기권한을 부여해 주십시오.\n> mkdir log\n> chmod 707 log");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        } else {
            if(!is_writable($log_path)) {
                echo '<script>'.PHP_EOL;
                echo 'alert("'.str_replace(G5_PATH.'/', '',$log_path).' 폴더에 쓰기권한을 부여해 주십시오.\n> chmod 707 log");'.PHP_EOL;
                echo '</script>'.PHP_EOL;
            }
        }
    }

    // 이니시스의 경우 log 디렉토리 체크
    if($default['de_pg_service'] == 'inicis') {
        if (!function_exists('xml_set_element_handler')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("XML 관련 함수를 사용할 수 없습니다.\n서버 관리자에게 문의해 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        if (!function_exists('openssl_get_publickey')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("OPENSSL 관련 함수를 사용할 수 없습니다.\n서버 관리자에게 문의해 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        if (!function_exists('socket_create')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("SOCKET 관련 함수를 사용할 수 없습니다.\n서버 관리자에게 문의해 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        if (!function_exists('mcrypt_module_open')) {
            echo '<script>'.PHP_EOL;
            echo 'alert("MCRYPT 관련 함수를 사용할 수 없습니다.\n서버 관리자에게 문의해 주십시오.");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }

        $log_path = G5_SHOP_PATH.'/inicis/log';

        if(!is_dir($log_path)) {
            echo '<script>'.PHP_EOL;
            echo 'alert("'.str_replace(G5_PATH.'/', '', G5_SHOP_PATH).'/inicis 폴더 안에 log 폴더를 생성하신 후 쓰기권한을 부여해 주십시오.\n> mkdir log\n> chmod 707 log");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        } else {
            if(!is_writable($log_path)) {
                echo '<script>'.PHP_EOL;
                echo 'alert("'.str_replace(G5_PATH.'/', '',$log_path).' 폴더에 쓰기권한을 부여해 주십시오.\n> chmod 707 log");'.PHP_EOL;
                echo '</script>'.PHP_EOL;
            }
        }
    }

    // 카카오페이의 경우 log 디렉토리 체크
    if($default['de_kakaopay_mid'] && $default['de_kakaopay_key'] && $default['de_kakaopay_enckey'] && $default['de_kakaopay_hashkey'] && $default['de_kakaopay_cancelpwd']) {
        $log_path = G5_SHOP_PATH.'/kakaopay/log';

        if(!is_dir($log_path)) {
            echo '<script>'.PHP_EOL;
            echo 'alert("'.str_replace(G5_PATH.'/', '', G5_SHOP_PATH).'/kakaopay 폴더 안에 log 폴더를 생성하신 후 쓰기권한을 부여해 주십시오.\n> mkdir log\n> chmod 707 log");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        } else {
            if(!is_writable($log_path)) {
                echo '<script>'.PHP_EOL;
                echo 'alert("'.str_replace(G5_PATH.'/', '',$log_path).' 폴더에 쓰기권한을 부여해 주십시오.\n> chmod 707 log");'.PHP_EOL;
                echo '</script>'.PHP_EOL;
            }
        }
    }
}
?>


<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
