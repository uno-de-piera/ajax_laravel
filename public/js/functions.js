$(document).ready(function() {
	//petición al enviar el formulario de registro
	var form = $('.register_ajax');
	    form.bind("submit",function () {
	        $.ajax({
	            type: form.attr('method'),
	            url: form.attr('action'),
	            data: form.serialize(),
	            beforeSend: function(){
	            	$(".before").append("<img src='imgs/350.gif' />");
	            },
	            complete: function(data){
	            	
	            },
	            success: function (data) {
	            	$(".before").hide();
					$(".errors_form").html("");
					$(".success_message").hide().html("");
	            	if(data.success == false){
		            	var errores = "";
		            	for(datos in data.errors){
		            		errores += "<small class='error'>" + data.errors[datos] + "</small>";
		            	}
		            	$(".errors_form").html(errores)
		            }else{
		            	$(form)[0].reset();//limpiamos el formulario
		            	$(".success_message").show().html(data.message)
		            }
	            },
	            error: function(errors){
	            	$(".before").hide();
					$(".errors_form").html("");
	            	$(".errors_form").html(errors);
	            }
	        });
	   return false;
	});
	
	//al pulsar el botón de ver usuarios mostramos la información con ajax
	$(".show_users").bind("click", function(e){
		e.preventDefault();
		$.ajax({
			type: "GET",
			url: "content_ajax",
	        beforeSend: function(){
	            $(".preload_users").html("<img src='imgs/350.gif' />");
	        },
			success: function (data) {
				$(".preload_users").html("");
				$(".load_ajax").html(usuarios)
				var usuarios = "";		
			    for(datos in data.users){
			    	usuarios += "<div class='panel callout radius'>";
			        usuarios += "<p>Nombre: " + data.users[datos].username + "</p>";
			        usuarios += "<p>Email: " + data.users[datos].email + "</p>";
			        usuarios += "<p>Password: " + data.users[datos].password + "</p>";
			        usuarios += "</div>";
			    }
			    $(".load_ajax").html(usuarios)
			}
		})
	});
});