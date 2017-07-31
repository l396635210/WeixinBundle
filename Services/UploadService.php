<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/7/31
 * Time: 11:43
 */

namespace Liz\WeiXinBundle\Services;


use GuzzleHttp\Client;
use Liz\WeiXinBundle\Traits\Interaction;
use Liz\WeiXinBundle\Utils\Tool;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Translation\TranslatorInterface;

class UploadService
{
    use Interaction;

    public function __construct(BaseService $base, KernelInterface $kernel,
                                RequestStack $requestStack, TranslatorInterface $translator)
    {
        $this->base = $base;
        $this->tool = new Tool($translator, $kernel);
        $this->httpClient = new Client();
    }
}