<?php

declare(strict_types=1);

namespace WechatStoreBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use WechatStoreBundle\Entity\QualificationImage;

/**
 * 资质形象管理控制器
 */
#[AdminCrud(routePath: '/wechat-store/qualification-image', routeName: 'wechat_store_qualification_image')]
final class QualificationImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return QualificationImage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->onlyOnIndex(),

            TextField::new('title', '标题')
                ->setRequired(true),

            TextField::new('imagePath', '图片路径')
                ->setRequired(true),

            IntegerField::new('sortOrder', '排序')
                ->setHelp('数字越小越靠前'),

            BooleanField::new('status', '状态')
                ->renderAsSwitch(false),

            DateTimeField::new('createTime', '创建时间')
                ->setFormat('yyyy-MM-dd HH:mm:ss')
                ->hideOnForm(),

            DateTimeField::new('updateTime', '更新时间')
                ->setFormat('yyyy-MM-dd HH:mm:ss')
                ->hideOnForm(),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('title')
            ->add('status')
            ->add('createTime')
            ->add('updateTime')
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('资质形象')
            ->setEntityLabelInPlural('资质形象')
            ->setPageTitle('index', '资质形象管理')
            ->setPageTitle('new', '新增资质形象')
            ->setPageTitle('edit', '编辑资质形象')
            ->setPageTitle('detail', '资质形象详情')
        ;
    }
}
