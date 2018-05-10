<?php

/**
 * @Author: wangjian
 * @Date:   2018-05-08 22:11:34
 * @Last Modified by:   wangjan
 * @Last Modified time: 2018-05-10 10:12:43
 * 系统及用户管理控制模块
 */
namespace app\year\controller;
use think\Controller;
use app\year\model\UserModel;
use think\Request;

class System extends Controller
{
    public function index()
    {
    	$list=UserModel::where('key_id','>=',1)->paginate(10);
        // 获取分页显示
        $page = $list->render();
        // 模板变量赋值
        $this->assign('list', $list);
        $this->assign('page', $page);
        $counter=1;
        $this->assign('counter',$counter);
        return $this->fetch();
    }


    /**
     * @return mixed
     * User: wangjian
     * Date: 2017-12-
     * Function：修改用户 页面
     */
    public function editUser($key_id)
    {
        $info=UserModel::get($key_id);
        // 模板变量赋值
        $this->assign('info', $info);
//        dump($info);
        return $this->fetch();
    }


    /**
     * @param Request $request
     * @return array
     * User: wangjian
     * Date: 2017-12-26
     * Function：修改用户 ajax请求
     */
    public function editUserAjax(Request $request)/*修改用户 ajax请求*/
    {

        //       初始返回参数
        $status=0;
        $result='';
        $data=$request->param();

        $key_id=$data['key_id'];

        $user=UserModel::get($key_id);

//        进行验证

        $rule=[
            ['user_password','require','密码不能为空，请检查！'],
        ];
       $result=$this->validate($data,$rule);

        //        验证通过则将注册是用户信息存入数据库
        if($result===true)
        {
            // $user->student_id=$data['user_name'];
            $user->password=$data['user_password'];

            if($user->save())
            {
                //数据成功存入数据库
                $status=1;
                $result="修改成功！";
            }
            else{
                //数据未成功存入数据库
                $status=0;
                $result="修改失败！"+$user->getError();
            }

        }

        return ['status'=>$status,'message'=>$result,'data'=>$data];

    }



    /**
     * @param $key_id
     * @return array
     * User: wangjian
     * Date: 2017-12-27
     * Function：ajax删除用户信息
     */
    public function delUserAjax($key_id)
    {
        //       初始返回参数
        $status=0;
        $result='';
        $data=$key_id;

        $user=UserModel::get($key_id);
        if($user){
            $user->delete();
            $status=1;
            $result="删除成功！";
        }
        else{
            $status=0;
            $result="删除失败！";
        }


        return ['status'=>$status,'message'=>$result,'data'=>$data];
    }
    
}
