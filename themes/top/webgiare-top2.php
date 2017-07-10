<div id="webgiare-top2" class="default-bg">
	<div class="wm-logo-fixed hide-if-mobile">
		<div class="<?php echo $__cf_row['cf_top_class_style']; ?> cf">
			<div class="lf f80">
				<div class="nav-menu"><?php echo EBE_echbay_top_menu(); ?></div>
			</div>
			<div class="lf f20">
				<div class="div-search-margin">
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
		</div>
	</div>
</div>
