<?php

namespace WechatStoreBundle\Tests\Repository;

use PHPUnit\Framework\TestCase;

class QualificationImageRepositoryTest extends TestCase
{
    public function testRepositoryConstruction(): void
    {
        $registry = $this->createMock(\Doctrine\Persistence\ManagerRegistry::class);
        $entityManager = $this->createMock(\Doctrine\ORM\EntityManagerInterface::class);
        $classMetadata = $this->createMock(\Doctrine\ORM\Mapping\ClassMetadata::class);
        
        $registry->method('getManagerForClass')
            ->with(\WechatStoreBundle\Entity\QualificationImage::class)
            ->willReturn($entityManager);
            
        $entityManager->method('getClassMetadata')
            ->with(\WechatStoreBundle\Entity\QualificationImage::class)
            ->willReturn($classMetadata);
        
        $repository = new \WechatStoreBundle\Repository\QualificationImageRepository($registry);
        
        $this->assertInstanceOf(\WechatStoreBundle\Repository\QualificationImageRepository::class, $repository);
    }
} 