<?php 
	require_once 'includes/session.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Chat Room</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="css/custom.css" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript">
	function verifyLogin(){
		var username = loginForm.username.value;
		var password = loginForm.password.value;
		var loginloader = document.getElementById("loginloader");
		var logintext = document.getElementById("logintext");
		if(username.length < 6 || password.length < 6)
		{
			document.getElementById("loginalert").innerHTML = "Username or password is invalid";
			return;
		}
		else
		{	
			logintext.style.display = 'none';
			loginloader.style.display = 'block';
			}
		var http = new XMLHttpRequest();
		http.onreadystatechange = function(){
			if(http.readyState == 4 && http.status == 200)
			{
				if(http.responseText == "invalid")
				{
					document.getElementById("loginalert").innerHTML = "Username or password are incorrect";
					loginloader.style.display = 'none';
					logintext.style.display = 'block';
					}
				else
				{
					$("#login").hide(200);
					$("#chat").show(200);
					$("#logout").show(200);
					document.getElementById("user").innerHTML = username;
					document.getElementById("chatwindow").innerHTML = http.responseText;
					placeWindow();
					}
				}
		}
		http.open("GET","login.php?user="+ username + "&pass="+ password,true);
		http.send();
	}
	function refreshChat(){
		var username = document.getElementById('user').innerHTML;
		var msg = document.inputchat.msg.value;
		var http = new XMLHttpRequest();
		http.onreadystatechange = function(){
			if(http.readyState == 4 && http.status == 200)
			{
				if(http.responseText == "login")
				{
					$("#chat").hide(200);
					$("#login").show(200);
					}
				else
					{
						document.getElementById("chatwindow").innerHTML = http.responseText;
						placeWindow();
					}
				}
		}	
		http.open("GET","refresh.php?user="+ username + "&msg="+ msg,true);
		http.send();
	}
	function logout() {
		var http = new XMLHttpRequest();
		http.onreadystatechange = function(){
			if(http.readyState == 4 && http.status == 200)
			{
				if(http.responseText == "logout"){
					$("#login").show(200);
					$("#logout").hide(200);
					document.getElementById("user").innerHTML = "";
					$("#chat").hide(200);
				}
			}
		}
		http.open("POST","logout.php",true);
		http.send();
    }
	
	function placeWindow(){
		var height = 0;
		$('div.chatwindow p').each(function(i, value){
			height += parseInt($(this).height());
		});
		
		height += '';
		$('div.chatwindow').animate({scrollTop: height});
	}

</script>
</head>

<body>
<div class="page-header">
	<h3 align="center">Chat Room-303<span class="user" id="user"><?php if(isset($_SESSION['user'])) echo $_SESSION['user']; ?></span><?php if(isset($_SESSION['user'])) echo '<i onClick="logout()" class="logout fa fa-power-off" title="Logout" id="logout"></i>' ?></h3>
</div>
<div class="container">
	<div class="row" id="login" style="display:<?php if(isset($_SESSION['user'])) echo 'none'; else echo 'block'?>" >
    	<div class="col-md-8">
        	<img class="img-responsive" src="img/main.jpg">
        </div>
        <div class="col-md-4">
            <form role="form" id="loginForm" method="get" action="">
                	<p class="btn-danger" id="loginalert"></p>
                    <div class="form-group">
                    	<input type="text" class="form-control" placeholder="Username" name="username" value="" />
                    </div>
                    <div class="form-group">
                    	<input type="password" class="form-control" placeholder="Password" name="password" value="" />
                    </div>
                    <div class="form-group">
                    	<a class="btn btn-success form-control" onClick="verifyLogin();" id="loginsubmit"><span id="logintext">Login</span><i style="display:none; margin:auto; " id="loginloader" class="fa fa-cog fa-spin fa-2x"></i></a>
                    </div>
            </form>
        </div>
    </div>
    <div class="row" id="chat" class="chat" style="display:<?php if(isset($_SESSION['user'])) echo 'block'; else echo 'none'?>">
    	<div class="col-md-4">
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12 chatwindow" id="chatwindow">
                </div>
             </div>
             <div class="row">
                <div class="col-md-12 form-group inputwindow">
                    <form name="inputchat"><textarea required class="msg form-control" rows=2 name="msg"></textarea></form><span onClick="refreshChat()" onkeyUp="refreshChat()" class="btn btn-success send">Send</span>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
</body>
</html>