<?php
        require_once ("DAO.class.php");
        /**
         * @author Yang Yang
         * @version 1.0
         * 11/30/2008
         */
        class SearchDAO extends DAO{
                public function SearchDAO(){
                        $this->enableScrollPage();
                }
        }

?>
