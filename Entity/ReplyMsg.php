<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/7/29
 * Time: 5:36
 */

namespace Liz\WeiXinBundle\Entity;


class ReplyMsg
{
    protected $toUserName;

    protected $fromUserName;

    protected $createTime;

    protected $data;

    protected $msgType;

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMsgType()
    {
        return $this->msgType;
    }

    /**
     * @param mixed $msgType
     */
    public function setMsgType($msgType)
    {
        $this->msgType = $msgType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getToUserName()
    {
        return $this->toUserName;
    }

    /**
     * @return mixed
     */
    public function getFromUserName()
    {
        return $this->fromUserName;
    }

    /**
     * @return int
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    public function __construct(ReceiveMsg $receiveMsg)
    {
        $receiveMsgData = $receiveMsg->getData();
        $this->createTime = (new \DateTime())->getTimestamp();
        $this->toUserName = $receiveMsgData['FromUserName'];
        $this->fromUserName = $receiveMsgData['ToUserName'];
    }

}