<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2018/2/10
 * Time: 1:57
 */

namespace Liz\WeiXinBundle\Services;


use GuzzleHttp\Client;
use Liz\WeiXinBundle\Traits\Interaction;
use Liz\WeiXinBundle\Utils\Tool;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Translation\TranslatorInterface;

class ShortUrlService
{
    use Interaction;

    private static $action = "long2short";

    protected function isWUrl($url){
        return strstr($url,"w.url.cn");
    }

    public function __construct(BaseService $base, KernelInterface $kernel,
                                RequestStack $requestStack, TranslatorInterface $translator)
    {
        $this->base = $base;
        $this->tool = new Tool($translator, $kernel);
        $this->httpClient = new Client();
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @param $longUrl
     * @return array|mixed 转换短地址
     */
    public function trans($longUrl){
        return $this->httpJsonPost($this->getShortUrlAPI(),[
            "long_url" => $longUrl,
            "action" => self::$action,
        ], function ($body){
            return $body;
        });
    }

    /**
     * @param $url
     * @return bool
     */
    public function verify($url){

        if(!$this->isWUrl($url)){
            $data = $this->trans($url);
            $url = $data["short_url"];
        }

        $response = $this->httpClient->get($url);
        $contents = $response->getBody()->getContents();
        return !strstr(strtolower($contents), "weixin110");
    }
}