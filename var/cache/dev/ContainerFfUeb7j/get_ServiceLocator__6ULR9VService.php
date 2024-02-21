<?php

namespace ContainerFfUeb7j;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator__6ULR9VService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator..6ULR9V' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator..6ULR9V'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'savedJobRepository' => ['privates', 'App\\Repository\\SavedJobRepository', 'getSavedJobRepositoryService', true],
            'security' => ['privates', 'security.helper', 'getSecurity_HelperService', true],
        ], [
            'savedJobRepository' => 'App\\Repository\\SavedJobRepository',
            'security' => '?',
        ]);
    }
}