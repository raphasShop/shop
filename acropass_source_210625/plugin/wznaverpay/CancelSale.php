<?php
include_once('./_common.php');

if (!$is_admin) alert("관리자만 접근이 가능합니다.", G5_URL);

echo '<html><head><META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8"></head>';

include_once(G5_PLUGIN_PATH.'/wznaverpay/config.php');
$aor = new NHNAPIORDER();
//$aor->showReq = true;
$ProductOrderID = '2019061113036420';
$CancelReasonCode = 'INTENT_CHANGED'; // 클레임 요청 사유 코드
$xml = $aor->CancelSale($ProductOrderID, $CancelReasonCode); // 배송이 시직되면 취소불가

echo '<pre>';
var_dump($xml);
echo '</pre>';