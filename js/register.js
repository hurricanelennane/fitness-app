$(document).ready(function(){
	$("input[name='username']").on("change",function(e){
	    $.ajax({
            cache: false,
            type: "GET",
            url: "http://localhost:8888/services/register.php",
            data: {tentName: $(this).val()},
            contentType: "application/json; charset=utf-8",
            success: function (resp) {
            	flag = $.parseJSON(resp);
                if(flag){
                	$("#userWarning").hide();
                }
                else{
                	$("#userWarning").show();
                }
            },
        	error: function(xhr, textStatus, errorThrown){
        		alert("Weird error");
        	}
        });	
	});
});