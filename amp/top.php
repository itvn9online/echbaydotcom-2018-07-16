<?php
$str_for_amp_logo = web_name;
if ( $__cf_row['cf_on_off_amp_logo'] == 1 ) {
	$str_for_amp_logo = $__cf_row['cf_logo'];
	if ( strstr( $str_for_amp_logo, '//' ) == false ) {
		if ( substr( $str_for_amp_logo, 0, 1 ) == '/' ) {
			$str_for_amp_logo = substr( $str_for_amp_logo, 1 );
		}
		$str_for_amp_logo = web_link . $str_for_amp_logo;
	}
	$str_for_amp_logo = '<span class="amp-wp-logo" style="background-image:url(' . $str_for_amp_logo . ');"> </span>';
}
?>
<header id="#top" class="amp-wp-header">
	<div><a href="<?php echo web_link; ?>"><?php echo $str_for_amp_logo; ?></a></div>
</header>
