<div id="erawatch-top1">
	<div class="web-top-logo l25 hide-if-mobile">
		<div class="cf div-search-margin <?php echo $__cf_row['cf_top_class_style']; ?>">
			<div class="lf f50">
				<div class="topbar-menu"><?php echo EBE_echbay_top_menu(); ?></div>
				<!-- <i class="fa fa-phone"></i> <span class="phone-numbers-inline"><?php echo $__cf_row['cf_call_dienthoai']; ?></span> --></div>
			<div class="lf f20 fullsize-if-mobile">
				<div>
					<div class="div-search">
						<form role="search" method="get" action="<?php echo web_link; ?>">
							<input type="search" placeholder="Tìm kiếm" value="<?php echo $current_search_key; ?>" name="s" aria-required="true" required>
							<input type="hidden" name="post_type" value="post" />
							<button type="submit" class="cur"><i class="fa fa-search"></i></button>
						</form>
					</div>
					<div id="oiSearchAjax"></div>
				</div>
			</div>
			<div class="lf f30 cf text-center">
				<div class="lf f60"><?php echo EBE_get_html_profile(); ?></div>
				<div class="lf f40"><?php echo EBE_get_html_cart(); ?></div>
			</div>
		</div>
	</div>
</div>
