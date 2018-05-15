<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//第一个是原串,第二个是 部份串
function startWith($str, $needle) {    
    return strpos($str, $needle) === 0;    
}

//第一个是原串,第二个是 部份串
function endWith($haystack, $needle) {
    
    $length = strlen($needle);
    if($length == 0)
    {
        return true;
    }
    return (substr($haystack, -$length) === $needle);
}