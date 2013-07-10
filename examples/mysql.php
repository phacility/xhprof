<?php
$xhprof_arg = array( 'argument_functions' =>
                                      array('mysql_query', 'kuchen', 'Backen::doBacken'));

class Backen {
    function doBacken($x) {
        sleep(1);
    }
}
function kuchen($x) {
    sleep(1);
}

function bar($x) {
  if ($x > 0) {
    bar($x - 1);
  }
}

function foo() {
  for ($idx = 0; $idx < 5; $idx++) {
    bar($idx);
    $x = strlen("abc");
  }
}

function testdbconn() {
$user = 'root';
$pw = 'root';
$db = 'information_schema';
$table = 'TABLES';
$con = mysql_connect("127.0.0.1",$user,$pw);
mysql_select_db($db, $con);
$sql = "SELECT COUNT(*) FROM TABLES";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
return $row;
}

// start profiling
xhprof_enable(XHPROF_FLAGS_MEMORY, $xhprof_arg);
kuchen(1);
$bcken = new Backen;
$bcken->doBacken(1);
$bcken->doBacken('kuchen');
// run program
foo();
testdbconn();
// stop profiler
$xhprof_data = xhprof_disable();

// display raw xhprof data for the profiler run
print_r($xhprof_data);


$XHPROF_ROOT = realpath(dirname(__FILE__) .'/..');
include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";

// save raw data for this profiler run using default
// implementation of iXHProfRuns.
$xhprof_runs = new XHProfRuns_Default();

// save the run under a namespace "xhprof_foo"
$run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");

echo "---------------\n".
     "Assuming you have set up the http based UI for \n".
     "XHProf at some address, you can view run at \n".
     "http://<xhprof-ui-address>/index.php?run=$run_id&source=xhprof_foo\n".
     "---------------\n";
