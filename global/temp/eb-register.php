<?php
if ( $mtv_id > 0 ) {
	die('Login exist!');
}
?>

<div class="popup-border" style="display:none;">
	<div class="cf opoup-title-bg default-bg">
		<div class="lf f70 bold">Đăng ký</div>
		<div align="right" class="lf f30"><a onclick="g_func.opopup();" href="javascript:;">Đóng [x]</a></div>
	</div>
	<div class="popup-padding l19">
		<div>Tạo mới một tài khoản cho phép bạn truy cập và sử dụng các dịch vụ trên website này. Nếu bạn đã có tài khoản, bạn hãy <a onclick="g_func.opopup('login')" href="javascript:;">đăng nhập tại đây</a></div>
		<br />
		<form name="frm_dangnhap" method="post" action="process/?set_module=register" target="target_eb_iframe" onSubmit="return _global_js_eb.add_primari_iframe();">
			<div>
				<label for="t_email"><strong>Email</strong></label>
			</div>
			<div>
				<input type="email" name="t_email" id="t_email" value="" placeholder="Email" aria-required="true" required />
			</div>
			<br />
			<div>
				<label for="t_matkhau"><strong>Mật khẩu</strong></label>
			</div>
			<div>
				<input type="password" name="t_matkhau" id="t_matkhau" value="" placeholder="Password" aria-required="true" required />
			</div>
			<br />
			<div>
				<label for="t_matkhau2"><strong>Xác nhận mật khẩu</strong></label>
			</div>
			<div>
				<input type="password" name="t_matkhau2" id="t_matkhau2" value="" placeholder="Re-password" aria-required="true" required />
			</div>
			<br />
			<div>
				<button type="submit" class="cur">Đăng ký</button>
			</div>
			<br>
		</form>
	</div>
</div>
