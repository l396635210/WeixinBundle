<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/7/25
 * Time: 15:28
 */

namespace Liz\WeiXinBundle\Entity;


use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;

class ClickButton extends MenuButton
{
    protected $key;

    const TYPE_CLICK = "click";
    const TYPE_SCANCODE_PUSH = "scancode_push";
    const TYPE_PIC_SYSPHOTO = "pic_sysphoto";
    const TYPE_PIC_PHOTO_OR_ALBUM = "pic_photo_or_album";
    const TYPE_PIC_WEIXIN = "pic_weixin";
    const TYPE_LOCATION_SELECT = "location_select";

    private static $clickTypes = [
        "click"=>"click",
        "scancode_push"=>"scancode_push",
        "pic_sysphoto"=>"pic_sysphoto",
        "pic_photo_or_album"=>"pic_photo_or_album",
        "pic_weixin"=>"pic_weixin",
        "location_select"=>"location_select"
    ];

    /**
     * @return array
     */
    public static function getClickTypes()
    {
        return self::$clickTypes;
    }

    /**
     * @param array $clickTypes
     */
    public static function setClickTypes($clickTypes)
    {
        self::$clickTypes = $clickTypes;
    }

    public function __construct($type="click")
    {
        parent::__construct($type);
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    public function setType($type)
    {
        if(in_array($type, self::getClickTypes())){
            $this->type = $type;
        }else{
            $types = implode(",",self::getClickTypes());
            throw new ParameterNotFoundException("click type not in [{$types}]");
        }
        return $this;
    }

    protected function toArray()
    {
        $menu = parent::toArray();
        $menu["key"] = $this->getKey();
        return $menu;
    }

}