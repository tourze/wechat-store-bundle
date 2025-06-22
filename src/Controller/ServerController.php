<?php

namespace WechatStoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServerController extends AbstractController
{
    #[Route('/wechat-store/callback/{appId}', name: 'wechat-store-callback')]
    public function __invoke(EventDispatcherInterface $eventDispatcher): Response
    {
        // TODO 将消息存库
        return $this->json([]);
    }
}
