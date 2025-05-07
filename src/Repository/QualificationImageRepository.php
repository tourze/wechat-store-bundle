<?php

namespace WechatStoreBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use WechatStoreBundle\Entity\QualificationImage;

/**
 * @method QualificationImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method QualificationImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method QualificationImage[]    findAll()
 * @method QualificationImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QualificationImageRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QualificationImage::class);
    }
}
