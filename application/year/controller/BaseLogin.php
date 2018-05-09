<?php

/**
 * @Author: wangjian
 * @Date:   2018-05-09 19:47:57
 * @Last Modified by:   wangjan
 * @Last Modified time: 2018-05-09 19:48:14
 */
namespace app\year\controller;
use think\Controller;
use think\Session;
/*
 * wj
 * 登录验证基类
 */

class BaseLogin extends Controller{

    public function _initialize()
    {
        $uid=Session::get('user');
        if($uid==null)
        {
            $this->redirect('Index/index');
        }
    }
} 