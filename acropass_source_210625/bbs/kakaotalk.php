<?php
include_once('./_common.php');

$msg = "[아크로패스]\r\n안녕하세요. 이신비고객님!\r\n아크로패스 회원가입을 진심으로 축하드립니다.\r\n- 아이디: [신비동무]\r\n- 가입일: [[2019/04/13]\r\n고객님께서 만족하실때까지 보다 좋은 상품과 서비스로 보답하도록 하겠습니다. 감사합니다.\r\n \r\n고객센터 070-7712-2015";
$rst = post('http://api.apistore.co.kr/kko/1/msg/raphas', array('PHONE'=>'01029363427', 'CALLBACK'=>'01024780137', 'MSG'=>$msg, 'TEMPLATE_CODE'=>'AC0001', 'BTN_TYPES'=>'웹링크', 'BTN_TXTS'=>'아크로패스 바로가기', 'BTN_URLS1'=>'http://acropass.com'));

echo $rst;

function post($url, $fields)
{
    $post_field_string = http_build_query($fields, '', '&');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8', 'x-waple-authorization: MTAzNzctMTU1MjMwODczMjA3MS0yMzAyYmVhMy1lNTYxLTQyMjktODJiZS1hM2U1NjE4MjI5MTc='));
    curl_setopt($ch, CURLOPT_POST, true);
    $response = curl_exec($ch);
    curl_close ($ch);
    return $response;
}

?>