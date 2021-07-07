<?php
if (!defined('_GNUBOARD_')) exit;
include_once('./_common.php');

#######################################################################################
/* 관리자모드 좌측에 표시되는 좌측 기본 메뉴 [아이스크림 소스] */
// 삽입함수 include_once(G5_ADMIN_PATH.'/admin.left_menu.php');
#######################################################################################
?>
<style>
.at-container { margin:0px auto; padding:0px; }

/********************************************************
■ Mobile Menu : 모바일 메뉴
********************************************************/
.m-menu { display:none; overflow:hidden; background:#fff; position:relative; z-index:20; box-shadow: 0px 5px 5px -2px rgba(25, 25, 25, 0.15); -webkit-box-shadow: 0px 5px 5px -2px rgba(25, 25, 25, 0.15); -moz-box-shadow: 0px 5px 5px -2px rgba(25, 25, 25, 0.15); }
.m-menu .m-wrap { }
.m-menu .m-table { display:table; width:100%; table-layout:fixed; width:100%; margin:0px; min-width:300px; border-collapse: collapse; }
.m-menu .m-icon, 
.m-menu .m-list { display:table-cell; vertical-align:middle; font-size:15px; height:44px; line-height:44px; border:1px solid #eee; border-top:0px; border-bottom:0px; }
.m-menu .m-icon { width:44px; text-align:center; font-size:18px; }
.m-menu .m-icon a { display:block; position:relative; }
.m-menu .m-icon .label { position: absolute; top: 15%; right: 5px; text-align: center; font-size: 9px; font-weight:300; padding: 2px 3px; line-height: 0.9; border-radius: .25em !important;  }
.m-menu .m-nav { overflow: hidden; margin:0px 10px; }
.m-menu .m-nav ul { list-style: none; margin:0px; padding:0px; }
.m-menu .m-nav ul li { display:table-cell; padding: 0px 10px; white-space:nowrap; }
.m-menu .m-nav ul li.active a { color: orangered; font-weight:bold; }

.m-menu .m-sub { background:#fafafa; border-top:1px solid #ddd; font-size:15px; height:44px; line-height:44px; padding:0px 10px; }
.m-menu .m-nav-sub { width:100%; overflow: hidden; margin:0px; }
.m-menu .m-nav-sub ul { list-style: none; margin:0px; padding:0px; }
.m-menu .m-nav-sub ul li { display:table-cell; padding: 0px 10px; white-space:nowrap; }
.m-menu .m-nav-sub ul li.active a { color: orangered; font-weight:bold; }
@media all and (max-width:991px) {
	.responsive .m-menu { display:block; }
}
</style>
<div class="m-wrap">
	<div class="at-container">
		<div class="m-table en">
			<div class="m-icon">
				<a href="javascript:;" onclick="sidebar_open('sidebar-menu');"><i class="fa fa-bars"></i></a>
			</div>
			<?php if(IS_YC) { // 영카트 이용시 ?>
				<div class="m-icon">
					<a href="<?php echo $at_href['change'];?>">
						<?php if(IS_SHOP) { // 쇼핑몰일 때 ?>
							<i class="fa fa-commenting"></i>
							<span class="label bg-blue">BBS</span>
						<?php } else { ?>
							<i class="fa fa-shopping-cart"></i>
							<span class="label bg-blue">SHOP</span>
						<?php } ?>
					</a>
				</div>
			<?php } ?>
			<div class="m-list">
				<div class="m-nav" id="mobile_nav">
					<ul class="clearfix">
					<li>
						<a href="<?php echo $at_href['main'];?>">메인</a>
					</li>
					<?php 
						$j = 1; //현재위치 표시
						for ($i=1; $i < $menu_cnt; $i++) {

							if(!$menu[$i]['gr_id']) continue;

							if($menu[$i]['on'] == 'on') {
								$m_sat = $j;

								//서브메뉴
								if($menu[$i]['is_sub']) {
									$m_sub = $i;
								}
							}
					?>
						<li>
							<a href="<?php echo $menu[$i]['href'];?>"<?php echo $menu[$i]['target'];?>>
								<?php echo $menu[$i]['menu'];?>
								<?php if($menu[$i]['new'] == "new") { ?>
									<i class="fa fa-bolt new"></i>
								<?php } ?>
							</a>
						</li>
					<?php $j++; } //for ?>
					</ul>
				</div>
			</div>
			<?php if(IS_YC) { // 영카트 이용시 ?>
				<div class="m-icon">
					<a href="<?php echo $at_href['cart'];?>" onclick="sidebar_open('sidebar-cart'); return false;"> 
						<i class="fa fa-shopping-bag"></i>
						<?php if($member['cart'] || $member['today']) { ?>
							<span class="label bg-green en">
								<?php echo number_format($member['cart'] + $member['today']);?>
							</span>
						<?php } ?>
					</a>
				</div>
			<?php } ?>
			<div class="m-icon">
				<a href="javascript:;" onclick="sidebar_open('sidebar-response');">
					<i class="fa fa-bell"></i>
					<span class="label bg-orangered en"<?php echo ($member['response'] || $member['memo']) ? '' : ' style="display:none;"';?>>
						<span class="msgCount"><?php echo number_format($member['response'] + $member['memo']);?></span>
					</span>
				</a>
			</div>
		</div>
	</div>
</div>

<div class="clearfix"></div>

<?php if($m_sub) { //서브메뉴가 있으면 ?>
	<div class="m-sub">
		<div class="at-container">
			<div class="m-nav-sub en" id="mobile_nav_sub">
				<ul class="clearfix">
				<?php 
					$m_subchk = false;
					for ($i=1; $i < $menu_cnt; $i++) {
						if($i == $m_sub) {
							for($j=0; $j < count($menu[$i]['sub']); $j++) { 
								if($menu[$i]['sub'][$j]['on'] == 'on') { 
									$m_subsat = $j;
									$m_subchk = true;
								}
				?>
						<li>
							<a href="<?php echo $menu[$i]['sub'][$j]['href'];?>"<?php echo $menu[$i]['sub'][$j]['target'];?>>
								<?php echo $menu[$i]['sub'][$j]['menu'];?>
								<?php if($menu[$i]['sub'][$j]['new'] == "new") { ?>
									<i class="fa fa-bolt sub-new"></i>
								<?php } ?>
							</a>
						</li>
				<?php	
							}
						}
					}

					if(!$m_subchk) $m_subsat = '-1';
				?>
				</ul>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
<?php } ?>