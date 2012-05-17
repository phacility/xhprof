<?php
class History
{
    /**
     * 
     * @var Db_Abstract
     */
    protected $db;
    protected $symbol;
    
    public function __construct($dir = null)
    {
        $this->db = Db::factory();
    }
    
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;
        return $this;
    }
    
    
    public function getHistory()
    {
        $query = 'SELECT id, 
            UNIX_TIMESTAMP(`timestamp`) AS timestamp,
            f.ct,
            f.wt,
            f.mu,
            f.pmu,
            f.cpu, 
            f.excl_wt,
            f.excl_mu, 
            f.excl_pmu, 
            f.excl_cpu
        FROM functions AS f
        JOIN details AS d ON (id=runid)
        WHERE function="'.$this->symbol.'"
        ORDER BY timestamp DESC ';
        $this->resultSet[$this->symbol] = $this->db->query($query);
        return $this->resultSet[$this->symbol];
        
        
    }
}