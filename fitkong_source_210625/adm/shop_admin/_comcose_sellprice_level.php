<?php
$sub_menu = '600100';
include_once('./_common.php');

//comcose_edit_2018.04.23 추가테이블 생성 여부
$sql_add_level = " select count(*) as cnt from comcose_sellprice_level ";
$result_add_level = sql_fetch($sql_add_level);
$add_level_cnt = $result_add_level['cnt'];
if($add_level_cnt == 0) {
    goto_url("./_comcose_sellprice_setting.php");
}

auth_check($auth[$sub_menu], "r");

$sel_level_add_sql="select * from comcose_sellprice_level ";
$sel_level_add_result= sql_query($sel_level_add_sql);
$sel_level_add = sql_fetch_array($sel_level_add_result);

$g5['title'] = '회원권한별 금액설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>
<style>
.comcose_dc_level_use {width:80px; height:30px; padding: 2px 2px 2px 2px;}
.comcose_dc_level_select {width:45px; height:35px; font-size:15px; color:#ff3600; padding: 1px 2px 2px 2px;}
</style>

<script src="_comcose_sellprice.js"></script>
<form name="fitemform" action="./_comcose_sellprice_level_update.php" method="post" autocomplete="off">
<input type="hidden" name="cose_add_level_id" value="<?php echo $sel_level_add['cose_add_level_id']; ?>"> 
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <tbody>
        <tr>
            <th style="border-top:none">등급별 금액설정</th>
            <td style="border-top:none">
                <?php echo help("등급별 금액설정 사용을 가능하게 할것인지를 설정합니다."); ?>
                <select id="cose_add_level_use" name="cose_add_level_use" class="comcose_dc_level_use">
                    <option value="0" <?php if($sel_level_add['cose_add_level_use'] == '0') echo 'selected'; ?>>사용안함</option>
                    <option value="1" <?php if($sel_level_add['cose_add_level_use'] == '1') echo 'selected'; ?>>사용</option>
                </select>
            </td>
        </tr>
        
        <tr>
            <th style="border-top:none">로그인시 금액노출</th>
            <td style="border-top:none">
                <?php echo help("로그인시에만 금액을 노출 할것인지를 설정합니다.\n로그인시에만 금액을 노출 할시에는 '회원권한 1' 설정은 적용되지 않습니다."); ?>
                <b style="color: #ff3600">비회원이 장바구니에 상품을 담을시 금액이 노출되니 필히 쇼핑몰설정에서 "상품구입 권한"을 2등급 이상 지정 후 사용하십시요!</b><br>
                <select id="cose_add_level_login" name="cose_add_level_login" onChange="goChange(this.value)" class="comcose_dc_level_use">
                    <option value="0" <?php if($sel_level_add['cose_add_level_login'] == '0') echo 'selected'; ?>>사용안함</option>
                    <option value="1" <?php if($sel_level_add['cose_add_level_login'] == '1') echo 'selected'; ?>>사용</option>
                </select>
                <a href="./configform.php#anc_scf_etc" style="background: #686868;color:#fff;text-decoration:none;cursor:pointer;padding:5px 7px 7px 7px">상품구입권한 설정하러가기</a>
            </td>
        </tr>
        
        
        <?php if ($sel_level_add['cose_add_level_login'] == '0' or $sel_level_add['cose_add_level_login'] == '') {?>
        <tr id="loginoutput">
            <th>회원권한 1</th>
            <td>
                <?php echo help("+,- 로 입력 하신 값 '1~100%'로 설정됩니다."); ?>
                <select id="cose_add_level_1_type" name="cose_add_level_1_type" class="comcose_dc_level_select">
                    <option value="+" <?php if($sel_level_add['cose_add_level_1_type'] == '+') echo 'selected'; ?>>+</option>
                    <option value="-" <?php if($sel_level_add['cose_add_level_1_type'] == '-') echo 'selected'; ?>>-</option>
                </select>
                <input type="text" name="cose_add_level_1" value="<?php echo $sel_level_add['cose_add_level_1']; ?>" id=cose_add_level_1" style="padding-left:3px" class="frm_input num_only" size="3"> %
            </td>
        </tr>
        <?php } else {} ?>
        
        <tr>
            <th>회원권한 2</th>
            <td>
                <?php echo help("+,- 로 입력 하신 값 '1~100%'로 설정됩니다."); ?>
                <select id="cose_add_level_2_type" name="cose_add_level_2_type" class="comcose_dc_level_select">
                    <option value="+" <?php if($sel_level_add['cose_add_level_2_type'] == '+') echo 'selected'; ?>>+</option>
                    <option value="-" <?php if($sel_level_add['cose_add_level_2_type'] == '-') echo 'selected'; ?>>-</option>
                </select>
                <input type="text" name="cose_add_level_2" value="<?php echo $sel_level_add['cose_add_level_2']; ?>" id=cose_add_level_2" style="padding-left:3px" class="frm_input num_only" size="3"> %
            </td>
        </tr>
        
        <tr>
            <th>회원권한 3</th>
            <td>
                <?php echo help("+,- 로 입력 하신 값 '1~100%'로 설정됩니다."); ?>
                <select id="cose_add_level_3_type" name="cose_add_level_3_type" class="comcose_dc_level_select">
                    <option value="+" <?php if($sel_level_add['cose_add_level_3_type'] == '+') echo 'selected'; ?>>+</option>
                    <option value="-" <?php if($sel_level_add['cose_add_level_3_type'] == '-') echo 'selected'; ?>>-</option>
                </select>
                <input type="text" name="cose_add_level_3" value="<?php echo $sel_level_add['cose_add_level_3']; ?>" id=cose_add_level_3" style="padding-left:3px" class="frm_input num_only" size="3"> %
            </td>
        </tr>
        
        <tr>
            <th>회원권한 4</th>
            <td>
                <?php echo help("+,- 로 입력 하신 값 '1~100%'로 설정됩니다."); ?>
                <select id="cose_add_level_4_type" name="cose_add_level_4_type" class="comcose_dc_level_select">
                    <option value="+" <?php if($sel_level_add['cose_add_level_4_type'] == '+') echo 'selected'; ?>>+</option>
                    <option value="-" <?php if($sel_level_add['cose_add_level_4_type'] == '-') echo 'selected'; ?>>-</option>
                </select>
                <input type="text" name="cose_add_level_4" value="<?php echo $sel_level_add['cose_add_level_4']; ?>" id=cose_add_level_4" style="padding-left:3px" class="frm_input num_only" size="3"> %
            </td>
        </tr>
        
        <tr>
            <th>회원권한 5</th>
            <td>
                <?php echo help("+,- 로 입력 하신 값 '1~100%'로 설정됩니다."); ?>
                <select id="cose_add_level_5_type" name="cose_add_level_5_type" class="comcose_dc_level_select">
                    <option value="+" <?php if($sel_level_add['cose_add_level_5_type'] == '+') echo 'selected'; ?>>+</option>
                    <option value="-" <?php if($sel_level_add['cose_add_level_5_type'] == '-') echo 'selected'; ?>>-</option>
                </select>
                <input type="text" name="cose_add_level_5" value="<?php echo $sel_level_add['cose_add_level_5']; ?>" id=cose_add_level_5" style="padding-left:3px" class="frm_input num_only" size="3"> %
            </td>
        </tr>
        
        <tr>
            <th>회원권한 6</th>
            <td>
                <?php echo help("+,- 로 입력 하신 값 '1~100%'로 설정됩니다."); ?>
                <select id="cose_add_level_6_type" name="cose_add_level_6_type" class="comcose_dc_level_select">
                    <option value="+" <?php if($sel_level_add['cose_add_level_6_type'] == '+') echo 'selected'; ?>>+</option>
                    <option value="-" <?php if($sel_level_add['cose_add_level_6_type'] == '-') echo 'selected'; ?>>-</option>
                </select>
                <input type="text" name="cose_add_level_6" value="<?php echo $sel_level_add['cose_add_level_6']; ?>" id=cose_add_level_6" style="padding-left:3px" class="frm_input num_only" size="3"> %
            </td>
        </tr>
        
        <tr>
            <th>회원권한 7</th>
            <td>
                <?php echo help("+,- 로 입력 하신 값 '1~100%'로 설정됩니다."); ?>
                <select id="cose_add_level_7_type" name="cose_add_level_7_type" class="comcose_dc_level_select">
                    <option value="+" <?php if($sel_level_add['cose_add_level_7_type'] == '+') echo 'selected'; ?>>+</option>
                    <option value="-" <?php if($sel_level_add['cose_add_level_7_type'] == '-') echo 'selected'; ?>>-</option>
                </select>
                <input type="text" name="cose_add_level_7" value="<?php echo $sel_level_add['cose_add_level_7']; ?>" id=cose_add_level_7" style="padding-left:3px" class="frm_input num_only" size="3"> %
            </td>
        </tr>
        
        <tr>
            <th>회원권한 8</th>
            <td>
                <?php echo help("+,- 로 입력 하신 값 '1~100%'로 설정됩니다."); ?>
                <select id="cose_add_level_8_type" name="cose_add_level_8_type" class="comcose_dc_level_select">
                    <option value="+" <?php if($sel_level_add['cose_add_level_8_type'] == '+') echo 'selected'; ?>>+</option>
                    <option value="-" <?php if($sel_level_add['cose_add_level_8_type'] == '-') echo 'selected'; ?>>-</option>
                </select>
                <input type="text" name="cose_add_level_8" value="<?php echo $sel_level_add['cose_add_level_8']; ?>" id=cose_add_level_8" style="padding-left:3px" class="frm_input num_only" size="3"> %
            </td>
        </tr>
        
        <tr>
            <th>회원권한 9</th>
            <td>
                <?php echo help("+,- 로 입력 하신 값 '1~100%'로 설정됩니다."); ?>
                <select id="cose_add_level_9_type" name="cose_add_level_9_type" class="comcose_dc_level_select">
                    <option value="+" <?php if($sel_level_add['cose_add_level_9_type'] == '+') echo 'selected'; ?>>+</option>
                    <option value="-" <?php if($sel_level_add['cose_add_level_9_type'] == '-') echo 'selected'; ?>>-</option>
                </select>
                <input type="text" name="cose_add_level_9" value="<?php echo $sel_level_add['cose_add_level_9']; ?>" id=cose_add_level_9" style="padding-left:3px" class="frm_input num_only" size="3"> %
            </td>
        </tr>

        </tbody>
        </table>
    </div>
    <div class="btn_fixed_top">
    <input type="submit" value="확인" class="btn_01 btn">
	</div>
    </form>

<script type="text/javascript">
<!--
 function goChange(val) {
  if(val=="1") 
   document.all.loginoutput.style.display="none";
  else
   document.all.loginoutput.style.display="";
 } 
//-->
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>