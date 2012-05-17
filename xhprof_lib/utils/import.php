<?php
class Import
{
    protected $linkID;
    
    public function __construct($dir = null)
    {
        $this->db();
    }
    
    protected function db()
    {
        global $_xhprof;
    
    
        $linkid = mysql_connect($_xhprof['dbhost'], $_xhprof['dbuser'], $_xhprof['dbpass']);
        if ($linkid === FALSE)
        {
            xhprof_error("Could not connect to db");
            $run_desc = "could not connect to db";
            throw new Exception("Unable to connect to database");
            return false;
        }
        mysql_select_db($_xhprof['dbname'], $linkid);
        $this->linkID = $linkid;
    }
    
    public function importFunctions()
    {
        global $stats;
        $query = 'SELECT id
        FROM details AS d
        LEFT JOIN functions AS f ON (f.runid=d.id)
        WHERE runid IS NULL';
        $resultSet = mysql_query($query, $this->linkID);
        $xhprof_runs_impl = new XHProfRuns_Default();
        $totals = $desc = null;
        
        while ($run = mysql_fetch_assoc($resultSet)) {
            list($xhprof_data, $run_details) = $xhprof_runs_impl->get_run($run['id'], null, $desc);
            $symbol_tab = xhprof_compute_flat_info($xhprof_data, $totals);
            mysql_query('LOCK TABLES `xhprof`.`functions` WRITE');
            foreach ($symbol_tab as $name=>$symbol) {
                $query = 'INSERT INTO `xhprof`.`functions`
                    (`function`, `runid`,'.implode(',',array_keys($symbol)).')
                    VALUES 
                    ("'.$name.'","'.$run['id'].'",'.implode(',', $symbol).');';
                mysql_query($query, $this->linkID);
            }
            mysql_query('UNLOCK TABLES');
        }
    }
    
}
