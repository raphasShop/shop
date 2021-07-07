<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
/* 관리자모드 메뉴 */

function print_mobile_menu1($key, $no='')
{
    global $menu;

    $str = print_mobile_menu2($key, $no);

    return $str;
}

function print_mobile_menu2($key, $no='')
{
    global $menu, $auth_menu, $is_admin, $auth, $g5, $sub_menu;

    $str .= "<ul>";
    for($i=1; $i<count($menu[$key]); $i++)
    {
        if ($is_admin != 'super' && (!array_key_exists($menu[$key][$i][0],$auth) || !strstr($auth[$menu[$key][$i][0]], 'r')))
            continue;

        /*if (($menu[$key][$i][4] == 1 && $gnb_grp_style == false) || ($menu[$key][$i][4] != 1 && $gnb_grp_style == true)) $gnb_grp_div = 'gnb_grp_div';*/
		if (($menu[$key][$i][4] == 1 && $gnb_grp_style == false)) $gnb_grp_div = 'gnb_grp_div';
        else $gnb_grp_div = '';

        if ($menu[$key][$i][4] == 1) $gnb_grp_style = 'gnb_grp_style';
        else $gnb_grp_style = '';

        $current_class = '';

        if ($menu[$key][$i][0] == $sub_menu){
            $current_class = ' on';
        }

        $str .= '<li data-menu="'.$menu[$key][$i][0].'"><a href="'.$menu[$key][$i][2].'" class="gnb_2da '.$gnb_grp_style.' '.$gnb_grp_div.$current_class.'">'.$menu[$key][$i][1].'</a></li>';

        $auth_menu[$menu[$key][$i][0]] = $menu[$key][$i][1];
    }
    $str .= "</ul>";

    return $str;
}

?>

<div id="menusero" class="menu">
    <!-- 닫기 -->
    <button type="button" class="menu_close">×<span class="sound_only">카테고리닫기</span></button>
    <!--//-->
    <div class="cate_bg"></div>
    
    <div class="menu_wr">
    
    <!-- @@@@@ 관리자메뉴기본표시 @@@@@ -->
    <div id="gnbindex">
        <!-- (1) 버전표시 -->
        <div class="ver">영카트NEW관리자 <b>아이스크림S9</b><br><span class="gray"> ver.</span> <span class="font-10 orange"><?php echo $icecream_ver;?></span></div>
        <!-- (2) 관리자정보표시 -->
        <div class="user">
                <!-- 관리자정보 -->
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
                    <a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" class="win_memo at-tip">내쪽지함</a>
                </div>
                <!--//-->
                
                
                <!-- 쪽지알림 -->
				<?php if(memo_recv_count($member['mb_id']) == '0') { //않읽은 메모가 없을때?>
                <!--<span class="memo_alim_none">
                    <a href="<?//php echo G5_BBS_URL ?>/memo.php" target="_blank" class="win_memo"><i class="fa far-envelope-open"></i></a>
                </span> -->
                <?php } else { //않읽은 메모가 있을때?>
                <span class="memo_alim_yes">
                    <a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" class="win_memo at-tip" data-original-title="<nobr><b>읽지않은</b><br>쪽지가 있습니다</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
                    <?php echo (memo_recv_count($member['mb_id']) > 0) ? '<div class="alarm-btn-label en bg-orangered">'.number_format(memo_recv_count($member['mb_id'])).'</div>' : '';//미확인받은쪽지표시?>
                    <i class="fas fa-envelope-open font-24"></i>
                    </a>
                </span>
                <?php } ?>
                <!--//-->
                
                <!-- 쇼핑알림 -->
                <?php if ($todayalim_all > 0) { //오늘 알림건수 있을때?>
                <span class="memo_alim_yes" style="margin:0;padding:0;">
                    <a onclick="win_adm_del('win_adm_alim​​', '<?php echo G5_ADMIN_URL; ?>/alim_today.php');" class="at-tip cursor" data-original-title="<nobr>실시간<br>쇼핑몰관리 알림</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
                    <?php echo ($todayalim_all > 0) ? '<div class="alarm-btn-label bg-orangered">'.number_format($todayalim_all).'</div>' : '';//알림건수?> 
                    <i class="fas fa-calendar-check font-24"></i>  
                    </a>
                </span>
                <?php } else { //없을때?>
                <span class="memo_alim_none" style="margin:0;padding:0;">
                    <a onclick="win_adm_del('win_adm_alim​​', '<?php echo G5_ADMIN_URL; ?>/alim_today.php');" class="at-tip cursor" data-original-title="<nobr>실시간<br>쇼핑몰관리 알림</nobr>" data-toggle="tooltip" data-placement="top" data-html="true">
                    <i class="far fa-calendar-check"></i>  
                    </a>
                </span>
                <?php } ?>
                <!--//-->
                
        </div>
        
    </div>
    <!-- @@@@@ // @@@@@ -->

    <!-- @@@@@@ 좌측메뉴@@@@@ -->
	<nav id="gnbsero" class="gnb_large <?php echo $adm_menu_cookie['gnb']; ?>">
        <!--<h2>관리자 주메뉴</h2>-->
        <ul class="gnb_ul">
            <?php
            $jj = 1;
            foreach($amenu as $key=>$value) {
                $href1 = $href2 = '';

                if ($menu['menu'.$key][0][2]) {
                    $href1 = '<a href="'.$menu['menu'.$key][0][2].'" class="gnb_1da">';
                    $href2 = '</a>';
                } else {
                    continue;
                }

                $current_class = "";
                if (isset($sub_menu) && (substr($sub_menu, 0, 3) == substr($menu['menu'.$key][0][0], 0, 3)))
                    $current_class = " on";

                $button_title = $menu['menu'.$key][0][1];
            ?>
            <li class="gnb_li<?php echo $current_class;?>">
                <button type="button" class="btn_op menu-<?php echo $key; ?> menu-order-<?php echo $jj; ?>" title="<?php echo $button_title; ?>"></button><span class="gnb_tit"><?php echo $button_title;?></span>
                <div class="gnb_oparea_wr">
                    <div class="gnb_oparea">
                        <h3><?php echo $menu['menu'.$key][0][1];?></h3>
                        <?php echo print_mobile_menu1('menu'.$key, 1); ?>
                    </div>
                </div>
            </li>
            <?php
            $jj++;
            }     //end foreach
            ?>
        </ul>
    </nav>
    <!-- @@@@@ // @@@@@-->
    
    </div>
</div>
<!-- 관리자메뉴 스크립트 -->
<script>
jQuery(function($){

    var menu_cookie_key = 'g5_admin_btn_gnb';

    $(".tnb_mb_btn").click(function(){
        $(".tnb_mb_area").toggle();
    });

    $("#btn_gnb").click(function(){
        
        var $this = $(this);

        try {
            if( ! $this.hasClass("btn_gnb_open") ){
                set_cookie(menu_cookie_key, 1, 60*60*24*365);
            } else {
                delete_cookie(menu_cookie_key);
            }
        }
        catch(err) {
        }

        $("#container").toggleClass("container-small");
        $("#gnb").toggleClass("gnb_small");
        $this.toggleClass("btn_gnb_open");

    });

    $(".gnb_ul li .btn_op" ).click(function() {
        $(this).parent().addClass("on").siblings().removeClass("on");
    });

});
</script>
<!--//-->
<script>
$(function (){

    $("button.sub_ct_toggle").on("click", function() {
        var $this = $(this);
        $sub_ul = $(this).closest("li").children("ul.sub_cate");

        if($sub_ul.size() > 0) {
            var txt = $this.text();

            if($sub_ul.is(":visible")) {
                txt = txt.replace(/닫기$/, "열기");
                $this
                    .removeClass("ct_cl")
                    .text(txt);
            } else {
                txt = txt.replace(/열기$/, "닫기");
                $this
                    .addClass("ct_cl")
                    .text(txt);
            }

            $sub_ul.toggle();
        }
    });


    $(".content li.con").hide();
    $(".content li.con:first").show();   
    $(".cate_tab li a").click(function(){
        $(".cate_tab li a").removeClass("selected");
        $(this).addClass("selected");
        $(".content li.con").hide();
        //$($(this).attr("href")).show();
        $($(this).attr("href")).fadeIn();
    });
     
});
</script>