<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/6 0006
 * Time: 下午 4:24
 */

namespace app\admin\controller;


use think\Controller;
use think\Request;

class Api extends Controller
{

    /**
     * 登录接口
     * @param $account
     * @param $pwd
     * @param null $token
     */
    public function login($tel=null,$pwd=null,$token=null){
        $model = model("User");
        if(!empty($token))
        {
            //使用token进行登录
            if($user = $model->loginWithToken($token)){

                $this->success("登录成功",null,$user);
            }
            else{
                $this->error("Token错误或过期，请重新登录！");
            }
        }
        else{
        //使用用户名密码登录
            if($user = $model->loginWithAccount($tel,$pwd)){
                $this->success("登录成功！",null,$user);
            }
            else{
                $this->error("用户名或密码错误！");
            }
        }
    }

    /**
     * 新用户注册
     * @param $mobile电话号码
     * @param $pwd
     * @param int $from 用户来源，默认为1-微信小程序
     */
    public function reg($mobile,$pwd,$from=1){
        if(empty($mobile) || empty($pwd)){
            $this->error("电话号码和密码不能为空！");
        }
        //检查电话是否存在
        if($this->checkMobile($mobile)){
            $this->error("电话号码已注册，请直接登录，如果忘记密码请联系管理员");
        }
        $res = model("User")->reg($mobile,$pwd,$from);
        if($res){
            $this->success("注册成功！");
        }
        else{
            $this->error("注册失败！");
        }
    }

    /**
     * 检测电话号码是否被注册
     * @param $mobile
     * @return array|false|\think\Model，如果不为false，则存在
     */
    protected function checkMobile($mobile){
        $model = model("User")->where(["tel"=>$mobile,"isreg"=>1])->find();
        return $model;
    }

    public function addStudent(Request $request){

    }
    /**
     * @param Request $request
     */
    public function addUser(Request $request){

    }
    /**
     * 代理列表
     * @param int $pid推荐人编号，默认为null，查询所有人。
     */
    public function userList($pid = null){
        $map = [];
        if($pid)
        {
            $map["referee_id"] = $pid;
        }
        $model = model("User");
        $res = $model->where($map)->paginate();
       $this->success("查询到数据",'',$res);
    }




    public function success($msg = '', $url = null, $data = '', $wait = 3, array $header = [])
    {
        $result = [
            'code' => 0,
            'msg'  => $msg,
            'data' => $data
        ];
        echo json_encode($result);
        die;
    }
    public function error($msg = '', $url = null, $data = '', $wait = 3, array $header = [])
    {
        $result = [
            'code' => 1,
            'msg'  => $msg,
            'data' => $data
        ];
        echo json_encode($result);
        die;
    }
}