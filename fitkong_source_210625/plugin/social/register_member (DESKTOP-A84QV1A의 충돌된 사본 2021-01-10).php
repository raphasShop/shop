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
$user_ci = isset($user_profile->account_ci) ? $user_profile->account_ci : '';    
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
	$user_nickname = $exp_email[0];
} else {
	$user_nickname = substr($user_id, 5, 4)."****";
}
$user_birthday = $user_birthyear.$user_birth;

if($user_gender == 'male') {
	$user_gender = 'M'; 
} else if($user_gender == 'female') {
	$user_gender = 'W';
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
	if($terms_tag == 'sms_201127') {
		$terms_sms = 1;
	} else if($terms_tag == 'email_201127') {
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
/*
echo $user_id;
echo "/";
echo get_encrypt_string($user_id);
echo "/";
echo $user_email;
echo "/";
echo $user_nick;
echo "/";
echo $user_nickname;
echo "/";
echo $user_birthday;
echo "/";
echo $user_gender;
echo "/";
echo $user_agerange;
echo "/";
echo $user_phone;
echo "/";
echo $shipping_base_address;
echo "/";
echo $shipping_detail_address;
echo "/";
echo $shipping_zone_number;
echo "/";
echo $shipping_zip_code;
echo "/";
echo $shipping_address_type;
echo "/";
echo $terms_sms;
echo "/";
echo $terms_mail;
echo "/";
echo $shipping_base_address1;
echo "/";
echo $shipping_base_address2;
echo "/";
$ship_count = count($shipping_addresses);
echo $ship_count;
echo "/";
$jj = json_decode($shipping_addresses,true);
print_r($shipping_addresses[0]);
print_r($user_profile->terms);
*/
if($default['de_kakaosync_use'] && $provider == 'Kakao') {
	
	$mb = get_member($user_id);

	if(!$mb) {
		$mb_hp = hyphen_hp_number($mb_hp);
		// 중복체크
		$sql = " select mb_id from {$g5['member_table']} where mb_hp = '{$mb_hp}' and mb_10 != 'kakaosync' ";
		$row = sql_fetch($sql);
		if ($row['mb_id']) {
		    alert("카카오 계정과 동일한 정보로 일반회원으로 가입한 내역이 존재합니다.",G5_URL);
		}

		$sql = " select mb_id from {$g5['member_table']} where mb_email = '{$mb_email}' and mb_10 != 'kakaosync' ";
		$row = sql_fetch($sql);
		if ($row['mb_id']) {
		    alert("카카오 계정과 동일한 정보로 일반회원으로 가입한 내역이 존재합니다.",G5_URL);
		}
		// 회원정보 입력
		$sql = " insert into {$g5['member_table']}
                set mb_id = '{$user_id}',
                     mb_password = '".get_encrypt_string($user_id)."',
                     mb_name = '{$user_nick}',
                     mb_nick = '{$user_nickname}',
                     mb_email = '{$user_email}',
                     mb_homepage = '{$user_code}',
                     mb_tel = '{$user_tel}',
                     mb_zip1 = '{$zone_number1}',
                     mb_zip2 = '{$zone_number2}',
                     mb_addr1 = '{$shipping_base_address1}',
                     mb_addr2 = '{$shipping_detail_address}',
                     mb_addr3 = '{$shipping_base_address2}',
                     mb_addr_jibeon = '{$mb_addr_jibeon}',
                     mb_signature = '{$mb_signature}',
                     mb_profile = '{$mb_profile}',
                     mb_today_login = '".G5_TIME_YMDHIS."',
                     mb_datetime = '".G5_TIME_YMDHIS."',
                     mb_ip = '{$_SERVER['REMOTE_ADDR']}',
                     mb_level = '{$config['cf_register_level']}',
                     mb_recommend = '{$mb_recommend}',
                     mb_login_ip = '{$_SERVER['REMOTE_ADDR']}',
                     mb_mailling = '{$terms_mail}',
                     mb_sms = '{$terms_sms}',
                     mb_open = '{$mb_open}',
                     mb_open_date = '".G5_TIME_YMD."',
                     mb_hp = '{$user_phone}',
                     mb_certify = 'hp',
                     mb_adult = '0',
                     mb_birth = '{$user_birthday}',
                     mb_sex = '{$user_gender}',
                     mb_1 = '{$mb_1}',
                     mb_2 = '{$mb_2}',
                     mb_3 = '{$mb_3}',
                     mb_4 = '{$mb_4}',
                     mb_5 = '{$mb_5}',
                     mb_6 = '{$mb_6}',
                     mb_7 = '{$mb_7}',
                     mb_8 = '{$mb_8}',
                     mb_9 = '{$mb_9}',
                     mb_10 = 'kakaosync' ";

      
		$result = sql_query($sql, false);

		if($result) {

		    // 회원가입 포인트 부여
		    insert_point($mb_id, $config['cf_register_point'], '회원가입 축하', '@member', $mb_id, '회원가입');

		    // 회원가입 시 쿠폰 증정
		    $register_coupon_use = true;

		    if($register_coupon_use) {
		        $j = 0;
		        $create_coupon = false;

		        do {
		            $cp_id = get_coupon_id();

		            $sql3 = " select count(*) as cnt from {$g5['g5_shop_coupon_table']} where cp_id = '$cp_id' ";
		            $row3 = sql_fetch($sql3);

		            if(!$row3['cnt']) {
		                $create_coupon = true;
		                break;
		            } else {
		                if($j > 20)
		                    break;
		            }
		        } while(1);

		        if($create_coupon) {
		            $cp_subject = '회원가입 축하쿠폰';
		            $cp_method = 2;
		            $cp_target = '';
		            $cp_start = G5_TIME_YMD;
		            $cp_end = date('Y-m-d', strtotime("+7 days", G5_SERVER_TIME));
		            $cp_type = 0;
		            $cp_price = 3000;
		            $cp_trunc = 1;
		            $cp_minimum = 10000;
		            $cp_maximum = 0;

		            $sql = " INSERT INTO {$g5['g5_shop_coupon_table']}
		                        ( cp_id, cp_subject, cp_method, cp_target, mb_id, cp_start, cp_end, cp_type, cp_price, cp_trunc, cp_minimum, cp_maximum, cp_datetime )
		                    VALUES
		                        ( '$cp_id', '$cp_subject', '$cp_method', '$cp_target', '$mb_id', '$cp_start', '$cp_end', '$cp_type', '$cp_price', '$cp_trunc', '$cp_minimum', '$cp_maximum', '".G5_TIME_YMDHIS."' ) ";

		            $res = sql_query($sql, false);

		            if($res)
		                set_session('ss_member_reg_coupon', 1);
		        }
		    }

		    // 신규회원 쿠폰발생
			if($w == '' && $default['de_member_reg_coupon_use'] && $default['de_member_reg_coupon_term'] > 0 && $default['de_member_reg_coupon_price'] > 0) {
			    $j = 0;
			    $create_coupon = false;

			    do {
			        $cp_id = get_coupon_id();

			        $sql3 = " select count(*) as cnt from {$g5['g5_shop_coupon_table']} where cp_id = '$cp_id' ";
			        $row3 = sql_fetch($sql3);

			        if(!$row3['cnt']) {
			            $create_coupon = true;
			            break;
			        } else {
			            if($j > 20)
			                break;
			        }
			    } while(1);

			    if($create_coupon) {
			        $cp_subject = '신규 회원가입 배송비 할인 쿠폰';
			        $cp_method = 3;
			        $cp_target = '';
			        $cp_start = G5_TIME_YMD;
			        $cp_end = date("Y-m-d", (G5_SERVER_TIME + (86400 * ((int)$default['de_member_reg_coupon_term'] - 1))));
			        $cp_type = 1;
			        $cp_price = $default['de_member_reg_coupon_price'];
			        $cp_trunc = 100;
			        $cp_minimum = $default['de_member_reg_coupon_minimum'];
			        $cp_maximum = 0;

			        $sql = " INSERT INTO {$g5['g5_shop_coupon_table']}
			                    ( cp_id, cp_subject, cp_method, cp_target, mb_id, cp_start, cp_end, cp_type, cp_price, cp_trunc, cp_minimum, cp_maximum, cp_datetime )
			                VALUES
			                    ( '$cp_id', '$cp_subject', '$cp_method', '$cp_target', '$mb_id', '$cp_start', '$cp_end', '$cp_type', '$cp_price', '$cp_trunc', '$cp_minimum', '$cp_maximum', '".G5_TIME_YMDHIS."' ) ";

			        $res = sql_query($sql, false);

			        if($res)
			            set_session('ss_member_reg_coupon', 1);
			    }
			}

		    // 최고관리자님께 메일 발송
		    if ($config['cf_email_mb_super_admin']) {
		        $subject = '['.$config['cf_title'].'] '.$mb_nick .' 님께서 회원으로 가입하셨습니다.';

		        ob_start();
		        include_once (G5_BBS_PATH.'/register_form_update_mail2.php');
		        $content = ob_get_contents();
		        ob_end_clean();

		        mailer($mb_nick, $mb_email, $config['cf_admin_email'], $subject, $content, 1);
		    }

		    $mb = get_member($mb_id);

		    //소셜 로그인 계정 추가
		    if( function_exists('social_login_success_after') ){
		        social_login_success_after($mb, '', 'register');
		    }

		    set_session('ss_mb_reg', $mb['mb_id']);



		    // 사용자 코드 실행
		    @include_once ($member_skin_path.'/register_form_update.tail.skin.php');

		    goto_url(G5_HTTP_BBS_URL.'/register_result.php');

		} else {

		    alert('회원 가입 오류!', G5_URL );

		}


	} else {

		// 계정이 있으면 로그인 처리
		//set_session('ss_mb_id', $mb['mb_id']);
	}



	//goto_url($url);
}


//include_once(get_social_skin_path().'/social_register_member.skin.php');

include_once(G5_BBS_PATH.'/_tail.php');
?>
