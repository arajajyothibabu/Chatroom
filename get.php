<?php 
	require_once 'includes/connection.php';
	require_once 'includes/session.php';
	if($_GET['user'] == $_SESSION['user'])
	{
		$chatQuery = mysql_query("select * from chat");
		while ($chat = mysql_fetch_array($chatQuery)){
			echo "<p><span class='user'>".$chat[1]."</span>".$chat[2]."</p>";
			}
		}
	else
	{
		echo "login";
		}
		
?>