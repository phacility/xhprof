<?php
$GLOBALS['XHPROF_LIB_ROOT'] = dirname(__FILE__) . '/../xhprof_lib';

include_once $GLOBALS['XHPROF_LIB_ROOT'].'/display/xhprof.php';
include ("../xhprof_lib/templates/header.phtml");

// param name, its type, and default value
$params = array('run'        => array(XHPROF_STRING_PARAM, ''),
                'wts'        => array(XHPROF_STRING_PARAM, ''),
                'symbol'     => array(XHPROF_STRING_PARAM, ''),
                'sort'       => array(XHPROF_STRING_PARAM, 'wt'), // wall time
                'run1'       => array(XHPROF_STRING_PARAM, ''),
                'run2'       => array(XHPROF_STRING_PARAM, ''),
                'source'     => array(XHPROF_STRING_PARAM, 'xhprof'),
                'all'        => array(XHPROF_UINT_PARAM, 0),
                );

// pull values of these params, and create named globals for each param
xhprof_param_init($params);

/* reset params to be a array of variable names to values
   by the end of this page, param should only contain values that need
   to be preserved for the next page. unset all unwanted keys in $params.
 */
foreach ($params as $k => $v) {
  $params[$k] = $$k;

  // unset key from params that are using default values. So URLs aren't
  // ridiculously long.
  if ($params[$k] == $v[1]) {
    unset($params[$k]);
  }
}



$vbar  = ' class="vbar"';
$vwbar = ' class="vwbar"';
$vwlbar = ' class="vwlbar"';
$vbbar = ' class="vbbar"';
$vrbar = ' class="vrbar"';
$vgbar = ' class="vgbar"';

$xhprof_runs_impl = new XHProfRuns_Default();
if (isset($_GET['geturl']))
{

    $rs = $xhprof_runs_impl->getUrlStats(array("url" => $_GET['geturl'], 'limit' => 100));
    showChart($rs);
    
    $rs = $xhprof_runs_impl->getRuns(array('url' => $_GET['geturl'], 'limit' => 100));
    $url = htmlentities($_GET['geturl'], ENT_QUOTES);
    displayRuns($rs, "Runs with URL: $url");
}elseif (isset($_GET['getcurl']))
{
    $rs = $xhprof_runs_impl->getUrlStats(array("c_url" => $_GET['getcurl'], 'limit' => 100));
    showChart($rs);
    
    $url = htmlentities($_GET['getcurl'], ENT_QUOTES);
    $rs = $xhprof_runs_impl->getRuns(array('c_url' => $_GET['getcurl'], 'limit' => 100));
    displayRuns($rs, "Runs with Simplified URL: $url");
}elseif (isset($_GET['last']))
{
    $last = (int) $_GET['last'];
    $rs = $xhprof_runs_impl->getRuns(array("order by" => 'timestamp', 'limit' => $last));
    displayRuns($rs, "Last $last Runs");
}elseif (isset($_GET['getruns']))
{
    $days = (int) $_GET['days'];
    
    switch ($_GET['getruns'])
    {
        case "cpu":
            $load = "cpu";
            break;
        case "wt":
            $load = "wt";
            break;
        case "pmu":
            $load = "pmu";
            break;
    }
    
    
    $rs = $xhprof_runs_impl->getRuns(array("order by" => $load, 'limit' => 500 ,'where' => "DATE_SUB(CURDATE(), INTERVAL $days DAY) <= `timestamp`"));
    displayRuns($rs, "Worst runs by $load");
}else
{
    
    displayXHProfReport($xhprof_runs_impl, $params, $source, $run, $wts,
                    $symbol, $sort, $run1, $run2);
    
}


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

include ("../xhprof_lib/templates/footer.phtml");