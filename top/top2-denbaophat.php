<div class="top-header default-2bg">
	<div class="cf <?php echo $__cf_row['cf_top_class_style']; ?>">
		<div class="lf f25 fullsize-if-mobile">
			<div><a href="./" title="Trang chủ" class="web-logo" style="background-image:url('<?php echo $__cf_row['cf_logo']; ?>');">&nbsp;</a></div>
		</div>
		<div class="lf f75">
			<ul class="cf top-chinh-sach small hide-if-mobile">
				<li><i class="fa fa-truck"></i> Vận chuyển & Lắp đặt miễn phí Hà Nội</li>
				<li><i class="fa fa-calendar-check-o"></i> Bảo hành 1 năm miễn phí</li>
				<li><i class="fa fa-cogs"></i> Bảo trì trọn vòng đời sản phẩm</li>
			</ul>
			<div class="cf" style="margin:8px 0 5px 0;">
				<div class="lf f70 fullsize-if-mobile">
					<div class="div-search-margin">
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
				<div class="lf f30 cf hide-if-mobile"><a title="Giỏ hàng" href="actions/cart" class="btn-to-cart fa fa-shopping-cart">Giỏ hàng (<span class="show_count_cart">0</span>)</a></div>
			</div>
		</div>
	</div>
</div>
