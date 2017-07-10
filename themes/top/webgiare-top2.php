<div id="webgiare-top2">
	<div class="wm-logo-fixed hide-if-mobile">
		<div class="<?php echo $__cf_row['cf_top_class_style']; ?> cf">
			<div class="lf f70">
				<div class="nav-menu"><?php echo $arr_tmp_top_menu[1]; ?></div>
			</div>
			<div class="lf f30">
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
