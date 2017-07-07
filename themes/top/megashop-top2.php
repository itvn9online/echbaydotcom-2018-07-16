<div id="megashop-top2">
	<div class="web-top-logo">
		<div class="cf <?php echo $__cf_row['cf_top_class_style']; ?>">
			<div class="lf f20 cf fullsize-if-mobile"><a href="./" class="web-logo d-block" style="background-image:url('<?php echo $__cf_row['cf_logo']; ?>');">&nbsp;</a></div>
			<div class="lf f80 hide-if-mobile cf">
				<div class="lf f70">
					<div class="nav"><?php echo EBE_echbay_top_menu(); ?></div>
				</div>
				<div class="lf f30">
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
			</div>
		</div>
	</div>
</div>
