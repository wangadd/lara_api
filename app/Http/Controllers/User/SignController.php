<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class SignController extends Controller
{
    public $aliPubKey = './key/vm_pub.key';
    public function sign()
    {
        $now=$_GET['time'];
        $pubKey = file_get_contents($this->aliPubKey);
        $res = openssl_get_publickey($pubKey);
        //调用openssl内置方法验签，返回int
        $sign=$_POST['sign'];
        $str1=$_POST['str'];
        $new_sign=base64_decode($sign);
        $result =openssl_verify($str1, $new_sign, $res, OPENSSL_ALGO_SHA256);
        openssl_free_key($res);
        $str =base64_decode($str1);
        $salt="xxxxx";
        $key = "wang";
        $iv =substr(md5($now.$salt),5,16);
        $new_str = openssl_decrypt($str, "AES-128-CBC", $key, OPENSSL_RAW_DATA, $iv);
        if ($res) {
            $response_str = "收到请求，返回数据";
            $result=openssl_encrypt($response_str, "AES-128-CBC", $key, OPENSSL_RAW_DATA, $iv);
            $response=base64_encode($result);
            $info=[
                't'=>$now,
                'str'=>$response
            ];
            echo json_encode($info);

        }
    }

    //验签
    function verify($params) {
        $sign = $params['sign'];
        $params['sign_type'] = null;
        $params['sign'] = null;

        //读取公钥文件
        $pubKey = file_get_contents($this->aliPubKey);

        $res = openssl_get_publickey($pubKey);
        ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');

        //调用openssl内置方法验签，返回bool值

        $result = (openssl_verify(json_encode($params), $sign, $res, OPENSSL_ALGO_SHA256)===1);
        openssl_free_key($res);

        return $result;
    }
}

