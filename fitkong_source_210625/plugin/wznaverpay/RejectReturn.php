<?php
include_once('./_common.php');

if (!$is_admin) alert("관리자만 접근이 가능합니다.", G5_URL);

echo '<html><head><META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8"></head>';

$ProductOrderID = $_GET['poid'] ? $_GET['poid'] : '2020120614413800';

include_once(G5_PLUGIN_PATH.'/wznaverpay/config.php');
$aor = new NHNAPIORDER();
//$aor->showReq = true;
$RejectDetailContent = '상품의하자발생'; // 반품 거부 사유 (암호화?)
$xml = $aor->RejectReturn($ProductOrderID, $RejectDetailContent);

echo '<pre>';
var_dump($xml);
echo '</pre>';