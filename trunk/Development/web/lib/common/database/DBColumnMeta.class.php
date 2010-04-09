<?php
        /**
         * @author Yang Yang
         * @version 1.0
         * 11/20/2008
         */
        class DBColumnMeta{

                private $name;
                private $isPrimaryKey;
                private $isNumeric;
                private $type;
                private $isblob;

                public function __construct(){}

                public function setName($name){
                        $this->name = $name;
                }
                public function getName(){
                        return $this->name;
                }

                public function setPrimaryKey($isPrimaryKey){
                        $this->isPrimaryKey = $isPrimaryKey;
                }
                public function isPrimaryKey(){
                        return $this->isPrimaryKey;
                }

                public function setNumeric($isNumeric){
                        $this->isNumeric = $isNumeric;
                }
                public function isNumeric(){
                        return $this->isNumeric;
                }

                public function setType($type){
                        $this->type = $type;
                }
                public function getType(){
                        return $this->type;
                }

                public function setBlob($isblob){
                        $this->isblob = $isblob;
                }
                public function isBlob(){
                        return $this->isblob;
                }

                public function __toString(){
                        return "name=".$this->name.", isPrimaryKey=".$this->isPrimaryKey.", isNumeric=".$this->isNumeric.", type=".$this->type.", isblob=".$this->isblob;
                }
        }
?>
