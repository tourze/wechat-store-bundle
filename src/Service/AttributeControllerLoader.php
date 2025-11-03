<?php

namespace WechatStoreBundle\Service;

use Symfony\Bundle\FrameworkBundle\Routing\AttributeRouteControllerLoader;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Routing\RouteCollection;
use Tourze\RoutingAutoLoaderBundle\Service\RoutingAutoLoaderInterface;
use WechatStoreBundle\Controller\Admin\CategoryCrudController;
use WechatStoreBundle\Controller\Admin\FreightTemplateCrudController;
use WechatStoreBundle\Controller\Admin\ProductCrudController;
use WechatStoreBundle\Controller\Admin\QualificationImageCrudController;
use WechatStoreBundle\Controller\Admin\ServerMessageCrudController;
use WechatStoreBundle\Controller\ServerController;

#[AutoconfigureTag(name: 'routing.loader')]
#[Autoconfigure(public: true)]
class AttributeControllerLoader extends Loader implements RoutingAutoLoaderInterface
{
    private AttributeRouteControllerLoader $controllerLoader;

    public function __construct()
    {
        parent::__construct();
        $this->controllerLoader = new AttributeRouteControllerLoader();
    }

    public function load(mixed $resource, ?string $type = null): RouteCollection
    {
        return $this->autoload();
    }

    public function supports(mixed $resource, ?string $type = null): bool
    {
        return false;
    }

    public function autoload(): RouteCollection
    {
        $collection = new RouteCollection();
        $collection->addCollection($this->controllerLoader->load(ServerController::class));
        $collection->addCollection($this->controllerLoader->load(CategoryCrudController::class));
        $collection->addCollection($this->controllerLoader->load(FreightTemplateCrudController::class));
        $collection->addCollection($this->controllerLoader->load(ProductCrudController::class));
        $collection->addCollection($this->controllerLoader->load(QualificationImageCrudController::class));
        $collection->addCollection($this->controllerLoader->load(ServerMessageCrudController::class));

        return $collection;
    }
}
