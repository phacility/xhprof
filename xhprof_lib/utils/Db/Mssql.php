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
class Db_Mssql extends Db_Abstract
{
    
    public function connect()
    {
        $linkid = mssql_connect($this->config['dbhost'], $this->config['dbuser'], $this->config['dbpass']);
        if ($linkid === FALSE)
        {
            xhprof_error("Could not connect to db");
            throw new Exception("Unable to connect to database");
            return false;
        }
        mssql_select_db($this->config['dbname'], $linkid);
        $this->linkID = $linkid;
    }
    
    public function query($sql)
    {
        return mssql_query($sql);
    }
    
    public static function getNextAssoc($resultSet)
    {
        return mssql_fetch_assoc($resultSet);
    }
    
    public static function escape($str)
    {
        return addslashes($str);
    }
    
    public function affectedRows()
    {
        return mssql_rows_affected($this->linkID);
    }
    
    public static function unixTimestamp($field)
    {
        return 'UNIX_TIMESTAMP('.$field.')';
    }
    
    public static function dateSub($days)
    {
        return 'DATE_SUB(CURDATE(), INTERVAL '.$days.' DAY)';
    }
}