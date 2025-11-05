<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminControllerTestCase;
use WechatStoreBundle\Controller\Admin\FreightTemplateCrudController;
use WechatStoreBundle\Entity\FreightTemplate;

/**
 * 运费模板管理控制器测试
 * @internal
 */
#[CoversClass(FreightTemplateCrudController::class)]
#[RunTestsInSeparateProcesses]
final class FreightTemplateCrudControllerTest extends AbstractEasyAdminControllerTestCase
{
    private FreightTemplateCrudController $controller;

    protected function afterEasyAdminSetUp(): void
    {
        $this->controller = new FreightTemplateCrudController();
    }

    protected function getControllerService(): FreightTemplateCrudController
    {
        return self::getService(FreightTemplateCrudController::class);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideIndexPageHeaders(): iterable
    {
        yield 'ID' => ['ID'];
        yield 'Name' => ['模板名称'];
        yield 'Type' => ['计费方式'];
        yield 'Price' => ['价格'];
        yield 'Free Amount' => ['免运费金额'];
        yield 'Status' => ['状态'];
        yield 'Created Time' => ['创建时间'];
        yield 'Updated Time' => ['更新时间'];
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideNewPageFields(): iterable
    {
        yield 'name' => ['name'];
        yield 'type' => ['type'];
        yield 'price' => ['price'];
        yield 'freeAmount' => ['freeAmount'];
        yield 'status' => ['status'];
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideEditPageFields(): iterable
    {
        yield 'name' => ['name'];
        yield 'type' => ['type'];
        yield 'price' => ['price'];
        yield 'freeAmount' => ['freeAmount'];
        yield 'status' => ['status'];
    }

    public function testEntityFqcn(): void
    {
        $this->assertSame(FreightTemplate::class, FreightTemplateCrudController::getEntityFqcn());
    }

    public function testControllerConfiguration(): void
    {
        $this->assertInstanceOf(FreightTemplateCrudController::class, $this->controller);
        $this->assertSame(FreightTemplate::class, $this->controller::getEntityFqcn());
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
        $url = $this->generateAdminUrl(FreightTemplateCrudController::class, ['crudAction' => 'new']);
        $crawler = $client->request('GET', $url);

        $buttonSelector = $crawler->filter('button[type="submit"], input[type="submit"]');
        if ($buttonSelector->count() === 0) {
            static::markTestSkipped('未找到提交按钮，可能表单结构有变化');
        }

        $form = $buttonSelector->form([
            'FreightTemplate[name]' => '',
            'FreightTemplate[type]' => '',
            'FreightTemplate[price]' => '',
        ]);

        $crawler = $client->submit($form);
        $this->assertResponseStatusCodeSame(422);

        $errorElements = $crawler->filter('.invalid-feedback, .form-error-message, .error');
        $this->assertGreaterThan(0, $errorElements->count(), '应该有验证错误信息');

        $errorText = $crawler->filter('body')->text();
        $this->assertStringContainsString('不能为空', $errorText, '应该包含中文验证错误信息');
    }
}
