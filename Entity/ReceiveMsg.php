<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/7/29
 * Time: 5:38
 */

namespace Liz\WeiXinBundle\Entity;


use Liz\WeiXinBundle\Utils\Tool;

abstract class ReceiveMsg
{
    protected $type;

    protected $data;


    public function getType(){
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

    public function __construct($data)
    {
        $this->data = $data;
        $this->setType($data['MsgType']);;
    }

    public function getData(){
        return $this->data;
    }

    /**
     * @param $format|string ["arr","array", "xml", "json", "object", "obj"]
     * @return array|string
     */
    public function serialize($format="arr"){
        return Tool::serialize($format, $this->getData());
    }

}