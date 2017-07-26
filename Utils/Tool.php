<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/7/25
 * Time: 5:43
 */

namespace Liz\WeiXinBundle\Utils;


use Doctrine\Common\Cache\FilesystemCache;
use Symfony\Component\HttpKernel\KernelInterface;
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


    public function dump($var){
        if($this->getKernel()->getEnvironment()!='prod'){
            dump($var);
        }
    }

}