<div class="web-top-logo cf <?php echo $__cf_row['cf_top_class_style']; ?>">
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
<?php


$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/top2-1.css' ] = 1;


