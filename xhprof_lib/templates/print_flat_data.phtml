<h3 align=center><?php echo $title; ?> <?php echo $display_link;?></h3><br>
<table border=1 cellpadding=2 cellspacing=1 width="90%" rules=rows bordercolor="#bdc7d8" align=center>
    <tr bgcolor="#bdc7d8" align=right>
<?php
  foreach ($stats as $stat) {
    $desc = stat_description($stat);
    if (array_key_exists($stat, $sortable_columns)) {
      $href = "$base_path/?"
              . http_build_query(xhprof_array_set($url_params, 'sort', $stat));
      $header = xhprof_render_link($desc, $href);
    } else {
      $header = $desc;
    }

    if ($stat == "fn")
      print("<th align=left><nobr>$header</th>");
    else
      print("<th " . $vwbar . "><nobr>$header</th>");
  }
  print("</tr>\n");

  if ($limit >= 0) {
    $limit = min($size, $limit);
    for($i=0; $i < $limit; $i++) {
      print_function_info($url_params, $flat_data[$i], $sort, $run1, $run2);
    }
  } else {
    // if $limit is negative, print abs($limit) items starting from the end
    $limit = min($size, abs($limit));
    for($i=0; $i < $limit; $i++) {
      print_function_info($url_params, $flat_data[$size - $i - 1], $sort, $run1, $run2);
    }
  }
  print("</table>");

  // let's print the display all link at the bottom as well...
  if ($display_link) {
    echo '<div style="text-align: left; padding: 2em">' . $display_link . '</div>';
  }