<?php

        class Shape{
                public function Shape(){
                        //print __CLASS__."<br>";
                        print get_class($this)."<br>";
                }

                public function go(){
                        print "go()<br>";
                }
        }
?>
