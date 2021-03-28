<?php
    class LoginUserDTO{
        private $id;
        private $pw;

        function __construct($id, $pw){
            $this->id = $id;
            $this->pw = $pw;
        }

        public function setterID($id) {
            $this->id = $id;
        }
        public function setterPW($pw) {
            $this->pw = $pw;
        }

        public function getterID(){
            return $this->id;
        }
        public function getterPW(){
            return $this->pw;
        }
    }
?>