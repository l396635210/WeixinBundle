<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/7/31
 * Time: 11:43
 */

namespace Liz\WeiXinBundle\Services;


use GuzzleHttp\Client;
use Liz\WeiXinBundle\Traits\Interaction;
use Liz\WeiXinBundle\Utils\Tool;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Stream;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Translation\TranslatorInterface;

class MediaService
{

    use Interaction;

    private $localDir;

    /**
     * @return mixed
     */
    protected function getLocalDir()
    {
        return $this->localDir;
    }

    /**
     * @param mixed $localDir
     */
    protected function setLocalDir($localDir)
    {
        $this->localDir = $localDir;
    }

    public function __construct(BaseService $base, KernelInterface $kernel,
                                RequestStack $requestStack, TranslatorInterface $translator, $localDir)
    {
        $this->base = $base;
        $this->tool = new Tool($translator, $kernel);
        $this->httpClient = new Client();
        $this->request = $requestStack->getCurrentRequest();
        $this->localDir = $localDir;
    }

    /**
     * 上传图文消息内的图片获取URL，对应接口https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=ACCESS_TOKEN
     * @param array $file
     * @return mixed|array
     */
    public function uploadImg(array $file){
        $res = $this->getHttpClient()->request("POST", $this->getMediaUploadImgAPI(), [
            'multipart' => [
                $file
            ],
        ]);
        return $this->requestAPICallBack($res, function ($body){
            return $body;
        });
    }

    /**
     * 新增临时素材 对应接口https://api.weixin.qq.com/cgi-bin/media/upload?access_token=ACCESS_TOKEN&type=TYPE
     * @param array $file
     * @param null $type 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb）
     * @return mixed|array
     */
    public function upload(array $file, $type=null){
        $res = $this->getHttpClient()->request("POST",
            $this->getMediaUploadAPI($type), [
            'multipart' => [
                $file
            ],
        ]);
        return $this->requestAPICallBack($res, function ($body){
            return $body;
        });
    }

    /**
     * @param $mediaId
     * @param null $type
     * @return array|mixed|string
     */
    public function get($mediaId, $type=null){
        $url = $this->getMediaGetAPI($mediaId);
        if($type=='video'){
            return $this->httpGet($url, function ($body){
                return $body;
            });
        }
        $res = $this->getHttpClient()->request('Get', $url);
        if(!$res->getStatusCode()==200){
            throw $this->interActionException("request error");
        }
        $filesystem = new Filesystem();
        $filename = substr($res->getHeader("Content-disposition")[0], strlen('attachment; filename="'), -1);
        $filesystem->dumpFile($this->getLocalDir().'/'.$filename, $res->getBody()->getContents());
        return $this->getLocalDir().'/'.$filename;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function uploadNews(array $data){
        return $this->httpJsonPost($this->getMediaUploadNewsAPI(),
            $data,
            function ($body){
                return $body;
        });
    }
}