<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/7/25
 * Time: 16:28
 */

namespace Liz\WeiXinBundle\Factory;


use Liz\WeiXinBundle\Entity\ClickButton;
use Liz\WeiXinBundle\Entity\MediaButton;
use Liz\WeiXinBundle\Entity\MiniprogramButton;
use Liz\WeiXinBundle\Entity\ViewButton;

class ButtonFactory
{
    public static function createClickButton($type="click"){
        return new ClickButton($type);
    }

    public static function createMediaButton($type="media_id"){
        return new MediaButton($type);
    }

    public static function createMiniprogramButton($type="miniprogram"){
        return new MiniprogramButton($type);
    }

    public static function createViewButton($type="view"){
        return new ViewButton($type);
    }
}