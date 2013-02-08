$(function(){  
	setInterval(function(){  
		$(".slideshow ul").animate({marginLeft:-160},1500,function(){  
			$(this).css({marginLeft:0}).find("li:last").after($(this).find("li:first"));  
         })  
    }, 0);  
});