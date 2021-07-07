<?php
$sub_menu = '111116'; /* 새로만듦 */
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

if (!$config['cf_icode_server_ip'])   $config['cf_icode_server_ip'] = '211.172.232.124'; //아이코드 서버IP
if (!$config['cf_icode_server_port']) $config['cf_icode_server_port'] = '7295'; //아이코드 서버포트

if ($config['cf_sms_use'] && $config['cf_icode_id'] && $config['cf_icode_pw']) {
    $userinfo = get_icode_userinfo($config['cf_icode_id'], $config['cf_icode_pw']);
}

$g5['title'] = '쇼핑알림설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$pg_anchor = '<ul class="anchor2">
<li><a href="#anc_scf_sms">주문SMS설정</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';

?>

<script>
function byte_check(el_cont, el_byte)
{
    var cont = document.getElementById(el_cont);
    var bytes = document.getElementById(el_byte);
    var i = 0;
    var cnt = 0;
    var exceed = 0;
    var ch = '';
    var limit_num = (jQuery("#cf_sms_type").val() == "LMS") ? 1500 : 80;

    for (i=0; i<cont.value.length; i++) {
        ch = cont.value.charAt(i);
        if (escape(ch).length > 4) {
            cnt += 2;
        } else {
            cnt += 1;
        }
    }

    //byte.value = cnt + ' / 80 bytes';
    bytes.innerHTML = cnt + ' / ' + limit_num +' bytes';

    if (cnt > limit_num) {
        exceed = cnt - limit_num;
        alert('메시지 내용은 ' + limit_num +' 바이트를 넘을수 없습니다.\r\n작성하신 메세지 내용은 '+ exceed +'byte가 초과되었습니다.\r\n초과된 부분은 자동으로 삭제됩니다.');
        var tcnt = 0;
        var xcnt = 0;
        var tmp = cont.value;
        for (i=0; i<tmp.length; i++) {
            ch = tmp.charAt(i);
            if (escape(ch).length > 4) {
                tcnt += 2;
            } else {
                tcnt += 1;
            }

            if (tcnt > limit_num) {
                tmp = tmp.substring(0,i);
                break;
            } else {
                xcnt = tcnt;
            }
        }
        cont.value = tmp;
        //byte.value = xcnt + ' / 80 bytes';
        bytes.innerHTML = xcnt + ' / ' + limit_num +' bytes';
        return;
    }
}
</script>

<form name="fconfig" action="./config_shopping_alimupdate.php" onsubmit="return fconfig_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="">
<section id="anc_scf_sms" >
    <?php echo $pg_anchor; ?>
    <h2 class="h2_frm">주문시 SMS 설정 및 발송문구 지정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>SMS 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_sms_use">SMS 사용</label></th>
            <td>
                <?php echo help("SMS  서비스 회사를 선택하십시오. 서비스 회사를 선택하지 않으면, SMS 발송 기능이 동작하지 않습니다.<br>아이코드는 무료 문자메세지 발송 테스트 환경을 지원합니다.<br><a href=\"".G5_ADMIN_URL."/config_form.php#anc_cf_sms\">기본환경설정 &gt; SMS</a> 설정과 동일합니다."); ?>
                <select id="cf_sms_use" name="cf_sms_use">
                    <option value="" <?php echo get_selected($config['cf_sms_use'], ''); ?>>사용안함</option>
                    <option value="icode" <?php echo get_selected($config['cf_sms_use'], 'icode'); ?>>아이코드</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_sms_type">SMS 전송유형</label></th>
            <td>
                <?php echo help("전송유형을 SMS로 선택하시면 최대 80바이트까지 전송하실 수 있으며<br>LMS로 선택하시면 90바이트 이하는 SMS로, 그 이상은 1500바이트까지 LMS로 전송됩니다.<br>요금은 건당 SMS는 16원, LMS는 48원입니다."); ?>
                <select id="cf_sms_type" name="cf_sms_type">
                    <option value="" <?php echo get_selected($config['cf_sms_type'], ''); ?>>SMS</option>
                    <option value="LMS" <?php echo get_selected($config['cf_sms_type'], 'LMS'); ?>>LMS</option>
                </select>
                <!-- 선택저장 -->
                <?php if ($is_admin == 'super') { ?>

                    <input type="submit" value="선택저장" class="btn_frmline cursor" accesskey="s">

                <?php } ?>
                <!--//-->
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_sms_hp">관리자 휴대폰번호</label></th>
            <td>
                <?php echo help("주문서작성시 쇼핑몰관리자가 문자메세지를 받아볼 번호를 숫자만으로 입력하세요. 예) 0101234567"); ?>
                <input type="text" name="de_sms_hp" value="<?php echo $default['de_sms_hp']; ?>" id="de_sms_hp" class="frm_input" size="15">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_icode_id">아이코드 회원아이디</label></th>
            <td>
                <?php echo help("아이코드에서 사용하시는 회원아이디를 입력합니다."); ?>
                <input type="text" name="cf_icode_id" value="<?php echo $config['cf_icode_id']; ?>" id="cf_icode_id" class="frm_input" size="15">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_icode_pw">아이코드 비밀번호</label></th>
            <td>
                <?php echo help("아이코드에서 사용하시는 비밀번호를 입력합니다."); ?>
                <input type="password" name="cf_icode_pw" value="<?php echo $config['cf_icode_pw']; ?>" class="frm_input" id="cf_icode_pw">
            </td>
        </tr>
        <tr>
            <th scope="row">요금제</th>
            <td>
                <input type="hidden" name="cf_icode_server_ip" value="<?php echo $config['cf_icode_server_ip']; ?>">
                <?php
                    if ($userinfo['payment'] == 'A') {
                       echo '충전제';
                        echo '<input type="hidden" name="cf_icode_server_port" value="7295">';
                    } else if ($userinfo['payment'] == 'C') {
                        echo '정액제';
                        echo '<input type="hidden" name="cf_icode_server_port" value="7296">';
                    } else {
                        echo '가입해주세요.';
                        echo '<input type="hidden" name="cf_icode_server_port" value="7295">';
                    }
                ?>
            </td>
        </tr>
        <tr>
            <th scope="row">아이코드 SMS 신청<br>회원가입</th>
            <td>
                <?php echo help("아래 링크에서 회원가입 하시면 문자 건당 16원에 제공 받을 수 있습니다."); ?>
                <a href="http://icodekorea.com/res/join_company_fix_a.php?sellid=sir2" target="_blank" class="btn_frmline">아이코드 회원가입</a>
            </td>
        </tr>
         <?php if ($userinfo['payment'] == 'A') { ?>
        <tr>
            <th scope="row">충전 잔액</th>
            <td colspan="3">
                <?php echo number_format($userinfo['coin']); ?> 원.
                <a href="http://www.icodekorea.com/smsbiz/credit_card_amt.php?icode_id=<?php echo $config['cf_icode_id']; ?>&amp;icode_passwd=<?php echo $config['cf_icode_pw']; ?>" target="_blank" class="btn_frmline" onclick="window.open(this.href,'icode_payment', 'scrollbars=1,resizable=1'); return false;">충전하기</a>
            </td>
        </tr>
        <?php } ?>
         </tbody>
        </table>
    </div>

    <section id="scf_sms_pre">
        <h3>사전에 정의된 SMS프리셋</h3>
        <div class="local_desc01 local_desc">
            <dl>
                <dt>회원가입시</dt>
                <dd>{이름} {회원아이디} {회사명}</dd>
                <dt>주문서작성</dt>
                <dd>{이름} {보낸분} {받는분} {주문번호} {주문금액} {회사명}</dd>
                <dt>입금확인시</dt>
                <dd>{이름} {입금액} {주문번호} {회사명}</dd>
                <dt>상품배송시</dt>
                <dd>{이름} {택배회사} {운송장번호} {주문번호} {회사명}</dd>
            </dl>
           <p><?php echo help('주의! 80 bytes 까지만 전송됩니다. (영문 한글자 : 1byte , 한글 한글자 : 2bytes , 특수문자의 경우 1 또는 2 bytes 임)'); ?></p>
           <p>
           <i class="fas fa-user-tie font-22 blue"></i> 고객&nbsp;&nbsp;&nbsp;
           <i class="fas fa-user-cog font-22"></i> 쇼핑몰관리자
           </p>
        </div>

        <div id="scf_sms">
            <?php
            $scf_sms_title = array (1=>"<i class=\"fas fa-user-tie font-28 blue\"></i> 회원가입 발송문자", "<i class=\"fas fa-user-tie font-28 blue\"></i> 주문접수 발송문자", "<i class=\"fas fa-user-cog font-28 gray\"></i> 주문시 관리자에게 발송", "<i class=\"fas fa-user-tie font-28 blue\"></i> 입금확인완료 발송문자", "<i class=\"fas fa-user-tie font-28 blue\"></i> 상품배송 발송문자");
            for ($i=1; $i<=5; $i++) {
            ?>
            <section class="scf_sms_box">
                <h4><?php echo $scf_sms_title[$i]; ?></h4>
                <label class="switch-check-mini">
                <input type="checkbox" name="de_sms_use<?php echo $i; ?>" value="1" id="de_sms_use<?php echo $i; ?>" <?php echo ($default["de_sms_use".$i] ? " checked" : ""); ?>> 사용
                <div class="check-slider-mini round"></div>
                </label>
                <?php if($config['cf_sms_type'] == 'LMS') {//LMS사용시?>
                <div class="scf_lms_img">
                    <div class="type">LMS</div>
                    <textarea id="de_sms_cont<?php echo $i; ?>" name="de_sms_cont<?php echo $i; ?>" ONKEYUP="byte_check('de_sms_cont<?php echo $i; ?>', 'byte<?php echo $i; ?>');"><?php echo $default['de_sms_cont'.$i]; ?></textarea>
                </div>
                <?php } else {//SMS사용시?>
                <div class="scf_sms_img">
                    <div class="type">SMS</div>
                    <textarea id="de_sms_cont<?php echo $i; ?>" name="de_sms_cont<?php echo $i; ?>" ONKEYUP="byte_check('de_sms_cont<?php echo $i; ?>', 'byte<?php echo $i; ?>');"><?php echo $default['de_sms_cont'.$i]; ?></textarea>
                </div>
                <?php } //닫기?>
                <span id="byte<?php echo $i; ?>" class="scf_sms_cnt">0 / 80 바이트</span>
            </section>

            <script>
            byte_check('de_sms_cont<?php echo $i; ?>', 'byte<?php echo $i; ?>');
            </script>
            <?php } ?>
        </div>
    </section>

</section>

<?php echo $frm_submit; ?>

<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">   
    <div class="bq_basic_icon">
    <a href="<?php echo G5_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/home_icon.png" border="0" title="홈"></a>
    <a href="<?php echo G5_SHOP_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/shop_icon.png" border="0" title="쇼핑몰">&nbsp;&nbsp;</a>
    </div>
    
	<?php if ($is_admin == 'super') { ?>
    <div class="bq_basic_submit">
    <input type="submit" value="확인" accesskey="s">
    </div>
    <?php } ?>
</div>
<!--//-->

</form>

<script>
function fconfig_check(f)
{
    <?php echo get_editor_js('de_guest_privacy'); ?>

    return true;
}
</script>


<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>