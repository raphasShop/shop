<?php
################################################
//data폴더의 썸네일/캡챠/캐시/세션을 삭제합니다
################################################
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

/*최고관리자만 실행*/
if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.', G5_URL);
/*최고관리자만 실행*/

$g5['title'] ='사이트 기록삭제 최적화';
include_once(G5_ADMIN_PATH.'/admin.head.sub.php');
?>
<style>
/********************************************************
■ 타이틀
********************************************************/
.pop_h2 { height:40px;margin:0px; padding:0px 15px;font-family: Malgun Gothic,"맑은 고딕",Nanum Gothic,"나눔고딕",AppleGothic,Dotum,"돋움","Helvetica Neue", Helvetica, Arial, sans-serif;font-size:1.2em;color:#2B313F;font-weight:700;letter-spacing:-0.5px;line-height:40px;border-bottom:1px solid #d3d3d3; background-color:#fcfcfc; }
/********************************************************
■ 레이아웃
********************************************************/
.pop_layout { padding:40px 25px 30px; }
</style>

<!-- 타이틀표시-->
<div class="pop_h2">
    <a href="javascript:location.reload()" title="새로고침"><i class="fa fa-refresh font-15 skyblue p-lr5"></i></a>
    사이트 기록삭제 알림창&nbsp;&nbsp;&nbsp;<span style="font-family:돋움,dotum; font-size:12px; font-weight:normal; color:#666666;">data폴더의 썸네일/캡챠/캐시/세션을 삭제합니다</span>
    <div class="pull-right">
	<?php echo $frm_submit; ?>
    <a href="#" onclick="window.close();parent.opener.location.reload();" style="position:absolute; top:0; right:0;  padding:0px 10px; font-family:돋움,dotum; font-size:20px;font-weight:lighter;color:#777;" title="창닫기">×</a>
    </div>
</div>
<!--//-->

<?php /* 전체 레이아웃 감싸기 열기 */    echo '<div class ="pop_layout">'; ?>

<div class="local_desc02 local_desc">
    <p>
        완료 메세지가 나오기 전에 프로그램의 실행을 중지하지 마십시오.
    </p>
</div>

<!-- 썸네일 삭제 -->
<?php
$directory = array();
$dl = array('file', 'editor', 'item');

foreach($dl as $val) {
	$dir = G5_DATA_PATH.'/'.$val;

	if(!is_dir($dir)) continue;

	if($handle = opendir($dir)) {
        while(false !== ($entry = readdir($handle))) {
            if($entry == '.' || $entry == '..')
                continue;

            $path = G5_DATA_PATH.'/'.$val.'/'.$entry;

            if(is_dir($path))
                $directory[] = $path;
        }
    }
}

$ds = array('banner', 'content', 'event', 'faq');
foreach($ds as $val) {
	$dir = G5_DATA_PATH.'/'.$val;

	if(!is_dir($dir)) continue;

	$directory[] = $dir;
}

flush();

if (empty($directory)) {
    echo '<p>썸네일디렉토리를 열지못했습니다.</p>';
}

$cnt=0;
echo '<ul>'.PHP_EOL;

foreach($directory as $dir) {
    $files = glob($dir.'/thumb-*');
    if (is_array($files)) {
        foreach($files as $thumbnail) {
            $cnt++;
            @unlink($thumbnail);

            echo '<li>'.$thumbnail.'</li>'.PHP_EOL;

            flush();

            if ($cnt%10==0)
                echo PHP_EOL;
        }
    }
}

echo '<li>썸네일 삭제 실행 완료</li></ul>'.PHP_EOL;
echo '<div class="local_desc01 local_desc"><p><strong>썸네일 '.$cnt.'건의 삭제 완료됐습니다.</strong><br>프로그램의 실행을 끝마치셔도 좋습니다.</p></div>'.PHP_EOL;
?>
<!-- 썸네일 삭제 //-->

<!-- 캡챠파일 삭제 -->
<?php
flush();

if (!$dir=@opendir(G5_DATA_PATH.'/cache')) {
    echo '<p>캐시디렉토리를 열지못했습니다.</p>';
}

$cnt=0;
echo '<ul>'.PHP_EOL;

$files = glob(G5_DATA_PATH.'/cache/?captcha-*');
if (is_array($files)) {
    $before_time  = G5_SERVER_TIME - 3600; // 한시간전
    foreach ($files as $gcaptcha_file) {
        $modification_time = filemtime($gcaptcha_file); // 파일접근시간

        if ($modification_time > $before_time) continue;

        $cnt++;
        unlink($gcaptcha_file);
        echo '<li>'.$gcaptcha_file.'</li>'.PHP_EOL;

        flush();

        if ($cnt%10==0) 
            echo PHP_EOL;
    }
}

echo '<li>캡챠파일 삭제 실행 완료</li></ul>'.PHP_EOL;
echo '<div class="local_desc01 local_desc"><p><strong>캡챠파일 '.$cnt.'건의 삭제 완료됐습니다.</strong><br>프로그램의 실행을 끝마치셔도 좋습니다.</p></div>'.PHP_EOL;
?>
<!-- 캡챠파일 삭제 //-->

<!-- 캐시파일 삭제 -->
<?php
flush();

if (!$dir=@opendir(G5_DATA_PATH.'/cache')) {
    echo '<p>캐시디렉토리를 열지못했습니다.</p>';
}

$cnt=0;
echo '<ul>'.PHP_EOL;

$files = glob(G5_DATA_PATH.'/cache/latest-*');
if (is_array($files)) {
    foreach ($files as $cache_file) {
        $cnt++;
        unlink($cache_file);
        echo '<li>'.$cache_file.'</li>'.PHP_EOL;

        flush();

        if ($cnt%10==0) 
            echo PHP_EOL;
    }
}

echo '<li>캐시파일 삭제 실행 완료</li></ul>'.PHP_EOL;
echo '<div class="local_desc01 local_desc"><p><strong>최신글 캐시파일 '.$cnt.'건 삭제 완료됐습니다.</strong><br>프로그램의 실행을 끝마치셔도 좋습니다.</p></div>'.PHP_EOL;
?>
<!-- 캐시파일 삭제 //-->

<!-- 세션파일 삭제 -->
    <?php
    flush();

    $list_tag_st = "";
    $list_tag_end = "";
    if (!$dir=@opendir(G5_DATA_PATH.'/session')) {
      echo "<p>세션 디렉토리를 열지못했습니다.</p>";
    } else {
        $list_tag_st = "<ul>\n<li>세션파일 삭제 실행 완료</li>\n";
        $list_tag_end = "</ul>\n";
    }

    $cnt=0;
    echo $list_tag_st;
    while($file=readdir($dir)) {

        if (!strstr($file,'sess_')) continue;
        if (strpos($file,'sess_')!=0) continue;

        $session_file = G5_DATA_PATH.'/session/'.$file;

        if (!$atime=@fileatime($session_file)) {
            continue;
        }
        if (time() > $atime + (3600 * 6)) {  // 지난시간을 초로 계산해서 적어주시면 됩니다. default : 6시간전
            $cnt++;
            $return = unlink($session_file);
            /*echo "<script>document.getElementById('ct').innerHTML += '{$session_file}<br/>';</script>\n";*/
            echo "<li>{$session_file}</li>\n";

            flush();

            if ($cnt%10==0)
                /*echo "<script>document.getElementById('ct').innerHTML = '';</script>\n";*/
                echo "\n";
        }
    }
    echo $list_tag_end;
    echo '<div class="local_desc01 local_desc"><p><strong>세션데이터 '.$cnt.'건 삭제 완료됐습니다.</strong><br>프로그램의 실행을 끝마치셔도 좋습니다.</p></div>'.PHP_EOL;
 ?>
<!-- 세션파일 삭제 -->


<?php /* 전체 레이아웃 감싸기 닫기 */    echo '</div>'; ?>

<!-- [JS쿼리] 탭메뉴 시작 { -->
<script>
$(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        document.location.reload();
    }
});
</script>
<!-- [JS쿼리] 탭메뉴 끝 // -->

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.sub.php');
?>