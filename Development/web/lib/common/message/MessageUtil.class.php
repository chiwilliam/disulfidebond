<?php
        require_once ("Message.class.php");

        /**
         * @author Yang Yang
         * @version 1.0
         * 12/01/2008
         */
        class MessageUtil{

                const DEFAULT_MSG_NAME = "SYSTEM";

                //--------------------------------------------------------------------------------------------------
                // methods for single message
                //--------------------------------------------------------------------------------------------------
                /**
                 * put message into _SESSION
                 * @param <string> $name name of the message
                 * @param <Message> $message message object
                 */
                public static function setMessage($name, $message){
                        session_start();
                        //put message object into _SESSION
                        $_SESSION[$name] = $message;
                }

                /**
                 * get message from _SESSION
                 * @param <string> $name name of the message
                 * @return <Message> message object
                 */
                public static function getMessage($name){
                        session_start();
                        //get message object from _SESSION
                        $message = $_SESSION[$name];
                        return $message;
                }

                /**
                 * get message from _SESSION and clear message object from _SESSION
                 * @param <string> $name name of the message
                 * @return <Message> message object
                 */
                public static function popMessage($name){
                        session_start();
                        //get message object from _SESSION
                        $message = $_SESSION[$name];
                        //clear _SESSION
                        unset($_SESSION[$name]);
                        return $message;
                }


                //--------------------------------------------------------------------------------------------------
                // methods for mutilple message
                //--------------------------------------------------------------------------------------------------
                /**
                 * add a message object to the messages in _SESSION
                 * @param <string> $name name of the message
                 * @param <Message> $message message object
                 */
                public static function addMessage($name, $message){
                        session_start();
                        $msgs = $_SESSION[$name."_array"];
                        if($msgs==null){
                                $msgs = array();
                        }
                        $msgs[] = $message;
                        print $message."<br>";
                        //put message object into _SESSION
                        $_SESSION[$name."_array"] = $msgs;
                        return $msgs;
                }

                /**
                 * get message objects from _SESSION
                 * @param <string> $name name of the message
                 * @return Array<Message> message objects
                 */
                public static function getMessages($name){
                        session_start();
                        //get message objects from _SESSION
                        $msgs = $_SESSION[$name."_array"];
                        if($msgs==null){
                                $msgs = array();
                        }
                        return $msgs;
                }

                /**
                 * get message objects from _SESSION
                 * @param <string> $name name of the message
                 * @return Array<Message> an array of message objects
                 */
                public static function popMessages($name){
                        session_start();
                        //get message objects from _SESSION
                        $msgs = $_SESSION[$name."_array"];
                        if($msgs==null){
                                $msgs = array();
                        }
                        //clear _SESSION
                        unset($_SESSION[$name."_array"]);
                        return $msgs;
                }

        }
?>
