<?php
    
    require_once ("../User/UserManager.class.php");
    require_once ("../orgcontrol/Orgcontrol.class.php");
    require_once ("../orgcontrol/OrgcontrolManager.class.php");

    class usermanagement {

        protected $usrmgr;
        
        public function userexists($user){

            $query = "Select userid, firstname, lastname, username, email, pwd, usertype
              from USER where username = '".$user->getUsername()."'";
            $usrmgr = new UserManager();
            
            if(count($usrmgr->getUsersBySQL($user, $query)) > 0){
                return true;
            }
            else{
                return false;
            }
        }

        public function retrieveuser($user,$mode){

            if ($mode == 'login'){
                $query = "Select userid, firstname, lastname, username, email, pwd, usertype
                  from USER where username = '".$user->getUsername()."' and pwd = '".$user->getPwd()."'";
            }
            else{
                $query = "Select userid, firstname, lastname, username, email, pwd, usertype
                  from USER where username = '".$user->getUsername()."' and email = '".$user->getEmail()."'";
            }

            $usrmgr = new UserManager();
            $users = $usrmgr->getUsersBySQL($user, $query);
            if(count($users) > 0){
                $user->setUserid($users[0]->getUserid());
                $user->setFirstname($users[0]->getFirstname());
                $user->setLastname($users[0]->getLastname());
                $user->setUsername($users[0]->getUsername());
                $user->setEmail($users[0]->getEmail());
                $user->setPwd($users[0]->getPwd());
                $user->setUsertype($users[0]->getUsertype());
                
                return true;
            }
            else{
                return false;
            }
        }

        public function createuser($user,$orgcontrol){

            $usrmgr = new UserManager();
            $user = $usrmgr->addUser($user);

            if ($user->getUsertype() == "Student"){
                $orgcontrol->setUserid($user->getUserid());
                $orgcontrolmgr = new OrgcontrolManager();
                $orgcontrol = $orgcontrolmgr->addOrgcontrol($orgcontrol);
            }
            return true;
        }

        public function setsessionwithuserinfo($user){
            session_start();
            session_destroy();
            session_start();

            $_SESSION['loggedin'] = true;
            $_SESSION['message'] = '';
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['firstname'] = $user->getFirstname();
            $_SESSION['lastname'] = $user->getLastname();
            $_SESSION['usertype'] = $user->getUsertype();
            $_SESSION['userid']= $user->getUserid();
            $_SESSION['javanetrealname'] = $user->getJavanetrealname();

            session_commit();
        }

    }

?>
