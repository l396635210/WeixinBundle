<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/8/1
 * Time: 4:44
 */

namespace Liz\WeiXinBundle\Services;


use GuzzleHttp\Client;
use Liz\WeiXinBundle\Traits\Interaction;
use Liz\WeiXinBundle\Utils\Tool;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Translation\TranslatorInterface;

class MaterialService
{
    use Interaction;

    public function __construct(BaseService $base, KernelInterface $kernel,
                                RequestStack $requestStack, TranslatorInterface $translator)
    {
        $this->base = $base;
        $this->tool = new Tool($translator, $kernel);
        $this->httpClient = new Client();
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @param array $articles
     * @return array|mixed
     */
    public function addNews(array $articles){
        return $this->httpJsonPost($this->getMaterialAddNews(),[
            "articles" => $articles,
        ], function ($body){
            return $body;
        });
    }

    /**
     * @param array $file
     * @param $type
     * @param null $description
     * @return mixed|array
     */
    public function addMaterial(array $file, $type, $description=null){
        $res = $this->getHttpClient()->request("POST",
            $this->getMaterialAddMaterialAPI($type), [
                'multipart' => [
                    $file
                ],[
                    'description' => $description,
                ]
            ]);
        return $this->requestAPICallBack($res, function ($body){
            return $body;
        });
    }

}