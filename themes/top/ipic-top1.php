<div id="ipic-top2">
	<div class="cf <?php echo $__cf_row['cf_top_class_style']; ?>">
		<div class="top-header cf <?php echo $__cf_row['cf_top_class_style']; ?>">
			<div class="lf f25 fullsize-if-mobile">
				<div><a href="./" title="Trang chủ" class="web-logo" style="background-image:url('<?php echo $__cf_row['cf_logo']; ?>');">&nbsp;</a></div>
			</div>
			<div class="lf f75 hide-if-mobile">
				<div class="cf">
					<div class="top-top-lang rf"><?php echo EBE_echbay_top_menu(); ?></div>
				</div>
				<div class="cf">
					<div class="rf div-search-margin">
						<div class="div-search">
							<form role="search" method="get" action="<?php echo web_link; ?>">
								<input type="search" placeholder="Tìm kiếm sản phẩm" value="<?php echo $current_search_key; ?>" name="s" aria-required="true" required>
								<input type="hidden" name="post_type" value="post" />
								<button type="submit" class="cur default-2bg"><i class="fa fa-search"></i></button>
							</form>
						</div>
						<div id="oiSearchAjax"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
