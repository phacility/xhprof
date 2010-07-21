<?php
$_xhprof = array();

$_xhprof['dbhost'] = 'localhost';
$_xhprof['dbuser'] = 'xhprof';
$_xhprof['dbpass'] = 'xh23as0ahd';
$_xhprof['dbname'] = 'xhprof';
$_xhprof['servername'] = 'sd1';

$exceptionURLs = array();
$exceptionURLs[] = "/get_scenes/";
$exceptionURLs[] = "/get_scenes2/";
$exceptionURLs[] = "/EdmAjax/";
$exceptionURLs[] = "/EdmFax/";
$exceptionPostURLs = array();
$exceptionPostURLs[] = "login";


$_xhprof['display'] = false;
$_xhprof['doprofile'] = false;

$controlIPs = array();
$controlIPs[] = "127.0.0.1";   //Localhost, you'll want to add your own ip here
$controlIPs[] = "10.3.2.14";
$controlIPs[] = "10.3.2.13";
$controlIPs[] = "10.3.2.12";
$controlIPs[] = "10.3.2.11";
$controlIPs[] = "10.3.2.10";
$controlIPs[] = "10.3.2.15";
$controlIPs[] = "10.3.2.16";
$controlIPs[] = "10.3.2.17";
$controlIPs[] = "10.3.2.18";
$controlIPs[] = "10.3.2.19";
$controlIPs[] = "10.3.2.20";
$controlIPs[] = "10.3.2.21";
$controlIPs[] = "10.3.2.22";
$controlIPs[] = "10.3.2.23";


$otherURLS = array();

$weight = 100;


  /**
  * The goal of this function is to accept the URL for a resource, and return a "simplified" version
  * thereof. Similar URLs should become identical. Consider:
  * http://example.org/stories.php?id=2323
  * http://example.org/stories.php?id=2324
  * Under most setups these two URLs, while unique, will have an identical execution path, thus it's
  * worthwhile to consider them as identical. The script will store both the original URL and the
  * Simplified URL for display and comparison purposes. A good simplified URL would be:
  * http://example.org/stories.php?id=
  * 
  * @param string $url The URL to be simplified
  * @return string The simplified URL 
  */
  function _urlSimilartor($url)
  {
      //This is an example 
      $url = preg_replace("!\d{4}!", "", $url);
      
      $url = preg_replace("![?&]_profile=\d!", "", $url);
      return $url;
  }
  
  function _aggregateCalls($calls, $rules = null)
  {
    $rules = array(
        'Loading' => 'load::',
	'Encryption' => 'CI_Encrypt'
        );
    $addIns = array();
    foreach($calls as $index => $call)
    {
        foreach($rules as $rule => $search)
        {
            if (strpos($call['fn'], $search) !== false)
            {
                if (isset($addIns[$search]))
                {
                    unset($call['fn']);
                    foreach($call as $k => $v)
                    {
                        $addIns[$search][$k] += $v;
                    }
                }else
                {
                    $call['fn'] = $rule;
                    $addIns[$search] = $call;
                }
                unset($calls[$index]);  //Remove it from the listing
                break;  //We don't need to run any more rules on this
            }else
            {
                //echo "nomatch for $search in {$call['fn']}<br />\n";
            }
        }
    }
    return array_merge($addIns, $calls);
  }
