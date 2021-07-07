<?php
if (!defined('_GNUBOARD_')) exit;
include_once('./_common.php');
 
#######################################################################################
/* 관리자모드 좌측에 표시되는 좌측 기본 메뉴 [아이스크림 소스] */
// 삽입함수 include_once(G5_ADMIN_PATH.'/admin.left_menu.php');
#######################################################################################
?>
<!-- 좌측 관리자메뉴 -->
 
    <div id="left_wrap" class="leftside"><!-- 좌측 관리자설정메뉴 -->
         
        <!-- [주문관리에서만 노출] PG사정보 -->
        <?php if($is_order_list && $member['mb_id'] == 'acropass') { //주문관리페이지에서만 보여짐 ?>
        <!-- PG사 이용정보/상점관리자바로가기 -->
        <div id="left_service" style="background:#fafafa; border-top:solid 2px #fff;">
            <ul class="serv">
                <!-- PG사정보 -->
                <li>
                    <?php if($default['de_kcp_site_key'] !== '' || $config['cf_lg_mert_key'] !== '' || $default['de_inicis_admin_key'] !== '' || $default['de_inicis_sign_key'] !== '') { //PG사사용시?>
                        <i class="fa fa-credit-card fa-lg"></i> PG사
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pgpay.php">
                        <span class="pull-right font-bold">
                        <?php echo ($default['de_pg_service'] == 'kcp') ? '<span class="darkgreen">NHN KCP</span>' : '';?>
                        <?php echo ($default['de_pg_service'] == 'lg') ? '<span class="pink">LG유플러스</span>' : '';?>
                        <?php echo ($default['de_pg_service'] == 'inicis') ? '<span class="blue">KG이니시스</span>' : '';?>
                        </span>
                        </a>
                    <?php } else { //PG사미사용시?>
                        <i class="fa fa-credit-card fa-lg"></i> PG결제<br>
                        <span class="lightpink">미사용</span>
                        <span class="pull-right font-bold">
                            <a href="<?php echo G5_ADMIN_URL;?>/service.php"><button>PG신청</button></a>
                            <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pgpay.php"><button>상점키입력</button></a>
                        </span>
                    <?php } ?>        
                </li>
                <!-- // -->
                <?php if($default['de_kcp_site_key'] !== '' || $config['cf_lg_mert_key'] !== '' || $default['de_inicis_admin_key'] !== '' || $default['de_inicis_sign_key'] !== '') { //PG사사용시?>
                <!-- 상점관리자바로가기 -->
                <li>
                    &nbsp;┗
                    <span class="pull-right font-11">
                    <?php if($default['de_pg_service'] == 'kcp') { //kcp상점?>
                        <a href="http://admin.kcp.co.kr" target="_blank" class="at-tip" data-original-title="<nobr>NHN KCP상점관리</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-home fa-lg"></i> 상점관리</a>&nbsp;
                        <a href="http://testadmin8.kcp.co.kr" target="_blank" class="at-tip" data-original-title="<nobr>테스트상점관리</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-cog"></i> 테스트관리</a>
                    <?php } else if($default['de_pg_service'] == 'lg') { //lg유플러스상점?>
                        <a href="https://pgweb.uplus.co.kr/" target="_blank" class="at-tip" data-original-title="<nobr>LG유플러스상점관리</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><span class="black"><i class="fa fa-home fa-lg"></i> 상점관리</span></a>&nbsp;
                        <a href="https://pgweb.uplus.co.kr/tmert" target="_blank" class="at-tip" data-original-title="<nobr>테스트상점관리</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-cog"></i> 테스트관리</a>
                    <?php } else if($default['de_pg_service'] == 'inicis') { //이니시스상점?>
                        <a href="https://iniweb.inicis.com/" target="_blank" class="at-tip" data-original-title="<nobr>KG이니시스상점관리</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-home fa-lg"></i> 상점관리</a>
                    <?php } else { //기타?>
                     
                    <?php } //완료?>
                    </span>
                </li>
                <!-- // -->
                <?php } //PG사사용시?>    
            </ul>
        </div>
        <!-- // -->
         
        <!-- 알뱅킹 이용정보/상점관리자바로가기 -->
        <div id="left_service" style="background:#fafafa; border-top:solid 2px #fff;">
            <ul class="serv">
                <?php if($default['apibox_use'] == '1') { //알뱅킹 사용시?>
                <li><span class="skyblue"><b>자동입금확인</b>서비스 <b>이용중</b></span></li>
                <?php } else { ?>
                <li><span class="lightpink"><b>자동입금확인</b>을 사용하지않음</span></li>
                <?php } ?>    
                <!-- 알뱅킹 정보 -->
                <li>
                    <?php if($default['apibox_use'] == '1') { //알뱅킹 사용시?>
                        <i class="fa fa-spinner fa-lg"></i> 알뱅킹서비스
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_apibox.php">
                        <span class="pull-right font-bold darkgreen">
                        APIBOX
                        </span>
                        </a>
                    <?php } else { //알뱅킹 미사용시?>
                        미사용중
                        <span class="pull-right font-bold" style="color:#666;">
                            <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_apibox.php"><button>알뱅킹신청</button></a>
                        </span>
                    <?php } ?>        
                </li>
                <!-- // -->
                <?php if($default['apibox_use'] == '1') { //알뱅킹 사용시?>
                <!-- 상점관리자바로가기 -->
                <li>
                    &nbsp;┗
                    <span class="pull-right font-11">
                        <a href="http://www.apibox.kr/bank/bank.return.php" target="_blank" class="at-tip" data-original-title="<nobr>입금통보관리</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-home fa-lg"></i> 입금통보관리</a>&nbsp;
                    </span>
                </li>
                <!-- // -->
                <?php } //알뱅킹사용시?>    
            </ul>
        </div>
        <!-- // -->
        <?php } //주문관리페이지에서만 보여짐?>
        <!-- // -->
 
 
        <ul id="left_menu">
        <?php // [좌측] 관리자메뉴
            foreach($amenu as $key=>$value) {
                if ($menu['menu'.$key][0][2]) {
                    if (isset($sub_menu) && $sub_menu && (substr($sub_menu, 0, 3) == substr($menu['menu'.$key][0][0], 0, 3))) {
 
                        echo '<li><a href="'.$menu['menu'.$key][0][2].'" class="on"><i class="fa fa-chevron-down fa-lg"></i> '.$menu['menu'.$key][0][1].'</a>';
 
                        $menu_key = substr($sub_menu, 0, 3);
                        $bus = '';
                        foreach($menu['menu'.$menu_key] as $key=>$value) {
                            if($key > 0) {
                                if ($is_admin != 'super' && (!array_key_exists($value[0],$auth) || !strstr($auth[$value[0]], 'r')))
                                    continue;
 
                                if($member['mb_id'] == 'administrator' && (($menu_key == '155' && ($key == 1 || $key == 2 || $key == 3 || $key == 4 || $key == 5 || $key == 6 || $key == 7 || $key == 8 || $key == 9)) || ($menu_key == '200' && ($key == 3 || $key == 6 || $key == 7 || $key == 9)) || ($menu_key == '300' && ($key == 1 || $key == 2 || $key == 3 || $key == 4 || $key == 5 || $key == 9)) || ($menu_key == '400' && ($key == 8 || $key == 9 || $key == 10 || $key == 11)) || ($menu_key == '411' && ($key == 1 || $key == 3)) || ($menu_key == '422' && $key == 10) || ($menu_key == '455' && $key == 3) || ($menu_key == '500' && $key == 13))) {} else {
                                        $onmenu = ($sub_menu == $value[0]) ? ' class="on"' : '';
                                        $bus .= '<li><a href="'.$value[2].'"'.$onmenu.'>'.$value[1].'</a></li>'.PHP_EOL;
                                }
                            }
                        }
 
 
                        if($bus) echo '<ul>'.$bus.'</ul>'.PHP_EOL;
 
                        echo '</li>'.PHP_EOL;
                    }
                     
                } else {
                    continue;
                }
            }
        ?>
        </ul>
            
        <!-- [관리자메인에서만노출] 관리자서비스이용정보 -->
        <?php if($is_admindex && $member['mb_id'] == 'acropass') { //관리자메인에서만 보여짐 ?>
        <!-- 영카트테마이용정보 -->
        <div id="left_service" style="background:#f7f7f7;">
            <ul class="serv">
                <?php if($config['cf_theme']) { ?>
                <li><span class="skyblue">영카트테마를 사용중입니다</span></li>
                <?php } else { ?>
                <li><span class="lightpink">영카트테마 사용하지 않음</span></li>
                <?php } ?>    
                <li>
                    <?php if($config['cf_theme']) { ?>
                        <i class="fa fa-life-ring"></i> 테마
                        <span class="pull-right font-bold blue"><?php echo $config['cf_theme']; ?></span>
                    <?php } else { ?>
                        미사용중
                        <span class="pull-right font-bold" style="text-decoration:underline; color:#666;">
                        <a href="<?php echo G5_ADMIN_URL;?>/theme.php" class="at-tip" data-original-title="<nobr>영카트테마를 사용하세요</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
                        테마사용하기
                        </a>
                        </span>
                    <?php } ?>        
                </li>
                <?php if($config['cf_theme']) { ?>
                <li>
                    &nbsp;┗
                    <span class="pull-right font-11">
                    <a href="<?php echo G5_ADMIN_URL;?>/theme.php" class="at-tip font-11 gray" data-original-title="<nobr>테마보관함</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-refresh"></i> 테마변경</a>&nbsp;
                    <a href="<?php echo G5_URL;?>/theme/<?php echo $config['cf_theme']; ?>/theme_adm/" target="_blank" class="at-tip" data-original-title="<nobr><?php echo $config['cf_theme']; ?> 관리자모드</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-cog"></i> 관리자</a>
                    </span>
                </li>
                <?php } ?>    
            </ul>
        </div>
        <!-- // -->   
         
        <!-- PG사 이용정보/상점관리자바로가기 -->
        <div id="left_service" style="background:#fafafa; border-top:solid 2px #fff;">
            <ul class="serv">
                <?php if($default['de_kcp_site_key'] == '' && $config['cf_lg_mert_key'] == '' && $default['de_inicis_admin_key'] == '' && $default['de_inicis_sign_key'] == '') { ?>
                <li><b class="lightpink">PG서비스를 신청하세요</b></li>
                <?php } else { ?>
                <li><span class="skyblue"><b>PG서비스</b>를 <b>이용중</b>입니다</span></li>
                <?php } ?>    
                <!-- PG사정보 -->
                <li>
                    <?php if($default['de_kcp_site_key'] !== '' || $config['cf_lg_mert_key'] !== '' || $default['de_inicis_admin_key'] !== '' || $default['de_inicis_sign_key'] !== '') { //PG사사용시?>
                        <i class="fa fa-credit-card fa-lg"></i> PG사
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pgpay.php">
                        <span class="pull-right font-bold">
                        <?php echo ($default['de_pg_service'] == 'kcp') ? '<span class="darkgreen">NHN KCP</span>' : '';?>
                        <?php echo ($default['de_pg_service'] == 'lg') ? '<span class="pink">LG유플러스</span>' : '';?>
                        <?php echo ($default['de_pg_service'] == 'inicis') ? '<span class="blue">KG이니시스</span>' : '';?>
                        </span>
                        </a>
                    <?php } else { //PG사미사용시?>
                        미사용중
                        <span class="pull-right font-bold" style="color:#666;">
                            <a href="<?php echo G5_ADMIN_URL;?>/service.php"><button>PG신청</button></a>
                            <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pgpay.php"><button>상점키입력</button></a>
                        </span>
                    <?php } ?>        
                </li>
                <!-- // -->
                <?php if($default['de_kcp_site_key'] !== '' || $config['cf_lg_mert_key'] !== '' || $default['de_inicis_admin_key'] !== '' || $default['de_inicis_sign_key'] !== '') { //PG사사용시?>
                <!-- 상점관리자바로가기 -->
                <li>
                    &nbsp;┗
                    <span class="pull-right font-11">
                    <?php if($default['de_pg_service'] == 'kcp') { //kcp상점?>
                        <a href="http://admin.kcp.co.kr" target="_blank" class="at-tip" data-original-title="<nobr>NHN KCP상점관리</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-home fa-lg"></i> 상점관리</a>&nbsp;
                        <a href="http://testadmin8.kcp.co.kr" target="_blank" class="at-tip" data-original-title="<nobr>테스트상점관리</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-cog"></i> 테스트관리</a>
                    <?php } else if($default['de_pg_service'] == 'lg') { //lg유플러스상점?>
                        <a href="https://pgweb.uplus.co.kr/" target="_blank" class="at-tip" data-original-title="<nobr>LG유플러스상점관리</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><span class="black"><i class="fa fa-home fa-lg"></i> 상점관리</span></a>&nbsp;
                        <a href="https://pgweb.uplus.co.kr/tmert" target="_blank" class="at-tip" data-original-title="<nobr>테스트상점관리</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-cog"></i> 테스트관리</a>
                    <?php } else if($default['de_pg_service'] == 'inicis') { //이니시스상점?>
                        <a href="https://iniweb.inicis.com/" target="_blank" class="at-tip" data-original-title="<nobr>KG이니시스상점관리</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-home fa-lg"></i> 상점관리</a>
                    <?php } else { //기타?>
                     
                    <?php } //완료?>
                    </span>
                </li>
                <!-- // -->
                <!-- 에스크로서비스 -->
                <li>
                    <i class="fa fa-bluetooth"></i> 에스크로
                        <span class="pull-right">
                        <?php if($default['de_escrow_use'] == '0') { //에스크로 미사용시?>
                            <?php if($default['de_pg_service'] == 'kcp') { //kcp상점?>
                                <a href="http://admin.kcp.co.kr" target="_blank" class="at-tip" data-original-title="<nobr>결제서비스이용중이신<br>PG사 상점관리자페이지에서<br>신청이 가능합니다</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
                            <?php } else if($default['de_pg_service'] == 'lg') { //lg유플러스상점?>
                                <a href="https://pgweb.uplus.co.kr/" target="_blank" class="at-tip" data-original-title="<nobr>결제서비스이용중이신<br>PG사 상점관리자페이지에서<br>신청이 가능합니다</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
                            <?php } else if($default['de_pg_service'] == 'inicis') { //이니시스상점?>
                                <a href="https://iniweb.inicis.com/" target="_blank" class="at-tip" data-original-title="<nobr>결제서비스이용중이신<br>PG사 상점관리자페이지에서<br>신청이 가능합니다</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
                            <?php } //완료?>
                            <button>신청</button></a>
                             
                            <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pgpay.php#anc_scf_pg" class="at-tip" data-original-title="<nobr>에스크로서비스 승인이 되셨으면<br>쇼핑몰관리자에서 사용으로<br>체크하시면 쇼핑몰에 적용됩니다</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><button>사용설정</button></a>
                        <?php } else { ?>
                            <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pgpay.php#anc_scf_pg">사용중</a>
                        <?php } ?>
                        </span>
                </li>
                <!-- //-->
                <!-- 삼성페이(이니시스) -->
                <?php if($default['de_pg_service'] == 'inicis') { //이니시스이용시 삼성페이표시?>
                <li>
                    <i class="fa fa-bluetooth"></i> 삼성페이
                        <span class="pull-right">
                        <?php if($default['de_pg_service'] == 'inicis' && $default['de_samsung_pay_use'] !== '1') { ?>
                            <a href="http://sir.kr/main/service/samsungpay.php" target="_blank"><button>신청</button></a>
 
                        <?php } else if($default['de_pg_service'] == 'inicis' && $default['de_samsung_pay_use'] == '1') { ?>
                            <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pgpay.php#anc_scf_kgpay">사용중</a>
                        <?php } ?>
                        </span>
                </li>
                <?php } ?>
                <!--//-->
                <?php } ?>    
                 
                <!-- 카카오페이 -->
                <li>
                    <i class="fa fa-bluetooth"></i> 카카오페이
                        <span class="pull-right">
                        <?php if($default['de_kakaopay_mid'] == '' && $default['de_kakaopay_key'] == '' && $default['de_kakaopay_enckey'] == '' && $default['de_kakaopay_hashkey'] == '') { ?>
                            <a href="http://with.kakao.com/kakaopay/index" target="_blank"><button>신청</button></a>
                        <?php } else { ?>
                            <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pgpay.php#anc_scf_kakao">사용중</a>
                        <?php } ?>
                        </span>
                </li>
                <!-- 네이버페이 -->
                <li>
                    <i class="fa fa-bluetooth"></i> 네이버페이
                        <span class="pull-right">
                        <?php if($default['de_naverpay_mid'] == '' && $default['de_naverpay_cert_key'] == '' && $default['de_naverpay_button_key'] == '') { ?>
                            <a href="https://admin.pay.naver.com/about" target="_blank"><button>신청</button></a>
                        <?php } else if($default['de_naverpay_test'] == '1' && $default['de_naverpay_mb_id'] !== '') { ?>
                            <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pgpay.php#anc_scf_npay">검수중</a>
                        <?php } else { ?>
                            <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pgpay.php#anc_scf_npay">사용중</a>
                        <?php } ?>
                        </span>
                </li>
                <!--//--> 
            </ul>
        </div>
        <!-- // -->
         
        <!-- 알뱅킹 이용정보/상점관리자바로가기 -->
        <div id="left_service" style="background:#fafafa; border-top:solid 2px #fff;">
            <ul class="serv">
                <?php if($default['apibox_use'] == '1') { //알뱅킹 사용시?>
                <li><span class="skyblue"><b>자동입금확인</b>서비스 <b>이용중</b></span></li>
                <?php } else { ?>
                <li><span class="lightpink"><b>자동입금확인</b>을 사용하지않음</span></li>
                <?php } ?>    
                <!-- 알뱅킹 정보 -->
                <li>
                    <?php if($default['apibox_use'] == '1') { //알뱅킹 사용시?>
                        <i class="fa fa-spinner fa-lg"></i> 알뱅킹서비스
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_apibox.php">
                        <span class="pull-right font-bold darkgreen">
                        APIBOX
                        </span>
                        </a>
                    <?php } else { //알뱅킹 미사용시?>
                        미사용중
                        <span class="pull-right font-bold" style="color:#666;">
                            <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_apibox.php"><button>알뱅킹신청</button></a>
                        </span>
                    <?php } ?>        
                </li>
                <!-- // -->
                <?php if($default['apibox_use'] == '1') { //알뱅킹 사용시?>
                <!-- 상점관리자바로가기 -->
                <li>
                    &nbsp;┗
                    <span class="pull-right font-11">
                        <a href="http://www.apibox.kr/bank/bank.return.php" target="_blank" class="at-tip" data-original-title="<nobr>입금통보관리</nobr>" data-toggle="tooltip" data-placement="top" data-html="true"><i class="fa fa-home fa-lg"></i> 입금통보관리</a>&nbsp;
                    </span>
                </li>
                <!-- // -->
                <?php } //알뱅킹사용시?>    
            </ul>
        </div>
        <!-- // -->
         
        <!-- PG 테스트/실결제 이용정보 -->
        <?php if($default['de_card_test'] == 1) { //테스트결제사용시?>
        <div id="left_service2" style="background:#D497ED;">
            <h5 style="color:#fff;">
                <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pgpay.php#anc_scf_pg"><span class="white">변경</span><i class="fa fa-asterisk white"></i></a>
                <span class="pull-right">
                    테스트결제<span class="font-normal">(판매불가)</span>
                </span>
            </h5>
        </div>
        <?php } else {//실결제사용시 ?>
        <div id="left_service2" style="background:#8BD2F8;">
            <h5 style="color:#fff;">
                <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pgpay.php#anc_scf_pg"><i class="fa fa-credit-card fa-lg white"></i></a>
                <span class="pull-right">
                    실결제사용중<span class="font-normal">(판매가능)</span>
                </span>
            </h5>
        </div>        
        <?php } ?>
        <!--//-->
         
        <!-- 유료서비스이용정보 -->
        <div id="left_service2">
            <h5>서비스</h5>
            <ul class="serv">
            <?php
            // SMS 정보
            if ($config['cf_sms_use'] && $config['cf_icode_id'] && $config['cf_icode_pw']) {
                $userinfo = get_icode_userinfo($config['cf_icode_id'], $config['cf_icode_pw']);
            }
            ?>
                <li>
                    <i class="fa fa-bluetooth"></i> SMS잔액
                    <a href="<?php echo G5_ADMIN_URL;?>/sms_admin/config.php">
                        <span class="pull-right">
                        <?php echo ($userinfo['coin'] > 0) ? '<b>'.display_price(intval($userinfo['coin'])).'</b>' : '잔액없음';?>
                        </span>
                    </a>
                </li>
                <li>
                    <i class="fa fa-bluetooth"></i> 본인확인
                        <span class="pull-right">
                        <?php if($config['cf_cert_use'] == '0') { ?><a href="<?php echo G5_ADMIN_URL;?>/service.php"><button>신청</button></a>
                        <?php } else if($config['cf_cert_use'] == '1') { ?><a href="<?php echo G5_ADMIN_URL;?>/config_ipin.php">테스트중</a>
                        <?php } else if($config['cf_cert_use'] == '2') { ?><a href="<?php echo G5_ADMIN_URL;?>/config_ipin.php">사용중</a>
                        <?php } ?>
                        </span>
                    </a>
                </li>
                <li>
                    <i class="fa fa-bluetooth"></i> 배송
                        <span class="pull-right">
                            <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_delivery.php#anc_deliv_company">
                            <?php if($default['de_delivery_company'] == '') { ?>
                            <button>등록</button>
                            <?php } else { ?>
                            <?php echo $default['de_delivery_company']; ?>
                            <?php } ?>
                            </a>
                        </span>
                </li>
            </ul>
        </div>
        <!--//-->
         
        <!-- 사이트설정 -->
        <div id="left_service2">
            <h5>사이트설정</h5>
            <ul class="serv">
                <li>
                    회원가입쿠폰
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_reg_benefit.php">
                        <?php if($default['de_member_reg_coupon_use'] == 1) { //쿠폰발행?>
                            <b><?php echo number_format($default['de_member_reg_coupon_price']);?></b>
                        <?php } else { ?>
                            <font class="gray">안함</font>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                <li>
                    회원가입적립금
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_reg_benefit.php">
                        <?php if($config['cf_register_point'] > 0) { //사용함?>
                            <b><?php echo number_format($config['cf_register_point']);?></b>
                        <?php } else { ?>
                            <font class="gray">안함</font>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                <li>
                    회원가입메일인증
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/config_reg_basic.php">
                        <?php if($config['cf_use_email_certify'] == 1) { //사용함?>
                            사용중
                        <?php } else { ?>
                            <font class="gray">안함</font>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                <li>
                    네이버신디케이션
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/config_syndi.php">
                        <?php if($config['cf_syndi_token']) { //사용함?>
                            사용중
                        <?php } else { ?>
                            <font class="gray">안함</font>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                <li>
                    사용후기작성
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/configform.php#anc_scf_etc">
                        <?php if($default['de_item_use_write'] == 1) { //사용함?>
                            구매회원만
                        <?php } else { ?>
                            <font class="gray">제한없음</font>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                <li>
                    사용후기출력
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/configform.php#anc_scf_etc">
                        <?php if($default['de_item_use_use'] == 1) { //사용함?>
                            관리자승인
                        <?php } else { ?>
                            <font class="gray">즉시출력</font>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                <li>
                    비회원장바구니
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/configform.php#anc_scf_etc">
                        <?php if($default['de_guest_cart_use'] == 1) { //사용함?>
                            담기가능
                        <?php } else { ?>
                            <font class="gray">불가</font>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                <li>
                    장바구니보관일
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/configform.php#anc_scf_etc">
                        <?php if($default['de_cart_keep_term']) { //사용함?>
                            <b><?php echo $default['de_cart_keep_term'];?></b> 일
                        <?php } else { ?>
                            <font class="gray">없음</font>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                
            </ul>
        </div>
        <!--//-->
         
        <!-- 결제수단 이용정보 -->
        <div id="left_service2">
            <h5>결제수단설정</h5>
            <ul class="serv">
                <li>
                    무통장
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pay.php">
                        <?php if($default['de_bank_use'] == '1') { //사용함?>
                            <i class="fa fa-toggle-on fa-lg font-18" title="사용중"></i>
                        <?php } else { ?>
                            <i class="fa fa-toggle-off fa-lg font-18 gray" title="사용않함"></i>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                <li>
                    계좌이체
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pay.php">
                        <?php if($default['de_iche_use'] == '1') { //사용함?>
                            <i class="fa fa-toggle-on fa-lg font-18" title="사용중"></i>
                        <?php } else { ?>
                            <i class="fa fa-toggle-off fa-lg font-18 gray" title="사용않함"></i>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                <li>
                    가상계좌
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pay.php">
                        <?php if($default['de_vbank_use'] == '1') { //사용함?>
                            <i class="fa fa-toggle-on fa-lg font-18" title="사용중"></i>
                        <?php } else { ?>
                            <i class="fa fa-toggle-off fa-lg font-18 gray" title="사용않함"></i>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                <li>
                    휴대폰결제
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pay.php">
                        <?php if($default['de_hp_use'] == '1') { //사용함?>
                            <i class="fa fa-toggle-on fa-lg font-18" title="사용중"></i>
                        <?php } else { ?>
                            <i class="fa fa-toggle-off fa-lg font-18 gray" title="사용않함"></i>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                <li>
                    신용카드결제
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pay.php">
                        <?php if($default['de_card_use'] == '1') { //사용함?>
                            <i class="fa fa-toggle-on fa-lg font-18" title="사용중"></i>
                        <?php } else { ?>
                            <i class="fa fa-toggle-off fa-lg font-18 gray" title="사용않함"></i>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                <li>
                    무이자할부
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pay.php">
                        <?php if($default['de_card_noint_use'] == '1') { //사용함?>
                            <i class="fa fa-toggle-on fa-lg font-18" title="사용중"></i>
                        <?php } else { ?>
                            <i class="fa fa-toggle-off fa-lg font-18 gray" title="사용않함"></i>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                <li>
                    간편결제버튼
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pay.php">
                        <?php if($default['de_easy_pay_use'] == '1') { //사용함?>
                            <i class="fa fa-toggle-on fa-lg font-18" title="사용중"></i>
                        <?php } else { ?>
                            <i class="fa fa-toggle-off fa-lg font-18 gray" title="사용않함"></i>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                <li>
                    현금영수증
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pay.php">
                        <?php if($default['de_taxsave_use'] == '1') { //사용함?>
                            <i class="fa fa-toggle-on fa-lg font-18" title="사용중"></i>
                        <?php } else { ?>
                            <i class="fa fa-toggle-off fa-lg font-18 gray" title="사용않함"></i>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                <li>
                    포인트사용
                        <span class="pull-right">
                        <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_pay.php">
                        <?php if($config['cf_use_point'] == '1') { //사용함?>
                            <i class="fa fa-toggle-on fa-lg font-18" title="사용중"></i>
                        <?php } else { ?>
                            <i class="fa fa-toggle-off fa-lg font-18 gray" title="사용않함"></i>
                        <?php } ?>
                        </a>
                        </span>
                </li>
                
            </ul>
        </div>
        <!--//-->
  
        <?php } //관리자메인에서만 보여짐 ?>
        <!-- // -->
 
        <!-- 회사정보 -->
        <?php if ($member['mb_id'] == acropass) { ?>
        <div id="left_company">
            <ul class="serv">
            <h5>
            사업자정보
            <span class="pull-right">
                <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/configform.php#anc_scf_info"><button>EDIT</button></a>
            </span>
            </h5>
             
                <li>
                    <b>ㆍ</b>상호 :
                    <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/configform.php#anc_scf_info">
                        <?php echo $default['de_admin_company_name']; ?>
                    </a>
                </li>
                <li>
                    <b>ㆍ</b>대표 :
                    <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/configform.php#anc_scf_info">
                        <?php echo $default['de_admin_company_owner']; ?>
                    </a>
                </li>
                <li>
                    <b>ㆍ</b>주소 :
                    <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/configform.php#anc_scf_info">
                        <?php echo $default['de_admin_company_addr']; ?>
                    </a>
                </li>
                <li>
                    <b>ㆍ</b>전화 :
                    <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/configform.php#anc_scf_info">
                        <?php echo $default['de_admin_company_tel']; ?>
                    </a>
                </li>
                <li>
                    <b>ㆍ</b>책임자 :
                    <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/configform.php#anc_scf_info">
                        <?php echo $default['de_admin_info_name']; ?>
                    </a>
                </li>
                <li>
                    <b>ㆍ</b>메일 :
                    <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/configform.php#anc_scf_info">
                        <?php echo $default['de_admin_info_email']; ?>
                    </a>
                </li>
                <li>
                    <b>ㆍ</b>사업자번호 :
                    <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/configform.php#anc_scf_info">
                        <?php echo $default['de_admin_company_saupja_no']; ?>
                    </a>
                </li>
                <li>
                    <b>ㆍ</b>통신판매 :
                    <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/configform.php#anc_scf_info">
                        <?php echo $default['de_admin_tongsin_no']; ?>
                    </a>
                </li>
                <?php if($default['de_admin_buga_no']) {?>
                <li>
                    <b>ㆍ</b>부가통신 :
                    <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/configform.php#anc_scf_info">
                        <?php echo $default['de_admin_buga_no']; ?>
                    </a>
                </li>
                <li>
                    <b>ㆍ</b>반품주소 :
                    <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_return.php#anc_return_addr">
                        <span class="violet">(<?php echo $default['de_admin_return_zip']; ?>) <?php echo $default['de_admin_return_addr']; ?></span>
                    </a>
                     
                    <a href="<?php echo G5_ADMIN_URL;?>/shop_admin/config_return.php#anc_return_addr"><button>EDIT</button></a>
                </li>
                <?php } ?>               
            </ul>
        </div>
        <!--//-->
    <? } ?>
         
        <!-- 아이스크림 카피라이트 표시 -->
        <div id="left_brand">
            <ul class="cont">
                <li>
                    <!--내용-->
                </li>
            </ul>
        </div>
        <!--//-->
 
    </div><!-- 좌측 관리자설정메뉴 끝 -->