<?php



// nếu có quyền xem đơn -> hiển thị đơn hàng
if ( current_user_can('publish_posts') )  {
	include ECHBAY_PRI_CODE . 'order_main.php';
}
// mặc định chỉ cho xem dashboard
else {
	echo '<br><br><h2>Permission ERROR!</h2>';
}




