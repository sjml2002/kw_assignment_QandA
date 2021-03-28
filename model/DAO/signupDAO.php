<?php
    class SignupSQL {
        private $id;
        private $pw;
        private $salt;

        function __construct($SignUserDTO){
            $this->id = $SignUserDTO->getterID();
            $this->pw = $SignUserDTO->getterPW();
            $this->salt = $SignUserDTO->getterSalt();
        }

        function QuerySignup(){
            try{
                require_once("../model/DBconnect.php");
                //DB연동 후 id 똑같은거 있는지 검사 후 없으면 로그인 성공
                $signUserInsert = $db_conn->prepare("insert into user_info(id, pw, salt) values(?, ?, ?);");
                $signUserInsert->bind_param("sss", $this->id, $this->pw, $this->salt);
                $result = $signUserInsert->execute();
                return $result;
            } catch (exception $e){
                return false;
            }
        }

        public function checkObject() {
            //else if로 이메일과 pw 정규식으로 양식 확인
            if(empty($this->id) || empty($this->pw)) {
                return false;
            }
            else{
                $idReg = "/^[a-z0-9]{6,20}$/";
                $pwReg = "/^[a-z0-9!@#$*]{8,20}$/";
                if(preg_match($idReg, $this->id) || preg_match($pwReg, $this->pw)){
                    return true;
                }
                else{
                    return false;
                }
                
            }
        }
    }
?>