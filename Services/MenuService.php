<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/7/25
 * Time: 6:13
 */

namespace Liz\WeiXinBundle\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Liz\WeiXinBundle\Traits\Interaction;
use Liz\WeiXinBundle\Utils\Tool;

class MenuService
{
    use Interaction;

    private $baseService;

    private $httpClient;

    /**
     * @return BaseService
     */
    public function getBase()
    {
        return $this->baseService;
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    public function __construct(BaseService $base, Tool $tool)
    {
        $this->baseService = $base;
        $this->tool = $tool;
        $this->httpClient = new Client();
    }

    /**
     * @param array $data
     */
    public function create(array $data){
        $request = new Request("POST", $this->getMenuCreateAPI(), [
            'Content-type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
        ], \GuzzleHttp\json_encode($data, JSON_UNESCAPED_UNICODE));
        $res = $this->getHttpClient()
            ->send($request);
        return $this->requestAPICallBack($res, function ($body){
            return $body;
        });
    }

    public function get(){
        $res = $this->getHttpClient()->request("GET", $this->getMenuGetAPI());
        return $this->requestAPICallBack($res, function ($body){
            return $body;
        });
    }

    public function delete(){
        $res = $this->getHttpClient()->request("GET", $this->getMenuDeleteAPI());
        return $this->requestAPICallBack($res, function ($body){
            return $body;
        });
    }
}