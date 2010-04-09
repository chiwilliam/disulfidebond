<?php

        /**
         * Supper class for all value object class
         *
         * @author Yang Yang
         * @version 1.0
         * 11/20/2008
         */
        class VO{
                public function __call($method, $params) {
                        $size = count($params);
                        if ( $size ==0) {
                                //the function has no parameter
                                return $this->$method();
                        }else if ( $size ==1) {
                                //the function has one parameter
                                return $this->$method($params[0]);
                        } else {
                                //the function has more than one parameter
                                $str = '';
                                $values = array_values($params);
                                for ( $i=0; $i<$size; $i++ ) {
                                        $str .= "'".$values[$i]."' ,";
                                }
                                $str = substr($str, 0, -2);
                                return eval('return $this->'.$method.'('.$str.');');
                        }
                }
        }
?>
