<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Url;

class Base extends Controller
{    
    
    protected function _initialize()
    {
       //Url::root('/public/index.php');
    }
    
    protected function tables()
    {
        $tables=Db::query('SHOW TABLES');//print_r($tables);
        $tbs = array();
        foreach ($tables as $t){
            $tbs[] = $t["Tables_in_".config('database.database')];
        }
        return $tbs;
    }
    
    protected function columns($table){
        $columns = Db::query("SHOW FULL COLUMNS FROM ".$table);
        return $columns;
    }
    
    
}
