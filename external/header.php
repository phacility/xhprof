<?php
$exceptionURLs = array();
$exceptionURLs[] = "/get_scenes/";
$exceptionURLs[] = "/get_scenes2/";

$exceptionPostURLs = array();
$exceptionPostURLs[] = "login";

$_xhprof = array();

$_xhprof['display'] = false;
$_xhprof['doprofile'] = false;


// Only users from authorized IP addresses may control Profiling
$controlIPs = array();
$controlIPs[] = "127.0.0.1";   //Localhost, you'll want to add your own ip here
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

if ($_xhprof['doprofile'] === false)
{
    //Profile weighting, one in one hundred requests will be profiled without being specifically requested
    if (rand(1, 100) == 42)
    {
        $_xhprof['doprofile'] = true;
        $_xhprof['type'] = 0;
    } 
}

if (extension_loaded('xhprof') && $_xhprof['doprofile'] === true) {
    include_once '../xhprof_lib/utils/xhprof_lib.php';
    include_once '../xhprof_lib/utils/xhprof_runs.php';
    xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
}   
