<br>
<div><a href="javascript:;" class="medium blackcolor bold admin-set-reload-url">Đơn hàng</a></div>
<ul class="cf eb-admin-tab eb-order-filter-tab">
	<li><a href="admin.php?page=eb-order">Tất cả</a></li>
	<?php
	global $arr_hd_trangthai;
	
	//
	foreach ( $arr_hd_trangthai as $k => $v ) {
		if ( $k >= 0 ) {
			echo '<li data-tab="' . $k . '"><a href="admin.php?page=eb-order&tab=' . $k . '">' . $v . '</a></li>';
		}
	}
	?>
</ul>
<script type="text/javascript" src="<?php echo EB_URL_OF_PLUGIN . 'echbay/js/order.js?v=' . date_time; ?>"></script>
<?php


//
//echo ECHBAY_PRI_CODE;



//
if ( isset($_GET['id']) ) {
	$id = (int)$_GET['id'];
	if ( $id > 0 ) {
		include ECHBAY_PRI_CODE . 'order_details.php';
	}
} else {
	include ECHBAY_PRI_CODE . 'order_list.php';
}





