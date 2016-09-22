<?php 
require_once("../../../includes/initialize.php");

if(!isset($admin_id)){
exit();
}

echo "\$(function () {

  'use strict';

  /* ChartJS
   * -------
   * Here we will create a few charts using ChartJS
   */

  //-----------------------
  //- MONTHLY SALES CHART -
  //-----------------------

  // Get context with jQuery - using jQuery's .get() method.
  var salesChartCanvas = $(\"#salesChart\").get(0).getContext(\"2d\");
  // This will get the first returned node in the jQuery collection.
  var salesChart = new Chart(salesChartCanvas);

  var salesChartData = { ";
	//get the value of the topup which has been credited into the meter
	$range=15;
	$rangd=$range-1;
	
		$date_raw=date('r');
	$yesterday=date('Y-m-d H:i:s', strtotime("-$range day", strtotime($date_raw)));
	$today=date('Y-m-d H:i:s', strtotime("-{$rangd}	day", strtotime($date_raw)));

	
$labels='[';
$values_time='[';
$values_time2='[';
	for($i=$range;$i>0;$i--){
		//this is to print the various dates data sharp sharp
	$pday=$day-1;
$no=date('d', strtotime($yesterday));
$nom=date('M', strtotime($yesterday));


$sales=$mysqli->query("SELECT id,time FROM meter_topup WHERE time >='$yesterday' AND time<='$today'
");
if($sales){
	$sales=$sales->num_rows;
}else {
	$sales=0;
}
$visits=$mysqli->query("SELECT id,time FROM visitors WHERE time >='$yesterday' AND time<='$today'
");
if($visits){
	$visits=$visits->num_rows;
}else {
	$visits=0;
}
		$yesterday=date('Y-m-d H:i:s', strtotime('+1 day', strtotime($yesterday)));
		$today=date('Y-m-d H:i:s', strtotime('+1 day', strtotime($today)));
		$labels.="\"$no $nom\",";
   $values_time.="$sales,";
   $values_time2.="$visits,";
		
	}


   $llen=strlen($labels)-1;
   $labels=substr($labels,0,$llen);
    $vlen=strlen($values_time)-1;
   $values_time=substr($values_time,0,$vlen);
    $vlen2=strlen($values_time2)-1;
   $values_time2=substr($values_time2,0,$vlen2);
  
   $labels.=']';
   $values_time.=']';
   $values_time2.=']';
  //this will return the total energy consumed that day
  
  
  
  echo "  labels: $labels,
    datasets: [
      {
        label: \"Electronics\",
        fillColor: \"rgb(210, 214, 222)\",
        strokeColor: \"rgb(210, 214, 222)\",
        pointColor: \"rgb(210, 214, 222)\",
        pointStrokeColor: \"#c1c7d1\",
        pointHighlightFill: \"#fff\",
        pointHighlightStroke: \"rgb(220,220,220)\",
        data:$values_time
      },
      {
        label: \"Digital Goods\",
        fillColor: \"rgba(60,141,188,0.9)\",
        strokeColor: \"rgba(60,141,188,0.8)\",
        pointColor: \"#3b8bba\",
        pointStrokeColor: \"rgba(60,141,188,1)\",
        pointHighlightFill: \"#fff\",
        pointHighlightStroke: \"rgba(60,141,188,1)\",
        data: $values_time2
      }
    ]
  };

  var salesChartOptions = {
    //Boolean - If we should show the scale at all
    showScale: true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines: false,
    //String - Colour of the grid lines
    scaleGridLineColor: \"rgba(0,0,0,.05)\",
    //Number - Width of the grid lines
    scaleGridLineWidth: 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: true,
    //Boolean - Whether the line is curved between points
    bezierCurve: true,
    //Number - Tension of the bezier curve between points
    bezierCurveTension: 0.3,
    //Boolean - Whether to show a dot for each point
    pointDot: false,
    //Number - Radius of each point dot in pixels
    pointDotRadius: 4,
    //Number - Pixel width of point dot stroke
    pointDotStrokeWidth: 1,
    //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    pointHitDetectionRadius: 20,
    //Boolean - Whether to show a stroke for datasets
    datasetStroke: true,
    //Number - Pixel width of dataset stroke
    datasetStrokeWidth: 2,
    //Boolean - Whether to fill the dataset with a color
    datasetFill: true,
    //String - A legend template
    legendTemplate: \"<ul class='<%=name.toLowerCase()%>-legend'><% for (var i=0; i<datasets.length; i++){%><li><span style='background-color:<%=datasets[i].lineColor%>'></span><%=datasets[i].label%></li><%}%></ul>\",
    //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: true,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true
  };

  //Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);

  //---------------------------
  //- END MONTHLY SALES CHART -
  //---------------------------

  //-------------
  //- PIE CHART -
  //-------------
  // Get context with jQuery - using jQuery's .get() method.
  

  /* SPARKLINE CHARTS
   * ----------------
   * Create a inline charts with spark line
   */

  //-----------------
  //- SPARKLINE BAR -
  //-----------------
  $('.sparkbar').each(function () {
    var \$this = $(this);
    \$this.sparkline('html', {
      type: 'bar',
      height: \$this.data('height') ? \$this.data('height') : '30',
      barColor: \$this.data('color')
    });
  });

  //-----------------
  //- SPARKLINE PIE -
  //-----------------
  $('.sparkpie').each(function () {
    var \$this = $(this);
    \$this.sparkline('html', {
      type: 'pie',
      height: \$this.data('height') ? \$this.data('height') : '90',
      sliceColors: \$this.data('color')
    });
  });

  //------------------
  //- SPARKLINE LINE -
  //------------------
  $('.sparkline').each(function () {
    var \$this = $(this);
    \$this.sparkline('html', {
      type: 'line',
      height: \$this.data('height') ? \$this.data('height') : '90',
      width: '100%',
      lineColor: \$this.data('linecolor'),
      fillColor: \$this.data('fillcolor'),
      spotColor: \$this.data('spotcolor')
    });
  });
}); ";
?>