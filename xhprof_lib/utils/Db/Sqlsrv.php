<?php

  /**
  * When setting the `id` column, consider the length of the prefix you're specifying in $this->prefix
  * 
  *
CREATE TABLE dbo.details
(
   id nchar(17) NOT NULL, 
   url nvarchar(255) NULL DEFAULT NULL, 
   c_url nvarchar(255) NULL DEFAULT NULL, 
   timestamp datetime NOT NULL DEFAULT getdate(), 
   [server name] nvarchar(64) NULL DEFAULT NULL, 
   perfdata nvarchar(max) NULL, 
   type smallint NULL DEFAULT NULL, 
   cookie nvarchar(max) NULL, 
   post nvarchar(max) NULL, 
   get nvarchar(max) NULL, 
   pmu int NULL DEFAULT NULL, 
   wt int NULL DEFAULT NULL, 
   cpu int NULL DEFAULT NULL, 
   server_id nchar(3) NOT NULL DEFAULT N't11', 
   aggregateCalls_include nvarchar(255) NULL DEFAULT NULL,
   CONSTRAINT PK_details_id PRIMARY KEY (id)
)
GO
CREATE NONCLUSTERED INDEX dbo.url
   ON dbo.details (url ASC)
GO
CREATE NONCLUSTERED INDEX dbo.c_url
   ON dbo.details (c_url ASC)
GO
CREATE NONCLUSTERED INDEX dbo.cpu
   ON dbo.details (cpu ASC)
GO
CREATE NONCLUSTERED INDEX dbo.wt
   ON dbo.details (wt ASC)
GO
CREATE NONCLUSTERED INDEX dbo.pmu
   ON dbo.details (pmu ASC)
GO
CREATE NONCLUSTERED INDEX dbo.timestamp
   ON dbo.details (timestamp
  
*/

require_once XHPROF_LIB_ROOT.'/utils/Db/Abstract.php';
class Db_Sqlsrv extends Db_Abstract
{
    protected $curStmt;
    
    public function connect()
    {
        $connectionInfo = array("UID" => $this->config['dbuser'], "PWD" =>  $this->config['dbpass'], "Database"=>$this->config['dbname'], "ReturnDatesAsStrings" => TRUE);
        $linkid = sqlsrv_connect($this->config['dbhost'], $connectionInfo);
        if ($linkid === FALSE)
        {
            xhprof_error("Could not connect to db");
            throw new Exception("Unable to connect to database");
            return false;
        }
        $this->linkID = $linkid;
    }
    
    public function query($sql)
    {
        $this->curStmt = sqlsrv_prepare($this->linkID, $query, array());
        return sqlsrv_execute($this->curStmt);
    }
    
    public static function getNextAssoc($resultSet)
    {
        return sqlsrv_fetch_array($resultSet, SQLSRV_FETCH_ASSOC);
    }
    
    public function escape($str)
    {
        return addslashes($str);
    }
    
    public function affectedRows()
    {
        return sqlsrv_rows_affected($this->curStmt);
    }
    
    public static function unixTimestamp($field)
    {
        return 'DATEDIFF(s, \'1970-01-01 00:00:00\', '.$field.')';
    }
    
    public static function dateSub($days)
    {
        return 'dateadd(d, -'.$days.', getdate())';
    }
}