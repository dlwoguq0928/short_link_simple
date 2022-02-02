<?php

	include("sql/config.php");
	
	
    $q_insert = "INSERT INTO ".$config["table"]["subscriber_emails"]." (email) VALUES ('".$_POST["email"]."') ;";
    $q_delete = "DELETE FROM ".$config["table"]["subscriber_emails"]." WHERE email = '".$_POST["email"]."' ;";
	
	
	$conn = mysqli_connect($config["host"], $config["username"], $config["password"], $config["database"]);
	$query = "SELECT * FROM ".$config["table"]["subscriber_emails"]." WHERE email = '".$_POST["email"]."' ;";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($result);
	if (count($row) == 0) 
	{
		$query = $q_insert;
		mysqli_query($conn, $query);
		echo '
			<script>
				alert("이제부터 메일을 수신합니다.");
				history.back();
			</script>
		';
	}
	else 
	{
		$query = $q_delete;
		mysqli_query($conn, $query);
		echo '
			<script>
				alert("이제부터 메일을 수신하지 않습니다.");
				history.back();
			</script>
		';
	}
	mysqli_close($conn);
	

?>