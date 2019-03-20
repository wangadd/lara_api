<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class BeforeMiddleware
{
    /**
     * 路由防刷
     * @return array
     */
    public function handle($request, Closure $next){
        $request_uri=$_SERVER['REQUEST_URI'];
        $uri_hash=md5($request_uri);
        $uri=substr($uri_hash,10,10);
        $ip=$_SERVER['SERVER_ADDR'];        //获取ip
        $redis_key="str:".$uri.":".$ip;     //设置计数的键名
        $num=Redis::incr($redis_key);        //加一次计数
        Redis::expire($redis_key,60);       //设置计数键名的过期时间
        //防刷逻辑判断
        if($num>20){
            $response=[
                'errcode'=>40003,
                'errmsg' =>"TOO MANY",
            ];
            Redis::expire($redis_key,600);    //重新设置键名过期时间
            $ip_key='ip';
            Redis::sAdd($ip_key,$ip);
            return  json_encode($response);
        }else{
            $response=[
                'errcode' =>0,
                'msg'      =>'ok',
                'data'    =>[
                    'aaaa'=>'bbbb'
                ],
            ];
        }

//        echo  json_encode($response);
        return $next($request);

    }
}
