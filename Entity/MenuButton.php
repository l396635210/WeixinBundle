<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/7/25
 * Time: 11:46
 */

namespace Liz\WeiXinBundle\Entity;

abstract class MenuButton
{

    /**
     * @var MenuButton
     */
    protected $parentButton;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection|MenuButton
     */
    protected $subButtons;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
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

    public function toArray(){
        $menu = [
            "type" => $this->getType(),
            "name" => $this->getName(),
        ];
        foreach ($this->getSubButtons() as $subButton){
            $menu["sub_button"][] = $subButton->toArray();
        }
        return $menu;
    }
}