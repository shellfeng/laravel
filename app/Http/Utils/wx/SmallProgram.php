<?php

namespace App\Http\Utils\wx;
/**
 * 小程序
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/6/12
 * Time: 14:48
 */
class SmallProgram
{
    private $appid   = 'wx3b61b152398b2d3f';
    private $secret  = '46df895e819014c80e57b10b9ac09a24';
    private $js_code = '';

    public function __construct($js_code, $appid = null, $secret = null)
    {
        $this->js_code = $js_code;
        $this->appid   = is_null($appid) ? $this->appid : $appid;
        $this->secret   = is_null($secret) ? $this->secret : $secret;
    }

    /**
     * 通过js_code获取openid
     */
    public function getOpenIdByJsCode ()
    {
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='. $this->appid
            .'&secret='. $this->secret
            .'&js_code='. $this->js_code
            .'&grant_type=authorization_code';
       return $this->curlSetopt($url,'get');
    }



    private function curlSetopt($url, $type = 'post', $parameter='', $parameter_type = 'array',$second = 300) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300); // 设置超时
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($parameter_type == 'json'){
            $header = [
                'Content-Type: application/json; charset=utf-8',
                'Content-Length:' . strlen($parameter),
            ];
            curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        }
        switch (strtolower($type)) {
            case 'get' :
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                break;
            case 'post':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $parameter);
                break;
            case 'put' :
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $parameter);
                break;
            case 'patch':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');

                curl_setopt($ch, CURLOPT_POSTFIELDS, $parameter);
                break;
            case 'delete':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $parameter);
                break;
        }
        $response = curl_exec($ch);
        if ($response === false) {
            throw new \Exception(sprintf("", curl_errno($ch)));
        }
        curl_close($ch);
        return $response;
    }
}