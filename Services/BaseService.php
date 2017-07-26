<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/7/23
 * Time: 21:48
 */

namespace Liz\WeiXinBundle\Services;


use GuzzleHttp\Client;
use Liz\WeiXinBundle\Traits\ApiUrl;
use Liz\WeiXinBundle\Traits\Interaction;
use Liz\WeiXinBundle\Utils\Tool;
use Symfony\Component\HttpFoundation\RequestStack;

class BaseService
{
    use Interaction;
    /**
     * @var string
     */
    private $token;

    private $appID;

    private $appSecret;


    /**
     * @return mixed
     */
    protected function getAppID()
    {
        return $this->appID;
    }

    /**
     * @return mixed
     */
    protected function getAppSecret()
    {
        return $this->appSecret;
    }


    public function __construct($token, $appID, $appSecret, $cacheDir,
                                RequestStack $requestStack, Tool $tool)
    {
        $this->token = $token;
        $this->request = $requestStack->getCurrentRequest();
        $this->appID = $appID;
        $this->appSecret = $appSecret;
        $this->tool = $tool;
        $this->httpClient = new Client();
    }

    /**
     * 接口配置
     * @return mixed| "success" or throw
     */
    public function start(){
        $request = $this->getRequest();
        $timestamp = $request->query->get('timestamp');
        $nonce = $request->query->get('nonce');
        $array = [ $this->token, $timestamp, $nonce,];
        sort($array, SORT_STRING);
        $sign = sha1(implode("",$array));
        if($sign==$request->query->get('signature')){
            return  $request->query->get('echostr');
        }
        throw $this->exception("token valid fail, check config liz_wx: base: token value");
    }



    public function updateAccessToken(){
        $res = $this->httpClient->request("get",
            $this->getFetchAccessTokenAPI()
        );
        return $this->requestAPICallBack($res, function ($body){
            $this->getTool()->saveAccessToken($body);
            return $body;
        });
    }

    /**
     * @return mixed
     */
    public function fetchWeiXinServerIP(){
        $res = $this->httpClient->request("get",
            $this->getWeiXinServerIpAPI()
        );
        return $this->requestAPICallBack($res, function ($body){
            return $body["ip_list"];
        });
    }

}