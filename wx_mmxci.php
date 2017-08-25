<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "20170802");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $msgType = $postObj->MsgType;
                $time = time();
                error_log( json_encode( $postObj ) );
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
                $imgTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Image>
                            <MediaId><![CDATA[%s]]></MediaId>
                            </Image>
                            </xml>";

                if( $msgType == 'text' ){       // 普通消息
                    $keyword = trim($postObj->Content);
                        if(!empty( $keyword )){
                            if( $keyword == '1' ){
                                    $msgType = "text";
                                    $contentStr = "hello world";
                                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                    echo $resultStr;
                            }else if( $keyword == '2' ){
                                $msgType = "image";
                                $mediaId = 'jpCIbFRXl6R6OsQBwxnZrkqX48WrT4w-e6drSiBhyQ0SBV0BeRTTPpQA9HwVcuve';
                                $resultStr = sprintf($imgTpl, $fromUsername, $toUsername, $time, $msgType, $mediaId);
                                echo $resultStr;
                            }
                        }else{
                            echo "Input something...";
                        }
                }else if( $msgType == 'event' ){    // 事件推送
                    $event = $postObj->Event;
                    if( $event == 'subscribe' ){
                        $msgType = "image";
                        $mediaId = 'jpCIbFRXl6R6OsQBwxnZrkqX48WrT4w-e6drSiBhyQ0SBV0BeRTTPpQA9HwVcuve';
                        $resultStr = sprintf($imgTpl, $fromUsername, $toUsername, $time, $msgType, $mediaId);
                        echo $resultStr;
                    }
                }

        }else {
        	echo "";
        	exit;
        }
    }

	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>
