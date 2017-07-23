<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/7/23
 * Time: 21:48
 */

namespace Liz\WeiXinBundle\Services;


use Doctrine\Common\Cache\FilesystemCache;
use GuzzleHttp\Client;
use Liz\WeiXinBundle\Traits\ApiUrl;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Exception\ValidatorException;

class BaseService
{
    use ApiUrl;
    /**
     * @var string
     */
    private $token;

    private $appID;

    private $appSecret;

    private $cache;

    private $cacheDir;

    /**
     * @var null|\Symfony\Component\HttpFoundation\Request
     */
    private $request;

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

    /**
     * @return string
     */
    protected function getToken()
    {
        return $this->token;
    }

    /**
     * @return FilesystemCache
     */
    protected function getCache()
    {
        return $this->cache;
    }

    /**
     * @return string
     */
    protected function getCacheDir()
    {
        return $this->cacheDir;
    }

    /**
     * @return null|\Symfony\Component\HttpFoundation\Request
     */
    protected function getRequest()
    {
        return $this->request;
    }

    public function cacheAccessTokenKey(){
        return md5("{$this->getAppID()}_{$this->getAppSecret()}");
    }

    public function __construct($token, $appID, $appSecret, $cacheDir, RequestStack $requestStack)
    {
        $this->token = $token;
        $this->request = $requestStack->getCurrentRequest();
        $this->appID = $appID;
        $this->appSecret = $appSecret;
        $this->cacheDir = $cacheDir."/liz_wx";
        $this->cache = new FilesystemCache($this->getCacheDir());
    }

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
        throw $this->baseException("token valid fail, check config liz_wx: base: token value");
    }

    public function getAccessToken(){
        return $this->getCache()->fetch($this->cacheAccessTokenKey());
    }

    protected function requestAPICallBack(ResponseInterface $res, callable $callback){
        $body = \GuzzleHttp\json_decode($res->getBody()->getContents(),true);
        if(!isset($body["errcode"])){
            return call_user_func($callback, $body);
        }
        throw $this->baseException($body["errmsg"]);
    }

    public function updateAccessToken(){
        $client = new Client();
        $res = $client->request("get",
            $this->getApiUrl(self::$accessTokenForService)
        );
        $this->requestAPICallBack($res, function ($body){
            $this->getCache()->save(
                $this->cacheAccessTokenKey(), $body['access_token'],
                $body["expires_in"] - 200
            );
        });
    }

    public function fetchWeiXinServerIP(){
        $client = new Client();
        $res = $client->request("get",
            $this->getApiUrl(self::$weiXinServerIPForService)
        );
        $body = \GuzzleHttp\json_decode($res->getBody()->getContents(),true);
        if(!isset($body["errcode"])){
            return $body["ip_list"];
        }
        throw $this->baseException($body["errmsg"]);
    }

    public function baseException($e){
        return new ValidatorException($e);
    }
}