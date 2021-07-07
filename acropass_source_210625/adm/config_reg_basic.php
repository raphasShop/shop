<?php
$sub_menu = '200201'; // 회원가입항목 및 정책
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '회원가입항목 및 정책';
include_once (G5_ADMIN_PATH.'/admin.head.php');
/*
$pg_anchor = '<ul class="anchor">
<li><a href="#anc_ch_basic">기본설정</a></li>
<li><a href="#anc_ch_market">추천쇼핑몰관리</a></li>
</ul>';

$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';
*/
$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';

// 회원 이미지 관련 필드 추가
if(!isset($config['cf_member_img_size'])) {
    sql_query("ALTER TABLE `{$g5['config_table']}`
                ADD `cf_member_img_size` int(11) NOT NULL DEFAULT '0' AFTER `cf_member_icon_height`,
                ADD `cf_member_img_width` int(11) NOT NULL DEFAULT '0' AFTER `cf_member_img_size`,
                ADD `cf_member_img_height` int(11) NOT NULL DEFAULT '0' AFTER `cf_member_img_width`
    ", true);

    $sql = " update {$g5['config_table']} set cf_member_img_size = 50000, cf_member_img_width = 60, cf_member_img_height = 60 ";
    sql_query($sql, false);

    $config['cf_member_img_size'] = 50000;
    $config['cf_member_img_width'] = 60;
    $config['cf_member_img_height'] = 60;
}
?>

<form name="fconfigform" action="./config_reg_basicupdate.php" onsubmit="return fconfigform_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="" id="token">

<!-- 메일인증 사용여부 -->
<section id="anc_cf_mail">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">메일 인증시에만 회원가입 완료</h2>
    <div class="local_desc02 local_desc">
        <p>
        회원가입시 기재한 이메일로 발송된 인증메일에서 인증확인을 클릭해서 인증받은 회원만 회원가입이 완료되는 기능입니다.<br>
        간혹 메일이 발송되지 않는 경우도 있으며, 재발송을 할 수 있고 회원 메일 자체가 수신불가능한 경우도 있습니다.
        </p>
    </div>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>기본 메일 환경 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_use_email_certify">메일인증 사용</label></th>
            <td>
                <?php echo help('메일에 배달된 인증 주소를 클릭하여야 회원으로 인정합니다.'); ?>
                <label class="switch-check">
                <input type="checkbox" name="cf_use_email_certify" value="1" id="cf_use_email_certify" <?php echo $config['cf_use_email_certify']?'checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
                </td>
        </tr>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!--//-->

<!-- 회원가입 스킨 설정 { -->
<section id="anc_cf_join">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">회원가입 스킨</h2>
    <div class="local_desc02 local_desc">
        <p>회원가입 시 사용할 스킨을 설정할 수 있습니다. 테마를 사용하는경우 테마 가 표시된 스킨을 사용하시면 됩니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>회원가입스킨</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_member_skin">PC 회원스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_skin_select('member', 'cf_member_skin', 'cf_member_skin', $config['cf_member_skin'], 'required'); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_mobile_member_skin">모바일 회원스킨<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo get_mobile_skin_select('member', 'cf_mobile_member_skin', 'cf_mobile_member_skin', $config['cf_mobile_member_skin'], 'required'); ?>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo preg_replace('#</div>$#i', '<button type="button" class="get_theme_confc btn btn-orangered" data-type="conf_member"><i class="fas fa-magic"></i> 테마 회원스킨설정 가져오기</button></div>', $frm_submit); ?>
<!-- // --> 

<!-- 회원가입항목 설정 { -->
<section id="anc_cf_join">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">회원가입 항목 설정</h2>
    <div class="local_desc02 local_desc">
        <p>회원가입 시 추가로 사용할 항목을 지정할 수 있습니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>회원가입 항목 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row">홈페이지 입력</th>
            <td>
                <input type="checkbox" name="cf_use_homepage" value="1" id="cf_use_homepage" <?php echo $config['cf_use_homepage']?'checked':''; ?>> <label for="cf_use_homepage">보이기</label>
                <input type="checkbox" name="cf_req_homepage" value="1" id="cf_req_homepage" <?php echo $config['cf_req_homepage']?'checked':''; ?>> <label for="cf_req_homepage">필수입력</label>
            </td>
        </tr>
        <tr>
            <th scope="row">주소 입력</th>
            <td>
                <input type="checkbox" name="cf_use_addr" value="1" id="cf_use_addr" <?php echo $config['cf_use_addr']?'checked':''; ?>> <label for="cf_use_addr">보이기</label>
                <input type="checkbox" name="cf_req_addr" value="1" id="cf_req_addr" <?php echo $config['cf_req_addr']?'checked':''; ?>> <label for="cf_req_addr">필수입력</label>
            </td>
        </tr>
        <tr>
            <th scope="row">전화번호 입력</th>
            <td>
                <input type="checkbox" name="cf_use_tel" value="1" id="cf_use_tel" <?php echo $config['cf_use_tel']?'checked':''; ?>> <label for="cf_use_tel">보이기</label>
                <input type="checkbox" name="cf_req_tel" value="1" id="cf_req_tel" <?php echo $config['cf_req_tel']?'checked':''; ?>> <label for="cf_req_tel">필수입력</label>
            </td>
        </tr>
        <tr>
            <th scope="row">휴대폰번호 입력</th>
            <td>
                <input type="checkbox" name="cf_use_hp" value="1" id="cf_use_hp" <?php echo $config['cf_use_hp']?'checked':''; ?>> <label for="cf_use_hp">보이기</label>
                <input type="checkbox" name="cf_req_hp" value="1" id="cf_req_hp" <?php echo $config['cf_req_hp']?'checked':''; ?>> <label for="cf_req_hp">필수입력</label>
            </td>
        </tr>
        <tr>
            <th scope="row">서명 입력</th>
            <td>
                <input type="checkbox" name="cf_use_signature" value="1" id="cf_use_signature" <?php echo $config['cf_use_signature']?'checked':''; ?>> <label for="cf_use_signature">보이기</label>
                <input type="checkbox" name="cf_req_signature" value="1" id="cf_req_signature" <?php echo $config['cf_req_signature']?'checked':''; ?>> <label for="cf_req_signature">필수입력</label>
            </td>
        </tr>
        <tr>
            <th scope="row">자기소개 입력</th>
            <td>
                <input type="checkbox" name="cf_use_profile" value="1" id="cf_use_profile" <?php echo $config['cf_use_profile']?'checked':''; ?>> <label for="cf_use_profile">보이기</label>
                <input type="checkbox" name="cf_req_profile" value="1" id="cf_req_profile" <?php echo $config['cf_req_profile']?'checked':''; ?>> <label for="cf_req_profile">필수입력</label>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!--//-->

<!-- 회원가입정책 { -->
<section id="anc_cf_join">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">회원가입정책</h2>
    <div class="local_desc02 local_desc">
        <p>회원가입시 권한이나 가입조건 및 닉네임, 정보수정 기간등을 설정을 할 수 있습니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>회원가입정책</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_register_level">회원가입시 권한</label></th>
            <td><?php echo get_member_level_select('cf_register_level', 1, 9, $config['cf_register_level']) ?></td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_register_point">회원가입시 포인트</label></th>
            <td><input type="text" name="cf_register_point" value="<?php echo $config['cf_register_point'] ?>" id="cf_register_point" class="frm_input" size="5"> 점</td>
        </tr>
        <tr>
            <th scope="row" id="th310"><label for="cf_leave_day">회원탈퇴후 삭제일</label></th>
            <td><input type="text" name="cf_leave_day" value="<?php echo $config['cf_leave_day'] ?>" id="cf_leave_day" class="frm_input" size="2"> 일 후 자동 삭제</td>
        </tr>
        
        <tr>
            <th scope="row"><label for="cf_cut_name">이름(닉네임) 표시</label></th>
            <td>
                <input type="text" name="cf_cut_name" value="<?php echo $config['cf_cut_name'] ?>" id="cf_cut_name" class="frm_input" size="5"> 자리만 표시
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_nick_modify">닉네임 수정</label></th>
            <td>수정하면 <input type="text" name="cf_nick_modify" value="<?php echo $config['cf_nick_modify'] ?>" id="cf_nick_modify" class="frm_input" size="3"> 일 동안 바꿀 수 없음</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_open_modify">정보공개 수정</label></th>
            <td>수정하면 <input type="text" name="cf_open_modify" value="<?php echo $config['cf_open_modify'] ?>" id="cf_open_modify" class="frm_input" size="3"> 일 동안 바꿀 수 없음</td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!-- // -->

<!-- 회원아이콘 { -->
<section id="anc_cf_join">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">회원아이콘</h2>
    <div class="local_desc02 local_desc">
        <p>게시물 및 회원닉네임 표시되는 곳에 회원아이콘을 등록,삭제할 수 있습니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>회원아이콘</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_use_member_icon">회원아이콘 사용</label></th>
            <td>
                <?php echo help('게시물에 게시자 닉네임 대신 아이콘 사용') ?>
                <select name="cf_use_member_icon" id="cf_use_member_icon">
                    <option value="0"<?php echo get_selected($config['cf_use_member_icon'], '0') ?>>미사용
                    <option value="1"<?php echo get_selected($config['cf_use_member_icon'], '1') ?>>아이콘만 표시
                    <option value="2"<?php echo get_selected($config['cf_use_member_icon'], '2') ?>>아이콘+이름 표시
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_icon_level">아이콘 업로드 권한</label></th>
            <td><?php echo get_member_level_select('cf_icon_level', 1, 9, $config['cf_icon_level']) ?> 이상</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_member_icon_size">회원아이콘 용량</label></th>
            <td><input type="text" name="cf_member_icon_size" value="<?php echo $config['cf_member_icon_size'] ?>" id="cf_member_icon_size" class="frm_input" size="10"> 바이트 이하</td>
        </tr>
        <tr>
            <th scope="row">회원아이콘 사이즈</th>
            <td>
                <label for="cf_member_icon_width">가로</label>
                <input type="text" name="cf_member_icon_width" value="<?php echo $config['cf_member_icon_width'] ?>" id="cf_member_icon_width" class="frm_input" size="2">
                <label for="cf_member_icon_height">세로</label>
                <input type="text" name="cf_member_icon_height" value="<?php echo $config['cf_member_icon_height'] ?>" id="cf_member_icon_height" class="frm_input" size="2">
                픽셀 이하
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!-- // -->

<!-- 회원가입메일발송 -->
<section id="anc_cf_join_mail">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">회원가입 시 메일 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>회원가입 시 메일 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_email_mb_super_admin">최고관리자 메일발송</label></th>
            <td>
                <?php echo help('최고관리자에게 메일을 발송합니다.') ?>
                <label class="switch-check">
                <input type="checkbox" name="cf_email_mb_super_admin" value="1" id="cf_email_mb_super_admin" <?php echo $config['cf_email_mb_super_admin']?'checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_email_mb_member">회원님께 메일발송</label></th>
            <td>
                <?php echo help('회원가입한 회원님께 메일을 발송합니다.') ?>
                <label class="switch-check">
                <input type="checkbox" name="cf_email_mb_member" value="1" id="cf_email_mb_member" <?php echo $config['cf_email_mb_member']?'checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!--//-->

<!-- 추천인제도 { -->
<section id="anc_cf_join">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">추천인제도</h2>
    <div class="local_desc02 local_desc">
        <p>회원가입시 추천인을 등록할 수 있는 기능을 사용할 수 있습니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>추천인제도</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_use_recommend">추천인제도 사용</label></th>
            <td>
            <label class="switch-check">
            <input type="checkbox" name="cf_use_recommend" value="1" id="cf_use_recommend" <?php echo $config['cf_use_recommend']?'checked':''; ?>> 사용
            <div class="check-slider round"></div>
            </label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_recommend_point">추천인 포인트</label></th>
            <td><input type="text" name="cf_recommend_point" value="<?php echo $config['cf_recommend_point'] ?>" id="cf_recommend_point" class="frm_input"> 점</td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!-- // -->

<!-- 금지 설정 { -->
<section id="anc_cf_join">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">아이디,닉네임,메일 금지 설정</h2>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>회원가입 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_prohibit_id">아이디,닉네임 금지단어</label></th>
            <td>
                <?php echo help('회원아이디, 닉네임으로 사용할 수 없는 단어를 정합니다. 쉼표 (,) 로 구분') ?>
                <textarea name="cf_prohibit_id" id="cf_prohibit_id" rows="5"><?php echo $config['cf_prohibit_id'] ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_prohibit_email">입력 금지 메일</label></th>
            <td>
                <?php echo help('입력 받지 않을 도메인을 지정합니다. 엔터로 구분 ex) hotmail.com') ?>
                <textarea name="cf_prohibit_email" id="cf_prohibit_email" rows="5"><?php echo $config['cf_prohibit_email'] ?></textarea>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!-- // -->


<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">   
    <div class="bq_basic_icon">
    <a href="<?php echo G5_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/home_icon.png" border="0" title="홈"></a>
    <a href="<?php echo G5_SHOP_URL ?>/" target="_blank"><img src="<?php echo G5_ADMIN_URL;?>/img/shop_icon.png" border="0" title="쇼핑몰">&nbsp;&nbsp;</a>
    </div>
    
    <div class="bq_basic_submit">
    <input type="submit" value="확인" accesskey="s">
    </div>
</div>
<!--//-->

</form>

<script>
/* 스킨 가져오기 */
$(function(){

    $(".get_theme_confc").on("click", function() {
        var type = $(this).data("type");
        var msg = "기본환경 스킨 설정";
        if(type == "conf_member")
            msg = "기본환경 회원스킨 설정";

        if(!confirm("현재 테마의 "+msg+"을 적용하시겠습니까?"))
            return false;

        $.ajax({
            type: "POST",
            url: "./theme_config_load.php",
            cache: false,
            async: false,
            data: { type: type },
            dataType: "json",
            success: function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                var field = Array('cf_member_skin', 'cf_mobile_member_skin', 'cf_new_skin', 'cf_mobile_new_skin', 'cf_search_skin', 'cf_mobile_search_skin', 'cf_connect_skin', 'cf_mobile_connect_skin', 'cf_faq_skin', 'cf_mobile_faq_skin');
                var count = field.length;
                var key;

                for(i=0; i<count; i++) {
                    key = field[i];

                    if(data[key] != undefined && data[key] != "")
                        $("select[name="+key+"]").val(data[key]);
                }
            }
        });
    });
});
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
