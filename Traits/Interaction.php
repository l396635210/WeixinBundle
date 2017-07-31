<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/7/24
 * Time: 6:09
 */

namespace Liz\WeiXinBundle\Traits;

use GuzzleHttp\Client;
use Liz\WeiXinBundle\Services\BaseService;
use Liz\WeiXinBundle\Utils\Tool;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Validator\Exception\ValidatorException;

trait Interaction
{
    private static $baseWeiXinApi = "https://api.weixin.qq.com/cgi-bin/";

    protected static $accessTokenForService = 0;

    protected static $weiXinServerIPForService = 1;

    protected static $menuCreate = 1;

    /**
     * @var Tool
     */
    private $tool;


    /**
     * @var null|\Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * @var Client
     */
    private $httpClient;


    /**
     * @var BaseService
     */
    private $base;

    /**
     * @return BaseService
     */
    protected function getBase()
    {
        return $this->base;
    }

    /**
     * @return null|\Symfony\Component\HttpFoundation\Request
     */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Client
     */
    protected function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @return Tool
     */
    protected function getTool()
    {
        return $this->tool;
    }


    protected function getWeiXinServerIpAPI(){
        return self::$baseWeiXinApi."getcallbackip?access_token={$this->getBase()->getAccessToken()}";
    }

    protected function getMenuCreateAPI(){
        return self::$baseWeiXinApi."menu/create?access_token={$this->getBase()->getAccessToken()}";
    }

    protected function getMenuGetAPI(){
        return self::$baseWeiXinApi."menu/get?access_token={$this->getBase()->getAccessToken()}";
    }

    protected function getMenuDeleteAPI(){
        return self::$baseWeiXinApi."menu/delete?access_token={$this->getBase()->getAccessToken()}";
    }

    protected function getUploadMediaAPI(){
        return self::$baseWeiXinApi."uploadimg?access_token={$this->getBase()->getAccessToken()}";
    }


    protected function requestAPICallBack(ResponseInterface $res, callable $callback){
        $body = \GuzzleHttp\json_decode($res->getBody()->getContents(),true);
        if(!isset($body["errcode"]) || $body["errcode"]==0){
            return call_user_func($callback, $body);
        }
        throw $this->interActionException($body["errmsg"]);
    }

    protected function interActionException($e){
        return new ValidatorException($this->getTool()->trans($e));
    }
}