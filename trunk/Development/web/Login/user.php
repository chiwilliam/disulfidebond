<?php

    class User {

        protected $firstname, $lastname, $email, $username, $password, $group, $usertype;

        public function User($ifirstname, $ilastname, $iemail, $iusername, $ipassword, $igroup, $iusertype){

            $this->firstname = $ifirstname;
            $this->lastname = $ilastname;
            $this->email = $iemail;
            $this->username = $iusername;
            $this->password = $ipassword;
            $this->group = $igroup;
            $this->usertype = $iusertype;

        }

        public function getfirstname(){
            return $this->firstname;
        }
        public function getlastname(){
            return $this->lastname;
        }
        public function getusername(){
            return $this->username;
        }
        public function getemail(){
            return $this->email;
        }
        public function getpassword(){
            return $this->password;
        }
        public function getgroup(){
            return $this->group;
        }
        public function getusertype(){
            return $this->usertype;
        }

        public function setfirstname($ifirstname){
            $this->firstname = $ifirstname;
        }
        public function setlastname($ilastname){
            $this->lastname = $ilastname;
        }
        public function setusername($iusername){
            $this->username = $iusername;
        }
        public function setemail($iemail){
            $this->email = $iemail;
        }
        public function setpassword($ipassword){
            $this->password = $ipassword;
        }
        public function setgroup($igroup){
            $this->group = $igroup;
        }
        public function setusertype($iusertype){
            $this->usertype = $iusertype;
        }

    }
?>
