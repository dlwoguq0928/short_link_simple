<?php
	
	function make_unique_hash($str)
	{
		include('sql/config.php');
		$hash = substr(base64_encode(sha1($str)),0,7);  //base64로 인코딩 된 7글자 해시 생성
		$conn = mysqli_connect($config["host"], $config["username"], $config["password"], $config["database"]);  //DB 연결
		$query = "SELECT * FROM ".$config["table"]." WHERE hash = '$hash';";  //쿼리 : 해당 해시가 이미 할당 된 적 있는지 받아오기
		$result = mysqli_query($conn, $query);
		if ($result)
		{	//쿼리가 성공적으로 전송 되었으면
			$row = mysqli_fetch_array($result);
			if ($row !== null)
			{ //해당 해시가 중복된다면
				return make_unique_hash($hash);  //재귀 호출
			}
			else
			{ //중복되지 않는다면
				return $hash;  //그대로 반환
			}
		}
		mysqli_close($conn);
	}
	
	$url = urldecode($_GET['url']);  //url 가져오기
	
	include('sql/config.php');
	$conn = mysqli_connect($config["host"], $config["username"], $config["password"], $config["database"]);  //DB 연결
	$query = "SELECT * FROM ".$config["table"]." WHERE url = '$url';";  //쿼리 : 해당 URL에 대한 데이터가 있는지 받아오기
	$result = mysqli_query($conn, $query);
	if ($result)
	{	//쿼리가 성공적으로 전송 되었으면
		$row = mysqli_fetch_array($result);
		if ($row !== null)
		{ //해당 URL에 대한 데이터가 이미 등록되어 있다면
			echo 'https://'.$_SERVER['HTTP_HOST']."/".$row['hash'];  //이미 만들어진 단축 URL 반환
			exit;
		}
		else
		{ //기존에 등록된 데이터가 없다면
			$timestamp = time();  //타임스탬프 기록
			$hash = make_unique_hash($url);  //새로운 해시 생성
			$query = "INSERT INTO ".$config["table"]." (timestamp, hash, url) VALUES ('$timestamp', '$hash', '$url')";  //쿼리 : 새로운 단축 링크 데이터 등록하기
			$result = mysqli_query($conn, $query);
			if ($result)
			{  //쿼리가 성공적으로 전송 되었으면
				$short_url = 'https://'.$_SERVER['HTTP_HOST']."/".$hash;  //단축 URL 구성
				echo $short_url;  //새로 만들어진 단축 URL 반환
				exit;
			}
		}
	}
	
	echo "Error.";  //이도 저도 아니면 에러 반환
	
	mysqli_close($conn);

?>