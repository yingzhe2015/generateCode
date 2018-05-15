<?php
namespace app\index\controller;

class Ajax extends Base
{    
    public function getcolumns()
    {
        return json($this->columns(input('get.table')));
    }
}