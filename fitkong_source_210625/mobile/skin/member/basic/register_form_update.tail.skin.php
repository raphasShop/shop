<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//----------------------------------------------------------
// SMS 문자전송 시작
//----------------------------------------------------------

$sms_contents = $default['de_sms_cont1'];
$sms_contents = str_replace("{이름}", $mb_name, $sms_contents);
$sms_contents = str_replace("{회원아이디}", $mb_id, $sms_contents);
$sms_contents = str_replace("{회사명}", $default['de_admin_company_name'], $sms_contents);

// 핸드폰번호에서 숫자만 취한다
$receive_number = preg_replace("/[^0-9]/", "", $mb_hp);  // 수신자번호 (회원님의 핸드폰번호)
$send_number = preg_replace("/[^0-9]/", "", $default['de_admin_company_tel']); // 발신자번호

if ($w == "" && $default['de_sms_use1'] && $receive_number)
{
	if ($config['cf_sms_use'] == 'icode')
	{
		if($config['cf_sms_type'] == 'LMS') {
            include_once(G5_LIB_PATH.'/icode.lms.lib.php');

            $port_setting = get_icode_port_type($config['cf_icode_id'], $config['cf_icode_pw']);

            // SMS 모듈 클래스 생성
            if($port_setting !== false) {
                $SMS = new LMS;
                $SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $port_setting);

                $strDest     = array();
                $strDest[]   = $receive_number;
                $strCallBack = $send_number;
                $strCaller   = iconv_euckr(trim($default['de_admin_company_name']));
                $strSubject  = '';
                $strURL      = '';
                $strData     = iconv_euckr($sms_contents);
                $strDate     = '';
                $nCount      = count($strDest);

                $res = $SMS->Add($strDest, $strCallBack, $strCaller, $strSubject, $strURL, $strData, $strDate, $nCount);

                $SMS->Send();
                $SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
            }
        } else {
            include_once(G5_LIB_PATH.'/icode.sms.lib.php');

            $SMS = new SMS; // SMS 연결
            $SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $config['cf_icode_server_port']);
            $SMS->Add($receive_number, $send_number, $config['cf_icode_id'], iconv_euckr(stripslashes($sms_contents)), "");
            $SMS->Send();
            $SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
        }
	}
}
//----------------------------------------------------------
// SMS 문자전송 끝
//----------------------------------------------------------

//----------------------------------------------------------
// 알림톡전송 시작
//----------------------------------------------------------
if($w == "") {
$today = date("Y/m/d");

$msg = "[핏콩]\r\n안녕하세요. ".$mb_name."님!\r\n회원가입을 진심으로 축하드립니다.\r\n \r\n- 아이디: [".$mb_id."]\r\n- 가입일: [".$today."]\r\n \r\n고객님께서 만족하실때까지 보다 좋은 상품과 서비스로 보답하도록 하겠습니다. 감사합니다.\r\n \r\n고객센터 070-4483-4583";
$rst = kakaomsg('http://api.apistore.co.kr/kko/1/msg/fitkong', array('PHONE'=>$receive_number, 'CALLBACK'=>'01085808413', 'MSG'=>$msg, 'TEMPLATE_CODE'=>'FK0001', 'BTN_TYPES'=>'웹링크', 'BTN_TXTS'=>'핏콩 바로가기', 'BTN_URLS1'=>'http://fitkong.co.kr'));
}
//----------------------------------------------------------
// 알림톡전송 끝
//----------------------------------------------------------
?>
