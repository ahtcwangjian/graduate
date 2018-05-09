<?php
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

/**
 * 登录和注册页面的控制器
 */
class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }


    /**
     * [register description]  用户注册页面
     * @Author   wangjian
     * @email    ahtcwangjian@qq.com
     * @DateTime 2018-05-09
     * @return   [type]              [description]
     */
    public  function register()
    {
    	return $this->fetch();
    }

    /**
     * @param Request $request
     * 注册请求
     * @return array
     */
    public function registerAjax(Request $request)
    {
        //       初始返回参数
        $status=0;
        $result='';
        $data=$request->param();

        $user=new UserModel();

        $rule=[
            ['xuehao','require|number|unique:user_copy,student_id','学号不能为空|学号必须为数字|该学号已存在，请填写新的学号！'],
            ['mima','require','密码不能为空，请检查！'],
            ['mima_confirm','require|confirm:mima','验证密码不能为空|验证密码不正确'],
        ];

//        进行验证
        $result=$this->validate($data,$rule);

        //        验证通过则将注册是用户信息存入数据库
        if($result===true)
        {
            $user->student_id=$data['xuehao'];
            $user->password=$data['mima'];
            $user->user_flag=$data['userflag'];

            if($user->save())
            {
                //数据成功存入数据库
                $status=1;
                $result="注册成功！";
            }
            else{
                //数据未成功存入数据库
                $status=0;
                $result="注册失败！"+$user->getError();
            }
        }
        return ['status'=>$status,'message'=>$result,'data'=>$data];
    }

    /**
     * @param Request $request
     * 登录请求
     * @return array
     */
    public function loginAjax(Request $request)
    {
        //       初始返回参数
        $status=0;
        $result='';
        $data=$request->param();
//        $user=new UserModel;
        $rule=[
//            ['username','require|unique:tk_user,username','用户名不能为空|该用户名已存在，请填写新的用户名！'],
            ['xuehao','require|number','学号不能为空！|学号必须为数字'],
            ['mima','require','密码不能为空，请检查！'],
        ];

//        进行验证
        $result=$this->validate($data,$rule);
        if($result===true)
        {
//            构造查询条件
            $map=[
                'student_id'=>$data['xuehao'],
                'password'=>$data['mima'],
                'user_flag'=>$data['userflag'],
            ];

            $user=UserModel::get($map);
            if($user==null)
            {
                $status=0;
                $result="该用户名或密码错误或身份错误！";
            }
            else{
                //数据未成功存入数据库
                $status=1;
                $result="验证通过！";
                //将数据存入Session
                Session::set('user',$user);
            }
        }
        return ['status'=>$status,'message'=>$result,'data'=>$data];
    }





}
