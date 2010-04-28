<?php

function displayRuns($resultSet, $title = "")
{
    echo "<div class=\"runTitle\">$title</div>\n";
    echo "<table id=\"box-table-a\" class=\"tablesorter\" summary=\"Stats\"><thead><tr><th>Timestamp</th><th>Cpu</th><th>Wall Time</th><th>Peak Memory Usage</th><th>URL</th><th>Simplified URL</th></tr></thead>";
    echo "<tbody>\n";
    while ($row = mysql_fetch_assoc($resultSet))
    {
        $c_url = urlencode($row['c_url']);
        $url = urlencode($row['url']);
        $date = strtotime($row['timestamp']);
        $date = date('M d H:i:s', $date);
        echo "\t<tr><td><a href=\"/?run={$row['id']}\">$date</a><br><span class=\"runid\">{$row['id']}</span></td><td>{$row['cpu']}</td><td>{$row['wt']}</td><td>{$row['pmu']}</td><td><a href=\"?geturl={$url}\">{$row['url']}</a></td><td><a href=\"?getcurl={$c_url}\">{$row['c_url']}</a></td></tr>\n";
    }
    echo "</tbody>\n";
    echo "</table>\n";   
}

function showChart($rs)
{
    global $_xh_header;
    
    $_xh_header = "
          <script type=\"text/javascript\">
      google.load(\"visualization\", \"1\", {packages:[\"linechart\"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', 'Date');
        data.addColumn('number', 'CPU');
        data.addColumn('number', 'Wall Time');
        data.addColumn('number', 'Peak Memory Usage');
        data.addColumn('string', 'Run ID');
        ";
        $count = 0;
        
        
        $dataPoints = "";
        $ids = array();
        while($row = mysql_fetch_assoc($rs))
        {
            
            $date = date("Y, ", $row['timestamp']) . (date("n", $row['timestamp']) - 1) . date(", j, g, i, s", $row['timestamp']);
            $cpu = $row['cpu'] * 75;
            $dataPoints .=  <<<DATA
        data.setValue($count, 0, new Date($date));
        data.setValue($count, 1, {$cpu});
        data.setValue($count, 2, {$row['wt']});
        data.setValue($count, 3, {$row['pmu']});
        data.setValue($count, 4, '{$row['id']}');

DATA;
            $ids[] = $row['id'];
            $count++;
            
        }
        $_xh_header .= "data.addRows($count);
        ";

        $_xh_header .= $dataPoints;
        $_xh_header .= "
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, {displayAnnotations: true, hideColumns: 4});
        
        google.visualization.events.addListener(chart, 'select', function() 
        {
          var idlookup = new Array($count);
          ";
          $i = 0;
          foreach($ids as $id)
          {
            $_xh_header .= "idlookup[$i] = '$id';\n"; 
            $i++;  
          }
          $_xh_header .= "
          var selection = chart.getSelection();
          document.location = '/?run=' + idlookup[selection[0].row];
        });
        
      }
    </script>";

    echo "<div id='chart_div' style='width: 1200px; height: 260px;'></div>";
    echo $_xh_header;
    
}