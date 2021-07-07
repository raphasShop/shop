<?php

    if (!defined('_GNUBOARD_')) {
        exit;
    }
    //seo 사용에 체크해야 출력된다.
    if (!$config['as_use']) {
        return;
    }
    if ($is_admin || $member['mb_id'] == 'test') {
    ?>
    <div class="bo_w_metatag write_div">
        <input type="text" name="<?php echo AS_WRITE_TITLE_FIELD ?>" value='<?php echo $write[AS_WRITE_TITLE_FIELD] ?>' class="frm_input full_input" placeholder='OG Title'>
    </div>
    <div class="bo_w_metatag write_div">
        <input type="text" name="<?php echo AS_WRITE_KEYWORDS_FIELD ?>" value='<?php echo $write[AS_WRITE_KEYWORDS_FIELD] ?>' class="frm_input full_input" placeholder='META Keywords'>
    </div>
    <div class="bo_w_metatag write_div">
        <input type="text" name="<?php echo AS_WRITE_DESCRIPTION_FIELD ?>" value='<?php echo $write[AS_WRITE_DESCRIPTION_FIELD] ?>' class="frm_input full_input" placeholder='META DESCRIPTION'>
    </div>
<?php }?>