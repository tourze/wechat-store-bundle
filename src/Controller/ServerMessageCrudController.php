<?php

declare(strict_types=1);

namespace WechatStoreBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use WechatStoreBundle\Entity\ServerMessage;

/**
 * 服务器消息管理控制器
 */
#[AdminCrud(routePath: '/wechat-store/server-message', routeName: 'wechat_store_server_message')]
final class ServerMessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ServerMessage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),

            TextField::new('type', '消息类型')
                ->setRequired(true)
                ->setHelp('消息的类型标识，最大50个字符')
                ->setMaxLength(50),

            TextareaField::new('content', '消息内容')
                ->setRequired(true)
                ->setHelp('消息的具体内容')
                ->setMaxLength(65535),

            UrlField::new('mediaUrl', '媒体URL')
                ->setRequired(false)
                ->setHelp('媒体文件的访问链接，最大500个字符'),

            TextField::new('mediaId', '媒体ID')
                ->setRequired(false)
                ->setHelp('媒体文件的标识符，最大100个字符')
                ->setMaxLength(100),

            TextField::new('mediaMd5', '媒体MD5')
                ->setRequired(false)
                ->setHelp('媒体文件的MD5校验值，32位十六进制字符串')
                ->setMaxLength(32),

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
            ->add('type')
            ->add('mediaId')
            ->add('createTime')
            ->add('updateTime')
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('服务器消息')
            ->setEntityLabelInPlural('服务器消息')
            ->setPageTitle('index', '服务器消息管理')
            ->setPageTitle('new', '新增服务器消息')
            ->setPageTitle('edit', '编辑服务器消息')
            ->setPageTitle('detail', '服务器消息详情')
        ;
    }
}
