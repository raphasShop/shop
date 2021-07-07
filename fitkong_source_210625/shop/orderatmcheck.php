<?php
/*
입금확인요청
*************************
//연결파일
*************************
shop > orderatmcheckupdate.php  // 입금 확인 업데이트폼​
*/
include_once('./_common.php');

$g5['title'] = '무통장입금확인요청';

$od_id = trim($_REQUEST['od_id']);
$id_id = trim($_REQUEST['id_id']);

// 주문정보체크
//$sql = " select it_id, ca_id from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
$sql = " select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' ";
$row = sql_fetch($sql);
if(!$row['od_id']) {
	if($move) {
		alert('자료가 존재하지 않습니다.');
	} else {
		alert_close('자료가 존재하지 않습니다.');
	}
}

if($move) {
	include_once('./_head.php');
} else {
	include_once(G5_PATH.'/head.sub.php');
	@include_once(THEMA_PATH.'/head.sub.php');
}

$today = G5_TIME_YMD; //입금일자
$it_id = get_text($row['it_idx']);
$od_bank_account = get_text($row['od_bank_account']);
$id_name_order = get_text($row['od_name']); // order테이블의 주문자명 불러오기
$id_deposit_name_order = get_text($row['od_deposit_name']); // order테이블의 입금자명 불러오기
$id_money_order = get_text($row['od_misu']); // order테이블의 구매금액(미수금) 불러오기

?>
<style>
.form-box { 
	margin: 0px 0px 15px; 
	border: 1px solid rgb(231, 231, 231); 
	transition:0.3s linear; 
	border-image: none; 
	overflow: hidden; 
	position: relative; 
	cursor: default; 
	-webkit-transition: all 0.3s linear;
	background: rgb(252, 252, 252); 
	border-top:1px solid rgb(231, 231, 231); 
	border-bottom:1px solid rgb(231, 231, 231); 
	line-height: 130%;
}
.form-box::before { 
	display: table; 
	content: ""; 
}
.form-box::after { 
	display: table; 
	content: ""; 
}
.form-box::after { 
	clear: both; 
}
.form-box label.checkbox, .form-box label.radio { 
	line-height:12px; 
	font-size: 12px; 
	font-weight: normal; 
	cursor: pointer; 
}
.form-box .form-icon { 
	margin: 25px auto; 
	border-radius: 80px; 
	width: 80px; 
	height: 80px; 
	text-align: center; 
	line-height: 80px; 
	font-size: 40px; 
	display: block; 
}
.form-box .form-header { 
	padding: 15px; 
	border-bottom-color: rgb(243, 243, 243); 
	border-bottom-width: 1px; 
	border-bottom-style: solid; 
}
.form-box .form-header h2, .form-box .form-heading { 
	margin: 0px; 
	padding: 0px !important; 
	font-size: 18px; 
	font-weight: 500; 
}
.form-box .form-body { 
	background: rgb(255, 255, 255); 
	padding: 15px; 
}
.form-box .form-body p { 
	padding-left: 0px; 
	margin-bottom: 10px; 
}
.form-box .form-body .condition { 
	margin:10px 0px; 
	height:100px; 
	overflow:auto; 
	background:#fff; 
	border:1px solid #ddd; 
	padding:15px;
	color:#666666; 
	line-height:130%;
}
.form-box .form-footer { 
	padding: 6px 0px; 
	border-top-color: rgb(243, 243, 243); 
	border-top-width: 1px; 
	border-top-style: solid; 
}
.form-box .form-footer::before { 
	display: table; 
	content: ""; 
}
.form-box .form-footer::after { 
	display: table; 
	content: "";
	clear: both; 
}
.form-box .form-footer p { 
	margin: 6px 15px; 
}
.form-box .form-footer a { 
	margin:0px 15px; 
}
</style>

<div class="form-box">
	<div class="form-header" style="background-color:#34394A;color:#FFFFFF;height:60px;">
		<h2>입금확인요청</h2>
	</div>
    

    
	<div class="form-body">
        
        <form name="forderatmcheck" class="form-light padding-15" role="form" method="post" action="./orderatmcheckupdate.php" onsubmit="return forderatmcheck_submit(this);" autocomplete="off">
			<input type="hidden" name="od_id" value="<?php echo $od_id; ?>">
            <input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
            <input type="hidden" name="od_bank_account" value="<?php echo $od_bank_account; ?>">
            <input type="hidden" name="id_name" value="<?php echo $id_name_order; ?>">
            <input type="hidden" name="id_deposit_name" value="<?php echo $id_deposit_name_order; ?>">
            <input type="hidden" name="id_money" value="<?php echo $id_money_order; ?>">
		  <br />
          
          <div class="form-group">
          <!-- ##### 주문정보 ##### -->
          <table width="95%" border="0" align="center">
           <tr>
             <td width="100"><?php echo get_it_image($row['it_idx'], 80, 80); ?></td>
             <td>
	     	 <span class="link_big_blackgray"><b><?php echo $row['od_cart_count']; ?>개</b>의 상품 <?php echo display_price($row['od_misu']);?>을 주문하셨습니다</span><br>
             <span class="link_st_brown">무통장입금의 경우 입금하신후 입금확인요청을 해주시면 빠른시간내에 확인해드립니다.<br>확인요청은 1회만 가능합니다. 당일안에 바로 처리해드립니다.</span>
             </td>
             <td>&nbsp;</td>
           </tr>
         </table>
         <!-- } -->
         </div>
          
		  <div class="form-group">
          <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr style="height:35px;">
        <td><label for="id_subject"><b class="en">제목</b><strong class="sound_only"> 필수</strong></label></td>
        <td><input type="text" name="id_subject" value="<?php echo get_text($row['od_deposit_name']); ?>님의 입금확인요청입니다" id="id_subject" required class="form-control input-sm minlength=2" minlength="2" maxlength="100" style="width:220px" readonly="readonly"></td>
      </tr>
      <tr style="height:35px;">
                <td><label for="od_bank_account"><b class="en">입금한 계좌</b><strong class="sound_only"> 필수</strong></label></td>
               <td><input name="od_bank_account​" type="text" class="form-control input-sm minlength=2" style="width:220px" id="od_bank_account​" value="<?php echo $od_bank_account; ?>" maxlength="50" required readonly="readonly"></td>
             </tr>
             <tr style="height:35px;">
                <td><label for="id_money"><b class="en">입금한 금액</b><strong class="sound_only"> 필수</strong></label></td>
               <td><input name="id_money​" type="text" class="form-control input-sm minlength=2" style="width:100px;text-align:right;" id="id_money" value="<?php echo $id_money_order;?>" maxlength="10" required></td>
             </tr>
             <tr style="height:35px;">
                <td><label for="id_deposit_name"><b class="en">입금자</b><strong class="sound_only"> 필수</strong></label></td>
               <td><input name="id_deposit_name​" type="text" class="form-control input-sm minlength=2" style="width:100px;" id="id_deposit_name" value="<?php echo $id_deposit_name_order; ?>" maxlength="20" required></td>
             </tr>
             <!-- ##### 날짜와 달력구하는 쿼리 { ##### -->
             <?php include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php'); ?> 
                <script> 
                    $(function(){ 
                        $("#datepicker_depositdate").datepicker({ 
                            changeMonth: true, 
                            changeYear: true, 
                            dateFormat: "yy-mm-dd", 
                            showButtonPanel: true, 
                            yearRange: "c-99:c+99", 
                            maxDate: "+365d" 
                        }); 
                    }); 
                </script>
                <!-- ##### } 날짜와 달력구하는 쿼리 끝 ##### -->
             <tr style="height:35px;">
               <td><label for="id_deposit_date"><b class="en">입금한 날짜</b><strong class="sound_only"> 필수</strong></label></td>
               
               <td>
               <input type="text" name="id_deposit_date" class="form-control input-sm" style="width:100px;" id="datepicker_depositdate" value="<?php echo $today; ?>" required></td>
             </tr>
             <tr style="height:35px;">
               <td>&nbsp;</td>
               <td class="link_st_brown">
               *입금자 : 입금자가 변경된경우에만 수정해주세요<br>
               *입금한 날짜 : 오늘 입금한게 아니라면 입금일을 수정해주세요
               </td>
             </tr>
          </table>
          </div>

            <div class="text-center">
				<span class="link_big_pink"><b>입금하셨나요?</b></span>
			</div>
            <br>
			<div class="text-center">
				<button type="submit" class="btn btn-color btn-sm"><b>예.입금했습니다.확인해주세요!</b></button>
				<?php if($move) { ?>
					<button type="button" class="btn btn-black btn-sm" onclick="history.go(-1);">아니오.입금전입니다</button>
				<?php } else { ?>
					<button type="button" class="btn btn-black btn-sm" onclick="window.close();">아니오.입금전입니다</button>
				<?php } ?>
			</div>
            <br>
            <div class="text-center">
				<span class="link_st_blackgrayk">&nbsp;</span>
			</div>
		</form>
	</div>
</div>

<?php
if($move) {
	include_once('./_tail.php');
} else {
	@include_once(THEMA_PATH.'/tail.sub.php');
	include_once(G5_PATH.'/tail.sub.php');
}
?>

<script>
	function forderatmcheck_submit(f) {
		<?php echo chk_captcha_js();  ?>
		return true;
	}
</script>
