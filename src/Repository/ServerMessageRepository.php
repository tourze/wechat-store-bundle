<?php

namespace WechatStoreBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use WechatStoreBundle\Entity\ServerMessage;

/**
 * @method ServerMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServerMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServerMessage[]    findAll()
 * @method ServerMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServerMessageRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServerMessage::class);
    }
}
