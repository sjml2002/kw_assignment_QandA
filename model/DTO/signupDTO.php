<?php
    class SignupUserDTO{
        private $id;
        private $pw;
        private $salt;

        function __construct($id, $pw){
            $this->setterID($id);
            $this->setterSalt();
            $this->setterPW($pw);
        }

        public function setterID($id) {
            $this->id = $id;
        }
        public function setterPW($pw) {
            $this->pw = password_hash($this->salt . $pw , PASSWORD_BCRYPT);
        }
        public function setterSalt() {
            //opensslhex 해시함수 사용해서 할당
            $pw_salt = openssl_random_pseudo_bytes(32, $cstrong);
			$this->salt = bin2hex($pw_salt);
        }

        public function getterID(){
            return $this->id;
        }
        public function getterPW(){
            return $this->pw;
        }
        public function getterSalt() {
            return $this->salt;
        }
    }
?>