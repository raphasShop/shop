<?php
$sub_menu = '155351'; /* ������ ���� �޴��ڵ� 100320 */
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

@mkdir(G5_DATA_PATH."/mtopbanner", 0707);
@chmod(G5_DATA_PATH."/mtopbanner", 0707);

$bn_bimg1      = $_FILES['bn_bimg1']['tmp_name'];
$bn_bimg2      = $_FILES['bn_bimg2']['tmp_name'];

if ($bn_bimg1_del)  @unlink(G5_DATA_PATH."/mtopbanner/1");
if ($bn_bimg2_del)  @unlink(G5_DATA_PATH."/mtopbanner/2");

    $sql = " update g5_shop_mtopbanner
                set bn_alt        = '$bn_alt',
                    bn_url        = '$bn_url',
                    bn_device     = '$bn_device',
                    bn_position   = '$bn_position',
                    bn_border     = '$bn_border',
                    bn_new_win    = '$bn_new_win',
                    bn_begin_time = '$bn_begin_time',
                    bn_end_time   = '$bn_end_time',
					bn_hit        = '$bn_hit',
					bn_bgcolor    = '$bn_bgcolor',
                    bn_order      = '$bn_order' ";
    sql_query($sql);

// ������ ���ε� ��
function topbanner_upload_file($srcfile, $destfile, $dir)
{
    if ($destfile == "") return false;
    // ���ε� ���� , �۹̼��� ������
    @move_uploaded_file($srcfile, $dir.'/'.$destfile);
    @chmod($dir.'/'.$destfile, G5_FILE_PERMISSION);
    return true;
}

    if ($_FILES['bn_bimg1']['name']) topbanner_upload_file($_FILES['bn_bimg1']['tmp_name'], '1', G5_DATA_PATH."/mtopbanner");
	if ($_FILES['bn_bimg2']['name']) topbanner_upload_file($_FILES['bn_bimg2']['tmp_name'], '2', G5_DATA_PATH."/mtopbanner");

    goto_url("./top.banner.php");

?>
