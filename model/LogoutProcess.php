<?php
    session_start();
    
    function logoutProcess() {
        require_once("../model/DBconnect.php");
        $deleteToken = $db_conn->prepare("update user_info set sessionToken='' where id = ?");
        $deleteToken->bind_param("s", $_SESSION['id']);
        if($deleteToken->execute()) {
            if(session_destroy()) {
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }