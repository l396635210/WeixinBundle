<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/7/25
 * Time: 16:04
 */

namespace Liz\WeiXinBundle\Entity;


use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;

class MediaButton extends MenuButton
{

    protected $mediaId;

    protected static $mediaTypes = [
        "media_id" => "media_id",
        "view_limited" => "view_limited",
    ];

    public function __construct($type="media_id")
    {
        parent::__construct($type);
    }

    /**
     * @return mixed
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

    /**
     * @param mixed $mediaId
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;
    }

    /**
     * @return array
     */
    public static function getMediaTypes()
    {
        return self::$mediaTypes;
    }

    /**
     * @param array $mediaTypes
     */
    public static function setMediaTypes($mediaTypes)
    {
        self::$mediaTypes = $mediaTypes;
    }

    public function setType($type)
    {
        if(in_array($type, self::getMediaTypes())){
            $this->type = $type;
        }else{
            $types = implode(",",self::getMediaTypes());
            throw new ParameterNotFoundException("click type not in [{$types}]");
        }
        return $this;
    }
}