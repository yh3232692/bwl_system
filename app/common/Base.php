<?php

namespace app\common;

use think\Controller;
use think\Db;
use think\Request;
use think\Env;
class Base extends Controller 
{

    public $request;
    // 初始化操作,并且进行登陆操作的验证与权限把控
    public function _initialize ()
    {
        $request = Request::instance();
		
    }

    // 数据处理成功调用的api接口
    public static function echo_success($message = '') 
    {
        $row = [
            "code"  => 0,
            "message"   => $message
        ];
        return json_encode($row,JSON_UNESCAPED_UNICODE);
    }

    // 数据处理失败调用的api接口
    public static function echo_error($message = '') 
    {
        $row = [
            "code"  => -1,
            "message"   => $message
        ];
        return json_encode($row,JSON_UNESCAPED_UNICODE);
    }

    // 自动生成guid的方法
    protected function guid() 
    {
        if (function_exists('com_create_guid')){
            $uuid = com_create_guid();
            $uuid1 = preg_match('/^{(.+)}$/', $uuid, $match);
            return $match[1];
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);
            $uuid = substr($charid, 0, 8).$hyphen
                    .substr($charid, 8, 4).$hyphen
                    .substr($charid,12, 4).$hyphen
                    .substr($charid,16, 4).$hyphen
                    .substr($charid,20,12);
            return $uuid;
        }
    }
}