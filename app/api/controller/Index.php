<?php
namespace app\api\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\common\Base;
use app\common\Error;
use app\common\Common;

class Index extends Base
{
    private $sql = " SELECT a.*,CASE a.bugs_status WHEN 0 THEN '未处理' WHEN 1 THEN '已处理' ELSE '' END AS bugs_status_info FROM bug_info a ";
    
    public function show_bugs ()
    {
        $bugs = Db::name('bug_info');
        // 默认查询当天的时间
        // $date = Date('Y-m-d',time());

        // 检测查询的时间是否为空
        $date = $this -> request -> post('date');
        if (Common::check_empty($date) === true) {
            return Base::echo_error(Error::DATE_IS_EMPTY);
        }
        
        $result = $bugs -> query($this -> sql."where a.bugs_create_date = '{$date}' ORDER BY a.bugs_create_time DESC");

        // 数据库错误
        if ($result === false) {
            return Base::echo_error(Error::DB_ERROR);
        }
        // 数据处理成功
        return Base::echo_success($result);
    }

    public function add_bugs ()
    {
        $bugs = Db::name('bug_info');
        $data = [];

        // 检测title是否合法
        $bugs_title = $this -> request -> post('bugs_title');
        if (Common::check_empty($bugs_title) === true) {
            return Base::echo_error(Error::TLTLE_IS_EMPTY);
        }
        $data['bugs_title'] = $bugs_title;
        
        // 检测bug描述书否为空
        $bugs_description = $this -> request -> post('bugs_description');
        if (Common::check_empty($bugs_description) === true) {
            return Base::echo_error(Error::DESC_IS_EMPTY);
        }
        $data['bugs_description'] = $bugs_description;

        // 检测bug等级是否为空
        $bugs_grade = $this -> request -> post('bugs_grade');
        if (Common::check_empty($bugs_grade) === true) {
            return Base::echo_error(Error::BUGS_GRADE_IS_EMPTY);
        }
        $data['bugs_grade'] = intval($bugs_grade);

        $data['bugs_create_user'] = $this -> request -> post('bugs_create_user');
        $data['bugs_create_time'] = Date('Y-m-d H:i:s',time());
        $data['bugs_status'] = 0;
        $data['bugs_create_date'] = Date('Y-m-d',time());
        
        if (Db::name('bug_info')->insert($data)) {
            return Base::echo_success(Error::ADD_SUCCESS);
        } else {
            return Base::echo_error(Error::ADD_ERROR);
        }
    }


}
