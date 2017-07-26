<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/7/25
 * Time: 15:56
 */

namespace Liz\WeiXinBundle\Entity;


class ViewButton extends MenuButton
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function __construct($type="view")
    {
        parent::__construct($type);
    }

    public function toArray()
    {
        $menu = parent::toArray();
        $menu["url"] = $this->getUrl();
        return $menu;
    }

}