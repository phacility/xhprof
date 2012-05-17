<?php
class Build_Symbol
{
    /**
    * 
    * @var Db_Abstract
    */
    protected $db;
    
    public function __construct($dir = null)
    {
        $this->db = Db::factory();
    }
    
    public function importFunctions()
    {
        global $stats;
        
        $maxTime = ini_get('max_execution_time');
        set_time_limit(0);
        
        $query = 'SELECT id
        FROM details AS d
        LEFT JOIN functions AS f ON (f.runid=d.id)
        WHERE runid IS NULL';
        $resultSet = $this->db->query($query);
        $xhprof_runs_impl = new XHProfRuns_Default();
        $totals = $desc = null;
        $nb = 0;
        
        while ($run = $this->db->getNextAssoc($resultSet)) {
            list($xhprof_data, $run_details) = $xhprof_runs_impl->get_run($run['id'], null, $desc);
            $symbol_tab = xhprof_compute_flat_info($xhprof_data, $totals);
            foreach ($symbol_tab as $name=>$symbol) {
                $query = 'INSERT INTO `xhprof`.`functions`
                    (`function`, `runid`,'.implode(',',array_keys($symbol)).')
                    VALUES 
                    ("'.$name.'","'.$run['id'].'",'.implode(',', $symbol).');';
                $this->db->query($query);
                $nb++;
            }
        }
        set_time_limit($maxTime);
        
        return $nb;
    }
    
}
