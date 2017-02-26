--TEST--
XHProf: Profiler Unwind From Function Scope
--FILE--
<?php

function xhprof_done() {
  xhprof_disable();
}

// This makes sure we don't segfault if disabling the profiler from within
// the scope of a function.

xhprof_enable();
xhprof_done();

echo "Done.";

--EXPECT--
Done.