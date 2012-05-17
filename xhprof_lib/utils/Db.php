<?php
class Db
{
    /**
     * @return Db_Abstract
     */
    public static function factory()
    {
        global $_xhprof;
        require_once XHPROF_LIB_ROOT.'/utils/Db/'.$_xhprof['dbadapter'].'.php';
         
        $class = 'Db_'.$_xhprof['dbadapter'];
        $db = new $class($_xhprof);
        $db->connect();
        
        return $db;
    }
}