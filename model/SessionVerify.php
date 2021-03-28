<?php
    session_start();

    function sessionIsseting() {
        if(!isset($_SESSION['id']) || !isset($_SESSION['token'])) {
            return false;
        }
        else{
            return true;
        }
    }
    function sessionVerify() {
        if(sessionIsseting()) {
            require_once("../model/DBconnect.php");
            $searchToken = $db_conn->prepare("select sessionToken from user_info where id = ?");
            $searchToken->bind_param("s", $_SESSION['id']);
            if($searchToken->execute()) {
                $result = $searchToken->get_result();
                if($data_row = $result->fetch_array(MYSQLI_ASSOC)) {
                    if($data_row['sessionToken'] === $_SESSION['token']){
                        //DB의 토큰과 세션['token']의 값이 일치함. true 반환
                        return $_SESSION['id'];
                    }
                    else{
                        return false;
                    }
                }
            }
        }
        else{
            return false;
        }
        return false;
    }
    