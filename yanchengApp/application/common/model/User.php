<?php
namespace app\common\model;

use think\Model;

class User extends Model
{
    // 指定表名,不含前缀
    protected $name = 'user';
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    /**
     * 注册用户
     * @param $mobile 电话号码
     * @param $pwd 密码
     * @param int $from 用户来源：0 - 未知，1-微信小程序，2-公众号，3-iOS，4-安卓
     * @return false|int
     */
    public function reg($mobile,$pwd,$from=1){
       return $this->save(["tel"=>$mobile,"pwd"=>md5($pwd),"isreg"=>1,"from"=>$from]);
    }

    public function loginWithToken($token){
        $res = null;
       $res = $this->where("token",$token)->find();
        return $res;
    }

    /**
     * 用户密码登录
     * @param $tel 电话号码
     * @param $pwd 密码
     * @return array|false|null|\PDOStatement|string|Model登录成功后返回用户信息对象
     */
    public function loginWithAccount($tel,$pwd){
        $map = ["tel"=>$tel,"pwd"=>md5($pwd)];
        $res = null;
      if($res = $this->where($map)->find()){
          //登录成功后，生成token，并保存
          $token = md5($tel . date("yy-mm-ss"));
          $res->token = $token;
          $res->save();
      }
      return $res;
    }

    public function referees(){
        return $this->hasMany("User",'referee_id',"id");
    }
}
