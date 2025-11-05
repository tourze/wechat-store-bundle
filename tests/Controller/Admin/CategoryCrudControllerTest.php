<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminControllerTestCase;
use WechatStoreBundle\Controller\Admin\CategoryCrudController;
use WechatStoreBundle\Entity\Category;

/**
 * 商品类别管理控制器测试
 * CategoryCrudController 禁用了 NEW、EDIT、DELETE 操作，只支持只读操作
 * 因此不需要验证测试（testValidationErrors）
 * @internal
 * @phpstan-ignore-next-line missingValidationTest
 */
#[CoversClass(CategoryCrudController::class)]
#[RunTestsInSeparateProcesses]
final class CategoryCrudControllerTest extends AbstractEasyAdminControllerTestCase
{
    private CategoryCrudController $controller;

    protected function afterEasyAdminSetUp(): void
    {
        $this->controller = new CategoryCrudController();
    }

    public function testEntityFqcn(): void
    {
        $this->assertSame(Category::class, CategoryCrudController::getEntityFqcn());
    }

    public function testControllerConfiguration(): void
    {
        $this->assertInstanceOf(CategoryCrudController::class, $this->controller);
        $this->assertSame(Category::class, $this->controller::getEntityFqcn());
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

    public function testActionsConfiguration(): void
    {
        $actions = $this->controller->configureActions(Actions::new());
        $this->assertInstanceOf(Actions::class, $actions);
    }

    public function testFieldsConfiguration(): void
    {
        $fields = iterator_to_array($this->controller->configureFields('index'));
        $this->assertNotEmpty($fields);
    }

    protected function getControllerService(): CategoryCrudController
    {
        return self::getService(CategoryCrudController::class);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideIndexPageHeaders(): iterable
    {
        yield 'id_header' => ['ID'];
        yield 'name_header' => ['分类名称'];
        yield 'sort_header' => ['排序'];
        yield 'status_header' => ['状态'];
        yield 'create_time_header' => ['创建时间'];
        yield 'update_time_header' => ['更新时间'];
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideNewPageFields(): iterable
    {
        // CategoryCrudController 禁用了 NEW 操作，但PHPUnit要求至少一个测试数据
        // 实际测试会抛出ForbiddenActionException，这是预期行为
        yield 'dummy' => ['id'];
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideEditPageFields(): iterable
    {
        // CategoryCrudController 禁用了 EDIT 操作，但PHPUnit要求至少一个测试数据
        // 实际测试会抛出ForbiddenActionException，这是预期行为
        yield 'dummy' => ['id'];
    }
}
