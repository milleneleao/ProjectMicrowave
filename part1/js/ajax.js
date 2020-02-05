$(document).ready( function(){

	$("#wallForm").submit( function(event){
		$.post("ajax.php", $(this).serialize(), 
			onNewPost);
		event.preventDefault();	 
	});

	var onNewPost = function(response){
		$("#div1").html("");
		$("#div1").html(response);
		$('input[name="postContent"]').val("");
		$('input[name="posterName"]').val("");
	};

	$.get("ajax.php", onNewPost);


});
