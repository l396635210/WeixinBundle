<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/7/27
 * Time: 5:59
 */

namespace Liz\WeiXinBundle\Entity;

class CommonMsg extends ReceiveMsg
{
    private static $typeText = "text";
    public function isText(){
        return strtolower($this->getType()) == self::$typeText;
    }

    private static $typeImage = "image";
    public function isImage(){
        return strtolower($this->getType()) == self::$typeImage;
    }
    private static $typeVoice = "voice";
    public function isVoice(){
        return strtolower($this->getType()) == self::$typeVoice;
    }

    private static $typeVideo = "video";
    public function isVideo(){
        return strtolower($this->getType()) == self::$typeVideo;
    }

    private static $typeShortVideo = "shortvideo";
    public function isShortVideo(){
        return strtolower($this->getType()) == self::$typeShortVideo;
    }

    private static $typeLocation = "location";
    public function isLocation(){
        return strtolower($this->getType()) == self::$typeLocation;
    }

    private static $typeLink      = "link";
    public function isLink(){
        return strtolower($this->getType()) == self::$typeLink;
    }

}