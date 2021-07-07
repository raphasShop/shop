<?php
$sub_menu = '600000';
include_once('./_common.php');
auth_check($auth[$sub_menu], "r");
//comcose_edit_2018.04.23 추가테이블 생성 여부
$sql_add_level = " select count(*) as cnt from comcose_sellprice_level ";
$result_add_level = sql_fetch($sql_add_level);
$add_level_cnt = $result_add_level['cnt'];
if ($add_level_cnt == 0){
    $g5['title'] = '추가테이블 설치';
} else if ($add_level_cnt > 0){
    $g5['title'] = '판매금액설정 안내';
}
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<?php if ($add_level_cnt == 0){ ?>
<div style="padding: 14px 0 0 20px;">
추가 테이블을 설치하셔야 정상이용가능합니다.&nbsp;&nbsp;<a style="padding: 7px 10px 6px 10px; background:#ff3061; color:#fff; text-decoration:none" href="./_comcose_sellprice.sql_import.php">설치하기</a>
</div>
<?php } else if ($add_level_cnt > 0){ ?> 
<div style="padding:12px 0 0 20px;">
<b style="color:#f03c23;font-size:14px">우선순위 확인 후 설정하시기 바랍니다.</b><br><br><b style="color:#343b43;font-size:12px">로그인(로그인시 금액노출) -> 상품별금액설정 -> 제외상품, 제외분류 -> 분류별 금액설정 -> 회원권한별 금액설정(등급별 금액설정)</b><br><br><br><br><text style="color:#343b43;">
"회원권한별 설정금액"에 <b>"로그인시 금액노출"</b> 이 가장 우선순위에 있으며,<br><br>
회원권한별 금액설정 후 "분류별 금액설정" 사용하시면,<br>
분류별로 설정한 금액이 우선 노출후 나머지 상품은 회원권한별 설정한 설정금액으로 노출됩니다.<br><br><br>
"제외분류, 제외상품" 에 등록하신 분류와 상품은 "회원권한별, 분류별" 설정하신 금액은 모두 무시되며<br>
상품 등록시 입력하신 금액으로 노출됩니다.<br><br>

제외분류 삭제시 삭제한 분류내 상품이 "제외 상품설정"에 등록되어 있으면 개별 적용되니,<br>제외분류 삭제 후 금액표시가 적용안될 시 "제외상품 설정"를 확인바랍니다.<br>
<b style="color:#f03c23">
"제외분류 등록은" 2차분류 이상 등록이 가능합니다.
</b>
<br><br><br>
</text>
<b style="color:#f03c23">
"상품별 금액설정"을 하시면 등록된 상품은,<br>
분류별, 회원권한별, 제외 분류·상품 설정하신 금액 모두 무시되고 상품별설정한 금액이 우선 노출됩니다.
</b>
</div>
<?php } ?>


<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>