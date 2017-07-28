<div id="vicwatch-top1" class="hide-if-mobile">
	<div class="web-top-logo">
		<div class="<?php echo $__cf_row['cf_top_class_style']; ?> cf div-search-margin">
			<div class="lf f50"><i class="fa fa-map-marker"></i> <?php echo _eb_first( explode( "\n", $__cf_row['cf_diachi'] ) ); ?></div>
			<div class="lf f30 cf text-center medium">
				<div class="lf f80"><i class="fa fa-phone"></i> <span class="medium phone-numbers-inline"><?php echo $__cf_row['cf_call_dienthoai']; ?></span></div>
				<div class="lf f20"><?php echo EBE_get_html_cart(); ?></div>
			</div>
			<div class="lf f20">
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
		</div>
	</div>
</div>
