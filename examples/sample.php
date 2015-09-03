<?php

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

// start profiling
xhprof_enable();

// run program
for ($i = 0; $i < 1000; $i++) {

	foo();
}

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
     "<a href='http://".$_SERVER['HTTP_HOST']."/xhprof_html/index.php?run=$run_id&source=xhprof_foo'>click here</a>\n".
     "---------------\n";
