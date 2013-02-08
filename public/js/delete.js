$(function() {
	$(".delete_button").click(function() {
		var id = $(this).attr("id");
		var dataString = 'id='+ id ;
		var parent = $(this).parent();
		 
		$.ajax({
			type: "POST",
			url: "library/delete/delete.php",
			data: dataString,
			cache: false,
			beforeSend: function()
			{
				parent.animate({'backgroundColor':'#fb6c6c'},300).animate({ opacity: 0.35 }, "slow");
			},
			success: function()
			{
				parent.slideUp('slow', function() {$(this).remove();});
			}
		});
		 
		return false;
	});
});