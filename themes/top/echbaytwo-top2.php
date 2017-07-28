<?php
/*
Tags: dep qua
*/
?>

<div id="echbaytwo-top2">
	<div class="web-top-logo cf <?php echo $__cf_row['cf_top_class_style']; ?>">
		<div class="lf f25 cf fullsize-if-mobile"><?php echo EBE_get_html_logo(); ?></div>
		<div class="lf f75 hide-if-mobile cf">
			<div class="lf f62">
				<div class="div-search-margin">
					<div class="div-search">
						<form role="search" method="get" action="<?php echo web_link; ?>">
							<input type="search" placeholder="<?php echo EBE_get_lang('searchp'); ?>" value="<?php echo $current_search_key; ?>" name="s" aria-required="true" required>
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
</div>
