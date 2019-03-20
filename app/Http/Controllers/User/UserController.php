<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class UserController extends Controller
{
    protected $redis_key="user_token";
    public function test(){
        echo __METHOD__;
    }

    public function userLogin(Request $request){
        $username=$request->input('u');
        $pass=$request->input('p');
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
        echo __METHOD__;
    }

    /**
     *
     */
    public function vip(){
        print_r($_SERVER['HTTP_TOKEN']);
        echo '</br>';
        $uid=1000;
        $key=$this->redis_key.$uid;
        $token=Redis::hget($key,'token');
        echo $token;
        if($_SERVER['HTTP_TOKEN']==$token){
            echo "登录成功";
        }else{
            echo "FAIL";
        }

    }

    public function encryption(Request $request){
        $msg = file_get_contents("php://input");
        $EncodingAESKey='Acdds123lkJKKwsla123lkj25nfwi183549kjdjk2iH';
        $AESKey =base64_decode($EncodingAESKey).'=';
        echo $AESKey;die;
//        $msg_encrypt = Base64_Encode( AES_Encrypt[ random(16) + msg_len(4) + $msg + ] );


    }






}

