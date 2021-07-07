<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원정보 입력/수정 시작 { -->

<script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
<?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
<script src="<?php echo G5_JS_URL ?>/certify.js?v=<?php echo G5_JS_VER; ?>"></script>
<?php } ?>

<!-- 회원가입약관 동의 시작 { -->
<?php if( $w == 'u' ) { } else { ?>
<div id="pc_register_background">
<div id="register_top_wrap">

    <?php
    // 소셜로그인 사용시 소셜로그인 버튼
    //@include_once(get_social_skin_path().'/social_register.skin.php');
    ?>
    <img src="<?php echo G5_IMG_URL ?>/register_icon.png" class="register_top_image">
    <div class="register_intro">
        <div class="main_intro">FitKong 에 오신 것을 환영합니다.</div>
        <div class="sub_intro">가입 후 다양한 혜택을 만나보세요!</div>
    </div>
</div>
<?php } ?>

<form name="fregisterform" id="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="url" value="<?php echo $urlencode ?>">
    <input type="hidden" name="agree" value="<?php echo $agree ?>">
    <input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
    <input type="hidden" name="cert_type" id="cert_type" value="<?php echo $member['mb_certify']; ?>">
    <input type="hidden" name="cert_no" value="">
    <input type="hidden" name="rc_id" value="<?php echo $rc_id; ?>">
    <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면 ?>
    <input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
    <input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
    <?php } ?>
    
    <section id="cert_before">
    <div id="register_step_wrap">
        <div class="register_process_wrap">
            <div class="register_process">약관동의</div><div class="process_arrow"><img src="<?php echo G5_IMG_URL ?>/register_arrow.png"></div><div class="register_process process_now">본인인증</div><div class="process_arrow"><img src="<?php echo G5_IMG_URL ?>/register_arrow.png"></div><div class="register_process">정보입력</div>
        </div>
    </div>
    <div id="register_con_wrap">

    <div class="register_con_title">회원가입 시 본인인증</div>
    <div class="register_con_subtitle">안전한 회원가입을 위해 본인인증을 해주세요.</div>
    <div class="register_con_title_notice">전자상거래 법에 의해 만 14세 미만은 회원가입이 제한됩니다.</div>

    <div class="register_cert_wrap">
    <?php
        if($config['cf_cert_use']) {
            if($config['cf_cert_ipin'])
                echo '<div class="register_cert_image"><img src="'.G5_IMG_URL.'/acm-join-phone.png" id="win_ipin_cert"></div><div class="register_cert_text">아이핀 본인인증</div>'.PHP_EOL;
            if($config['cf_cert_hp'] && $config['cf_cert_hp'] != 'lg')
                echo '<div class="register_cert_image"><img src="'.G5_IMG_URL.'/hp_certification.jpg" id="win_hp_cert"></div><div class="register_cert_text" id="win_hp_cert_text">휴대폰 인증</div>'.PHP_EOL;
                //echo '<div class="register_cert_image"><img src="'.G5_IMG_URL.'/acm-join-phone.png" id="win_hp_cert"></div><div class="register_cert_text" id="win_hp_cert_text">휴대폰 본인인증</div>'.PHP_EOL;

            echo '<noscript>본인확인을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>'.PHP_EOL;
        }
        ?>
        <?php
        if ($config['cf_cert_use'] && $member['mb_certify']) {
            if($member['mb_certify'] == 'ipin')
                $mb_cert = '아이핀';
            else
                $mb_cert = '휴대폰';
        ?>
        <?php if ($config['cf_cert_use']) { ?>
        <span class="frm_info">아이핀 본인확인 후에는 이름이 자동 입력되고 휴대폰 본인확인 후에는 이름과 휴대폰번호가 자동 입력되어 수동으로 입력할수 없게 됩니다.</span>
        <?php } ?>
        <div id="msg_certify">
            <strong><?php echo $mb_cert; ?> 본인확인</strong><?php if ($member['mb_adult']) { ?> 및 <strong>성인인증</strong><?php } ?> 완료
        </div>
        <?php } ?>
    </div>
    <div class="btn_cert_check" id="cert_check_btn">다음</div>
    </section>  
    <?php if( $w == 'u' ) { ?>
    <div id="pc_confirm_background">
    <section id="cert_after">
    <div id="register_con_wrap">

    <div class="register_con_title">회원 정보 수정</div>
    <div class="register_con_subtitle">서비스 이용에 필요한 회원 정보를 입력해주세요.</div>
    <?php } else { ?>
    <section id="cert_after">
    <div id="register_step_wrap">
        <div class="register_process_wrap">
            <div class="register_process">약관동의</div><div class="process_arrow"><img src="<?php echo G5_IMG_URL ?>/register_arrow.png"></div><div class="register_process">본인인증</div><div class="process_arrow"><img src="<?php echo G5_IMG_URL ?>/register_arrow.png"></div><div class="register_process process_now">정보입력</div>
        </div>
    </div>
    <div id="register_con_wrap">

    <div class="register_con_title">회원 필수 정보 입력</div>
    <div class="register_con_subtitle">서비스 이용에 필요한 회원 정보를 입력해주세요.</div>
    
    <?php } ?>
    

    <div class="form_01">
        <h2>아이디</h2>
        <li>
            <label for="reg_mb_id" class="sound_only">아이디<strong>필수</strong></label>
            <input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" class="frm_input full_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20" <?php echo $required ?> <?php echo $readonly ?> placeholder="아이디">
            <span id="msg_mb_id"></span>
            <div class="reg_form_msg">
                <span class="frm_info">영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.</span>
            </div>
        </li>
         <h2>비밀번호</h2>
        <li>
            <label for="reg_mb_password" class="sound_only">비밀번호<strong>필수</strong></label>
            <input type="password" name="mb_password" id="reg_mb_password" class="frm_input full_input <?php echo $required ?>" minlength="3" maxlength="20" <?php echo $required ?> placeholder="비밀번호">
        </li>
         <h2>비밀번호 확인</h2>
        <li>
            <label for="reg_mb_password_re" class="sound_only">비밀번호 확인<strong>필수</strong></label>
            <input type="password" name="mb_password_re" id="reg_mb_password_re" class="frm_input full_input <?php echo $required ?>" minlength="3" maxlength="20" <?php echo $required ?>  placeholder="비밀번호확인">
        </li>
        <h2>이름</h2>
        <li class="rgs_name_li">
            <label for="reg_mb_name" class="sound_only">이름<strong>필수</strong></label>
            <input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?> <?php echo $readonly; ?> class="frm_input full_input <?php echo $required ?> <?php echo $readonly ?>" placeholder="이름" readonly>
           
            
        </li>
       

        <h2>닉네임</h2>
        <li>
            <label for="reg_mb_nick" class="sound_only">닉네임<strong>필수</strong></label>
            
            <input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>">
            <input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>" id="reg_mb_nick" required class="frm_input full_input required nospace" maxlength="20" placeholder="닉네임">
            <div class="reg_form_msg">
                <span class="frm_info">
                    공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상)<br>
                    닉네임을 바꾸시면 앞으로 <?php echo (int)$config['cf_nick_modify'] ?>일 이내에는 변경 할 수 없습니다.
                </span>
                <span id="msg_mb_nick"></span>
            </div>
            
        </li>
        <h2>이메일</h2>
        <li>
            <label for="reg_mb_email" class="sound_only">E-mail<strong>필수</strong></label>
            
                <?php if ($config['cf_use_email_certify']) {  ?>
                <span class="frm_info">
                    <?php if ($w=='') { echo "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다."; }  ?>
                    <?php if ($w=='u') { echo "E-mail 주소를 변경하시면 다시 인증하셔야 합니다."; }  ?>
                </span>
                <?php }  ?>
                <input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
                <input type="email" name="mb_email" value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>" id="reg_mb_email" required class="frm_input email required" size="50" maxlength="100" placeholder="E-mail">
            
        </li>
        <?php if ($config['cf_use_homepage']) { ?>
         <h2>홈페이지</h2>
        <li>
            <label for="reg_mb_homepage" class="sound_only">홈페이지<?php if ($config['cf_req_homepage']){ ?><strong>필수</strong><?php } ?></label>
            <input type="url" name="mb_homepage" value="<?php echo get_text($member['mb_homepage']) ?>" id="reg_mb_homepage" class="frm_input full_input <?php echo $config['cf_req_homepage']?"required":""; ?>" maxlength="255" <?php echo $config['cf_req_homepage']?"required":""; ?> placeholder="홈페이지">
        </li>
        <?php } ?>

        <?php if ($config['cf_use_tel']) { ?>
         <h2>전화번호</h2>
        <li>
            <label for="reg_mb_tel" class="sound_only">전화번호<?php if ($config['cf_req_tel']) { ?><strong>필수</strong><?php } ?></label>
            <input type="text" name="mb_tel" value="<?php echo get_text($member['mb_tel']) ?>" id="reg_mb_tel" class="frm_input full_input <?php echo $config['cf_req_tel']?"required":""; ?>" maxlength="20" <?php echo $config['cf_req_tel']?"required":""; ?> placeholder="전화번호">
        </li>
        <?php } ?>
        <?php if ($config['cf_use_hp'] || $config['cf_cert_hp']) {  ?>
        <h2>휴대폰번호</h2>
        <li>
            <label for="reg_mb_hp" class="sound_only">휴대폰번호<?php if ($config['cf_req_hp']) { ?><strong>필수</strong><?php } ?></label>
            
            <input type="text" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp" <?php echo ($config['cf_req_hp'])?"required":""; ?> class="frm_input full_input <?php echo ($config['cf_req_hp'])?"required":""; ?>" maxlength="20" placeholder="휴대폰번호" readonly>
            <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
            <input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
            <?php } ?>
            
        </li>

        <h2>성별</h2>
        <li>
            <label for="reg_mb_hp" class="sound_only">성별<?php if ($config['cf_req_hp']) { ?><strong>필수</strong><?php } ?></label>
            
            <input type="text" name="mb_sex" value="<?php if($member['mb_sex'] == 'M') { echo '남자'; } else if($member['mb_sex'] == 'F') { echo '여자'; } else { } ?>" id="reg_mb_hp" <?php echo ($config['cf_req_hp'])?"required":""; ?> class="frm_input full_input <?php echo ($config['cf_req_hp'])?"required":""; ?>" maxlength="20" placeholder="성별" readonly>
            <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
            <input type="hidden" name="old_mb_sex" value="<?php echo get_text($member['mb_sex']) ?>">
            <?php } ?>
            
        </li>

        <h2>생년월일</h2>
        <li>
            <label for="reg_mb_birth" class="sound_only">생년월일<?php if ($config['cf_req_birth']) { ?><strong>필수</strong><?php } ?></label>
            <input type="text" id="reg_mb_birth" name="mb_birth" value="<?php echo get_text($member['mb_birth']) ?>" <?php echo $required ?> <?php echo $readonly; ?> class="frm_input full_input <?php echo $required ?> <?php echo $readonly ?>" placeholder="생년월일" readonly>
            
        </li>
        <?php } ?>

        <?php if ($config['cf_use_addr']) { ?>
        <h2>주소</h2>
        <li>
            <label for="reg_mb_zip" class="sound_only">우편번호<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
            <input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input frm_add <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6" placeholder="우편번호">
            <button type="button" class="btn_frmline btn" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button><br>
            <label for="reg_mb_addr1" class="sound_only">주소<?php echo $config['cf_req_addr']?'<strong class="sound_only"> 필수</strong>':''; ?></label>
            <input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input frm_address <?php echo $config['cf_req_addr']?"required":""; ?>" size="50" placeholder="주소"><br>
            <label for="reg_mb_addr2" class="sound_only">상세주소</label>
            <input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="frm_input frm_address" size="50" placeholder="상세주소">
            <br>
            <label for="reg_mb_addr3" class="sound_only">참고항목</label>
            <input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="frm_input frm_address" size="50" readonly="readonly" placeholder="참고항목">
            <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">
            
        </li>
        <?php } ?>
        <?php if ($config['cf_use_signature']) { ?>
        <h2>서명</h2>
        <li>
            <label for="reg_mb_signature" class="sound_only">서명<?php if ($config['cf_req_signature']){ ?><strong>필수</strong><?php } ?></label>
            <textarea name="mb_signature" id="reg_mb_signature" class="<?php echo $config['cf_req_signature']?"required":""; ?>" <?php echo $config['cf_req_signature']?"required":""; ?> placeholder="서명"><?php echo $member['mb_signature'] ?></textarea>
        </li>
        <?php } ?>

        <?php if ($config['cf_use_profile']) { ?>
        <h2>자기소개</h2>
        <li>
            <label for="reg_mb_profile" class="sound_only">자기소개</label>
            <textarea name="mb_profile" id="reg_mb_profile" class="<?php echo $config['cf_req_profile']?"required":""; ?>" <?php echo $config['cf_req_profile']?"required":""; ?> placeholder="자기소개"><?php echo $member['mb_profile'] ?></textarea>
        </li>
        <?php } ?>
        <?php if ($w == "" && $config['cf_use_recommend']) { ?>
        <h2>추천인아이디(선택)</h2>
        <li>
            <label for="reg_mb_recommend" class="sound_only">추천인아이디</label>
            <input type="text" name="mb_recommend" id="reg_mb_recommend" class="frm_input full_input" placeholder="추천인아이디" value="<?php echo $rc_id; ?>">
        </li>
        <?php } ?>

        <li>&nbsp;</li>
        <li>
            <input type="checkbox" name="mb_mailling" value="1" id="reg_mb_mailling" <?php echo ($w=='' || $member['mb_mailling'])?'checked':''; ?>>
            <label for="reg_mb_mailling" class="frm_label"><span></span>FITKONG에서 제공하는 정보 메일을 받겠습니다.</label>
            
        </li>

        <?php if ($config['cf_use_hp']) { ?>
        <li>
            
            
            <input type="checkbox" name="mb_sms" value="1" id="reg_mb_sms" <?php echo ($w=='' || $member['mb_sms'])?'checked':''; ?>>
            <label for="reg_mb_sms" class="frm_label"><span></span>주문/배송/마케팅 정보 제공을 위한 SMS를 수신하겠습니다.</label>
            
        </li>
        <?php } ?>

       

        <?php
        //회원정보 수정인 경우 소셜 계정 출력
        if( $w == 'u' && function_exists('social_member_provider_manage') ){
            //social_member_provider_manage();
        }
        ?>

        
        <input type="submit" value="<?php echo $w==''?'회원가입':'정보수정'; ?>" id="btn_submit" class="btn_submit" accesskey="s">
        <?php if( $w == 'u' && $member['mb_10'] != 'kakaosync') { ?>
        <a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php" onclick="return member_leave();">
        <div class="btn_leave">회원탈퇴</div>
        </a>
        <?php } ?>
    </div>

    </div>

    
    
    
    </form>
    <section>
</div>
</div>
</div>

    <script>
    $(function(ready) {
        //$('#cert_before').css("display","none");
        //$('#cert_after').css("display","block");
        <?php if($member['mb_certify']) { ?>
            $('#cert_before').css("display","none");
            $('#cert_after').css("display","block");
        <? } ?>

        $('#cert_check_btn').click(function() {
            if($('input[name="cert_type"]').val() == 'hp') {
                $('#cert_before').css("display","none");
                $('#cert_after').css("display","block");
            } else {
                alert("회원가입을 위해 본인인증을 먼저 진행해주세요.");
            }
        });

        
        
    });

    $(function() {
        $("#reg_zip_find").css("display", "inline-block");

        <?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
        // 아이핀인증
        $("#win_ipin_cert").click(function() {
            if(!cert_confirm())
                return false;

            var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php";
            certify_win_open('kcb-ipin', url);
            return;
        });

        <?php } ?>
        <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
        // 휴대폰인증
        $("#win_hp_cert, #win_hp_cert_text").click(function() {
            if(!cert_confirm())
                return false;

            <?php
            switch($config['cf_cert_hp']) {
                case 'kcb':
                    $cert_url = G5_OKNAME_URL.'/hpcert1.php';
                    $cert_type = 'kcb-hp';
                    break;
                case 'kcp':
                    $cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
                    $cert_type = 'kcp-hp';
                    break;
                case 'lg':
                    $cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
                    $cert_type = 'lg-hp';
                    break;
                default:
                    echo 'alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");';
                    echo 'return false;';
                    break;
            }
            ?>

            certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
            return;
        });
        <?php } ?>
    });

    // submit 최종 폼체크
    function fregisterform_submit(f)
    {
        // 회원아이디 검사
        if (f.w.value == "") {
            var msg = reg_mb_id_check();
            if (msg) {
                alert(msg);
                f.mb_id.select();
                return false;
            }
        }

        if (f.w.value == "") {
            if (f.mb_password.value.length < 3) {
                alert("비밀번호를 3글자 이상 입력하십시오.");
                f.mb_password.focus();
                return false;
            }
        }

        if (f.mb_password.value != f.mb_password_re.value) {
            alert("비밀번호가 같지 않습니다.");
            f.mb_password_re.focus();
            return false;
        }

        if (f.mb_password.value.length > 0) {
            if (f.mb_password_re.value.length < 3) {
                alert("비밀번호를 3글자 이상 입력하십시오.");
                f.mb_password_re.focus();
                return false;
            }
        }

        // 이름 검사
        if (f.w.value=="") {
            if (f.mb_name.value.length < 1) {
                alert("이름을 입력하십시오.");
                f.mb_name.focus();
                return false;
            }

            /*
            var pattern = /([^가-힣\x20])/i;
            if (pattern.test(f.mb_name.value)) {
                alert("이름은 한글로 입력하십시오.");
                f.mb_name.select();
                return false;
            }
            */
        }

        <?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
        // 본인확인 체크
        if(f.cert_no.value=="") {
            alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
            return false;
        }
        <?php } ?>

        // 닉네임 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
            var msg = reg_mb_nick_check();
            if (msg) {
                alert(msg);
                f.reg_mb_nick.select();
                return false;
            }
        }

        // E-mail 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
            var msg = reg_mb_email_check();
            if (msg) {
                alert(msg);
                f.reg_mb_email.select();
                return false;
            }
        }

        <?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
        // 휴대폰번호 체크
        var msg = reg_mb_hp_check();
        if (msg) {
            alert(msg);
            f.reg_mb_hp.select();
            return false;
        }
        <?php } ?>

        if (typeof f.mb_icon != "undefined") {
            if (f.mb_icon.value) {
                if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                    alert("회원아이콘이 이미지 파일이 아닙니다.");
                    f.mb_icon.focus();
                    return false;
                }
            }
        }

        if (typeof f.mb_img != "undefined") {
            if (f.mb_img.value) {
                if (!f.mb_img.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                    alert("회원이미지가 이미지 파일이 아닙니다.");
                    f.mb_img.focus();
                    return false;
                }
            }
        }

        if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
            if (f.mb_id.value == f.mb_recommend.value) {
                alert("본인을 추천할 수 없습니다.");
                f.mb_recommend.focus();
                return false;
            }

            var msg = reg_mb_recommend_check();
            if (msg) {
                alert(msg);
                f.mb_recommend.select();
                return false;
            }
        }

        <?php echo chk_captcha_js();  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    </script>

<!-- } 회원정보 입력/수정 끝 -->