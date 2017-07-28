<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/7/25
 * Time: 11:46
 */

namespace Liz\WeiXinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Liz\WeiXinBundle\Utils\Tool;

abstract class MenuButton
{

    /**
     * @var MenuButton
     * @ORM\ManyToOne(targetEntity="Liz\WeiXinBundle\Entity\MediaButton", inversedBy="subButtons")
     */
    protected $parentButton;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|MenuButton
     * @ORM\OneToMany(targetEntity="Liz\WeiXinBundle\Entity\MediaButton", mappedBy="parentButton")
     */
    protected $subButtons;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=30, options={"fixed":true,"comments":"按钮名称"})
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=30, options={"fixed":true, "comments":""})
     */
    protected $type;

    public function __construct($type=null)
    {
        $this->subButtons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setType($type);
    }

    /**
     * @return MenuButton
     */
    public function getParentButton()
    {
        return $this->parentButton;
    }

    /**
     * @param $parentButton
     * @return $this
     */
    public function setParentButton($parentButton)
    {
        $this->parentButton = $parentButton;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|MenuButton[]
     */
    public function getSubButtons()
    {
        return $this->subButtons;
    }


    public function addSubButton(MenuButton $button)
    {
        $this->subButtons[] = $button;
        return $this;
    }

    public function removeSubButton(MenuButton $button)
    {
        $this->subButtons->removeElement($button);
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    protected function toArray(){
        $menu = [
            "type" => $this->getType(),
            "name" => $this->getName(),
        ];
        foreach ($this->getSubButtons() as $subButton){
            $menu["sub_button"][] = $subButton->toArray();
        }
        return $menu;
    }

    /**
     * @param string $format|string ["arr","array", "xml", "json", "object", "obj"]
     * @return array|string|\Symfony\Component\Serializer\Encoder\scalar
     */
    public function serialize($format="arr"){
        return Tool::serialize($format, $this->toArray());
    }
}