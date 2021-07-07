<?php
include_once('./_common.php');

/*******************************************************
네이버페이에서 Callback Url 로 자동 동기화 처리되는 모듈입니다.
********************************************************/

include_once(G5_PLUGIN_PATH.'/wznaverpay/config.php');
$aor = new NHNAPIORDER();
$aor->ordersync_callback('ordersync');