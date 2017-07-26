<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/7/25
 * Time: 17:57
 */

namespace Liz\WeiXinBundle\Services;


use GuzzleHttp\Client;
use Liz\WeiXinBundle\Entity\CommonMg;
use Liz\WeiXinBundle\Entity\CommonMsg;
use Liz\WeiXinBundle\Traits\Interaction;
use Liz\WeiXinBundle\Utils\Tool;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Translation\TranslatorInterface;

class EventService
{
    use Interaction;

    private $base;

    public function __construct(BaseService $base, KernelInterface $kernel,
                                RequestStack $requestStack, TranslatorInterface $translator)
    {
        $this->base = $base;
        $this->tool = new Tool($translator, $kernel);
        $this->httpClient = new Client();
        $this->request = $requestStack->getCurrentRequest();
    }

    public function subscribe(){
        $content = $this->getRequest()->getContent();
        dump($content);
    }

    public function receiveMsg(){
        $xmlEncoder = new XmlEncoder();
        $content = $this->getRequest()->getContent();
        $data = $xmlEncoder->decode($content,'array');
        return new CommonMsg($data);
    }
}