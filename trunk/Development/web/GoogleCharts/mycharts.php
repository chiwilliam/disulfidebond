<?php  


function img($val,$lbl,$title,$type)
	{       $strTitle = "";
                for ($i = 0; $i < sizeof($title); $i++)
                {
                    $strTitle = $strTitle.$title[$i]."+";
                }

		return sprintf('<img src="http://chart.apis.google.com/chart?chtt=%s&chs=300x150&chco=FF0000,CC3366,660033,330066,9966CC,330033&chbh=20,20&chd=t:%s&cht=%s&chdl=%s" />', $strTitle, $val, $type, $lbl);

	}

   

function piechart(array $values, array $labels, array $title)
{
                      
                      $strlabels1 = "";
                      $strValues = "";
                      $strLabels = "";
                      $strVal = "";
                      $total = 0;
                      $values1 = array ();

                      for ($a = 0; $a < sizeof($values); $a++)
                            $total += $values[$a];

                      for ($b = 0; $b < sizeof($values); $b++)
                            $values1[$b] = ($values[$b]/$total)*100 ;
                            
                      for ($i = 0; $i < sizeof($values); $i++) {
                          $strValues = $strValues.$values1[$i].",";
                          $strLabels = $strLabels.$labels[$i]."|";
                          $strLabels1 = $strLabels1.$values[$i]."|";

                      }

                      $type='p&chl='.$strLabels1;

                     // for ($i=1; $i < strlen($strValues); $i++)
                       //    $strValues .=  ",";

                      $strValues = substr($strValues, 0, strlen($$strValues)-1);
                      $strLabels = substr($strLabels, 0, strlen($strLabels)-1);


    return img($strValues,$strLabels,$title,$type);
    /*echo <img src="http://chart.apis.google.com/chart?chs=280x120&amp;chco=0000FF&amp;chd=t:<?php echo $strForum; ?>&amp;cht=p&amp;chl=<?php echo $strNames; ?>"title="2D Pie chart" />
                   */
}

function barchart(array $values, array $labels, array $title)
{
                      $type='bvg&chbh=a';
                      $strValues = "";
                      $strLabels = "";
                      //$strVal= "";
                      $total = 0;
                      $values1 = array ();

                      for ($a = 0; $a < sizeof($values); $a++)
                            $total += $values[$a];

                      for ($b = 0; $b < sizeof($values); $b++)
                            $values1[$b] = ($values[$b]/$total)*100 ;

                      for ($i = 0; $i < sizeof($values); $i++) {
                          $strValues = $strValues.$values1[$i]."|";
                          //$strVal = $strVal.$values[$i]."|";
                          $strLabels = $strLabels.$labels[$i]."(".$values[$i].")"."|";

                      }

                     // for ($i=1; $i < strlen($strValues); $i++)
                       //    $strValues .=  ",";

                      $strValues = substr($strValues, 0, strlen($$strValues)-1);
                      $strLabels = substr($strLabels, 0, strlen($strLabels)-1);


    return img($strValues,$strLabels,$title,$type);
    /*echo <img src="http://chart.apis.google.com/chart?chs=280x120&amp;chco=0000FF&amp;chd=t:<?php echo $strForum; ?>&amp;cht=p&amp;chl=<?php echo $strNames; ?>"title="2D Pie chart" />
                   */
}

// FUNCTIONS MADE TO GENERATE PDF



//    U N D E R       C O N S T R U C T I O N 
function timeline(array $values, array $labels, array $title)
{
                      $type='s';
                      $strValues = "";
                      $strLabels = "";
                      $total = 0;
                      $values1 = array ();
                      $xlabel = "";

                      for ($a = 0; $a < sizeof($values); $a++)
                            $total += $values[$a];

                      for ($b = 0; $b < sizeof($values); $b++)
                            $values1[$b] = ($values[$b]/$total)*100 ;

                      for ($i = 0; $i < sizeof($values); $i++) {
                          $strValues = $strValues.$values1[$i].",";
                          //$strVal = $strVal.$values[$i]."|";
                          $strLabels = $strLabels.$labels[$i]."(".$values[$i].")"."|";

                             $j=$i+1;
                          $xlabel = $xlabel.$j.",";

                      }

                      $strValues = $strValues."|".$xlabel;
                      //for ($i=1; $i < strlen($strValues); $i++)
                        //   $strValues .=  ",";

                      $strValues = substr($strValues, 0, strlen($$strValues)-1);
                      $strLabels = substr($strLabels, 0, strlen($strLabels)-1);


    return img($strValues,$strLabels,$title,$type);
    /*echo <img src="http://chart.apis.google.com/chart?chs=280x120&amp;chco=0000FF&amp;chd=t:<?php echo $strForum; ?>&amp;cht=p&amp;chl=<?php echo $strNames; ?>"title="2D Pie chart" />
                   */
}


?>