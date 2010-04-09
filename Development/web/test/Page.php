<?php

        class Page{

                private $totalpage;
                private $stride;
                private $currentpage;

                //设置总页数
                function setTotalpage($objpage=0){
                        $this->totalpage=$objpage;
                }

                //设置当前页
                function setCurrentpage($objpage=1){
                        $this->currentpage=$objpage;
                }

                //设置跨度
                function setStride($objStride=1){
                        $this->stride=$objStride;
                }

                //获得总页数
                function getTotalpage(){
                        return $this->totalpage;
                }

                //获得跨读
                function getStride($objStride=1){
                        return $this->stride;
                }

                //获取当前页
                function getCurrentpage($objpage=1){
                        return $this->currentpage;
                }

                //打印分页
                function Pageprint(){
                        for($Tmpa=1; $Tmpa<$this->totalpage; $Tmpa++){
                                if($Tmpa+$this->stride<$this->currentpage){
                                        //加了跨度还小于当前页的不显示
                                        continue;
                                }

                                if($Tmpa+$this->stride==$this->currentpage){
                                        //刚好够跨度的页数
                                        $p=$this->currentpage-$this->stride-1;
                                        $willprint.="<a href=\"$_SERVER[PHP_SELF]?page=1\"><strong><<</strong></a> <a href=\"$_SERVER[PHP_SELF]?page=$p\"><strong><</strong></a> ";
                                }

                                if($Tmpa>$this->currentpage+$this->stride){
                                        //大于当前页+跨度的页面
                                        break;
                                }

                                $willprint.="<a href=\"$_SERVER[PHP_SELF]?page=$Tmpa\"><strong>$Tmpa</strong></a> ";
                                if($Tmpa==$this->currentpage+$this->stride){
                                        //刚好够跨度的页数
                                        $p=$this->currentpage+$this->stride+1;
                                        $willprint.="<a href=\"$_SERVER[PHP_SELF]?page=$p\"><strong>></strong></a> <a href=\"$_SERVER[PHP_SELF]?page=$this->totalpage\"><strong>>></strong></a>";
                                }
                        }
                        echo $willprint;
                }
        }

        if(isset($_GET[page])){
                $page=$_GET[page];
        }else{
                $page=1;
        }

        $CC=new Page();
        $CC->setTotalpage(1000);
        $CC->setCurrentpage($page);
        $CC->setStride(3);
        $CC->Pageprint();
?>
