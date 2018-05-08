<?php

/**
 * @Author: wangjian
 * @Date:   2018-05-08 22:11:34
 * @Last Modified by:   wangjan
 * @Last Modified time: 2018-05-08 22:12:58
 * 系统及用户管理控制模块
 */
namespace app\year\controller;
use think\Controller;

class System extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}
