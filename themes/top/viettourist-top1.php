<div id="viettourist-top1" class="hide-if-mobile">
	<div class="<?php echo $__cf_row['cf_top_class_style']; ?>">
		<div class="top-top-search">
			<div class="div-search-margin">
				<div class="div-search-padding">
					<div class="div-search">
						<form role="search" method="get" action="<?php echo web_link; ?>">
							<input type="search" placeholder="<?php echo EBE_get_lang('searchp'); ?>" value="<?php echo $current_search_key; ?>" name="s" aria-required="true" required>
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
