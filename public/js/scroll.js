$(document).ready(function(){
	var load = false;
	var offset = $('.wrapper8:last').offset(); 
	
	$(window).scroll(function(){
 
		if((offset.top-$(window).height() <= $(window).scrollTop()) 
		&& load==false && ($('.wrapper8').size()>=5) && 
		($('.wrapper8').size()!=$('.wrapper8').text())){

			load = true;
 
			var last_id = $('.wrapper8:last').attr('id');
 
			$('#loader').show();
 
			$.ajax({
				url: 'library/loader/loader.php',
				type: 'get',
				data: 'lastid='+last_id,
 
				success: function(data) {
 
					$('#loader').fadeOut(500);
					$('.wrapper8:last').after(data);
					offset = $('.wrapper8:last').offset();
					load = false;
				}
			});
		}
	});
});