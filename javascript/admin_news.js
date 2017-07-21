


//console.log('admin_news');

jQuery('#toplevel_page_eb-order .toplevel_page_eb-order').attr({
	href: 'admin.php?page=eb-dashboard'
});


// nếu người dùng chưa đổi tên menu chính -> tạo luôn tên mới
if ( typeof cf_chu_de_chinh == 'undefined' || cf_chu_de_chinh == '' ) {
	jQuery('#menu-posts .wp-menu-name').html( 'Tin tức' );
}


