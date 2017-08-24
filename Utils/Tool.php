<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/7/25
 * Time: 5:43
 */

namespace Liz\WeiXinBundle\Utils;


use Doctrine\Common\Cache\FilesystemCache;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Translation\TranslatorInterface;

class Tool
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var string
     */
    private $kernel;


    private $appSecret;

    /**
     * @var FilesystemCache
     */
    private $cache;

    /**
     * @return TranslatorInterface
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * @return string|KernelInterface
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * @return FilesystemCache
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @return mixed
     */
    public function getAppSecret()
    {
        return $this->appSecret;
    }

    public function __construct(TranslatorInterface $translator, KernelInterface $kernel)
    {
        $this->translator = $translator;
        $this->kernel = $kernel;
        $this->cache = new FilesystemCache($kernel->getCacheDir()."/liz_wx");
    }

    public function trans($message, array $params = array())
    {
        return $this->translator->trans($message, $params, 'LizWeiXinBundle');
    }

    public static function serialize($format, array $data){
        $formats = ["arr","array", "xml", "json", "object", "obj"];
        if(!in_array($format, $formats)){
            throw new ParameterNotFoundException("format should with [".implode(",",$formats)."]");
        }
        if($format=='xml'){
            $xmlEncoder = new XmlEncoder();
            $data = $xmlEncoder->encode($data, "xml");
        }elseif($format=='json'||$format=='object'||$format=='obj'){
            $isJson = $format=='json' ? true : false;
            $data = \GuzzleHttp\json_encode($data, $isJson);
        }
        return $data;
    }

    /**
     * Encode array to utf8 recursively
     * @param string|array $dat
     * @return array|string
     */
    public function utf8Encode($dat)
    {
        if (is_string($dat)){
            return utf8_encode($dat);
        }
        if (!is_array($dat)){
            return $dat;
        }
        $ret = array();
        foreach ($dat as $i => $d){
            $ret[$i] = $this->array_utf8_encode($d);
        }
        return $ret;
    }

}