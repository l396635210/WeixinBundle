<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/7/29
 * Time: 3:43
 */

namespace Liz\WeiXinBundle\Entity;

class EventMsg extends ReceiveMsg
{

    private static $eventSubscribe = "subscribe";
    public function isSubscribe(){
        return strtolower($this->getEvent()) == self::$eventSubscribe;
    }

    private static $eventUnSubscribe = "unsubscribe";
    public function isUnSubscribe(){
        return strtolower($this->getEvent()) == self::$eventUnSubscribe;
    }

    private static $eventScan = "scan";
    public function isScan(){
        return strtolower($this->getEvent()) == self::$eventScan;
    }

    private static $eventLocation = "location";
    public function isLocation(){
        return strtolower($this->getEvent()) == self::$eventLocation;
    }

    private static $eventClick = "click";
    public function isClick(){
        return strtolower($this->getEvent()) == self::$eventClick;
    }

    private static $eventView = "view";
    public function isView(){
        return strtolower($this->getEvent()) == self::$eventView;
    }

    private $event;

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    public function __construct($data)
    {
        parent::__construct($data);
        $this->event = $data['Event'];
    }

}