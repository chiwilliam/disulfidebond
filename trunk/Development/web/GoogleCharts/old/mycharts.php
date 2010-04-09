<?php
/** Include class */
include( 'GoogChart.class.php' );

function piechart($title,$att1,$label1,$att2,$label2,$att3,$label3)
{
    // Set graph data
    $chart=new GoogChart;
$data = array(
        $label1=>$att1,
        $label2=>$att2,
        $label3=>$att3,
		);

// Set graph colors
$color = array(
			'#99C754',
			'#54C7C5',
			'#999999',
		);

/* # Chart 1 # */
//echo '<h2>Pie chart</h2>';
$chart->setChartAttrs( array(
	'type' => 'pie',
	'title' => $title,
	'data' => $data,
	'size' => array( 400, 300 ),
	'color' => $color
	));
// Print chart
return $chart;

}


function barchart($title,$type1,$att1,$label1,$att2,$label2,$att3,$label3,$type2,$att4,$att5,$att6)
{

    $chart=new GoogChart;
    $dataMultiple = array(
		$type1 => array(
			$label1 => $att1,
			$label2 => $att2,
			$label3 => $att3,
		
		),
		$type2 => array(
			$label1 => $att4,
			$label2 => $att5,
			$label3 => $att6,

		),
	);

    $color = array(
			'#99C754',
			'#54C7C5',
			'#999999',
		);

/* # Chart 2 # */
//echo '<h2>Vertical Bar</h2>';
$chart->setChartAttrs( array(
	'type' => 'bar-vertical',
	'title' => $title,
	'data' => $dataMultiple,
	'size' => array( 550, 200 ),
	'color' => $color,
	'labelsXY' => true,
	));
// Print chart
return $chart;
}

function timeline($title,$type1,$att1,$label1,$att2,$label2,$att3,$label3,$type2,$att4,$att5,$att6,$type3,$att7,$att8,$att9)
{
$chart=new GoogChart;
$dataTimeline = array( 
		$type1 => array(
			$label1 => $att1,
			$label2 => $att2,
			$label3 => $att3,
			),
		$type2 => array(
			$label1 => $att4,
			$label2 => $att5,
			$label3 => $att6,
			),
		$type3 => array(
			$label1 => $att7,
			$label2 => $att8,
			$label3 => $att9,
			),
	);

        $color = array(
			'#99C754',
			'#54C7C5',
			'#999999',
		);


/* # Chart 3 # */
//echo '<h2>Timeline</h2>';
$chart->setChartAttrs( array(
	'type' => 'sparkline',
	'title' => $title,
	'data' => $dataTimeline,
	'size' => array( 600, 200 ),
	'color' => $color,
	'labelsXY' => true,
	'fill' => array( '#eeeeee', '#aaaaaa' ),
	));
// Print chart
return $chart;
}
?>
