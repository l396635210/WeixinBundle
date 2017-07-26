<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/7/25
 * Time: 15:59
 */

namespace Liz\WeiXinBundle\Entity;


class MiniprogramButton extends MenuButton
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $appid;

    /**
     * @var string
     */
    protected $pagepath;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getAppid()
    {
        return $this->appid;
    }

    /**
     * @param string $appid
     */
    public function setAppid($appid)
    {
        $this->appid = $appid;
        return $this;
    }

    /**
     * @return string
     */
    public function getPagepath()
    {
        return $this->pagepath;
    }

    /**
     * @param string $pagepath
     */
    public function setPagepath($pagepath)
    {
        $this->pagepath = $pagepath;
        return $this;
    }


    public function __construct($type="miniprogram")
    {
        parent::__construct($type);
    }
}