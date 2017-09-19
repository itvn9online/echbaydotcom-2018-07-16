<?php
/*
Description: Sử dụng nhân của bản echbaytwo-home1 sau đó CSS lại cho phù hợp với giao diện mong muốn của vinhaninterior.
*/
?>

<div id="vinhaninteriorV2-home3">
	<div class="home_default-title text-center"><?php echo EBE_get_lang('ads_status12'); ?></div>
	<br>
	<?php
	include EB_THEME_PLUGIN_INDEX . 'themes/home/echbaytwo-home1.php';
//	$arr_for_add_theme_css[ EB_THEME_PLUGIN_INDEX . 'css/echbaytwo-home1.css' ] = 1;
	$arr_for_add_css[ EB_THEME_PLUGIN_INDEX . 'css/echbaytwo-home1.css' ] = 1;
	?>
</div>
