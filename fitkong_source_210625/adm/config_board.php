<?php
$sub_menu = '100101'; // 게시판기본환경 설정
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '게시판 기본환경 설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$pg_anchor = '<ul class="anchor">
    <li><a href="#anc_cf_board">게시판 기본설정</a></li>
	<li><a href="#anc_cf_edit">에디터/복사이동</a></li>
	<li><a href="#anc_cf_captcha">캡챠/구글리캡챠 설정</a></li>
	<li><a href="#anc_cf_list">게시판목록 설정</a></li>
	<li><a href="#anc_cf_upload">업로드 파일확장자</a></li>
	<li><a href="#anc_cf_filtering">단어필터링</a></li>
    <li><a href="#anc_cf_article_mail">글작성 메일발송</a></li>
</ul>';

/*
$frm_submit = '<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
</div>';
*/
$frm_submit = '<div class="btn_confirm01 btn_confirm"><div class="h10"></div></div>';
?>

<form name="fconfigform" action="./config_boardupdate.php" onsubmit="return fconfigform_check(this)" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="" id="token">

<!-- 게시판 기본환경 설정 { -->
<section id="anc_cf_board">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">게시판 기본 설정</h2>
    <div class="local_desc02 local_desc">
        <p>각 게시판 관리에서 개별적으로 설정 가능합니다.</p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>게시판 기본 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_delay_sec">글쓰기 간격<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="cf_delay_sec" value="<?php echo $config['cf_delay_sec'] ?>" id="cf_delay_sec" required class="required numeric frm_input" size="3"> 초 지난후 가능</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_link_target">새창 링크</label></th>
            <td>
                <?php echo help('글내용중 자동 링크되는 타켓을 지정합니다.') ?>
                <select name="cf_link_target" id="cf_link_target">
                    <option value="_blank"<?php echo get_selected($config['cf_link_target'], '_blank') ?>>_blank</option>
                    <option value="_self"<?php echo get_selected($config['cf_link_target'], '_self') ?>>_self</option>
                    <option value="_top"<?php echo get_selected($config['cf_link_target'], '_top') ?>>_top</option>
                    <option value="_new"<?php echo get_selected($config['cf_link_target'], '_new') ?>>_new</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_read_point">글읽기 포인트<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="cf_read_point" value="<?php echo $config['cf_read_point'] ?>" id="cf_read_point" required class="required frm_input" size="3"> 점</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_write_point">글쓰기 포인트</label></th>
            <td><input type="text" name="cf_write_point" value="<?php echo $config['cf_write_point'] ?>" id="cf_write_point" required class="required frm_input" size="3"> 점</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_comment_point">댓글쓰기 포인트</label></th>
            <td><input type="text" name="cf_comment_point" value="<?php echo $config['cf_comment_point'] ?>" id="cf_comment_point" required class="required frm_input" size="3"> 점</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_download_point">다운로드 포인트</label></th>
            <td><input type="text" name="cf_download_point" value="<?php echo $config['cf_download_point'] ?>" id="cf_download_point" required class="required frm_input" size="3"> 점</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_search_part">검색 단위</label></th>
            <td><input type="text" name="cf_search_part" value="<?php echo $config['cf_search_part'] ?>" id="cf_search_part" class="frm_input" size="4"> 건 단위로 검색</td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!-- // -->

<!-- 에디터/복사이동 설정 -->
<section id="anc_cf_edit">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">에디터/복사이동 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>에디터/복사이동 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_editor">에디터 선택</label></th>
            <td>
                <?php echo help(G5_EDITOR_URL.' 밑의 DHTML 에디터 폴더를 선택합니다.') ?>
                <select name="cf_editor" id="cf_editor">
                <?php
                $arr = get_skin_dir('', G5_EDITOR_PATH);
                for ($i=0; $i<count($arr); $i++) {
                    if ($i == 0) echo "<option value=\"\">사용안함</option>";
                    echo "<option value=\"".$arr[$i]."\"".get_selected($config['cf_editor'], $arr[$i]).">".$arr[$i]."</option>\n";
                }
                ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_use_copy_log">복사,이동시 로그남김</label></th>
            <td>
                <?php echo help('게시물 아래에 누구로 부터 복사, 이동됨 표시') ?>
                <label class="switch-check">
                <input type="checkbox" name="cf_use_copy_log" value="1" id="cf_use_copy_log" <?php echo $config['cf_use_copy_log']?'checked':''; ?>> 남김
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

<!-- 캡챠/구글리캡챠 설정 -->
<section id="anc_cf_captcha">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">캡챠/구글리캡챠 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>캡챠/구글리캡챠 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <!-- 캡챠선택 및 구글캡챠 api 등록 -->
        <tr>
            <th scope="row"><label for="cf_captcha">캡챠 선택<strong class="sound_only">필수</strong></label></th>
            <td colspan="3">
                <?php echo help('사용할 캡챠를 선택합니다.<br>1) Kcaptcha 는 그누보드5의 기본캡챠입니다. ( 문자입력 )<br>2) reCAPTCHA V2 는 구글에서 서비스하는 원클릭 형식의 간편한 캡챠입니다. ( 모바일 친화적 UI )<br>3) Invisible reCAPTCHA 는 구글에서 서비스하는 안보이는 형식의 캡챠입니다. ( 간혹 퀴즈를 풀어야 합니다. )<br>') ?>
                <select name="cf_captcha" id="cf_captcha" required class="required">
                <option value="kcaptcha" <?php echo get_selected($config['cf_captcha'], 'kcaptcha') ; ?>>Kcaptcha</option>
                <option value="recaptcha" <?php echo get_selected($config['cf_captcha'], 'recaptcha') ; ?>>reCAPTCHA V2</option>
                <option value="recaptcha_inv" <?php echo get_selected($config['cf_captcha'], 'recaptcha_inv') ; ?>>Invisible reCAPTCHA</option>
                </select>
            </td>
        </tr>
        <tr>
			<th scope="row"><label for="cf_recaptcha_site_key">구글 reCAPTCHA Site key</label></th>
			<td colspan="3">
            <?php echo help('reCAPTCHA V2와 Invisible reCAPTCHA 캡챠의 sitekey 와 secret 키는 동일하지 않고, 서로 발급받는 키가 다릅니다.') ?>
            <input type="text" name="cf_recaptcha_site_key" value="<?php echo $config['cf_recaptcha_site_key']; ?>" id="cf_recaptcha_site_key" class="frm_input" size="52"> <a href="https://www.google.com/recaptcha/admin" target="_blank" class="btn_frmline">reCAPTCHA 등록하기</a>
            </td>
		</tr>
		<tr>
            <th scope="row"><label for="cf_recaptcha_secret_key">구글 reCAPTCHA Secret key</label></th>
            <td colspan="3">
                <input type="text" name="cf_recaptcha_secret_key" value="<?php echo $config['cf_recaptcha_secret_key']; ?>" id="cf_recaptcha_secret_key" class="frm_input" size="52">
            </td>
		</tr>
        <!--//-->
        
        <tr class="kcaptcha_mp3">
            <th scope="row"><label for="cf_captcha_mp3">음성캡챠 선택<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo help('kcaptcha 사용시 '.str_replace(array('recaptcha_inv', 'recaptcha'), 'kcaptcha', G5_CAPTCHA_URL).'/mp3 밑의 음성 폴더를 선택합니다.') ?>
                <select name="cf_captcha_mp3" id="cf_captcha_mp3" required class="required">
                <?php
                $arr = get_skin_dir('mp3', str_replace(array('recaptcha_inv', 'recaptcha'), 'kcaptcha', G5_CAPTCHA_PATH));
                for ($i=0; $i<count($arr); $i++) {
                    if ($i == 0) echo "<option value=\"\">선택</option>";
                    echo "<option value=\"".$arr[$i]."\"".get_selected($config['cf_captcha_mp3'], $arr[$i]).">".$arr[$i]."</option>\n";
                }
                ?>
                </select>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!--//-->

<!-- 게시판 목록 설정 -->
<section id="anc_cf_list">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">게시판 목록 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>게시판 목록 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_new_rows">최근게시물 라인수</label></th>
            <td>
                <?php echo help('목록 한페이지당 라인수') ?>
                <input type="text" name="cf_new_rows" value="<?php echo $config['cf_new_rows'] ?>" id="cf_new_rows" class="frm_input" size="3"> 라인
            </td>
        </tr>
        <tr>
            <th colspan="2" class="titletag">PC</th>
        </tr>
        <tr>
            <th scope="row"><label for="cf_page_rows">한페이지당 라인수</label></th>
            <td>
                <?php echo help('목록(리스트) 한페이지당 라인수') ?>
                <input type="text" name="cf_page_rows" value="<?php echo $config['cf_page_rows'] ?>" id="cf_page_rows" class="frm_input" size="3"> 라인
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_write_pages">페이지 표시 수<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="cf_write_pages" value="<?php echo $config['cf_write_pages'] ?>" id="cf_write_pages" required class="required numeric frm_input" size="3"> 페이지씩 표시</td>
        </tr>
        <tr>
            <th colspan="2" class="titletag">모바일</th>
        </tr>
        <tr>
            <th scope="row"><label for="cf_mobile_page_rows">모바일 한페이지당 라인수</label></th>
            <td>
                <?php echo help('모바일 목록 한페이지당 라인수') ?>
                <input type="text" name="cf_mobile_page_rows" value="<?php echo $config['cf_mobile_page_rows'] ?>" id="cf_mobile_page_rows" class="frm_input" size="3"> 라인
            </td>
        </tr>
        
        <tr>
            <th scope="row"><label for="cf_mobile_pages">모바일 페이지 표시 수<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="cf_mobile_pages" value="<?php echo $config['cf_mobile_pages'] ?>" id="cf_mobile_pages" required class="required numeric frm_input" size="3"> 페이지씩 표시</td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!--//-->

<!-- 게시판 업로드파일 확장자 -->
<section id="anc_cf_upload">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">업로드 파일확장자 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>업로드 파일확장자 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_image_extension">이미지 업로드 확장자</label></th>
            <td>
                <?php echo help('게시판 글작성시 이미지 파일 업로드 가능 확장자. | 로 구분') ?>
                <input type="text" name="cf_image_extension" value="<?php echo $config['cf_image_extension'] ?>" id="cf_image_extension" class="frm_input w100per">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_flash_extension">플래쉬 업로드 확장자</label></th>
            <td>
                <?php echo help('게시판 글작성시 플래쉬 파일 업로드 가능 확장자. | 로 구분') ?>
                <input type="text" name="cf_flash_extension" value="<?php echo $config['cf_flash_extension'] ?>" id="cf_flash_extension" class="frm_input w100per">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_movie_extension">동영상 업로드 확장자</label></th>
            <td>
                <?php echo help('게시판 글작성시 동영상 파일 업로드 가능 확장자. | 로 구분') ?>
                <input type="text" name="cf_movie_extension" value="<?php echo $config['cf_movie_extension'] ?>" id="cf_movie_extension" class="frm_input w100per">
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!--//-->

<!-- 단어필터링 -->
<section id="anc_cf_filtering">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">단어필터링 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>게시판 글작성시 단어필터링</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_filter">단어 필터링</label></th>
            <td>
                <?php echo help('입력된 단어가 포함된 내용은 게시할 수 없습니다. 단어와 단어 사이는 ,로 구분합니다.') ?>
                <textarea name="cf_filter" id="cf_filter" rows="7"><?php echo $config['cf_filter'] ?></textarea>
             </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php echo $frm_submit; ?>
<!--//-->

<!-- 글작성메일 -->
<section id="anc_cf_article_mail">
    <?php echo $pg_anchor ?>
    <h2 class="h2_frm">게시판 글 작성 시 메일 설정</h2>
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
