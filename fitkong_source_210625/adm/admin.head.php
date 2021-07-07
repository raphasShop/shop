<?php
if (!defined('_GNUBOARD_')) exit;
 
include_once(G5_ADMIN_PATH.'/admin.head.sub.php');
 
function print_menu1($key, $no) {
    global $menu;
 
    $str = print_menu2($key, $no);
 
    return $str;
}
 
function print_menu2($key, $no) {
    global $menu, $auth_menu, $is_admin, $auth, $g5, $sub_menu, $member;
 
    $str .= "<ul class=\"gnb_2dul\">";
    for($i=1; $i<count($menu[$key]); $i++) {
 
        if(!$menu[$key][$i][1])
            continue;
 
        if ($is_admin != 'super' && (!array_key_exists($menu[$key][$i][0],$auth) || !strstr($auth[$menu[$key][$i][0]], 'r')))
            continue;
        // 상단메뉴 드롭메뉴중 1로 체크한 메뉴(소그룹명) :: admin.menu100.php등으로표시된 상단메뉴설정파일
        // 디자인적용 css/admin/css 179줄~186줄 부근의 .gnb_grp_style / .gnb_grp2_style 등 css 수정하면됨
        // if (($menu[$key][$i][4] == 1 && $gnb_grp_style == false) || ($menu[$key][$i][4] != 1 && $gnb_grp_style == true))
        if ($menu[$key][$i][4] == 1)   
            $gnb_grp_div = 'gnb_grp_div';
        // 상단메뉴 드롭메뉴중 2로 체크한 메뉴(소그룹명) :: admin.menu100.php등으로표시된 상단메뉴설정파일
        // else if (($menu[$key][$i][4] == 2 && $gnb_grp_style == false) || ($menu[$key][$i][4] != 2 && $gnb_grp_style == true))
        else if ($menu[$key][$i][4] == 2) 
            $gnb_grp_div = 'gnb_grp2_div';
        else $gnb_grp_div = '';
 
        // 상단메뉴 드롭메뉴중 1로 체크한 메뉴(소그룹명) :: admin.menu100.php등으로표시된 상단메뉴설정파일
        if ($menu[$key][$i][4] == 1) $gnb_grp_style = 'gnb_grp_style';
        // 상단메뉴 드롭메뉴중 2로 체크한 메뉴(소그룹명) :: admin.menu100.php등으로표시된 상단메뉴설정파일
        else if ($menu[$key][$i][4] == 2) $gnb_grp_style = 'gnb_grp2_style';
        else $gnb_grp_style = '';
     
        if (isset($sub_menu) && $sub_menu == $menu[$key][$i][0]) $gnb_on = ' on';
        else $gnb_on = '';
        if($member['mb_id'] == 'administrator' && (($key == 'menu155' && $i == 1) || ($key == 'menu155' && $i == 2) || ($key == 'menu155' && $i == 3) || ($key == 'menu155' && $i == 4) || ($key == 'menu155' && $i == 5) || ($key == 'menu155' && $i == 6) || ($key == 'menu155' && $i == 10) || ($key == 'menu155' && $i == 16) || ($key == 'menu155' && $i == 18) || ($key == 'menu200' && $i == 3) || ($key == 'menu200' && $i == 5) || ($key == 'menu200' && $i == 6) || ($key == 'menu200' && $i == 7) || ($key == 'menu200' && $i == 9) || ($key == 'menu300' && ($i == 1 || $i == 2 || $i == 3 || $i == 4 || $i == 5 || $i == 9)) || ($key == 'menu400' && ($i == 8 || $i == 9 || $i == 10 || $i == 11)) || ($key == 'menu411' && ($i == 1 || $i == 3)) || ($key == 'menu422' && $i == 4 ) || ($key == 'menu422' && $i == 5 ) || ($key == 'menu422' && $i == 6 ) || ($key == 'menu422' && $i == 10 ) || ($key == 'menu455' && $i == 3) || ($key == 'menu500' && $i == 13) )) {} else {
            $str .= '<li class="gnb_2dli"><a href="'.$menu[$key][$i][2].'" class="gnb_2da '.$gnb_grp_style.' '.$gnb_grp_div.$gnb_on.'">'.$menu[$key][$i][1].'</a></li>';
        }
         
        $auth_menu[$menu[$key][$i][0]] = $menu[$key][$i][1];
    }
    $str .= "</ul>";
 
    return $str;
}
 
$adm_menu_cookie = array(
'container' => '',
'gnb'       => '',
'btn_gnb'   => '',
);
 
if( ! empty($_COOKIE['g5_admin_btn_gnb']) ){
    $adm_menu_cookie['container'] = 'container-small';
    $adm_menu_cookie['gnb'] = 'gnb_small';
    $adm_menu_cookie['btn_gnb'] = 'btn_gnb_open';
}
 
//전체보기 echo $listall; - 관리자모드 목록 페이지에 공통적용 - 아이스크림 (목록페이지에 있는 함수는 삭제)
$listall = '<div id="list_quick"><div class="listq_basic_icon"><a href="'.$_SERVER['SCRIPT_NAME'].'" class="at-tip" data-original-title="<nobr>전체목록</nobr>" data-toggle="tooltip" data-placement="left" data-html="true"><i class="fas fa-tasks font-13"></i></a></div></div>';
 
// 우측 고정 퀵메뉴 :: 모든페이지에 우측에 고정 (메인페이지제외)
if(!$is_admindex) {
    include_once(G5_ADMIN_PATH.'/admin.right_quick.php');
}
?>
 
<style>
/* body 관리자 모든페이지에 가로사이즈 최소사이즈지정 - #wrapper 의 min-width와 동일하게 지정해야 함 */
body {}
#inb a:hover, #left_menu a:hover, #left_menu a:focus, .gnb_1dli_on .gnb_1da, .gnb_2da:focus, .gnb_2da:hover {
    color: #FFF !important;
    /*background: #FF8BA6 !important;*/
    /*background: #007042 !important;*/
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#03e196+0,14cae0+100 */
/*outline:solid 1px #10B7C1;*/
background: #03e196; /* Old browsers */
background: -moz-linear-gradient(-45deg,  #03e196 0%, #14cae0 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(-45deg,  #03e196 0%,#14cae0 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(135deg,  #03e196 0%,#14cae0 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#03e196', endColorstr='#14cae0',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}
.gnb_1dli_air .gnb_1da {
    color: #5E990F !important;
    background: #2C2A29 !important;
    text-decoration:underline dotted !important;
    border:solid 1px #2C2A29 !important;
    border-bottom:solid 0px #2C2A29 !important;
    padding-left:12px;
    padding-right:12px;
}
</style>
 
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php echo G5_ADMIN_URL;?>/js/respond.js"></script>
<script type="text/javascript" src="<?php echo G5_ADMIN_URL;?>/js/html5shiv.js"></script>
<![endif]-->
 
<script>
var tempX = 0;
var tempY = 0;
 
function imageview(id, w, h)
{
 
    menu(id);
 
    var el_id = document.getElementById(id);
 
    //submenu = eval(name+".style");
    submenu = el_id.style;
    submenu.left = tempX - ( w + 11 );
    submenu.top  = tempY - ( h / 2 );
 
    selectBoxVisible();
 
    if (el_id.style.display != 'none')
        selectBoxHidden(id);
}
</script>
 
<!-- 선택출력되는 인크루드파일 설정 -->
<?php
//관리자모드 팝업레이어 메인노출 : 관리자 > 프로모션 > 팝업창관리에서 등록가능
if($is_admindex) { // index에서만 실행 
    include G5_ADMIN_PATH.'/newwin.inc.php'; // 관리자모드메인 팝업레이어
}
//맨위로바로가기 버튼 모바일에서 감지하기
if(G5_IS_MOBILE) {
    echo '<script src="'.G5_JS_URL.'/modernizr.custom.70111.js"></script>'.PHP_EOL; // overflow scroll 감지
}
?>
<!-- // -->
 
<!-- 맨위로 가기버튼 추가 -->
<a href="javascript:void(0);" id="Topscroll" title="맨위로" style="display: none;"><span><i class="fa fa-chevron-up font-20 white"></i></span></a>
<!--//-->
 
<div id="to_content"><a href="#container">본문 바로가기</a></div>
 
<header id="hd">
    <div id="hd_wrap">
        <div id="top_nav">
         
        
          
        <ul id="tnb">
             
            <li>
                <div id="logo"><a href="<?php echo G5_ADMIN_URL ?>" class="at-tip" data-original-title="<nobr>핏콩<br>관리자</nobr>" data-toggle="tooltip" data-placement="right" data-html="true"><img src="<?php echo G5_IMG_URL;?>/logo.png"></a></div>  
            </li>
 
            <!-- 현재접속자 -->
            <?php// if ($is_admin = 'super') { //최고관리자만 볼수있음?>
            <li id="li_connect"><a href="<?php echo G5_URL; ?>/bbs/current_connect.php" target="_blank" class="at-tip" data-original-title="<nobr>현재접속자</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true"><?php echo $connect_total_cnt;//전체접속자수?>&nbsp;<?php// echo ($connect_mb_cnt > 0) ? $connect_mb_cnt : '';//회원접속자수?><?php echo $connect_mb_cnt;//회원접속자수?></a></li>
            <?php// } ?>
            <!--//-->
        </ul>
        </div>
         
    <nav id="gnb">
        <h2>메인메뉴</h2>
        <div class="gnb_wrap">
             
            <!-- 우측 전체메뉴 아이콘(반응형) --
            <div class="pull-right quick_all">
                <button type="button" id="btn_hdcate"><i class="fa fa-bars"></i><span class="sound_only">모바일메뉴열기</span></button>       
            </div>
            <!--//-->
             
            <ul class="gnb_wrapul">
                <li class="gnb_wrapli gnb_logo">
                 
                <div class="btn_t_name" onclick="$('.toggle_name_down').toggle()">
                <?php
                    $mbicon_dir = substr($member['mb_id'],0,2);
                    $mbicon_file = G5_DATA_PATH.'/member/'.$mbicon_dir.'/'.$member['mb_id'].'.gif';
                    if (file_exists($mbicon_file)) {
                        $mbicon_url = G5_DATA_URL.'/member/'.$mbicon_dir.'/'.$member['mb_id'].'.gif';
                        echo '<img src="'.$mbicon_url.'" alt="">';
                    } else {
                        echo '<i class="fa fa-user"></i>';
                    }
                ?>
                <font class="skyblue"><?php echo iconv_substr($member['mb_nick'], 0, 6, "utf-8"); //닉네임문자자르기?></font>
                </div>
                <!-- 토글 -->
                <div class="toggle_name_down" onmouseout="$('.toggle_name_down').toggle()">
                    <a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a>
                    <a href="<?php echo G5_ADMIN_URL ?>/member_form.php?w=u&amp;mb_id=<?php echo $member['mb_id'] ?>">정보변경</a>
                    
                </div>
                <!--//-->
                 
                <!-- 내쇼핑몰 -->
                <?php if(defined('G5_USE_SHOP')) { ?>
                &nbsp;&nbsp;<a href="<?php echo G5_SHOP_URL ?>/" target="_blank" class="at-tip" data-original-title="<nobr>내쇼핑몰<br>바로가기</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true"><img src="<?php echo G5_ADMIN_URL;?>/img/shop_icon.png" border="0"></a>
                <?php } ?>
                <!--//-->
                <!-- 내홈 -->
                &nbsp;<a href="<?php echo G5_URL ?>/" target="_blank" class="at-tip" data-original-title="<nobr>내홈<br>바로가기</nobr>" data-toggle="tooltip" data-placement="bottom" data-html="true"><img src="<?php echo G5_ADMIN_URL;?>/img/home_icon.png" border="0"></a>
                <!--//-->
  
                </li>
                 
                <li class="gnb_wrapli_gnbmenubar">
                    <!-- 상단주메뉴 -->
                    <div id="gnbmenubar">
                        <ul id="gnb_1dul">
                        <?php // [상단] 관리자주메뉴
                        $gnb_str = "";
                        foreach($amenu as $key=>$value) {
                            $href1 = $href2 = '';
                            if ($menu['menu'.$key][0][2]) {
                                if($key == '155') {
                                    $href1 = '<a href="'.$menu['menu'.$key][8][2].'" class="gnb_1da">';
                                    $href2 = '</a>';
                                } else {
                                    $href1 = '<a href="'.$menu['menu'.$key][0][2].'" class="gnb_1da">';
                                    $href2 = '</a>';
                                }
                               
                            } else {
                                continue;
                            }
                            $current_class = "";
                            if (isset($sub_menu) && (substr($sub_menu, 0, 3) == substr($menu['menu'.$key][0][0], 0, 3)))
                                $current_class = " gnb_1dli_air";
                            if($member['mb_id'] == 'administrator' && ($key == '100' || $key == '111' || $key == '600' || $key == '999')){} else {
                                $gnb_str .= '<li class="gnb_1dli'.$current_class.'">'.PHP_EOL;
                                $gnb_str .=  $href1 . $menu['menu'.$key][0][1] . $href2;
                                $gnb_str .=  print_menu1('menu'.$key, 1);
                                $gnb_str .=  "</li>";
                            }
                             
                        }
                        $gnb_str .= "";
                        echo $gnb_str;
                        ?>
                        </ul>
                    </div>
                    <!--//-->
                </li>
                <!--<li><button type="button" class="gnb_menu_btn"><i class="fa fa-bars" aria-hidden="true"></i><span class="sound_only">전체메뉴열기</span></button></li>-->
            </ul>
        </div>
    </nav>
     
    </div>
     
</header>
 
<!-- 모바일 사이드 관리자메뉴바 :: 스크롤시 하단에 붙어서 표시됨 -->
<?php include_once(G5_ADMIN_PATH.'/admin.inc.menu1.php'); // @전체 관리자메뉴 ?>
    <script>
     
    $("#btn_hdcate").on("click", function() {
        $("#menusero").show();
    });
 
    $(".menu_close").on("click", function() {
        $(".menu").hide();
    });
     $(".cate_bg").on("click", function() {
        $(".menu").hide();
    });
   </script>
<!--//-->
 
 
<div id="table_wrap">
 
<!-- LEFT 좌측메뉴삽입 -->    
<?php include_once(G5_ADMIN_PATH.'/admin.left_menu.php'); // @좌측메뉴 삽입?>
<!--//-->
 
<div id="wrapper">
    <div id="container">
        <div class="left_closed cursor" onclick="$('.leftside').toggle()" title="좌측메뉴닫기">&lt;</div>
        <?php if($is_admindex || $is_order_list) { //관리자메인,주문목록 에서 숨김 ?>
 
        <?php } else { //관리자메인,주문목록 에서 숨김?>
        <div id="text_size">
            <!-- font_resize('엘리먼트id', '제거할 class', '추가할 class'); -->
            <button onclick="font_resize('container', 'ts_up ts_up2', '');"><img src="<?php echo G5_ADMIN_URL ?>/img/ts01.gif" alt="기본"></button><button onclick="font_resize('container', 'ts_up ts_up2', 'ts_up');"><img src="<?php echo G5_ADMIN_URL ?>/img/ts02.gif" alt="크게"></button><button onclick="font_resize('container', 'ts_up ts_up2', 'ts_up2');"><img src="<?php echo G5_ADMIN_URL ?>/img/ts03.gif" alt="더크게"></button>
            <!-- 전체화면보기 -->
            <div class="cursor" onclick="$('.leftside').toggle()" style="display:inline-block; margin-left:5px;" title="넓게보기">
                <i class="fa fa-arrows-h fa-lg font-18" style="color:#bbb;"></i>
            </div>
            <!--//-->
        </div>
        <h1 class="h1_title"><?php echo $g5['title'] ?></h1>
        <?php } //관리자메인,주문목록 에서 숨김 ?>