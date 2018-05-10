<?php

/**
 * @Author: wangjian
 * @Date:   2018-05-08 22:26:09
 * @Last Modified by:   wangjan
 * @Last Modified time: 2018-05-10 21:52:56
 * 用户操作年鉴信息的界面
 */
namespace app\year\controller;
use think\Controller;
use app\year\model\UserModel;
use app\year\model\YearbookModel;
use think\Request;
use think\Db;
use think\Session;
use think\Log;
use think\Validate;
use think\File;

class Manage extends BaseLogin
{
    public function index()
    {
        return $this->fetch();
    }

    /**
     * [addYearbook 新增年鉴页面]
     * @Author   wangjian
     * @email    ahtcwangjian@qq.com
     * @DateTime 2018-05-10
     */
    public function addYearbook()
    {
    	return $this->fetch();
    }

    /**
     * [saveData 新增年鉴时，提交按钮的点击事件]
     * @Author   wangjian
     * @email    ahtcwangjian@qq.com
     * @DateTime 2018-05-10
     * @param    Request             $request [description]
     * @return   [type]                       [description]
     */
    public function saveData(Request $request)
    {
        $year=$request->param("year");
        $title=$request->param("title");
        $author=$request->param("author");
        $remark=$request->param("remark");
        $content=$request->param("content");
        //如果标题 和 内容不为空，则将数据保存到数据库 tk_title  tk_textarea
        if((!empty($title))&&(!empty($content))){

            //将数据存进数据库
            $yearbook=new YearbookModel();
            $yearbook->year=$year;
            $yearbook->title=$title;
            $yearbook->author=$author;
            $yearbook->remark=$remark;
            $yearbook->textarea=$content;
            if($yearbook->save()){
                return 1;
            }
            else{
                return 0;
            }
        }else{
            return ['data'=>"fail"];
        }
    }
}
