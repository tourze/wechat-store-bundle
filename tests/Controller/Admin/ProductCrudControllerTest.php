<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminControllerTestCase;
use WechatStoreBundle\Controller\Admin\ProductCrudController;
use WechatStoreBundle\Entity\Product;

/**
 * 商品管理控制器测试
 * @internal
 */
#[CoversClass(ProductCrudController::class)]
#[RunTestsInSeparateProcesses]
final class ProductCrudControllerTest extends AbstractEasyAdminControllerTestCase
{
    private ProductCrudController $controller;

    protected function afterEasyAdminSetUp(): void
    {
        $this->controller = new ProductCrudController();
    }

    protected function getControllerService(): ProductCrudController
    {
        return self::getService(ProductCrudController::class);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideIndexPageHeaders(): iterable
    {
        yield 'ID' => ['ID'];
        yield 'Name' => ['商品名称'];
        yield 'Description' => ['商品描述'];
        yield 'Price' => ['价格'];
        yield 'Category' => ['分类'];
        yield 'Stock' => ['库存数量'];
        yield 'Status' => ['状态'];
        yield 'Created Time' => ['创建时间'];
        yield 'Update Time' => ['更新时间'];
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideNewPageFields(): iterable
    {
        yield 'name' => ['name'];
        yield 'description' => ['description'];
        yield 'price' => ['price'];
        yield 'category' => ['category'];
        yield 'status' => ['status'];
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideEditPageFields(): iterable
    {
        yield 'name' => ['name'];
        yield 'description' => ['description'];
        yield 'price' => ['price'];
        yield 'category' => ['category'];
        yield 'status' => ['status'];
    }

    public function testEntityFqcn(): void
    {
        $this->assertSame(Product::class, ProductCrudController::getEntityFqcn());
    }

    public function testControllerConfiguration(): void
    {
        $this->assertInstanceOf(ProductCrudController::class, $this->controller);
        $this->assertSame(Product::class, $this->controller::getEntityFqcn());
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
        $invalidFeedbacks = $crawler->filter('.invalid-feedback, .form-error-message, .error');
        $this->assertGreaterThan(0, $invalidFeedbacks->count(), '应该有验证错误信息');

        // 验证至少包含 name 字段的必填错误
        $errorText = $invalidFeedbacks->text();
        $this->assertStringContainsString('商品名称不能为空', $errorText, 'name字段应该有必填验证错误');
    }
}
