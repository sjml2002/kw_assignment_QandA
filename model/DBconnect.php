<?php
    $db_conn = new mysqli("localhost", "root", "sjml0724@@", "kw_assignment_QandA");
	if($db_conn->connect_error){
		die("데이베이스에 오류가 생겼습니다.");
	}

	$db_conn->set_charset('uft8mb4');

	//mysql 인코딩
	mysqli_query($db_conn, "set session character_set_connection=utf8mb4;");
	mysqli_query($db_conn, "set session character_set_results=utf8mb4;");
	mysqli_query($db_conn, "set session character_set_client=utf8mb4;");
?>