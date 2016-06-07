<?php
/*
 * @param auther: feyeen Date: 2016/4/13 Time: 18:24
 * @param ccbConfig.php
 */

namespace ccb\ccbpay;

use Yii;
class CcbConfig {

    private $ccb_config = [];

    public function __construct() {
        
        //建行配置文件初始化
        $this->ccb_config['MERCHANTID'] = Yii::$app->params['ccb']['MERCHANTID'];
        $this->ccb_config['POSID']    = Yii::$app->params['ccb']['POSID'];
        $this->ccb_config['BRANCHID'] = Yii::$app->params['ccb']['BRANCHID'];
        $this->ccb_config['CURCODE']  = Yii::$app->params['ccb']['CURCODE'];
        $this->ccb_config['TXCODE']  = Yii::$app->params['ccb']['TXCODE'];
        $this->ccb_config['PUB32TR2']  = Yii::$app->params['ccb']['PUB32TR2'];
    }

    public function getAliconfig() {
        return $this->ccb_config;
    }

}