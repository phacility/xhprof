<?php
$GLOBALS['XHPROF_LIB_ROOT'] = dirname(__FILE__) . '/../xhprof_lib';
require ("../xhprof_lib/config.php");
include_once $GLOBALS['XHPROF_LIB_ROOT'].'/display/xhprof.php';
include ("../xhprof_lib/utils/common.php");



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

$domainFilter = getFilter('domain_filter');
$serverFilter = getFilter('server_filter');

$domainsRS = $xhprof_runs_impl->getDistinct(array('column' => 'server name'));
$domainFilterOptions = array("None");
while ($row = mysql_fetch_assoc($domainsRS))
{
	$domainFilterOptions[] = $row['server name'];
}

$serverRS = $xhprof_runs_impl->getDistinct(array('column' => 'server_id'));
$serverFilterOptions = array("None");
while ($row = mysql_fetch_assoc($serverRS))
{
	$serverFilterOptions[] = $row['server_id'];
}




include ("../xhprof_lib/templates/header.phtml");
$criteria = array();
if (!is_null($domainFilter))
{
  $criteria['server name'] = $domainFilter;
}
if (!is_null($serverFilter))
{
  $criteria['server_id'] = $serverFilter;
}

if(isset($_GET['run1']) || isset($_GET['run']))
{
	displayXHProfReport($xhprof_runs_impl, $params, $source, $run, $wts,
	                    $symbol, $sort, $run1, $run2);	
}elseif (isset($_GET['geturl']))
{
    $criteria['url'] = $_GET['geturl'];
    $criteria['limit'] = 100;
    $rs = $xhprof_runs_impl->getUrlStats($criteria);
    showChart($rs);
    
    $rs = $xhprof_runs_impl->getRuns(array('url' => $_GET['geturl'], 'limit' => 100));
    $url = htmlentities($_GET['geturl'], ENT_QUOTES);
    displayRuns($rs, "Runs with URL: $url");
}elseif (isset($_GET['getcurl']))
{
    $criteria['c_url'] = $_GET['getcurl'];
    $criteria['limit'] = 100;
    $rs = $xhprof_runs_impl->getUrlStats($criteria);
    showChart($rs);
    
    $url = htmlentities($_GET['getcurl'], ENT_QUOTES);
    $rs = $xhprof_runs_impl->getRuns($criteria);
    displayRuns($rs, "Runs with Simplified URL: $url");
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
    
    $criteria['order by'] = $load;
    $criteria['limit'] = "500";
    $criteria['where'] = "DATE_SUB(CURDATE(), INTERVAL $days DAY) <= `timestamp`";
    $rs = $xhprof_runs_impl->getRuns($criteria);
    displayRuns($rs, "Worst runs by $load");
}else 
{
	$last = (isset($_GET['last'])) ?  $_GET['last'] : 25;
	$last = (int) $last;
	$criteria['order by'] = "timestamp";
	$criteria['limit'] = $last;
	$rs = $xhprof_runs_impl->getRuns($criteria);
	displayRuns($rs, "Last $last Runs");
}


include ("../xhprof_lib/templates/footer.phtml");