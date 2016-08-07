<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Tentando invadir</title>
		<script  src="http://tcc.local/framework/libs/jquery.min.js"></script>
	</head>

	<body>
		<p><a href="#" class="tryHack" >Invadir</a></p>
		<div class="result"></div>

		<script>
		$(function()
		{

			$("a.tryHack").click(function()
			{
				$.ajax(
			    {
			        type: "POST",
			        url: "http://tcc.local/framework/login",
			        data: 
			        {
			        	//token correto, entao vai ter acesso, para bloquear acesso só trocar o token
			        	username: "leonaaardo",
			        	password: "12345678",
						token: "app2"
			        },
			        success: function(result)
			        {
						$("div.result").html(result);
			            if(result == "ok")
			            {
			            	alert("Login efetuado!");
			            }	
			            else
			            {
			            	$("div.result").html("Falha:" + result);
			            }
			        }
			    });
			});
		});
		</script>
	</body>

</html>
