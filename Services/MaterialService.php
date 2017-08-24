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
     * 新增永久图文素材
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
     * 新增除图文外其他永久素材, 新增永久视频素材需要传入$description参数
     * @param array $file 文件信息
     * @param string $type 素材类型：image，voice，video，thumb
     * @param array|null $description
     * @return mixed|array
     */
    public function addMaterial(array $file, $type, array $description=null){
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

    /**
     * 获取永久素材
     * @param string $mediaId
     * @return array|mixed
     */
    public function get($mediaId){
        return $this->httpJsonPost($this->getGetMaterialAPI(),
            ['media_id'=>$mediaId,],
            function ($body){
            dump($body);
                return $body;
        });
    }
}