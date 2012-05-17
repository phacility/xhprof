<?php
class History
{
    protected $linkID;
    protected $resultSet;
    protected $symbol;
    
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
    
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;
        return $this;
    }
    
    
    public function getHistory()
    {
        $rs = $this->getResultSet(); 
        echo "<table id=\"box-table-a\" class=\"tablesorter\" summary=\"Stats\">
            <thead>
            <tr>
                <th>Timestamp</th>
                <th>Wall Time</th>
            </tr>
            </thead>";
        echo "<tbody>\n";
            while ($data = XHProfRuns_Default::getNextAssoc($rs)) {
                echo "\t<tr><td>".$data['timestamp']."</td><td>".$data['wt']."</td></tr>";
            }
        echo "</tbody>\n";
        echo "</table>\n";
    }
    
    public function getResultSet()
    {
        if (!isset($this->resultSet[$this->symbol])) {
            $query = 'SELECT id, UNIX_TIMESTAMP(`timestamp`) AS timestamp, f.excl_wt as wt, f.excl_pmu as pmu, f.excl_cpu as cpu
                FROM functions AS f
                JOIN details AS d ON (id=runid)
                WHERE function="'.$this->symbol.'"
                ORDER BY timestamp DESC ';
            $this->resultSet[$this->symbol] = mysql_query($query) or die(mysql_error());
        } else {
            mysql_data_seek($this->resultSet[$this->symbol], 0);
        }
        return $this->resultSet[$this->symbol]; 
    }
    
    
}