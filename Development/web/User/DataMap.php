<?php
    require_once("../item/Item.class.php");
    require_once("../item/ItemManager.class.php");
    
    function DataMap($users, $categories, $selected, $type){

        //create item object
        $item = new Item();
        //create item manager object
        $itemmgr = new ItemManager();

        //temporary array
        $data = array();
        $cat = array();
        $chart = array();
        $total = array();
        $categorychart = array();
        
        //get items for each category
        for ($i=0; $i<count($users); $i++){
            $totalperuser = 0;
            $user = $users[$i];
            $sql = "SELECT ITEMID FROM ITEM WHERE (".
                      "USERNAME LIKE '%".$user->getJavanetrealname().
                "%' or USERNAME LIKE '%".$user->getEmail().
                "%' or USERNAME LIKE '%".$user->getUsername().
                "%' or USERNAME LIKE '%".$user->getFirstname()." ".$user->getLastname()."%')";
            $data[0] = '<a href="./UserMainController.php?type=student&selected='.$user->getFirstname()." ".$user->getLastname().'">'.
            $user->getFirstname()." ".$user->getLastname()."</a>";
            for ($j=0; $j<count($categories); $j++){
                $category = $categories[$j];
                $item->setCategoryid($category->getCategoryid());
                if ($i == 0){
                    $cat[$j] = '<a href="./UserMainController.php?type=category&selected='.
                    $category->getCategoryname().'">'.
                    str_replace(".dev.java.net", "", $category->getCategoryname())."</a>";
                }
                $sql2 = $sql." AND CATEGORYID = ".$category->getCategoryid();
                $items = $itemmgr->getItemsBySQL($item, $sql2);
                $value = count($items);
                $totalperuser += $value;
                $data[$j+1] = $value;
                if ($type == "category" && $selected == $category->getCategoryname()){
                    $categorychart[$i] = $value;
                }
            }
            if ($user->getFirstname()." ".$user->getLastname() == $selected){
                $chart = $data;
                unset($chart[count($chart)-1]);
            }
            for ($k=1; $k<count($data);$k++){
                if($i == 0){
                    $total[$k] = $data[$k];
                }
                else{
                    $total[$k] = $total[$k]+$data[$k];
                }
            }
            if ($i == 0){
                $cat[count($cat)] = '<a href="./UserMainController.php?type=total&selected=category">TOTAL</a>';
                $datamap[$i] = $cat;
            }
            $data[count($categories)+1] = $totalperuser;
            if ($type == "total" && $selected == "category"){
                $categorychart[$i] = $totalperuser;
            }
            $datamap[$i+1] = $data;
        }
        $total[0] = '<a href="./UserMainController.php?type=total&selected=group">TOTAL</a>';
        $datamap[count($datamap)] = $total;

        if ($type == "total" && $selected == "group"){
            $chart = $total;
            unset($chart[count($chart)-1]);
        }
        if ($type == "category" || ($type == "total" && $selected == "category")){
            $chart = $categorychart;
        }
        else{
            unset($chart[0]);
        }

        $datamap[count($datamap)] = $chart;

        //remove columns with no data
        $datamap = removeEmptyColumns($datamap,$type,$selected);
        
        
        //return datamap
        return $datamap;
    }

    function removeEmptyColumns($datamap,$type,$selected){

        $totalrows = count($datamap);
        $totals = $datamap[$totalrows-2];

        for($i=0; $i<$totalrows; $i++){
                $row = $datamap[$i];
                $columns = count($row);
                $newrow = array();
                $counter = 0;
                $membernamecopied = false;
                for($j=1; $j<=$columns; $j++){
                    if ($totals[$j] != 0){
                        if ($i == 0){
                            $newrow[$counter] = $row[$j-1];
                        }
                        else{
                            if ($membernamecopied == false){
                                $newrow[0] = $row[0];
                                $membernamecopied = true;
                                $counter++;
                            }
                            $newrow[$counter] = $row[$j];
                        }
                        $counter++;
                    }
                }
                $newdata[$i] = $newrow;
        }

        if ($type == "category" || ($type == "total" && $selected == "category")){
            $newdata[(count($newdata)-1)] = $datamap[(count($datamap)-1)];
        }
        return $newdata;
    }

?>
