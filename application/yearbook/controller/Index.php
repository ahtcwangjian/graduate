<?php
namespace app\yearbook\controller;
use think\Controller;


class Index extends Controller
{
    /**
     * @return mixed
     * 年鉴系统登录页面
     */
    public function index()
    {
        return $this->fetch();
    }

    public function login()
    {
        return "login";
    }

    /**
     * @return mixed
     * 年鉴系统注册页面
     */
    public function register()
    {
        return $this->fetch();
    }
}
