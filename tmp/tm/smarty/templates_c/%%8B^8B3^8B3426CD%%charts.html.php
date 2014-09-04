<?php /* Smarty version 2.6.25, created on 2014-09-04 18:25:48
         compiled from site/en/common/charts.html */ ?>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
<?php echo '
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          [\'Year\', \'Sales\', \'Expenses\'],
          [\'2013\',  1000,      400],
          [\'2014\',  1170,      460],
          [\'2015\',  660,       1120],
          [\'2016\',  1030,      540]
        ]);

        var options = {
          title: \'Company Performance\',
          hAxis: {title: \'Year\',  titleTextStyle: {color: \'#333\'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById(\'flot-sp1ine\'));
        chart.draw(data, options);
      }
    </script>
    '; ?>