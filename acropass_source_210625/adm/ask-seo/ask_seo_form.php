<?php
    $sub_menu = "100980";
    include_once './_common.php';

    auth_check($auth[$sub_menu], 'r');

    if ($is_admin != 'super') {
        alert('최고관리자만 접근 가능합니다.');
    }


    if(!function_exists(get_board_subject)){
        /**
         * 게시판 제목 가져오기
         */
        function get_board_subject($bo_table){
            global $g5;
            $query  = "select bo_subject from {$g5['board_table']} where bo_table = '{$bo_table}'";
            $result = sql_fetch($query);
            return $result['bo_subject'];
        }
    }
    if(!function_exists(get_contents_subject)){
        /**
         * 내용관리 제목 가져오기
         */
        function get_contents_subject($co_id){
            global $g5;
            $query  = "select co_subject from {$g5['content_table']} where co_id='{$co_id}'";
            $result = sql_fetch($query);
            return $result['co_subject'];
        }
    }
    /**
     * ASK SEO 관련 필드 추가.
     */
    if (!isset($config['as_use'])) { 
        sql_query("ALTER TABLE `{$g5['config_table']}` 
            ADD `as_use` varchar(10) NOT NULL DEFAULT '1' AFTER `cf_10`, 
            ADD `as_google_verification` varchar(50) NOT NULL DEFAULT '' , 
            ADD `as_naver_verification` varchar(50) NOT NULL DEFAULT '' , 
            ADD `as_bing_verification` varchar(50) NOT NULL DEFAULT '' , 
            ADD `as_url` varchar(30) NOT NULL DEFAULT '' , 
            ADD `as_logo` varchar(30) NOT NULL DEFAULT '' , 
            ADD `as_telephone` varchar(20) NOT NULL DEFAULT '' , 
            ADD `as_title` varchar(60) NOT NULL DEFAULT '' , 
            ADD `as_keywords` text NOT NULL  , 
            ADD `as_description` text NOT NULL , 
            ADD `as_sns_facebook` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_sns_twitter` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_sns_instagram` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_sns_youtube` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_sns_googleplus` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_sns_linkedin` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_sns_pinterest` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_sns_soundcloud` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_sns_tumblr` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_sns_navercafe` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_sns_naversmartstore` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_sns_naverpost` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_sns_naverpholar` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_sns_itunes` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_sns_googleplaystore` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_sns_navertv` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_sns_kakaostory` varchar(40) NOT NULL DEFAULT '' , 
            ADD `as_feed_type` VARCHAR(20) NOT NULL DEFAULT 'rss', 
            ADD `as_feed_target` VARCHAR(20) NOT NULL DEFAULT 'new_table' , 
            ADD `as_feed_rows` INT(11) NOT NULL DEFAULT '50', 
            ADD `as_sitemap_google` VARCHAR(10) NOT NULL DEFAULT '1', 
            ADD `as_sitemap_bing` VARCHAR(10) NOT NULL DEFAULT '1', 
            ADD `as_sitemap_addurl` TEXT NOT NULL  , 
            ADD `as_sitemap_boardcount` INT(11) NOT NULL DEFAULT '100' , 
            ADD `as_sitemap_boardlist` TEXT NOT NULL  , 
            ADD `as_sitemap_contentslist` VARCHAR(255) NOT NULL DEFAULT '' , 
            ADD `as_sitemap_faq` VARCHAR(10) NOT NULL DEFAULT '1' 

            ", true); 
    } 

    $g5['title'] = 'ASK-SEO 설정';
    include_once G5_ADMIN_PATH . '/admin.head.php';
    add_stylesheet('<link rel="stylesheet" href="' . G5_ADMIN_URL . '/ask-seo/style.css">');
?>

<form name="askconfigform" id="askconfigform" method="post" enctype="multipart/form-data" onsubmit="return askseo_submit(this);">
<input type="hidden" name="token" value="" id="token">

<section id="anc-seo">
    <?php echo $pg_anchor ?>
    <h2 class="frm-head">SEO 최적화 설정</h2>
    <div class='alert-info'>
        <i class="fa fa-info-circle" aria-hidden="true"></i>
        구글 SEO 가이드 <a href='https://static.googleusercontent.com/media/www.google.com/ko//intl/ko/webmasters/docs/search-engine-optimization-starter-guide-ko.pdf' target='_blank'>링크 <i class="fa fa-link" aria-hidden="true"></i></a>, 
        네이버웹마스터도구 가이드 <a href='https://webmastertool.naver.com/guide/wmt_guide_201710.pdf' target='_blank'> 링크 <i class="fa fa-link" aria-hidden="true"></i></a>, 
        <a href='https://webmastertool.naver.com/board/main.naver' target='_blank' class=''>네이버웹마스터도구 <i class="fa fa-link" aria-hidden="true"></i></a>,
        <a href='https://www.google.com/webmasters/tools/home?hl=ko' target='_blank'>구글웹마스터도구<i class="fa fa-link" aria-hidden="true"></i></a>,
        <a href='https://www.bing.com/webmaster/' target='_blank'>빙웹마스터도구 <i class="fa fa-link" aria-hidden="true"></i></a>
    </div>
    <div class='alert-info'>
        <strong>SEO 설정을 하여도 검색 결과 출력은 보장하지 않습니다. 검색엔진이 분석하여 검색 노출 여부를 판단하게 됩니다. 따라서 노출을 보장하지는 않습니다.</strong>
    </div>
    <div class='frm-wrap'>
        <div class='frm-group border-top-1'>
            <label class='frm-label'><span>SEO 사용여부</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <label><input type="checkbox" name="as_use" value="1" id="as_use" class="frm-check" <?php echo $config['as_use'] ? 'checked' : ''; ?>> 사용</label>
                    <?php echo help('사용에 체크해야 SEO 설정이 사이트에 적용됩니다.'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class='frm-wrap'>
        <h3 class="frm-head">기본설정</h3>
        <div class='alert-info'>
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            웹마스터 도구에서 사이트 소유를 확인하기 위한 태그를 입력하세요. 메타태그 입력방식으로 인증합니다.
        </div>
        <div class='frm-group border-top-1'>
            <label class='frm-label' for='as_google_verification'><span>구글 - 사이트소유확인</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="as_google_verification" value="<?php echo $config['as_google_verification'] ?>" id="as_google_verification" class="frm-input">
                    <?php echo help('Google Search console 에서 사이트소유확인용 <a href="https://support.google.com/webmasters/answer/35179?visit_id=636770658756047462-841414286&rd=1" target="_blank">참고링크</a>'); ?>
                    <div class='help-img'>
                        <img src='./img/google-auth-info.jpg'>
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_naver_verification'><span>네이버 - 사이트소유확인</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="as_naver_verification" value="<?php echo $config['as_naver_verification'] ?>" id="as_naver_verification" class="frm-input">
                    <?php echo help('네이버웹마스터도구에서 사이트소유확인용 <a href="https://help.naver.com/support/contents/contents.nhn?serviceNo=14882&categoryNo=14928" target="_blank">참고링크</a>'); ?>
                    <div class='help-img'>
                        <img src='./img/naver-auth-info.jpg'>
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_bing_verification'><span>빙 - 사이트소유확인</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="as_bing_verification" value="<?php echo $config['as_bing_verification'] ?>" id="as_bing_verification" class="frm-input">
                    <?php echo help('빙웹마스터도구에서 사이트소유확인용 <a href="https://www.bing.com/webmaster/help/getting-started-checklist-66a806de" target="_blank">참고링크</a>'); ?>
                    <div class='help-img'>
                        <img src='./img/bing-auth-info.jpg'>
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_logo'><span>사이트로고</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="file" name="as_logo" id="as_logo" class="frm-input">
                    <?php echo help('사이트 로고를 업로드 하세요. jpg, png, gif'); ?>
                    <?php
                        //파일이 있다면 출력 및 삭제
                        if ($config['as_logo'] && file_exists(AS_SAVE_DIR . '/' . $config['as_logo'])) {
                            echo "<a href='" . AS_SAVE_URL . '/' . $config['as_logo'] . "' target='_blank'><img src='" . AS_SAVE_URL . '/' . $config['as_logo'] . "' width='100px' height='auto'></a>";
                            echo "<label><input type='checkbox' name='delete_logo' value='{$config['as_logo']}' class='frm-check'>삭제</label>";
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_telephone'><span>회사연락처</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="as_telephone" value="<?php echo $config['as_telephone'] ?>" id="as_telephone" required class="required frm-input size50" placeholder='02-000-0000'>
                    <?php echo help('회사 연락처나 고객지원 연락처를 입력하세요.'); ?>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_url'><span>사이트 URL</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_url" value="<?php echo $config['as_url'] ?>" id="as_url" required class="required frm-input size50" placeholder="http://....">
                    <?php echo help('웹사이트 주소를 입력하세요. ex) http://www.mywebsite.com'); ?>
                </div>
            </div>
        </div>
    </div><!--//.frm-wrap-->

    <div class='frm-wrap'>
        <h3 class="frm-head">메인페이지 Metatag</h3>
        <div class='alert-info'>
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            기본정보 및 메인페이지 정보 입력을 기반으로 메인페이지 Open Graph tag는 자동으로 출력됩니다.
        </div>
        <div class='frm-group border-top-1'>
            <label class='frm-label' for='as_title'><span>TITLE</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="as_title" value="<?php echo $config['as_title'] ?>" id="as_title" required class="required frm-input size50">
                    <?php echo help('Open Graph Title 입력. 사이트 제목을 입력하세요.'); ?>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_keywords'><span>Keywords</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="as_keywords" value="<?php echo $config['as_keywords'] ?>" id="as_keywords" required class="required frm-input">
                    <?php echo help('Meta keywords 입력. 쉼표로 구분해서 입력하세요.'); ?>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_description'><span>Description</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <textarea type="text" name="as_description" id="as_description" required class="required frm-input" size="255"><?php echo $config['as_description'] ?></textarea>
                    <?php echo help('Meta Description 입력. 한글기준 160자 이내로 입력'); ?>
                </div>
            </div>
        </div>
    </div><!--//.frm-wrap-->

    <div class='frm-wrap'>
        <h3 class="frm-head">구글 소셜프로필, 네이버채널</h3>
        <div class='alert-info'>
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            구조화된 데이터를 작성하여 소셜프로필 정보를 구글지식패널 또는 네이버 연관채널에 추가합니다.
            <a href='https://developers.google.com/search/docs/data-types/social-profile?hl=ko' target='_blank'>참고URL #1</a>
            <a href='https://webmastertool.naver.com/guide/advanced_sd.naver#chapter3.1' target='_blank'>참고URL #2</a>
        </div>
        <div class='alert-info'>
            구글은 Facebook, Twitter, Google+, Instagram, YouTube, LinkedIn, Myspace, Pinterest, SoundCloud, Tumblr를 지원합니다.
        </div>
        <div class='alert-info'>
            네이버는 네이버 블로그/카페, 스마트스토어, 포스트, 폴라, 페이스북, 인스타그램, 아이튠즈, 구글 플레이 스토어, 트위터, 유투브, 구글 플러스, 네이버 TV, 링크드인, 핀터레스트, 카카오 스토리를 지원하며 최대10개만 지원합니다.
        </div>

        <div class='frm-group border-top-1'>
            <label class='frm-label' for='as_sns_facebook'><span>Facebook</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_facebook" value="<?php echo $config['as_sns_facebook'] ?>" id="as_sns_facebook" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sns_twitter'><span>Twitter</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_twitter" value="<?php echo $config['as_sns_twitter'] ?>" id="as_sns_twitter" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sns_instagram'><span>Instagram</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_instagram" value="<?php echo $config['as_sns_instagram'] ?>" id="as_sns_instagram" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sns_youtube'><span>Youtube</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_youtube" value="<?php echo $config['as_sns_youtube'] ?>" id="as_sns_youtube" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sns_googleplus'><span>Google+</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_googleplus" value="<?php echo $config['as_sns_googleplus'] ?>" id="as_sns_googleplus" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sns_linkedin'><span>LinkedIn</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_linkedin" value="<?php echo $config['as_sns_linkedin'] ?>" id="as_sns_linkedin" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sns_pinterest'><span>Pinterest</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_pinterest" value="<?php echo $config['as_sns_pinterest'] ?>" id="as_sns_pinterest" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sns_soundcloud'><span>SoundCloud</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_soundcloud" value="<?php echo $config['as_sns_soundcloud'] ?>" id="as_sns_soundcloud" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sns_tumblr'><span>Tumblr</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_tumblr" value="<?php echo $config['as_sns_tumblr'] ?>" id="as_sns_tumblr" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='alert-info'>네이버전용</div>
        <div class='frm-group border-top-1'>
            <label class='frm-label' for='as_sns_navercafe'><span>네이버카페</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_navercafe" value="<?php echo $config['as_sns_navercafe'] ?>" id="as_sns_navercafe" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sns_naversmartstore'><span>스마트스토어</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_naversmartstore" value="<?php echo $config['as_sns_naversmartstore'] ?>" id="as_sns_naversmartstore" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sns_naverpost'><span>네이버포스트</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_naverpost" value="<?php echo $config['as_sns_naverpost'] ?>" id="as_sns_naverpost" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sns_naverpholar'><span>네이버폴라</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_naverpholar" value="<?php echo $config['as_sns_naverpholar'] ?>" id="as_sns_naverpholar" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sns_itunes'><span>아이튠즈</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_itunes" value="<?php echo $config['as_sns_itunes'] ?>" id="as_sns_itunes" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sns_googleplaystore'><span>구글플레이스토어</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_googleplaystore" value="<?php echo $config['as_sns_googleplaystore'] ?>" id="as_sns_googleplaystore" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sns_navertv'><span>네이버TV</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_navertv" value="<?php echo $config['as_sns_navertv'] ?>" id="as_sns_navertv" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sns_kakaostory'><span>카카오스토리</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_sns_kakaostory" value="<?php echo $config['as_sns_kakaostory'] ?>" id="as_sns_kakaostory" class="frm-input size50">
                </div>
            </div>
        </div>
    </div><!--//.frm-wrap-->

    <div class='frm-wrap'>
        <h3 class="frm-head">Feed 설정</h3>
        <div class='alert-info'>
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            RSS, ATOM Feed 를 설정하세요.
        </div>
        <div class='frm-group border-top-1'>
            <label class='frm-label' for='as_feed_type'><span>Feed Type</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                <?php
                    if ($config['as_feed_type'] == 'rss') {
                        $rss_check = "checked";
                    }
                    if ($config['as_feed_type'] == 'atom') {
                        $atom_check = "checked";
                    }
                ?>
                    <label><input type="radio" name="as_feed_type" value="rss" class="" <?php echo $rss_check ?>> RSS</label>
                    <label><input type="radio" name="as_feed_type" value="atom" class="" <?php echo $atom_check ?>> ATOM</label>
                    <?php echo help('Feed 형식을 선택하세요.'); ?>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_feed_target'><span>Feed 소스</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                <?php
                    if ($config['as_feed_target'] == 'new_table') {
                        $new_check = "checked";
                    }
                    if ($config['as_feed_target'] == 'all_board') {
                        $all_check = "checked";
                    }
                ?>
                    <label><input type="radio" name="as_feed_target" value="new_table" class="" <?php echo $new_check ?>> 새글에서 가져오기</label>
                    <label><input type="radio" name="as_feed_target" value="all_board" class="" <?php echo $all_check ?>> 전체게시판에서 가져오기</label>
                    <?php echo help('새글 목록 또는 전체 게시판 중 선택해서 Feed 생성 합니다.'); ?>
                    <?php echo help('새글에서 가져오기를 추천합니다.'); ?>
                    <?php echo help('전체게시판에서 가져오기는 게시판 검색에 체크한 것만 가져옵니다. 순서는 게시판 설정에 출력순서 기준입니다.'); ?>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_feed_rows'><span>Feed 출력 수</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="text" name="as_feed_rows" value="<?php echo $config['as_feed_rows'] ?>" id="as_feed_rows" class="frm-input size50">
                </div>
            </div>
        </div>
    </div><!--//.frm-wrap-->

    <div class='frm-wrap'>
        <h3 class="frm-head">Sitemap 설정</h3>
        <div class='alert-info'>
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            그누보드 메뉴는 기본으로 포함됩니다.
        </div>
        <div class='frm-group border-top-1'>
            <label class='frm-label'><span>자동제출</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <label><input type="checkbox" name="as_sitemap_google" value="1" id="as_sitemap_google" class="frm-check" <?php echo $config['as_sitemap_google'] ? 'checked' : ''; ?>> Google</label>
                    <label><input type="checkbox" name="as_sitemap_bing" value="1" id="as_sitemap_bing" class="frm-check" <?php echo $config['as_sitemap_bing'] ? 'checked' : ''; ?>> Bing</label>
                    <?php echo help('네이버는 직접 제출해야 합니다.');?>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sitemap_addurl'><span>추가 URL</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <textarea type="text" name="as_sitemap_addurl" id="as_sitemap_addurl" class="frm-input"  placeholder='http://myhomeurl.com/suburl'><?php echo $config['as_sitemap_addurl'] ?></textarea>
                    <?php echo help('추가하고싶은 주소를 한줄에 하나씩 입력하세요.'); ?>
                </div>
            </div>
        </div>
        <div class='alert-info'>
            게시판을 사이트맵에 추가할 수 있습니다. 
        </div>
        <div class='frm-group border-top-1'>
            <label class='frm-label'><span>게시판추가</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <label><input type="number" name="as_sitemap_boardcount" value="<?php echo $config['as_sitemap_boardcount'] ?>" id="as_sitemap_boardcount" class="frm-input size20"> 게시판당 출력수</label>
                    <?php echo help('설정한 숫자만큼 게시판 최신 목록이 사이트맵에 추가됩니다.')?>
                    <div class='board-list-wrap'>
                        <?php $as_sitemap_boardlist = unserialize($config['as_sitemap_boardlist']);?>
                        <div class='board'>
                            <h4>게시판목록</h4>
                            <select id="board_list" name="board_list" multiple="multiple">
                                <?php
                                    $query  = "select * from {$g5['board_table']} where bo_use_search = 1 and bo_read_level='1' order by bo_order asc";
                                    $result = sql_query($query);
                                    $list   = array();
                                    for ($a = 0; $rows = sql_fetch_array($result); $a++) {
                                        if(count($as_sitemap_boardlist) > 0 && in_array($rows['bo_table'], $as_sitemap_boardlist)){
                                            continue;
                                        }
                                        echo "<option value='{$rows['bo_table']}'>{$rows['bo_subject']}({$rows['bo_table']})</option>";
                                    }
                                ?>
                                
                            </select>
                        </div>
                        <div class='board-button'>
                            <a href="javascript:void(0);" id="addPop" class='button'> 추가 <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                            <br/>
                            <a href="javascript:void(0);" id="removePop" class='button'> <i class="fa fa-arrow-left" aria-hidden="true"></i> 삭제</a>
                        </div>
                        
                        <div class='sitemap-board'>
                            <h4>추가된 게시판</h4>
                            <?php
                            if(count($as_sitemap_boardlist) > 0 && $as_sitemap_boardlist){
                                $add_board_list = '';
                                foreach($as_sitemap_boardlist as $board_list){
                                    $add_board_list .= "<option value='{$board_list}'>" . get_board_subject($board_list) . "({$board_list})</option>";
                                }
                            }
                            ?>
                            <select id="as_sitemap_boardlist" name="as_sitemap_boardlist[]" multiple="multiple">
                                <?php echo $add_board_list?>
                            </select>
                        </div>
                        <script type='text/javascript'>
                            $('#addPop').click(function () {
                                if ($('#board_list option:selected').val() != null) {
                                    var tempSelect = $('#board_list option:selected').val();
                                    $('#board_list option:selected').remove().appendTo('#as_sitemap_boardlist');
                                    $("#board_list").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
                                    $("#as_sitemap_boardlist").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
                                    $("#as_sitemap_boardlist").val(tempSelect);
                                    tempSelect = '';
                                } else {
                                    alert("왼쪽 - 추가할 게시판을 선택하세요.");
                                }
                            });

                            $('#removePop').click(function () {
                                if ($('#as_sitemap_boardlist option:selected').val() != null) {
                                    var tempSelect = $('#as_sitemap_boardlist option:selected').val();
                                    $('#as_sitemap_boardlist option:selected').remove().appendTo('#board_list');
                                    $("#as_sitemap_boardlist").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
                                    $("#board_list").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
                                    
                                    $("#board_list").val(tempSelect);
                                    tempSelect = '';
                                } else {
                                    alert("오른쪽 - 삭제할 게시판을 선택하세요.");
                                }
                            });
                        </script>
                    </div>
                    <?php echo help('검색가능한 비회원이 볼 수 있는 게시판만 출력됩니다.');?>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>내용관리추가</span></label>
            <div class='frm-control'>
                <?php $as_sitemap_contentslist = unserialize($config['as_sitemap_contentslist']);?>
                <div class='frm-cont'>
                    <div class='board-list-wrap'>
                        <div class='board'>
                            <h4>내용관리목록</h4>
                            <select id="contents_list" name="contents_list" multiple="multiple">
                                <?php
                                    $query  = "select * from {$g5['content_table']} limit 1000";
                                    $result = sql_query($query);
                                    $list   = array();
                                    for ($a = 0; $rows = sql_fetch_array($result); $a++) {
                                        if(count($as_sitemap_contentslist) > 0 && in_array($rows['co_id'], $as_sitemap_contentslist)){
                                            continue;
                                        }
                                        echo "<option value='{$rows['co_id']}'>{$rows['co_subject']}({$rows['co_id']})</option>";
                                    }
                                ?>
                                
                            </select>
                        </div>
                        <div class='board-button'>
                            <a href="javascript:void(0);" id="addPop2" class='button'> 추가 <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                            <br/>
                            <a href="javascript:void(0);" id="removePop2" class='button'> <i class="fa fa-arrow-left" aria-hidden="true"></i> 삭제</a>
                        </div>
                        
                        <div class='sitemap-board'>
                            <h4>추가된 내용관리</h4>
                            <?php
                            if(count($as_sitemap_contentslist) > 0 && $as_sitemap_contentslist){
                                $add_contents_list = '';
                                foreach($as_sitemap_contentslist as $contents_list){
                                    $add_contents_list .= "<option value='{$contents_list}'>" . get_contents_subject($contents_list) . "({$contents_list})</option>";
                                }
                            }
                            ?>
                            <select id="as_sitemap_contentslist" name="as_sitemap_contentslist[]" multiple="multiple">
                                <?php echo $add_contents_list?>
                            </select>
                        </div>
                        <script type='text/javascript'>
                            $('#addPop2').click(function () {
                                if ($('#contents_list option:selected').val() != null) {
                                    var tempSelect = $('#contents_list option:selected').val();
                                    $('#contents_list option:selected').remove().appendTo('#as_sitemap_contentslist');
                                    $("#contents_list").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
                                    $("#as_sitemap_contentslist").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
                                    $("#as_sitemap_contentslist").val(tempSelect);
                                    tempSelect = '';
                                } else {
                                    alert("왼쪽 - 추가할 내용관리를 선택하세요.");
                                }
                            });

                            $('#removePop2').click(function () {
                                if ($('#as_sitemap_contentslist option:selected').val() != null) {
                                    var tempSelect = $('#as_sitemap_contentslist option:selected').val();
                                    $('#as_sitemap_contentslist option:selected').remove().appendTo('#contents_list');
                                    $("#as_sitemap_contentslist").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
                                    $("#contents_list").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
                                    
                                    $("#contents_list").val(tempSelect);
                                    tempSelect = '';
                                } else {
                                    alert("오른쪽 - 삭제할 내용관리를 선택하세요.");
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_sitemap_faq'><span>FAQ 추가</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <label><input type="checkbox" name="as_sitemap_faq" value="1" id="as_sitemap_faq" class="frm-check" <?php echo $config['as_sitemap_faq'] ? 'checked' : ''; ?>> FQA추가</label>
                    <?php echo help('FQA를 사이트맵에 추가합니다.');?>
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label'><span>사이트맵 미리보기</span></label>
            <div class='frm-control'>
                <?php
                    $ch = curl_init();
                    $url = G5_URL . '/sitemap.php';
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
                    $data = curl_exec($ch);
                    curl_close($ch);
                    $xml = simplexml_load_string($data);
                    $xml = json_decode(json_encode($xml), true); 
                    /*
                    $xml = get_object_vars(simplexml_load_file(G5_URL . '/sitemap.php'));
                    $xml = json_decode(json_encode($xml), true);
                    */
                ?>
                <div class='xml-codeview'>
                <textarea><?php 
                    for($i = 0; count($xml['url']) > $i; $i++){
                        var_dump($xml['url'][$i]['loc']);
                    }
                    ?></textarea>
                </div>
                <?php echo help('URL만 출력합니다.');?>
            </div>
        </div>

    </div><!--//.frm-wrap-->
    <!--
    <div class='frm-wrap'>
        <h3 class="frm-head">앱설정</h3>
        <div class='alert-info'>
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            웹사이트를 모바일 앱으로 제공한다면 앱 링크 정보를 입력하세요. 앱을 설치한 사용자가 접속시 앱으로 연결 가능하도록 도와줍니다.
        </div>

        <div class='frm-group'>
            <label class='frm-label' for='as_ios_url'><span>iOS - URL</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_ios_url" value="<?php echo $config['as_ios_url'] ?>" id="as_ios_url" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_ios_id'><span>iOS - ID</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_ios_id" value="<?php echo $config['as_ios_id'] ?>" id="as_ios_id" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_ios_name'><span>iOS - Name</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_ios_name" value="<?php echo $config['as_ios_name'] ?>" id="as_ios_name" class="frm-input size50">
                </div>
            </div>
        </div>

        <div class='frm-group'>
            <label class='frm-label' for='as_android_url'><span>Android URL</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_android_url" value="<?php echo $config['as_android_url'] ?>" id="as_android_url" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_android_package'><span>Android Package</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_android_package" value="<?php echo $config['as_android_package'] ?>" id="as_android_package" class="frm-input size50">
                </div>
            </div>
        </div>
        <div class='frm-group'>
            <label class='frm-label' for='as_android_name'><span>Android APP Name</span></label>
            <div class='frm-control'>
                <div class='frm-cont'>
                    <input type="url" name="as_android_name" value="<?php echo $config['as_android_name'] ?>" id="as_android_name" class="frm-input size50">
                </div>
            </div>
        </div>
    </div>
    -->

</section>

<div class="btn_fixed_top btn_confirm">
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>

<script>
function askseo_submit(f)
{
    $('#as_sitemap_boardlist option').prop('selected', true);
    $('#as_sitemap_contentslist option').prop('selected', true);
    f.action = "./ask_seo_update.php";
    return true;
}
</script>

<?php
include_once G5_ADMIN_PATH . '/admin.tail.php';