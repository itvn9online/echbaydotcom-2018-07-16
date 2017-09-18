<?php

// tạo HTML riêng
$html_for_get_du_an = '
<li class="grid-item dt-project-{tmp.ID} item-small">
	<div class="banner-ads-padding global-a-posi"><a href="{tmp.trv_img}" rel="prettyPhoto[portf_gal]" title="{tmp.post_title}"><img class="lazy" data-original="{tmp.trv_img}" alt="" /></a>
		<div data-size="{tmp.data_size}" data-img="{tmp.trv_img}" data-table-img="{tmp.trv_table_img}" data-mobile-img="{tmp.trv_mobile_img}" class="ti-le-global each-to-bgimg banner-ads-media">&nbsp;</div>
		<div class="banner-ads-title">{tmp.trv_tieude}</div>
	</div>
</li>';

// js để xử lý slider
$arr_for_add_outsource_js[] = 'http://vinhaninterior.com/lib/themes/vinhan/js/jquery.isotope.min.js?ver=1.0';
$arr_for_add_outsource_async_js[] = 'http://vinhaninterior.com/lib/themes/vinhan/js/custom/custom-isotope-portfolio.js?ver=1.0';

?>
<script type='text/javascript'>
/* <![CDATA[ */
var vals = {"grid_manager":"1","grid_very_wide":"7","grid_wide":"5","grid_normal":"5","grid_small":"5","grid_tablet":"3","grid_phone":"2","grid_gutter_width":"4"};
var dt_grid_XNJtp = {"id":"abc","initial_word":""};
/* ]]> */
</script>

<div id="vinhaninterior-home3">
	<div class="vinhaninterior-home3">
		<div class="home_default-title text-center"><?php echo EBE_get_lang('ads_status12'); ?></div>
		<br>
		<div class="patti-grid" id="gridwrapper_abc">
			<div id="portfolio-wrapper"><?php echo _eb_load_ads( 12, 4, '295/379', array(), 0, $html_for_get_du_an, array(
					'add_class' => 'portfolio grid isotope grid_abc'
				) ); ?></div>
		</div>
	</div>
</div>
