<?php

declare(strict_types=1);

namespace WechatStoreBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use WechatStoreBundle\Entity\Category;

/**
 * 商品类别管理控制器
 */
#[AdminCrud(routePath: '/wechat-store/category', routeName: 'wechat_store_category')]
final class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->onlyOnIndex(),

            TextField::new('name', '分类名称')
                ->setRequired(true),

            TextareaField::new('description', '分类描述')
                ->hideOnIndex(),

            TextField::new('parentId', '父级分类ID')
                ->hideOnIndex(),

            IntegerField::new('sort', '排序')
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
            ->add('name')
            ->add('parentId')
            ->add('status')
            ->add('createTime')
            ->add('updateTime')
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('商品类别')
            ->setEntityLabelInPlural('商品类别')
            ->setPageTitle('index', '商品类别管理')
            ->setPageTitle('detail', '商品类别详情')
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // 禁用新增、编辑、删除操作，只保留只读操作
            ->disable(Action::NEW, Action::EDIT, Action::DELETE)
        ;
    }
}
