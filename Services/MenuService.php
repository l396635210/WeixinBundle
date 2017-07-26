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
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Translation\TranslatorInterface;

class MenuService
{
    use Interaction;


    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    public function __construct(BaseService $base, KernelInterface $kernel,
                                RequestStack $requestStack, TranslatorInterface $translator)
    {
        $this->base = $base;
        $this->tool = new Tool($translator, $kernel);
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