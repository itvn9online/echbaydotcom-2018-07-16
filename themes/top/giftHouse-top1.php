<div id="giftHouse-top1" class="hide-if-mobile">
	<div class="topbar cf <?php echo $__cf_row['cf_top_class_style']; ?>">
		<div class="lf f40">
			<div><span><i class="fa fa-map-marker"></i> ĐC: <?php echo $__cf_row['cf_diachi']; ?></span> <i class="fa fa-phone"></i> <span class="phone-numbers-inline"><?php echo $__cf_row['cf_call_dienthoai']; ?></span></div>
		</div>
		<div class="lf f20">
			<div class="oi_member_func"></div>
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
		<div class="lf f10">
			<div class="btn-to-cart"><a title="Giỏ hàng" href="cart/" rel="nofollow"><em class="show_count_cart d-none">0</em><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></div>
		</div>
	</div>
</div>
