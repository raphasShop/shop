<?php
$sub_menu = '155351'; /* 수정전 원본 메뉴코드 100320 */
include_once('./_common.php');

auth_check($auth[$sub_menu], "w");

$g5['title'] = '탑배너';

if ($w=="") {
    $sql = " select * from g5_shop_mtopbanner";
    $bn = sql_fetch($sql);
} else {
    $bn['bn_url']        = "http://";
    $bn['bn_begin_time'] = date("Y-m-d 00:00:00", time());
    $bn['bn_end_time']   = date("Y-m-d 00:00:00", time()+(60*60*24*31));
}

// 탑배너 테이블 추가 (PHP버전에 따른 설치문에러를 없애기 위한 설치문 변경) 2017-11-15
if (!isset($bn['bn_url'])) {
    if(!sql_query(" DESCRIBE g5_shop_mtopbanner ", false)) {
        sql_query(" CREATE TABLE IF NOT EXISTS g5_shop_mtopbanner (
                      `bn_id` int(11) NOT NULL auto_increment,
                      `bn_alt` varchar(255) NOT NULL default '이미지설명',
                      `bn_url` varchar(255) NOT NULL default 'http://naver.com',
                      `bn_bgcolor` varchar(255) NOT NULL default '',
                      `bn_device` varchar(255) NOT NULL default 'both',
                      `bn_position` varchar(255) NOT NULL default 'fa-times',
                      `bn_border` varchar(255) NOT NULL default '90',
                      `bn_new_win` varchar(255) NOT NULL default '1',
                      `bn_begin_time` varchar(255) NOT NULL default '2016-01-01 00:00:00',
                      `bn_end_time` varchar(255) NOT NULL default '2050-01-01 00:00:00',
                      `bn_time` varchar(255) NOT NULL default '0000-00-00 00:00:00',
                      `bn_hit` varchar(255) NOT NULL default '0',
                      `bn_order` int(255) NOT NULL default '1000',
                      `info_1` varchar(255) NOT NULL default '',
                      `info_2` varchar(255) NOT NULL default '',
                      `info_3` varchar(255) NOT NULL default '',
                      `info_4` varchar(255) NOT NULL default '',
                      `info_5` varchar(255) NOT NULL default '',
                      PRIMARY KEY (`bn_id`)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
    }

$insert_config = " insert into g5_shop_mtopbanner
           set bn_id = '1',
                bn_alt = '이미지설명',
                bn_url = 'http://naver.com',
				bn_bgcolor = '',
                bn_device = 'both',
				bn_position = 'fa-times',
				bn_border = '90',
                bn_new_win = '1',
				bn_begin_time = '2016-01-01 00:00:00',
				bn_end_time = '2016-01-02 00:00:00',
				bn_time = '0000-00-00 00:00:00',
				bn_hit = '0',
                bn_order = '1000',
                info_1 = '',
				info_2 = '',
				info_3 = '',
				info_4 = '',
                info_5 = ''";
sql_query($insert_config);

echo "<script language=javascript> 
alert(\"처음실행 DB설치완료!\"); 
top.location.href = \"./top.banner.php\";</script>"; 
exit; 
}

include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="fbanner" action="./top.banner_update.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="bn_id" value="<?php echo $bn_id; ?>">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>

    <tr>
        <th scope="row"><label for="bn_hit">총클릭수</label></th>
        <td>
            <?php echo help("배너를 클릭한 총 클릭수를 나타냅니다."); ?>
            <input type="text" name="bn_hit" size="20" value="<?php echo $bn['bn_hit']; ?>" id="bn_hit" class="frm_input">
        </td>
    </tr>

    <tr>
        <th scope="row">배너이미지</th>
        <td>
		<?php echo help('링크가 클릭되는 실제배너입니다.<br><span class="violet font-11">(기본사이즈 : <b>가로 800px, 세로 90px</b> )</span>'); ?>
            <input type="file" name="bn_bimg1">
            <?php
            $bimg_str = "";
            $bimg = G5_DATA_PATH."/mtopbanner/1";
            if (file_exists($bimg) && 1) {
                $size = @getimagesize($bimg);
                if($size[0] && $size[0] > 750)
                    $width = 750;
                else
                    $width = $size[0];

                echo '<input type="checkbox" name="bn_bimg1_del" value="1" id="bn_bimg1_del"> <label for="bn_bimg1_del">삭제</label>';
                $bimg_str = '<img src="'.G5_DATA_URL.'/mtopbanner/1" width="'.$width.'">';
            }
            if ($bimg_str) {
                echo '<div class="banner_or_img">';
                echo $bimg_str;
                echo '</div>';
            }
            ?>
        </td>
    </tr>
        <tr>
        <th scope="row">배경색상</th>
        <td>
		<?php echo help('배경색상을 RGB칼라로 등록하세요 [예] #CCCCCC'); ?>
        <input id="bn_bgcolor" class="frm_input iColorPicker" type="text" name="bn_bgcolor" value="<?php echo $bn['bn_bgcolor']; ?>">
        </td>
    </tr>
    <!--
    <tr>
        <th scope="row">배경색상</th>
        <td>
		<?php// echo help('이미지는 가로,세로 1px로 등록하세요'); ?>
            <input type="file" name="bn_bimg2">
            <?php
			/* 배경이미지를 컬러코드로 변경
            $bimg_str = "";
            $bimg = G5_DATA_PATH."/mtopbanner/2";
            if (file_exists($bimg) && 2) {
                $size = @getimagesize($bimg);
                if($size[0] && $size[0] > 750)
                    $width = 750;
                else
                    $width = $size[0];

                echo '<input type="checkbox" name="bn_bimg2_del" value="1" id="bn_bimg2_del"> <label for="bn_bimg2_del">삭제</label>';
    //            $bimg_str = '<img src="'.G5_DATA_URL.'/mtopbanner/2" width="'.$width.'">';
				$bimg_str = '<img src="'.G5_DATA_URL.'/mtopbanner/2" width="100">';	//강제크기늘림
            }
            if ($bimg_str) {
                echo '<div class="banner_or_img">';
                echo $bimg_str;
                echo '</div>';
            }
			*/
            ?>
        </td>
    </tr>
    -->
    <tr>
        <th scope="row"><label for="bn_alt">이미지 설명</label></th>
        <td>
            <?php echo help("img 태그의 alt, title 에 해당되는 내용입니다.\n배너에 마우스를 오버하면 이미지의 설명이 나옵니다."); ?>
            <input type="text" name="bn_alt" value="<?php echo $bn['bn_alt']; ?>" id="bn_alt" class="frm_input" size="80">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_url">링크</label></th>
        <td>
            <?php echo help("배너클릭시 이동하는 주소입니다."); ?>
            <input type="text" name="bn_url" size="80" value="<?php echo $bn['bn_url']; ?>" id="bn_url" class="frm_input">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_device">접속기기</label></th>
        <td>
            <?php echo help('배너를 표시할 접속기기를 선택합니다.'); ?>
            <select name="bn_device" id="bn_device">
                <option value="both"<?php echo get_selected($bn['bn_device'], 'both', true); ?>>PC와 모바일</option>
                <option value="pc"<?php echo get_selected($bn['bn_device'], 'pc'); ?>>PC</option>
                <option value="mobile"<?php echo get_selected($bn['bn_device'], 'mobile'); ?>>모바일</option>
        </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_position">닫기버튼</label></th>
        <td>
            <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank"><?php echo help("닫기버튼입니다. Font-Awesome코드를 넣어주세요. 예) fa-times"); ?></a>
                <input type="text" name="bn_position" size="20" value="<?php echo $bn['bn_position']; ?>" id="bn_position" class="frm_input">
        </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_border">배너세로길이</label></th>
        <td>
             <?php echo help("배너이미지/배너공간 공통 세로길이 입니다. (기본90px)", 50); ?>
            <input type="text" name="bn_border" size="10" value="<?php echo $bn['bn_border']; ?>" id="bn_border" class="frm_input">px
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_border">배너가로길이</label></th>
        <td>
             <?php echo help("배너공간 전체 가로길이 (기본900px). 배너이미지제작시 가로길이(800px)", 50); ?>
            <input type="text" name="bn_order" size="10" value="<?php echo $bn['bn_order']; ?>" id="bn_order" class="frm_input">px
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_new_win">새창</label></th>
        <td>
            <?php echo help("배너클릭시 새창을 띄울지를 설정합니다.", 50); ?>
            <select name="bn_new_win" id="bn_new_win">
                <option value="0" <?php echo get_selected($bn['bn_new_win'], 0); ?>>사용안함</option>
                <option value="1" <?php echo get_selected($bn['bn_new_win'], 1); ?>>사용</option>
            </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_begin_time">시작일시</label></th>
        <td>
            <?php echo help("배너 게시 시작일시를 설정합니다."); ?>
            <input type="text" name="bn_begin_time" value="<?php echo $bn['bn_begin_time']; ?>" id="bn_begin_time" class="frm_input"  size="21" maxlength="19">
            <input type="checkbox" name="bn_begin_chk" value="<?php echo date("Y-m-d 00:00:00", time()); ?>" id="bn_begin_chk" onclick="if (this.checked == true) this.form.bn_begin_time.value=this.form.bn_begin_chk.value; else this.form.bn_begin_time.value = this.form.bn_begin_time.defaultValue;">
            <label for="bn_begin_chk">오늘</label>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_end_time">종료일시</label></th>
        <td>
            <?php echo help("배너 게시 종료일시를 설정합니다."); ?>
            <input type="text" name="bn_end_time" value="<?php echo $bn['bn_end_time']; ?>" id="bn_end_time" class="frm_input" size=21 maxlength=19>
            <input type="checkbox" name="bn_end_chk" value="<?php echo date("Y-m-d 23:59:59", time()+60*60*24*31); ?>" id="bn_end_chk" onclick="if (this.checked == true) this.form.bn_end_time.value=this.form.bn_end_chk.value; else this.form.bn_end_time.value = this.form.bn_end_time.defaultValue;">
            <label for="bn_end_chk">오늘+31일</label>
        </td>
    </tr>
    </tbody>
    </table>
</div>
<!--
<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="./top.banner.php">목록</a>
</div>
-->
<!-- 맨하단 고정 버튼 추가 #bq_right1 (관련수정 : admin.css파일 397줄 부근) -->
<div id="bq_right1">   
    <div class="bq_basic">
    <a href="./top.banner.php"><i class="fas fa-tasks"></i> 목록</a>
    </div>
    
    <div class="bq_basic_submit">
    <input type="submit" value="확인" accesskey="s">
    </div>
</div>
<!--//-->

</form>

<div class="h30"><!--//--></div>
<div class="div-note">
    <ul>
        <li class="content-list-title">
        출력할곳에 표시함
        </li>
        <li class="content-list-txt1">
        include_once(G5_PATH.'/plugin/banner-mtop/banner.php');
        </li>
    </ul>
</div>


<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
