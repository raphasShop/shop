<?php
$sub_menu = "155900"; /* 새로운 메뉴 */
include_once('./_common.php');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$g5['title'] = $config['cf_theme']." 테마관리자";
include_once('./admin.head.php');
?>

<script src="<?php echo G5_ADMIN_URL; ?>/theme.js"></script>

<p class="theme_p">설치된 테마 : <?php echo number_format($total_count); ?></p>

<?php if($total_count > 0) { ?>
<ul id="theme_list">
    <?php
    for($i=0; $i<$total_count; $i++) {
        $info = get_theme_info($theme[$i]);

        $name = get_text($info['theme_name']);
        if($info['screenshot'])
            $screenshot = '<img src="'.$info['screenshot'].'" alt="'.$name.'">';
        else
            $screenshot = '<img src="'.G5_ADMIN_URL.'/img/theme_img.jpg" alt="">';

        if($config['cf_theme'] == $theme[$i]) {
            $btn_active = '<span class="theme_sl theme_sl_use">사용중</span><button type="button" class="theme_sl theme_deactive" data-theme="'.$theme[$i].'" '.'data-name="'.$name.'">사용안함</button>';
        } else {
            $tconfig = get_theme_config_value($theme[$i], 'set_default_skin');
            if($tconfig['set_default_skin'])
                $set_default_skin = 'true';
            else
                $set_default_skin = 'false';

            $btn_active = '<button type="button" class="theme_sl theme_active" data-theme="'.$theme[$i].'" '.'data-name="'.$name.'" data-set_default_skin="'.$set_default_skin.'">테마적용</button>';
        }
    ?>
    <li>
        <div class="tmli_if">
            <?php echo $screenshot; ?>
            <div class="tmli_tit">
                <p><?php echo get_text($info['theme_name']); ?></p>
            </div>
        </div>
        <?php echo $btn_active; ?>
        <a href="./theme_preview.php?theme=<?php echo $theme[$i]; ?>" class="theme_pr" target="theme_preview">미리보기</a>
        <button type="button" class="tmli_dt theme_preview" data-theme="<?php echo $theme[$i]; ?>">상세보기</button>
    </li>
    <?php
    }
    ?>
</ul>
<?php } else { ?>
<p class="no_theme">설치된 테마가 없습니다.</p>
<?php } ?>

<?php
include_once ('./admin.tail.php');
?>