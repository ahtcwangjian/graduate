<?php

/**
 * @Author: wangjian
 * @Date:   2018-05-08 22:43:16
 * @Last Modified by:   wangjan
 * @Last Modified time: 2018-05-09 13:37:02
 * 年鉴信息列表页
 */

namespace app\year\controller;
use think\Controller;

class Info extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}
