<?php

/**
 * @Author: wangjian
 * @Date:   2018-05-08 22:26:09
 * @Last Modified by:   wangjan
 * @Last Modified time: 2018-05-08 22:26:52
 * 用户操作年鉴信息的界面
 */
namespace app\year\controller;
use think\Controller;

class Manage extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}
