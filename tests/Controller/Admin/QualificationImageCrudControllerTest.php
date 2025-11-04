<?php

declare(strict_types=1);

namespace WechatStoreBundle\Tests\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminControllerTestCase;
use WechatStoreBundle\Controller\Admin\QualificationImageCrudController;
use WechatStoreBundle\Entity\QualificationImage;

/**
 * 资质形象管理控制器测试
 * @internal
 */
#[CoversClass(QualificationImageCrudController::class)]
#[RunTestsInSeparateProcesses]
final class QualificationImageCrudControllerTest extends AbstractEasyAdminControllerTestCase
{
    private QualificationImageCrudController $controller;

    protected function onAfterSetUp(): void
    {
        $this->controller = new QualificationImageCrudController();
    }

    protected function getControllerService(): QualificationImageCrudController
    {
        return self::getService(QualificationImageCrudController::class);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideIndexPageHeaders(): iterable
    {
        yield 'ID' => ['ID'];
        yield 'Title' => ['标题'];
        yield 'Image Path' => ['图片路径'];
        yield 'Sort Order' => ['排序'];
        yield 'Status' => ['状态'];
        yield 'Created Time' => ['创建时间'];
        yield 'Updated Time' => ['更新时间'];
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideNewPageFields(): iterable
    {
        yield 'title' => ['title'];
        yield 'imagePath' => ['imagePath'];
        yield 'sortOrder' => ['sortOrder'];
        yield 'status' => ['status'];
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideEditPageFields(): iterable
    {
        yield 'title' => ['title'];
        yield 'imagePath' => ['imagePath'];
        yield 'sortOrder' => ['sortOrder'];
        yield 'status' => ['status'];
    }

    public function testEntityFqcn(): void
    {
        $this->assertSame(QualificationImage::class, QualificationImageCrudController::getEntityFqcn());
    }

    public function testControllerConfiguration(): void
    {
        $this->assertInstanceOf(QualificationImageCrudController::class, $this->controller);
        $this->assertSame(QualificationImage::class, $this->controller::getEntityFqcn());
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
        $url = $this->generateAdminUrl(QualificationImageCrudController::class, ['crudAction' => 'new']);
        $crawler = $client->request('GET', $url);

        $buttonSelector = $crawler->filter('button[type="submit"], input[type="submit"]');
        if ($buttonSelector->count() === 0) {
            static::markTestSkipped('未找到提交按钮，可能表单结构有变化');
        }

        $form = $buttonSelector->form([
            'QualificationImage[title]' => '',
            'QualificationImage[imagePath]' => '',
        ]);

        $crawler = $client->submit($form);
        $this->assertResponseStatusCodeSame(422);

        $errorElements = $crawler->filter('.invalid-feedback, .form-error-message, .error');
        $this->assertGreaterThan(0, $errorElements->count(), '应该有验证错误信息');
    }
}
