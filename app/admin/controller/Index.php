<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\common\Base;
use app\common\Error;
use app\common\Common;

class Index extends Base
{
    // 视图渲染
    public function index () {
        return $this -> fetch();
    }
    
}
