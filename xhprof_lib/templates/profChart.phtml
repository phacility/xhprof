<script type="text/javascript">
   Highcharts.setOptions({colors: ['#4572A7', '#AA4643', '#89A54E', '#80699B', '#3D96AE', '#DB843D', '#92A8CD', '#A47D7C', '#B5CA92', '#EAFEBB', '#FEB4B1', '#2B6979', '#E9D6FE', '#FECDA3', '#FED980']});
       var chart = new Highcharts.Chart({
   chart: {
      renderTo: 'container',
      margin: [20, 20, 20, -50],
      height: '300'
   },
   credits: {
       enabled:false
   },
   title: {
      text: 'Expensive Calls by Exclusive Wall Time'
   },
   plotArea: {
      shadow: null,
      borderWidth: null,
      backgroundColor: null
   },
   tooltip: {
      formatter: function() {
         return '<b>'+ this.point.name +'</b>: '+ this.y + 'ms';
      }
   },
   plotOptions: {
      pie: {
         allowPointSelect: true,
         dataLabels: {
            enabled: true,

            color: 'white',
            style: {
               font: '13px Trebuchet MS, Verdana, sans-serif'
            }
         }
      }
   },
   legend: {
      layout: 'vertical',
      style: {
         left: 'auto',
         bottom: 'auto',
         right: '10px',
         top: '35px'
      },
      labelFormatter: function() {
         if(this.name.length > 20)
         {
              return this.name.substring(0,20) + '...'
         }else
         {
              return this.name
         }
         
       }
   },
        series: [{
      type: 'pie',
      name: 'Expensive by exclusive wall time',
      data: [
        <?php
            $iterations = 0;
            $other = 0;
            foreach($data_copy as $dataPoint)
            {
                if (++$iterations > 14)
                {
                    $other+= $dataPoint['excl_wt'];
                }else
                {
                    echo "['{$dataPoint['fn']}', {$dataPoint['excl_wt']}],\n";
                }
            }
            echo "['Other', $other]";
        ?>
      ]
   }]
});

</script>
