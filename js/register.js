$(document).ready(function(){
	var submitEnable1 = false;
	var submitEnable2 = false;
	var userbox = $("input[name='username']");
	var passbox = $("input[name='password']");
	userbox.on("change",function(e){
		submitEnable1 = false;
		if(userbox.val() != ""){
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
	                	submitEnable1 = true;
	                }
	                else{
	                	$("#userWarning").show();
	                }
	            },
	        	error: function(xhr, textStatus, errorThrown){
	        		alert("Username lookup failed");
	        	}
	        });
		}
        $("input[type='submit']").prop("disabled", !(submitEnable1 && submitEnable2));
	});
	$("input[name='password'], input[name='rpassword']" ).on("change keyup",function(e){
		submitEnable2 = false;
		var password = passbox.val();
		var rpassword = $("input[name='rpassword']").val();
		if(rpassword == "" || password == rpassword){
			$("#passWarning").hide();
			if(password == rpassword && password != ""){
				submitEnable2 = true;
			}
		}
		else{
			$("#passWarning").show();
		}
		$("input[type='submit']").prop("disabled", !(submitEnable1 && submitEnable2));
	});
	$("form[name='registerForm']").submit(function(e){
		e.preventDefault();
		if(submitEnable1 && submitEnable2){
			   $.ajax({
	            cache: false,
	            type: "POST",
	            url: "http://localhost:8888/services/register.php",
	            data: JSON.stringify({username: userbox.val(),
	        		   password: passbox.val()}),
	            contentType: "application/json; charset=utf-8",
	            success: function (resp) {
	            	flag = $.parseJSON(resp);
	                if(flag){
	                	$("#registerModal").fadeIn(700);
	                	setTimeout(function(){
	                		window.location.replace("login.php");
	                	},2500);
	                }
	                else{
	                	alert("Register failed.")
	                }
	            },
	        	error: function(xhr, textStatus, errorThrown){
	        		alert("Register failed.");
	        	}
	        });
	    }	
	});
});