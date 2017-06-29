<?php

$arr_tmp_top_menu[] = _eb_echbay_menu( 'top-menu-01' );

$arr_tmp_top_menu[] = _eb_echbay_menu( 'top-menu-02' );

$arr_tmp_top_menu[] = _eb_echbay_menu( 'top-menu-03' );

?>
<header id="header">
	<div class="top-top-login default-2bg hide-if-mobile">
		<div class="cf <?php echo $__cf_row['cf_blog_class_style']; ?>">
			<div class="lf f50"><a href="mailto:<?php echo $__cf_row['cf_email']; ?>" rel="nofollow" target="_blank"><i class="fa fa-envelope-o orgcolor"></i> <?php echo $__cf_row['cf_email']; ?></a> &nbsp; <span class="phone-numbers-inline"><i class="fa fa-phone orgcolor"></i> <?php echo $__cf_row['cf_call_dienthoai']; ?></span></div>
			<div class="lf f50">
				<div class="rf cf top-top-ul"><?php echo $arr_tmp_top_menu[0]; ?>
					<ul class="cf">
						<li><a title="Giỏ hàng" href="actions/cart" class="btn-to-cart"><i class="fa fa-shopping-cart"></i> Giỏ hàng (<span class="show_count_cart">0</span>)</a></li>
						<li>
							<div id="oi_member_func" class="oi_member_func"></div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="web-top-logo cf <?php echo $__cf_row['cf_blog_class_style']; ?>">
		<div class="lf f25 cf fullsize-if-mobile"><a href="./" class="web-logo d-block" style="background-image:url('<?php echo $__cf_row['cf_logo']; ?>');">&nbsp;</a></div>
		<div class="lf f75 hide-if-mobile cf">
			<div class="lf f62">
				<div class="div-search-margin">
					<div class="div-search">
						<form role="search" method="get" action="<?php echo web_link; ?>">
							<input type="search" placeholder="Tìm kiếm sản phẩm" value="<?php echo $current_search_key; ?>" name="s" aria-required="true" required>
							<input type="hidden" name="post_type" value="post" />
							<button type="submit" class="cur default-bg"><i class="fa fa-search"></i></button>
						</form>
					</div>
					<div id="oiSearchAjax"></div>
				</div>
			</div>
			<div class="lf f38 text-right">
				<div class="nav-mobile-hotline aorgcolor"><i class="fa fa-phone"></i> <?php echo $__cf_row['cf_call_hotline']; ?></div>
			</div>
		</div>
	</div>
	<div class="top-nav default-bg hide-if-mobile">
		<div class="cf <?php echo $__cf_row['cf_blog_class_style']; ?>">
			<div class="lf f25">
				<div id="nav"><?php echo $arr_tmp_top_menu[1]; ?></div>
			</div>
			<div class="lf f75 cf">
				<div class="lf f75">
					<div class="nav-about"><?php echo $arr_tmp_top_menu[2]; ?></div>
				</div>
				<div class="lf f25 text-right d-none show-if-scroll awhitecolor medium18"><i class="fa fa-phone"></i> <?php echo $__cf_row['cf_call_hotline']; ?></div>
			</div>
		</div>
	</div>
</header>
