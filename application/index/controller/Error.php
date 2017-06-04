<?php

namespace app\index\controller;

use think\Request;

class Error
{
        public function index(Request $request)
        {
             return $request->controller().'不存在！';
        }
        
}