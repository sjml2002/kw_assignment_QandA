<?php
    //root function
    function signupProcess($id, $pw) { 
        return userDTO($id, $pw); //true면 회원가입 성공
    }

    function userDTO($id, $pw) {
        require_once("../model/DTO/signupDTO.php");
        $signUser = new SignupUserDTO($id, $pw);
        return signupDBinsert($signUser);
    }

    function signupDBinsert($signUser){ //login->signup 변경
        require_once("../model/DAO/signupDAO.php");
        $signupSQLobject = new SignupSQL($signUser);
        if($signupSQLobject->checkObject()){
            return $signupSQLobject->QuerySignup();
        }
        else{
            return false;
        }
    }
?>