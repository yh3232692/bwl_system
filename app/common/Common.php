<?php
namespace app\common;

use think\Db;
use think\Request;
use app\common\Base;
use app\common\Error;
use think\Controller;

class Common extends Controller
{
    public static function check_empty($var) {
        if(isset($var) && $var !== '' ) {
            return false;
        }
        return true;
    }
    
}