<?php

declare(strict_types=1);

namespace WechatStoreBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use WechatStoreBundle\Entity\FreightTemplate;

/**
 * 运费模板管理控制器
 */
#[AdminCrud(routePath: '/wechat-store/freight-template', routeName: 'wechat_store_freight_template')]
final class FreightTemplateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FreightTemplate::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),

            TextField::new('name', '模板名称')
                ->setMaxLength(100)
                ->setRequired(true),

            ChoiceField::new('type', '计费方式')
                ->setChoices([
                    '按重量' => 'weight',
                    '按件数' => 'count',
                    '按体积' => 'volume'
                ])
                ->setRequired(true),

            MoneyField::new('price', '价格')
                ->setCurrency('CNY')
                ->setStoredAsCents(true)
                ->setRequired(true),

            MoneyField::new('freeAmount', '免运费金额')
                ->setCurrency('CNY')
                ->setStoredAsCents(true)
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
            ->add('type')
            ->add('status')
            ->add('createTime')
            ->add('updateTime')
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('运费模板')
            ->setEntityLabelInPlural('运费模板')
            ->setPageTitle('index', '运费模板管理')
            ->setPageTitle('new', '新增运费模板')
            ->setPageTitle('edit', '编辑运费模板')
            ->setPageTitle('detail', '运费模板详情')
        ;
    }
}
