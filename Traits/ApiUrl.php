<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/7/24
 * Time: 6:09
 */

namespace Liz\WeiXinBundle\Traits;


trait ApiUrl
{
    private static $baseWeiXinApi = "https://api.weixin.qq.com/cgi-bin/";

    protected static $accessTokenForService = 0;

    protected static $weiXinServerIPForService = 1;

    protected function getApiUrl($what){
        $url = self::$baseWeiXinApi;
        switch ($what){
            case self::$accessTokenForService:
                $url = self::$baseWeiXinApi."token?grant_type=client_credential&appid={$this->getAppID()}&secret={$this->getAppSecret()}";
                break;
            case self::$weiXinServerIPForService:
                dump($this->getAccessToken());
                $url = self::$baseWeiXinApi."getcallbackip?access_token={$this->getAccessToken()}";
                break;
        }
        return $url;
    }
}