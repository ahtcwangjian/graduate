<?php

/**
 * @Author: wangjian
 * @Date:   2018-05-08 22:43:16
 * @Last Modified by:   wangjan
 * @Last Modified time: 2018-05-10 21:52:57
 * 年鉴信息列表页
 */

namespace app\year\controller;
use think\Controller;
use think\Db;
use think\Request;
use app\year\model\UserModel;
use app\year\model\YearbookModel;

class Info extends BaseLogin
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


    /**
     * [infoList 具体某个年份的信息列表]
     * @Author   wangjian
     * @email    ahtcwangjian@qq.com
     * @DateTime 2018-05-10
     * @param    [type]              $year [description]
     * @return   [type]                    [description]
     */
    public function infoList($year)
    {
        $datatitle=$data=Db::table('info_copy')->where('year',$year)->select();
        $this->assign("year",$year);
        $this->assign("datatitle",$datatitle);
        return $this->fetch();
    }


    /**
     * [detail 详细的信息页面]
     * @Author   wangjian
     * @email    ahtcwangjian@qq.com
     * @DateTime 2018-05-10
     * @param    [type]              $id [description]
     * @return   [type]                  [description]
     */
    public function detail($id)
    {
        $data=Db::table('info_copy')->where('key_id',$id)->find();
        $this->assign("data",$data);
        return $this->fetch();
    }

    /**
     * [edit 编辑页面]
     * @Author   wangjian
     * @email    ahtcwangjian@qq.com
     * @DateTime 2018-05-10
     * @return   [type]              [description]
     */
    public function edit($id)
    {
        $data=Db::table('info_copy')->where('key_id',$id)->find();
        $this->assign("data",$data);
        return $this->fetch();
    }


    /**
     * [updateData 修改 年鉴信息]
     * @Author   wangjian
     * @email    ahtcwangjian@qq.com
     * @DateTime 2018-05-10
     * @param    Request             $request [description]
     * @return   [type]                       [description]
     */
    public function updateData(Request $request){
        $year=$request->param("year");
        $title=$request->param("title");
        $author=$request->param("author");
        $remark=$request->param("remark");
        $keyid=$request->param("keyid");
        $content=$request->param("content");

        //如果标题 和 内容不为空，则将数据保存到数据库 tk_title  tk_textarea
        if((!empty($title))&&(!empty($content))){

            //将数据存进数据库
            $yearbook=YearbookModel::get($keyid);
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

    /**
     * [delAjax 删除年鉴的信息请求]
     * @Author   wangjian
     * @email    ahtcwangjian@qq.com
     * @DateTime 2018-05-10
     * @param    [type]              $id [description]
     * @return   [type]                  [description]
     */
    public function delAjax($id)
    {
        $res=0;
        if(Db::table('info_copy')->where('key_id',$id)->delete())
        {
            $res=1;
        }
        return $res;
    }
}
