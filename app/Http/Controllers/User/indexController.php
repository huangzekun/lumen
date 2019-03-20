<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class indexController extends Controller
{
    public $hash_token = 'user:login:';
    public function login(Request $request){
        $uid=$request->input('u');
        //生成token
        $token = substr(md5(time() + $uid + rand(1000,9999)),10,20);
        if(1){
            $key=$this->hash_token.$uid;
            Redis::hSet($key,'token',$token);
            Redis::expire($key,60*60*24*7);
            $response = [
                'errno'     =>  0,
                'token'     =>  $token
            ];
        }else{
            //TODO
        }
        return $response;
    }
    public function uCenter(Request $request){
        $uid=$request->input('uid');
        //print_r($_SERVER);exit;
        if(!empty($_SERVER['HTTP_TOKEN'])){
            $http_token = $_SERVER['HTTP_TOKEN'];
            $key = $this->hash_token . $uid;
            $token = Redis::hGet($key,'token');
            if($token == $http_token){
                $response = [
                    'errno'     =>  0,
                    'msg'       =>  'ok'
                ];
            }else{
                $response = [
                    'errno'     =>  50001,
                    'msg'       =>  'invalid token'
                ];
            }
        }else{
            $response = [
                'errno'     =>  50000,
                'msg'       =>  'not find token'
            ];
        }
        return $response;
    }

    /**
     * 防刷
     */
    public function fangshua(){
        echo 1;
    }
    //curl测试
    public function curl1(Request $request){
        $data=$request->input('en');
        $t=$request->input('t');
        $key="pas";
        $iv=substr(md5($t),6,16);
        $en=openssl_decrypt($data,'AES-128-CBC',$key,OPENSSL_RAW_DATA,$iv);
        //echo $en;exit;
        $nuw=time();
        $iv2=substr(md5($nuw),6,16);
        $vn=openssl_encrypt($en,'AES-128-CBC',$key,OPENSSL_RAW_DATA,$iv2);
        $data=[
            'vn'=>base64_encode($vn),
            'nuw'=>$nuw
        ];
        return $data;
    }

    public function sign2(Request $request){
        $sign=$request->input('sign');
        $data=$request->input('data');
        $t=$request->input('t');

        $pubKey = file_get_contents('./key/pr.key');
        $res = openssl_get_publickey($pubKey);
        ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');
        $result = openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_SHA256);
        openssl_free_key($res);
        if($result===1){
            $key="pas";
            $iv=substr(md5($t),6,16);
            $en=openssl_decrypt($data,'AES-128-CBC',$key,OPENSSL_RAW_DATA,$iv);
            return '成功';
        }
    }

     public   function fbnq($n){
            if($n <= 0) return 0;
            if($n == 1 || $n == 2) return 1;
            return $this->fbnq($n - 1) + $this->fbnq($n - 2);
     }

    public function hb_2(){
        if($_POST){
            $data=[
                'error'=>0,
                'msg'=>'OK'
            ];
        }else{
            $data=[
                'error'=>1000,
                'msg'=>'no'
            ];
        }
        return $data;
    }

}