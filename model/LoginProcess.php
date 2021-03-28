<?php
    //root function
    function loginProcess($id, $pw) { 
        session_start();
        $sessionValue = loginDBquery($id, $pw);
        if(!$sessionValue){ //로그인 실패
            return false;
        }
        else{
            //return값으로 sessionValue를 받음
            //로그인 세션 생성
            $_SESSION['token'] = $sessionValue;
            $_SESSION['id'] = $id;
            //controller에 로그인 성공을 알림
            return true;
        }
    }

    function userDTO($email, $pw) {
        require_once("../model/DTO/loginDTO.php");
        $loginUser = new LoginUserDTO($email, $pw);
        return $loginUser;
    }

    function loginDBquery($email, $pw){
        require_once("../model/DAO/loginDAO.php");
        $loginUser = userDTO($email, $pw); //DTO
        $loginSQLobject = new LoginSQL($loginUser);
        $returnValue = $loginSQLobject->QueryLogin();
        if(!$returnValue){ //로그인 성공
            return false;
        }
        else{
            return $returnValue;
        }
    }
?>