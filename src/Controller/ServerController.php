<?php

namespace WechatStoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServerController extends AbstractController
{
    #[Route(path: '/wechat-store/callback/{appId}', name: 'wechat-store-callback', methods: ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'HEAD', 'OPTIONS'])]
    public function __invoke(EventDispatcherInterface $eventDispatcher): Response
    {
        // TODO 将消息存库
        return $this->json([]);
    }
}
