<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/7/24
 * Time: 6:09
 */

namespace Liz\WeiXinBundle\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
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
/********************************获取api地址start************************************/
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

    protected function getMediaUploadImgAPI(){
        return self::$baseWeiXinApi."media/uploadimg?access_token={$this->getBase()->getAccessToken()}";
    }

    protected function getMediaUploadAPI($type="image"){
        return self::$baseWeiXinApi."media/upload?access_token={$this->getBase()->getAccessToken()}&type={$type}";
    }

    protected function getMaterialAddMaterialAPI($type="image"){
        return self::$baseWeiXinApi."material/add_material?access_token={$this->getBase()->getAccessToken()}&type={$type}";
    }

    protected function getMediaGetAPI($mediaID){
        return self::$baseWeiXinApi."media/get?access_token={$this->getBase()->getAccessToken()}&media_id={$mediaID}";
    }

    protected function getMaterialAddNews(){
        return self::$baseWeiXinApi."material/add_news?access_token={$this->getBase()->getAccessToken()}";
    }

    protected function getMaterialUpdateNews(){
        return self::$baseWeiXinApi."material/update_news?access_token={$this->getBase()->getAccessToken()}";
    }

    protected function getMediaUploadNewsAPI(){
        return self::$baseWeiXinApi."media/uploadnews?access_token={$this->getBase()->getAccessToken()}";
    }

    protected function getGetMaterialAPI(){
        return self::$baseWeiXinApi."material/get_material?access_token={$this->getBase()->getAccessToken()}";
    }

    protected function getDelMaterialAPI(){
        return self::$baseWeiXinApi."material/del_material?access_token={$this->getBase()->getAccessToken()}";
    }

/********************************获取api地址end************************************/
    /**
     * @param ResponseInterface $res
     * @param callable $callback
     * @return array|mixed
     */
    protected function requestAPICallBack(ResponseInterface $res, callable $callback){
        $body = $res->getBody()->getContents();
        $utf8Body = $this->getTool()->utf8Encode($body);
        if(json_decode($utf8Body)){
            $body = \GuzzleHttp\json_decode($utf8Body,true);
        }
        if(!isset($body["errcode"]) || $body["errcode"]==0){
            return call_user_func($callback, $body);
        }
        throw $this->interActionException($body);
    }

    /**
     * @param $url
     * @param array $data
     * @param callable $callback
     * @return mixed|array
     */
    protected function httpJsonPost($url, array $data, callable $callback){
        $request = new Request("POST", $url, [
            'Content-type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
        ], \GuzzleHttp\json_encode($data, JSON_UNESCAPED_UNICODE));
        $res = $this->getHttpClient()
            ->send($request);
        return $this->requestAPICallBack($res, $callback);
    }

    /**
     * @param $url
     * @param callable $callback
     * @return mixed|array
     */
    protected function httpGet($url, callable $callback){
        $res = $this->getHttpClient()->request("GET", $url);
        return $this->requestAPICallBack($res, $callback);
    }

    /**
     * @param $e
     * @return ValidatorException
     */
    protected function interActionException($e){
        if(is_array($e)){
            $errorCode = $e['errcode'];
            list($errorMsg, $errorRequest) = explode(":", $e["errmsg"]);
            $errorShow = "error_code:{$errorCode}\n"."request_id:{$errorRequest}\n".
                "error_message:{$this->getTool()->trans($errorMsg)}";
        }else{
            $errorShow = $this->getTool()->trans($e);
        }
        return new ValidatorException($errorShow);
    }


}