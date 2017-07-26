<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/7/27
 * Time: 5:59
 */

namespace Liz\WeiXinBundle\Entity;


class CommonMsg
{

    private static $typeText = "text";
    private static $typeImage = "image";
    private static $typeVoice = "voice";
    private static $typeVideo = "video";
    private static $typeShortVideo = "shortvideo";
    private static $typeLocation = "location";
    private static $typeLink      = "link";

    private $data;

    private $type;

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    protected function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->setType($data["MsgType"]);
    }

    public function isText(){
        return strtolower($this->getType()) == self::$typeText;
    }

}