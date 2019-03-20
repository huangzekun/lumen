<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class IllegaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request,Closure $next)
    {
        //用户uri
        $request_uri=$_SERVER['REQUEST_URI'];
        //用户ip
        $ip=$_SERVER['REMOTE_ADDR'];
        //截取  加密uri
        $hash_uri=substr(md5($request_uri),0,10);
        //redis key名
        $redis_key="str:url:".$hash_uri.",ip:".$ip;
        //存入redis
        $num = Redis::incr($redis_key);
        //设置reids存储时间
        Redis::expire($redis_key,60);
        if($num>10){
            $response = [
                'errno'     =>  50002,
                'msg'       =>  'invalid feifa!!'
            ];
            //存非法ip
            $key="str:feifa_ip";
            Redis::sAdd($key,$ip);
            Redis::expire($redis_key,600);
            return json_encode($response);
        }

        return $next($request);
    }
}