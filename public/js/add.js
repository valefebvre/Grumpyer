$(function(){
	$("#form-grump").submit(function(){
		$.post("library/add/add.php");
	});
});