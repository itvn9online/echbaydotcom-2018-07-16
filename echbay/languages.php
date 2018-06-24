<?php



//
global $___eb_default_lang;
global $___eb_lang;
global $eb_type_lang;
global $eb_note_lang;
global $eb_ex_from_github;
global $eb_class_css_lang;


//
//print_r( $___eb_lang );




?>

<div class="wrap">
	<h1>Bản dịch</h1>
</div>
<p>* Bạn có thể thay đổi các bản dịch, cụm từ trên website sang nội dung khác phù hợp với website của bạn hơn. Bấm đúp chuột vào cụm từ cần thay đổi, nhập từ mới rồi enter.</p>
<h4><span class="redcolor">&lt;?php</span> <span class="greencolor">echo</span> EBE_get_lang(<span class="orgcolor">'home'</span>); <span class="redcolor">?&gt;</span></h4>
<h4>EBE_get_lang(<span class="orgcolor">'home'</span>)</h4>
<br>
<form name="frm_languages" method="post" action="<?php echo web_link; ?>process/?set_module=languages" target="target_eb_iframe" onsubmit="return check_update_languages();">
	<div class="d-none">
		<input type="text" name="languages_key_edit" id="languages_key_edit" value="">
		<textarea name="languages_content_edit" id="languages_content_edit" style="width:90%;"></textarea>
	</div>
	<div>
		<input type="submit" value="Cập nhật" class="button button-primary eb-admin-lang-submit" />
	</div>
</form>
<table border="0" cellpadding="0" cellspacing="0" width="99%" class="table-list languages-textarea-height table-languages-list">
	<tr class="table-list-title">
		<td width="20%">Key</td>
		<td width="80%">Value</td>
	</tr>
	<?php
	
	// nạp lại bảng ngôn ngữ lần nữa
	$___eb_lang = $___eb_default_lang;
	EBE_get_lang_list();
//	print_r( $___eb_lang );
//	print_r( $___eb_default_lang );
	
	//
	foreach ( $___eb_lang as $k => $v ) {
		if ( isset( $___eb_default_lang[ $k ] ) ) {
			$custom_class_css = '';
			if ( isset( $eb_class_css_lang[ $k ] ) ) {
				$custom_class_css = ' ' . $eb_class_css_lang[ $k ];
			}
			
			//
			$pla = esc_html( $___eb_default_lang[ $k ] );
			
			// phần ngôn ngữ
			echo '
			<tr>
				<td>' . str_replace( eb_key_for_site_lang, '', $k ) . '</td>
				<td class="table-languages-edit">';
			
			if ( isset( $eb_type_lang[ $k ] ) ) {
				if ( $eb_type_lang[ $k ] == 'textarea' ) {
					echo '<textarea data-min-height="21" data-add-height="1" placeholder="' . $pla . '" id="' . $k . '" class="click-to-update-url-lang cur' . $custom_class_css . '">' . esc_html( $v ) . '</textarea>';
				}
				else if ( $eb_type_lang[ $k ] == 'number' ) {
					echo '<input type="number" value="' . $v . '" placeholder="' . $pla . '" id="' . $k . '" class="click-to-update-url-lang cur' . $custom_class_css . '" />';
				}
			}
			else {
				echo '<input type="text" value="' . esc_html( $v ) . '" placeholder="' . $pla . '" id="' . $k . '" class="click-to-update-url-lang cur' . $custom_class_css . '" />';
			}
			
			echo '</td>
			</tr>';
			
			
			// phần URL trên github nếu có
			if ( isset( $eb_ex_from_github[ $k ] ) ) {
				echo '
				<tr class="small">
					<td>&nbsp;</td>
					<td class="no-border-left"><em><a href="' . $eb_ex_from_github[ $k ] . '" target="_blank" rel="nofollow">' . $eb_ex_from_github[ $k ] . '</a></em></td>
				</tr>';
			}
			
			
			// phần ghi chú
			if ( isset( $eb_note_lang[ $k ] ) ) {
				echo '
				<tr class="small">
					<td>&nbsp;</td>
					<td class="no-border-left">' . $eb_note_lang[ $k ] . '</td>
				</tr>';
			}
		}
		
	}
	
	?>
</table>
<br>
<p>* Với một số trường hợp, file mẫu bạn xem không đúng với HTML hiển thị bên ngoài, có thể do theme bạn đang sử dụng cũng có file với tên tương tự file mẫu, nên hệ thống sẽ hiển thị file từ theme thay vì file từ plugin (file mẫu).</p>
<br>
<script type="text/javascript">

//
var cache_for_current_lang_edit = '',
	cache_for_current_lang_id = '',
	auto_submit_save_lang = false;


function check_update_languages () {
//	console.log( auto_submit_save_lang );
	
	if ( cache_for_current_lang_id == '' ) {
		alert('Không xác định được KEY');
		return false;
	}
	console.log( 'Save lang: ' + cache_for_current_lang_id );
	
	// lấy nội dung cần cập nhật
	$('#languages_content_edit').val( $('#' + cache_for_current_lang_id).val() );
	
	// thay đổi trạng thái submit
	$('.eb-admin-lang-submit').val('Chờ...');
	
	auto_submit_save_lang = false;
	
	return true;
}

function done_update_languages () {
	$('.eb-admin-lang-submit').val('Xong');
}


function EBE_click_to_update_site_lang () {
	
	//
	$('.languages-textarea-height textarea').each(function() {
		var new_height = $(this).get(0).scrollHeight || 0;
		$(this).height(new_height);
	}).change(function () {
		$(this).height(10);
		var new_height = $(this).get(0).scrollHeight || 0;
		$(this).height(new_height);
	});
	
	
	
	//
	$('.click-to-update-url-lang').off('click').click(function () {
		var a = $(this).val() || $(this).html() || '',
			b = $(this).attr('id') || '',
			c = '';
//		cache_for_current_lang_edit = a;
//		console.log(b);
		
		//
		if ( b != '' ) {
			
			//
			_global_js_eb.change_url_tab( 'edit_key', b );
//			window.history.pushState( "", '', window.location.href.split('&edit_key=')[0] + '&edit_key=' + b );
			
			//
//			cache_for_current_lang_id = b;
			
			//
//			$('#languages_key_edit').val( b );
//			$('#languages_content_edit').val( a );
			
			//
			$('.eb-admin-lang-submit').show().val('Cập nhật').css({
//				left: $(this).offset().left + 'px',
				top: ( $(this).offset().top + $(this).height() - 55 ) + 'px'
			});
			
			//
//			c = prompt( 'Translate:', a );
//			console.log(c);
			
			//
			/*
			if ( c != null && c != cache_for_current_lang_edit ) {
	//			console.log('ajax update');
				ajaxl('languages_update&text=' + encodeURIComponent( c ) + '&key=' + b + '&no_echo=1', b, 1);
			}
			*/
		}
	}).off('focus').focus(function(e) {
		$(this).click();
	}).off('keyup').keyup(function(e) {
		// khi người dùng bấm enter
		if (e.keyCode == 13) {
			// kiểm tra giá trị đang có
			var a = $(this).val() || '';
			a = $.trim(a);
			
			// kiểm tra lại lần nữa cho chắc
			if ( a != '' ) {
				// nếu là input text thì submit luôn
				if ( a.split("\n").length == 1 ) {
					$(this).val( a );
					
					// tự động cập nhật giá trị mới
					if ( check_update_languages() == true ) {
						document.frm_languages.submit();
					}
					
					return false
				}
				// textarea thì xuống dòng thoải mai, submit phải bấm nút
			}
			else if ( check_update_languages() == true ) {
				document.frm_languages.submit();
				$(this).val( $(this).attr('placeholder') || '' );
				return false
			}
		}
	}).on('change', function () {
		if ( auto_submit_save_lang == false ) {
			auto_submit_save_lang = true;
			
			var b = $(this).attr('id') || '';
			
			cache_for_current_lang_id = b;
			
			$('#languages_key_edit').val( b );
		}
	}).on('blur', function () {
		if ( auto_submit_save_lang == true ) {
//			auto_submit_save_lang = false;
			
			//
//			console.log( cache_for_current_lang_id );
			
			if ( check_update_languages() == true ) {
				document.frm_languages.submit();
				
//				$('#target_eb_iframe').on('load', function () {
				setTimeout(function () {
					$('.eb-admin-lang-submit').val('Cập nhật');
				}, 600);
//				});
			}
		}
	});
	
	//
	if ( window.location.href.split('&edit_key=').length > 1 ) {
		var a = window.location.href.split('&edit_key=')[1].split('&')[0].split('#')[0];
//		console.log(a);
		
		//
		$('body,html').animate({
			scrollTop: $('#' + a).offset().top - ( $(window).height()/ 3 )
		}, 200);
		
		//
		$('#' + a + '.click-to-update-url-lang').focus();
	}
	
}

//
EBE_click_to_update_site_lang();
convert_size_to_one_format();

</script> 
