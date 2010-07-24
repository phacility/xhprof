<?php
include(dirname(__FILE__) . '/..//xhprof_lib/config.php');
// Only users from authorized IP addresses may control Profiling
if (in_array($_SERVER['REMOTE_ADDR'], $controlIPs))
{
    $_xhprof['display'] = true;
    if (isset($_GET['_profile']) && !headers_sent()) {
        setcookie('_profile', $_GET['_profile']);
    }
    if (
        (isset($_GET['_profile']) && $_GET['_profile'])
        || (isset($_COOKIE['_profile']) && $_COOKIE['_profile'])) 
    {
        $_xhprof['doprofile'] = true;
        $_xhprof['type'] = 1;
    } 
}
//Certain URLs should never have a link displayed. Think images, xml, etc. 
foreach($exceptionURLs as $url)
{
    if (stripos($_SERVER['REQUEST_URI'], $url) !== FALSE)
    {
        $_xhprof['display'] = false;
        header('X-XHProf-No-Display: Trueness');
        break;
    }    
}
unset($exceptionURLs);

//Certain urls should have their POST data omitted. Think login forms, other privlidged info
$_xhprof['savepost'] = true;
foreach ($exceptionPostURLs as $url)
{
    if (stripos($_SERVER['REQUEST_URI'], $url) !== FALSE)
    {
        $_xhprof['savepost'] = false;
        break;
    }    
}
unset($exceptionPostURLs);

//Determine wether or not to profile this URL randomly
if ($_xhprof['doprofile'] === false)
{
    //Profile weighting, one in one hundred requests will be profiled without being specifically requested
    if (rand(1, $weight) == 1)
    {
        $_xhprof['doprofile'] = true;
        $_xhprof['type'] = 0;
    } 
}
unset($weight);

//Display warning if extension not available
if (extension_loaded('xhprof') && $_xhprof['doprofile'] === true) {
    include_once dirname(__FILE__) . '/../xhprof_lib/utils/xhprof_lib.php';
    include_once dirname(__FILE__) . '/../xhprof_lib/utils/xhprof_runs.php';
    xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
}elseif(!extension_loaded('xhprof') && $_xhprof['display'] === true)
{
	echo "Warning! Unable to profile run, xhprof extension not loaded\n";
}
