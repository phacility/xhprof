<?php

/**
 * When setting the `id` column, consider the length of the prefix you're specifying in $this->prefix
 *
 *
 CREATE TABLE `details` (
 `id` char(17) NOT NULL,
 `url` varchar(255) default NULL,
 `c_url` varchar(255) default NULL,
 `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
 `server name` varchar(64) default NULL,
 `perfdata` MEDIUMBLOB,
 `type` tinyint(4) default NULL,
 `cookie` BLOB,
 `post` BLOB,
 `get` BLOB,
 `pmu` int(11) unsigned default NULL,
 `wt` int(11) unsigned default NULL,
 `cpu` int(11) unsigned default NULL,
 `server_id` char(3) NOT NULL default 't11',
 `aggregateCalls_include` varchar(255) DEFAULT NULL,
 PRIMARY KEY  (`id`),
 KEY `url` (`url`),
 KEY `c_url` (`c_url`),
 KEY `cpu` (`cpu`),
 KEY `wt` (`wt`),
 KEY `pmu` (`pmu`),
 KEY `timestamp` (`timestamp`)
 ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

 */

require_once XHPROF_LIB_ROOT.'/utils/Db/Abstract.php';
class Db_Mysql extends Db_Abstract
{
    
    public function connect()
    {
        $linkid = mysql_connect($this->config['dbhost'], $this->config['dbuser'], $this->config['dbpass']);
        if ($linkid === FALSE)
        {
            xhprof_error("Could not connect to db");
            throw new Exception("Unable to connect to database");
            return false;
        }
        $this->query("SET NAMES utf8");
        mysql_select_db($this->config['dbname'], $linkid);
        $this->linkID = $linkid;
    }
    
    public function query($sql)
    {
        return mysql_query($sql);
    }
    
    public static function getNextAssoc($resultSet)
    {
        return mysql_fetch_assoc($resultSet);
    }
    
    public function escape($str)
    {
        return mysql_real_escape_string($str);
    }
    
    public function affectedRows()
    {
        return mysql_affected_rows($this->linkID);
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