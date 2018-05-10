<?php

/**
 * @Author: wangjian
 * @Date:   2018-05-08 22:43:16
 * @Last Modified by:   wangjan
 * @Last Modified time: 2018-05-10 13:32:51
 * 年鉴信息列表页
 */

namespace app\year\controller;
use think\Controller;
use think\Db;

class Info extends Controller
{
	/**
	 * [index 年鉴信息列表页]
	 * @Author   wangjian
	 * @email    ahtcwangjian@qq.com
	 * @DateTime 2018-05-10
	 * @return   [type]              [description]
	 */
    public function index()
    {
    	$data=Db::table('info_copy')->where('key_id','>',0)->column('year');
        $data=array_unique($data);
        $this->assign('yeardata',$data);
        $this->assign('countdata',count($data));
        return $this->fetch();
    }
}
