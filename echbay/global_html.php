<div id="oi_admin_popup"></div>
<div class="d-none">
	<div id="content-for-quick-add-menu">
		<ul class="buttom-for-quick-add-menu">
			<li>
				<h4>Hỗ trợ thêm menu nhanh</h4>
				<div>* <em>Bấm dấu <strong>[ + ]</strong> để thêm menu!</em></div>
			</li>
			<li class="cf">
				<div class="lf f80"><?php echo EBE_get_lang('home'); ?> <em>(/)</em></div>
				<div class="lf f20 text-center">
					<button data-link="/" data-text="<?php echo EBE_get_lang('home'); ?>" type="button" class="cur click-to-add-custom-link"><i class="fa fa-plus"></i></button>
				</div>
			</li>
			<li class="cf">
				<div class="lf f80"><i class="fa fa-home"></i> <?php echo EBE_get_lang('home'); ?> <em>(/)</em></div>
				<div class="lf f20 text-center">
					<button data-link="/" data-text="<i class='fa fa-home'></i> <?php echo EBE_get_lang('home'); ?>" type="button" class="cur click-to-add-custom-link"><i class="fa fa-plus"></i></button>
				</div>
			</li>
			<li class="cf">
				<div class="lf f80"><i class="fa fa-home"></i> <em>(/)</em></div>
				<div class="lf f20 text-center">
					<button data-link="/" data-text="<i class='fa fa-home'></i>" type="button" class="cur click-to-add-custom-link"><i class="fa fa-plus"></i></button>
				</div>
			</li>
			<li class="cf">
				<div class="lf f80"><i class="fa fa-support"></i> <?php echo EBE_get_lang('lienhe'); ?> <em>(/contact)</em></div>
				<div class="lf f20 text-center">
					<button data-link="/contact" data-text="<?php echo EBE_get_lang('lienhe'); ?>" type="button" class="cur click-to-add-custom-link"><i class="fa fa-plus"></i></button>
				</div>
			</li>
			<li class="cf">
				<div class="lf f80"><i class="fa fa-support"></i> <?php echo EBE_get_lang('lienhe'); ?> <em>(/lienhe)</em></div>
				<div class="lf f20 text-center">
					<button data-link="/lienhe" data-text="<?php echo EBE_get_lang('lienhe'); ?>" type="button" class="cur click-to-add-custom-link"><i class="fa fa-plus"></i></button>
				</div>
			</li>
			<li class="cf">
				<div class="lf f80"><i class="fa fa-support"></i> <?php echo EBE_get_lang('lienhe'); ?> <em>(/lien-he)</em></div>
				<div class="lf f20 text-center">
					<button data-link="/lien-he" data-text="<?php echo EBE_get_lang('lienhe'); ?>" type="button" class="cur click-to-add-custom-link"><i class="fa fa-plus"></i></button>
				</div>
			</li>
			<li class="cf">
				<div class="lf f80"><i class="fa fa-shopping-cart"></i> <?php echo EBE_get_lang('cart'); ?> <em>(/cart)</em></div>
				<div class="lf f20 text-center">
					<button data-link="/cart" data-text="<?php echo EBE_get_lang('cart'); ?>" type="button" class="cur click-to-add-custom-link"><i class="fa fa-plus"></i></button>
				</div>
			</li>
			<li class="cf">
				<div class="lf f80"><i class="fa fa-user"></i> <?php echo EBE_get_lang('taikhoan'); ?> <em>(/profile)</em></div>
				<div class="lf f20 text-center">
					<button data-link="/profile" data-text="<?php echo EBE_get_lang('taikhoan'); ?>" type="button" class="cur click-to-add-custom-link"><i class="fa fa-plus"></i></button>
				</div>
			</li>
			<li class="cf">
				<div class="lf f80"><i class="fa fa-list"></i> Tất cả danh mục <em class="small">(lấy toàn bộ chuyên mục đang có trên hệ thống)</em></div>
				<div class="lf f20 text-center">
					<button data-link="/auto.get_all_category/" data-text="Toàn bộ danh mục" type="button" class="cur click-to-add-custom-link"><i class="fa fa-plus"></i></button>
				</div>
			</li>
			<li class="cf">
				<div class="lf f80"><i class="fa fa-home"></i> Tất cả danh mục <em class="small">(lấy toàn bộ chuyên mục đang có trên hệ thống, đính kèm Home menu vào đầu tiên)</em></div>
				<div class="lf f20 text-center">
					<button data-link="/auto.get_all_category/home/" data-text="<i class='fa fa-home'></i> Danh mục" type="button" class="cur click-to-add-custom-link"><i class="fa fa-plus"></i></button>
				</div>
			</li>
			<li class="cf">
				<div class="lf f80"><i class="fa fa-bars"></i> Danh mục <em class="small">(lấy toàn bộ chuyên mục đang có trên hệ thống, đính kèm cả icon, dùng cho việc tạo dropdown menu)</em></div>
				<div class="lf f20 text-center">
					<button data-link="/auto.get_all_category/bars/" data-text="<i class='fa fa-bars'></i> Danh mục" type="button" class="cur click-to-add-custom-link"><i class="fa fa-plus"></i></button>
				</div>
			</li>
			<li class="cf">
				<div class="lf f80"><i class="fa fa-bars"></i> Danh mục <i class="fa fa-caret-down"></i> <em class="small">(lấy toàn bộ chuyên mục đang có trên hệ thống, đính kèm cả icon, dùng cho việc tạo dropdown menu - mẫu 2)</em></div>
				<div class="lf f20 text-center">
					<button data-link="/auto.get_all_category/caret/" data-text="<i class='fa fa-bars'></i> Danh mục <i class='fa fa-caret-down'></i>" type="button" class="cur click-to-add-custom-link"><i class="fa fa-plus"></i></button>
				</div>
			</li>
			<li class="cf">
				<div class="lf f80">Đã thông báo với BCT</div>
				<div class="lf f20 text-center">
					<button data-link="#" data-text="<img src='<?php echo basename( WP_CONTENT_DIR ); ?>/echbaydotcom/images-global/dathongbao.png' width='200' height='76' />" type="button" class="cur click-to-add-custom-link"><i class="fa fa-plus"></i></button>
				</div>
			</li>
			<li class="cf">
				<div class="lf f80">Đã đăng ký với BCT</div>
				<div class="lf f20 text-center">
					<button data-link="#" data-text="<img src='<?php echo basename( WP_CONTENT_DIR ); ?>/echbaydotcom/images-global/dadangky.png' width='200' height='75' />" type="button" class="cur click-to-add-custom-link"><i class="fa fa-plus"></i></button>
				</div>
			</li>
		</ul>
	</div>
</div>
