<?php
include(dirname(__FILE__) . '/..//xhprof_lib/config.php');

//I'm Magic :)
class visibilitator
{
	public static function __callstatic($name, $arguments)
	{
		$func_name = array_shift($arguments);
		//var_dump($name);
		//var_dump("arguments" ,$arguments);
		//var_dump($func_name);
		if (is_array($func_name))
		{
			list($a, $b) = $func_name;
			if (count($arguments) == 0)
			{
				$arguments = $arguments[0];
			}
			return call_user_func_array(array($a, $b), $arguments);
			//echo "array call  -> $b ($arguments)";
		}else {
			call_user_func_array($func_name, $arguments);
		}
	}
}

//User has control, and is attempting to modify profiling parameters
if(in_array($_SERVER['REMOTE_ADDR'], $controlIPs) && isset($_GET['_profile']))
{
    //Give them a cookie to hold status, and redirect back to the same page
    setcookie('_profile', $_GET['_profile']);
    $newURI = str_replace(array('_profile=1','_profile=0'), '', $_SERVER['REQUEST_URI']);
    header("Location: $newURI");
    exit;
}


// Only users from authorized IP addresses may control Profiling
if (in_array($_SERVER['REMOTE_ADDR'], $controlIPs) && (isset($_COOKIE['_profile']) && $_COOKIE['_profile']))
{
    $_xhprof['display'] = true;
    $_xhprof['doprofile'] = true;
    $_xhprof['type'] = 1;
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
