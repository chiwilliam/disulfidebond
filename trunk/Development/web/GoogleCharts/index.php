<?php

    include ('mycharts.php');

    $data=array(22,10,78.46,55);
    $labels=array(group1,group2,group3,group4);
    $title=array(the,title,must,be,passed,like,this);
    $image1=piechart($data,$labels,$title);
    $image2=barchart($data,$labels,$title);
    $image3=timeline($data,$labels,$title);

 ?>
<html><title> charts </title>
    <body>

<?php

echo $image1;
echo $image2;
echo $image3;

    ?>


    </body>

</html>