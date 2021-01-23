<?php
	
	header('Content-Type: text/html; charset=utf-8');
	
	include("include/sql/config.php");
	
	$uri = $_SERVER["REQUEST_URI"]; //도메인 단을 제외한 uri 단을 구합니다.
	
	 if (strpos($uri,"/shorten.php") === 0)
	 {
			include("shorten.php");
			exit;
	 }
	 
	if ($uri != "/")
	{	//uri 단에 문자열이 존재하면
		$hash = substr($uri,1);  //슬래시를 제외한 해시코드 추출
		$conn = mysqli_connect($config["host"], $config["username"], $config["password"], $config["database"]);  //DB 연결
		$query = "SELECT * FROM ".$config["table"]." WHERE hash = '$hash';";  //해당 해시에 대한 데이터 받아오기
		$result = mysqli_query($conn, $query);
		if ($result)
		{	//쿼리가 성공적으로 전송 되었으면
			$row = mysqli_fetch_array($result);
			if ($row != null)
			{ //해시코드에 대한 데이터가 등록 되어 있으면
				$url = $row["url"]; //url 가져오기
				
				//미리보기 가능한 메타데이터 설정
				echo "
					<meta property='og:title' content='SOLT.PW | 단축된 URL입니다.' />
					<meta property='og:description' content='$url' />
				";
				
				echo "
					<script>
						var url = '$url';
						if (url.indexOf('http://') != 0 && url.indexOf('https://') != 0)
						{
							url = 'http://' + url;
						}
						location.href = url;
					</script>
				";  //해당하는 url으로 리다이렉션
			}
			else 
			{ //데이터가 등록 되어 있지 않으면
				echo "
					 URL을 찾을 수 없습니다.
				";
			}
		}
		else
		{ //전송에 실패했으면
			echo "
				쿼리 전송에 실패했습니다.
			";
		}
		mysqli_close($conn);
	}
	else
	{	//uri 단에 문자열이 존재하지 않으면
		//인덱스 페이지 표시
		include("include/home/index.html");
	}

?>