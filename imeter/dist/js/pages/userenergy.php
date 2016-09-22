<?php 
require_once("../../../includes/initialize.php");

if(!isset($userid)){
if(!isset($admin_id)){
exit();
}
else {
	if(!isset($_GET['user'])){
exit();
}
else {
$user=  User::find_by_id($_GET['user']);
$userid=$user->id;
$meter_no=$user->meter_no;
}}}else {
	
$meter_no=eselect($userid,'meter_no');
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
	//get the total energy consumed in the last 24 hrs
$part_query="SELECT energy_consumed,hour FROM meter_informations WHERE meter_no='$meter_no' ORDER BY id DESC LIMIT 24 ";
$myquery=$mysqli->query("(SELECT energy_consumed,hour,id FROM meter_informations WHERE meter_no='$meter_no' ORDER BY id DESC LIMIT 24) ORDER BY id ASC");
$divisor=$myquery->num_rows;
$labels='[';
$values_time='[';
if(!$myquery){
     echo "query could not be executed";
      }
else{
	while ($page=$myquery->fetch_array()) {
    $energy=$page['energy_consumed'];  
    $hour=$page['hour'];  
   $labels.="\"$hour\",";
   $values_time.="$energy,";
   }
   $llen=strlen($labels)-1;
   $labels=substr($labels,0,$llen);
    $vlen=strlen($values_time)-1;
   $values_time=substr($values_time,0,$vlen);
   $labels.=']';
   $values_time.=']';
  //this will return the total energy consumed that day
  
  }
  
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
  var pieChartCanvas = $(\"#pieChart\").get(0).getContext(\"2d\");
  var pieChart = new Chart(pieChartCanvas);
  var PieData = [";
$date_string=date('Y').'-'.date('m').'-'.(date('d')-1);
  $get_last_date=$mysqli->query("SELECT dater from meter_informations WHERE  meter_no='$meter_no' LIMIT 1 ");
  while($last_date=$get_last_date->fetch_array()){
	  $date_string=$last_date['dater'];
  }
  $pie_get_night=$mysqli->query("SELECT energy_consumed FROM meter_informations WHERE dater='$date_string' AND meter_no='$meter_no' AND hour<='6'");
$night_cons=0; 
 while($line=$pie_get_night->fetch_array()){
	$night_cons=$night_cons+$line['energy_consumed'];  
 
 ;
  }
   $night_cons=round($night_cons);
    $pie_get_morn=$mysqli->query("SELECT energy_consumed FROM meter_informations WHERE dater='$date_string' AND meter_no='$meter_no' AND hour BETWEEN 7 AND 12  ");
$morn_cons=0; 
 while($line=$pie_get_morn->fetch_array()){
	$morn_cons=$morn_cons+$line['energy_consumed'];  
	 
	  
  }
   $morn_cons=round($morn_cons);
    $pie_get_aft=$mysqli->query("SELECT energy_consumed FROM meter_informations WHERE dater='$date_string' AND meter_no='$meter_no' AND hour BETWEEN 13 AND 18  ");
$aft_cons=0; 
 while($line=$pie_get_aft->fetch_array()){
	$aft_cons=$aft_cons+$line['energy_consumed'];  
	  
  }
  
	 $aft_cons=round($aft_cons) ;
    $pie_get_eve=$mysqli->query("SELECT energy_consumed FROM meter_informations WHERE dater='$date_string' AND meter_no='$meter_no' AND hour >18  ");
$eve_cons=0; 
 while($line=$pie_get_eve->fetch_array()){
	$eve_cons=$eve_cons+$line['energy_consumed']; 
	  
  }
  
	$eve_cons=round($eve_cons);   
  
  
  echo "
    {
      value: $night_cons,
      color: \"#f56954\",
      highlight: \"#f56954\",
      label: \"KwH Early Morning\"
    },
    {
      value: $morn_cons,
      color: \"#00a65a\",
      highlight: \"#00a65a\",
      label: \"KwH Morning\"
    },
    {
      value: $aft_cons,
      color: \"#f39c12\",
      highlight: \"#f39c12\",
      label: \"KwH Afternoon\"
    },
    {
      value: $eve_cons,
      color: \"#00c0ef\",
      highlight: \"#00c0ef\",
      label: \"KwH Evening\"
    }
  ];
  var pieOptions = {
    //Boolean - Whether we should show a stroke on each segment
    segmentShowStroke: true,
    //String - The colour of each segment stroke
    segmentStrokeColor: \"#fff\",
    //Number - The width of each segment stroke
    segmentStrokeWidth: 1,
    //Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    //Number - Amount of animation steps
    animationSteps: 100,
    //String - Animation easing effect
    animationEasing: \"easeOutBounce\",
    //Boolean - Whether we animate the rotation of the Doughnut
    animateRotate: true,
    //Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale: false,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: false,
    //String - A legend template
    legendTemplate: \"<ul class='<%=name.toLowerCase()%>-legend'><% for (var i=0; i<segments.length; i++){%><li><span style='background-color:<%=segments[i].fillColor%>'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>\",
    //String - A tooltip template
    tooltipTemplate: \"<%=value %> <%=label%> \"
	
  };
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions);
  //-----------------
  //- END PIE CHART -
  //-----------------

 

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