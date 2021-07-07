<?php
include_once('./_common.php');

if (!$is_admin) alert("관리자만 접근이 가능합니다.", G5_URL);

echo '<html><head><META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8"></head>';

include_once(G5_PLUGIN_PATH.'/wznaverpay/config.php');
$aor = new NHNAPIORDER();
//$aor->showReq = true;
$ProductOrderID = '2019061113036630';
$DeliveryMethodCode = 'DIRECT_DELIVERY';
$DeliveryCompanyCode = '';
$TrackingNumber = '';
$DispatchDate = '2019-06-12T12:01:10';
$xml = $aor->ShipProductOrder($ProductOrderID, $DeliveryMethodCode, $DeliveryCompanyCode, $TrackingNumber, $DispatchDate);

echo '<pre>';
var_dump($xml);
echo '</pre>';