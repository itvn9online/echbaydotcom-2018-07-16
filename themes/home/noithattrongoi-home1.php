<?php
$str_noithattrongoi_home1 = '
<div class="cf">
	<div class="lf f50 fullsize-if-mobile">
		<div class="right-menu-space l20 medium">
			<div>{tmp.trv_gioithieu}</div>
			<br>
		</div>
	</div>
	<div class="lf f50 fullsize-if-mobile global-a-posi"><a href="{tmp.p_link}" title="{tmp.post_title}"{tmp.target_blank}>&nbsp;</a>
		<div data-size="{tmp.data_size}" data-img="{tmp.trv_img}" data-table-img="{tmp.trv_table_img}" data-mobile-img="{tmp.trv_mobile_img}" class="ti-le-global each-to-bgimg banner-ads-media">&nbsp;</div>
	</div>
</div>';
?>

<div id="noithattrongoi-home1">
	<div class="<?php echo $__cf_row['cf_blog_class_style']; ?>">
		<div class="noithattrongoi-home1">
			<h1 class="home_default-title text-center"><?php echo $__cf_row ['cf_title']; ?></h1>
			<div style="text-align: justify;"><?php echo _eb_load_ads( 11, 1, 'auto', array(), 0, $str_noithattrongoi_home1 ); ?></div>
		</div>
	</div>
</div>

