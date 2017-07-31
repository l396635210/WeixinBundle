<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/7/25
 * Time: 17:57
 */

namespace Liz\WeiXinBundle\Services;


use GuzzleHttp\Client;
use Liz\WeiXinBundle\Entity\ReplyMsg;
use Liz\WeiXinBundle\Factory\MessageFactory;
use Liz\WeiXinBundle\Traits\Interaction;
use Liz\WeiXinBundle\Utils\Tool;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Translation\TranslatorInterface;

class MessageService
{
    use Interaction;

    private $receiveMsg;

    private $twig;

    public function __construct(BaseService $base, KernelInterface $kernel,
                                RequestStack $requestStack, TranslatorInterface $translator, \Twig_Environment $twig)
    {
        $this->base = $base;
        $this->getBase()->validSignature();
        $this->tool = new Tool($translator, $kernel);
        $this->httpClient = new Client();
        $this->request = $requestStack->getCurrentRequest();
        $this->twig = $twig;
    }

    /**
     * receiveMsg
     * @return \Liz\WeiXinBundle\Entity\CommonMsg|\Liz\WeiXinBundle\Entity\EventMsg
     */
    public function receiveMsg(){
        $xmlEncoder = new XmlEncoder();
        $content = $this->getRequest()->getContent();
        $data = $xmlEncoder->decode($content,'array');
        $this->receiveMsg = MessageFactory::createReceiveMessage($data);
        return $this->receiveMsg;
    }

    public function replyMsg($msgType, array $data){
        $replyMessage = new ReplyMsg($this->receiveMsg);
        $replyMessage
            ->setMsgType($msgType)
            ->setData($data);
        return $this->twig->render('@LizWeiXin/Message/reply_'.$msgType.'.xml.twig', [
            'replyMessage' => $replyMessage,
        ]);
    }
}