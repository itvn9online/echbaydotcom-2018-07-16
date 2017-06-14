<!-- quick cart -->

<div id="click_show_cpa">
	<div class="cart-quick">
		<div class="cart-quick-close">
			<div onClick="close_img_quick_video_details();" class="fa fa-close cur"></div>
		</div>
		<div class="cart-quick-title bold upper">Mua ngay</div>
		<div class="cart-quick-padding">
			<form name="frm_cart" method="post" action="process/?set_module=booking" target="target_eb_iframe" onsubmit="return _global_js_eb.check_cart();" class="eb-global-frm-cart">
				<div id="cart_user_agent" class="d-none">
					<input type="text" name="t_muangay[]" value="0" />
					<input type="text" name="t_size[]" value="" />
					<input type="text" name="t_color[]" value="" />
				</div>
				<div class="eb-quickcart-table">
					<div class="eb-quickcart-node cf show-if-color-exist product-color d-none">
						<div class="eb-quickcart-left">Màu sắc</div>
						<div class="eb-quickcart-right">
							<div class="oi_product_color">
								<ul class="cf">
								</ul>
							</div>
						</div>
					</div>
					<div class="eb-quickcart-node cf show-if-size-exist d-none">
						<div class="eb-quickcart-left">Kích cỡ</div>
						<div class="eb-quickcart-right">
							<div class="eb-product-size oi_product_size">
								<ul class="cf">
								</ul>
							</div>
						</div>
					</div>
					<div class="eb-quickcart-node eb-quickcart-quan cf">
						<div class="eb-quickcart-left">Số lượng</div>
						<div id="oi_change_soluong" class="eb-quickcart-right"></div>
					</div>
					<div class="eb-quickcart-node eb-quickcart-price cf">
						<div class="eb-quickcart-left">Thành tiền</div>
						<div id="oi_change_tongtien" class="eb-quickcart-right bold redcolor"></div>
					</div>
					<div class="eb-quickcart-node cf">
						<div class="eb-quickcart-left">Họ và tên</div>
						<div class="eb-quickcart-right">
							<input type="text" name="t_ten" value="" placeholder="Họ và tên" />
						</div>
					</div>
					<div class="eb-quickcart-node cf">
						<div class="eb-quickcart-left">Điện thoại <span class="redcolor">*</span></div>
						<div class="eb-quickcart-right">
							<input type="text" name="t_dienthoai" value="" placeholder="Điện thoại" />
						</div>
					</div>
					<div class="eb-quickcart-node cf">
						<div class="eb-quickcart-left">Email</div>
						<div class="eb-quickcart-right">
							<input type="text" name="t_email" value="" placeholder="Email" />
						</div>
					</div>
					<div class="eb-quickcart-node cf">
						<div class="eb-quickcart-left">Địa chỉ</div>
						<div class="eb-quickcart-right">
							<textarea name="t_diachi" placeholder="Địa chỉ nhận hàng"></textarea>
						</div>
					</div>
					<div class="eb-quickcart-node cf">
						<div class="eb-quickcart-left">Ghi chú</div>
						<div class="eb-quickcart-right">
							<textarea name="t_ghichu" placeholder="Ví dụ: Giao hàng trong giờ hành chính, gọi điện trước khi giao..."></textarea>
						</div>
					</div>
					<div class="text-center">
						<button type="submit" id="sb_submit_cart" class="default-bg cur"><i class="fa fa-shopping-cart"></i> Gửi đơn hàng</button>
						<button type="button" class="btn-addto-cart default-2bg div-jquery-add-to-cart click-jquery-add-to-cart">Cho vào giỏ hàng</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
