<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminControllerTestCase;
use WechatStoreBundle\Controller\Admin\ServerMessageCrudController;
use WechatStoreBundle\Entity\ServerMessage;

/**
 * 服务器消息管理控制器测试
 * @internal
 */
#[CoversClass(ServerMessageCrudController::class)]
#[RunTestsInSeparateProcesses]
final class ServerMessageCrudControllerTest extends AbstractEasyAdminControllerTestCase
{
    private ServerMessageCrudController $controller;

    protected function onSetUp(): void
    {
        $this->controller = new ServerMessageCrudController();
    }

    protected function getControllerService(): ServerMessageCrudController
    {
        return self::getService(ServerMessageCrudController::class);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideIndexPageHeaders(): iterable
    {
        yield 'ID' => ['ID'];
        yield 'Type' => ['消息类型'];
        yield 'Content' => ['消息内容'];
        yield 'Media URL' => ['媒体URL'];
        yield 'Media ID' => ['媒体ID'];
        yield 'Media MD5' => ['媒体MD5'];
        yield 'Created Time' => ['创建时间'];
        yield 'Updated Time' => ['更新时间'];
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideNewPageFields(): iterable
    {
        yield 'type' => ['type'];
        yield 'content' => ['content'];
        yield 'mediaUrl' => ['mediaUrl'];
        yield 'mediaId' => ['mediaId'];
        yield 'mediaMd5' => ['mediaMd5'];
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideEditPageFields(): iterable
    {
        yield 'type' => ['type'];
        yield 'content' => ['content'];
        yield 'mediaUrl' => ['mediaUrl'];
        yield 'mediaId' => ['mediaId'];
        yield 'mediaMd5' => ['mediaMd5'];
    }

    public function testEntityFqcn(): void
    {
        $this->assertSame(ServerMessage::class, ServerMessageCrudController::getEntityFqcn());
    }

    public function testControllerConfiguration(): void
    {
        $this->assertInstanceOf(ServerMessageCrudController::class, $this->controller);
        $this->assertSame(ServerMessage::class, $this->controller::getEntityFqcn());
    }

    public function testCrudConfiguration(): void
    {
        $crud = $this->controller->configureCrud(Crud::new());
        $this->assertInstanceOf(Crud::class, $crud);
    }

    public function testFiltersConfiguration(): void
    {
        $filters = $this->controller->configureFilters(Filters::new());
        $this->assertInstanceOf(Filters::class, $filters);
    }

    public function testFieldsConfiguration(): void
    {
        $fields = iterator_to_array($this->controller->configureFields('index'));
        $this->assertNotEmpty($fields);
    }

    public function testValidationErrors(): void
    {
        $client = $this->createAuthenticatedClient();

        // 访问创建页面
        $crawler = $client->request('GET', $this->generateAdminUrl('new'));
        $this->assertResponseIsSuccessful();

        // 查找表单并提交空表单
        $form = $crawler->selectButton('Create')->form();
        $crawler = $client->submit($form);

        // 验证返回状态码为422（验证错误）
        $this->assertResponseStatusCodeSame(422);

        // 验证必填字段的错误消息存在
        $errorText = $crawler->filter('.invalid-feedback, .form-error-message, .error')->text();

        // 验证 type 字段的必填错误
        $this->assertStringContainsString('should not be blank', $errorText, 'type字段应该有必填验证错误');

        // 验证 content 字段的必填错误
        $this->assertStringContainsString('should not be blank', $errorText, 'content字段应该有必填验证错误');
    }
}
