<?php
$sub_menu = "500800"; /* 수정전 원본 메뉴코드 200800 */
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '접속자집계';
include_once('./visit.sub.php');

$colspan = 8;

$sql_common = " from {$g5['visit_table']} ";
$sql_search = " where vi_date between '{$fr_date}' and '{$to_date}' ";
if (isset($domain))
    $sql_search .= " and vi_referer like '%{$domain}%' ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            order by vi_id desc
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);
?>

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col"><i class="fa fa-search fa-lg"></i></th>
        <th scope="col" colspan="2">IP</th>
        <th scope="col">접속 경로</th>
        <th scope="col">브라우저</th>
        <th scope="col">OS</th>
        <th scope="col">접속기기</th>
        <th scope="col">일시</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $brow = $row['vi_browser'];
        if(!$brow)
            $brow = get_brow($row['vi_agent']);

        $os = $row['vi_os'];
        if(!$os)
            $os = get_os($row['vi_agent']);

        $device = $row['vi_device'];

        $link = '';
        $link2 = '';
        $referer = '';
        $title = '';
        if ($row['vi_referer']) {

            $referer = get_text(cut_str($row['vi_referer'], 255, ''));
            $referer = urldecode($referer);

            if (!is_utf8($referer)) {
                $referer = iconv_utf8($referer);
            }

            $title = str_replace(array('<', '>', '&'), array("&lt;", "&gt;", "&amp;"), $referer);
            $link = '<a href="'.$row['vi_referer'].'" target="_blank">';
            $link = str_replace('&', "&amp;", $link);
            $link2 = '</a>';
        }

        if ($is_admin == 'super')
            $ip = $row['vi_ip'];
        else
            $ip = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['vi_ip']);

        if ($brow == '기타') { $brow = '<span title="'.get_text($row['vi_agent']).'">'.$brow.'</span>'; }
        if ($os == '기타') { $os = '<span title="'.get_text($row['vi_agent']).'">'.$os.'</span>'; }

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_category td_category3">
        <?php if ($is_admin = 'super') { //최고관리자만 볼수있음?>
        <a href="<?php echo G5_ADMIN_URL; ?>/visit_search.php?sfl=vi_ip&amp;stx=<?php echo $ip; ?>" target="_blank">
        <?php } //최고관리자만 볼수있음?>
        <img src="<?php echo G5_ADMIN_URL; ?>/img/icon/date.png" align="absmiddle" border="0" title="접속검색">
        </a>
        <?php if ($is_admin = 'super') { //최고관리자만 볼수있음?>
        <a href="<?php echo G5_ADMIN_URL; ?>/member_list.php?sfl=mb_ip&stx=<?php echo $ip; ?>" target="_blank">
        <?php } //최고관리자만 볼수있음?>
        <img src="<?php echo G5_ADMIN_URL; ?>/img/icon/group_delete.png" align="absmiddle" border="0" title="회원검색">
        </a>
        <?php if ($is_admin = 'super') { //최고관리자만 볼수있음?>
        <a href="<?php echo G5_ADMIN_URL; ?>/shop_admin/orderlist.php?sel_field=od_ip&search=<?php echo $ip; ?>" target="_blank">
        <?php } //최고관리자만 볼수있음?>
        <img src="<?php echo G5_ADMIN_URL; ?>/img/icon/cart_add.png" align="absmiddle" border="0" title="주문검색">
        </a>
        </td>
        <td style="text-align:center;width:24px;"><img src="<?php echo G5_URL; ?>/img/ip/<?php echo geoip_country_code_by_addr($gi, $row['vi_ip']); ?>.png" alt="<?php echo geoip_country_code_by_addr($gi, $row['vi_ip']); ?>"></td>
        <td style="width:100px; text-align:center;">
		<?php if ($is_admin = 'super') { //최고관리자만 볼수있음?>
		<?php echo "<a href=\"#\" onclick=\"window.open('http://www.iegate.net/open/whois.php?ip=$ip', 'visit_list', 'toolbar=no, status=no, menubar=no, scrollbars=yes, width=510, height=550');\">$ip</a>";//ip내역 보기 ?>        
		
		<?php
		$latest_whoip = "select * from  {$g5['member_table']} where mb_ip LIKE '{$ip}' LIMIT 0 , 1";
		$who = sql_fetch($latest_whoip);
		
		$whoicon_dir = substr($who['mb_id'],0,2);
        $whoicon_file = G5_DATA_PATH.'/member/'.$whoicon_dir.'/'.$who['mb_id'].'.gif';
        if (file_exists($whoicon_file) && $who[mb_name]) {
            $whoicon_url = G5_DATA_URL.'/member/'.$whoicon_dir.'/'.$who['mb_id'].'.gif';
            echo '<br><span class="skyblue" title="'.$who[mb_name].'"><img src="'.$whoicon_url.'" alt=""> '.$who[mb_id].'</span>';
        } else if(!file_exists($whoicon_file) && $who[mb_name]) {
			echo '<br><span class="skyblue" title="'.$who[mb_name].'"><i class="fa fa-user"></i> '.$who[mb_id].'</span>';
		} else if(!file_exists($whoicon_file) && !$who[mb_name]) {
			echo '';
		} else {
			echo '';
		}
		?>
        <?php } //최고관리자만 볼수있음?> 
		</td>
        <td><?php echo $link ?><?php echo $title ?><?php echo $link2 ?></td>
        <td class="td_category td_category1"><?php echo $brow ?></td>
        <td class="td_category td_category3"><?php echo $os ?></td>
        <td class="td_category td_category2"><?php echo $device; ?></td>
        <td class="td_datetime"><?php echo $row['vi_date'] ?> <?php echo $row['vi_time'] ?></td>
    </tr>

    <?php
    }
    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없거나 관리자에 의해 삭제되었습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<?php
if (isset($domain))
    $qstr .= "&amp;domain=$domain";
$qstr .= "&amp;page=";

$pagelist = get_paging($config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr");
echo $pagelist;

include_once('./admin.tail.php');
?>
