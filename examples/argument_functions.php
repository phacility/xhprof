<?php

$options = array( 'argument_functions' => array('file_get_contents', 'strlen'));

xhprof_enable(0, $options);

function fetch($url)
{
    return file_get_contents($url);
}

fetch('http://qafoo.com');
fetch('http://php.net');

echo strlen(str_repeat('"', 300));

var_dump(xhprof_disable());
