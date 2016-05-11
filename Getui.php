<?php

namespace stevexu\getui;

header("Content-Type: text/html; charset=utf-8");

require_once(dirname(__FILE__) . '/sdk/' . 'IGt.Push.php');
require_once(dirname(__FILE__) . '/sdk/' . 'igetui/IGt.AppMessage.php');
require_once(dirname(__FILE__) . '/sdk/' . 'igetui/IGt.APNPayload.php');
require_once(dirname(__FILE__) . '/sdk/' . 'igetui/template/IGt.BaseTemplate.php');
require_once(dirname(__FILE__) . '/sdk/' . 'IGt.Batch.php');
require_once(dirname(__FILE__) . '/sdk/' . 'igetui/utils/AppConditions.php');

//http的域名
//define('HOST','http://sdk.open.api.igexin.com/apiex.htm');

//https的域名
//define('HOST','https://api.getui.com/apiex.htm');
 
// define('APPKEY','O5PguC6iF87hQuqtH684x5');
// define('APPID','gQhzVAmCXm8Rg62Y39HKT5');
// define('MASTERSECRET','zx3DyVD0JW7iqhJEuYXlMA');

/**
 * This is just an example.
 */
class Getui extends \yii\base\Component
{
	public $appkey = 'O5PguC6iF87hQuqtH684x5';
	public $appid = 'gQhzVAmCXm8Rg62Y39HKT5';
	public $mastersecret = 'zx3DyVD0JW7iqhJEuYXlMA';
	public $host = 'http://sdk.open.api.igexin.com/apiex.htm';
	
    public function run()
    {
    	$igt = new \IGeTui($this->host, $this->appkey, $this->mastersecret);
    	$template = $this->IGtNotificationTemplateDemo();
    	//$template = IGtLinkTemplateDemo();
    	//个推信息体
    	//基于应用消息体
    	$message = new \IGtAppMessage();
    	$message->set_isOffline(true);
    	$message->set_offlineExpireTime(10 * 60 * 1000);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
    	$message->set_data($template);
    	
    	$appIdList=array($this->appid);
    	$phoneTypeList=array('ANDROID');
    	$provinceList=array('浙江');
    	$tagList=array('haha');

    	$message->set_appIdList($appIdList);
    	$rep = $igt->pushMessageToApp($message,"任务组名");
    	
//     	var_dump($rep);
//     	echo ("<br><br>");
        return "Hello!".$rep;
    }
    
    protected function IGtNotificationTemplateDemo(){
    	$template =  new \IGtNotificationTemplate();
    	$template->set_appId($this->appid);//应用appid
    	$template->set_appkey($this->appkey);//应用appkey
    	$template->set_transmissionType(1);//透传消息类型
    	$template->set_transmissionContent("测试离线");//透传内容
    	$template->set_title("个推");//通知栏标题
    	$template->set_text("个推最新版点击下载");//通知栏内容
    	$template->set_logo("http://wwww.igetui.com/logo.png");//通知栏logo
    	$template->set_isRing(true);//是否响铃
    	$template->set_isVibrate(true);//是否震动
    	$template->set_isClearable(true);//通知栏是否可清除
    	//$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
    	//iOS推送需要设置的pushInfo字段
    	//        $apn = new IGtAPNPayload();
    	//        $apn->alertMsg = "alertMsg";
    	//        $apn->badge = 11;
    	//        $apn->actionLocKey = "启动";
    	//    //        $apn->category = "ACTIONABLE";
    	//    //        $apn->contentAvailable = 1;
    	//        $apn->locKey = "通知栏内容";
    	//        $apn->title = "通知栏标题";
    	//        $apn->titleLocArgs = array("titleLocArgs");
    	//        $apn->titleLocKey = "通知栏标题";
    	//        $apn->body = "body";
    	//        $apn->customMsg = array("payload"=>"payload");
    	//        $apn->launchImage = "launchImage";
    	//        $apn->locArgs = array("locArgs");
    	//
    	//        $apn->sound=("test1.wav");;
    	//        $template->set_apnInfo($apn);
    	return $template;
    }
}
