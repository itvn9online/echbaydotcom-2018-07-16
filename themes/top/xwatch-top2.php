<?php
/*
Domain: xwatch.vn
*/
?>

<div id="xwatch-top2">
	<div class="default-bg hide-if-mobile">
		<div class="<?php echo $__cf_row['cf_footer_class_style']; ?> cf">
			<div class="lf f30"><a href="./" class="web-logo d-block" style="background-image:url('<?php echo $__cf_row['cf_logo']; ?>');">&nbsp;</a></div>
			<div class="lf f70">
				<div class="cf div-search-margin">
					<div class="lf f50">
						<div>
							<div class="div-search">
								<form role="search" name="frm_search" method="get" action="<?php echo web_link; ?>">
									<input type="search" placeholder="Tìm kiếm" value="<?php echo $current_search_key; ?>" name="s" aria-required="true" required>
									<input type="hidden" name="post_type" value="post" />
									<button type="submit" class="cur"><i class="fa fa-search"></i></button>
								</form>
							</div>
							<div id="oiSearchAjax"></div>
							<div class="l25 cf fix-search-ins">
								<div class="redcolor lf">Gợi ý từ khóa:</div>
								<div class="div-search-ins lf"><?php echo EBE_echbay_top_menu(); ?></div>
								<!-- <div class="whitecolor lf">...</div> --> 
							</div>
						</div>
					</div>
					<div class="lf f50 cf medium whitecolor">
						<div class="lf f40 text-center"><a href="./lien-he" class="whitecolor"><span class="d-block upper redcolor"><i class="fa fa-map-marker"></i> Địa chỉ</span> cửa hàng</a></div>
						<div class="lf f60 text-center top-multi-hotline"><span class="d-block upper redcolor"><i class="fa fa-volume-control-phone"></i> Hotline</span> <span class="phone-numbers-inline"><?php echo $__cf_row['cf_call_hotline']; ?></span></div>
						<!--
						<div class="left-menu-space">
							<div class="top-multi-hotline"><span class="d-block upper redcolor"><i class="fa fa-volume-control-phone"></i> Hotline</span> <span class="phone-numbers-inline"><?php echo $__cf_row['cf_call_hotline']; ?></span></div>
							<p class="d-none"><a href="./lien-he" class="whitecolor"><span class="d-block upper redcolor"><i class="fa fa-map-marker"></i> Địa chỉ</span> cửa hàng</a></p>
						</div>
						--> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
