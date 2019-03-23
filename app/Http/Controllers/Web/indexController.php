<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class indexController extends Controller{
    public function login1(){
        $data=$_POST;
        $url="http://passport.anjingdehua.cn/login1";
        $ch=curl_init($url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        $res=curl_exec($ch);
        curl_close($ch);
        $res1=json_decode($res,true);
        return $res1;
    }
    public function mycenter(){
        $uid=$_POST['uid'];
        $token=$_POST['token'];
        if(empty($uid) || empty($token)){
            $response=[
                'error'=>40003,
                'msg'=>'非法操作'
            ];
        }else{
            $key="str:u:token:".$uid;
            $rtoken=Redis::hget($key,'app');
            if($token==$rtoken){
                $response=[
                    'error'=>0,
                    'msg'=>'ok'
                ];
            }else{
                $response=[
                    'error'=>40004,
                    'msg'=>'token无效'
                ];
            }
        }
        return $response;

    }

}