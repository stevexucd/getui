<?php

namespace stevexu\getui;

header("Content-Type: text/html; charset=utf-8");

require_once(dirname(__FILE__) . '/sdk/' . 'IGt.Push.php');
require_once(dirname(__FILE__) . '/sdk/' . 'igetui/IGt.AppMessage.php');
require_once(dirname(__FILE__) . '/sdk/' . 'igetui/IGt.APNPayload.php');
require_once(dirname(__FILE__) . '/sdk/' . 'igetui/template/IGt.BaseTemplate.php');
require_once(dirname(__FILE__) . '/sdk/' . 'IGt.Batch.php');
require_once(dirname(__FILE__) . '/sdk/' . 'igetui/utils/AppConditions.php');

/**
 * GeTui
 */
class Getui extends \yii\base\Component
{
	public $appkey = 'O5PguC6iF87hQuqtH684x5';
	public $appid = 'gQhzVAmCXm8Rg62Y39HKT5';
	public $mastersecret = 'zx3DyVD0JW7iqhJEuYXlMA';
	public $host = 'http://sdk.open.api.igexin.com/apiex.htm';
	public $logo = "http://wwww.igetui.com/logo.png";
    
    public function sendToAppList($apps, $msg){
    	$igt = new \IGeTui($this->host, $this->appkey, $this->mastersecret);
    	$template = $this->IGtNotificationTemplateDemo($msg);
    	
    	$message = new \IGtListMessage();
		$message->set_isOffline(true);
    	$message->set_offlineExpireTime(10 * 60 * 1000);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
    	$message->set_data($template);
		
    	$contentId = $igt->getContentId($message);
    	$rep = NULL;
    	$targetList = [];
    	try{
    	
    		foreach ($apps as $client){
    			$target = new \IGtTarget();
    			$target->set_appId($this->appid);
    			$target->set_clientId($client);
    			$targetList [] = $target;
    		}
    		$rep = $igt->pushMessageToList($contentId, $targetList);
    		
    	}catch (Exception $e){
    		return false;
    	}
    	
    	return ($rep['result'] == 'ok');
    }
    
    public function broadcastToApp($message){
    	$igt = new \IGeTui($this->host, $this->appkey, $this->mastersecret);
    	$template = $this->IGtNotificationTemplateDemo($message);
    	//个推信息体
    	//基于应用消息体
    	$message = new \IGtAppMessage();
    	$message->set_isOffline(true);
    	$message->set_offlineExpireTime(10 * 60 * 1000);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
    	$message->set_data($template);
    	$appIdList=array($this->appid);
    	$message->set_appIdList($appIdList);
    	$rep = $igt->pushMessageToApp($message,"任务组名");
    	
    	return ($rep['result'] == 'ok'); 
    }
    
    protected function IGtNotificationTemplateDemo($message, $title='移拉罐'){
    	$template =  new \IGtNotificationTemplate();
    	$template->set_appId($this->appid);//应用appid
    	$template->set_appkey($this->appkey);//应用appkey
    	$template->set_transmissionType(1);//透传消息类型
    	$template->set_transmissionContent("");//透传内容
    	$template->set_title($title);//通知栏标题
    	$template->set_text($message);//通知栏内容
    	$template->set_logo($this->logo);//通知栏logo
    	$template->set_isRing(true);//是否响铃
    	$template->set_isVibrate(true);//是否震动
    	$template->set_isClearable(true);//通知栏是否可清除
    	//$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
    	return $template;
    }
}
