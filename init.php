<?php

	include('include/sql/config.php');
	
	$conn = mysqli_connect($config['host'], $config['username'], $config['password'], $config['database']);
	//!-- 데이터 테이블 생성
	$query[] = "DROP TABLE ".$config['table']."; ";
	$query[] = "CREATE TABLE ".$config['table']." (
		idx int(16) AUTO_INCREMENT PRIMARY KEY,
		timestamp varchar(64),
		hash varchar(64),
		url varchar(512),
	);";
	$query[] = "TRUNCATE TABLE ".$config['table']."; ";
	for($i=0;$i<count($query);$i++)
	{
		mysqli_query($conn, $query[$i]);
	}
	mysqli_close($conn);

?>