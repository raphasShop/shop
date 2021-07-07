<?php
$sub_menu = '100301'; // 메일사용 및 발송설정
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '메일환경 및 발송설정';
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
?>

<form name="fconfigform" action="./config_mailsendupdate.php" onsubmit="return fconfigform_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="" id="token">

<!-- 기본 메일환경 설정 { -->
<section id="anc_cf_mail">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">기본 메일 환경 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>기본 메일 환경 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_email_use">메일발송 사용</label></th>
            <td>
                <?php echo help('체크하지 않으면 메일발송을 아예 사용하지 않습니다. 메일 테스트도 불가합니다.') ?>
                <label class="switch-check">
                <input type="checkbox" name="cf_email_use" value="1" id="cf_email_use" <?php echo $config['cf_email_use']?'checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_formmail_is_member">폼메일 사용 여부</label></th>
            <td>
                <?php echo help('체크하지 않으면 비회원도 사용 할 수 있습니다.') ?>
                <input type="checkbox" name="cf_formmail_is_member" value="1" id="cf_formmail_is_member" <?php echo $config['cf_formmail_is_member']?'checked':''; ?>> 회원만 사용
            </td>
        </tr>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!--//-->

<!-- 회원가입메일발송 -->
<section id="anc_cf_join_mail">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">회원가입 시 메일 설정</h2>
    <div class="local_desc02 local_desc">
        <p><span class="info_navi_link">환경설정 &gt; 회원 &gt; 회원가입설정 &gt; 회원가입정책설정 에서도 동일하게 등록</span>할 수 있습니다</p>
    </div>
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

<!-- 게시판글작성메일 -->
<section id="anc_cf_article_mail">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">게시판 글 작성 시 메일 설정</h2>
    <div class="local_desc02 local_desc">
        <p><span class="info_navi_link">환경설정 &gt; 사이트환경설정 &gt; 게시판설정 에서도 동일하게 등록</span>할 수 있습니다</p>
    </div>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>게시판 글 작성 시 메일 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_email_wr_super_admin">최고관리자</label></th>
            <td>
                <?php echo help('최고관리자에게 메일을 발송합니다.') ?>
                <label class="switch-check">
                <input type="checkbox" name="cf_email_wr_super_admin" value="1" id="cf_email_wr_super_admin" <?php echo $config['cf_email_wr_super_admin']?'checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_email_wr_group_admin">그룹관리자</label></th>
            <td>
                <?php echo help('그룹관리자에게 메일을 발송합니다.') ?>
                <label class="switch-check">
                <input type="checkbox" name="cf_email_wr_group_admin" value="1" id="cf_email_wr_group_admin" <?php echo $config['cf_email_wr_group_admin']?'checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_email_wr_board_admin">게시판관리자</label></th>
            <td>
                <?php echo help('게시판관리자에게 메일을 발송합니다.') ?>
                <label class="switch-check">
                <input type="checkbox" name="cf_email_wr_board_admin" value="1" id="cf_email_wr_board_admin" <?php echo $config['cf_email_wr_board_admin']?'checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_email_wr_write">원글작성자</label></th>
            <td>
                <?php echo help('게시자님께 메일을 발송합니다.') ?>
                <label class="switch-check">
                <input type="checkbox" name="cf_email_wr_write" value="1" id="cf_email_wr_write" <?php echo $config['cf_email_wr_write']?'checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_email_wr_comment_all">댓글작성자</label></th>
            <td>
                <?php echo help('원글에 댓글이 올라오는 경우 댓글 쓴 모든 분들께 메일을 발송합니다.') ?>
                <label class="switch-check">
                <input type="checkbox" name="cf_email_wr_comment_all" value="1" id="cf_email_wr_comment_all" <?php echo $config['cf_email_wr_comment_all']?'checked':''; ?>> 사용
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

<!-- 투표메일 -->
<section id="anc_cf_vote_mail">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">투표 기타의견 작성 시 메일 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>투표 기타의견 작성 시 메일 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_email_po_super_admin">최고관리자 메일발송</label></th>
            <td>
                <?php echo help('최고관리자에게 메일을 발송합니다.') ?>
                <label class="switch-check">
                <input type="checkbox" name="cf_email_po_super_admin" value="1" id="cf_email_po_super_admin" <?php echo $config['cf_email_po_super_admin']?'checked':''; ?>> 사용
                <div class="check-slider round"></div>
                </label>
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

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
