<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if ($member['mb_id'] == 'administrator') $is_admin = 'super';

//카카오톡 알림톡 전송
function kakaomsg($url, $fields)
{
    $post_field_string = http_build_query($fields, '', '&');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8', 'x-waple-authorization: MTI2MzMtMTU4MzM3MTEyOTUxNC01NDk4ODI2Ni0wM2QzLTQwZWItOTg4Mi02NjAzZDMxMGViNDM='));
    curl_setopt($ch, CURLOPT_POST, true);
    $response = curl_exec($ch);
    curl_close ($ch);
    return $response;
}

$def_member_grade_array = array( 
"1"=>1 
, "2"=>0.9 
, "3"=>0.9 
, "4"=>0.9 
, "5"=>0.5 
); 

if($is_member && !defined("G5_IS_ADMIN")) 
define("G5_SHOP_DSICOUNT_RATE", $def_member_grade_array[$member['mb_level']]);  

?>