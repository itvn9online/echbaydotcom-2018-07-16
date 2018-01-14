<?php


//
$___eb_lang = array();

// định dạng kiểu dữ liệu
$eb_type_lang = array();

// class CSS riêng nếu có
$eb_class_css_lang = array();

//
define( 'eb_key_for_site_lang', 'lang_eb_' );


//
$___eb_lang[eb_key_for_site_lang . 'home'] = 'Trang chủ';

//
$___eb_lang[eb_key_for_site_lang . 'search'] = 'Tìm kiếm';
// placeholder for search
$___eb_lang[eb_key_for_site_lang . 'searchp'] = $___eb_lang[eb_key_for_site_lang . 'search'] . ' sản phẩm';

$___eb_lang[eb_key_for_site_lang . 'cart'] = 'Giỏ hàng';
$___eb_lang[eb_key_for_site_lang . 'shopping_cart'] = $___eb_lang[eb_key_for_site_lang . 'cart'];
$___eb_lang[eb_key_for_site_lang . 'lienhe'] = 'Liên hệ';
$___eb_lang[eb_key_for_site_lang . 'muangay'] = 'Mua ngay';

$___eb_lang[eb_key_for_site_lang . 'taikhoan'] = 'Tài khoản';
$___eb_lang[eb_key_for_site_lang . 'thoat'] = 'Thoát';
$___eb_lang[eb_key_for_site_lang . 'xacnhan_thoat'] = 'Xác nhận đăng xuất khỏi hệ thống';
$___eb_lang[eb_key_for_site_lang . 'dangnhap'] = 'Đăng nhập';
$___eb_lang[eb_key_for_site_lang . 'dangky'] = 'Đăng ký';

//
$___eb_lang[eb_key_for_site_lang . 'home_hot'] = '<i class="fa fa-dollar"></i> Sản phẩm HOT';
$___eb_lang[eb_key_for_site_lang . 'home_new'] = '<i class="fa fa-star"></i> Sản phẩm MỚI';

$___eb_lang[eb_key_for_site_lang . 'order_by'] = 'Sắp xếp theo';
$___eb_lang[eb_key_for_site_lang . 'order_view'] = 'Xem nhiều';
$___eb_lang[eb_key_for_site_lang . 'order_price_down'] = 'Giá giảm dần';
$___eb_lang[eb_key_for_site_lang . 'order_price_up'] = 'Giá tăng dần';
$___eb_lang[eb_key_for_site_lang . 'order_az'] = 'Tên sản phẩm ( từ A đến Z )';
$___eb_lang[eb_key_for_site_lang . 'order_za'] = 'Tên sản phẩm ( từ Z đến A )';

//
$___eb_lang[eb_key_for_site_lang . 'post_giacu'] = 'Giá cũ';
$___eb_lang[eb_key_for_site_lang . 'post_giamgia'] = 'Giảm<br>giá';
$___eb_lang[eb_key_for_site_lang . 'post_giamoi'] = 'Giá mới';
$___eb_lang[eb_key_for_site_lang . 'post_zero'] = '<em>Liên hệ</em>';
$___eb_lang[eb_key_for_site_lang . 'post_luotmua'] = 'Lượt mua';
$___eb_lang[eb_key_for_site_lang . 'post_soluong'] = 'Số lượng';
$___eb_lang[eb_key_for_site_lang . 'post_time_discount'] = 'Thời gian khuyến mại còn lại:';
$___eb_lang[eb_key_for_site_lang . 'post_time_soldout'] = 'Sản phẩm tạm thời ngừng bán';
$___eb_lang[eb_key_for_site_lang . 'post_comment'] = 'Bình luận';
$___eb_lang[eb_key_for_site_lang . 'post_content'] = 'Thông tin sản phẩm';
$___eb_lang[eb_key_for_site_lang . 'post_other'] = 'Sản phẩm khác';

//
$___eb_lang[eb_key_for_site_lang . 'cart_diachi'] = 'Địa chỉ';
$___eb_lang[eb_key_for_site_lang . 'cart_dienthoai'] = 'Điện thoại';
$___eb_lang[eb_key_for_site_lang . 'cart_pla_dienthoai'] = $___eb_lang[eb_key_for_site_lang . 'cart_dienthoai'];
$___eb_lang[eb_key_for_site_lang . 'cart_hotline'] = 'Hotline';

// giờ vàng
$___eb_lang[eb_key_for_site_lang . 'golden_time'] = 'Giờ vàng';
$___eb_lang[eb_key_for_site_lang . 'golden_desc_time'] = 'Giờ vàng GIÁ SỐC, khuyến mại tận GỐC';
$___eb_lang[eb_key_for_site_lang . 'limit_golden_time'] = 50;
$eb_type_lang[eb_key_for_site_lang . 'limit_golden_time'] = 'number';

//
$___eb_lang[eb_key_for_site_lang . 'favorite'] = 'Sản phẩm yêu thích';
$___eb_lang[eb_key_for_site_lang . 'limit_favorite'] = 50;
$eb_type_lang[eb_key_for_site_lang . 'limit_favorite'] = 'number';

// default status
$___eb_lang[eb_key_for_site_lang . 'ads_status1'] = 'Banner chính ( 1366 x Auto )';
$___eb_lang[eb_key_for_site_lang . 'ads_status2'] = 'Chờ sử dụng';
$___eb_lang[eb_key_for_site_lang . 'ads_status3'] = $___eb_lang[eb_key_for_site_lang . 'ads_status2'];
$___eb_lang[eb_key_for_site_lang . 'ads_status4'] = 'Review của khách hàng';
$___eb_lang[eb_key_for_site_lang . 'ads_status5'] = 'Banner/ Logo đối tác ( chân trang )';
$___eb_lang[eb_key_for_site_lang . 'ads_status6'] = 'Video HOT (trang chủ)';
$___eb_lang[eb_key_for_site_lang . 'ads_status7'] = 'Bộ sưu tập/ Banner nổi bật (trang chủ)';
$___eb_lang[eb_key_for_site_lang . 'ads_status8'] = 'Địa chỉ/ Bản đồ (chân trang/ liên hệ)';
$___eb_lang[eb_key_for_site_lang . 'ads_status9'] = 'Banner chuyên mục ở trang chủ';
$___eb_lang[eb_key_for_site_lang . 'ads_status10'] = 'Slide ảnh theo phân nhóm (trang chi tiết)';
$___eb_lang[eb_key_for_site_lang . 'ads_status11'] = 'Noname';
$___eb_lang[eb_key_for_site_lang . 'ads_status12'] = $___eb_lang[eb_key_for_site_lang . 'ads_status11'];
$___eb_lang[eb_key_for_site_lang . 'ads_status13'] = $___eb_lang[eb_key_for_site_lang . 'ads_status11'];
$___eb_lang[eb_key_for_site_lang . 'ads_status14'] = $___eb_lang[eb_key_for_site_lang . 'ads_status11'];
$___eb_lang[eb_key_for_site_lang . 'ads_status15'] = $___eb_lang[eb_key_for_site_lang . 'ads_status11'];

$___eb_lang[eb_key_for_site_lang . 'product_status0'] = 'Mặc định';
$___eb_lang[eb_key_for_site_lang . 'product_status1'] = 'Sản phẩm HOT';
$___eb_lang[eb_key_for_site_lang . 'product_status2'] = 'Sản phẩm MỚI';
$___eb_lang[eb_key_for_site_lang . 'product_status3'] = 'Sản phẩm BÁN CHẠY';
$___eb_lang[eb_key_for_site_lang . 'product_status4'] = 'Sản phẩm GIẢM GIÁ';
$___eb_lang[eb_key_for_site_lang . 'product_status5'] = 'Sản phẩm KHÁC';
$___eb_lang[eb_key_for_site_lang . 'product_status6'] = $___eb_lang[eb_key_for_site_lang . 'golden_time'];
$___eb_lang[eb_key_for_site_lang . 'product_status7'] = $___eb_lang[eb_key_for_site_lang . 'ads_status11'];
$___eb_lang[eb_key_for_site_lang . 'product_status8'] = $___eb_lang[eb_key_for_site_lang . 'ads_status11'];
$___eb_lang[eb_key_for_site_lang . 'product_status9'] = $___eb_lang[eb_key_for_site_lang . 'ads_status11'];
$___eb_lang[eb_key_for_site_lang . 'product_status10'] = $___eb_lang[eb_key_for_site_lang . 'ads_status11'];


// details
$___eb_lang[eb_key_for_site_lang . 'chitietsp'] = 'Chi tiết Sản phẩm';
$___eb_lang[eb_key_for_site_lang . 'tuongtu'] = 'Sản phẩm tương tự';

// footer
$___eb_lang[eb_key_for_site_lang . 'copyright'] = 'Bản quyền';
$___eb_lang[eb_key_for_site_lang . 'allrights'] = ' - Toàn bộ phiên bản.';
$___eb_lang[eb_key_for_site_lang . 'joinus'] = 'Kết nối với chúng tôi';
$___eb_lang[eb_key_for_site_lang . 'diachi'] = $___eb_lang[eb_key_for_site_lang . 'cart_diachi'] . ':';
$___eb_lang[eb_key_for_site_lang . 'dienthoai'] = $___eb_lang[eb_key_for_site_lang . 'cart_dienthoai'] . ':';
$___eb_lang[eb_key_for_site_lang . 'poweredby'] = 'Cung cấp bởi';

// echbay two footer sologan
$___eb_lang[eb_key_for_site_lang . 'ebslogan1'] = '<i class="fa fa-refresh"></i> Đổi hàng<br />trong 7 ngày';
$___eb_lang[eb_key_for_site_lang . 'ebslogan2'] = '<i class="fa fa-truck"></i> Giao hàng miễn phí<br />Toàn Quốc';
$___eb_lang[eb_key_for_site_lang . 'ebslogan3'] = '<i class="fa fa-dollar"></i> Thanh toán<br />khi giao hàng';
$___eb_lang[eb_key_for_site_lang . 'ebslogan4'] = '<i class="fa fa-check-square"></i> Bảo hành VIP<br />12 tháng';

// quick cart
$___eb_lang[eb_key_for_site_lang . 'cart_muangay'] = $___eb_lang[eb_key_for_site_lang . 'muangay'];
$___eb_lang[eb_key_for_site_lang . 'cart_mausac'] = 'Màu sắc';
$___eb_lang[eb_key_for_site_lang . 'cart_kichco'] = 'Kích cỡ';
$___eb_lang[eb_key_for_site_lang . 'cart_soluong'] = $___eb_lang[eb_key_for_site_lang . 'post_soluong'];
$___eb_lang[eb_key_for_site_lang . 'cart_thanhtien'] = 'Thành tiền';
$___eb_lang[eb_key_for_site_lang . 'cart_hoten'] = 'Họ và tên';
$___eb_lang[eb_key_for_site_lang . 'cart_diachi2'] = 'Địa chỉ nhận hàng';
$___eb_lang[eb_key_for_site_lang . 'cart_ghichu'] = 'Ghi chú';
$___eb_lang[eb_key_for_site_lang . 'cart_vidu'] = 'Ví dụ: Giao hàng trong giờ hành chính, gọi điện trước khi giao...';
$___eb_lang[eb_key_for_site_lang . 'cart_gui'] = '<i class="fa fa-shopping-cart"></i> Gửi đơn hàng';
$___eb_lang[eb_key_for_site_lang . 'cart_them'] = 'Cho vào giỏ hàng';
$___eb_lang[eb_key_for_site_lang . 'cart_emailformat'] = 'Email không đúng định dạng';

// contact
$___eb_lang[eb_key_for_site_lang . 'lh_lienhe'] = 'Liên hệ với chúng tôi';
$___eb_lang[eb_key_for_site_lang . 'lh_luuy'] = 'Để liên hệ với chúng tôi, bạn có thể gửi email tới <a href="mailto:{tmp.cf_email}" rel="nofollow">{tmp.cf_email}</a>, sử dụng phom liên hệ phía dưới hoặc liên hệ trực tiếp theo địa chỉ và số điện thoại chúng tôi cung cấp.';
$___eb_lang[eb_key_for_site_lang . 'lh_hoten'] = $___eb_lang[eb_key_for_site_lang . 'cart_hoten'];
$___eb_lang[eb_key_for_site_lang . 'lh_diachi'] = $___eb_lang[eb_key_for_site_lang . 'cart_diachi'];
$___eb_lang[eb_key_for_site_lang . 'lh_dienthoai'] = $___eb_lang[eb_key_for_site_lang . 'cart_dienthoai'];
$___eb_lang[eb_key_for_site_lang . 'lh_noidung'] = 'Nội dung';
$___eb_lang[eb_key_for_site_lang . 'lh_submit'] = 'Gửi liên hệ';
$___eb_lang[eb_key_for_site_lang . 'lh_note'] = 'là các trường bắt buộc phải điền.<br>Vui lòng cung đầy đủ thông tin để quá trình trao đổi được diễn ra thuận lợi hơn.';
$___eb_lang[eb_key_for_site_lang . 'lh_done'] = 'Cảm ơn bạn! thông tin của bạn đã được gửi đi, chúng tôi sẽ phản hồi sớm nhất có thể.';

// booking done
$___eb_lang[eb_key_for_site_lang . 'booking_done'] = file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/hoan-tat.html' );
$eb_type_lang[eb_key_for_site_lang . 'booking_done'] = 'textarea';

// nội dung email đơn hàng
$___eb_lang[eb_key_for_site_lang . 'booking_mail'] = file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/mail/booking.html' );
$eb_type_lang[eb_key_for_site_lang . 'booking_mail'] = 'textarea';

// file mail mặc định
$___eb_lang[eb_key_for_site_lang . 'mail_main'] = file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/mail/mail.html' );
$eb_type_lang[eb_key_for_site_lang . 'mail_main'] = 'textarea';


/*
* Phần này không hẳn là phần ngôn ngữ, mà nó là phần config nhanh, đỡ phải chỉnh nhiều
*/
// kích thước ảnh quảng cáo ở phần danh sách sản phẩm trang chủ: auto || 90/728
$___eb_lang[eb_key_for_site_lang . 'homelist_size'] = 'auto';
$eb_class_css_lang[eb_key_for_site_lang . 'homelist_size'] = 'fixed-size-for-config';

$___eb_lang[eb_key_for_site_lang . 'homelist_num'] = '1';
$eb_type_lang[eb_key_for_site_lang . 'homelist_num'] = 'number';


// tiêu đề của phần logo đối tác
$___eb_lang[eb_key_for_site_lang . 'doitac_title'] = '';

// số tin trên mỗi dòng
$___eb_lang[eb_key_for_site_lang . 'doitac_num'] = '5';
$eb_type_lang[eb_key_for_site_lang . 'doitac_num'] = 'number';

// kích thước của banner đối tác: auto || 1/2
$___eb_lang[eb_key_for_site_lang . 'doitac_size'] = 'auto';
$eb_class_css_lang[eb_key_for_site_lang . 'doitac_size'] = 'fixed-size-for-config';


// Số lượng banner lớn sẽ lấy cho mỗi trang
$___eb_lang[eb_key_for_site_lang . 'bigbanner_num'] = '5';
$eb_type_lang[eb_key_for_site_lang . 'bigbanner_num'] = 'number';


// phần ngôn ngữ riêng, để sử dụng cho các câu từ mà một số website sẽ dùng
$___eb_lang[eb_key_for_site_lang . 'custom_text'] = 'Custom text';
$___eb_lang[eb_key_for_site_lang . 'custom_text1'] = 'Custom text 1';
$___eb_lang[eb_key_for_site_lang . 'custom_text2'] = 'Custom text 2';
$___eb_lang[eb_key_for_site_lang . 'custom_text3'] = 'Custom text 3';
$___eb_lang[eb_key_for_site_lang . 'custom_text4'] = 'Custom text 4';
$___eb_lang[eb_key_for_site_lang . 'custom_text5'] = 'Custom text 5';
$___eb_lang[eb_key_for_site_lang . 'custom_text6'] = 'Custom text 6';
$___eb_lang[eb_key_for_site_lang . 'custom_text7'] = 'Custom text 7';
$___eb_lang[eb_key_for_site_lang . 'custom_text8'] = 'Custom text 8';
$___eb_lang[eb_key_for_site_lang . 'custom_text9'] = 'Custom text 9';


// URL của phần chính sách, quy định trong phần đặt hàng
$___eb_lang[eb_key_for_site_lang . 'url_chinhsach'] = '#';
$___eb_lang[eb_key_for_site_lang . 'chinhsach'] = 'Quý khách vui lòng tham khảo <a href="{tmp.url_chinhsach}" target="_blank">chính sách, quy định chung</a> của chúng tôi.';




//
$___eb_default_lang = $___eb_lang;
//$___eb_lang_default = $___eb_lang;
//$___eb_lang = array();
// EBE_get_lang('home')




