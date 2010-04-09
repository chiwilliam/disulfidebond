<?php

       /**
        * Date
        * @author YANG YANG
        * @version 1.0
        * 12/17/2008
        */
        class DateUtil {

                public static function getYear(){
                        return date("Y");
                }

                public static function getMonth(){
                        return date("m");
                }

                public static function getDay(){
                        return date("d");
                }

                public static function getDate(){
                        return date("Y-m-d");
                }

        }
?>
