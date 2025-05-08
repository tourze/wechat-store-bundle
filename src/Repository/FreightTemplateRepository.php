<?php

namespace WechatStoreBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use WechatStoreBundle\Entity\FreightTemplate;

/**
 * @method FreightTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method FreightTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method FreightTemplate[]    findAll()
 * @method FreightTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FreightTemplateRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FreightTemplate::class);
    }
}
