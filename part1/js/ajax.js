$(document).ready(function() {
    $(".display").click(function() {
        var id = $(this).attr('data-id');
        $.ajax({
            type: "POST",
            url: "displayAjax.php",
            data:{
                display_row:'display_row',
                row_id:id
               },
            success: function(response)
            {
                $("#table").append(response);
            }
        });
   
        
    });
    /* Find and remove selected table rows */
    $(".reset").click(function() {
        $("table tbody").find('input[name="record"]').each(function() {
            if ($(this).is(":checked")) {
                $(this).parents("tr").remove();
            }
        });
    });
});

// $(document).ready( function(){

// 	$("#wallForm").submit( function(event){
// 		$.post("ajax.php", $(this).serialize(), 
// 			onNewPost);
// 		event.preventDefault();	 
// 	});

// 	var onNewPost = function(response){
// 		$("#div1").html("");
// 		$("#div1").html(response);
// 		$('input[name="postContent"]').val("");
// 		$('input[name="posterName"]').val("");
// 	};

// 	$.get("ajax.php", onNewPost);


// })
