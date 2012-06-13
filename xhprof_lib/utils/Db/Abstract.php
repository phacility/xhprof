<?php
abstract class Db_Abstract
{
    protected $config;
    public $linkID;
    
    public function __construct($config)
    {
        $this->config = $config;
    }
    
    abstract public function connect();
    abstract public function query($sql);
    abstract public static function getNextAssoc($resultSet);
    abstract public function escape($str);
    abstract public function affectedRows();
    abstract public static function unixTimestamp($field);
    abstract public static function dateSub($days);
    
    
}