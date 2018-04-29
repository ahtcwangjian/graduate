<?php
namespace app\yearbook\controller;
use think\Controller;
use app\yearbook\model\UserModel;
use think\Request;
use think\Db;
use think\Session;
use think\Log;
use think\Validate;
use think\File;

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

        $user=new UserModel;

        $rule=[
            ['xuehao','require|number|unique:user,student_id','学号不能为空|学号必须为数字|该学号已存在，请填写新的学号！'],
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
            ];

            $user=UserModel::get($map);
            if($user==null)
            {
                $status=0;
                $result="该用户名或密码错误！";
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

    /**
     * @return mixed
     * 首页
     */
    public function manage()
    {
        return $this->fetch();
    }

    /**
     * @return mixed
     * 新增年鉴页面
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 新增年鉴的提交按钮点击事件
     */
    public function infoAjax(Request $request)
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('myfile');
// 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
// 成功上传后 获取上传信息
// 输出 jpg
//            echo $info->getExtension();
//// 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
//            echo $info->getSaveName();
//// 输出 42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getFilename();
        }else{
// 上传失败获取错误信息
            echo $file->getError();
        }
        echo "<hr>";
        echo $request->param("author");

        echo "<hr>";
        $fileName=ROOT_PATH . 'public' . DS . 'uploads'.DS.$info->getSaveName();
        $myfile=fopen($fileName,'r');
        while(!feof($myfile))
        {
            echo fgetc($myfile);
        }

    }

}
