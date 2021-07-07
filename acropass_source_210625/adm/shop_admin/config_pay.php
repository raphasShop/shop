<?php
$sub_menu = '111114'; /* (새로만듬)결제/적립설정 */
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '결제/적립금설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$pg_anchor = '<ul class="anchor">
<li><a href="#anc_scf_payment">결제설정</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';

// 무이자 할부 사용설정 필드 추가
if(!isset($default['de_card_noint_use'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_card_noint_use` tinyint(4) NOT NULL DEFAULT '0' AFTER `de_card_use` ", true);
}

// PG 간편결제 사용여부 필드 추가
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

<form name="fconfig" action="./config_payupdate.php" onsubmit="return fconfig_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="">

<!-- 결제설정 { -->
<section id ="anc_scf_payment">
    <?php// echo $pg_anchor; ?>
    <h2 class="h2_frm">결제 사용 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>결제설정 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="de_bank_use">무통장입금사용</label></th>
            <td>
                <?php echo help("주문시 무통장으로 입금을 가능하게 할것인지를 설정합니다.\n사용할 경우 은행계좌번호를 반드시 입력하여 주십시오.", 50); ?>
                <!--<select id="de_bank_use" name="de_bank_use">
                    <option value="0" <?php echo get_selected($default['de_bank_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_bank_use'], 1); ?>>사용</option>
                </select>-->
                <label class="switch-check">
                <input type="checkbox" name="de_bank_use" value="1" id="de_bank_use"<?php echo $default['de_bank_use']?' checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
                <label for="de_bank_use">무통장입금사용</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_bank_account"><img src="<?php echo G5_ADMIN_URL;?>/img/left-plus.gif" align="absmiddle"> 은행계좌번호</label></th>
            <td>
                <?php echo help("줄바꿈으로 한줄에 한개씩 기재하면, 여러개의 계좌번호를 등록할 수 있습니다. (은행명,계좌번호,예금주)", 50); ?>
                <textarea name="de_bank_account" id="de_bank_account"><?php echo $default['de_bank_account']; ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_iche_use">계좌이체 결제사용</label></th>
            <td>
            <?php echo help("주문시 실시간 계좌이체를 가능하게 할것인지를 설정합니다.", 50); ?>
                <!--<select id="de_iche_use" name="de_iche_use">
                    <option value="0" <?php echo get_selected($default['de_iche_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_iche_use'], 1); ?>>사용</option>
                </select>-->
                <label class="switch-check">
                <input type="checkbox" name="de_iche_use" value="1" id="de_iche_use"<?php echo $default['de_iche_use']?' checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
                <label for="de_iche_use">계좌이체결제사용</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_vbank_use">가상계좌 결제사용</label></th>
            <td>
                <?php echo help("주문별로 유일하게 생성되는 일회용 계좌번호입니다. 주문자가 가상계좌에 입금시 상점에 실시간으로 통보가 되므로 업무처리가 빨라집니다.", 50); ?>
                <!--<select name="de_vbank_use" id="de_vbank_use">
                    <option value="0" <?php echo get_selected($default['de_vbank_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_vbank_use'], 1); ?>>사용</option>
                </select>-->
                <label class="switch-check">
                <input type="checkbox" name="de_vbank_use" value="1" id="de_vbank_use"<?php echo $default['de_vbank_use']?' checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
                <label for="de_vbank_use">가상계좌결제사용</label>
            </td>
        </tr>
        <tr id="kcp_vbank_url" class="pg_vbank_url">
            <th scope="row">NHN KCP 가상계좌<br>입금통보 URL</th>
            <td>
                <?php echo help("NHN KCP 가상계좌 사용시 다음 주소를 <strong><a href=\"http://admin.kcp.co.kr\" target=\"_blank\">NHN KCP 관리자</a> &gt; 상점정보관리 &gt; 정보변경 &gt; 공통URL 정보 &gt; 공통URL 변경후</strong>에 넣으셔야 상점에 자동으로 입금 통보됩니다."); ?>
                <?php echo G5_SHOP_URL; ?>/settle_kcp_common.php</td>
        </tr>
        <tr id="inicis_vbank_url" class="pg_vbank_url">
            <th scope="row">KG이니시스 가상계좌 입금통보 URL</th>
            <td>
                <?php echo help("KG이니시스 가상계좌 사용시 다음 주소를 <strong><a href=\"https://iniweb.inicis.com/\" target=\"_blank\">KG이니시스 관리자</a> &gt; 거래조회 &gt; 가상계좌 &gt; 입금통보방식선택 &gt; URL 수신 설정</strong>에 넣으셔야 상점에 자동으로 입금 통보됩니다."); ?>
                <?php echo G5_SHOP_URL; ?>/settle_inicis_common.php</td>
        </tr>
        <tr>
            <th scope="row"><label for="de_hp_use">휴대폰결제사용</label></th>
            <td>
                <?php echo help("주문시 휴대폰 결제를 가능하게 할것인지를 설정합니다.", 50); ?>
                <!--<select id="de_hp_use" name="de_hp_use">
                    <option value="0" <?php echo get_selected($default['de_hp_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_hp_use'], 1); ?>>사용</option>
                </select>-->
                <label class="switch-check">
                <input type="checkbox" name="de_hp_use" value="1" id="de_hp_use"<?php echo $default['de_hp_use']?' checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
                <label for="de_hp_use">휴대폰결제사용</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_card_use">신용카드결제사용</label></th>
            <td>
                <?php echo help("주문시 신용카드 결제를 가능하게 할것인지를 설정합니다.", 50); ?>
                <!--<select id="de_card_use" name="de_card_use">
                    <option value="0" <?php echo get_selected($default['de_card_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_card_use'], 1); ?>>사용</option>
                </select>-->
                <label class="switch-check">
                <input type="checkbox" name="de_card_use" value="1" id="de_card_use"<?php echo $default['de_card_use']?' checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
                <label for="de_card_use">신용카드결제사용</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_card_noint_use">신용카드 무이자할부사용</label></th>
            <td>
                <?php echo help("주문시 신용카드 무이자할부를 가능하게 할것인지를 설정합니다.<br>사용으로 설정하시면 PG사 가맹점 관리자 페이지에서 설정하신 무이자할부 설정이 적용됩니다.<br>사용안함으로 설정하시면 PG사 무이자 이벤트 카드를 제외한 모든 카드의 무이자 설정이 적용되지 않습니다.", 50); ?>
                <!--<select id="de_card_noint_use" name="de_card_noint_use">
                    <option value="0" <?php echo get_selected($default['de_card_noint_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_card_noint_use'], 1); ?>>사용</option>
                </select>-->
                <label class="switch-check">
                <input type="checkbox" name="de_card_noint_use" value="1" id="de_card_noint_use"<?php echo $default['de_card_noint_use']?' checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
                <label for="de_card_noint_use">신용카드결제사용</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_easy_pay_use">PG사 간편결제 버튼 사용</label></th>
            <td>
                <?php echo help("주문서 작성 페이지에 PG사 간편결제(PAYCO, PAYNOW, KPAY) 버튼의 별도 사용 여부를 설정합니다.", 50); ?>
                <!--<select id="de_easy_pay_use" name="de_easy_pay_use">
                    <option value="0" <?php echo get_selected($default['de_easy_pay_use'], 0); ?>>노출안함</option>
                    <option value="1" <?php echo get_selected($default['de_easy_pay_use'], 1); ?>>노출함</option>
                </select>-->
                <label class="switch-check">
                <input type="checkbox" name="de_easy_pay_use" value="1" id="de_easy_pay_use"<?php echo $default['de_easy_pay_use']?' checked':''; ?>> 노출
                <div class="check-slider round"></div>
                </label>
                <label for="de_easy_pay_use">간편결제 버튼 노출</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_taxsave_use">현금영수증<br>발급사용</label></th>
            <td>
                <?php echo help("관리자는 설정에 관계없이 <a href=\"".G5_ADMIN_URL."/shop_admin/orderlist.php\">주문내역</a> &gt; 보기에서 발급이 가능합니다.\n현금영수증 발급 취소는 PG사에서 지원하는 현금영수증 취소 기능을 사용하시기 바랍니다.", 50); ?>
                <!--<select id="de_taxsave_use" name="de_taxsave_use">
                    <option value="0" <?php echo get_selected($default['de_taxsave_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_taxsave_use'], 1); ?>>사용</option>
                </select>-->
                <label class="switch-check">
                <input type="checkbox" name="de_taxsave_use" value="1" id="de_taxsave_use"<?php echo $default['de_taxsave_use']?' checked':''; ?>> 노출
                <div class="check-slider round"></div>
                </label>
                <label for="de_taxsave_use">현금영수증발급사용</label>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!-- // -->

<!-- 결제설정 { -->
<section id ="anc_scf_point">
    <?php// echo $pg_anchor; ?>
    <h2 class="h2_frm">적립금 포인트 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>적립금 포인트 설정 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_use_point">포인트 사용</label></th>
            <td>
                <?php echo help("<a href=\"".G5_ADMIN_URL."/config_form.php#frm_board\" target=\"_blank\">환경설정 &gt; 기본환경설정</a>과 동일한 설정입니다."); ?>
                <label class="switch-check">
                <input type="checkbox" name="cf_use_point" value="1" id="cf_use_point"<?php echo $config['cf_use_point']?' checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
                <label for="cf_use_point">포인트 사용</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_settle_min_point">결제 최소포인트</label></th>
            <td>
                <?php echo help("회원의 포인트가 설정값 이상일 경우만 주문시 결제에 사용할 수 있습니다.\n포인트 사용을 하지 않는 경우에는 의미가 없습니다."); ?>
                <input type="text" name="de_settle_min_point" value="<?php echo $default['de_settle_min_point']; ?>" id="de_settle_min_point" class="frm_input" size="10"> 점
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_settle_max_point">최대 결제포인트</label></th>
            <td>
                <?php echo help("주문 결제시 최대로 사용할 수 있는 포인트를 설정합니다.\n포인트 사용을 하지 않는 경우에는 의미가 없습니다."); ?>
                <input type="text" name="de_settle_max_point" value="<?php echo $default['de_settle_max_point']; ?>" id="de_settle_max_point" class="frm_input" size="10"> 점
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_settle_point_unit">결제 포인트단위</label></th>
            <td>
                <?php echo help("주문 결제시 사용되는 포인트의 절사 단위를 설정합니다."); ?>
                <select id="de_settle_point_unit" name="de_settle_point_unit">
                    <option value="100" <?php echo get_selected($default['de_settle_point_unit'], 100); ?>>100</option>
                    <option value="10"  <?php echo get_selected($default['de_settle_point_unit'],  10); ?>>10</option>
                    <option value="1"   <?php echo get_selected($default['de_settle_point_unit'],   1); ?>>1</option>
                </select> 점
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_card_point">포인트부여</label></th>
            <td>
                <?php echo help("신용카드, 계좌이체, 휴대폰 결제시 포인트를 부여할지를 설정합니다. (기본값은 '아니오')"); ?>
                <!--<select id="de_card_point" name="de_card_point">
                    <option value="0" <?php echo get_selected($default['de_card_point'], 0); ?>>아니오</option>
                    <option value="1" <?php echo get_selected($default['de_card_point'], 1); ?>>예</option>
                </select>-->
                <label class="switch-check">
                <input type="checkbox" name="de_card_point" value="1" id="de_card_point"<?php echo $default['de_card_point']?' checked':''; ?>> 노출
                <div class="check-slider round"></div>
                </label>
                <label for="de_card_point">포인트부여</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_point_days">주문완료 포인트</label></th>
            <td>
                <?php echo help("주문자가 회원일 경우에만 주문완료시 포인트를 지급합니다. 주문취소, 반품 등을 고려하여 포인트를 지급할 적당한 기간을 입력하십시오. (기본값은 7일)\n0일로 설정하는 경우에는 주문완료와 동시에 포인트를 지급합니다."); ?>
                주문 완료 <input type="text" name="de_point_days" value="<?php echo $default['de_point_days']; ?>" id="de_point_days" class="frm_input" size="2"> 일 이후에 포인트를 지급
            </td>
        </tr>
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
