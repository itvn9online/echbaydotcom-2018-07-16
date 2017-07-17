<div id="vietnamontrails-top3" class="hide-if-mobile">
	<div class="cf <?php echo $__cf_row['cf_top_class_style']; ?>">
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
		<div class="lf f60">
			<marquee width="100%" direction="left" scrollamount="3" scrolldelay="0" onmouseover="this.stop();" onmouseout="this.start();">
			<span class="top-marquee"><?php echo $__cf_row['cf_description']; ?></span>
			</marquee>
		</div>
		<div class="lf f20 text-center">
			<div class="oi_member_func"></div>
		</div>
	</div>
</div>
