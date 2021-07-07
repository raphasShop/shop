<?php
include_once('./_common.php');
//include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');
include_once(G5_LIB_PATH.'/register.lib.php');

define('ASIDE_DISABLE', 1);

if( ! $config['cf_social_login_use'] ){
    alert('소셜 로그인을 사용하지 않습니다.');
}

if( $is_member ){
    alert('이미 회원가입 하였습니다.', G5_URL);
}

$provider_name = social_get_request_provider();
$user_profile = social_session_exists_check();
if( ! $user_profile ){
    alert( "소셜로그인을 하신 분만 접근할 수 있습니다.", G5_URL);
}

// 소셜 가입된 내역이 있는지 확인 상수 G5_SOCIAL_DELETE_DAY 관련
$is_exists_social_account = social_before_join_check($url);

$user_nick = social_relace_nick($user_profile->displayName);
$user_email = isset($user_profile->emailVerified) ? $user_profile->emailVerified : $user_profile->email;
$user_id = $user_profile->sid ? preg_replace("/[^0-9a-z_]+/i", "", $user_profile->sid) : get_social_convert_id($user_profile->identifier, $provider_name);

//$is_exists_id = exist_mb_id($user_id);
//$is_exists_name = exist_mb_nick($user_nick, '');
$user_id = exist_mb_id_recursive($user_id);
$user_nick = exist_mb_nick_recursive($user_nick, '');
$is_exists_email = $user_email ? exist_mb_email($user_email, '') : false;
$user_name = isset($user_profile->username) ? $user_profile->username : ''; 
$user_birth = isset($user_profile->birthday) ? $user_profile->birthday : '';  
$user_birthyear = isset($user_profile->birthyear) ? $user_profile->birthyear : '';  
$user_gender = isset($user_profile->gender) ? $user_profile->gender : '';  
$user_agerange = isset($user_profile->age_range) ? $user_profile->age_range : '';
$user_phone = isset($user_profile->phone_number) ? $user_profile->phone_number : '';    
$is_exists_phone = $user_phone ? exist_mb_hp($user_phone, '') : false;
$user_plusfriends = isset($user_profile->plusfriends) ? $user_profile->plusfriends : '';    
$user_did = isset($user_profile->duser_id) ? $user_profile->duser_id : '';  
$user_terms = isset($user_profile->terms) ? $user_profile->terms : '';  
$shipping_addresses = isset($user_profile->shipping_addresses) ? $user_profile->shipping_addresses : '';  

$shipping_base_address = $shipping_addresses[0]->base_address;
$shipping_detail_address = $shipping_addresses[0]->detail_address;
$shipping_zone_number = $shipping_addresses[0]->zone_number;
$shipping_zip_code = $shipping_addresses[0]->zip_code;
$shipping_address_type = $shipping_addresses[0]->type;

if($shipping_zone_number) {
	$zone_number1 = substr($shipping_zone_number, 0, 3);
	$zone_number2 = substr($shipping_zone_number, 3, 2);
} 

if(!$shipping_zone_number) {
	$zone_number1 = substr($shipping_zip_code, 0, 3);
	$zone_number2 = substr($shipping_zip_code, 3, 3);
} 

if($user_email) {
	$exp_email = explode('@', $user_email);
	$user_nickname = $exp_email[0]."**";
} else {
	$user_nickname = substr($user_id, 5, 4)."****";
}
$user_birthday = $user_birthyear.$user_birth;

if($user_gender == 'male') {
	$user_gender = 'M'; 
} else if($user_gender == 'female') {
	$user_gender = 'F';
} else {
	$user_gender = '';
}

if($shipping_base_address) {
	$exp_base_add = explode(' (', $shipping_base_address);
	$shipping_base_address1 = $exp_base_add[0];
	if($exp_base_add[1]) {
		$shipping_base_address2 = '('.$exp_base_add[1];
	}
}

if($user_phone) {
	$exp_phone = explode(' ', $user_phone);
	$user_phone = '0'.$exp_phone[1];
}

$terms_sms = 0;
$terms_mail = 0;
for($i=0;$i<count($user_terms->allowed_service_terms);$i++){
	$terms_tag = $user_terms->allowed_service_terms[$i]->tag;
	if($terms_tag == 'sms_201214') {
		$terms_sms = 1;
	} else if($terms_tag == 'email_201214') {
		$terms_mail = 1;
	}
}

$user_data = isset($user_profile->data) ? $user_profile->data : '';  
$mb_id = $user_id;
$mb_hp = $user_phone;

// 불법접근을 막도록 토큰생성
$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

$g5['title'] = '소셜 회원 가입 - '.social_get_provider_service_name($provider_name);

include_once(G5_BBS_PATH.'/_head.php');

$register_action_url = https_url(G5_PLUGIN_DIR.'/'.G5_SOCIAL_LOGIN_DIR, true).'/register_member_update.php';
$login_action_url = G5_HTTPS_BBS_URL."/login_check.php";
$req_nick = !isset($member['mb_nick_date']) || (isset($member['mb_nick_date']) && $member['mb_nick_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400)));
$required = ($w=='') ? 'required' : '';
$readonly = ($w=='u') ? 'readonly' : '';

include_once(get_social_skin_path().'/social_register_member.skin.php');

include_once(G5_BBS_PATH.'/_tail.php');
?>
