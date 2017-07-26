<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/7/25
 * Time: 5:43
 */

namespace Liz\WeiXinBundle\Utils;


use Doctrine\Common\Cache\FilesystemCache;
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
    private $env;

    private $token;

    private $appID;

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
     * @return string
     */
    public function getEnv()
    {
        return $this->env;
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
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getAppID()
    {
        return $this->appID;
    }

    /**
     * @return mixed
     */
    public function getAppSecret()
    {
        return $this->appSecret;
    }

    public function __construct(TranslatorInterface $translator, $env, $cacheDir,
                                $token, $appID, $appSecret)
    {
        $this->translator = $translator;
        $this->env = $env;
        $this->cache = new FilesystemCache($cacheDir."/liz_wx");
    }

    public function trans($message, array $params = array())
    {
        return $this->translator->trans($message, $params, 'LizWeiXinBundle');
    }


    protected function cacheAccessTokenKey(){
        return md5("{$this->getAppID()}_{$this->getAppSecret()}");
    }

    public function saveAccessToken($body){
        $this->getCache()->save(
            $this->cacheAccessTokenKey(), $body['access_token'],
            $body["expires_in"] - 200
        );
    }

    /**
     * 获取当前token
     * @return false|mixed
     */
    public function getAccessToken(){
        return $this->getCache()->fetch($this->cacheAccessTokenKey());
    }

    public function dump($var){
        if($this->env!='prod'){
            dump($var);
        }
    }

}