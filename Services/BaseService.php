<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/7/23
 * Time: 21:48
 */

namespace Liz\WeiXinBundle\Services;


use GuzzleHttp\Client;
use Liz\WeiXinBundle\Traits\Interaction;
use Liz\WeiXinBundle\Utils\Tool;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Translation\TranslatorInterface;

class BaseService
{
    use Interaction;
    /**
     * @var string
     */
    private $token;

    /**
     * @var
     */
    private $appID;

    /**
     * @var
     */
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

    public function __construct($token, $appID, $appSecret, KernelInterface $kernel,
                                RequestStack $requestStack, TranslatorInterface $translator)
    {
        $this->token = $token;
        $this->request = $requestStack->getCurrentRequest();
        $this->appID = $appID;
        $this->appSecret = $appSecret;
        $this->tool = new Tool($translator, $kernel);
        $this->httpClient = new Client();
        $this->base = $this;
    }


    protected function getFetchAccessTokenAPI(){
        return self::$baseWeiXinApi."token?grant_type=client_credential&appid={$this->getAppID()}&secret={$this->getAppSecret()}";
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
        throw $this->interActionException("token valid fail, check config liz_wx: base: token value");
    }

    public function updateAccessToken(){
        $res = $this->httpClient->request("get",
            $this->getFetchAccessTokenAPI()
        );
        return $this->requestAPICallBack($res, function ($body){
            $this->saveAccessToken($body);
            return $body;
        });
    }


    protected function cacheAccessTokenKey(){
        return md5("{$this->getAppID()}_{$this->getAppSecret()}");
    }

    public function saveAccessToken($body){
        $this->getTool()->getCache()->save(
            $this->cacheAccessTokenKey(), $body['access_token'],
            $body["expires_in"] - 200
        );
        return $body;
    }

    /**
     * 获取当前token
     * @return false|mixed
     */
    public function getAccessToken(){
        return $this->getTool()->getCache()->fetch($this->cacheAccessTokenKey());
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