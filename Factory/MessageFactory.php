<?php
/**
 * Created by PhpStorm.
 * User: yu
 * Date: 2017/7/29
 * Time: 4:03
 */

namespace Liz\WeiXinBundle\Factory;


use Liz\WeiXinBundle\Entity\CommonMsg;
use Liz\WeiXinBundle\Entity\EventMsg;

class MessageFactory
{
    public static function createReceiveMessage($data){
        if(strtolower($data['MsgType'])=='event'){
            return new EventMsg($data);
        }else{
            return new CommonMsg($data);
        }
    }

}