$(document).ready(function(){
	var load = false;
	var offset = $('.wrapper3:last').offset(); 
 
	$(window).scroll(function(){
 
		if((offset.top-$(window).height() <= $(window).scrollTop()) 
		&& load==false && ($('.wrapper3').size()>=5) && 
		($('.wrapper3').size()!=$('.wrapper3').text())){
 
			load = true;

			var last_id = $('.wrapper3:last').attr('id');
			
			$('#loaderstop').show();
 
			$.ajax({
				url: 'library/loader/loaderProfile.php',
				type: 'get',
				data: 'lastid='+last_id,
 
				success: function(data) {
 
					$('#loaderstop').fadeOut(500);
					$('.wrapper3:last').after(data);
					offset = $('.wrapper3:last').offset();
					load = false;
				}
			});
		}
	});
});