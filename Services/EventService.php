<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/7/25
 * Time: 17:57
 */

namespace Liz\WeiXinBundle\Services;


use GuzzleHttp\Client;
use Liz\WeiXinBundle\Traits\Interaction;
use Liz\WeiXinBundle\Utils\Tool;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class EventService
{
    use Interaction;

    private $base;

    public function __construct(BaseService $baseService, Tool $tool, RequestStack $requestStack)
    {
        $this->base = $baseService;
        $this->tool = $tool;
        $this->httpClient = new Client();
        $this->request = $requestStack->getCurrentRequest();
    }

    public function subscribe(){
        $content = $this->getRequest()->getContent();
        dump($content);
    }
}