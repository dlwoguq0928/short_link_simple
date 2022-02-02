<?php
	
	//timezone을 한국표준시로 설정
	date_default_timezone_set('Asia/Seoul');
	
	//경고 문구 없애기
	//error_reporting(E_ALL^ E_WARNING); 
	
	
	//호스팅어서버
	$config = array(
		'host' => 'localhost',
		'database' => 'u296007167_physia',
		'username' => 'u296007167_physia',
		'password' => 'physics2020A',
		'table' => array(
			'subscriber_emails' => 'physia_subscriber_emails',
		),
	);
	
?>