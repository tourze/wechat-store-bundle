<?php

declare(strict_types=1);

namespace WechatStoreBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use WechatStoreBundle\Entity\Product;

/**
 * 商品管理控制器
 */
#[AdminCrud(routePath: '/wechat-store/product', routeName: 'wechat_store_product')]
final class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),

            TextField::new('name', '商品名称')
                ->setMaxLength(100)
                ->setRequired(true),

            TextEditorField::new('description', '商品描述')
                ->setRequired(false),

            MoneyField::new('price', '价格')
                ->setCurrency('CNY')
                ->setStoredAsCents(true)
                ->setRequired(true),

            TextField::new('category', '分类')
                ->setMaxLength(50)
                ->setRequired(false),

            IntegerField::new('stock', '库存数量')
                ->setRequired(false),

            BooleanField::new('status', '状态')
                ->setRequired(false),

            DateTimeField::new('createTime', '创建时间')
                ->hideOnForm()
                ->setFormat('yyyy-MM-dd HH:mm:ss'),

            DateTimeField::new('updateTime', '更新时间')
                ->hideOnForm()
                ->setFormat('yyyy-MM-dd HH:mm:ss'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('category')
            ->add('status')
            ->add('createTime')
            ->add('updateTime')
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('商品')
            ->setEntityLabelInPlural('商品')
            ->setPageTitle('index', '商品管理')
            ->setPageTitle('new', '新增商品')
            ->setPageTitle('edit', '编辑商品')
            ->setPageTitle('detail', '商品详情')
        ;
    }
}
