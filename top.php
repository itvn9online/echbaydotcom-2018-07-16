<?php
// top menu dưới dạng widget
$eb_top_widget = _eb_echbay_sidebar( 'eb_top_global', 'eb-widget-top cf', 'div', 1, 0 );

//
if ( $eb_top_widget == '' ) {
	include EB_THEME_PLUGIN_INDEX . 'top_default.php';
}
else {
?>

<div class="eb-top">
	<div class="<?php echo $__cf_row['cf_top_class_style']; ?>">
		<?php $eb_top_widget; ?>
	</div>
</div>
<?php
}
?>
