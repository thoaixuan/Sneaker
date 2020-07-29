<script defer>
function changeClass(buttonClass , formClass ,dataClass, idHoTen, idSdt){
	var submit = jQuery(buttonClass);
   submit.click(function(){
	    var hoTen = jQuery('#hoTen').val();
        var sdt = jQuery('#sdtC').val();
        var diachi = jQuery('#diaChi').val();
		var remove_space = jQuery.trim(sdt.replace(/ /g,''));
        var vnf_regex = /((09|03|07|08|05)+([0-9]{8})\b)/g;
		if(hoTen == "" || sdt == ""){
			if(hoTen == ""){ hoTen.text("Vui lòng cho biết tên"); hoTen.click(function(){hoten.text();}); }
            if(sdt !== ""){
                if (vnf_regex.test(remove_space) == false){alert('Số điện thoại không đúng định dạng!');}
					else{alert('Số điện thoại không hợp lệ!');}
                }else{alert('Bạn chưa nhập số điện thoại');}
            
            return false;
		}
		if(hoTen !== "" || sdt !== ""){
			if (vnf_regex.test(remove_space) == false){alert('Số điện thoại không đúng định dạng');}
			else{
				var data = jQuery(dataClass).serialize();
				jQuery.ajax({
				type : 'GET',
				url : 'https://script.google.com/macros/s/AKfycbylnIFoPeClwtbaGtmvEJyEs9vCEq0EKBVSVP1C1AcwJ087Nt4/exec',
				dataType:'json',
				crossDomain : true,
				data : data,
				success : function(data){
					if(data == 'false')
					{
						alert('Có lỗi xảy ra!! Vui lòng thử lại');
					}else{
						window.location.replace("https://ing.vn/cam-on-ban/");
					}
				}
				});
			return false;
            }
		return false;
		}
		else{
			var data = jQuery(dataClass).serialize();
			jQuery.ajax({
			type : 'GET',
			url : 'https://script.google.com/macros/s/AKfycbylnIFoPeClwtbaGtmvEJyEs9vCEq0EKBVSVP1C1AcwJ087Nt4/exec',
			dataType:'json',
			crossDomain : true,
			data : data,
			success : function(data){
				if(data == 'false')
				{
					alert('Có lỗi xảy ra!! Vui lòng thử lại');
				}else{
					window.location.replace("https://ing.vn/cam-on-ban/");
				}
			}
			});
			return false;
		}
   });
}
jQuery(document).ready(function(){
	changeClass("#btnCheckout","form-checkout","#form-checkout","#hoTen","#sdtC");
});
</script>