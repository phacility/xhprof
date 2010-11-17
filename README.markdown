This branch/clone/whatever git calls it of the official Facebook GUI does a few things:

* It includes a header.php and footer.php document you can use with PHP's 
  auto\_prepend\_file and auto\_append\_file directives. They set up profiling 
  when requested (?\_profile=1), or randomly. Profiled pages display a link to 
  their profile results at the bottom of the page (this can be disabled on a 
  black list bases for specific documents. e.g. pages generating XML, images, 
  etc.).
* The GUI is a bit prettier (Thanks to Graham Slater)
* It uses a MySQL backend, the database schema is stored in xhprof\_runs.php 
* There's a front end to view different runs, compare runs to the same url, etc.

Key features include:

* Listing 25, 50 most recent runs
* Display most expensive (cpu), longest running, or highest memory usage runs 
  for the day
* It introduces the concept of "Similar" URLs. Consider:
  * http://news.example.com/?story=23
  * http://news.example.com/?story=25
  While the URLs are different, the PHP code execution path is likely identical,
  by tweaking the method in xhprof\_runs.php you can help the front end be aware
  that these urls are identical.
* Highcharts is used to graph stats over requests for an 
  easy heads up display.

Requirements:

* Zlib library in PHP: <http://php.net/manual/en/zlib.installation.php> 
  (Used to compress serialized data)
* Database backend
* MySQL, or MySQLi for data storage fully supported
* Support for SQL Server now in beta stages #jumpInCamp

Work that we're still doing:

* The aggregation functionality is ignored completely
* The code is... a mess. Deadlines do that to you, we're working on it
* The default table schema isn't indexed all the places it needs to be
* Easier ways to diff URLs
