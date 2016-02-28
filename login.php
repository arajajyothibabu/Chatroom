<?php 
	require_once 'includes/connection.php';
	$query = mysql_query("select * from users where user='{$_GET['user']}' and pass='{$_GET['pass']}'")or die(mysql_error());
	if(mysql_num_rows($query) == 1)
	{
		session_start();
		$_SESSION['user'] = $_GET['user'];
		$chatQuery = mysql_query("select * from chat");
		while ($chat = mysql_fetch_array($chatQuery)){
			echo "<p><span class='userid'>".$chat[1]."</span>".$chat[2]."</p>";
			}
		}
	else
	{
		echo "invalid";
		}
		
?>