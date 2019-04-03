<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    protected $redis_key="user_token";
    public function userLogin(Request $request){
        $data=$_POST;
        print_r($data);die;
        //验证用户信息

        $res=true;
        if($res){
            $uid=100;
            $str=time().$uid.rand(1111,9999);
            $token=substr(md5($str),10,20);

            //将token 存入redis
            $key=$this->redis_key.':'.$uid;
            Redis::hSet($key,'token',$token);
            Redis::expire($key,3600*24*7);
        }
    }

}

