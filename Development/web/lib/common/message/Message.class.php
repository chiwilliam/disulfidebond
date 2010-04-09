<?php
        /**
         * @author Yang Yang
         * @version 1.0
         * 12/01/2008
         */
        class Message {

                const DEBUG = "DEBUG";
                const INFO = "INFO";
                const WARN = "WARN";
                const ERROR = "ERROR";

                //message type e.g. Message::DEBUG | Message::INFO | Message::WARN | Message::ERROR
                private $type;
                //content of the message
                private $content;

                /**
                 * constructor of the Message cla
                 * @param <type> $type
                 * @param <type> $content
                 */
                public function Message($type, $content){
                        $this->type = $type;
                        $this->content = $content;
                }

                /**
                 * get type of the message
                 * @return <string> Message::DEBUG | Message::INFO | Message::WARN | Message::ERROR
                 */
                public function getType(){
                        return $this->type;
                }

                /**
                 *get content of the message
                 * @return <string>
                 */
                public function getContent(){
                        return $this->content;
                }

                public function getImage(){
                        $img = "MessageInfo.gif";
                        if($this->type==Message::DEBUG){
                                $img = "MessageInfo.gif";
                        } else if ($this->type==Message::INFO){
                                $img = "MessageInfo.gif";
                        } else if ($this->type==Message::WARN){
                                $img = "MessageWarn.gif";
                        } else if ($this->type==Message::ERROR){
                                $img = "MessageError.gif";
                        }
                        return $img;
                }

                public function getColor(){
                        $color = "#00CC00";
                        if($this->type==Message::DEBUG){
                                $color = "#000000";
                        } else if ($this->type==Message::INFO){
                                $color = "#00CC00";
                        } else if ($this->type==Message::WARN){
                                $color = "#FF6600";
                        } else if ($this->type==Message::ERROR){
                                $color = "#FF0000";
                        }
                        return $color;
                }

                public function __toString(){
                        return $this->type.": ".$this->content;                        
                }

        }

?>
