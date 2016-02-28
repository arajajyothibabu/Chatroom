<?php 
	require_once 'includes/connection.php';
	require_once 'includes/session.php';
	if($_GET['user'] == $_SESSION['user'])
	{
		$query = mysql_query("INSERT into chat values('','{$_GET['user']}','{$_GET['msg']}')") or die(mysql_error());
		$chatQuery = mysql_query("select * from chat");
		while ($chat = mysql_fetch_array($chatQuery)){
			echo "<p><span class='userid'>".$chat[1]."</span>".$chat[2]."</p>";
			}
		}
	else
	{
		echo "login";
		}
		
?>