<?php

       /**
        * Log
        * @author YANG YANG
        * @version 1.1
        * 12/17/2008
        */
        class Log {

                public static function createFolder($path){
                        //print "createFolder() \$path=$path<br>";
                        /*
                        if (!file_exists($path)){
                                Log::createFolder(dirname($path));
                                mkdir($path, 0777);
                        }*/
                }

                public static function println($content){

                        /*
                        $path = str_replace("lib\\common\\log", "log", dirname(__FILE__));
                        Log::createFolder($path);

                        $currentDate = date("Y-m-d");
                        $logFileName = dirname(__FILE__)."\\..\\..\\..\\log\\SystemOut_".$currentDate.".log";
                        $logContent = "[".date("Y-m-d H:i:s")."] - ".$content."\r";
                        $logFile = fopen($logFileName, 'a') or die("can't open file: $logFileName");
                        fwrite($logFile, $logContent);
                        fclose($logFile);
                        */
                }

        }

?>
