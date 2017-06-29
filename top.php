<?php
// top menu dưới dạng widget
$eb_top_widget = _eb_echbay_sidebar( 'eb_top_global', 'eb-widget-top cf', 'div', 1, 0 );

// nếu không có nội dung trong widget -> lấy theo thiết kế mặc định
if ( $eb_top_widget == '' ) {
	include EB_THEME_PLUGIN_INDEX . 'top_default.php';
}
else {
?>

<div class="eb-top">
	<div class="<?php echo $__cf_row['cf_top_class_style']; ?>"><?php echo $eb_top_widget; ?></div>
</div>
<?php
}



