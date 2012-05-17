<?php
    $base_url_params = xhprof_array_unset(xhprof_array_unset($url_params, 'run1'), 'run2');
    $href1 = "$base_path/?" .
      http_build_query(xhprof_array_set($base_url_params,
                                        'run', $run1));
    $href2 = "$base_path/?" .
      http_build_query(xhprof_array_set($base_url_params,
                                        'run', $run2));
                                                                                                                       
print('<div id="view-diff-tables">'); 
        print("<div id=\"invert-wrapper\">"); 
           print("<div id=\"invert-image\">");                                        
             print("<a class=\"invert\" href=\"?run1=$run2&run2=$run1\"><img src=\"img/invert-2.png\" alt=\"Invert Report\" /></a>");                                          
           print("</div>");                  
           print("<div id=\"link-id\">");                            
             print("<h2 class=\"diff-details\">Run One ID: $run1 against {$xhprof_runs_impl->run_details[0]['server name']}</h2>"); 
             print("<h2 class=\"diff-details\">Run Two ID: $run2 against {$xhprof_runs_impl->run_details[1]['server name']}</h2>"); 
           print("</div>");
        print("</div>");                    
                
         print("<div id=\"diff-graph\">");
           print("<a href=\"callgraph.php?run1=$run1&run2=$run2\" class=\"callgraph\">View Callgraph</a>");         
         print("</div>");
        
        print("<div id=\"clear\"></div>");
         
      print('<div class="colone">');          
         //   cookie diff data from array position 0 
	  if (!isset($GLOBALS['_xhprof']['serializer']) || strtolower($GLOBALS['_xhprof']['serializer']) == 'php') {
       $cookieArr0 =  unserialize($xhprof_runs_impl->run_details[0]['cookie']);
       $cookieArr1 =  unserialize($xhprof_runs_impl->run_details[1]['cookie']);
       $getArr0 =  unserialize($xhprof_runs_impl->run_details[0]['get']);
       $getArr1 =  unserialize($xhprof_runs_impl->run_details[1]['get']);     
       $postArr0 =  unserialize($xhprof_runs_impl->run_details[0]['post']); 
       $postArr1 =  unserialize($xhprof_runs_impl->run_details[1]['post']);    
	  } else {
	   $cookieArr0 =  json_decode($xhprof_runs_impl->run_details[0]['cookie'], true);
       $cookieArr1 =  json_decode($xhprof_runs_impl->run_details[1]['cookie'], true);
       $getArr0 =  json_decode($xhprof_runs_impl->run_details[0]['get'], true);
       $getArr1 =  json_decode($xhprof_runs_impl->run_details[1]['get'], true);     
       $postArr0 =  json_decode($xhprof_runs_impl->run_details[0]['post'], true); 
       $postArr1 =  json_decode($xhprof_runs_impl->run_details[1]['post'], true);    
	  }
       
       
        print ('<div class="box-fix-small">');
         print '<table class="box-tables-small">';
         print "<thead>";
         print "<tr><th>Run One ID:\n$run1</th><th>Cookie Results</th></tr>";
         print "</head>";
         print "<tbody>";
                 
            foreach($cookieArr0 as $key=>$value){       
            echo "<tr>";
            
            if(isset($cookieArr1[$key]) && $cookieArr0[$key] == $cookieArr1[$key]){
              $class ="normal";
            }else{
              $class ="different";
            }            
            echo "<td>" . $key . "</td><td class=\"".$class."\">" .  chunk_split($value) . "</td>";
            echo "</tr>";
         }
         print  "</tbody>";
         print  "</table>";
        print  "</div>";  
         
        //   get diff data from array position 0
           
       // $getArr0 =  json_decode($xhprof_runs_impl->run_details[0]['get']);
        print '<div class="box-fix-small-cl">';
         print '<table class="box-tables-small">';
         print "<thead>";
         print "<tr><th>Run:$run1</th><th>Get Results</th></tr>";
         print "</head>";
         print "<tbody>"; 
                
            foreach($getArr0 as $key=>$value){       
            echo "<tr>";
            
            if(isset($getArr1[$key]) && ($getArr0[$key] == $getArr1[$key])){
              $class ="normal";
            }else{
              $class ="different";
            }
            if (is_array($value))
            {
                $value = implode(", ", $value);
            }
            echo "<td>" . $key . "</td><td class=\"".$class."\">" . chunk_split($value) . "</td>";
            echo "</tr>";
         }
         print  "</tbody>";
         print  "</table>";
        print  "</div>";      

         //   post diff data from array position 0 
        // $postArr0 =  json_decode($xhprof_runs_impl->run_details[0]['post']);
        print '<div class="box-fix-small-cl">';
         print '<table class="box-tables-small">';
         print "<thead>";
         print "<tr><th>Run:$run1</th><th>Post Results</th></tr>";
         print "</head>";
         print "<tbody>"; 
                
            foreach($postArr0 as $key=>$value){       
            echo "<tr>";
             if(isset($postArr1[$key]) && $postArr0[$key] == $postArr1[$key]){
              $class ="normal";
            }else{
                $class ="different";
            }
            echo "<td>" . $key . "</td><td class=\"".$class."\">" . chunk_split($value) . "</td>";
            echo "</tr>";
         }
         print  "</tbody>";
         print  "</table>";
        print  "</div>";      
          
    print('</div>');          
  
    print('<div class="coltwo">');          
        print('<div id="diff-summary">');  
        print('<table class="diff-box">');
        print("<thead>"); 
        print('<tr>');
        print("<th></th>");
        print("<th $vwbar>Run One ID: " . xhprof_render_link("$run1", $href1) . "</th>");
        print("<th $vwbar>Run Two ID: " . xhprof_render_link("$run2", $href2) . "</th>");
        print("<th $vwbar>Diff</th>");
        print("<th $vwbar>Diff%</th>");
        print('</tr>');
        print("</thead>"); 
        print "<tbody>";        
        if ($display_calls) {
          print('<tr>');
          print("<td>Number of Function Calls</td>");
          print_td_num($totals_1["ct"], $format_cbk["ct"]);
          print_td_num($totals_2["ct"], $format_cbk["ct"]);
          print_td_num($totals_2["ct"] - $totals_1["ct"], $format_cbk["ct"], true);
          print_td_pct($totals_2["ct"] - $totals_1["ct"], $totals_1["ct"], true);
          print('</tr>');
        }

        foreach ($metrics as $metric) {
          $m = $metric;
          print('<tr>');
          print("<td>" . str_replace("<br>", " ", $descriptions[$m]) . "</td>");
          print_td_num($totals_1[$m], $format_cbk[$m]);
          print_td_num($totals_2[$m], $format_cbk[$m]);
          print_td_num($totals_2[$m] - $totals_1[$m], $format_cbk[$m], true);
          print_td_pct($totals_2[$m] - $totals_1[$m], $totals_1[$m], true);
          print('<tr>');
        }                 
        print "</tbody>";        
        print('</table>');                                
        print('</div>');         
        
               
     print('</div>'); 
   
        
     print('<div class="colthree">');             
        print '<div class="box-fix-small">';
         print '<table class="box-tables-small">';
         print "<thead>";
         print "<tr><th>Run Two ID:\n$run2</th><th>Cookie Results</th></tr>";
         print "</head>";
         print "<tbody>";        
         //  cookie diff data from array position 1  
        //$cookieArr1 =  json_decode($xhprof_runs_impl->run_details[1]['cookie']);
            
          foreach($cookieArr1 as $key=>$value){
            echo "<tr>";
            
             if(isset($cookieArr0[$key]) && ($cookieArr1[$key] == $cookieArr0[$key])){
              $class ="normal";
            }else{
                $class ="different";
            }
            echo "<td>" . $key . "</td><td class=\"".$class."\">" . chunk_split($value) . "</td>";
            echo "</tr>";
         }
          print  "</tbody>";
          print  "</table>";
         print  "</div>";
          
             
         print '<div class="box-fix-small-cl">';
         print '<table class="box-tables-small">';
         print "<thead>";
         print "<tr><th>Run:$run2</th><th>Get Results</th></tr>";
         print "</head>";
         print "<tbody>";
        //   get diff data from array position 1                            
      //  $getArr1 =  json_decode($xhprof_runs_impl->run_details[1]['get']);
        
            foreach($getArr1 as $key=>$value){
            echo "<tr>";
            
             if(isset($getArr0[$key]) && ($getArr1[$key] == $getArr0[$key])){
              $class ="normal";
            }else{
                $class ="different";
            }
            if(is_array($value))
            {
                $value = implode(", ", $value);
            }
            echo "<td>" . $key . "</td><td class=\"".$class."\">" . chunk_split($value) . "</td>";
            echo "</tr>";
         }
          print  "</tbody>";
          print  "</table>";
          print  "</div>";
         
                                                                        
         print '<div class="box-fix-small-cl">';
         print '<table class="box-tables-small">';
         print "<thead>";
         print "<tr><th>Run:$run2</th><th>Post Results</th></tr>";
         print "</head>";
         print "<tbody>";        
         //   post diff data from array position 1  
       // $postArr1 =  json_decode($xhprof_runs_impl->run_details[1]['post']);
            
            foreach($postArr1 as $key=>$value){
            echo "<tr>";
            
             if($postArr1[$key] == $postArr0[$key]){
              $class ="normal";
            }else{
                $class ="different";
            }
            echo "<td>" . $key . "</td><td class=\"".$class."\">" . chunk_split($value) . "</td>";
            echo "</tr>";
         }
?>
</tbody>
</table>
</div>          
</div>
</div>
