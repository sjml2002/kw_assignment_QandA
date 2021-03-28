<?php
    class LoginSQL {
        private $id;
        private $pw;
        private function checkObject() {
            //else if로 이메일과 pw 정규식으로 양식 확인
            if(empty($this->id) || empty($this->pw)) {
                return false;
            }
            else{
                return true;
            }
        }
        /////////// Private ////////////////

        /////////// Public /////////////////
        function __construct($LoginUserDTO){
            $this->id = $LoginUserDTO->getterID();
            $this->pw = $LoginUserDTO->getterPW();
        }

        public function Querylogin(){
            if($this->checkObject()) {
                try{
                    //DB 연동해서 email과 pw 맞는지 확인작업, 성공시 로그인 완료
                    require_once("../model/DBconnect.php");
                    $searchUser = $db_conn->prepare("select * from user_info where id = ?");
                    $searchUser->bind_param("s", $this->id);
                    $result = $searchUser->execute();
                    if($result) {
                        $result = $searchUser->get_result();
                        if($data_row = $result->fetch_array(MYSQLI_ASSOC)) {
                            $check_salt = $data_row['salt'];
                            if(password_verify($check_salt . $this->pw, $data_row['pw'])) {
                                //비밀번호 일치 (로그인 성공)
                                //세션 생성 후 DB에 넣기
                                $sessionValue = bin2hex(openssl_random_pseudo_bytes(16, $cstrong));
                                $updateToken = $db_conn->prepare("update user_info set sessionToken = ? where id= ? ;");
                                $updateToken->bind_param("ss", $sessionValue, $this->id);
                                if($updateToken->execute()) {
                                    //토큰 생성까지 성공
                                    return $sessionValue;
                                }
                                else{
                                    //서버 오류로 인한 토큰 생성 실패
                                    throw new exception("500");
                                }
                            }
                            else{
                                //비밀번호 불일치
                                return false;
                            }
                        }
                    }
                    return false;
                } catch (exception $e){
                    return false;
                }
            }
            else{
                return false;
            }
        }
    }
?>