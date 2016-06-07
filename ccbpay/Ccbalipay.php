<?php
/*
 * @param auther: feyeen Date: 2016/4/13 Time: 17:50
 * @param Ccbalipay.php
 */

namespace ccb\ccbpay;


use Yii;
use ccb\ccbpay\ccbConfig;

class Ccbalipay{

    public $ccb_config = [];                     //付款配置

    public function __construct($config){

        $default_config = (new ccbConfig)->getAliconfig();
        $this->ccb_config = array_merge($default_config,$config);
        
    }

    //返回跳转
    public function buildRequestForm(){
        
        $sHtml = '<!DOCTYPE HTML><html><head><meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $sHtml .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        $sHtml .='<title>支付</title></head><body>';
        $sHtml .= '<form action="" method="post" name="MD5form" id="MD5form">';

        foreach($this->ccb_config as $key=>$val){
            $sHtml .= '<input name="'.$key.'" type="hidden"  id="'.$key.'" value="'.$val.'"/>';
        }
        $sHtml .= '<script type="text/javascript" src= "'.Yii::getAlias('@static').'/ccb/md5.js"></script>';
        $sHtml .= '<script type="text/javascript" src= "'.Yii::getAlias('@static').'/ccb/pay.js"></script>';
        $sHtml .= '<script type="text/javascript">';
        $sHtml .= 'var flag = make();';
        $sHtml .= 'if(flag) {go(window.MD5form.result.value);}';
        $sHtml .= '</script>';
        $sHtml .='</body></html>';
        
        return $sHtml;
    }

    //socket 验证方法
    public static function variSocket($address, $service_port, $send_data){

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        if ($socket < 0) {
            return "socket创建失败，原因是：".socket_strerror($socket);
        }

        $result = socket_connect($socket, $address, $service_port);
        if ($result < 0) {
            return "SOCKET连接失败原因:(".$result.")".socket_strerror($result);
        }

        $in = $send_data;
        $out = '';

        socket_write($socket, $in, strlen($in));
        while ($value = socket_read($socket, 2048)) {
            $out = $value;
        }
        socket_close($socket);
        $arr = explode("|", $out);

        if(empty($arr)) {
            return "数据出错";
        }

        return $arr;
    }
}