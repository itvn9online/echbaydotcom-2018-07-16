<!--
Description: Tạo danh sách logo đối tác theo dạng slider -> danh sách các quảng cáo có trạng thái là: Banner/ Logo đối tác ( chân trang ).
Tags: logo doi tac, quang cao chan trang
-->
<?php
$check_load_logo_doitac = _eb_number_only( EBE_get_lang('doitac_num') );

if ( $check_load_logo_doitac > 0 ) {
	
	//
	$num_load_logo_doitac = EBE_get_lang('doitac_title');
	if ( $num_load_logo_doitac != '' ) {
		$num_load_logo_doitac = '<div class="text-center title-btn-chantrang home-hot-title">
			<div>' . $num_load_logo_doitac . '</div>
		</div>';
	}
	
?>
<div class="sponsor-top-desktop">
	<div><?php echo $num_load_logo_doitac; ?></div>
	<div class="home-btn-chantrang text-center <?php echo $__cf_row['cf_blog_class_style']; ?>">
		<div class="home-prev-chantrang"><i class="fa fa-angle-left"></i></div>
		<div class="home-next-chantrang"><i class="fa fa-angle-right"></i></div>
		<div data-num="<?php echo $check_load_logo_doitac; ?>" class="banner-chan-trang"><?php echo _eb_load_ads( 5, $check_load_logo_doitac, EBE_get_lang('doitac_size') ); ?></div>
	</div>
</div>
<?

}
