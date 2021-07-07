<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$req = $xml->Body->GetProductOrderInfoListResponse;
$ResponseType = (string)$req->ResponseType; // 호출한 API 의 성공 여부(Success/SuccessWarning/Error/Error-Warning)
$Error = $req->Error; // 오류(error) 정보