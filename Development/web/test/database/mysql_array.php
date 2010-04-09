<?php

        class mysql_array {

                public function __construct ( $s_host , $s_user , $s_pass , $s_db ) {
                        $this -> r_conn = mysql_connect ( $s_host , $s_user , $s_pass ) or die ( mysql_error ( ) ) ;
                        mysql_select_db ( $s_db ) ;
                }

                private function array_make ( $s_sql , $i_type ) {
                        $r_rs = mysql_query ( $s_sql , $this -> r_conn ) or die ( mysql_error ( ) ) ;
                        while ( $a_col = mysql_fetch_array ( $r_rs , $i_type ) ) {
                                //$a_rs [ ] = $a_col ;
                                $arr = array_values($a_col);
                                $a_rs [ ] = $arr[0];
                        }
                        mysql_free_result ( $r_rs ) ;
                        return ( $a_rs ) ;
                }

                public function array_logic ( $s_sql ) {
                        $a_rs = $this -> array_make ( $s_sql , MYSQL_NUM ) ;
                        return ( $a_rs ) ;
                }

                public function array_assoc ( $s_sql ) {
                        $a_rs = $this -> array_make ( $s_sql , MYSQL_ASSOC ) ;
                        return ( $a_rs ) ;
                }

                public function array_both ( $s_sql ) {
                        $a_rs = $this -> array_make ( $s_sql , MYSQL_BOTH ) ;
                        return ( $a_rs ) ;
                }
        }

        $o_mysql = new mysql_array ( 'localhost:3306' , 'root' , 'admin' , 'ppm' ) ;
        $s_sql = "SHOW TABLES" ;
        $a_rs = $o_mysql -> array_assoc ( $s_sql ) ;

        echo '<pre>' ;
        print_r ( $a_rs ) ;

?>
