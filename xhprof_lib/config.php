<?php
$_xhprof = array();

$_xhprof['dbhost'] = 'localhost';
$_xhprof['dbuser'] = 'root';
$_xhprof['dbpass'] = 'root';
$_xhprof['dbname'] = 'xhprof';

$exceptionURLs = array();
$exceptionURLs[] = "/get_scenes/";
$exceptionURLs[] = "/get_scenes2/";

$exceptionPostURLs = array();
$exceptionPostURLs[] = "login";


$_xhprof['display'] = false;
$_xhprof['doprofile'] = false;

$controlIPs = array();
$controlIPs[] = "127.0.0.1";   //Localhost, you'll want to add your own ip here
$controlIPs[] = "216.226.57.228";   //Localhost, you'll want to add your own ip here


$otherURLS = array();
$controlIPs = array();

$weight = 100;


  /**
  * The goal of this function is to accept the URL for a resource, and return a "simplified" version
  * thereof. Similar URLs should become identical. Consider:
  * http://example.org/stories.php?id=23
  * http://example.org/stories.php?id=24
  * Under most setups these two URLs, while unique, will have an identical execution path, thus it's
  * worthwhile to consider them as identical. The script will store both the original URL and the
  * Simplified URL for display and comparison purposes. 
  * 
  * @param string $url The URL to be simplified
  * @return string The simplified URL 
  */
  function _urlSimilartor($url)
  {
      //This is an example 
      $url = preg_replace("!\d{4}!", "", $url);
      return $url;
  }