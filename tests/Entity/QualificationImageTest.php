<?php

namespace WechatStoreBundle\Tests\Entity;

use WechatStoreBundle\Entity\QualificationImage;

class QualificationImageTest extends AbstractEntityTest
{
    protected function getEntityClass(): string
    {
        return QualificationImage::class;
    }
    
    /**
     * 额外测试 - 特定于 QualificationImage 实体的测试用例可以在这里添加
     */
} 